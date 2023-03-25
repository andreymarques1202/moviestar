<?php

require_once("models/User.php");
require_once("models/message.php");
require_once("dao/userDAO.php");
require_once("globals.php");
require_once("db.php");

$message = new Message($BASE_URL);

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

    } else {
        //enviar mensagem de erro, de dados faltantes
        $message->setMessage("Por favore, preencha todos os campos.", "error", "back");

    }

} else if($type === "login") {

}