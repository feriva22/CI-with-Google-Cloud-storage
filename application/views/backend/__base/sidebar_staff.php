            <div class="page-wrap">
                <div class="app-sidebar colored">
                    <div class="sidebar-header">
                        <a class="header-brand" href="<?php echo base_url();?>backend/dashboard">
                            <span class="text">Sistem Backend</span>
                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="<?php echo isset($collapsed_sidebar) && $collapsed_sidebar ? 'collapsed' : 'expanded';?>" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>
                    <div class="sidebar-content">
                        <div class="nav-container">
                            <nav id="main-menu-navigation" class="navigation-main">
                                <div class="nav-item <?php echo $module_now == 'dashboard' ? 'active' : ''?>">
                                    <a href="<?php echo base_url();?>backend/dashboard"><i class="ik ik-home"></i><span>Dashboard</span></a>
                                </div>

                                <?php echo $sidebar;?>
                                <div class="nav-item">
                                    <a href="<?php echo base_url();?>backend/login/logout"><i class="ik ik-log-out"></i><span>Logout</span></a>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>