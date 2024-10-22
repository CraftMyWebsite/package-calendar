<?php

use CMW\Utils\Website;

Website::setTitle('Calendrier');
Website::setDescription('Découvrez nos futur événements');
?>
<?php if (\CMW\Controller\Users\UsersController::isAdminLogged()): ?>
    <div style="background-color: orange; padding: 6px; margin-bottom: 10px">
        <span>Votre thème ne gère pas cette page !</span>
        <br>
        <small>Seuls les administrateurs voient ce message !</small>
    </div>
<?php endif;?>
<div id='calendar'></div>
