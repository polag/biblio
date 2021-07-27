<?php
include_once __DIR__ . '/globals.php';
$codice_fiscale = $_SESSION['codice_fiscale'];

if(isset($_GET['update'])){   
   \DataHandle\Utente::updateUser($_POST, $_GET['codice_fiscale']);
}elseif(isset($_GET['delete'])){
    \DataHandle\Utente::deleteUser($_GET['codice_fiscale']);
}elseif(isset($_GET['password'])){
    $password = $_POST['password'];
    $newPassword = $_POST['newPassword'];  
    \DataHandle\Utente::updatePassword($password, $newPassword, $codice_fiscale);
}