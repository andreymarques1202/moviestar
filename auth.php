<?php
    require_once("templates/header.php");
?>


    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <h2>Entrar</h2>
                    <form action="" method="POST">
                    <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="email">E-mail: </label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu email">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha: </label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha">
                        </div>
                        <input type="submit" class="btn card-btn" value="Entrar">
                    </form>
                </div>
                <div class="col-md-4" id="register-container">
                    <h2>Criar Conta</h2>
                    <form action="" method="post">
                        <input type="hidden" name="type" value="register">
                        <div class="form-group">
                            <label for="email">E-mail: </label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu email">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome: </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Sobrenome: </label>
                            <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Digite seu sobrenome">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha: </label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Digite sua senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirmação de Senha: </label>
                            <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" placeholder="Confirme sua senha">
                        </div>
                        <input type="submit" value="btn card-btn" value="Registrar">
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
include_once("templates/footer.php");
?>