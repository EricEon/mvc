<?php include 'header.php';
use Flux\Core\Helpers\Session;
?>

<div class="container">
    <?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['status'] ?>">
        <p>
            <?php Session::display()?>
        </p>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <table>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>ACTIVATED</th>
                    <th>DATE CREATED</th>
                </tr>
                <?php foreach($data as $user):?>
                <tr>
                    <td><?=$user['id']?></td>
                    <td><?=$user['name']?></td>
                    <td><?=$user['email']?></td>
                    <td>
                    <?php 
                    if($user['activation_confirm'] === 0): 
                    ?>
                    <i class="fas fa-times danger"></i>
                    <?php else: ?>
                    <i class="fas fa-check success"></i>
                    <?php endif; ?>
                    </td>
                    <td><?= gmdate('D:m:Y H:i',strtotime($user['date_created'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php';?>