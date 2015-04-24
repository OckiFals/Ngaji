<!DOCTYPE html>
<html lang="ID">
<head>
    <title>Mararisah Admin</title>
    <?= Ngaji\view\View::makeHead() ?>
    <!-- Morris chart -->
    <?= Html::load('css', 'plugins/morris/morris.css') ?>
    <!-- jvectormap -->
    <?= Html::load('css', 'plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>
    <!-- Daterange picker -->
    <?= Html::load('css', 'plugins/daterangepicker/daterangepicker-bs3.css') ?>
</head>

<body class="skin-blue">
<div class="wrapper">

    <header class="main-header">
        <?= Ngaji\view\View::makeHeader() ?>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <? Ngaji\view\View::render('manager/left-sidebar') ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Menus
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?= HOSTNAME . '/index.php' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Dashboard</li>
                <li class="active">Manage Menus</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content -->
            <div id="content" class="colM">
                <!--                <h1>Dashboard</h1>-->
                <br class="clear"/>
            </div>
            <!-- END Content -->

            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Foods</h3>

                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Locality</th>
                                        <th>Popularity</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach ($foods as $food) : ?>
                                        <tr>
                                            <td><a href="pages/examples/invoice.html"><?= $food['id'] ?></a></td>
                                            <td><a href="pages/examples/invoice.html"><?= $food['name'] ?></a></td>
                                            <td><span class="label label-success"><?= $food['locality'] ?></span></td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                    90,80,90,-70,61,-83,63
                                                </div>
                                            </td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="blue" href="#">
                                                        <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                    </a>

                                                    <a class="green" href="#">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>

                                                    <a class="red" href="#">
                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                    </a>
                                                </div>

                                                <div class="hidden-md hidden-lg">
                                                    <div class="inline pos-rel">
                                                        <button class="btn btn-minier btn-yellow dropdown-toggle"
                                                                data-toggle="dropdown"
                                                                data-position="auto">
                                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                            <li>
                                                                <a href="#" class="tooltip-info" data-rel="tooltip"
                                                                   title="View">
	                                            <span class="blue">
	                                                <i class="ace-icon fa fa-search-plus bigger-120"></i>
	                                            </span>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" class="tooltip-success" data-rel="tooltip"
                                                                   title="Edit">
	                                            <span class="green">
	                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
	                                            </span>
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a href="#" class="tooltip-error" data-rel="tooltip"
                                                                   title="Delete">
	                                            <span class="red">
	                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
	                                            </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <? endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                            <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All
                                Orders</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.3 -->
<?= Html::load('js', 'plugins/jQuery/jQuery-2.1.3.min.js') ?>
<!-- Bootstrap 3.3.2 JS -->
<?= Html::load('js', 'bootstrap.min.js') ?>
<!-- FastClick -->
<?= Html::load('js', 'plugins/fastclick/fastclick.min.js') ?>
<!-- AdminLTE App -->
<?= Html::load('js', 'dist/app.min.js') ?>
<!-- Sparkline -->
<?= Html::load('js', 'plugins/sparkline/jquery.sparkline.min.js') ?>
<!-- jvectormap -->
<?= Html::load('js', 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') ?>
<?= Html::load('js', 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js') ?>
<!-- daterangepicker -->
<?= Html::load('js', 'plugins/daterangepicker/daterangepicker.js') ?>
<!-- datepicker -->
<?= Html::load('js', 'plugins/datepicker/bootstrap-datepicker.js') ?>
<!-- iCheck -->
<?= Html::load('js', 'plugins/iCheck/icheck.min.js') ?>
<!-- SlimScroll 1.3.0 -->
<?= Html::load('js', 'plugins/slimScroll/jquery.slimscroll.min.js') ?>
<!-- ChartJS 1.0.1 -->
<?= Html::load('js', 'plugins/chartjs/Chart.min.js') ?>
</body>
</html>