<?php
use Ngaji\Http\Request;

?>
<nav class="navbar navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="<?php echo HOSTNAME ?>" class="navbar-brand"><b>My</b>Company</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <!-- for authenticated user -->
                <?php if (Request::is_authenticated()): ?>
                    <li>
                        <?php echo Html::anchor('/accounts', '<span class="glyphicon glyphicon-edit"> Accounts</span>', [
                            'class' => 'dropdown-toggle btn bg-olive btn-flat'
                        ]) ?>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo
                                # same as <img src="/manajemen_rersto/assets/img/avatar.png" class="user-image" alt="User Image"/>
                            Html::load('img', '1.png', [
                                'class' => 'user-image',
                                'alt' => 'User Image'
                            ])
                            ?>
                            <span class=""><?php echo Request::user('name') ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header hidden-xs">
                                <?php echo Html::load('img', '1.png', [
                                    'class' => 'img-circle',
                                    'alt' => 'User Image'
                                ])
                                ?>

                                <p>
                                    <?php echo Ngaji\Http\Request::user('username') ?>
                                    <small><?php echo Ngaji\Http\Request::user('type-display') ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body hidden-xs">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer hidden-xs">
                                <div class="pull-left">
                                    <?php echo Html::anchor('#', 'Profile', [
                                        'class' => [
                                            'btn',
                                            'btn-default',
                                            'btn-flat'
                                        ]
                                    ])
                                    ?>
                                </div>
                                <div class="pull-right">
                                    <?php echo Html::anchor('/logout', 'Sign out', [
                                        'class' => [
                                            'btn',
                                            'btn-default',
                                            'btn-flat'
                                        ]
                                    ])
                                    ?>
                                </div>
                            </li>

                            <li class="hidden-lg hidden-md hidden-sm">
                                <?php echo Html::anchor('#', 'Profile') ?>
                            </li>
                            <li class="hidden-lg hidden-md hidden-sm">
                                <?php echo Html::anchor('/logout', 'Logout') ?>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- for guest -->
                    <li>
                        <?php echo Html::anchor('/login', '<span class="glyphicon glyphicon-user"> Login</span>', [
                            'class' => 'dropdown-toggle btn bg-olive btn-flat'
                        ]) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>