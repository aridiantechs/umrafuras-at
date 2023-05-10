<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Umraha Furas MIS - Dashboard</title>
    <link rel="icon" type="image/x-icon" href="<?= $template ?>assets/img/favicon.ico"/>
    <link href="<?= $template ?>assets/css/loader.css" rel="stylesheet" type="text/css"/>
    <script src="<?= $template ?>assets/js/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= $template ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $template ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?= $template ?>assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css"/>
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/table/datatable/dt-global_style.css">
    <link href="<?= $template ?>assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link href="<?= $template ?>assets/css/components/custom-modal.css" rel="stylesheet" type="text/css" />
    <link href="<?= $template ?>assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <script src="<?= $template ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?= $template ?>bootstrap/js/popper.min.js"></script>
    <script src="<?= $template ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= $template ?>plugins/table/datatable/datatables.js"></script>
    <script type="text/javascript" charset="utf-8">
        localStorage.setItem('path', '<?=$path?>');
        localStorage.setItem('template', '<?=$template?>');
    </script>
</head>
<body>
<!-- BEGIN LOADER -->
<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>
<!--  END LOADER -->

<!--  BEGIN NAVBAR  -->
<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="<?= $path ?>">
                    <img src="<?= $template ?>assets/img/90x90.jpg" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="<?= $path ?>" class="nav-link"> Umrah Furas MIS</a>
            </li>
        </ul>


        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown language-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?= $template ?>assets/img/ca.png" class="flag-width" alt="flag">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                    <a class="dropdown-item d-flex" href="javascript:void(0);"><img
                                src="<?= $template ?>assets/img/de.png" class="flag-width" alt="flag"> <span
                                class="align-self-center">&nbsp;German</span></a>
                    <a class="dropdown-item d-flex" href="javascript:void(0);"><img
                                src="<?= $template ?>assets/img/jp.png" class="flag-width" alt="flag"> <span
                                class="align-self-center">&nbsp;Japanese</span></a>
                    <a class="dropdown-item d-flex" href="javascript:void(0);"><img
                                src="<?= $template ?>assets/img/fr.png" class="flag-width" alt="flag"> <span
                                class="align-self-center">&nbsp;French</span></a>
                    <a class="dropdown-item d-flex" href="javascript:void(0);"><img
                                src="<?= $template ?>assets/img/ca.png" class="flag-width" alt="flag"> <span
                                class="align-self-center">&nbsp;English</span></a>
                </div>
            </li>

            <li class="nav-item dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="badge badge-success"></span>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    <div class="notification-scroll"><?php
                        for ($a = 1; $a < 10; $a++) {
                            echo '
                            <div class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="notification-para"><span class="user-name">Visa ID: ' . rand(1234, 5678) . '</span> processed.
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        } ?>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src="<?= $template ?>assets/img/90x90.jpg" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a href="<?= $path ?>user/profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                My Profile</a>
                        </div>
                        <div class="dropdown-item">
                            <a href="<?= $path ?>home/login">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Sign Out</a>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </header>
</div>
<!--  END NAVBAR  -->
<!--  BEGIN NAVBAR  -->
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-menu">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">

                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Sales</span></li>
                        </ol>
                    </nav>

                </div>
            </li>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->
<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
    <div class="overlay"></div>
    <div class="search-overlay"></div>

<?php echo view("navigation/admin") ?>