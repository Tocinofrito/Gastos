<link rel="stylesheet" href="public/css/default.css">
<link rel="stylesheet" href="public/css/dashboard.css">


<div id="header">
    <ul>
        <li><a href="<?php echo constant('URL')?>dashboard">Home</a></li>
        <li><a href="<?php echo constant('URL')?>expenses">Expenses</a></li>
        <li><a href="<?php echo constant('URL')?>logout">Logout</a></li>
    </ul>
    <div id="profile-container">
        <a href="<?php echo constant('URL')?>user">
            <div class="name"></div>
            <div class="photo">
            </div>
        </a>
        <div id="submenu">
            <ul>
                <li><a href="<?php echo constant('URL')?>user">Ver perfil</a></li>
                <li class='divisor'></li>
                <li><a href="logout">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</div>