<?php

require_once("models/User.php");
require_once("models/message.php");
require_once("dao/userDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($connect, $BASE_URL);
//resgata o tipo do formulario

$type = filter_input(INPUT_POST, "type");


if($type === "register") {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

    //verificação dos dados minimos

    if($name && $lastname && $email && $password) {

        //Verificar se as senhas batem
        if($password === $confirmpassword) {

            //verificar se o email já está cadastrado no sistema
            if($userDao->findByEmail($email) === false) {

                $user = new User();

                //Criçãp de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);

            } else {
                $message->setMessage("Usuário já cadastrado!, tente outro e-mail.", "error", "back");
            }

        } else {
            //enviar mensagem de erro cso as senhas não forem iguais
            $message->setMessage("As senhas não são iguais.", "error", "back");
        }
    } else {
        //enviar mensagem de erro, de dados faltantes
        $message->setMessage("Por favor, preencha todos os campos.", "error", "back");

    }

} else if($type === "login") {

}