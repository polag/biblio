<?php
include_once __DIR__ . '/globals.php';

if(isset($_GET['update'])){
   
   \DataHandle\Utente::updateUser($_POST, $_GET['codice_fiscale']);
}elseif(isset($_GET['delete'])){
    \DataHandle\Utente::deleteUser($_GET['codice_fiscale']);
}