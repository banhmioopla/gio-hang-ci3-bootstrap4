<?php 
	$js_plugins_path = base_url().'js-plugins/';
	$assets_path  = base_url().'assets/';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>SinvaTour | Hệ thống quản lý phòng nội bộ </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= $assets_path ?>images/favicon.png" />
        <!-- DataTables -->
        <link href="<?= $js_plugins_path ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Custom box css -->
        <link href="<?= $js_plugins_path ?>custombox/css/custombox.min.css" rel="stylesheet" />
        <link href="<?= $js_plugins_path ?>bootstrap-xeditable/css/bootstrap-editable.css" rel="stylesheet" />
        <link href="<?= $js_plugins_path ?>sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- Spinkit css -->
        <link href="<?= $js_plugins_path ?>spinkit/spinkit.css" rel="stylesheet" />

        <!--venobox lightbox-->
        <link rel="stylesheet" href="<?= $js_plugins_path ?>magnific-popup/css/magnific-popup.css" />
        <!-- App css -->
        <link href="<?= $assets_path ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $assets_path ?>css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?= $assets_path ?>css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?= $assets_path ?>css/custom.css" rel="stylesheet" type="text/css" />
		<script src="<?= $assets_path ?>js/modernizr.min.js"></script>
		<script>
            let commands = [];
            let modify_mode = '<?= $this->auth['modifymode'] ? $this->auth['modifymode']: 'view' ?>';
            let notify_html_success = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Cập nhật thành công
                </div>`;
            let notify_html_fail = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Cập nhật thất bại
                </div>`;
		</script>
        <style type="text/css" media="screen">
            .apm-update-time {
                font-size: 0.85em;
            }
        </style>
    </head>
    <body>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">
                    <!-- Logo container-->
                    <div class="logo">
                        <!-- Text Logo -->
                        <!-- <a href="index.html" class="logo"><span class="logo-small"><i class="mdi mdi-radar"></i></span><span class="logo-large"><i class="mdi mdi-radar"></i> Highdmin</span></a> -->
                        <!-- Image Logo -->
                        <a href="index.html" class="logo">
                            <img src="<?= $assets_path ?>images/logo_sm.png" alt="" height="26" class="logo-small" />
                            <img src="<?= $assets_path ?>images/logo-gh.png" alt="" height="22" class="logo-large" />
                        </a>
                    </div>
                    <!-- End Logo container-->
                    <div class="menu-extras topbar-custom">
                        <ul class="list-unstyled topbar-right-menu float-right mb-0">
                            <li class="menu-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
                            <li class="dropdown notification-list hide-phone">
                                <!-- <a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="mdi mdi-earth"></i> English
                                    <i class="mdi mdi-chevron-down"></i>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <!-- <a href="javascript:void(0);" class="dropdown-item">
                                        Spanish
                                    </a> -->
                                    <!-- item-->
                                    <!-- <a href="javascript:void(0);" class="dropdown-item">
                                        Italian
                                    </a> -->
                                    <!-- item-->
                                    <!-- <a href="javascript:void(0);" class="dropdown-item">
                                        French
                                    </a> -->
                                    <!-- item-->
                                    <!-- <a href="javascript:void(0);" class="dropdown-item">
                                        Russian
                                    </a> -->
                                </div>
                            </li>
                            <li class="dropdown notification-list">
                                <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="fi-bell noti-icon"></i>
                                    <span class="badge badge-danger badge-pill noti-icon-badge">4</span>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                                    <!-- item-->
                                    <!-- <div class="dropdown-item noti-title">
                                        <h6 class="m-0">
                                            <span class="float-right">
                                                <a href="" class="text-dark">
                                                    <small>x</small>
                                                </a>
                                            </span>
                                            Thông báo
                                        </h6>
                                    </div> -->
                                    <div class="slimscroll" style="max-height: 230px;">
                                        <!-- item-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-success">
                                                <i class="mdi mdi-comment-account-outline"></i>
                                            </div>
                                            <p class="notify-details">
                                                Caleb Flakelar commented on Admin
                                                <small class="text-muted">1 min ago</small>
                                            </p>
                                        </a> -->
                                        <!-- item-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-info">
                                                <i class="mdi mdi-account-plus"></i>
                                            </div>
                                            <p class="notify-details">
                                                New user registered.
                                                <small class="text-muted">5 hours ago</small>
                                            </p>
                                        </a> -->
                                        <!-- item-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-danger">
                                                <i class="mdi mdi-heart"></i>
                                            </div>
                                            <p class="notify-details">
                                                Carlos Crouch liked
                                                <b>Admin</b>
                                                <small class="text-muted">3 days ago</small>
                                            </p>
                                        </a> -->
                                        <!-- item-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-warning">
                                                <i class="mdi mdi-comment-account-outline"></i>
                                            </div>
                                            <p class="notify-details">
                                                Caleb Flakelar commented on Admin
                                                <small class="text-muted">4 days ago</small>
                                            </p>
                                        </a> -->
                                        <!-- item-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-purple">
                                                <i class="mdi mdi-account-plus"></i>
                                            </div>
                                            <p class="notify-details">
                                                New user registered.
                                                <small class="text-muted">7 days ago</small>
                                            </p>
                                        </a> -->
                                        <!-- item-->
                                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-custom">
                                                <i class="mdi mdi-heart"></i>
                                            </div>
                                            <p class="notify-details">
                                                Carlos Crouch liked
                                                <b>Admin</b>
                                                <small class="text-muted">13 days ago</small>
                                            </p>
                                        </a> -->
                                    </div>
                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View all
                                        <i class="fi-arrow-right"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="dropdown notification-list">
                                <!-- <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="fi-speech-bubble noti-icon"></i>
                                    <span class="badge badge-dark badge-pill noti-icon-badge">6</span>
                                </a> -->
                                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="m-0">
                                            <span class="float-right">
                                                <a href="" class="text-dark">
                                                    <small>Clear All</small>
                                                </a>
                                            </span>
                                            Chat
                                        </h6>
                                    </div>
                                    <div class="slimscroll" style="max-height: 230px;">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/batman-anim-1.gif" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Cristina Pride</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Hi, How are you? What about our next meeting</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-3.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Sam Garret</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Yeah everything is fine</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-4.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Karen Robinson</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Wow that's great</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-5.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Sherry Marshall</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Hi, How are you? What about our next meeting</p>
                                        </a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon">
                                                <img src="<?= $assets_path ?>images/users/avatar-6.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <p class="notify-details">Shawn Millard</p>
                                            <p class="text-muted font-13 mb-0 user-msg">Yeah everything is fine</p>
                                        </a>
                                    </div>
                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View all
                                        <i class="fi-arrow-right"></i>
                                    </a>
                                </div>
                            </li>
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="<?= $assets_path ?>images/users/batman-anim-1.gif" alt="user" class="rounded-circle" />
                                    <span class="ml-1 pro-user-name">
                                        <?= $this->session->auth['name'] ?>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">sinva.vn</h6>
                                    </div>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fi-head"></i>
                                        <span>Tài khoản</span>
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fi-cog"></i>
                                        <span>Cài đặt</span>
                                    </a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="fi-help"></i>
                                        <span>Hỗ trợ</span>
                                    </a>
                                    <!-- item-->
                                    <a href="<?= base_url().'admin/logout'?>" class="dropdown-item notify-item">
                                        <i class="fi-power"></i>
                                        <span>Đăng xuất</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- end menu-extras -->
                    <div class="clearfix"></div>
                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <?php $this->load->view('components/menu', ['menu' => $menu])?>
            <!-- end navbar-custom -->
        </header>