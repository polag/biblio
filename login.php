<?php
require __DIR__ . '/includes/globals.php';


?>
<div class="row access">

    <div class="col-8 ">
        <h1>Log In</h1>
        <?php

        if (isset($_GET['statologin'])) {
            \DataHandle\Utils\show_alert('login', $_GET['statologin']);
        }
        ?>
        <form action="includes/login.php" method="POST" class="container">
            <div class="col">
                <label for="codice_fiscale" class="form-label">Codice Fiscale</label>
                <input type="text" name="codice_fiscale" id="codice_fiscale" class="form-control" required>
            </div>
            <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <input type="submit" value="Login" class="btn btn-dark">

        </form>

    </div>
   

</div>

</main>
</body>

</html>