<?php

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
} //Inicia a sessão

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
    if(logar($login)) $msg .= ' (Logado Automaticamente)';
    $data["success"] = $success;
    $data["msg"] = $msg;
    echo json_encode($data);
    exit; //Necessario para funcionar no jquery
} //Verificação dos dados

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
            if ($rq->num_rows == 1) { //Verifica se existe essa conta e se a senha coincide com ela
                $dados = mysqli_fetch_array($rq);
                logar($login);
                $msg = "Sucesso ao fazer login!";
                $success = true;
                if (isset($_POST["lembrar"]) && ($_POST["lembrar"] == 'on' || $_POST["lembrar"] == 1)) {
                    remember_me($dados["id"]); // Quando a opção lembrar-me está marcada
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

} // Verificação dos dados