<?php
include_once __DIR__ . '/globals.php';

if(isset($_GET['insert'])){
    \DataHandle\Libro::insertBook($_POST);
}elseif(isset($_GET['update'])){
    \DataHandle\Libro::updateBook($_POST, $_GET['id']);
}
elseif(isset($_GET['prestito'])){
    
    if ($_GET['prestito'] == 1){
        \DataHandle\Libro::changeBookStatus($_POST['id'],'In prestito', $_POST['codice_fiscale']);
    }
    if ($_GET['prestito'] == 0){
        \DataHandle\Libro::changeBookStatus($_GET['id'],'disponibile');
    }
}elseif(isset($_GET['delete'])){
    \DataHandle\Libro::deleteBook($_GET['id']);
}elseif(isset($_GET['history'])){
    \DataHandle\Libro::viewBookHistory($_GET['id']);
}