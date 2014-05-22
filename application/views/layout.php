<!doctype html>
<html>
    <meta charset="utf-8"/>
    <head>
        <title><?php $title_for_layout ?></title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    </head>
    <body ng-app="app">

        <!-- Content -->
        <?php echo $content_for_layout ?>

        <!-- Scripts -->
        <script type="text/javascript" src="assets/js/libs/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="assets/js/libs/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/libs/angujar.min.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>
    </body>
</html>