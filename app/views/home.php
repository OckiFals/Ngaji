<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Ngaji App</title>
    <?php echo Ngaji\view\View::makeHead() ?>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body>
<div class="wrapper">
    <header class="main-header">
        <?php echo Ngaji\view\View::makeHeader() ?>
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Web System
                    <small> 2.1</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                </ol>
            </section>
            <!-- Main content -->

            <div class="jumbotron">
                <h1>Congratulations!</h1>

                <p class="lead">You have successfully created your Ngaji-powered application.</p>

                <p>
                    <?php echo Html::anchor('https://www.github.com/OckiFals', 'Get started with Ngaji', [
                        'class' => "btn btn-lg btn-success"
                    ])?>
                </p>
            </div>

            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-lg-4">
                            <h2>Heading</h2>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut
                                labore et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                nisi
                                ut aliquip
                                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu
                                fugiat nulla pariatur.</p>

                            <p><a class="btn btn-default" href="#">Link One &raquo;</a></p>
                        </div>
                        <div class="col-lg-4">
                            <h2>Heading</h2>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut
                                labore et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                nisi
                                ut aliquip
                                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu
                                fugiat nulla pariatur.</p>

                            <p><a class="btn btn-default" href="#">Link Two &raquo;</a>
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <h2>Heading</h2>

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut
                                labore et
                                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                nisi
                                ut aliquip
                                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu
                                fugiat nulla pariatur.</p>

                            <p><a class="btn btn-default" href="#">Link Three &raquo;</a></p>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
            </section>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.content-wrapper -->
    <?php echo Ngaji\view\View::makeFooter() ?>
</div>
<!-- ./wrapper -->
</body>
</html>