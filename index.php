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
<h1>CATALOGO</h1>
<form class="d-flex cerca-libri">
    <div class="input-group mb-3">

        <select class="form-select search" aria-label="Cerca per" name="search_type">
            <option value="titolo" selected>Titolo</option>
            <option value="autore">Autore</option>
            <?php if ($is_impiegato) : ?>
                <option value="ISBN">ISBN</option>
                <option value="data_pubblicazione">Data Pubblicazione (esempio: 1983-01-25)</option>
            <?php endif; ?>
        </select>
        <input class="input-group-text" type="search" placeholder="Cerca Libro" aria-label="search" name="search">
        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Cerca</button>

    </div>
</form>
<?php
if (isset($books)) : ?>
    <div>
        <?php foreach ($books as $book) : ?>
            <div class="card book-card mb-3" >
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $book['copertina']; ?>" class="card-img-top" alt="copertina  <?php echo $book['titolo']; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h4><?php echo $book['titolo']; ?></h4>
                            <p>Autore: <?php echo $book['autore']; ?> </p>

                            <?php if ($is_impiegato) : ?>
                                <p>ISBN: <?php echo $book['ISBN']; ?></p>
                                <p>Data di Pubblicazione: <?php echo $book['data_pubblicazione']; ?> </p>
                            <?php endif; ?>
                            <?php if ($book['stato'] == 'disponibile') : ?>
                            
                            <span class="disponibile"><?php echo strtoupper($book['stato']); ?> </span>
                            <?php else:?>
                            <span class="in-prestito"><?php echo strtoupper($book['stato']); ?> </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                                <?php if ($is_impiegato) : ?>
                                <?php if (strtolower($book['stato']) == 'disponibile') : ?>
                                    <a href="./prestito.php?id=<?php echo $book['id']; ?>&titolo=<?php echo $book['titolo']; ?>" class="btn btn-dark">Prestito</a>
                                <?php else : ?>
                                    <a href="./includes/manage-book.php?prestito=0&id=<?php echo $book['id']; ?>" class="btn btn-dark">Disponibile</a>
                                <?php endif; ?>
                                <a href="./update-book.php?id=<?php echo $book['id']; ?>" class="btn btn-dark">Modificare libro</a>
                                <a href="./history.php?id=<?php echo $book['id']; ?>" class="btn btn-dark">Storico dei prestiti</a>

                                <a href="./includes/manage-book.php?id=<?php echo $book['id']; ?>&delete=1" class="btn btn-dark">Eliminare libro</a>
                            <?php endif;?>
                    </div>
              </div>
            </div>
        <?php endforeach; ?>
                    
    </div>
        <?php endif; ?>
        <?php if ($not_found) : ?>
            <div>
                <h2>Libro non trovato.</h2>

            </div>
        <?php endif; ?>

        </body>

        </html>