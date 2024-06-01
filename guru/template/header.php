<ul class="navbar-nav navbar-align">
    <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
            <div class="position-relative">
                <i class="align-middle" data-feather="bell"></i>
                <span class="indicator">0</span>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
            <div class="dropdown-menu-header">
                0 Notifications
            </div>
            <div class="list-group">

            </div>
        </div>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
            <i class="align-middle" data-feather="settings"></i>
        </a>

        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
            <span class="text-dark"><?= $user['nama']; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
            <a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings</a>
            <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
            <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="../../logout.php">
                <div style="color: black;">Log out</div>
            </a>
        </div>
    </li>
</ul>