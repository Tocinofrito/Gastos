<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Esta es la vista de login</h1>
    <p><?php 
        $this->showMessages();
    ?></p>
    <div>
        <form action="<?php echo constant('URL'); ?>/login/authenticate" method="POST">
            <div><?php (isset($this->errorMessage))? $this->errorMessage : '' ?></div>
            <h2>Iniciar sesión</h2>
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off">
            </p>
            <p>
                <label for="password">password</label>
                <input type="password" name="password" id="password" autocomplete="off">
            </p>
            <p>
                <input type="submit" value="Iniciar sesión">
            </p>
                ¿No tienes cuenta? <a href="<?php echo constant('URL'); ?>/signup">Registrarse</a>
            </p>
        </form>
    
    </div>
</body>
</html