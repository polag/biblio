<?php 
include_once __DIR__ . '/includes/globals.php';
?>
        <form action="./includes/manage-user.php?password=1" method="POST" >
            <div class="mb-3">
                <label for="password" class="form-label">Password Attuale</label>
                <input type="password" name="password" class="form-control" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">Nuova Password</label>
                <input type="password" name="newPassword" class="form-control"  autocomplete="off" required>
            </div>
            <input type="submit" value="Salva modifiche" class="btn btn-dark">
            <a href="/blog/profile.php" class="btn btn-dark">Cancel</a>
        </form>