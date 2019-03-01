<?php include 'header.php';
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
            <form action="/login" method="post">
                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <input type="text" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Login" name="submit">
                </div>

            </form>
        </div>
    </div>
</div>

<?php include 'footer.php';?>