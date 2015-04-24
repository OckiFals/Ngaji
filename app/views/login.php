<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MararisahCAFE | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <?= Html::load('css', 'bootstrap.min.css') ?>
    <?= Html::load('css', 'font-awesome.min.css') ?>
    <!-- Font Awesome Icons -->
    <!-- Theme style -->
    <?= Html::load('css', 'dist/AdminLTE.min.css') ?>
    <!-- iCheck -->
    <?= Html::load('css', 'plugins/iCheck/square/blue.css') ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Mc</b>LOGIN</a>
    </div>
    <!-- /.login-logo -->
    <? if (isset($message)): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            Authenticated failure!
        </div>
    <? endif ?>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="<?= HOSTNAME . "/login"?>" method="post">
            <div class="form-group has-feedback">
                <input id="id_username" name="username" type="text" class="form-control" placeholder="ID"
                       required="true"/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="id_password" name="password" type="password" class="form-control"
                       placeholder="Password" required="true"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="#">I forgot my password</a><br>

    </div>
    <!-- /.login-box-body -->
    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Demo Accounts</h3>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <span>Manager  : root</span><br/>
            <span>Chef     : chef_juna</span><br/>
            <span>Waitress : pelayan</span><br/>
            <span>Cashier  :</span><br/>

            <span>Pass: admin</span><br/>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.3 -->
<?= Html::load('js', 'plugins/jQuery/jQuery-2.1.3.min.js') ?>
<!-- Bootstrap 3.3.2 JS -->
<?= Html::load('js', 'bootstrap.min.js') ?>
<!-- iCheck -->
<?= Html::load('js', 'plugins/iCheck/icheck.min.js') ?>

<?= Html::load('js', 'dist/app.min.js') ?>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>