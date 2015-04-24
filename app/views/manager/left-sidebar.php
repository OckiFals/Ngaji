<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <?= Html::loadIMG('user2-160x160.jpg', [
                'class' => 'img-circle',
                'alt' => 'User Image'
            ])
            ?>
        </div>
        <div class="pull-left info">
            <p><?= Ngaji\Http\Request::get_user('name') ?></p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
            <a href="<?= HOSTNAME . '/index.php' ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Sales Summary</span>
                <span class="label label-primary pull-right">4</span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Contoh</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-users"></i>
                <span>Accounts</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="#"><i class="fa fa-circle-o"></i> Managers <i
                            class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Manage Managers</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i> Add Managers</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-circle-o"></i> Chefs <i
                            class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Manage Chefs</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i> Add Chefs</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-circle-o"></i> Waitress <i
                            class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Manage Waitress</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i> Add Waitress</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-circle-o"></i> Cashiers <i
                            class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Manage Cashiers</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i> Add Cashiers</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-cutlery"></i> <span>Menus</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="#">
                        <i class="fa fa-cutlery"></i> Foods
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= HOSTNAME . '/index.php/manage-menus' ?>">
                                <i class="fa fa-sitemap"></i> Manage Foods
                            </a>
                        </li>
                        <li><a href="#"><i class="fa fa-plus-square"></i> Add Foods</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-glass"></i> Drinks <i
                            class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="<?= HOSTNAME . '/index.php/manage-menus' ?>">
                                <i class="fa fa-sitemap"></i> Manage Drinks
                            </a>
                        </li>
                        <li><a href="#"><i class="fa fa-plus-square"></i> Add Drinks</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-shopping-cart"></i> <span>Orders</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>

            </ul>
        </li>
    </ul>
</section>
<!-- /.sidebar -->