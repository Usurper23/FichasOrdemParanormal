<?php
session_start();

require_once "config.php";
$con = con();

function asleep($time = 1){
    usleep($time * 1000000);
}
function calcularvida($nex,$classe,$vigor){
    $vigor = max($vigor,0);
    switch ($classe){
        default:
            $pv = ((5+$vigor)*(floor(($nex/5))-1))+(20+$vigor);
            break;
        case 2:
            $pv = ((4+$vigor)*(floor(($nex/5))-1))+(16+$vigor);
            break;
        case 3:
            $pv = ((3+$vigor)*(floor(($nex/5))-1))+(12+$vigor);
            break;
    }
    return $pv;
}
function calcularpe($nex,$classe,$presenca) :int
{
    $presenca = max($presenca, 0);
    switch ($classe){
        default:
            $pe = (3 + $presenca) + ((1+$presenca) * (floor(($nex/5))-1));
            break;
        case 2:
            $pe = (4 + $presenca) + ((2+$presenca) * (floor(($nex/5))-1));
            break;
        case 3:
            $pe = (6 + $presenca) + ((3+$presenca) * (floor(($nex/5))-1));
            break;
    }
    return $pe;
}
function calcularesq($passiva,$reflexos){
    if($reflexos > 0) {
        return ($passiva + $reflexos);
    } else {
        return 0;
    }
}
function calcularblo($passiva,$luta){
    if ($luta > 0) {
        return ($passiva + $luta);
    } else {
        return 0;
    }
}
function minmax($int,$min=0,$max=99){
    return min(max(intval($int), $min),$max);
}
function test_input($data): string {
    return htmlspecialchars(stripslashes(trim($data)));
}
function VerificarID($id): bool
{
    $id = intval($id);
    if(isset($_SESSION["UserID"])) {
        $userid = $_SESSION["UserID"];
        if ($id > 0) {
            $con = con();
            $q = $con->prepare("Select * FROM `fichas_personagem` WHERE `id` = ? AND `usuario` = ?");
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
    $q = $con->query("Select * FROM `missoes` WHERE `mestre` = '".$id."' and `missoes`.`id` = '".$mid."'");
    if ($q->num_rows > 0){
        return true;
    }
    return false;
}
function VerificarConvite($missao): bool
{
    $missao = intval($missao);
    $con = con();
    if ($missao>0){
        $q = $con->query("SELECT * FROM ligacoes WHERE `id_missao` = '".$missao."' AND `id_usuario` = '".$_SESSION["UserID"]."' AND `id_ficha` is null;");
        if ($q->num_rows){
            return true;
        }
    }
    return false;
}
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
    $a->bind_param("s",$tokens[0]);
    $a->execute();
    $ra = $a->get_result();
    return mysqli_fetch_assoc($ra);
}
function insert_user_token(int $user_id, string $selector, string $hashed_validator, string $expiry): bool
{
    $con = con();
    $q = $con->prepare("INSERT INTO `user_tokens` (`id`, `selector`, `hashed_validator`, `user_id`, `expiry`) VALUES (NULL, ? , ? , ? , ? );");
    $q->bind_param("ssis",$selector,$hashed_validator,$user_id,$expiry);
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
function logar(string $login):bool{
    $con = con();
    $q = $con->prepare("select * from `usuarios` WHERE `login` = ?");
    $q->bind_param("s", $login);
    $q->execute();
    $rq = $q->get_result();
    if($rq->num_rows){
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
    $e = explode(':',$token);
    $selector = $e[0];
    $validator = $e[1];

    $tokens = find_user_token_by_selector($selector);
    if (!$tokens) {
        return false;
    }

    return password_verify($validator, $tokens['hashed_validator']);
}


///Login e cadasrto
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
        preg_match('/^[a-zA-Z-\'_0-9]*$/', $login);
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
            if($ab->num_rows == 0){
                $b = $con->query("SELECT * FROM `usuarios` WHERE `login` = '" . $login . "'");
                if ($b->num_rows == 0) {
                    $q = $con->prepare("INSERT INTO `usuarios`(`nome`,`login`,`senha`,`email`,`id`) VALUES (?,?,?,?,'')");
                    $q->bind_param("ssss", $nome, $login, $senha, $email);
                    $q->execute();
                    if ($q->affected_rows == 1) {
                        $success = true;
                        $msg = "Sucesso ao criar conta!";
                    } else {
                        $success = false;
                        $msg = "Falha ao criar conta!";
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
    if ($success){
        $l = $con->prepare("SELECT * FROM `usuarios` WHERE `login`=?");
        $l->bind_param("s", $login);
        $l->execute();
        $gl = $l->get_result();
        if ($gl->num_rows==1){
            $rl = mysqli_fetch_array($gl);
            $_SESSION["UserID"] = $rl["id"];
            $_SESSION["UserLogin"] = $rl["login"];
            $_SESSION["UserName"] = $rl["nome"];
            $_SESSION["UserEmail"] = $rl["email"];
            $_SESSION["UserElite"] = $rl["elite"];
            $_SESSION["UserAdmin"] = $rl["admin"];
            $_SESSION["CookieSession"] = false;
            $msg .= "; Logado automaticamente!";
        }
    }
    $data["success"] = $success;
    $data["msg"] = $msg;
    echo json_encode($data);
    exit;
}
if (isset($_POST["logar"])){
    if ($_SESSION["timeout"] < 16) {
        //$data["timeout"] = $_SESSION["timeout"];
        $success = true;
        asleep($_SESSION["timeout"]);
        if (!empty($_POST["login"])) {
            $login = test_input($_POST["login"]);
            preg_match('/^[a-zA-Z-\'_0-9]*$/', $login);
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
                if($_POST["lembrar"] == 'on' || $_POST["lembrar"] == 1){
                    remember_me($dados["id"]);
                }
            } else {
                $msg = "Usuario/Senha incorretos!";
                $success = false;

            }

        }
        $_SESSION["timeout"] *= 2;

        $_SESSION["tentativas"] += 1;
        $tentativas = 4 - $_SESSION["tentativas"];



        $data['timeout'] = $_SESSION["timeout"];
        $data["tentativas"] = $_SESSION["tentativas"];
        $data["success"] = $success;
        $data["msg"] = $msg.($success?"":" (Tentativas restantes: $tentativas.)");
        echo json_encode($data);
        exit;
    } else {
        $data["success"] = false;
        $data["msg"] = "Muitas tentativas foram feitas, tente mais tarde...";
        echo json_encode($data);
        exit;
    }

}


if (isset($_POST["update"])){
    $success = true;
    $msg="";
    switch($_POST["update"]) {
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
            if($success){
                if(isset($_SESSION["UserID"])) {
                    $v = $con->query("SELECT * FROM `usuarios` WHERE `email` = '".$email."';");
                    if(!$v->num_rows) {
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
            break;
        case 'login':
            if (empty($_POST["login"])) {
                $msg = "Preencha todos os campos!";
                $success = false;
            } else {
                $login = test_input($_POST["login"]);
                preg_match('/^[a-zA-Z-\'_0-9]*$/', $login);
                if (isset($_SESSION["UserID"])) {
                    $v = $con->query("SELECT * FROM `usuarios` WHERE `login` = '".$login."';");
                    if(!$v->num_rows) {
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
                        $msg = "Login já existente;".$v->num_rows;
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
                    if(isset($_SESSION["UserID"])) {
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