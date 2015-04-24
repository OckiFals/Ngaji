<? if (Ngaji\Http\Request::is_manager()): ?>
    <!-- Logo -->
    <a href="<?= 'index.php' ?>" class="logo"><b>Mararisah</b>LTE</a>

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= Html::loadIMG('user2-160x160.jpg', [
                            'class' => 'user-image',
                            'alt' => 'User Image'
                        ])
                        ?>
                        <span class="hidden-xs"><?= Ngaji\Http\Request::get_user('name') ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= Html::loadIMG('user2-160x160.jpg', [
                                'class' => 'img-circle',
                                'alt' => 'User Image'
                            ]) ?>
                            <p>
                                <?= Ngaji\Http\Request::get_user('username') ?> -
                                <?= Ngaji\Http\Request::get_user('type-display') ?>
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-5 text-center">
                                <a href="#">Ganti Paspor</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= HOSTNAME . '/profile' ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= HOSTNAME . '/logout' ?>"
                                   class="btn btn-default btn-flat">Sign Out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Header Navbar: style can be found in header.less -->

<? else: ?>
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?= 'index.php' ?>" class="navbar-brand"><b>Mararisah</b>CAFE</a>
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
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?=
                            # same as <img src="/manajemen_rersto/assets/img/avatar.png" class="user-image" alt="User Image"/>
                            Html::load('img', 'avatar.png', [
                                'class' => 'user-image',
                                'alt' => 'User Image'
                            ])
                            ?>
                            <span class=""><?= Ngaji\Http\Request::get_user('name') ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header hidden-xs">
                                <?= Html::load('img', 'avatar.png', [
                                    'class' => 'img-circle',
                                    'alt' => 'User Image'
                                ])
                                ?>

                                <p>
                                    <?= Ngaji\Http\Request::get_user('username') ?>
                                    <small><?= Ngaji\Http\Request::get_user('type-display') ?></small>
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
                                    <?= Html::anchor('/profile', 'Profile', [
                                        'class' => [
                                            'btn',
                                            'btn-default',
                                            'btn-flat'
                                        ]
                                    ])
                                    ?>
                                </div>
                                <div class="pull-right">
                                    <?= Html::anchor('/logout', 'Sign out', [
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
                                <?= Html::anchor('/profile', 'Profile') ?>
                            </li>
                            <li class="hidden-lg hidden-md hidden-sm">
                                <?= Html::anchor('/logout', 'Logout') ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
<? endif ?>