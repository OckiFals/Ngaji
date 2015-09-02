<?php
/**
 * @var String $title
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <?php echo Html::load('css', 'bootstrap.min.css') ?>
    <?php echo Html::load('css', 'font-awesome.min.css') ?>
    <!-- Font Awesome Icons -->
    <!-- Theme style -->
    <?php echo Html::load('css', 'dist/AdminLTE.min.css') ?>
    <!-- iCheck -->
    <?php echo Html::load('css', 'plugins/iCheck/square/blue.css') ?>
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Mc</b>LOGIN</a>
    </div>
    <?php if (Ngaji\Http\Session::flash()->has('flash-message')) : ?>
        <div class="alert alert-danger alert-dismissable" id="flash-message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            <?php echo Ngaji\Http\Session::flash()->pop('flash-message') ?>
        </div>
        <script>
            window.setTimeout( hideFlashMessage, 8000);

            function hideFlashMessage(){
                $('#flash-message').fadeOut('normal');
            }
        </script>
    <?php endif ?>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php echo Html::form_begin('login', 'POST', [
            'id' => 'login-form',
            'novalidate' => 'novalidate'
        ]) ?>
        <div class="form-group has-feedback">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <input id="id_username" name="username" type="text" class="form-control" placeholder="ID"
                   required="true"/>
        </div>
        <div class="form-group has-feedback">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <input id="id_password" name="password" type="password" class="form-control"
                   placeholder="Password" required="true"/>
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
        <?php echo Html::form_end() ?>

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
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>demo</td>
                    <td>demo</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.3 -->
<?php echo Html::load('js', 'plugins/jQuery/jQuery-2.1.3.min.js') ?>
<!-- Bootstrap 3.3.2 JS -->
<?php echo Html::load('js', 'bootstrap.min.js') ?>
<!-- iCheck -->
<?php echo Html::load('js', 'plugins/iCheck/icheck.min.js') ?>
<?php echo Html::load('js', 'dist/app.min.js') ?>
<?php echo Html::load('js', 'plugins/validate/jquery.validate.min.js') ?>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $("#login-form").validate({

            // Specify the validation rules
            rules: {
                username: "required",
                password: {
                    required: true,
                    minlength: 4
                }
            },

            // Specify the validation error messages
            messages: {
                username: "Please enter your username",
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
</body>
</html>