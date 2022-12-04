<?php

include("vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\RolesTable;
use Helpers\Auth;

$auth = Auth::check();

$table = new UsersTable(new MySQL);
$users = $table->getAll();

$rolesTable = new RolesTable(new MySQL);
$roles = $rolesTable->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.min.js" defer></script>
</head>
<body>
    <nav class="navbar bg-primary navbar-dark">
        <div class="container">
            <nav class="navbar-brand">ADMIN</nav>
        </div>
    </nav>
            <div class="container mt-4">
                
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>#</th>
                    </tr>

                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= $user->id ?></td>
                            <td><?= htmlspecialchars( $user->name ) ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->phone ?></td>
                            <td>
                                <?php if($user->value == 1): ?>
                                    <span class="badge bg-success">
                                <?php elseif($user->value ==2): ?>
                                    <span class="badge bg-danger">
                                <?php else: ?>
                                    <span class="badge bg-secondary">
                                <?php endif ?>
                                    <?=$user->role ?>
                                    </span>
                            </td>
                            <td>
                                <?php if($auth->value>=2): ?>
                                    <?php if($user->suspended): ?>
                                    <a href="_actions/unsuspend.php?id=<?= $user->id ?>"
                                    class="btn btn-warning btn-sm">Activate</a>
                                    <?php else: ?>
                                    <a href="_actions/suspend.php?id=<?= $user->id ?>"
                                    class="btn btn-success btn-sm">Suspend</a>
                                    <?php endif ?>
                                <?php endif ?>                       
                                
                            
                            
                            <?php 
                            // echo ($auth->value);
                            if($auth->value >=3): ?>
                                <div class="btn-group dropdown">
                                    <a href="#" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                        Change Role
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach($roles as $role): ?>
                                            <a href="_actions/role.php?id= <?= $user->id ?> &role= <?= $role->id ?>" class="dropdown-item">
                                            <?= $role->name ?>
                                            </a>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                                <a href="_actions/delete.php?id=<?= $user->id ?>" class="btn btn-danger btn-sm"> Delete</a>
                            <?php endif ?>
                                <a href="index.php" class="btn btn-warning btn-sm">Log Out</a>
                            </td>
                        </tr>
                    <?php endforeach ?>

                </table>
            </div>
        
    
</body>
</html>


<!-- 615 -->