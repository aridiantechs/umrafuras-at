<?php

use App\Models\Users;

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width , initial-scale=1"/>
        <meta name="author" content="Orixes Tech. - www.orixestech.com">
        <meta name="web_author" content="Orixes Tech. - www.orixestech.com">
        <meta name="publisher" content="http://www.orixestech.com/">
        <meta name="copyright" content="http://www.orixestech.com/">
        <meta name="host" content="http://www.orixestech.com/">
        <meta name="distribution" content="global"/>
        <meta name="revisit" content="1 days">
        <meta name="Robots" content="index,follow">
        <meta name="google-site-verification" content="40yEqCJCf-4RnEFY3f9GvBKoiAknq9M-uSG-8I4NKn8"/>
        <meta name="description"
              content="For many years, Orixes Tech have been the source for some of the most outstanding websites and web applications available today on the World Wide Web. We build solutions that lead their industry and remain at the top for a long time.">
        <meta name="keywords"
              content="Home page, Web Development, Web developers, Web Design, Web App, SEO, IT Company, Rawalpindi, Islamabad, Cutting Edge Technologies">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title><?= $settings['site_name'] ?> - Dashboard</title>
        <link rel="icon" type="image/x-icon" href="<?= $path ?>template/<?= $domain_themes[$hostdomain]['logo'] ?>"/>
        <link href="<?= $template ?>assets/css/loader.css" rel="stylesheet" type="text/css"/>
        <script src="<?= $template ?>assets/js/loader.js"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="<?= $template ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $template ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $template ?>assets/css/structure.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $path ?>template/<?= $hostdomain ?>-custom.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/select2/select2.min.css">
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
        <link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/table/datatable/datatables.css">
        <link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/table/datatable/dt-global_style.css">
        <link href="<?= $template ?>assets/css/scrollspyNav.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $template ?>assets/css/components/custom-modal.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $template ?>assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet"
              type="text/css"/>
        <link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/forms/switches.css">
        <link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/forms/theme-checkbox-radio.css">
        <link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/widgets/modules-widgets.css">


        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- END PAGE LEVEL STYLES -->
        <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
        <script src="<?= $template ?>assets/js/libs/jquery-3.1.1.min.js"></script>
        <script src="<?= $template ?>bootstrap/js/popper.min.js"></script>
        <script src="<?= $template ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= $template ?>plugins/table/datatable/datatables.js"></script>
        <script src="<?= $template ?>plugins/select2/select2.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            localStorage.setItem('path', '<?= $path ?>');
            localStorage.setItem('template', '<?= $template ?>');
        </script>
        <script src="<?= $path ?>template/custom.js"></script>

        <link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/dropify/dropify.min.css">
        <link href="<?= $template ?>assets/css/users/user-profile.css" rel="stylesheet" type="text/css"/>

        <script src='<?= $path ?>template/icons.js'></script>

        <script src="<?= $path ?>template/jquery_validator/jquery.maskedinput.min.js" type="text/javascript"
                charset="utf-8"></script>
        <script src="<?= $path ?>template/jquery_validator/jquery.validationEngine.js" type="text/javascript"
                charset="utf-8"></script>
        <script src="<?= $path ?>template/jquery_validator/jquery.validationEngine-en.js" type="text/javascript"
                charset="utf-8"></script>
        <link rel="stylesheet" href="<?= $path ?>template/jquery_validator/validationEngine.jquery.css"
              type="text/css"/>

        <script type="text/javascript" src="<?= $path ?>template/moment.min.js"></script>
        <script type="text/javascript" src="<?= $path ?>template/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $path ?>template/daterangepicker.css"/>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
        <style>
            body, p, h1, h2, h3, h4, h5, h6, .menu-title, a {
                font-family: 'Ubuntu', sans-serif;
            }

            .dataTables_wrapper {
                overflow: auto;
            }

            .leadsbtn {
                padding: 5px;
                font-size: 11px;
                margin: 0px 4px 0px 0px;
            }

            .leadbtngroup {
                margin-top: 13px;
            }


        </style>

        <!--    <link href="-->
        <? //=$template?><!--assets/css/users/account-setting.css" rel="stylesheet" type="text/css" />-->

    </head>
<body class="alt-menu sidebar-noneoverflow">
<?php

$Users = new Users();


$Notifications = $Users->ListNotifications();
$Flag = '';
foreach ($Notifications as $notiD) {
    if ($notiD['ReadFlag'] == 0) {
        //$Flag = '<span class="bg-primary dots"></span>';
        $Flag = '<span class="custom mail-badge badge" style=" background: #dda420;  border-radius: 50%;  position: absolute; left: 8px; padding: 3px 0; height: 19px; width: 19px; color: #fff; font-weight: 500; font-size: 10px;  top: 7px;">' . count($Notifications) . '</span>';
    }
}
?>
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
        <header class="header navbar navbar-expand-sm expand-header">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </a>
            <span style="color: #DDA420; margin-top: 6px; margin-left: 15px;"> <?= ucwords($session['name']) ?>
                <span class="d-none"> <?= print_r($session) ?></span>
            </span>

            <ul class="navbar-item flex-row ml-auto">
                <?= (($session['type'] == 'sale-officer') ? '<li class="nav-item">' . TimeTrackActions() . '</li>' : '') ?>

                <li class="nav-item dropdown language-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= $template ?>assets/img/<?= ((isset($session['lang']) && $session['lang'] != '') ? $session['lang'] : 'en') ?>.png"
                             class="flag-width" alt="flag">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <?php
                        if (isset($Languages))
                            foreach ($Languages as $record) {
                                echo ' <a class="dropdown-item d-flex" href="?lang=' . $record['Code'] . '"><img
                                src="' . $template . 'assets/img/' . $record['Code'] . '.png" class="flag-width" alt="flag"> <span
                                class="align-self-center">&nbsp;' . $record['Name'] . '</span></a>';
                            }
                        ?>
                    </div>
                </li>
                <li class="nav-item dropdown language-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= $template ?>_light.png" class="flag-width" alt="flag">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <?php
                        echo '<a class="dropdown-item d-flex" href="?theme=dark">
                    <img src="' . $template . '_dark.png" class="flag-width" alt="flag">
                    <span class="align-self-center">&nbsp;Dark Mode</span></a>';
                        echo '<a class="dropdown-item d-flex" href="?theme=light">
                    <img src="' . $template . '_light.png" class="flag-width" alt="flag">
                    <span class="align-self-center">&nbsp;Light Mode</span></a>'; ?>
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
                        <?= $Flag ?>
                        <!-- <span class="badge badge-success"></span>-->
                    </a>
                    <div class="dropdown-menu position-absolute e-animated e-fadeInUp"
                         style="max-height: 390px;overflow: auto;" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">
                            <?php
                            // print_r($Notifications);exit;
                            if (count($Notifications) > 0) {
                                foreach ($Notifications as $Noti) { ?>
                                    <div class="dropdown-item">
                                        <div class="media">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-message-square">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                            </svg>
                                            <div class="media-body">
                                                <a href="<?= $path ?>user/notification" target="_blank">
                                                    <div class="notification-para"><span
                                                                class="user-name"><?= UserNameByID($Noti['UserID']) ?></span>
                                                        <?= $Noti['Description'] ?>
                                                    </div>
                                                </a>

                                                <div class="notification-meta-time"><?= TIMEFORMAT($Noti['SystemDate']) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="dropdown-item">
                                    <div class="media">
                                        <div class="media-body" style="text-align:center;">
                                            <div class="notification-para"><span
                                                        class="user-name">No New Notification</span></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="dropdown-item <?= (((count($Notifications) > 0)) ? '' : 'd-none') ?>">
                                <div class="media">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-send">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                    <div class="media-body">
                                        <div class="notification-para">
                                            <a href="<?= $path ?>user/notification" target="_blank"> All
                                                Notifications</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <?php
                if ($session['account_type'] != 'sale_agent') {
                if ($CheckAccess['umrah'] || $CheckAccess['visitor'] || $CheckAccess['hotel'] || $CheckAccess['ticket']
                || $CheckAccess['tourism'] || $CheckAccess['transport'] || $CheckAccess['visa'] || $CheckAccess['hajj'] || $CheckAccess['home'] || $CheckAccess['hr']) { ?>
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-home" style="color: #DDA420">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </a>
                    <?php
                    //print_r($Products);
                    echo '<div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown" style="min-width: 100%;">';
                    foreach ($Products as $value) {
                        if ($CheckAccess[$value]) { ?>
                            <?php if ($value == 'home') { ?>
                                <div class="dropdown-item" style="padding: 5px; margin-bottom: 5px">
                                    <a href="<?= $path ?>?nav=<?= $value ?>"> <?= ucwords($value) ?> </a>
                                </div>
                            <?php } else if ($value == 'hr') {
                                echo '<div class="dropdown-item" style="padding: 5px;margin-bottom: 5px">
                                        <a href="'.$path.'home/humanresourcehr?nav='.$value.'">'.strtoupper($value).' </a>
                                        </div>';
                            }else
                            { ?>
                                <div class="dropdown-item" style="padding: 5px;margin-bottom: 5px ">
                                    <a href="<?= $path ?>home/<?= $value ?>?nav=<?= $value ?>"><?= ucwords($value) ?> </a>
                                </div> <?php } ?>
                        <?php }
                    }
                    echo '</div>
                           </li> ';
                    }
                    }

                    if ($session['domain_parent'] > 0 && $session['mis_type'] == "main" && $session['type'] != 'sale-officer') { ?>
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-airplay" style="color: #DDA420">
                            <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                            <polygon points="12 15 17 21 7 21 12 15"></polygon>
                        </svg>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown"
                         style="min-width: 100%;">
                        <div class="dropdown-item"><a href="?domainid=0">All Websites</a></div>
                        <?php
                        foreach ($Domains as $Domain) {
                            echo '<div class="dropdown-item"><a href="?domainid=' . $Domain['UID'] . '">' . $Domain['Name'] . '</a></div>';
                        } ?>
                    </div>
                </li>
            <?php } ?>

                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-user-check" style="color: #DDA420;margin-bottom: 5px;">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="8.5" cy="7" r="4"></circle>
                            <polyline points="17 11 19 13 23 9"></polyline>
                        </svg>
                    </a>

                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a href="#" onclick="LoadModal('update_profile_modal', 0)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user" style="color: #DDA420">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    My Profile</a>
                            </div>
                            <div class="dropdown-item">
                                <a href="<?= $path ?>home/logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-log-out" style="color: #DDA420">
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

    <!--<div class="loader"></div>-->

    <!--  END NAVBAR  -->
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container sidebar-closed sbar-open" id="container">

        <div class="overlay"></div>
        <div class="cs-overlay"></div>
        <div class="search-overlay"></div>

<?php
if ($session['account_type'] == "sale_agent") {

//    echo view("navigation/sale-agent-navigation");
    echo view("navigation/sale_agent_nav_test");

} else if ($session['mis_type'] == "other") {

    echo view("navigation/agents-navigation");

} else {
    echo view("navigation/default");
}
?>