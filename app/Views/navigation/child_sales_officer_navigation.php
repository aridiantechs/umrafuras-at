<?php if ($CheckAccess['sales_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/sales?nav=sales" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Dashboard</span>
            </div>
        </a>
    </li>
<?php } ?>


<?php //if ($CheckAccess['sales_leads']) { ?>
<!--    <li class="menu">-->
<!--        <a href="#saleleads" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">-->
<!--            <div class="">-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                     fill="none"-->
<!--                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
<!--                     class="feather feather-users">-->
<!--                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>-->
<!--                    <circle cx="9" cy="7" r="4"></circle>-->
<!--                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>-->
<!--                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>-->
<!--                </svg>-->
<!--                <span>Leads</span>-->
<!--            </div>-->
<!--            <div>-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                     stroke-linejoin="round" class="feather feather-chevron-right">-->
<!--                    <polyline points="9 18 15 12 9 6"></polyline>-->
<!--                </svg>-->
<!--            </div>-->
<!--        </a>-->
<!--        <ul class="collapse submenu list-unstyled" id="saleleads" data-parent="#accordionExample">-->
<!---->
<!--            <li>-->
<!--                <a href="--><?//= $path ?><!--lead/all_leads" aria-expanded="false"-->
<!--                   target="">All Leads-->
<!--                </a>-->
<!--            </li>-->
<!---->
<!---->
<!--            --><?php //if ($CheckAccess['sales_leads_facebook_api']) { ?>
<!--                <li>-->
<!--                    <a href="--><?//= $path ?><!--lead/facebook_api" aria-expanded="false"-->
<!--                       target="">Facebook Api-->
<!--                    </a>-->
<!--                </li>-->
<!--            --><?php //} ?>
<!---->
<!---->
<!--            --><?php //if ($CheckAccess['sales_leads_un_assigned_leads']) { ?>
<!--                <li>-->
<!--                    <a href="--><?//= $path ?><!--lead/un_assign" aria-expanded="false"-->
<!--                       target="">Un Assign-->
<!--                    </a>-->
<!--                </li>-->
<!--            --><?php //} ?>
<!---->
<!---->
<!--            --><?php //if ($CheckAccess['sales_leads_export_leads']) { ?>
<!--                <li>-->
<!--                    <a href="--><?//= $path ?><!--lead/export_leads" aria-expanded="false"-->
<!--                       target="">Export Leads-->
<!--                    </a>-->
<!--                </li>-->
<!--            --><?php //} ?>
<!---->
<!---->
<!--            --><?php //if ($CheckAccess['sales_leads_comments_list']) { ?>
<!--                <li>-->
<!--                    <a href="--><?//= $path ?><!--lead/comments" aria-expanded="false"-->
<!--                       target="">Lead Comments-->
<!--                    </a>-->
<!--                </li>-->
<!--            --><?php //} ?>
<!---->
<!---->
<!--            --><?php //foreach ($Products as $value) {
//                if ($value == 'home') {
//                } elseif ($value == 'sales') {
//                } elseif ($value == 'visitor') {
//                } else { ?>
<!--                    <li>-->
<!--                        <a href="#--><?//= $value ?><!--" data-toggle="collapse" aria-expanded="false"-->
<!--                           class="dropdown-toggle"> --><?//= ucwords($value) ?>
<!--                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                                 stroke-linejoin="round" class="feather feather-chevron-right">-->
<!--                                <polyline points="9 18 15 12 9 6"></polyline>-->
<!--                            </svg>-->
<!--                        </a>-->
<!---->
<!--                        <ul class="collapse list-unstyled sub-submenu" id="--><?//= $value ?><!--" data-parent="">-->
<!---->
<!---->
<!--                            <li>-->
<!--                                <a href="--><?//= $path ?><!--lead/all/--><?//= $value ?><!--" target="">All</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="--><?//= $path ?><!--lead/new/--><?//= $value ?><!--" target="">New</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="--><?//= $path ?><!--lead/index/--><?//= $value ?><!--" target="">Last 30 days</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="--><?//= $path ?><!--lead/personal/--><?//= $value ?><!--" target="">Personal</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="#callback" data-toggle="collapse" aria-expanded="false"-->
<!--                                   class="dropdown-toggle"> CallBack-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                                         class="feather feather-chevron-right">-->
<!--                                        <polyline points="9 18 15 12 9 6"></polyline>-->
<!--                                    </svg>-->
<!--                                </a>-->
<!---->
<!--                                <ul class="collapse list-unstyled sub-submenu" id="callback" data-parent="">-->
<!--                                    <li>-->
<!--                                        <a href="--><?//= $path ?><!--lead/callback/current_month/--><?//=$value?><!--" target="_blank">Current Month</a>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <a href="--><?//= $path ?><!--lead/callback/previous_month/--><?//=$value?><!--" target="_blank">Previous Month</a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                --><?php //}
//           } ?>
<!--        </ul>-->
<!--    </li>-->
<!---->
<?php //} ?>


<li class="menu">
    <a href="<?= $path ?>lead/all_leads" class="dropdown-toggle" aria-expanded="false">
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
            <span>All Leads</span>
        </div>
    </a>
</li>



<?php foreach ($Products as $value) {
if ($value == 'home') {
} elseif ($value == 'sales') {
} elseif ($value == 'visitor') {
} else { ?>
<li class="menu">
    <a href="#<?= $value ?>" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
        <div class="">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                <polyline points="13 2 13 9 20 9"></polyline>
            </svg>
            <span><?= ucwords($value)?> Leads </span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled" id="<?= $value ?>" data-parent="#accordionExample">
        <li>
            <a href="<?= $path ?>lead/all/<?= $value ?>" target="">All</a>
        </li>
        <li>
            <a href="<?= $path ?>lead/new/<?= $value ?>" target="">New</a>
        </li>
        <li>
            <a href="<?= $path ?>lead/index/<?= $value ?>" target="">Last 30 days</a>
        </li>
        <li>
            <a href="<?= $path ?>lead/personal/<?= $value ?>" target="">Personal</a>
        </li>
        <li>
            <a href="#<?= $value ?>_callback" data-toggle="collapse" aria-expanded="false"
               class="dropdown-toggle"> CallBack
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>

            <ul class="collapse list-unstyled sub-submenu" id="<?= $value ?>_callback" data-parent="">
                <li>
                    <a href="<?= $path ?>lead/callback/current_month/<?=$value?>" target="_blank">Current Month</a>
                </li>
                <li>
                    <a href="<?= $path ?>lead/callback/previous_month/<?=$value?>" target="_blank">Previous Month</a>
                </li>
            </ul>
        </li>

    </ul>
</li>

<?php } } ?>


<?php
if ($CheckAccess['sales_organic_organic_leads'] || $CheckAccess['sales_organic_worksheets'] || $CheckAccess['sales_organic_organic_platforms']) {
    ?>
    <li class="menu">
        <a href="#Organic" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Organic</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="Organic" data-parent="#accordionExample">
            <?php if ($CheckAccess['sales_organic_organic_leads']) { ?>
                <li>
                    <a href="<?= $path ?>lead/organic_leads" target=""> Organic Leads</a>
                </li>
            <?php } ?>
            <?php if ($CheckAccess['sales_organic_worksheets']) { ?>
                <li>
                    <a href="<?= $path ?>lead/worksheet" target=""> Worksheets</a>
                </li>
            <?php } ?>
<!--            --><?php //if ($CheckAccess['sales_organic_organic_platforms']) { ?>
<!--                <li>-->
<!--                    <a href="#OrganicPlatform" data-toggle="collapse" aria-expanded="false"-->
<!--                       class="dropdown-toggle">Organic Platforms-->
<!--                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                             stroke-linejoin="round" class="feather feather-chevron-right">-->
<!--                            <polyline points="9 18 15 12 9 6"></polyline>-->
<!--                        </svg>-->
<!--                    </a>-->
<!--                    <ul class="collapse list-unstyled sub-submenu" id="OrganicPlatform" data-parent="">-->
<!--                        --><?php //foreach ($OrganicLookups as $allLookup) { ?>
<!--                            <li>-->
<!--                                <a href="--><?//= $path ?><!--setting/lookup_options/--><?//= $allLookup['Key'] ?><!--"> --><?//= str_replace("Organic Platform", "", $allLookup['Name']) ?><!--</a>-->
<!--                            </li>-->
<!--                            --><?php
//                        }
//
//                        ?>
<!--                    </ul>-->
<!---->
<!--                </li>-->
<!--            --><?php //} ?>

        </ul>


    </li>
    <?php
} ?>


<!--<li class="menu">-->
<!--    <a href="#EmailCompaigns" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">-->
<!--        <div class="">-->
<!--            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"-->
<!--                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
<!--                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>-->
<!--                <polyline points="13 2 13 9 20 9"></polyline>-->
<!--            </svg>-->
<!--            <span>Email Compaigns</span>-->
<!--        </div>-->
<!--        <div>-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                 stroke-linejoin="round" class="feather feather-chevron-right">-->
<!--                <polyline points="9 18 15 12 9 6"></polyline>-->
<!--            </svg>-->
<!--        </div>-->
<!--    </a>-->
<!--    <ul class="collapse submenu list-unstyled" id="EmailCompaigns" data-parent="">-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/index">Email Listing</a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/add_email">Add Email</a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/import_email_ids">Import Email IDs</a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/view_all_email_ids">View All Email IDs</a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/run_email_campaign">Run Email Campaigns</a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/view_all_campaign_logs">View All Campaigns Logs</a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--emailcampaign/view_all_email_campaign">View All Email Campaigns </a>-->
<!--        </li>-->
<!--    </ul>-->
<!---->
<!--</li>-->


<!--<li class="menu">-->
<!--    <a href="#reports" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">-->
<!--        <div class="">-->
<!--            <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2"-->
<!--                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
<!--                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>-->
<!--                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>-->
<!--                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>-->
<!--                <line x1="12" y1="22.08" x2="12" y2="12"></line>-->
<!--            </svg>-->
<!--            <span>Reports</span>-->
<!--        </div>-->
<!--        <div>-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                 stroke-linejoin="round" class="feather feather-chevron-right">-->
<!--                <polyline points="9 18 15 12 9 6"></polyline>-->
<!--            </svg>-->
<!--        </div>-->
<!--    </a>-->
<!--    <ul id="reports" class="collapse submenu list-unstyled" data-parent="">-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--reports/time_track_report">Time Track </a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--reports/product_based_lead_report">Product Based Leads </a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--reports/daily_leads_distribution">Daily Distribution </a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--lead/close_lead_quality">Close Lead Quality </a>-->
<!--        </li>-->
<!--        <li>-->
<!--            <a href="--><?//= $path ?><!--reports/initial_training_report">Initial Training </a>-->
<!--        </li>-->
<!--    </ul>-->
<!---->
<!--</li>-->


<?php //if ($CheckAccess['sales_sales_officer']) { ?>
<!--    <li class="menu">-->
<!--        <a href="--><?//= $path ?><!--user/sales_officer" class="dropdown-toggle" aria-expanded="false">-->
<!--            <div class="">-->
<!--                <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2"-->
<!--                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
<!--                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>-->
<!--                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>-->
<!--                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>-->
<!--                    <line x1="12" y1="22.08" x2="12" y2="12"></line>-->
<!--                </svg>-->
<!--                <span>Sales Officer</span>-->
<!--            </div>-->
<!--        </a>-->
<!--    </li>-->
<?php //}
//
//?>


<!--<li class="menu">-->
<!--    <a href="--><?//= $path ?><!--setting/lookup_options/b2c_lead_close_reason" class="dropdown-toggle" aria-expanded="false">-->
<!--        <div class="">-->
<!--            <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2"-->
<!--                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
<!--                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>-->
<!--                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>-->
<!--                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>-->
<!--                <line x1="12" y1="22.08" x2="12" y2="12"></line>-->
<!--            </svg>-->
<!--            <span>B2C Lead Close Reason</span>-->
<!--        </div>-->
<!--    </a>-->
<!--</li>-->

<!--<li class="menu">-->
<!--    <a href="--><?//= $path ?><!--setting/lookup_options/b2b_lead_close_reason" class="dropdown-toggle" aria-expanded="false">-->
<!--        <div class="">-->
<!--            <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2"-->
<!--                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
<!--                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>-->
<!--                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>-->
<!--                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>-->
<!--                <line x1="12" y1="22.08" x2="12" y2="12"></line>-->
<!--            </svg>-->
<!--            <span>B2B Lead Close Reason</span>-->
<!--        </div>-->
<!--    </a>-->
<!--</li>-->

<!--<li class="menu">-->
<!--    <a href="--><?//= $path ?><!--setting/lookup_options/initial_training_checklist" class="dropdown-toggle"-->
<!--       aria-expanded="false">-->
<!--        <div class="">-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                 stroke-linejoin="round" class="feather feather-home">-->
<!--                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--            </svg>-->
<!--            <span>Intial  Training Checklist</span>-->
<!--        </div>-->
<!--    </a>-->
<!--</li>-->

<!--<li class="menu">-->
<!--    <a href="--><?//=$path?><!--lead/whatsapp_grabber" class="dropdown-toggle" aria-expanded="false">-->
<!--        <div>-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                 stroke-linejoin="round" class="feather feather-home">-->
<!--                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--            </svg>-->
<!--            <span>WhatsApp Grabber</span>-->
<!--        </div>-->
<!--    </a>-->
<!--</li>-->





