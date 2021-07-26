<?php

include_once __DIR__ . '/includes/globals.php';

?>

<form action="./includes/manage-book.php?prestito=1" method="POST">
    <input name="titolo" type="text"  class="form-control" value="<?php echo $_GET['titolo'];?>"  disabled>
    <input name="id" type="text"  class="form-control"  value="<?php echo $_GET['id']?>" hidden >
    <label for="codice_fiscale" class="form-label">Inserire codice fiscale del associato</label>
    <input name="codice_fiscale" type="text"  class="form-control" autocomplete="off" required>
    <input type="submit" value="Libro in prestito" class="btn btn-dark">
</form>