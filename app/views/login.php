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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 3.3.2 -->
    <?php echo Html::load('css', 'bootstrap.min.css') ?>
    <?php echo Html::load('css', 'style.css') ?>
</head>
<body>
<div class="container">
    <?php echo Html::form_begin('login', 'POST', [
        'id' => 'login-form',
        'class' => 'form-signin'
    ]) ?>
    <h2 class="form-signin-heading">Please sign in</h2>
    <?php if (Ngaji\Http\Session::flash()->has('flash-message')) : ?>
        <div class="alert alert-danger alert-dismissable" id="flash-message" role="alert">
            <span>
                <?php echo Ngaji\Http\Session::flash()->pop('flash-message') ?>
            </span>
        </div>
        <script>
            window.setTimeout(hideFlashMessage, 8000);
            function hideFlashMessage() {
                $('#flash-message').fadeOut('normal');
            }
        </script>
    <?php endif ?>
    <label class="sr-only">Username</label>
    <input type="text" class="form-control" placeholder="Username" name="username" required>
    <label class="sr-only">Password</label>
    <input type="password" class="form-control" placeholder="Password" name="password" required>
    <div class="checkbox">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <div class="box box-default collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Demo Accounts</h3>
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
    <?php echo Html::form_end() ?>
</div>

<!-- jQuery 2.1.3 -->
<?php echo Html::load('js', 'jquery.min.js') ?>
<!-- Bootstrap 3.3.2 JS -->
<?php echo Html::load('js', 'bootstrap.min.js') ?>
</body>
</html>