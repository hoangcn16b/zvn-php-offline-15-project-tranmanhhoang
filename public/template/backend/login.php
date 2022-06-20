<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'html/head.php'; ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-info">
            <div class="card-header text-center">
                <h1 class="h1"><b>Admin</b></h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your admin panel!</p>
                <?php
                require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
                ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <?php require_once 'html/script.php'; ?>
</body>

</html>