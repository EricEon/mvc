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
            <form action="/activate" method="post" style="background-color: grey;">
                <div class="form-group">
                <?php if(isset($data)): ?>
                    <input type="text" value="<?= $data['email']; ?>" name="email" hidden>
                <?php elseif(!isset($data)): ?>
                    <input type="text" value="" name="email" hidden>
                <?php endif;?>
                </div>
                <div class="form-group">
                <?php if(isset($data)): ?>
                    <input type="text" value="<?= $data['activation_code']; ?>" name="activation_code" hidden>
                <?php elseif(!isset($data)): ?>
                    <input type="text" value="" name="activation_code" hidden>
                <?php endif;?>
                </div>
                <div class="form-group">
                    <label for="activation">Activate User
                    </label>
                    <input type="submit" value="Activate" name="submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php';?>