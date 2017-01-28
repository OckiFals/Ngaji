<?php
/**
 * @var String $title
 * @var \Ngaji\Database\NgajiStdClass $accounts
 * @var \Ngaji\Database\NgajiStdClass $cities
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <?php echo Ngaji\view\View::makeHead() ?>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="skin-blue layout-top-nav">
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
                    <li>
                        <?php echo Html::anchor('/', 'Home', [
                            'class' => 'fa fa-dashboard'
                        ])?>
                    </li>
                    <li>
                        <?php echo Html::anchor('/accounts', 'Accounts') ?>
                    </li>
                    <li class="active">Account</li>
                </ol>
            </section>
            <!-- Main content -->

            <div class="content body">
                <!-- title row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Accounts</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="register-box-body">
                                    <p class="login-box-msg">Register a new membership</p>

                                    <?php echo Html::form_begin('', 'POST', [
                                        'enctype' => "multipart/form-data",
                                        'id' => "register-form"
                                    ])
                                    ?>
                                    <div class="form-group has-feedback">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Full name"
                                            required/>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                                            required/>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        <input type="password" id="password" class="form-control" placeholder="Password"
                                               required name="password"/>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <select name="city" class="form-control" required>
                                            <option value="0">-----</option>
                                            <?php foreach ($cities as $city) : ?>
                                                <option value="<?= $city->id ?>"><?php echo $city->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Uploads foto:</label>
                                        <input type="file" id="profile_picture" name="photo">
                                        <p class="help-block">Max 700KB</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-8">

                                        </div>
                                        <!-- /.col -->
                                        <div class="col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block btn-flat">Add</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <?php echo Html::form_end() ?>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">

                            </div>
                            <!-- /.box-footer -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <!-- /.row -->
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <?php echo Ngaji\view\View::makeFooter() ?>
</div>
<!-- ./wrapper -->
</body>
</html>