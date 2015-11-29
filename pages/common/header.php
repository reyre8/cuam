<?php define('ROOT_PATH', '/var/www/html/cuam/'); ?>
<script src="/cuam/dependencies/jquery-1.11.3.min.js"></script>
<script src="/cuam/dependencies/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/cuam/dependencies/moment.js"></script>
<script src="/cuam/dependencies/jquery-datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/cuam/assets/css/cuam.css" />
<link rel="stylesheet" type="text/css" href="/cuam/dependencies/bootstrap-3.3.5/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/cuam/dependencies/jquery-datetime-picker/css/bootstrap-datetimepicker.min.css" />
<script src="/cuam/assets/js/cuam.js"></script>

<div class="top-header-bar font-site"><a class="href-index" href="/cuam/index.php">Servicios al Estudiante (CUAM)</a></div>
<div class="container">
    <div class="navbar-header">
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <ul class="nav navbar-nav">
        <li>
            <a href="/cuam/pages/includes/estudiante.php">Estudiantes</a>
        </li>
        <li>
            <a href="/cuam/pages/includes/mencion.php">Menciones</a>
        </li>
        <li class="active">
            <a href="/cuam/pages/includes/inscripcion.php">Inscripciones</a>
        </li>
    </ul>
</div>

<div class="sub-header">
    <div class="container">
        <h1>Servicios al estudiante (CUAM)</h1>
        <p>Administracion de procesos de inscripciones, menciones, estudiantes y usuarios</p>
    </div>
</div>
<div class="container" id="message-container"></div>

<?php

include ROOT_PATH . '/libs/cuam-lib.php';