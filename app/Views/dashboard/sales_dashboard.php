<link rel="stylesheet" type="text/css" href="<?= $template ?>umrahfuras-dashboard.css">
<style>
    #ReportsPage a {
        color: white;
    }

    font.lang-ar {
        font-size: 130% !important;
    }

</style>


<?php



$PAGEJS = '';

use App\Models\Crud;
use App\Models\Sales;

$session = session();
$session = $session->get();
$DomainID = $session['domainid'];

$Crud = new Crud();
$sales = new Sales();
$lead_status = $Crud->LookupOptions('lead_status');

$total_leads = $sales->GetTotalLeads($DomainID);
$fresh_leads = $sales->GetFreshLeads($DomainID);

$un_assign_leads = $sales->GetUnAssignLeads($DomainID);
$today_followup_leads = $sales->GetTodayFollowUpLeads($DomainID);
$pending_followup_leads = $sales->GetPendingFollowUpLeads($DomainID);
$upcoming_followup_leads = $sales->GetUpComingFollowUpLeads($DomainID);


$count_leads_status = $sales->CountLeadStatus($DomainID);
$count_leads_products = $sales->CountLeadProducts($DomainID);
//echo "<pre>";
//print_r($count_leads_products);
//exit;

$agents_login_details = $sales->AgentsLoginDetails($DomainID);
?>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing" id="ReportsPage">

        <?php if ($session['type'] == 'admin') {
            if (count($agents_login_details) > 0) {
                ?>
                <div class="page-header">
                    <div class="page-title">
                        <h4>Today Login Agents </h4>
                    </div>
                </div>

                <div class="row analytics">
                    <?php
                    foreach ($agents_login_details as $value) {
                        ?>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four voucher-box p-2">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info">
                                            <div class="lightseagreen-circle"></div>
                                            <h6 class="value text-center mt-4"><?= ucwords($value['FullName']) ?></h6>
                                            <div class="text-center mt-2 mb-4"><?= ucwords($value['Designation']) ?>
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
        <div class="page-header">
            <div class="page-title">
                <h4>General Stats </h4>
            </div>
        </div>
        <!--        -->
        <div class="row analytics">

            <div class="col-xl-7 col-lg-12 col-md-7 ">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100" id="B2cCount">
                                        <div class="blue-circle float-right"></div>
                                        <h6 class="value">
                                            <span><?= $total_leads ?></span>
                                        </h6>
                                        <div class="blue-box text-center mt-2"><a
                                                    href="<?= $path ?>lead/all_leads"
                                            > Total Leads</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($session['profile']['ParentID'] == 1 && $session['type'] != 'admin') {
                    } else { ?>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                            <div class="widget widget-card-four btb-box p-3">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-100" id="B2bCount">
                                            <div class="green-circle float-right"></div>
                                            <h6 class="value">
                                                <span><?= $un_assign_leads ?></span>
                                            </h6>
                                            <div class="green-box text-center mt-2"><a
                                                        href="<?= $path ?>lead/un_assign"
                                                >Un Assign leads </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100" id="ExternalAgents">
                                        <div class="yellow-circle float-right"></div>
                                        <h6 class="value">
                                            <span><?= $fresh_leads ?></span>
                                        </h6>
                                        <div class="yellow-box text-center mt-2">
                                            <a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/fresh_leads_model','fresh_lead','modal-lg')"
                                               target=""> Assign Leads </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content" id="TotalPilgrim">
                                    <div class="w-info w-100">
                                        <div class="pink-circle float-right"></div>
                                        <h6 class="value">
                                            <span><?= $today_followup_leads ?></span>
                                        </h6>
                                        <div class="pink-box text-center mt-2">
                                            <a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/today_follow_model','today_follow','modal-lg')"
                                               target=""> Today Follow </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-5 col-lg-12 col-md-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="lightseagreen-circle float-right"></div>
                                        <h6 class="value"><?= $pending_followup_leads ?></h6>
                                        <div class="lightseagreen-box text-center mt-2">
                                            <a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/pending_followup_model','pending_followup_model','modal-lg')"
                                               target=""> Pending Follow Up </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="orange-circle float-right"></div>
                                        <h6 class="value"><?= $upcoming_followup_leads ?></h6>
                                        <div class="orange-box text-center mt-2">
                                            <a href="#"
                                               onclick="LoadModal('sales/lead/all_dashboard_models/upcoming_followup_model','upcoming_followup_model','modal-lg')"
                                               target=""> Up Coming Follow Up </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="orange-circle float-right"></div>
                                        <h6 class="value"><? /*= ((isset($DashboardCounters['visa-not-printed'])) ? $DashboardCounters['visa-not-printed'] : '-') */ ?></h6>
                                        <div class="orange-box text-center mt-2"><a
                                                    href="<? /*= $path */ ?>reports/visa_not_issue" target="_blank">Visa Not
                                                Issue</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>

        <div class="page-header">
            <div class="page-title">
                <h4>Lead Stats </h4>
            </div>
        </div>

        <div class="row analytics">
            <!-- voucher-box  -->

            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="row">


                    <?php

                    $finalarray = array();
                    $finalarray = array_merge($B2CLeadStatusArray, $B2BLeadStatusArray);
                    //                        echo "<pre>"; print_r($finalarray);
                    $cnt = 0;
                    foreach ($finalarray as $key => $value) {
                        if ($key != 'new') {
                             ?>

                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="#"
                                                   onclick="LoadModal('sales/lead/all_dashboard_models/leads_stats_model','<?= $key ?>','modal-lg')"
                                                   target="">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="<?= $key ?>" class=""
                                                             style="min-height: 220px;"></div>

                                                    </div>
                                                </a>

                                                <div class="text-center mb-2" style="background: <?= $StatusStatsColorsArray[$cnt];?>;border-radius: 27px;font-size: 11px;color: white;font-weight: 600;padding: 2px;"><?= ucwords($value) ?></div>
                                                <?php if (isset($count_leads_status[$key])) {
                                                    $statusCount = $count_leads_status[$key];
                                                } else {
                                                    $statusCount = 0;
                                                } ?>
                                                <?php
                                                $PAGEJS .= '
                                                htmldata = {
                                                  "divid": "' . $key . '",
                                                  "color": "'.$StatusStatsColorsArray[$cnt].'",
                                                  "labels": { "A": "' . ucwords($value) . '" , "B": "Total Leads" },
                                                  "series": { "A": ' . $statusCount . ' , "B": ' . $total_leads . ' }
                                                };
                                                LoadDashboardStatChart(htmldata);'; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }  $cnt++;
                    } ?>
                </div>
            </div>

        </div>


        <div class="row analytics">

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
                                   aria-selected="false"><h5><?= ucwords($value) ?></h5></a>
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
                                    <?php
                                    $cnt = 0;
                                    foreach ($finalarray as $key => $valueStatus) {
                                        if ($key != 'new') {
                                            $produceBased_leads_status = $sales->GetProductBasedLeadStatus($DomainID, $value, $key); ?>
                                            <div class="col-xl-2 col-lg-2 layout-spacing">
                                                <div class="widget widget-card-four allow-box p-2">
                                                    <div class="widget-content">
                                                        <div class="w-content">
                                                            <div class="w-info">
                                                                <div class="orange-circle"></div>
                                                                <h6 class="value text-center mt-4">
                                                                    <?php if (isset($produceBased_leads_status[$value])) {
                                                                        echo $produceBased_leads_status[$value];
                                                                    } else {
                                                                        echo '-';
                                                                    } ?>
                                                                </h6>
                                                                <div class="w-summary-details">
                                                                    <div class="w-summary-stats">
                                                                        <div class="text-center mt-5 p-1" style="background: <?= $StatusStatsColorsArray[$cnt];?>;border-radius: 27px;font-size: 11px;color: white;font-weight: 600;">
                                                                            <div class="">
                                                                                <a href="#"
                                                                                   target="">  <?= ucwords($valueStatus) ?> </a>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } $cnt++;
                                    } ?>
                                </div>

                            </div>
                        <?php }
                    } ?>
                </div>


            </div>


        </div>

        <div class="row analytics">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Products Stats</h4>
                    </div>
                </div>
                <div class="row">
                    <?php $cnt = 0;
                    foreach ($Products as $value) {

                        if ($value == 'home' || $value == 'visitor' || $value == 'sales' || $value == 'hr') {
                        } else {
                            ?>

                            <div class="col-xl-2 col-lg-2 layout-spacing">
                                <div class="widget widget-card-four allow-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <div class="orange-circle"></div>
                                                <h6 class="value text-center mt-4">
                                                    <?php if (isset($count_leads_products[$value])) {
                                                        echo $count_leads_products[$value];
                                                    } else {
                                                        echo '-';
                                                    } ?>
                                                </h6>
                                                <div class="w-summary-details">
                                                    <div class="w-summary-stats">
                                                        <div class="text-center mt-5 p-1" style="background: <?= $StatusStatsColorsArray[$cnt];?>;border-radius: 27px;font-size: 11px;color: white;font-weight: 600;">
                                                            <div class="">
                                                                <a href="<?= $path ?>lead/all/<?= $value ?>"
                                                                   target="">   <?= ucwords($value) ?> </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } $cnt++;
                    } ?>


                </div>
            </div>


        </div>


    </div>
</div>
<!--  END CONTENT AREA  -->

<script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?= $template ?>assets/js/dashboard-charts.js"></script>

<script type="text/javascript">

    function LoadDashboardStatChart(htmldata) {
        var chartDataOptions = {
            chart: {
                type: 'donut',
                width: '100%',
                height: '200px'
            },
            colors: [htmldata.color, htmldata.color],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '12px',
                markers: {
                    width: 10,
                    height: 10,
                },
                itemMargin: {
                    horizontal: 0,
                    vertical: 8
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '100%',
                                fontFamily: 'Nunito, sans-serif',
                                color: undefined,
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '100%',
                                fontFamily: 'Nunito, sans-serif',
                                color: '#bfc9d4',
                                offsetY: 16,
                                formatter: function (val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: htmldata.series.A,
                                color: '#000000',
                                width: '30px',
                                height: '30px',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce(function (a, b) {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            stroke: {
                show: true,
                width: 10
            },
            series: [htmldata.series.A, htmldata.series.B],
            labels: [htmldata.labels.A, htmldata.labels.B],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '150%',
                        height: '200px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }, {

                breakpoint: 1439,
                options: {
                    chart: {
                        width: '120%',
                        height: '220px'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                            }
                        }
                    }
                }
            }]
        }
        var chartOne = new ApexCharts(
            document.querySelector("#" + htmldata.divid),
            chartDataOptions
        );

        chartOne.render();
    }


    setTimeout(function () {
        <?=$PAGEJS?>
    }, 1000);


</script>