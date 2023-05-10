<?php

use App\Models\Crud;

$Crud = new Crud();
?>
<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="<?= $path ?>">
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
                <a href="" class="" data-toggle="collapse" aria-expanded="true">
                </a>
            </li>

            <li class="menu">
                <a href="<?= $path ?>?nav=home" class="dropdown-toggle" aria-expanded="false">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Home</span>
                    </div>
                </a>
            </li>

            <?php
            if ($session['type'] == 'sale-officer') {
                    echo view("navigation/sales");
            } else {
                //echo $session['domainid'];
                $NAV = $session['nav'];
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

                    default;
                        echo view("navigation/agent-nav");
                }
            } ?>


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
