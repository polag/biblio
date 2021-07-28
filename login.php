<?php
require __DIR__ . '/includes/globals.php';


?>
<div class="row ">

    <?php

    if (isset($_GET['statologin'])) {
        \DataHandle\Utils\show_alert('login', $_GET['statologin']);
    }
    ?>
    <form action="includes/login.php" method="POST" class="container login">
        <h1>Accedi</h1>
        <div class="col">
            <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
            <input type="text" name="codice_fiscale" id="codice_fiscale" class="form-control login" required>
        </div>
        <div class="col">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control login" required>
        </div>

        <input type="submit" value="Login" class="btn btn-dark">

    </form>
</div>

</main>
</body>

</html>