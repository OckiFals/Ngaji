<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order</title>
    {% block head %}
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="skin-blue layout-top-nav">
<div class="wrapper">

    <header class="main-header">
        {% block header %}
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Web System
                    <small> 1.0</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Foods</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <form action="add-order" method="POST">
                                <table class="table table-hover table-responsive">
                                    <tbody>
                                    <tr>
                                        <th width=40>#</th>
                                        <th>Name</th>
                                        <th>Popularity</th>
                                        <th>Locality</th>
                                        <th>Price</th>
                                        <th colspan="1">Order</th>
                                    </tr>
                                    <? $counter = 0 ?>
                                    <? foreach ($foods as $food): ?>
                                        <tr>
                                            <td><?= ++$counter ?></td>
                                            <td>
                                                <label for="id_<?= $food['id'] ?>">
                                                    <?= $food['name'] ?>
                                                </label>
                                            </td>
                                            <td>-</td>
                                            <td><span class="label label-success"><?= $food['locality'] ?></span>
                                            </td>
                                            <td><?= $food['price'] ?></td>
                                            <td>
                                                <label for="id_form-<?= $food['id'] ?>-extras">
                                                    <input id="id_form-<?= $food['id'] ?>-extras"
                                                           class="form-control col-xs-4"
                                                           name="form-<?= $food['id'] ?>-extras"
                                                           placeholder="Extras"
                                                           type="text"/>
                                                </label>

                                                <label for="id_form-<?= $food['id'] ?>-qty">
                                                    <input id="id_form-<?= $food['id'] ?>-qty" max="10" min="0"
                                                           class="form-control  col-xs-2"
                                                           name="form-<?= $food['id'] ?>-qty"
                                                           type="number" value="0"/>
                                                </label>
                                            </td>
                                        </tr>
                                    <? endforeach ?>
                                    </tbody>
                                </table>
                                <div class="input pull-right">
                                    <button type="submit" class="btn btn-block btn-flat">Add</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box-body -->
                </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Drinks</h3>

                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: block;">
                        None
                    </div>
                    <!-- /.box-body -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="container-fluid">
            <div class="pull-right hidden-xs">
                <a>Made By <i>Ngaji 2.0, AngularJS</i> and <i class="fa fa-heart"></i></a>
            </div>
            <strong>Copyright &copy;<a>OckiFals</a>.</strong> All
            rights reserved.
        </div>
        <!-- /.container -->
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.3 -->
<?= Html::load('js', 'plugins/jQuery/jQuery-2.1.3.min.js') ?>
<!-- Bootstrap 3.3.2 JS -->
<?= Html::load('js', 'bootstrap.min.js') ?>
<!-- SlimScroll -->
<?= Html::load('js', 'plugins/slimScroll/jquery.slimscroll.min.js') ?>
<!-- FastClick -->
<?= Html::load('js', 'plugins/fastclick/fastclick.min.js') ?>
<!-- AdminLTE App -->
<?= Html::load('js', 'dist/app.min.js') ?>
</body>
</html>