<?php
session_start();
include_once __DIR__ . '/util.php';
include_once __DIR__ . '/Utente.php';

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['codice_fiscale']);
    header('Location: https://localhost/biblio/login.php');
    exit;
}

$loggedInUser = \DataHandle\Utente::loginUser($_POST);

$_SESSION['codice_fiscale'] = $loggedInUser['codice_fiscale'];
$is_impiegato = \DataHandle\Utente::isImpiegato($loggedInUser['codice_fiscale']);
$_SESSION['is_impiegato'] = $is_impiegato;
header('Location: https://localhost/biblio');
exit; 
