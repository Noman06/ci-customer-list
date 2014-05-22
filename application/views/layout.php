<!doctype html>
<html>
    <meta charset="utf-8"/>
    <head>
        <title>PHP Test</title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    </head>
    <body ng-app="app">

        <!-- Content -->
        <div class="container">

            <?php echo $content_for_layout ?>

            <footer>
                <div class="row">
                  <div class="col-lg-12">
                    <p>Made by <a href="http://github.com/Agnostic">Gilberto Avalos</a> (<a href="mailto:avalosagnostic@gmail.com">avalosagnostic@gmail.com</a>).</p>
                    <p>Source code @ <a href="https://github.com/Agnostic/ci-customer-list">https://github.com/Agnostic/ci-customer-list</a>.
                  </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script type="text/javascript" src="assets/js/libs/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="assets/js/libs/underscore-min.js"></script>
        <script type="text/javascript" src="assets/js/libs/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/libs/angular.min.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>
    </body>
</html>