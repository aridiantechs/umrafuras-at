<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="<?= $template ?>plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="<?= $template ?>plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">

<style>
    .loader-position {
        margin: 50% auto;
    }
</style>
<?php

use App\Models\CronModel;
use App\Models\Agents;

$Agents = new Agents();

$AllAgents = $Agents->CountAgents();
$B2bAgents = $Agents->CountAgents('agent');
$ExternalAgents = $Agents->CountAgents('external_agent');
$SubAgents = $Agents->CountAgents('sub_agent');
$AllActiveAgents = $Agents->CountAgents('all', 'Active');
$AllInActiveAgents = $Agents->CountAgents('all', 'InActive');
?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 layout-spacing">
                <!--                <h4>Welcome "--><? //= $session['name'] ?><!--" as -->
                <? //= $user_types[$session['type']] ?><!--</h4>-->
                <h4>Umrah Dashboard <?/*=$session['account_type']*/?></h4>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 layout-spacing">
                <a type="button" style="margin: 8px;" class="btn btn_customized  btn-sm float-right"
                   href=" ">Date Filter Apply</a>
                <input id="rangeCalendarFlatpickr" style="width: 65%;float: right !important;"
                       class="form-control flatpickr flatpickr-input active" type="text"
                       placeholder="Select Date..">
                </h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="MainAgentsChart">

                <div class="widget widget-five">
                    <div class="widget-content">
                        <div class="header">
                            <div class="header-body">
                                <?php
                                $host = str_replace("panel.", "", $_SERVER['HTTP_HOST']);
                                if ($host == 'localhost') {

                                    if ($session['account_type'] == 'external_agent') {
                                        echo '<h6>Agent\'s  Based Pilgrim</h6>';
                                        $pilgrimChart = 'agent_based_pilgrims';
                                    } else {
                                        echo '<h6>Agent\'s Country Based Pilgrim</h6>';
                                        $pilgrimChart = 'country_based_pilgrims';

                                    }
                                } else if ($host == 'umrahfuras.com') {
                                    echo '<h6>Country Based Pilgrim</h6>';
                                    $pilgrimChart = 'country_based_pilgrims';
                                } else if ($host == 'lalaservices.com') {
                                    echo '<h6>Company Based Pilgrim</h6>';
                                    $pilgrimChart = 'company_based_pilgrims';
                                } else if ($host == 'tripplanner.ae') {
                                    echo '<h6>Top 5 b2b Based Pilgrim</h6>';
                                    $pilgrimChart = 'top_b2b_based_pilgrims';
                                }
                                //                                $pilgrimChart = 'country_based_pilgrims';
                                //                                $pilgrimChart = 'top_b2b_based_pilgrims';
                                //                                $pilgrimChart = 'company_based_pilgrims';
                                ?>
                                <p class="meta-date" id="agentsChartDate"></p>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div id="loadAgentsChart" class="text-center" align="center">
                                <div class="spinner-grow text-warning align-self-center loader-position"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Basic STATs                       -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-five">
                    <div class="widget-content" id="MainTodayStats">
                        <div class="header">
                            <div class="header-body">
                                <h6>Entered</h6>
                            </div>
                        </div>
                        <div class="w-content">
                            <div class="">
                                <div class="task-left" id="TodayStatsEntered">
                                    <?= ((isset($DashboardCounters['total-arrival'])) ? ($DashboardCounters['total-arrival']) : '-') ?>
                                </div>
                            </div>
                        </div>
                        <hr class="text-white">
                        <div class="header">
                            <div class="header-body">
                                <h6>Exited</h6>
                            </div>
                        </div>
                        <div class="w-content">
                            <div class="">
                                <div class="task-left" id="TodayStatsExit">
                                    <?= ((isset($DashboardCounters['total-exit'])) ? $DashboardCounters['total-exit'] : '-') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Total Pilgrims                       -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainPilgrimsChat">
                <div class="widget widget-five">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Total Pilgrims</h6>
                            </div>

                        </div>
                        <div class="widget-content">
                            <div id="LoadPilgrimsChat" class="text-center" align="center">
                                <div class="spinner-grow text-warning align-self-center loader-position"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= ((isset($B2bAgents) && $B2bAgents != '') ? $B2bAgents : '-') ?></h6>
                                <p class=""><a href="<?= $path ?>reports/b2b_agent" target="_blank"> B2B Agent</a></p>
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
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= ((isset($ExternalAgents) && $ExternalAgents != '') ? $ExternalAgents : '-') ?></h6>
                                <p class=""><a href="<?= $path ?>reports/external_agent" target="_blank"> External
                                        Agent</a></p>

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
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= ((isset($SubAgents) && $SubAgents != '') ? $SubAgents : '-') ?></h6>
                                <p class=""><a href="<?= $path ?>reports/external_agent" target="_blank"> Sub
                                        Agent</a></p>

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
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= ((isset($AllActiveAgents) && $AllActiveAgents != '') ? $AllActiveAgents : '-') ?></h6>
                                <p class=""><a href="<?= $path ?>reports/active_agent" target="_blank"> Active Agent</a>
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
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= ((isset($AllInActiveAgents) && $AllInActiveAgents != '') ? $AllInActiveAgents : '-') ?></h6>
                                <p class=""><a href="<?= $path ?>reports/in_active_agent" target="_blank">In Active
                                        Agent</a></p>

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
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <h6 class="value"><?= ((isset($AllAgents) && $AllAgents != '') ? $AllAgents : '-') ?></h6>
                                <p class=""><a href="javascript:void(0);"> Total Agents</a></p>
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
            <!--            Groups                       -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainGroupStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> Arrival </h6>
                                <p class="meta-date" id="GroupStatsDate"></p>
                            </div>

                        </div>
                        <div class="widget-content p-1 text-center">
                            <div id="GroupStatsRecords">
                                <!--                                <div class="spinner-grow text-warning align-self-center loader-position"></div>-->
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Jeddah Arrival</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['activity-jeddah-arrival-status'])) ? $DashboardCounters['activity-jeddah-arrival-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Medina Arrival</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['activity-medina-arrival-status'])) ? $DashboardCounters['activity-medina-arrival-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Yanbu Arrival</h4>
                                                <p class="meta-date"></p>
                                            </div>
                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['activity-yanbu-arrival-status'])) ? $DashboardCounters['activity-yanbu-arrival-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Sea Arrival</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['arrival-activity-by-sea'])) ? $DashboardCounters['arrival-activity-by-sea'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>By Road Arrival</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['arrival-activity-by-land'])) ? $DashboardCounters['arrival-activity-by-land'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Total Arrival</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <?php
                                                $TotalArrival = $DashboardCounters['activity-jeddah-arrival-status'] + $DashboardCounters['activity-medina-arrival-status'] + $DashboardCounters['activity-sea-arrival-status'] + $DashboardCounters['activity-yanbu-arrival-status'] + $DashboardCounters['activity-by-road-arrival-status'];

                                                ?>
                                                <span><?= ((isset($TotalArrival)) ? $TotalArrival : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Transaction                       -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainTransactionStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> Check in & Check out</h6>
                                <p class="meta-date" id="TransactionStatsDate"></p>
                            </div>

                        </div>
                        <div class="widget-content p-1 text-center">
                            <div id="TransactionStatsRecords">
                                <!--                                <div class="spinner-grow text-warning align-self-center loader-position"></div>-->
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Check in Mecca</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <span><?= ((isset($DashboardCounters['activity-check-in-mecca-status'])) ? $DashboardCounters['activity-check-in-mecca-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Check in Medina</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <span><?= ((isset($DashboardCounters['activity-check-in-medina-status'])) ? $DashboardCounters['activity-check-in-medina-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Check In Jeddah</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <span><?= ((isset($DashboardCounters['activity-check-in-jeddah-status'])) ? $DashboardCounters['activity-check-in-jeddah-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Check out Mecca</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <span><?= ((isset($DashboardCounters['activity-check-out-mecca-status'])) ? $DashboardCounters['activity-check-in-mecca-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Check out Medina</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <span><?= ((isset($DashboardCounters['activity-check-out-medina-status'])) ? $DashboardCounters['activity-check-in-medina-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Check out Jeddah</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <span><?= ((isset($DashboardCounters['activity-check-out-jeddah-status'])) ? $DashboardCounters['activity-check-in-jeddah-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Entry Exit ELM                       -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainGroupStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> Departure </h6>
                                <p class="meta-date" id="GroupStatsDate"></p>
                            </div>

                        </div>
                        <div class="widget-content p-1 text-center">
                            <div id="GroupStatsRecords">
                                <!--                                <div class="spinner-grow text-warning align-self-center loader-position"></div>-->
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Jeddah Departure</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['activity-departure-jeddah-status'])) ? $DashboardCounters['activity-departure-jeddah-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Medina Departure</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['activity-departure-medina-status'])) ? $DashboardCounters['activity-departure-medina-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Yanbu Departure</h4>
                                                <p class="meta-date"></p>
                                            </div>
                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['activity-departure-yanbu-status'])) ? $DashboardCounters['activity-departure-yanbu-status'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Sea Departure</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['departure-activity-by-sea'])) ? $DashboardCounters['departure-activity-by-sea'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>By Road Departure</h4>
                                                <p class="meta-date"></p>
                                            </div>
                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['departure-activity-by-land'])) ? $DashboardCounters['departure-activity-by-land'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">

                                            <div class="t-name">
                                                <h4>Total Departure</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <?php
                                                $TotalArrival = $DashboardCounters['activity-departure-jeddah-status'] + $DashboardCounters['activity-departure-medina-status'] + $DashboardCounters['activity-departure-yanbu-status'] + $DashboardCounters['activity-departure-sea-status'] + $DashboardCounters['activity-departure-by-road-status'];

                                                ?>
                                                <span><?= ((isset($TotalArrival)) ? $TotalArrival : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="MainAgentsMonthlyChart">
                <div class="widget widget-five">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Monthly Pilgrims</h6>
                                <p class="meta-date" id="agentsChartMonthlyDate"></p>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div id="loadAgentsMonthlyChart" class="text-center" align="center">
                                <div class="spinner-grow text-warning align-self-center loader-position"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="MainAgentsYearlyChart">
                <div class="widget widget-five">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Yearly Pilgrims</h6>
                                <p class="meta-date" id="agentsChartYearlyDate"></p>
                            </div>

                        </div>
                        <div class="widget-content">
                            <div id="loadAgentsYearlyChart" class="text-center" align="center">
                                <div class="spinner-grow text-warning align-self-center loader-position"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row layout-top-spacing">

            <!--            Recent Activities                       -->
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="MainRecentActivities">
                <div class="widget widget-five widget-activity-four">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Today Activities</h6>
                                <!--                                <p class="meta-date" id="RecentActivitiesDate"> </p>-->
                            </div>
                        </div>
                        <div class="widget-content">
                            <div class="mt-container mx-auto mt-4" style="height: auto;">
                                <div class="timeline-line text-center" id="RecentActivitiesRecords">
                                    <div class="spinner-grow text-warning align-self-center loader-position"></div>
                                </div>
                            </div>
                            <div class="tm-action-btn">
                                <button class="btn" onclick="location.href='<?= $path ?>setting/activity_Log'">View
                                    All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="MainRecentActivities">
                <div class="widget widget-five widget-activity-four">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body" style="width: 100%;">
                                <h6 class="float-left">Activity History </h6>
                                <p class="meta-date float-right" id="RecentActivitiesDate"></p>

                            </div>
                        </div>
                        <div class="widget-content">
                            <div class="mt-container mx-auto mt-4" style="height: auto;">
                                <div class="timeline-line text-center" id="RecentActivitiesRecords">
                                    <div class="spinner-grow text-warning align-self-center loader-position"></div>
                                </div>
                            </div>
                            <div class="tm-action-btn">
                                <button class="btn" onclick="location.href='<?= $path ?>setting/activity_Log'">View
                                    All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?= $template ?>plugins/flatpickr/flatpickr.js"></script>
<script type="application/javascript">
    function LoadTodayStats() {
        //  $("#MainTodayStats #TodayStatsEntered").html("");
        // $("#MainTodayStats #TodayStatsExit").html("");
        result = AjaxResponse("dashboard_ajax/today_stats", "");

        // $("#MainRecentActivities #RecentActivitiesDate").html(result.date_html);
        // $("#MainTodayStats #TodayStatsEntered").html(result.today_enter);
        // $("#MainTodayStats #TodayStatsExit").html(result.today_exit);

        setInterval(function () {
            // LoadTodayStats()
        }, 60000)
    }

    var f3 = flatpickr(document.getElementById('rangeCalendarFlatpickr'), {
        mode: "range",
    });

    // function LoadGroupStats(dateString) {
    //     $("#MainGroupStats #GroupStats").html("");
    //     result = AjaxResponse("dashboard_ajax/group_stats", "date=" + dateString);
    //
    //     $("#MainGroupStats #GroupStatsDate").html(result.date_html);
    //
    //     setInterval(function () {
    //         // LoadGroupStats(dateString)
    //     }, 60000)
    // }
    //
    // function LoadTransactionStats(dateString) {
    //     $("#MainTransactionStats #TransactionStats").html("");
    //     result = AjaxResponse("dashboard_ajax/transaction_stats", "date=" + dateString);
    //
    //     $("#MainTransactionStats #TransactionStatsDate").html(result.date_html);
    //     // $("#MainTransactionStats #TransactionStatsRecords").html(result.record_html);
    //
    //     setInterval(function () {
    //         // LoadTransactionStats(dateString)
    //     }, 60000)
    // }
    //
    // function LoadELMStats(dateString) {
    //     $("#MainELMStats #ELMStats").html("");
    //     result = AjaxResponse("dashboard_ajax/elm_stats", "date=" + dateString);
    //
    //     $("#MainELMStats #ELMStatsDate").html(result.date_html);
    //     // $("#MainELMStats #ELMStatsRecords").html(result.record_html);
    //
    //     setInterval(function () {
    //         // LoadELMStats(dateString)
    //     }, 60000)
    // }
    //

    function LoadRecentActivities(dateString, limit) {
        $("#MainRecentActivities #RecentActivitiesRecords").html("");
        result = AjaxResponse("dashboard_ajax/recent_activities", "date=" + dateString + "&limit=" + limit);

        $("#MainRecentActivities #RecentActivitiesDate").html(result.date_html);
        $("#MainRecentActivities #RecentActivitiesRecords").html(result.record_html);

        setInterval(function () {
            // LoadRecentActivities(dateString, 10)
        }, 60000)
    }

    function LoadPilgrimsChat() {
        $("#MainPilgrimsChat #LoadPilgrimsChat").html("");
        var result = AjaxResponse("dashboard_ajax/pilgrims_chat");
//alert(JSON.stringify(result));
        // $("#MainPilgrimsChat #PilgrimsChatDate").html(result.date_html);

        var options = {
            chart: {
                type: 'donut',
                width: '100%'
            },
            colors: ['#5c1ac3', '#e2a03f', '#e7515a', '#E9BA5F'],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '14px',
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
                        size: '100%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '29px',
                                fontFamily: 'Nunito, sans-serif',
                                color: undefined,
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '26px',
                                fontFamily: 'Nunito, sans-serif',
                                color: '#000',
                                offsetY: 16,
                                formatter: function (val) {
                                    console.log(val);
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                color: '#dda420',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce(function (a, b) {
                                        return parseInt(a) + parseInt(b)
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            stroke: {
                show: true,
                width: 25
            },
            series: [result.total_enter, result.total_exit, result.total_process, result.inprocess],
            labels: ['Entered', 'Exits', 'In KSA', 'In Process'],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '100%',
                        height: '400px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },

                breakpoint: 1439,
                options: {
                    chart: {
                        width: '100%',
                        height: '390px'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                            }
                        }
                    }
                },
            }]

        }
        var chart = new ApexCharts(
            document.querySelector("#LoadPilgrimsChat"),
            options
        );

        chart.render();

        setInterval(function () {
            // LoadPilgrimsChat(dateString)
        }, 60000)
    }

    function loadAgentsChart() {
        $("#MainAgentsChart #loadAgentsChart").html("");
        result = AjaxResponse("dashboard_ajax/<?=$pilgrimChart?>");
        $("#MainAgentsChart #agentsChartDate").html(result.agent);
        var options1 = {
            chart: {
                height: 450,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Total Pilgrims',
                data: result.data
            }],
            xaxis: {
                categories: result.label,
            },
            yaxis: {},
            fill: {
                opacity: 1,
                colors: ['#dda420']

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            }
        }

        var chart1 = new ApexCharts(
            document.querySelector("#loadAgentsChart"),
            options1
        );

        chart1.render();

        setInterval(function () {
            // loadAgentsChart(agent)
        }, 60000)
    }

    function loadAgentsMonthlyChart() {

        $("#MainAgentsMonthlyChart #loadAgentsMonthlyChart").html("");
        var result = AjaxResponse("dashboard_ajax/new_monthly_pilgrims");

        var options = {
            series: result.data,
            chart: {
                type: 'bar',
                height: 450
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '65%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            xaxis: {
                categories: result.labels,
            },
            yaxis: {
                title: {}
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Pilgrims"
                    }
                }
            }
        };

        var chart1 = new ApexCharts(
            document.querySelector("#loadAgentsMonthlyChart"),
            options
        );
        chart1.render();
    }

    /*function oldloadAgentsMonthlyChart() {
        $("#MainAgentsMonthlyChart #loadAgentsMonthlyChart").html("");
        result = AjaxResponse("dashboard_ajax/monthly_pilgrims");
        $("#MainAgentsMonthlyChart #agentsChartYearlyDate").html(result.agent);
        var options1 = {
            chart: {
                height: 450,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Revenue',
                data: result.data
            }],
            xaxis: {
                categories: result.label,
            },
            yaxis: {},
            fill: {
                opacity: 1,
                colors: ['#dda420']

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Pilgrims"
                    }
                }
            }
        }

        var chart1 = new ApexCharts(
            document.querySelector("#loadAgentsMonthlyChart"),
            options1
        );

        chart1.render();

        setInterval(function () {
            // loadAgentsChart(agent)
        }, 60000)
    }*/


    function loadAgentsYearlyChart() {
        $("#MainAgentsYearlyChart #loadAgentsYearlyChart").html("");
        result = AjaxResponse("dashboard_ajax/yearly_pilgrims");
        $("#MainAgentsYearlyChart #agentsChartYearlyDate").html(result.agent);
        var options1 = {
            chart: {
                height: 450,
                type: 'bar',
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Revenue',
                data: result.data
            }],
            xaxis: {
                categories: result.label,
            },
            yaxis: {},
            fill: {
                opacity: 1,
                colors: ['#dda420']

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Pilgrims"
                    }
                }
            }
        }

        var chart1 = new ApexCharts(
            document.querySelector("#loadAgentsYearlyChart"),
            options1
        );

        chart1.render();

        setInterval(function () {
            // loadAgentsChart(agent)
        }, 60000)
    }


    setTimeout(function () {
        var agentId = $('#MainAgentsChart #agent').val();
        loadAgentsChart(agentId);
        loadAgentsMonthlyChart(agentId);
        loadAgentsYearlyChart(agentId);
        LoadRecentActivities('current-month', 10);
        LoadTodayStats();
        //LoadGroupStats('current-month');
        //LoadTransactionStats('current-month');
        //LoadELMStats('current-month');
        LoadPilgrimsChat();
    }, 1000)
</script>
