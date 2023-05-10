<?php

use App\Models\Crud;

$Crud = new Crud(); ?>
<?php
if ($CheckAccess['hotel_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/hotel" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Hotel Dashboard</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php
if ($CheckAccess['hotel_client'] || $CheckAccess['hotel_client_b2c_client'] || $CheckAccess['hotel_client_b2b_client'] || $CheckAccess['hotel_client_sale_agent'] || $CheckAccess['hotel_client_external_agent']) { ?>
    <li class="menu <?= (($module == 'agent' && $page == 'index') ? 'active' : '') ?>">
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
            <?php
            if ($CheckAccess['hotel_client_b2c_client']) { ?>
                <li>
                    <a href="<?= $path ?>agent/B2C">B2C</a>
                </li>
            <?php }
            if ($CheckAccess['hotel_client_b2b_client']) { ?>
                <li <?= (($module == "agent" && $page == "index") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>agent/index">B2B </a>
                </li>
            <?php }
            if ($CheckAccess['hotel_client_sale_agent']) {
                ?>
                <li>
                    <a href="<?= $path ?>sale_agents/index">Sale Agent</a>
                </li> <?php
            }
            if ($CheckAccess['hotel_client_external_agent'] || $CheckAccess['hotel_client_external_agent_list'] || $CheckAccess['hotel_client_external_agent_sub_agents']) { ?>
                <li>
                    <a href="#groups-error" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> External Agents
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="groups-error" data-parent="#groups">
                        <?php
                        if ($CheckAccess['hotel_client_external_agent_list']) {
                            ?>
                            <li <?= (($module == "user" && $page == "external_agent") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>user/external_agent">List</a>
                            </li> <?php
                        }
                        if ($CheckAccess['hotel_client_external_agent_sub_agents']) { ?>
                        <li <?= (($module == "agent" && $page == "sub_agents") ? ' class="active" ' : '') ?>>
                            <a href="<?= $path ?>agent/sub_agents">Sub Agents </a>
                            </li><?php
                        }

                        ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </li>
    <?php
} ?>

<?php if ($CheckAccess['hotel_bulk_pilgrim']) { ?>
    <li class="menu">
        <a href="<?= $path ?>hotel/bulk_pilgrim" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Bulk Pilgrims</span>
            </div>
        </a>
    </li>

    <?php
} ?>


<?php
if ($CheckAccess['hotel_booking'] || $CheckAccess['hotel_booking_all'] || $CheckAccess['hotel_booking_pending'] || $CheckAccess['hotel_booking_confirm'] || $CheckAccess['hotel_booking_expire'] || $CheckAccess['hotel_booking_cancel']) {
    ?>

    <li class="menu">
        <a href="#Booking" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                </svg>
                <span>Booking</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="Booking" data-parent="#accordionExample">
            <?php if ($CheckAccess['hotel_booking_all']) { ?>
                <li><a href="<?= $path ?>hotel/bookings">All</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_booking_pending']) { ?>
                <li><a href="<?= $path ?>hotel/pending_booking">Pending</a></li>
            <?php } ?>

            <?php if ($CheckAccess['hotel_booking_confirm']) { ?>
                <li><a href="<?= $path ?>hotel/confirm_booking">Confirm</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_booking_expire']) { ?>
                <li><a href="<?= $path ?>hotel/expire_booking">Expire</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_booking_cancel']) { ?>
                <li><a href="<?= $path ?>hotel/cancle_booking">Cancel</a></li>
            <?php } ?>
        </ul>
    </li>

<?php } ?>


<?php if ($CheckAccess['hotel_change_booking']) { ?>
    <li class="menu">
        <a href="<?= $path ?>hotel/change_booking" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Change Booking</span>
            </div>
        </a>
    </li>
<?php } ?>
    <!--    <li class="menu">-->
    <!--        <a href="--><? //= $path ?><!--hotel/confirm_booking" class="dropdown-toggle" aria-expanded="false">-->
    <!--            <div class="">-->
    <!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
    <!--                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
    <!--                     stroke-linejoin="round" class="feather feather-home">-->
    <!--                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
    <!--                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
    <!--                </svg>-->
    <!--                <span>Confirm Booking</span>-->
    <!--            </div>-->
    <!--        </a>-->
    <!--    </li>-->
    <!--    <li class="menu">-->
    <!--        <a href="--><? //= $path ?><!--hotel/cancle_booking" class="dropdown-toggle" aria-expanded="false">-->
    <!--            <div class="">-->
    <!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
    <!--                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
    <!--                     stroke-linejoin="round" class="feather feather-home">-->
    <!--                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
    <!--                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
    <!--                </svg>-->
    <!--                <span>Cancle Booking</span>-->
    <!--            </div>-->
    <!--        </a>-->
    <!--    </li>-->


<?php if ($CheckAccess['hotel_refund_booking']) { ?>
    <li class="menu">
        <a href="<?= $path ?>hotel/refund_booking" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Refund Booking</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['hotel_tomorrow_checkIn']) { ?>
    <li class="menu">
        <a href="<?= $path ?>hotel/tomorrow_checkin" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Tomorrow CheckIn</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['hotel_tomorrow_checkout']) { ?>
    <li class="menu">
        <a href="<?= $path ?>hotel/tomorrow_checkout" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Tomorrow Checkout</span>
            </div>
        </a>
    </li>
<?php } ?>


<?php
if ($CheckAccess['hotel_reports'] || $CheckAccess['hotel_reports_detail_wise'] || $CheckAccess['hotel_reports_country_wise'] || $CheckAccess['hotel_reports_category_wise'] || $CheckAccess['hotel_reports_hotel_wise'] || $CheckAccess['hotel_reports_vendors']) {
    ?>

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
            <?php if ($CheckAccess['hotel_reports_detail_wise']) { ?>
                <li><a href="<?= $path ?>hotel/detail_report">Detail Report</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_reports_country_wise']) { ?>
                <li><a href="<?= $path ?>hotel/country_wise">Country Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_reports_category_wise']) { ?>
                <li><a href="<?= $path ?>hotel/category_wise">Category Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_reports_hotel_wise']) { ?>
                <li><a href="<?= $path ?>hotel/hotel_wise">Hotel Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['hotel_reports_vendors']) { ?>
                <li>
                    <a href="<?= $path ?>reports/hotel_vendor">Vendors</a>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>

<?php if ($CheckAccess['hotel_visitors']) { ?>
    <li class="menu">
        <a href="<?= $path ?>hotel/visitor" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Visitors</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['hotel_query']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/query" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Query</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['hotel_inbox']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/inbox" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Inbox</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['hotel_wallet']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/wallet" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Wallet</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php
if ($CheckAccess['hotel_users'] || $CheckAccess['hotel_users_system_user'] || $CheckAccess['hotel_users_access_level']) {
    ?>
    <?php $options = array("index", "external_agent") ?>
    <li class="menu <?= (($module == 'user' && in_array($page, $options)) ? 'active' : '') ?>">
        <a href="#users" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
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
                <span>Users</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="users" data-parent="#accordionExample">
            <?php
            if ($CheckAccess['hotel_users_system_user']) { ?>
                <li <?= (($module == "user" && $page == "index") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>user/index">System Users </a>
                </li>
                <?php
            }
            if ($CheckAccess['hotel_users_access_level']) {
                ?>
                <li>
                    <a href="<?= $path ?>setting/access_levels">Access levels </a>
                </li>
                <?php
            }


            ?>
        </ul>
    </li>
    <?php
} ?>