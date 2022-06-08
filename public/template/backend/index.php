<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <?php echo $this->_title; ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <?php echo $this->_pluginCssFiles ?>
    <?php echo $this->_cssFiles; ?>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once 'html/navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once 'html/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php require_once 'html/page-header.php'; ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?php
                    require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
                    ?>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->

        <?php require_once 'html/footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <!-- ?php require_once 'html/script.php'; ? -->
    <?php echo $this->_pluginJsFiles ?>
    <?php echo $this->_jsFiles; ?>
</body>

</html>