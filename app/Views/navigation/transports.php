 <?php

use App\Models\Crud;

$Crud = new Crud(); ?>

<?php
if ($CheckAccess['transport_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/transport" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Transport Dashboard</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['transport_client']) { ?>
    <li class="menu">
        <a href="<?= $path ?>transport/client" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Client</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['transport_bulk_pilgrim']) { ?>
    <li class="menu">
        <a href="<?= $path ?>transport/bulk_pilgrim" class="dropdown-toggle" aria-expanded="false">
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
<?php } ?>


<?php if ($CheckAccess['transport_booking'] || $CheckAccess['transport_booking_all'] || $CheckAccess['transport_booking_pending'] || $CheckAccess['transport_booking_confirm'] || $CheckAccess['transport_booking_expire'] || $CheckAccess['transport_booking_cancel']) { ?>
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
            <?php if ($CheckAccess['transport_booking_all']) { ?>
                <li><a href="<?= $path ?>transport/bookings">All</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_booking_pending']) { ?>
                <li><a href="<?= $path ?>transport/pending_booking">Pending</a></li>
            <?php } ?>

            <?php if ($CheckAccess['transport_booking_confirm']) { ?>
                <li><a href="<?= $path ?>transport/confirm_booking">Confirm</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_booking_expire']) { ?>
                <li><a href="<?= $path ?>transport/expire_booking">Expire</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_booking_cancel']) { ?>
                <li><a href="<?= $path ?>transport/cancel_booking">Cancel</a></li>
            <?php } ?>

        </ul>
    </li>

<?php } ?>

<?php if ($CheckAccess['transport_refund_booking']) { ?>
    <li class="menu">
        <a href="<?= $path ?>transport/refund_booking" class="dropdown-toggle" aria-expanded="false">
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

<?php if ($CheckAccess['transport_change_booking']) { ?>
    <li class="menu">
        <a href="<?= $path ?>transport/change_booking" class="dropdown-toggle" aria-expanded="false">
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

<?php if ($CheckAccess['transport_tomorrow_vehicle_required']) { ?>
    <li class="menu">
        <a href="<?= $path ?>transport/tomorrow_vehicle_required" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Tomorrow Vehicle Required</span>
            </div>
        </a>
    </li>

<?php } ?>


<?php if ($CheckAccess['transport_reports'] || $CheckAccess['transport_reports_detail_wises'] || $CheckAccess['transport_reports_country_wises'] || $CheckAccess['transport_reports_category_wises'] || $CheckAccess['transport_reports_month_wises'] || $CheckAccess['transport_reports_year_wises'] || $CheckAccess['transport_reports_vendors']) { ?>
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

            <?php if ($CheckAccess['transport_reports_detail_wises']) { ?>
                <li><a href="<?= $path ?>transport/detail_report">Detail Report</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_reports_country_wises']) { ?>
                <li><a href="<?= $path ?>transport/country_wise">Country Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_reports_category_wises']) { ?>
                <li><a href="<?= $path ?>transport/category_wise">Category Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_reports_month_wises']) { ?>
                <li><a href="<?= $path ?>transport/month_wise">Month Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_reports_year_wises']) { ?>
                <li><a href="<?= $path ?>transport/year_wise">Year Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['transport_reports_vendors']) { ?>
                <li>
                    <a href="<?= $path ?>reports/transport_vendor">Vendors</a>
                </li>
            <?php } ?>
            <!--        <li><a href="--><? //= $path ?><!--transport/accounts">Accounts</a></li>-->
        </ul>
    </li>

<?php } ?>


<?php if ($CheckAccess['transport_visitor']) { ?>
    <li class="menu">
        <a href="<?= $path ?>transport/visitor" class="dropdown-toggle" aria-expanded="false">
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

<?php if ($CheckAccess['transport_query']) { ?>
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

<?php if ($CheckAccess['transport_inbox']) { ?>
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

<?php if ($CheckAccess['transport_wallet']) { ?>
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

<?php if ($CheckAccess['transport_users']) { ?>
    <li class="menu">
        <a href="<?= $path ?>user" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Users</span>
            </div>
        </a>
    </li>
<?php } ?>