<?php
include_once __DIR__ . '/includes/globals.php';
$not_found = false;
$is_impiegato = false;
if (isset($_GET['search'])) {
    $search_value = $_GET['search'];
    $search_type = $_GET['search_type'];


    $books = \DataHandle\Libro::selectBook($search_type, $search_value);
    if (count($books) == 0) {
        $not_found = true;
    }
}
if (isset($_SESSION['is_impiegato'])) {
    $is_impiegato = $_SESSION['is_impiegato'];
}
if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert($_GET['action'], $_GET['stato']);
   

}  
?>
<h1>CERCA LIBRI</h1>
<?php if($is_impiegato):?>
                <a href="./insert-book.php" class="btn btn-dark">Inserire nuovo libro</a>
                
                <?php endif;?>

<form class="d-flex">
    <select class="form-select" aria-label="Cerca per" name="search_type">
        <option value="titolo" selected>Titolo</option>
        <option value="autore">Autore</option>
        <?php if ($is_impiegato) : ?>
            <option value="ISBN">ISBN</option>
            <option value="data_pubblicazione">Data Pubblicazione (esempio: 1983-01-25)</option>
        <?php endif; ?>
    </select>

    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>

<?php
if (isset($books)) : ?>
    <div>
        <?php foreach ($books as $book) : ?>
            <div class="book-card">
                <h2>Titolo: <?php echo $book['titolo']; ?></h2>
                <p>Autore: <?php echo $book['autore']; ?> </p>
                <?php if ($is_impiegato) : ?>
                    <p>ISBN: <?php echo $book['ISBN']; ?></p>
                    <p>Data di Pubblicazione: <?php echo $book['data_pubblicazione']; ?> </p>
                    <img src="<?php echo $book['copertina']; ?>" alt="copertina  <?php echo $book['titolo']; ?>">
                <?php endif; ?>
                <p><?php echo $book['stato']; ?> </p>

            </div>
            <?php if($is_impiegato):?>
                <?php if(strtolower($book['stato']) == 'disponibile'): ?>
                    <a href="./prestito.php?id=<?php echo $book['id'];?>&titolo=<?php echo $book['titolo'];?>" class="btn btn-dark">Prestito</a>
                <?php else: ?>
                    <a href="./includes/manage-book.php?prestito=0&id=<?php echo $book['id'];?>" class="btn btn-dark">Disponibile</a>
                <?php endif;?>
                <a href="./update-book.php?id=<?php echo $book['id'];?>" class="btn btn-dark">Modificare libro</a>
                <a href="./history.php?id=<?php echo $book['id'];?>" class="btn btn-dark">Storico dei prestiti</a>

                <a href="./includes/manage-book.php?id=<?php echo $book['id'];?>&delete=1" class="btn btn-dark">Eliminare libro</a>
                <?php endif;
        endforeach; ?>
    </div>
<?php endif; ?>
<?php if ($not_found) : ?>
    <div>
        <h2>Libro non trovato.</h2>

    </div>
<?php endif; ?>

</body>

</html>