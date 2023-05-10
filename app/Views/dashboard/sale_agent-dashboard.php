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
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 layout-spacing">
                <h4>Welcome "<?= $session['name'] ?>" as <?= $user_types[$session['type']] ?>Account (Sale-Agent
                    Dashboard)</h4>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 layout-spacing">
                <a type="button" style="margin: 8px;" class="btn btn_customized  btn-sm float-right"
                   href=" ">Date Filter Apply</a>
                <input id="rangeCalendarFlatpickr" style="width: 65%;float: right !important;"
                       class="form-control flatpickr flatpickr-input active" type="text"
                       placeholder="Select Date..">
                </h4>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="SaleAgentsChart">
                <div class="widget widget-five">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Agent Wise Pilgrims</h6>
                                <p class="meta-date" id="agentsWiseChartDate"></p>
                            </div>
                            <!--                            <div class="col-md-4">-->
                            <!--                                <div class="">-->
                            <!--                                    <div class="form-group pull-right">-->
                            <!--                                        <select class="form-control chart-select no-select2 " title="Agents" id="agent"-->
                            <!--                                                name="agent" onchange="loadAgentsChart(this.value)">-->
                            <!--                                            <option value="0">All Agents</option>-->
                            <!--                                            --><?php
                            //                                            foreach ($Agents as $Agent) {
                            //                                                echo '<option value="' . $Agent['UID'] . '">' . $Agent['FullName'] . '</option>';
                            //                                            }
                            ?>
                            <!--                                        </select>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <div class="widget-content">
                            <div id="loadSaleAgentsChart" class="text-center" align="center">
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
                                    <?= ((isset($DashboardCounters['total-arrival'])) ? $DashboardCounters['total-arrival'] : '-') ?>
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

                            <!--                            <div class="task-action">-->
                            <!--                                <div class="dropdown  custom-dropdown">-->
                            <!--                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"-->
                            <!--                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                            <!--                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                            <!--                                             stroke-linecap="round" stroke-linejoin="round"-->
                            <!--                                             class="feather feather-more-horizontal">-->
                            <!--                                            <circle cx="12" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="19" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="5" cy="12" r="1"></circle>-->
                            <!--                                        </svg>-->
                            <!--                                    </a>-->
                            <!---->
                            <!--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadGroupStats('today');">Today</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadGroupStats('yesterday');">Yesterday</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadGroupStats('current-week');">Current Week</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadGroupStats('current-month');">Current Month</a>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
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
                                                <span><?= ((isset($DashboardCounters['activity-sea-arrival-status'])) ? $DashboardCounters['activity-sea-arrival-status'] : '-') ?></span>
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
                                                <span><?= ((isset($DashboardCounters['activity-by-road-arrival-status'])) ? $DashboardCounters['activity-by-road-arrival-status'] : '-') ?></span>
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
                                                <?php $TotalArrival = $DashboardCounters['activity-jeddah-arrival-status'] + $DashboardCounters['activity-medina-arrival-status'] + $DashboardCounters['activity-sea-arrival-status'] + $DashboardCounters['activity-yanbu-arrival-status'] + $DashboardCounters['activity-by-road-arrival-status'];  ?>
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

                            <!--                            <div class="task-action">-->
                            <!--                                <div class="dropdown  custom-dropdown">-->
                            <!--                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"-->
                            <!--                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                            <!--                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                            <!--                                             stroke-linecap="round" stroke-linejoin="round"-->
                            <!--                                             class="feather feather-more-horizontal">-->
                            <!--                                            <circle cx="12" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="19" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="5" cy="12" r="1"></circle>-->
                            <!--                                        </svg>-->
                            <!--                                    </a>-->
                            <!---->
                            <!--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadTransactionStats('today');">Today</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadTransactionStats('yesterday');">Yesterday</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadTransactionStats('current-week');">Current Week</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadTransactionStats('current-month');">Current Month</a>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
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
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainELMStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> ENTRY & EXIT </h6>
                                <p class="meta-date" id="ELMStatsDate"></p>
                            </div>

                            <!--                            <div class="task-action">-->
                            <!--                                <div class="dropdown  custom-dropdown">-->
                            <!--                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"-->
                            <!--                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                            <!--                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                            <!--                                             stroke-linecap="round" stroke-linejoin="round"-->
                            <!--                                             class="feather feather-more-horizontal">-->
                            <!--                                            <circle cx="12" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="19" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="5" cy="12" r="1"></circle>-->
                            <!--                                        </svg>-->
                            <!--                                    </a>-->
                            <!---->
                            <!--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadELMStats('today');">Today</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadELMStats('yesterday');">Yesterday</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadELMStats('current-week');">Current Week</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadELMStats('current-month');">Current Month</a>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <div class="widget-content p-1 text-center">
                            <div id="ELMStatsRecords">
                                <!--                                <div class="spinner-grow text-warning align-self-center loader-position"></div>-->
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Package</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['voucher-package'])) ? $DashboardCounters['voucher-package'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Visa & Transport</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['visa-transport'])) ? $DashboardCounters['visa-transport'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Hotel</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['hotel-package'])) ? $DashboardCounters['hotel-package'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Transport</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p>
                                                <span><?= ((isset($DashboardCounters['transport-package'])) ? $DashboardCounters['transport-package'] : '-') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Dep Jeddah/Mecca/Yanbu</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <!--                                            <span>-->
                                            <? //= ((isset($DashboardCounters['without-hotel-arrival'])) ? $DashboardCounters['without-hotel-arrival'] : '-') ?><!--</span>-->
                                            <span>N/A</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4>Dep Medina</h4>
                                                <p class="meta-date"></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <!--                                            <span>-->
                                            <? //= ((isset($DashboardCounters['without-hotel-arrival'])) ? $DashboardCounters['without-hotel-arrival'] : '-') ?><!--</span>-->
                                            <span>N/A</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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
                            <div class="header-body">
                                <h6>Activity History</h6>
                                <p class="meta-date" id="RecentActivitiesDate"></p>
                            </div>

                            <!--                            <div class="task-action">-->
                            <!--                                <div class="dropdown  custom-dropdown">-->
                            <!--                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"-->
                            <!--                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
                            <!--                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"-->
                            <!--                                             stroke-linecap="round" stroke-linejoin="round"-->
                            <!--                                             class="feather feather-more-horizontal">-->
                            <!--                                            <circle cx="12" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="19" cy="12" r="1"></circle>-->
                            <!--                                            <circle cx="5" cy="12" r="1"></circle>-->
                            <!--                                        </svg>-->
                            <!--                                    </a>-->
                            <!---->
                            <!--                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadRecentActivities('today', 10);">Today</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadRecentActivities('yesterday', 10);">Yesterday</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadRecentActivities('current-week', 10);">Current Week</a>-->
                            <!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
                            <!--                                           onclick="LoadRecentActivities('current-month', 10);">Current Month</a>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
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
                        size: '65%',
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
                width: 25
            },
            series: [result.total_enter, result.total_exit, result.total_process, result.inprocess],
            labels: ['Entered', 'Exits', 'In KSA', 'In Process'],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '350px',
                        height: '400px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                },

                breakpoint: 1439,
                options: {
                    chart: {
                        width: '250px',
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
        result = AjaxResponse("dashboard_ajax/pilgrims_chart");
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
            document.querySelector("#loadAgentsChart"),
            options1
        );

        chart1.render();

        setInterval(function () {
            // loadAgentsChart(agent)
        }, 60000)
    }

    function loadSaleAgentsChart() {
        $("#SaleAgentsChart #loadSaleAgentsChart").html("");
        result = AjaxResponse("dashboard_ajax/sale_agent_pilgrims_chart");
        $("#SaleAgentsChart #agentsWiseChartDate").html(result.agent);
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
                name: 'Total',
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
            document.querySelector("#loadSaleAgentsChart"),
            options1
        );

        chart1.render();

        setInterval(function () {
            // loadAgentsChart(agent)
        }, 60000)
    }

    setTimeout(function () {
        var AgentUID = "<?=$session['id']?>";
        <?php
        if ($session['account_type'] == 'sale_agent') { ?>
        loadSaleAgentsChart(AgentUID);
        <?php } else {  ?>
        loadAgentsChart(AgentUID);
        <?php }?>
        LoadPilgrimsChat();
        LoadRecentActivities('current-month', 10);
        LoadTodayStats();

        //LoadGroupStats('current-month');
        //LoadTransactionStats('current-month');
        //LoadELMStats('current-month');
    }, 1000)
</script>
