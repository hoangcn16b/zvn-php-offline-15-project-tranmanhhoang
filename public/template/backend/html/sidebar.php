<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="<?= URL::createLink($this->arrParams['module'], 'index', 'index') ?>" class="brand-link">
        <img src="<?= $this->_pathImg ?>logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Admin Control Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $this->_pathImg ?>avatar.jpg" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="<?= URL::createLink($this->arrParams['module'], 'index', 'profile') ?>" class="d-block"><?= $this->arrParams['userLogged']['fullname'] ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= URL::createLink('backend', 'index', 'index') ?>" class="nav-link index-index">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <!-- index.php?module=backend&controller=Group&action=index -->
                    <a href="#" class="nav-link group-index">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Group
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= URL::createLink('backend', 'group', 'index') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL::createLink('backend', 'group', 'form') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- index.php?module=backend&controller=user&action=index -->
                <li class="nav-item ">
                    <a href="#" class="nav-link user-index">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= URL::createLink('backend', 'user', 'index') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL::createLink('backend', 'user', 'form') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link category-index">
                        <i class="nav-icon fas fa-thumbtack"></i>
                        <p>
                            Category
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= URL::createLink($this->arrParams['module'], 'category', 'index') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL::createLink($this->arrParams['module'], 'category', 'form') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link book-index">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Book
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= URL::createLink($this->arrParams['module'], 'book', 'index') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL::createLink($this->arrParams['module'], 'book', 'form') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item user-myPassword">
                    <a href="<?= URL::createLink('backend', 'user', 'myPassword') ?>" class="nav-link user-myPassword">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Change My Password
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>