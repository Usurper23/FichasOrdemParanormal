<?php
session_start();

require_once "config.php";
$con = con();

function asleep($time = 1)
{
    usleep($time * 1000000);
}

$_SESSION["timeout"]=$_SESSION["timeout"]?:0;


function ClearRolar($dado, $Return_Error = false)
{
    $success = true;

    if (!empty($dado)) {
        if (preg_match('/^[d0-9+-]+\S$/', $dado)) {
            if ($success) {
                $dado = str_replace("-", "+-", $dado);
                $a = explode('+', $dado);
                foreach ($a as $dados):
                    if ($success) {
                        if (!empty($dados)) {
                            $b = explode('d', $dados);
                            $b[0] = intval($b[0]);
                            if (($b[0] > 10 || $b[0] < -10) and isset($b[1])) {
                                $success = false;
                                $msg = "Não pode rolar mais de 10 dados de uma vez.";
                            }
                            if (($b[0] > 30 || $b[0] < -30) and !isset($b[1])) {
                                $success = false;
                                $msg = "Não pode somar além de 30 absolutamente.";
                            }
                            if ($b[1] > 100) {
                                $success = false;
                                $msg = "Não pode rolar dados com mais de 100 Lados.";
                            }
                        }
                    }
                endforeach;
            }
        } else {
            $success = false;
            $msg = "Preencha o campo de forma devida!";
        }
    } else {
        $success = false;
        $msg = "Preencha o campo!";
    }
    $data["success"] = $success;
    $data["msg"] = $msg;
    if ($Return_Error) {
        return $data;
    } else {
        return $success;
    }
}

function Rolar($dado, $dano = false): array
{
    $result = [];
    $dado = str_replace("-", "+-", $dado);
    $a = explode('+', $dado);
    foreach ($a as $nome => $dados) {
        if (!empty($dados)) {
            $b = explode('d', $dados);
            $b[0] = intval($b[0]);
            if ($b[0] == 0 and isset($b[1])) {
                $b[0] = 1;
            } else
                if ($b[0] < 0 and isset($b[1])) {
                    $b[0] = abs($b[0]);
                    $negative = true;
                }
            if (!empty($b[1])) {
                $roll = $b[0];
                $rice = $b[1];
                if (!$dano) {
                    while ($result["d" . $nome]["TotalRolls"] != $roll) {
                        $result["d" . $nome]["TotalRolls"] += 1;
                        $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]] = rand(1, $rice);
                    }
                    $result["d" . $nome]["dado"] = "d" . $rice;
                    $result["d" . $nome]["bestroll"] = max($result["d" . $nome]["d" . $rice]);
                    $result["d" . $nome]["worstroll"] = min($result["d" . $nome]["d" . $rice]);
                    if ($negative) {
                        $result["result"] += $result["d" . $nome]["worstroll"];
                        $result["print"] .= "+" . $result["d" . $nome]["worstroll"];
                        $result["d" . $nome]["result"] += $result["d" . $nome]["worstroll"];
                    } else {
                        $result["result"] += $result["d" . $nome]["bestroll"];
                        $result["print"] .= "+" . $result["d" . $nome]["bestroll"];
                        $result["d" . $nome]["result"] += $result["d" . $nome]["bestroll"];
                    }
                } else {
                    while ($result["d" . $nome]["TotalRolls"] != $roll) {
                        $result["d" . $nome]["TotalRolls"] += 1;
                        $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]] = rand(1, $rice);
                        $result["result"] += $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
                        $result["print"] .= "+" . $result["d" . $nome]["d" . $rice]["d" . $result["d" . $nome]["TotalRolls"]];
                    }
                    $result["d" . $nome]["dado"] = "d" . $rice;
                }
            } else {
                if ($b[0] > 0) {
                    $b[0] = '+' . $b[0];
                }
                $result["result"] += $b[0];
                $result["print"] .= $b[0];
                $result["soma"] = $b[0];
            }
        }
    }
    return ($result);
}

function ValorParaMostrarNoAtributo($Atributo)
{
    if ($Atributo > 0) {
        return ("+" . $Atributo);
    } else {
        return $Atributo;
    }
}

function ValorParaRolarDado($Atributo)
{
    if ($Atributo >= 0) {
        return ($Atributo + 1);
    } else {
        return ((abs($Atributo) + 1) * -1);
    }
}

function TirarPorcento($Valor_Atual, $Valor_Maximo)
{
    return minmax((($Valor_Atual / $Valor_Maximo) * 100), 0, 100);
}

function evalAsMath($str)
{

    $error = false;
    $div_mul = false;
    $add_sub = false;
    $result = 0;

    $str = preg_replace('/[^\d\.\+\-\*\/]/i', '', $str);
    $str = rtrim(trim($str, '/*+'), '-');

    if ((strpos($str, '/') !== false || strpos($str, '*') !== false)) {
        $div_mul = true;
        $operators = array('*', '/');
        while (!$error && $operators) {
            $operator = array_pop($operators);
            while ($operator && strpos($str, $operator) !== false) {
                if ($error) {
                    break;
                }
                $regex = '/([\d\.]+)\\' . $operator . '(\-?[\d\.]+)/';
                preg_match($regex, $str, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    if ($operator == '+') $result = (float)$matches[1] + (float)$matches[2];
                    if ($operator == '-') $result = (float)$matches[1] - (float)$matches[2];
                    if ($operator == '*') $result = (float)$matches[1] * (float)$matches[2];
                    if ($operator == '/') {
                        if ((float)$matches[2]) {
                            $result = (float)$matches[1] / (float)$matches[2];
                        } else {
                            $error = true;
                        }
                    }
                    $str = preg_replace($regex, $result, $str, 1);
                    $str = str_replace(array('++', '--', '-+', '+-'), array('+', '+', '-', '-'), $str);
                } else {
                    $error = true;
                }
            }
        }
    }

    if (!$error && (strpos($str, '+') !== false || strpos($str, '-') !== false)) {
        $add_sub = true;
        preg_match_all('/([\d\.]+|[\+\-])/', $str, $matches);
        if (isset($matches[0])) {
            $result = 0;
            $operator = '+';
            $tokens = $matches[0];
            $count = count($tokens);
            for ($i = 0; $i < $count; $i++) {
                if ($tokens[$i] == '+' || $tokens[$i] == '-') {
                    $operator = $tokens[$i];
                } else {
                    $result = ($operator == '+') ? ($result + (float)$tokens[$i]) : ($result - (float)$tokens[$i]);
                }
            }
        }
    }

    if (!$error && !$div_mul && !$add_sub) {
        $result = (float)$str;
    }

    return $error ? 0 : $result;
}

function DadoDinamico($dado, $FOR, $AGI, $INT, $PRE, $VIG): string
{
    $tese = [];
    if($FOR <= 0 || $FOR > 10){
        $FOR = 0;
    }
    if($AGI <= 0 || $AGI > 10){
        $AGI = 0;
    }
    if($INT <= 0 || $INT > 10){
        $INT = 0;
    }
    if($PRE <= 0 || $PRE > 10){
        $PRE = 0;
    }
    if($VIG <= 0 || $VIG > 10){
        $VIG = 0;
    }
    $dado = explode("+", $dado);
    foreach ($dado as $n => $s):
        if (strpos($s, "|") !== false) {
            $s = str_replace("FOR", $FOR, $s);
            $s = str_replace("AGI", $AGI, $s);
            $s = str_replace("INT", $INT, $s);
            $s = str_replace("PRE", $PRE, $s);
            $s = str_replace("VIG", $VIG, $s);
            $s = str_replace("|", '', $s);
            $s = evalAsMath($s);
        }
        $tese[] .= $s;
    endforeach;
    return implode('+', $tese);
}

function calcularvida($nex, $classe, $vigor)
{
    $vigor = max($vigor, 0);
    switch ($classe) {
        default:
            $pv = ((5 + $vigor) * (floor(($nex / 5)) - 1)) + (20 + $vigor);
            break;
        case 2:
            $pv = ((4 + $vigor) * (floor(($nex / 5)) - 1)) + (16 + $vigor);
            break;
        case 3:
            $pv = ((3 + $vigor) * (floor(($nex / 5)) - 1)) + (12 + $vigor);
            break;
    }
    return $pv;
}

function calcularpe($nex, $classe, $presenca): int
{
    $presenca = max($presenca, 0);
    switch ($classe) {
        default:
            $pe = (3 + $presenca) + ((1 + $presenca) * (floor(($nex / 5)) - 1));
            break;
        case 2:
            $pe = (4 + $presenca) + ((2 + $presenca) * (floor(($nex / 5)) - 1));
            break;
        case 3:
            $pe = (6 + $presenca) + ((3 + $presenca) * (floor(($nex / 5)) - 1));
            break;
    }
    return $pe;
}

function calcularesq($passiva, $reflexos)
{
    if ($reflexos > 0) {
        return ($passiva + $reflexos);
    } else {
        return 0;
    }
}

function calcularblo($passiva, $luta)
{
    if ($luta > 0) {
        return ($passiva + $luta);
    } else {
        return 0;
    }
}

function minmax($int, $min = 0, $max = 99)
{
    return min(max(intval($int), $min), $max);
}

function test_input($data): string
{
    return htmlspecialchars(stripslashes(trim($data)));
}

function VerificarID($id): bool
{
    $id = intval($id);
    if (isset($_SESSION["UserID"])) {
        $userid = $_SESSION["UserID"];
        if ($id > 0) {
            $con = con();
            $q = $con->prepare("Select * FROM `fichas_personagem` WHERE `id` = ? AND `usuario` = ? ;");
            $q->bind_param("ii", $id, $userid);
            $q->execute();
            $rq = $q->get_result();
            $a = $con->prepare("Select * FROM `ligacoes` WHERE `id` = ? AND `id_usuario` = ?");
            $a->bind_param("ii", $id, $userid);
            $a->execute();
            $aq = $a->get_result();
            if ($rq->num_rows > 0 || $aq->num_rows > 0) {
                return true;
            }
        }
    }
    return false;
}

function VerificarMestre($mid): bool
{
    $id = $_SESSION["UserID"];
    $con = con();
    $q = $con->query("Select * FROM `missoes` WHERE `mestre` = '" . $id . "' and `id` = '" . $mid . "';");
    if ($q->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
/* UNUSED
function VerificarConvite($missao): bool
{
    $missao = intval($missao);
    $con = con();
    if ($missao > 0) {
        $q = $con->query("SELECT * FROM ligacoes WHERE `id_missao` = '" . $missao . "' AND `id_usuario` = '" . $_SESSION["UserID"] . "' AND `id_ficha` is null;");
        if ($q->num_rows) {
            return true;
        }
    }
    return false;
}
*/
function generate_tokens(): array
{
    $selector = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));
    return [$selector, $validator, $selector . ':' . $validator];
}

function parse_token(string $token): ?array
{
    $parts = explode(':', $token);

    if ($parts && count($parts) == 2) {
        return [$parts[0], $parts[1]];
    }
    return null;
}

function find_user_token_by_selector(string $selector)
{
    $con = con();
    $a = $con->prepare("SELECT id, selector, hashed_validator, user_id, expiry FROM user_tokens WHERE selector = ? AND expiry >= now() LIMIT 1;");
    $a->bind_param("s", $selector);
    $a->execute();
    $ra = $a->get_result();
    return mysqli_fetch_assoc($ra);
}

function delete_user_token(int $user_id): bool
{
    $con = con();
    $q = $con->prepare("DELETE FROM user_tokens WHERE user_id = ?");
    $q->bind_param("i", $user_id);
    return $q->execute();
}

function find_user_by_token(string $token)
{
    $tokens = parse_token($token);

    if (!$tokens) {
        return null;
    }
    $con = con();
    $a = $con->prepare('SELECT usuarios.id, login
            FROM usuarios
            INNER JOIN user_tokens ON user_id = usuarios.id
            WHERE selector = ? AND
                expiry > now()
            LIMIT 1');
    $a->bind_param("s", $tokens[0]);
    $a->execute();
    $ra = $a->get_result();
    return mysqli_fetch_assoc($ra);
}

function insert_user_token(int $user_id, string $selector, string $hashed_validator, string $expiry): bool
{
    $con = con();
    $q = $con->prepare("INSERT INTO `user_tokens` (`id`, `selector`, `hashed_validator`, `user_id`, `expiry`) VALUES ('', ? , ? , ? , ? );");
    $q->bind_param("ssis", $selector, $hashed_validator, $user_id, $expiry);
    return $q->execute();
}

function remember_me(int $user_id, int $day = 5)
{
    [$selector, $validator, $token] = generate_tokens();

    // remove all existing token associated with the user id
    delete_user_token($user_id);

    // set expiration date
    $expired_seconds = time() + 60 * 60 * 24 * $day;

    // insert a token to the database
    $hash_validator = password_hash($validator, PASSWORD_DEFAULT);
    $expiry = date('Y-m-d H:i:s', $expired_seconds);
    if (insert_user_token($user_id, $selector, $hash_validator, $expiry)) {
        setcookie('remember_me', $token, $expired_seconds);
    }
}

function logout(): void
{
    if (is_user_logged_in()) {

        // delete the user token
        delete_user_token($_SESSION['UserID']);

        // delete session
        unset($_SESSION['username'], $_SESSION['user_id`']);

        // remove the remember_me cookie
        if (isset($_COOKIE['remember_me'])) {
            unset($_COOKIE['remember_me']);
            setcookie('remember_user', null, -1);
        }

        // remove all session data
        session_unset();
        session_destroy();

        // redirect to the login page
    }
}

function is_user_logged_in(): bool
{
    // check the session
    if (isset($_SESSION['UserLogin'])) {
        return true;
    }

    // check the remember_me in cookie
    $token = filter_input(INPUT_COOKIE, 'remember_me', FILTER_SANITIZE_STRING);

    if ($token && token_is_valid($token)) {

        $user = find_user_by_token($token);

        if ($user) {
            return logar($user['login']);
        }
    }
    return false;
}
function logar(string $login): bool
{
    $con = con();
    $q = $con->prepare("select * from `usuarios` WHERE `login` = ?");
    $q->bind_param("s", $login);
    $q->execute();
    $rq = $q->get_result();
    if ($rq->num_rows) {
        $dados = mysqli_fetch_array($rq);
        $_SESSION["UserID"] = $dados["id"];
        $_SESSION["UserLogin"] = $dados["login"];
        $_SESSION["UserName"] = $dados["nome"];
        $_SESSION["UserEmail"] = $dados["email"];
        $_SESSION["UserElite"] = $dados["elite"];
        $_SESSION["UserAdmin"] = $dados["admin"];
        $_SESSION["CookieSession"] = false;
        return true;
    } else {
        return false;
    }
}

function token_is_valid($token): bool
{
    $e = explode(':', $token);
    $selector = $e[0];
    $validator = $e[1];

    $tokens = find_user_token_by_selector($selector);
    if (!$tokens) {
        return false;
    }

    return password_verify($validator, $tokens['hashed_validator']);
}


///Login e cadasrto
$email = '';
$login = '';
$msg = '';

if (isset($_POST["cadastrar"])) {
    $success = true;
    if (!empty($_POST["nome"])) {
        $nome = test_input($_POST["nome"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
            $msg = "Apenas Letras e Espaços são permitidos no nome!";
            $success = false;
        }
    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }

    if (!empty($_POST["login"])) {
        $login = test_input($_POST["login"]);
        preg_match('/^[a-zA-Z-\'_\d]*$/', $login);
    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }

    if (!empty($_POST["email"])) {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Email inserido não é valido.";
            $success = false;
        }
    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }

    if (!empty($_POST["senha"] || $_POST["csenha"])) {
        if ($_POST["senha"] === $_POST["csenha"]) {
            $pass = $_POST["senha"];

            if (strlen($pass) < 8 || strlen($pass) > 50) {
                $msg = "Senha deve conter entre 8 e 50 digitos.";
                $success = false;
            }
            if (!preg_match("/[A-Z]/", $pass)) {
                $msg = "Senha precisa conter letras maiúsculas.";
                $success = false;
            }
            if (!preg_match("/[a-z]/", $pass)) {
                $msg = "Senha precisa conter letras minúsculas.";
                $success = false;
            }
            if (preg_match("/\s/", $pass)) {
                $msg = "Senha não pode conter espaços!";
                $success = false;
            }
            $senha = md5(md5($pass));

        } else {
            $msg = "As Senhas não Coincidem";
            $success = false;
        }

    } else {
        $success = false;
        $msg = "Preencha todos os campos!";
    }
    if ($success) {
        $a = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "' AND `status` = 1");
        $ab = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "' AND `status` = 0");
        if ($a->num_rows == 0) {
            if ($ab->num_rows == 0) {
                $b = $con->query("SELECT * FROM `usuarios` WHERE `login` = '" . $login . "'");
                if ($b->num_rows == 0) {
                    $q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`id`) VALUES (?,?,?,?,'')");
                    $q->bind_param("ssss", $nome, $login, $senha, $email);
                    $q->execute();
                    if ($con->affected_rows > 0) {
                        $success = true;
                        $msg = "Sucesso ao criar conta!";
                    } else {
                        $success = false;
                        $msg = "Falha ao criar conta!".$q->affected_rows.$con->affected_rows;
                    }
                } else {
                    $success = false;
                    $msg = "Login já usado!";
                }
            } else {
                $q = $con->prepare("UPDATE `usuarios` SET `nome` = ? ,`login` = ?,`senha` = ? , `status` = 1 WHERE `email` = ? ");
                $q->bind_param("ssss", $nome, $login, $senha, $email);
                $q->execute();
                if ($q->affected_rows == 1) {
                    $success = true;
                    $msg = "Sucesso ao criar conta!";
                } else {
                    $success = false;
                    $msg = "Falha ao criar conta!";
                }
            }
        } else {
            $success = false;
            $msg = "Email já usado!";
        }
    }
    if(logar($login)):$msg.=' (Logado Automaticamente)';endif;
    $data["success"] = $success;
    $data["msg"] = $msg;
    echo json_encode($data);
    exit;
}
if (isset($_POST["logar"])) {
    $success = true;
    if (!isset($_SESSION["timeout"]) || $_SESSION["timeout"] <= 5) {
        asleep($_SESSION["timeout"]*4);
        if (!empty($_POST["login"])) {
            $login = test_input($_POST["login"]);
            preg_match('/^[a-zA-Z-\'_\d]*$/', $login);
        } else {
            $success = false;
            $msg = "Preencha todos os campos!";
        }
        if (!empty($_POST["senha"])) {
            $pass = test_input($_POST["senha"]);
            $senha = cryptthis($pass);
        } else {
            $success = false;
            $msg = "Preencha todos os campos!";
        }
        if ($success) {
            $q = $con->prepare("select * from `usuarios` WHERE `login` = ? and `senha` = ?");
            $q->bind_param("ss", $login, $senha);
            $q->execute();
            $rq = $q->get_result();
            if ($rq->num_rows == 1) {
                $dados = mysqli_fetch_array($rq);
                logar($login);
                $msg = "Sucesso ao fazer login!";
                $success = true;
                if (isset($_POST["lembrar"]) && ($_POST["lembrar"] == 'on' || $_POST["lembrar"] == 1)) {
                    remember_me($dados["id"]);
                }
            } else {
                $msg = "Usuario/Senha incorretos!";
                $success = false;
            }

        }
        $_SESSION["timeout"] += 1;
        $data["tentativas"] = 5 - $_SESSION["timeout"];
        $data["success"] = $success;
        $data["msg"] = $msg . ($success ? "" : " (Tentativas restantes: ".$data["tentativas"].".)");
    } else {
        $data["success"] = false;
        $data["msg"] = "Muitas tentativas foram feitas, tente mais tarde...";
    }
    echo json_encode($data);
    exit;

}


if (isset($_POST["update"])) {
    $success = true;
    switch ($_POST["update"]) {
        default:
            $data["success"] = false;
            $data["msg"] = "Houve uma falha, contate um administrador";
            break;
        case 'email':
            if (!empty($_POST["email"])) {
                if ($_POST["email"] === $_POST["conemail"]) {
                    $email = test_input($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $msg = "Email inserido não é valido.";
                        $success = false;
                    }
                } else {
                    $success = false;
                    $msg = "Os dois emails não são iguais";
                }
            } else {
                $success = false;
                $msg = "Preencha todos os campos!";
            }
            if ($success) {
                if (isset($_SESSION["UserID"])) {
                    $v = $con->query("SELECT * FROM `usuarios` WHERE `email` = '" . $email . "';");
                    if (!$v->num_rows) {
                        $q = $con->prepare("UPDATE `usuarios` SET `email`= ? WHERE `id`=?");
                        $q->bind_param("si", $email, $_SESSION["UserID"]);
                        $q->execute();
                        if ($con->affected_rows) {
                            $msg = "Alterado com sucesso.";
                            $_SESSION["UserEmail"] = $email;
                        } else {
                            $msg = "Falha ao alterar, atualize a pagina.";
                            $success = false;
                        }
                    } else {
                        $msg = "Email Já existente no banco de dados.";
                        $success = false;
                    }
                } else {
                    $msg = "Sua sessão encerrou, faça login novamente!";
                    $success = false;
                }
            }
            break;
        case 'senha':
            if (!empty($_POST["senha"] || $_POST["consenha"])) {
                if ($_POST["senha"] === $_POST["consenha"]) {
                    $pass = $_POST["senha"];
                    if (strlen($pass) < 8 || strlen($pass) > 50) {
                        $msg = "Senha deve conter entre 8 e 50 digitos. ";
                        $success = false;
                    }
                    if (!preg_match("/[A-Z]/", $pass)) {
                        $msg .= "Senha precisa conter letras maiúsculas. ";
                        $success = false;
                    }
                    if (!preg_match("/[a-z]/", $pass)) {
                        $msg .= "Senha precisa conter letras minúsculas. ";
                        $success = false;
                    }
                    if (preg_match("/\s/", $pass)) {
                        $msg .= "Senha não pode conter espaços! ";
                        $success = false;
                    }
                    $senha = cryptthis($pass);

                } else {
                    $msg = "As Senhas não Coincidem";
                    $success = false;
                }

            } else {
                $success = false;
                $msg = "Preencha todos os campos!";
            }
            if ($success) {
                if (isset($_SESSION["UserID"])) {
                    $q = $con->prepare("UPDATE `usuarios` SET `senha`= ? WHERE `id`=?");
                    $q->bind_param("si", $senha, $_SESSION["UserID"]);
                    $q->execute();
                    if ($con->affected_rows) {
                        $msg = "Alterado com sucesso.";
                    } else {
                        $msg = "Falha ao alterar, atualize a pagina.";
                        $success = false;
                    }
                } else {
                    $msg = "Sua sessão encerrou, faça login novamente!";
                    $success = false;
                }
            }
            break;
        case 'login':
            if (empty($_POST["login"])) {
                $msg = "Preencha todos os campos!";
                $success = false;
            } else {
                $login = test_input($_POST["login"]);
                preg_match('/^[a-zA-Z-\'_\d]*$/', $login);
                if (isset($_SESSION["UserID"])) {
                    $v = $con->query("SELECT * FROM `usuarios` WHERE `login` = '" . $login . "';");
                    if (!$v->num_rows) {
                        $q = $con->prepare("UPDATE `usuarios` SET `login`= ? WHERE `id`=?");
                        $q->bind_param("si", $login, $_SESSION["UserID"]);
                        $q->execute();
                        if ($con->affected_rows) {
                            $msg = "Alterado com sucesso.";
                            $_SESSION["UserLogin"] = $login;
                        } else {
                            $msg = "Falha ao alterar, atualize a pagina.";
                            $success = false;
                        }
                    } else {
                        $msg = "Login já existente;" . $v->num_rows;
                        $success = false;
                    }
                } else {
                    $msg = "Sua sessão encerrou, faça login novamente!";
                    $success = false;
                }
            }
            break;
        case 'nome':
            if (empty($_POST["nome"])) {
                $msg = "Preencha todos os campos!";
                $success = false;
            } else {
                $nome = test_input($_POST["nome"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $nome)) {
                    $msg = "Apenas Letras e Espaços são permitidos no nome!";
                    $success = false;
                } else {
                    if (isset($_SESSION["UserID"])) {
                        $q = $con->prepare("UPDATE `usuarios` SET `nome`= ? WHERE `id`=?");
                        $q->bind_param("si", $nome, $_SESSION["UserID"]);
                        $q->execute();
                        if ($con->affected_rows) {
                            $msg = "Alterado com sucesso.";
                            $_SESSION["UserName"] = $nome;
                        } else {
                            $msg = "Falha ao alterar, atualize a pagina.";
                            $success = false;
                        }
                    } else {
                        $msg = "Sua sessão encerrou, faça login novamente!";
                        $success = false;
                    }
                }
            }
            break;
    }
    $data["msg"] = $msg;
    $data["success"] = $success;
    echo json_encode($data);
    header("Refresh:3");
    exit;
}