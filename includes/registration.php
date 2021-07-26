<?php
include_once __DIR__ . '/util.php';
include_once __DIR__ . '/Utente.php';
if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert($_GET['action'], $_GET['stato']);
}
\DataHandle\Utente::registerUser($_POST);
