<?php
/**
 * @var String $title
 * @var \Ngaji\Database\NgajiStdClass $accounts
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
    <div class="content-wrapper" style="min-height: 560px">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Web System
                    <small> 2.1</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Account</li>
                </ol>
            </section>
            <!-- Main content -->

            <div class="content body">
                <!-- title row -->
                <div class="row">
                    <?php if (Ngaji\Http\Session::flash()->has('flash-message')): ?>
                        <div class="col-md-12" id="flash-message">
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check-square-o"></i> Info!</h4>
                                <?php echo Ngaji\Http\Session::flash()->pop('flash-message') ?>
                            </div>
                        </div>
                        <script>
                            window.setTimeout(hideFlashMessage, 8000);

                            function hideFlashMessage() {
                                $('#flash-message').fadeOut('normal');
                            }
                        </script>
                    <?php endif; ?>

                    <div class="col-md-12">
                        <div class="box box-info">
                            <?php echo Html::anchor('/accounts/add', '<iclass="fa fa-plus"></i> Add New', [
                                'class' => 'btn btn-info btn-sm btn-flat'
                            ]) ?>
                            <div class="box-header with-border">
                                <h3 class="box-title">Accounts</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped no-margin">
                                        <tbody>
                                        <tr>
                                            <th style="width: 30px">ID</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>City</th>
                                            <th>Created Add</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php foreach ($accounts as $account): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $account->id ?>
                                                </td>
                                                <td>
                                                    <?php echo Html::loadIMG($account->photo, [
                                                        'alt' => 'account image',
                                                        'class' => 'img-responsive img-circle center-block',
                                                        'width' => '40',
                                                        'height' => '40'
                                                    ])
                                                    ?>
                                                <span
                                                    style="text-align: center" class="center-block">
                                                    @<?php echo $account->username ?>
                                                </span>
                                                </td>
                                                <td>
                                                    <?php echo $account->name ?>
                                                </td>
                                                <td>
                                                    <?php echo $account->city->name ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary"><i class="fa fa-eye">
                                                        </i> <?= date_format_id($account->created_at) ?>
                                                </span>
                                                </td>
                                                <td>
                                                    <?= Html::anchor("#",
                                                        '<i class="fa fa-trash-o"></i> Delete', [
                                                            'class' => 'btn btn-xs btn-flat btn-danger',
                                                            'data-post-id' => $account->id,
                                                            'data-type-modal' => 'User',
                                                            'data-post-title' => $account->name,
                                                            'data-href' => sprintf(
                                                                "%s/accounts/delete/%d",
                                                                HOSTNAME, $account->id
                                                            ),
                                                            'data-toggle' => "modal",
                                                            'data-target' => "#confirm-delete"
                                                        ]
                                                    ) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
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