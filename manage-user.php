<?php

include_once __DIR__ . '/includes/globals.php';

if($_POST){
    $codice_fiscale = $_POST['codice_fiscale'];
    $user = \DataHandle\Utente::selectUser($codice_fiscale);
    if(!isset($user)){
        $user = "Associato non trovato";
    }  
    
    $history = \DataHandle\Libro::viewBookHistory($id_libro = null, $codice_fiscale);
}
if(isset($_GET['update'])){//after pressing "Modificare dati";
    $codice_fiscale = $_GET['codice_fiscale'];
    $userUpdate = \DataHandle\Utente::selectUser($codice_fiscale);
}
if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert($_GET['action'], $_GET['stato']);

}  
?>

<form action="./manage-user.php" method="POST" class="container codice-form">
    <label for="codice_fiscale" class="form-label">Inserire codice fiscale del associato</label>
    <input name="codice_fiscale" type="text"  class="form-control codice-fiscale"  required>
    <input type="submit" value="Cercare" class="btn btn-dark">
</form>


<?php if(isset($user)):
    if(is_array($user)):?>
        <div>
            <p>Nome e cognome: <?php echo $user['nome'].' '.$user['cognome'];?></p>
            <p>Codice Fiscale: <?php echo $user['codice_fiscale'];?></p>
            <p>E-mail: <?php echo $user['email'];?></p>
            <p>Telefono: <?php echo $user['telefono'];?></p>
        </div>
        <div>
            <?php if (isset($history) && $history!=null):?>
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Libri ritirati</th>
                <th scope="col">Data Ritiro</th>
                <th scope="col">Data Restituzione</th>
                </tr>
            </thead>
      
            <tbody>
            <?php foreach($history as $record):
            $libro = \DataHandle\Libro::selectBook($search_type =null, $search_value =null, $record['id_libro']);?>
                <tr>
                <td><?php echo $libro['titolo'];?></td>
                <td><?php echo $record['data_ritiro'];?></td>
                <td><?php echo $record['data_restituzione'];?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif;?>

       
        <a href="./manage-user.php?codice_fiscale=<?php echo $codice_fiscale;?>&update=1" class="btn btn-dark">Modificare dati</a>
        <a href="./includes/manage-user.php?codice_fiscale=<?php echo $codice_fiscale;?>&delete=1" class="btn btn-dark">Eliminare associato</a>
                
    <?php else:?>
        <p><?php echo $user;?></p>
    <?php endif;?>
    <?php endif;?>
</div>

<?php if(isset($_GET['update'])):?>
    <form action="./includes/manage-user.php?update=1&codice_fiscale=<?php echo $codice_fiscale;?>" method="POST" class="container">
        <div class="row">    
            <div class="col">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $userUpdate['nome'];?>" required>
            </div>
            <div class="col">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" name="cognome" id="cognome" class="form-control" value="<?php echo $userUpdate['cognome'];?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
                <input type="text" name="codice_fiscale" id="codice_fiscale" class="form-control" value="<?php echo $userUpdate['codice_fiscale'];?>" disabled>
            </div>
            <div class="col">
            <label for="ruolo" class="form-label">Ruolo</label>

                <select class="form-select" aria-label="Ruolo" name="ruolo">
                    <option value="associato" selected>Associato</option>
                    <option value="impiegato">Impiegato</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo $userUpdate['telefono'];?>" required>
                </div>
           
            <div class="col">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo $userUpdate['email'];?>" required>

            </div>
        </div>
        

            <input type="submit" value="Modificare" class="btn btn-dark">

<?php endif;?>


</main>
</body>