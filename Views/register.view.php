<?php 
include 'header.php';
use Flux\Core\Helpers\Session;
?>


<div class="container">
<?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['status'] ?>">
        <p><?php Session::display()?></p>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col">
            <form action="#" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" name="submit">
                </div>

            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>