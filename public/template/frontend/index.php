<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <?php echo $this->_title; ?>

    <link rel="icon" href="<?= $this->_pathImg ?>favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= $this->_pathImg ?>favicon.png" type="image/x-icon">
    <title><?= $this->_title ?? 'Trang chủ | BookStore' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,900" rel="stylesheet">

    <?php echo $this->_cssFiles; ?>
    <!-- <link rel="stylesheet" type="text/css" href="css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <link rel="stylesheet" type="text/css" href="css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/color16.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="css/phone-ring.css"> -->
</head>

<body>
    <div class="loader_skeleton">
        <div class="typography_section">
            <div class="typography-box">
                <div class="typo-content loader-typo">
                    <div class="pre-loader"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- header start -->
    <?php require_once 'html/header.php' ?>
    <!-- header end -->

    <?php
    require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
    ?>

    <!-- footer -->

    <?php require_once 'html/footer.php' ?>
    <!-- tap to top end -->
    <!-- 
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.exitintent.js"></script>
    <script src="js/notifyjs/notify.min.js"></script>
    <script src="js/exit.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/lazysizes.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/slick.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/my-custom.js"></script> -->
    <?php echo $this->_jsFiles; ?>
    <script>
        function openSearch() {
            document.getElementById("search-overlay").style.display = "block";
            document.getElementById("search-input").focus();
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }
    </script>
</body>

</html>