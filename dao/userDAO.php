<?php

    include_once("models/user.php");
    include_once("models/message.php");

    class UserDAO implements UserDAOInterface {

        private $connect;
        private $url;
        private $message;

        public function __construct(PDO $connect, $url) {
            $this->connect = $connect;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildUser($data) {

            $user = new User();

            $user->id = $data["id"];
            $user->name = $data["name"];
            $user->lastname = $data["lastname"];
            $user->email = $data["email"];
            $user->password = $data["password"];
            $user->image = $data["image"];
            $user->bio = $data["bio"];
            $user->token = $data["token"];

            return $user;
        }
        public function create(User $user, $authUser = false) {

            $stmt = $this->connect->prepare("INSERT INTO users (name, lastname, email, password, token) VALUES (:name, :lastname, :email, :password, :token)");

                $stmt->bindParam(":name", $user->name);
                $stmt->bindParam(":lastname", $user->lastname);
                $stmt->bindParam(":email", $user->email);
                $stmt->bindParam(":password", $user->password);
                $stmt->bindParam(":token", $user->token);

                $stmt->execute();

                //Autenticar usuario caso auth seja true
                if($authUser) {
                    $this->setTokenSession($user->token);
                }
        }

        public function update(User $user) {
            $stmt = $this->connect->prepare("UPDATE users SET 
            name = :name,
            lastname = :lastname,
            email = :email,
            image = :image,
            bio = :bio,
            token = :token
            WHERE id = :id");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();
            // Redireciona e apresenta mensagem de sucesso
      $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
      
        }

        public function changePassword($user) {
            $stmt = $this->connect->prepare("UPDATE users SET
            password = :password 
            WHERE id = :id");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            // Redireciona e apresenta mensagem de sucesso
            $this->message->setMessage("Senha atualizada!", "success", "editprofile.php");
      
        }

        public function verifyToken($protected = false) {

        }

        public function setTokenSession($token, $redirect = true) {
            //Salvar token na session
            $_SESSION["token"] = $token;

            if($redirect) {
                //Redireciona para o perfil do usuario
                $this->message->setMessage("Seja Bem-vindo", "sucess", "editprofile.php");
            }

        }

        public function authenticateUser($email, $password) {

        }

        public function findByEmail($email) {

            if($email != "") {
      
              $stmt = $this->connect->prepare("SELECT * FROM users WHERE email = :email");
              
              $stmt->bindParam(":email", $email);
      
              $stmt->execute();
      
              if($stmt->rowCount() > 0) {
      
                $data = $stmt->fetch();
                $user = $this->buildUser($data);
        
                return $user;
      
              } else {
                return false;
              }
      
            }
      
            return false;
      
          }

        public function findById($id) {

        }

        public function findByToken($token) {

        }

        public function changePassword(User $user) {

        }

    }