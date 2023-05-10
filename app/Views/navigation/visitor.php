<?php

use App\Models\Crud;

$Crud = new Crud(); ?>
<?php if ($CheckAccess['visitor_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/visitor" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Visitors Dashboard</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_visitor']) { ?>
    <li class="menu">
        <a href="<?= $path ?>visitor/visitors" class="dropdown-toggle" aria-expanded="false">
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
<?php if ($CheckAccess['visitor_unique_visitor']) { ?>
    <li class="menu">
        <a href="<?= $path ?>visitor/unique_visitor" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Unique Visitors</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_old_visitor']) { ?>
    <li class="menu">
        <a href="<?= $path ?>visitor/old_visitor" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>OLD Visitors</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_confirm_visitor']) { ?>
    <li class="menu">
        <a href="<?= $path ?>visitor/confirm_visitor" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Confirm Visitors</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_not_interested_visitor']) { ?>
    <li class="menu">
        <a href="<?= $path ?>visitor/not_interested_visitor" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Not Interested Visitors</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_subscribers']) { ?>
    <li class="menu">
        <a href="<?= $path ?>visitor/subscribers" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Subscribers</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_reports'] || $CheckAccess['visitor_reports_detail_wise_reports']
    || $CheckAccess['visitor_reports_country_wise_reports']
    || $CheckAccess['visitor_reports_product_wise']
    || $CheckAccess['visitor_reports_month_wise_report']
    || $CheckAccess['visitor_reports_year_wise_report']
    || $CheckAccess['visitor_reports_vendors']
) { ?>

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
            <?php if ($CheckAccess['visitor_reports_detail_wise_reports']) { ?>
                <li><a href="<?= $path ?>visitor/detail_report">Detail Report</a></li>
            <?php } ?>
            <?php if ($CheckAccess['visitor_reports_country_wise_reports']) { ?>
                <li><a href="<?= $path ?>visitor/country_wise">Country Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['visitor_reports_product_wise'] || $CheckAccess['visitor_reports_product_wise_successful_product_wise']
                || $CheckAccess['visitor_reports_product_wise_unsuccessful_product_wise']) { ?>

                <li class="menu">
                    <!--            <a href="--><? //= $path ?><!--visitor/product_wise">Product Wise</a>-->
                    <a href="#product" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">

                        <span>Product Wise</span>

                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>

                    <ul class="collapse submenu list-unstyled" id="product">
                        <?php if ($CheckAccess['visitor_reports_product_wise_successful_product_wise']) { ?>
                            <li><a href="<?= $path ?>visitor/successful_product_wise_visitor">Successful Product Wise
                                    Visitor</a>
                            </li>
                        <?php } ?>
                        <?php if ($CheckAccess['visitor_reports_product_wise_unsuccessful_product_wise']) { ?>
                            <li><a href="<?= $path ?>visitor/unsuccessful_product_wise_visitor">Unsuccessful Product
                                    Wise
                                    Visitor</a></li>
                        <?php } ?>
                    </ul>

                </li>

            <?php } ?>
            <?php if ($CheckAccess['visitor_reports_month_wise_report']) { ?>
                <li><a href="<?= $path ?>visitor/month_wise">Month Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['visitor_reports_year_wise_report']) { ?>
                <li><a href="<?= $path ?>visitor/year_wise">Year Wise</a></li>
            <?php } ?>
            <?php if ($CheckAccess['visitor_reports_vendors']) { ?>
                <li>
                    <a href="<?= $path ?>reports/visitor_vendor">Vendors</a>
                </li>
            <?php } ?>
            <!--        <li><a href="--><? //= $path ?><!--">Accounts</a></li>-->
        </ul>
    </li>
<?php } ?>
<?php if ($CheckAccess['visitor_query']) { ?>
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
<?php if ($CheckAccess['visitor_inbox']) { ?>
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
<?php if ($CheckAccess['visitor_wallet']) { ?>
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
<?php if ($CheckAccess['visitor_user']) { ?>
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