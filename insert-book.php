<?php

include_once __DIR__ . '/includes/globals.php';


if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert('Inserito', $_GET['stato']);

}  


?>
<div class="manage-book">
    
    <form action="./includes/manage-book.php?insert=1.php" method="POST" class="container">
    <h3>Inserire un libro</h3>
        <div class="mb-3">
            <label for="titolo" class="form-label">Titolo</label>
            <input type="text" name="titolo" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="ISBN" class="form-label">ISBN</label>
            <input type="text" name="ISBN" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="copertina" class="form-label">Copertina</label>
            <input  type="text" name="copertina" placeholder="https://" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="data_pubblicazione" class="form-label">Data di pubblicazione</label>
            <input type="date" name="data_pubblicazione"  class="form-control" autocomplete="off">
        </div>
        
        <div class="mb-3">
            <label for="autore" class="form-label">Autore</label>
            <input type="text" name="autore"  class="form-control" autocomplete="off">
        </div>
        
        <input type="submit" value="Inserire libro" class="btn btn-dark">
        
    </form>


</div>
</main>
</body>