        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>PEMINATAN ILMU KOMPUTER</h3>
                <strong>PIK</strong>
            </div>

            <ul class="list-unstyled components">
            <?php if($title_topbar == 'DASHBOARD ADMIN') : ?>
                <li class="active">
            <?php else : ?>
                <li class="nav-item">
            <?php endif; ?>
                    <a href="<?= base_url('admin/dashboard') ?>">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>

            <?php if($title_topbar == 'DATA USERS') : ?>
                <li class="active">
            <?php else : ?>
                <li class="nav-item">
            <?php endif; ?>
                    <a href="<?= base_url('admin/users') ?>">
                        <i class="fas fa-users"></i>
                        Data Users
                    </a>
                </li>

            <?php if($title_topbar == 'DATA SAW') : ?>
                <li class="active">
            <?php else : ?>
                <li class="nav-item">
            <?php endif; ?>
                    <a href="<?= base_url('admin/saw') ?>">
                        <i class="fas fa-cogs"></i>
                        Data SAW
                    </a>
                </li>

            <?php if($title_topbar == 'PROFIL PENGEMBANG') : ?>
                <li class="active">
            <?php else : ?>
                <li class="nav-item">
            <?php endif; ?>
                    <a href="<?= base_url('admin/pengembang') ?>">
                        <i class="fas fa-code"></i>
                        Developer
                    </a>
                </li>
            </ul>
        </nav>