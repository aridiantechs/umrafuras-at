<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="<?= $template ?>plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="<?= $template ?>plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">

<?php

use App\Models\Crud;
use App\Models\Sales;

$session = session();
$session = $session->get();
$DomainID = $session['domainid'];

$Crud = new Crud();
$sales = new Sales();
$lead_status = $Crud->LookupOptions('lead_status');

$total_leads = $sales->GetTotalLeads($DomainID,'B2B');
$fresh_leads = $sales->GetFreshLeads($DomainID,'B2B');

$un_assign_leads = $sales->GetUnAssignLeads($DomainID,'B2B');
$today_followup_leads = $sales->GetTodayFollowUpLeads($DomainID,'B2B');
$pending_followup_leads = $sales->GetPendingFollowUpLeads($DomainID,'B2B');
$upcoming_followup_leads = $sales->GetUpComingFollowUpLeads($DomainID,'B2B');


$count_leads_status = $sales->CountLeadStatus($DomainID,'B2B');
$count_leads_products = $sales->CountLeadProducts($DomainID,'B2B');
//echo "<pre>";
//print_r($count_leads_products);
//exit;

$agents_login_details = $sales->AgentsLoginDetails($DomainID);
?>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 layout-spacing">
                <h3>B2B Sales Dashboard </h3>
            </div>
            <!--            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 layout-spacing">-->
            <!--                <a type="button" style="margin: 8px;" class="btn btn_customized  btn-sm float-right"-->
            <!--                   href=" ">Date Filter Apply</a>-->
            <!--                <input id="rangeCalendarFlatpickr" style="width: 65%;float: right !important;"-->
            <!--                       class="form-control flatpickr flatpickr-input active" type="text"-->
            <!--                       placeholder="Select Date..">-->
            <!--                </h4>-->
            <!--            </div>-->


        </div>

        <?php if ($session['type'] == 'admin') {
            if (count($agents_login_details) > 0) {
                ?>
                <div class="row layout-top-spacing">

                    <div class="col-lg-12">
                        <div class="page-header">
                            <h4>Today Login Agents</h4>
                        </div>
                    </div>
                    <?php
                    foreach ($agents_login_details as $value) {
                        ?>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info">
                                            <h6 class="value"><?= ucwords($value['FullName']) ?>

                                            </h6>
                                            <p class=""><a href="#"> <?= ucwords($value['Designation']) ?> </a></p>

                                        </div>
                                        <div class="">
                                            <div class="w-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-users">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>


            <?php }
        } else {
        } ?>


        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4>General Stats </h4>
                </div>
            </div>


            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= $total_leads ?></h6>
                                <p class=""><a href="<?= $path ?>lead/all_leads" target=""> Total Leads</a></p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($session['profile']['ParentID'] == 1 && $session['type'] != 'admin') {
            } else { ?>
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <h6 class="value"><?= $un_assign_leads ?></h6>
                                    <p class=""><a href="<?= $path ?>lead/un_assign" target=""> Un Assign leads </a></p>

                                </div>
                                <div class="">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-users">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= $fresh_leads ?></h6>
                                <p class=""><a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/fresh_leads_model','fresh_lead','modal-lg')"
                                               target=""> Assign Leads </a></p>

                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= $today_followup_leads ?></h6>
                                <p class=""><a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/today_follow_model','today_follow','modal-lg')"
                                               target=""> Today Follow </a></p>

                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= $pending_followup_leads ?></h6>
                                <p class=""><a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/pending_followup_model','pending_followup_model','modal-lg')"
                                               target=""> Pending Follow Up </a></p>

                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= $upcoming_followup_leads ?></h6>
                                <p class=""><a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/upcoming_followup_model','upcoming_followup_model','modal-lg')"
                                               target=""> Up Coming Follow Up </a></p>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4>Lead Stats </h4>
                </div>
            </div>

            <?php

            //            echo "<pre>"; print_r($count_leads_status);
            foreach ($B2BLeadStatusArray as $key => $value) {
                if ($key != 'new') {
                    ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <h6 class="value"><?php if (isset($count_leads_status[$key])) {
                                                echo $count_leads_status[$key];
                                            } else {
                                                echo '-';
                                            } ?></h6>
                                        <p class=""><a href="#"
                                                       onclick="LoadModal('sales/lead/all_dashboard_models/leads_stats_model','<?= $key ?>','modal-lg')"> <?= ucwords($value) ?> </a>
                                        </p>

                                    </div>
                                    <div class="">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-users">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>


        </div>


        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4>Product Based Lead Stats </h4>
                </div>
            </div>


            <div class="col-lg-12">

                <ul class="nav nav-tabs  mb-3" id="animateLine" role="tablist">

                    <?php
                    foreach ($Products as $value) {
                        if ($value == 'home' || $value == 'visitor' || $value == 'sales' || $value == 'hr') {
                        } else {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" id="animated-underline-<?= $value ?>-tab" data-toggle="tab"
                                   href="#animated-underline-<?= $value ?>" role="tab"
                                   aria-controls="animated-underline-<?= $value ?>"
                                   aria-selected="false"> <h5><?= ucwords($value) ?></h5></a>
                            </li>

                        <?php }
                    } ?>
                </ul>

                <div class="tab-content" id="animateLineContent" style="padding: 0px;">
                    <?php
                    $cnt = 0;
                    foreach ($Products as $value) {
                        if ($value == 'home' || $value == 'visitor' || $value == 'sales' || $value == 'hr') {
                        } else {
                            $cnt++;
                            ?>
                            <div class="<?= $cnt ?> tab-pane fade show <?= (($cnt == 1) ? 'active' : '') ?>"
                                 id="animated-underline-<?= $value ?>" role="tabpanel"
                                 aria-labelledby="animated-underline-<?= $value ?>-tab">
                                <div class="row layout-top-spacing">
                                    <?php foreach ($B2BLeadStatusArray as $key => $valueStatus) {
                                        if ($key != 'new') {
                                            $produceBased_leads_status = $sales->GetProductBasedLeadStatus($DomainID, $value, $key,'B2B'); ?>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                                                <div class="widget widget-card-four">
                                                    <div class="widget-content">
                                                        <div class="w-content">
                                                            <div class="w-info">
                                                                <h6 class="value">
                                                                    <?php if (isset($produceBased_leads_status[$value])) {
                                                                        echo $produceBased_leads_status[$value];
                                                                    } else {
                                                                        echo '-';
                                                                    } ?>
                                                                </h6>
                                                                <p class=""><a href="#"
                                                                               onclick=""> <?=ucwords($valueStatus)?> </a>
                                                                </p>

                                                            </div>
                                                            <div class="">
                                                                <div class="w-icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                         height="24"
                                                                         viewBox="0 0 24 24" fill="none"
                                                                         stroke="currentColor"
                                                                         stroke-width="2"
                                                                         stroke-linecap="round" stroke-linejoin="round"
                                                                         class="feather feather-users">
                                                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                                        <circle cx="9" cy="7" r="4"></circle>
                                                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>

                            </div>
                        <?php }
                    } ?>
                </div>


            </div>


        </div>

        <div class="row layout-top-spacing">
            <div class="col-lg-12">
                <div class="page-header">
                    <h4>Products Stats </h4>
                </div>
            </div>

            <?php
            foreach ($Products as $value) {

                if ($value == 'home' || $value == 'visitor' || $value == 'sales' || $value == 'hr') {
                } else {
                    ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <h6 class="value"><?php if (isset($count_leads_products[$value])) {
                                                echo $count_leads_products[$value];
                                            } else {
                                                echo '-';
                                            } ?></h6>
                                        <p class=""><a href="<?= $path ?>lead/all/<?= $value ?>"
                                                       target="">   <?= ucwords($value) ?> </a></p>

                                    </div>
                                    <div class="">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-users">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>


        </div>


    </div>
</div>
<!--  END CONTENT AREA  -->
<script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?= $template ?>plugins/flatpickr/flatpickr.js"></script>
<script type="application/javascript">


</script>
