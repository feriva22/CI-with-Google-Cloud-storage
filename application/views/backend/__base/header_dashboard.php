<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $page_title.' - '.$this->config->item('site_info');?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="<?php echo base_url();?>assets/img/default/favicon.ico" type="image/x-icon" />

        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/font_load.css">
        
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/icon-kit/dist/css/iconkit.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/ionicons/dist/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-toast/css/jquery.toast.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/summernote/summernote-bs4.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-select/css/bootstrap-select.css" />  
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">      
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/theme.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jquery-confirm/jquery-confirm.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap4-toggle/bootstrap4-toggle.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-tokenfield/bootstrap-tokenfield.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-tokenfield/tokenfield-typeahead.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datedropper/datedropper.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/Print.js/print.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/custom.css">

    </head>

    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="wrapper <?php echo isset($collapsed_sidebar) && $collapsed_sidebar ? 'nav-collapsed menu-collapsed' : '';?>">
            <header class="header-top" header-theme="light">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                        </div>
                        <div class="top-menu d-flex align-items-center">

                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="avatar" src="<?php echo base_url();?>assets/img/default/user-logo.jpg" alt="">
                                <?php echo strtoupper($this->session->userdata('userName'));?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
									<?php if($this->session->userdata('userName') !== 'root'):?>
                                    <a class="dropdown-item" id="chg_passwordbtn" href="javascript:void(0)"><i class="ik ik-lock dropdown-icon"></i> Ubah Password</a>
									<?php endif;?>
                                    <a class="dropdown-item" href="<?php echo base_url();?>backend/login/logout"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </header>