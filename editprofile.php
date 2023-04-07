<?php

    require_once("templates/header.php");

    // Checa autenticação
    require_once("models.user.php");
    require_once("dao/userDAO.php");

    $userModel = new User();

    //verifica o token, se não for o correto redireciona para home

    $auth = new UserDao($connect, $BASE_URL);

    $userData = $auth->verifyToken();

    $fullName = $userModel->getFullName($userData);

    if($userData->image == "") {
        $userData->image = "user.png";
    }
?>

    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <form action="<?= $BASE_URL?>user_process.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="update">
                <div class="row">
                    <div class="col-md-4">
                        <h1><? $fullName ?></h1>
                        <p class="page-description">Altere Seus dados no formulário abaixo:</p>
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu sobrenome" value="<?= $userData->lastname ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control disabled" id="email" name="email" placeholder="Digite seu e-mail" readonly value="<?= $userData->email ?>">
                        </div>
                        <input type="submit" class="btn form-btn" value="Alterar">
                    </div>
                    <div class="col-md-4">
                    <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
            <div class="form-group">
              <label for="image">Foto</label>
              <input type="file" name="image" class="form-control-file">
            </div>
            <div class="form-group">
              <label for="bio">Sobre você:</label>
              <textarea class="form-control" id="bio" name="bio" rows="5" placeholder="Conte quem você é, o que faz, onde trabalha..."><?= $userData->bio ?></textarea>
            </div>
          </div>    
        </div> 
      </form> 
      <div class="row" id="change-password-container">
        <div class="col-md-4">
          <h2>Alterar a senha:</h2>
          <p class="page-description">Digite a nova senha e confirme, para alterar a senha:</p>
          <form action="<?= $BASE_URL ?>user_process.php" method="POST">
            <input type="hidden" name="type" value="changepassword">
            <input type="hidden" name="id" value="<?= $userData->id ?>">
            <div class="form-group">
              <label for="password">Senha:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha">
            </div>
            <div class="form-group">
              <label for="confirmpassword">Confirmação de senha:</label>
              <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a sua senha">
            </div>
            <input type="submit" class="btn form-btn" value="Alterar Senha">
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php
    require_once("templates/footer.php");
?>