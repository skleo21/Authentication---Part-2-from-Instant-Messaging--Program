
<?php
//Ligar à bd
require("connectdb.php");
session_start();

//Operação de Registo
if (isset($_POST["register_btn"])){
    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"]) && isset($_POST["contact"])) {

        $newuserquery = $db->prepare("INSERT INTO `User`(`username`,`pass`,`email`,`contact`) VALUES (?,?,?,?)");

        $newuserquery->bind_param("ssss", $user, $pass, $email, $contact);

        if ($_POST["password"] == $_POST["confirm_password"]) {

            $user = $_POST["username"];
            $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = $_POST["email"];
            $contact = $_POST["contact"];
            

            $result = $newuserquery->execute();

            if ($result) {
                echo "<script>alert('Registo com sucesso');</script>";
                return;
            } else {
                echo "<script>alert('O registo falhou');</script>";
                return;
            }
        } else {
            echo "<script>alert('Password mismatch');</script>";
            return;
        }
    }
}

//Operação de Login
if (isset($_POST["login_btn"])){
    //Verificação se os campos username e pass foram realmente enviados
    if (isset($_POST["username"]) && isset($_POST["password"])) {   

        $verifyuser = $db->prepare("SELECT * FROM `User` WHERE username=? OR email=?;");

        $verifyuser->bind_param("ss", $_POST["username"], $_POST["username"]);

        $result = $verifyuser->execute();

        if (!$result) {
            echo "ERROR: Trying to verify user";
            return;
        }

        $user = $verifyuser->get_result();
        if (!$user) {
            echo "ERROR: Trying to get result from db";
            return;
        }

        $user = $user->fetch_assoc();

        if (isset($user) && sizeof($user) > 0) {
            //echo var_dump($_POST);
            //echo var_dump($user);

            if (password_verify($_POST["password"], $user["pass"])) {
                $_SESSION["username"] = $user["username"];
                header("Location:/whatstec/chat.html");
            } else {
                echo "Password incorrecta";
            }
        } else {
            echo "O utilizador não existe";
        }
    } else {
        echo "ERROR: Bad parameters";
    }
}

//O que significa $_ => Variáveis do tipo SuperGlobal
if(isset($_GET["logout"])){
    session_destroy();
    header("Location:/whatstec");
}


function user_loggedin(){
    if(isset($_SESSION) && isset($_SESSION["username"])){
        return true;
    }else{
        return false;
    }
}



