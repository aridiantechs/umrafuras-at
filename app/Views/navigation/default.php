<?php

use App\Models\Crud;
use App\Models\Users;

$Crud = new Crud(); ?>
<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <?php
                $session = session();
                $NAV = $session->get('nav');
                ?>
                <a href="<?= $path ?>?nav=<?=$NAV?>">
                    <img src="<?= $path ?>template/<?= $domain_themes[$hostdomain]['logo'] ?>" class="navbar-logo"
                         alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="<?= $path ?>" class="nav-link"><span style="font-size: 16px;">MIS - Umrah Furas</span></a>
            </li>
        </ul>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="" class="" data-toggle="collapse" aria-expanded="true"></a>
            </li>
            <?php

//            print_r($HomeAccess[0]['COUNTER']);
//            exit;

            $userID = $session->get('id');

            $user = new Users();
            $HomeRecord = 0;
            $SessionHomeRecord = $session->get('SetHomeNavigationData');

            if (isset($SessionHomeRecord) && $SessionHomeRecord > 0) {
                $HomeRecord = $SessionHomeRecord;
            } else {
                $CheckHomeRecord = $user->HomeNavigationCheck($userID);
                if (isset($CheckHomeRecord) && $CheckHomeRecord > 0) {
                    $session->set('SetHomeNavigationData', $CheckHomeRecord);
                    $HomeRecord = $CheckHomeRecord;
                }
            }
            ?>
            <?php if ($HomeRecord > 0) {
                if ($HomeAccess[0]['COUNTER'] > 0) {
                    ?>
                    <li class="menu">
                        <a href="<?= $path ?>?nav=home" class="dropdown-toggle" aria-expanded="false">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-airplay">
                                    <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                                    <polygon points="12 15 17 21 7 21 12 15"></polygon>
                                </svg>
                                <span>Home</span>
                            </div>
                        </a>
                    </li> <?php }
            } ?>

            <?php
            //echo $session['domainid'];
            $session = session();
            $Sess = $session->get();
//            echo "<pre>"
//            print_r($Sess);exit;
            //            echo $session['type'];exit;
            if ($Sess['type'] == 'sale-officer') {
                if($Sess['profile']['ParentID'] == 1){
                    echo view("navigation/child_sales_officer_navigation");
                }else{
                    echo view("navigation/sales");
                }
            } else {
                $NAV = $session->get('nav');
                switch ($NAV) {
                    case "ticket";
                        echo view("navigation/tickets");
                        break;

                    case "umrah";
                        echo view("navigation/umrah");
                        break;

                    case "hajj";
                        echo view("navigation/hajj");
                        break;

                    case "hotel";
                        echo view("navigation/hotels");
                        break;

                    case "transport";
                        echo view("navigation/transports");
                        break;

                    case "tourism";
                        echo view("navigation/tourism");
                        break;

                    case "visa";
                        echo view("navigation/visa");
                        break;

                    case "visitor";
                        echo view("navigation/visitor");
                        break;
                    case "sales";
                        echo view("navigation/sales");
                        break;
                    case "hr";
                        echo view("navigation/human_resource_hr_nav");
                        break;

                    default;
                        echo view("navigation/main");
                }

            }

            ?>
            <li class="menu">
                <a href="<?= $path ?>home/logout" class="dropdown-toggle" aria-expanded="false">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-log-out">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
</div>
<!--  END SIDEBAR  -->