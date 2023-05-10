<?php

use App\Models\Crud;

$Crud = new Crud(); ?>
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
                <a href="" class="" data-toggle="collapse" aria-expanded="true"></a>
            </li>
            <li class="menu">
                <a href="<?= $path ?>" class="dropdown-toggle" aria-expanded="false">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard </span>
                    </div>
                </a>
            </li>

            <?php
            if ($CheckAccess['umrah_client'] || $CheckAccess['umrah_client_b2b'] || $CheckAccess['umrah_client_external_agent']) { ?>

                <li class="menu">
                    <a href="#agents" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Client</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="agents" data-parent="#accordionExample">
                        <?php if ($CheckAccess['umrah_client_b2b']) { ?>
                            <li <?= (($module == "agent" && $page == "index") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>agent/index">B2B </a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_client_external_agent']) { ?>
                            <li <?= (($module == "agent" && $page == "external_agent") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>agent/external_agent">External Agent </a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
                <?php
            }
            ?>

            <?php
            if ($CheckAccess['umrah_travel_check'] || $CheckAccess['umrah_travel_check_create_voucher'] || $CheckAccess['umrah_travel_check_all_voucher'] || $CheckAccess['umrah_travel_check_pending_voucher'] || $CheckAccess['umrah_travel_check_approved_voucher'] || $CheckAccess['umrah_travel_check_updated_voucher'] || $CheckAccess['umrah_travel_check_executed_voucher'] || $CheckAccess['umrah_travel_check_refund_voucher'] || $CheckAccess['umrah_travel_check_wdout_voucher_arrival']) {
                ?>
                <li class="menu">
                    <a href="#voucher" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span>Travel Check</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled"
                        id="voucher" data-parent="#accordionExample">
                        <?php
                        if ($CheckAccess['umrah_travel_check_create_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/voucher">Create Voucher</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_all_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/all_voucher">All Voucher</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_pending_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/pending_voucher">Pending Voucher</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_approved_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/approved_voucher">Approved Vouchers</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_updated_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/updated_vouchers">Updated Voucher</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_executed_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/all_executed_voucher">Executed Vouchers</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_refund_voucher']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/refund_vouchers">Refund Voucher</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_travel_check_wdout_voucher_arrival']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/without_voucher_arrival">Wdout Voucher Arrvl</a>
                            </li>
                        <?php } ?>


                    </ul>
                </li>
            <?php } ?>
            <?php if ($CheckAccess['umrah_groups'] || $CheckAccess['umrah_groups_create_new'] || $CheckAccess['umrah_groups_manage'] || $CheckAccess['umrah_groups_pilgrim']) { ?>
                <li class="menu">
                    <a href="#groups"
                       class="dropdown-toggle" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Groups</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="groups" data-parent="#accordionExample">
                        <?php
                        if ($CheckAccess['umrah_groups_create_new']) { ?>
                            <li>
                                <a href="<?= $path ?>group/add_group">Create New Groups </a>
                            </li>
                        <?php } ?>

                        <?php if ($CheckAccess['umrah_groups_manage'] || $CheckAccess['umrah_groups_manage_incomplete'] || $CheckAccess['umrah_groups_manage_complete']) { ?>
                            <li>
                                <a href="#groups-error" data-toggle="collapse" aria-expanded="false"
                                   class="dropdown-toggle"> Manage
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                                <ul class="collapse list-unstyled sub-submenu" id="groups-error" data-parent="#groups">
                                    <?php
                                    if ($CheckAccess['umrah_groups_manage_incomplete']) { ?>
                                        <li>
                                            <a href="<?= $path ?>group/index/in-complete">In-Complete</a>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    if ($CheckAccess['umrah_groups_manage_complete']) { ?>
                                        <li>
                                            <a href="<?= $path ?>group/index/complete">Complete </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($CheckAccess['umrah_groups_pilgrim'] || $CheckAccess['umrah_groups_pilgrim_b2b'] || $CheckAccess['umrah_groups_pilgrim_new_registration'] || $CheckAccess['umrah_groups_pilgrim_transfer']) { ?>
                            <li>
                                <a href="#pilgrim-error" data-toggle="collapse" aria-expanded="false"
                                   class="dropdown-toggle"> Pilgrim
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                                <ul class="collapse list-unstyled sub-submenu" id="pilgrim-error" data-parent="#groups">

                                    <?php
                                    if ($CheckAccess['umrah_groups_pilgrim_b2b']) { ?>
                                        <li>
                                            <a href="<?= $path ?>agent/B2B">B2B</a>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    if ($CheckAccess['umrah_groups_pilgrim_new_registration']) { ?>
                                        <li>
                                            <a href="<?= $path ?>pilgrim/new_bulk">New Registration</a>
                                        </li>
                                    <?php } ?>
                                    <?php
                                    if ($CheckAccess['umrah_groups_pilgrim_transfer']) { ?>
                                        <li>
                                            <a href="<?= $path ?>pilgrim/pilgrim_transfer">Pilgrim Transfer</a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports'] || $CheckAccess['umrah_reports_stats'] || $CheckAccess['umrah_reports_status_stats'] ) { ?>
                <li class="menu">
                    <a href="#reports" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                                <line x1="2" y1="20" x2="2.01" y2="20"></line>
                            </svg>
                            <span>Reports</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="reports" data-parent="#accordionExample">
                        <?php
                        if ($CheckAccess['umrah_reports_stats']) { ?>
                            <li>
                                <a href="<?= $path ?>reports/stats">Report Stats</a>
                            </li>
                        <?php } ?>
                        <?php
                        if ($CheckAccess['umrah_reports_status_stats']) { ?>
                            <li>
                                <a href="<?= $path ?>home/stats">Status Stats</a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>
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