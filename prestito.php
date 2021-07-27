<?php

include_once __DIR__ . '/includes/globals.php';
if($_SESSION['is_impiegato']==false){
    header('Location: https://localhost/biblio/index.php');
    exit;
  }
?>

            <form action="./includes/manage-book.php?prestito=1" method="POST" class="container prestito-form">
                <input name="titolo" type="text"  class="form-control prestito" value="<?php echo $_GET['titolo'];?>"  disabled>
                <input name="id" type="text"  class="form-control"  value="<?php echo $_GET['id']?>" hidden >
                <label for="codice_fiscale" class="form-label">Inserire codice fiscale del associato</label>
                <input name="codice_fiscale" type="text"  class="form-control prestito" autocomplete="off" required>
                <input type="submit" value="Libro in prestito" class="btn btn-dark">
            </form>
        </main>
    </body>
</html>