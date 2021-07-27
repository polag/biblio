<?php

include_once __DIR__ . '/includes/globals.php';

if (isset($_GET['id'])) {
$id = $_GET['id'];
$book = \DataHandle\Libro::selectBook($search_type = null, $search_value  = null,$id);

}
?>
<div class="manage-book">
    
    <form action="./includes/manage-book.php?update=1&id=<?php echo $id;?>.php" method="POST" class="container" >
    <h2>Modificare libro</h2>
        <div class="mb-3">
            <label for="titolo" class="form-label">Titolo</label>
            <input type="text" name="titolo" class="form-control" autocomplete="off"  value="<?php echo $book['titolo'];?>" required>
        </div>
        <div class="mb-3">
            <label for="ISBN" class="form-label">ISBN</label>
            <input type="text" name="ISBN" class="form-control" autocomplete="off" value="<?php echo $book['ISBN'];?>" required>
        </div>
        <div class="mb-3">
            <label for="copertina" class="form-label">Copertina</label>
            <input  type="text" name="copertina" placeholder="https://" class="form-control" autocomplete="off" value="<?php echo $book['copertina'];?>" required>
        </div>
        <div class="mb-3">
            <label for="data_pubblicazione" class="form-label">Data di pubblicazione</label>
            <input type="date" name="data_pubblicazione"  class="form-control" autocomplete="off" value="<?php echo $book['data_pubblicazione'];?>">
        </div>
        
        <div class="mb-3">
            <label for="autore" class="form-label">Autore</label>
            <input type="text" name="autore"  class="form-control" autocomplete="off" value="<?php echo $book['autore'];?>">
        </div>
        
        
        <input type="submit" value="Modificare libro" class="btn btn-dark">
        
    </form>


</div>
</main>
</body>