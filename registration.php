<?php
require __DIR__ . '/includes/globals.php';
if($_SESSION['is_impiegato']==false){
    header('Location: https://localhost/biblio/index.php');
    exit;
}

?>
<div class="user-registration">
      
        <?php

        if (isset($_GET['stato'])) {
            \DataHandle\Utils\show_alert('registrazione', $_GET['stato']);
        }
        ?>
        <form action="includes/registration.php" method="POST" class="container registration-fields">
        <h3>Registrazione nuovo utente</h3>
        <div class="row">    
            <div class="col">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <div class="col">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" name="cognome" id="cognome" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
                <input type="text" name="codice_fiscale" id="codice_fiscale" class="form-control" required>
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
                    <input type="text" name="telefono" id="telefono" class="form-control" required>
                </div>
           
            <div class="col">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" name="email" id="email" class="form-control" required>

            </div>
        </div>
        <div class="row">
                <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col">
                    <label for="password-check" class="form-label">Ripeti Password</label>
                    <input type="password" name="password-check" id="password-check" class="form-control" required>
                </div>
            </div>

            <input type="submit" value="Registrare" class="btn btn-dark">

        </form>  

</div>

</main>
</body>

</html>