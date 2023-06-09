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
            
            if(!empty($_SESSION["token"])) {
                //pega o token da session
                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                if($user) {
                    return $user;
                } else if($protected) {
                    // Redireciona para home caso não haja usuário
          $this->message->setMessage("Faça a autenticação para acessar esta página.", "error", "index.php");

                } else {
                    return false;
                }
            }
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
            $user = new User();
            $user = $this->findByEmail($email);

            //checa se o usuario existe
            if($user) {

                //Checa se a senha bate
                if(password_verify($password, $user->password)) {

                    //gera o token e coloca na session, sem redirecionar

                    $token = $user->generateToken();

                    $this->setTokenSession($token, false);

                    //atualiza token do usuário

                    $user->token = $token;

                    $this->update($user);

                    return true;
                }

            }
            return false;
        }

        public function destroyToken() {
            //Remove o token

            $_SESSION["token"] = "";

            //Redireciona e apresenta mensagem de sucesso
            $this->message->setMessage("Você fez o logout com Sucesso!", "sucess", "index.php");
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

        public function findByToken($token) {
            $stmt = $this->connect->prepare("SELECT *  FROM users WHERE token = :token");
            $stmt->bindParam(":token", $token);

            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $data = $stmt->fetch();
                $user = $this->buildUser($data);

                return $user;
            } else {
                return false;
            }
        }

        public function findById($id) {
            if($id != "") {
      
                $stmt = $this->connect->prepare("SELECT * FROM users WHERE id = :id");
                
                $stmt->bindParam(":id", $id);
        
                $stmt->execute();
        
                if($stmt->rowCount() > 0) {
        
                  $data = $stmt->fetch();
                  $user = $this->buildUser($data);
          
                  return $user;
        
                } else {
                  return false;
                }
            }

        }
    }