
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= URL ?>?req=home" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                <?= LANG['home'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= URL ?>?req=records" class="nav-link <?= $objHome->menu_active_class('records'); ?>">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                <?= LANG['cases'] ?>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?= $objHome->menu_treeview_class('default_reports', 'custom_reports'); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                <?= LANG['reports'] ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL ?>?req=default_reports" class="nav-link <?= $objHome->menu_active_class('default_reports'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p><?= LANG['default_reports'] ?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=custom_reports" class="nav-link <?= $objHome->menu_active_class('custom_reports'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p><?= LANG['custom_reports'] ?></p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?= $objHome->menu_treeview_class('profile', 'support_request', 'info'); ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-buffer"></i>
              <p>
                <?= LANG['others'] ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= URL ?>?req=profile" class="nav-link <?= $objHome->menu_active_class('profile'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p><?= LANG['my_user'] ?></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= URL ?>?req=info" class="nav-link <?= $objHome->menu_active_class('info'); ?>">
                  <i class="fas fa-chevron-right nav-icon"></i>
                  <p><?= LANG['info_sys'] ?></p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?= URL ?>?event=logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                <?= LANG['logout'] ?>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
