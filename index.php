<?php
include_once __DIR__ . '/includes/globals.php';

if (isset($_GET['search'])) {
    $search_value = $_GET['search'];
    $search_type = $_GET['search_type'];

    $books = \DataHandle\Libro::selectBook($search_type, $search_value);
    
}
if(isset($_SESSION['is_impiegato'] )){
    $is_impiegato = $_SESSION['is_impiegato'];

}
?>
<form class="d-flex">
    <select class="form-select" aria-label="Cerca per" name="search_type">
        <option value="titolo" selected>Titolo</option>
        <option value="autore">Autore</option>
       <?php if ($is_impiegato):?>
        <option value="ISBN">ISBN</option>
        <option value="data_pubblicazione">Data Pubblicazione (esempio: 1983-01-25)</option>
        <?php endif;?>
    </select>

    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>

<?php
if(isset($books)): ?>

<div>
<?php foreach($books as $book): ?>
    <div class="book-card">
        <h2>Titolo: <?php echo $book['titolo'];?></h2>
        <p>Autore: <?php echo $book['autore'];?> </p>
        <?php if ($is_impiegato):?>
        <p>ISBN: <?php echo $book['ISBN'];?></p>
        <p>Data di Pubblicazione: <?php echo $book['data_pubblicazione'];?> </p>
        <?php endif;?>
        <p><?php echo $book['stato'];?> </p>
        
    </div>
    <?php endforeach; ?>
</div>

<?php endif;?>



</body>

</html>