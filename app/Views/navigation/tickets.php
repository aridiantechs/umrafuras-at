<?php

use App\Models\Crud;

$Crud = new Crud(); ?>
<?php
if ($CheckAccess['ticket_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/ticket" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Tickets Dashboard</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php
if ($CheckAccess['ticket_client']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/client" class="dropdown-toggle" aria-expanded="false">
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

<?php
if ($CheckAccess['ticket_bulk_pilgrim']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/bulk_pilgrim" class="dropdown-toggle" aria-expanded="false">
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

<?php
if ($CheckAccess['ticket_booking'] || $CheckAccess['ticket_booking_all'] || $CheckAccess['ticket_booking_pending'] || $CheckAccess['ticket_booking_confirm'] || $CheckAccess['ticket_booking_expire'] || $CheckAccess['ticket_booking_cancel']) {
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
            <!--        <li><a href="--><? //= $path ?><!--ticket/booking/all">All</a></li>-->
            <!--        <li><a href="--><? //= $path ?><!--ticket/booking/pending">Pending</a></li>-->
            <!--        <li><a href="--><? //= $path ?><!--ticket/booking/confirm">Confirm</a></li>-->
            <!--        <li><a href="--><? //= $path ?><!--ticket/booking/expire">Expire</a></li>-->
            <!--        <li><a href="--><? //= $path ?><!--ticket/booking/cancel">Cancel</a></li>-->
            <?php if ($CheckAccess['ticket_booking_all']) { ?>
                <li><a href="<?= $path ?>ticket/bookings">All</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_booking_pending']) { ?>
                <li><a href="<?= $path ?>ticket/pending_booking">Pending</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_booking_confirm']) { ?>
                <li><a href="<?= $path ?>ticket/confirm_booking">Confirm</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_booking_expire']) { ?>
                <li><a href="<?= $path ?>ticket/expire_booking">Expire</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_booking_cancel']) { ?>
                <li><a href="<?= $path ?>ticket/cancel_booking">Cancel</a></li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>

<?php if ($CheckAccess['ticket_issue']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/ticket_issue" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Ticket Issue</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['ticket_reissue']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/ticket_reissue" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Ticket Re Issue</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['ticket_refund']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/ticket_refund" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Ticket Refund</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['ticket_traveling_tomorrow']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/traveling_tomorrow" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Traveling Tomorrow</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php if ($CheckAccess['ticket_adm']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/adm" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>A.D.M</span>
            </div>
        </a>
    </li>
<?php } ?>

<?php
if ($CheckAccess['ticket_reports'] || $CheckAccess['ticket_reports_detail_wise'] || $CheckAccess['ticket_reports_country_wise'] || $CheckAccess['ticket_reports_month_wise'] || $CheckAccess['ticket_reports_year_wise'] || $CheckAccess['ticket_reports_airline_wise'] || $CheckAccess['ticket_reports_group_wise'] || $CheckAccess['ticket_reports_international'] || $CheckAccess['ticket_reports_domestic'] || $CheckAccess['ticket_reports_vendors']) {
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
            <?php if ($CheckAccess['ticket_reports_detail_wise']) { ?>
                <li><a href="<?= $path ?>ticket/detail_report">Detail Report</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_country_wise']) { ?>
                <li><a href="<?= $path ?>ticket/country_wise">Country Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_month_wise']) { ?>
                <li><a href="<?= $path ?>ticket/month_wise">Month Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_year_wise']) { ?>
                <li><a href="<?= $path ?>ticket/year_wise">Year Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_airline_wise']) { ?>
                <li><a href="<?= $path ?>ticket/airline_wise">Airline Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_group_wise']) { ?>
                <li><a href="<?= $path ?>ticket/group_wise">Group Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_international']) { ?>
                <li><a href="<?= $path ?>ticket/international">International</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_domestic']) { ?>
                <li><a href="<?= $path ?>ticket/domestic">Domestic</a></li>
            <?php } ?>
            <?php if ($CheckAccess['ticket_reports_vendors']) { ?>
                <li>
                    <a href="<?= $path ?>reports/ticket_vendor">Vendors</a>
                </li>
            <?php } ?>

        </ul>
    </li>

<?php } ?>


<?php if ($CheckAccess['ticket_visitors']) { ?>
    <li class="menu">
        <a href="<?= $path ?>ticket/visitor" class="dropdown-toggle" aria-expanded="false">
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

<?php if ($CheckAccess['ticket_query']) { ?>
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

<?php if ($CheckAccess['ticket_inbox']) { ?>
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

<?php if ($CheckAccess['ticket_wallet']) { ?>
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

<?php //if ($CheckAccess['ticket_users']) { ?>
<!--    <li class="menu">-->
<!--        <a href="--><?//= $path ?><!--user" class="dropdown-toggle" aria-expanded="false">-->
<!--            <div class="">-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                     stroke-linejoin="round" class="feather feather-home">-->
<!--                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                    <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--                </svg>-->
<!--                <span>Users</span>-->
<!--            </div>-->
<!--        </a>-->
<!--    </li>-->
<?php //} ?>