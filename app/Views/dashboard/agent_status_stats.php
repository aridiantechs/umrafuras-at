<link rel="stylesheet" type="text/css" href="<?= $template ?>umrahfuras-dashboard.css">
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/report-statistics.css">
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/umrahfuras-dashboard.css">
<?php

use App\Models\Crud;

$Crud = new Crud();

$PAGEJS = '';
?>
<style>
    #ReportsPage a {
        color: white;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing" id="ReportsPage">
        <div class="page-header">
            <div class="page-title">
                <h3>Stats</h3>
            </div>
        </div>

        <div class="row analytics">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four voucher-box p-2">
                    <div class="widget-content"><? //=print_r($DashboardCounters);?>
                        <div class="w-content">
                            <div class="w-info">
                                <div class="yellow-circle"></div>
                                <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['total-b2c'])) ? $DashboardCounters['total-b2c'] : '0') + ((isset($DashboardCounters['total-b2b-pilgrim'])) ? $DashboardCounters['total-b2b-pilgrim'] : '0') + ((isset($DashboardCounters['total-external-pilgrim'])) ? $DashboardCounters['total-external-pilgrim'] : '0') ?></h6>
                                <div class="w-summary-details">
                                    <div class="w-summary-stats">
                                        <div class="progress for-yellow-bar">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                 style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/total_pax"
                                                                      target="_blank" style="color: #888ea8">
                                        Total Pax</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four voucher-box p-2">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <div class="lightseagreen-circle"></div>
                                <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['pax-in-mecca'])) ? $DashboardCounters['pax-in-mecca'] : '-') ?></h6>
                                <div class="w-summary-details">
                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                 style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_mecca"
                                                                      target="_blank" style="color: #888ea8">  Pax in
                                        Mecca</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four voucher-box p-2">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <div class="yellow-circle"></div>
                                <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['pax-in-medina'])) ? $DashboardCounters['pax-in-medina'] : '-') ?></h6>
                                <div class="w-summary-details">
                                    <div class="w-summary-stats">
                                        <div class="progress for-yellow-bar">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                 style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_medina"
                                                                      target="_blank" style="color: #888ea8">  Pax in
                                        Medinah</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four voucher-box p-2">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <div class="blue-circle"></div>
                                <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['pax-in-jeddah'])) ? $DashboardCounters['pax-in-jeddah'] : '-') ?></h6>
                                <div class="w-summary-details">
                                    <div class="w-summary-stats">
                                        <div class="progress for-blue-bar">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                 style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_jeddah"
                                                                      target="_blank" style="color: #888ea8">  Pax in
                                        Jeddah</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-card-four voucher-box p-2">
                    <div class="widget-content">
                        <div class="w-content">
                            <div class="w-info">
                                <div class="orange-circle"></div>
                                <h6 class="value text-center mt-4"><?php
                                    $Total = ((isset($DashboardCounters['pax-in-mecca'])) ? $DashboardCounters['pax-in-mecca'] : '0') + ((isset($DashboardCounters['pax-in-jeddah'])) ? $DashboardCounters['pax-in-jeddah'] : '0') + ((isset($DashboardCounters['pax-in-medina'])) ? $DashboardCounters['pax-in-medina'] : '0');    ?>
                                    <?= ((isset($Total)) ? $Total : '-') ?></h6>
                                <div class="w-summary-details">
                                    <div class="w-summary-stats">
                                        <div class="progress for-orange-bar">
                                            <div class="progress-bar bg-gradient-success" role="progressbar"
                                                 style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_saudi_arabia"
                                                                      target="_blank" style="color: #888ea8">  Total Pax
                                        in Saudi Arabia</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 col-lg-12 col-md-7">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/voucher_not_issued" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="VoucherNotIssueChart" class=""
                                                     style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="yellow-box text-center mb-2">Voucher Not Issue</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "VoucherNotIssueChart",
                                          "color": "#dea41f",
                                          "labels": { "A": "Not Issued", "B": "Issued" },
                                          "series": { "A": ' . ($DashboardCounters['travel-voucher-not-issued'] + 0) . ', "B": ' . ($DashboardCounters['travel-voucher-issued'] + 0) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/voucher_issued" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="VoucherIssueChart" class="" style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="blue-box text-center mb-2">  Voucher Issued</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "VoucherIssueChart",
                                          "color": "#4f6cfd",
                                          "labels": { "A": "Issued", "B": "Not Issued" },
                                          "series": { "A": ' . ($DashboardCounters['travel-voucher-issued'] + 0) . ', "B": ' . ($DashboardCounters['travel-voucher-not-issued'] + 0) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/arrival_airport" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="ArrivalChart" class="" style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="green-box text-center mb-2">  Arrival</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "ArrivalChart",
                                          "color": "#8ac344",
                                          "labels": { "A": "Jeddah Arrival", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['total-arrival'] + 0) . ', "B": ' . (($DashboardCounters['mofa-issued'] - $DashboardCounters['total-arrival']) + 0) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/check_in_medina" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="ChecKinMedina" class="" style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="orange-box text-center mb-2">  Check in Medina</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "ChecKinMedina",
                                          "color": "#f77925",
                                          "labels": { "A": "Check In Medina", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['check-in-medina'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['check-in-medina']) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-12 col-md-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/check_in_mecca" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="CheckInMakkah" class="" style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="blue-box text-center mb-2">  Check in Mecca</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "CheckInMakkah",
                                          "color": "#4f6cfd",
                                          "labels": { "A": "Check In Mecca", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['check-in-mecca'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['check-in-mecca']) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/check_in_jeddah" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="CheckInJeddah" class="" style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="lightseagreen-box text-center mb-2">  Check in Jeddah</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "CheckInJeddah",
                                          "color": "#49b0a4",
                                          "labels": { "A": "Check In Jeddah", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['check-in-jeddah'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['check-in-jeddah']) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <a href="<?= $path ?>reports/pilgrim_exit" target="_blank">
                                            <div class="widget-content for-bottom-mrg">
                                                <div id="Exit" class="" style="min-height: 220px;"></div>
                                            </div>
                                        </a>
                                        <div class="pink-box text-center mb-2">  Exit</div>
                                        <?php
                                        $PAGEJS .= '
                                        htmldata = {
                                          "divid": "Exit",
                                          "color": "#e2525d",
                                          "labels": { "A": "Exit From KSA", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['total-exit'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['total-exit']) . ' }
                                        };                                       
                                        LoadDashboardStatChart(htmldata); '; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layout-px-spacing">
        <div class="analytics">
            <div class="row p-2">
                <div class="col-lg-12">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>Reports </h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-1.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">  Manage
                                        Pilgrim Report</h6>
                                    <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/pilgrim_list" target="_blank" style="color: white;"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-2.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">  Pilgrim
                                        Count</h6>
                                    <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/pilgrim_count" target="_blank" style="color: white;"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">  Group
                                        Stats</h6>
                                    <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/group_stats" target="_blank" style="color: white;"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-19.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">  Agent
                                        Work Report</h6>
                                    <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/agent_work_report" target="_blank" style="color: white;"> Read
                                            More</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                        ** Late Departure
                                    </h6>
                                    <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/late_departure" target="_blank" style="color: white;"> Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">** Passport
                                        Pending</h6>
                                    <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/passport_pending" target="_blank" style="color: white;"> Read
                                            More</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100">
                                    <div class="rs-icon pb-3"><img
                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png"></div>
                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">** Passport
                                        Complete</h6>
                                    <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                        <a href="<?= $path ?>reports/passport_completed" target="_blank" style="color: white;"> Read
                                            More</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
            </div>
        </div>
    </div>
</div>

<script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>

<script type="text/javascript">

    //function LoadReportsFunc(page) {
    //    window.open('<?//= $path ?>//reports/'+page, '_blank');
    //}
    function LoadHotelsStat() {
        result = AjaxResponse("dashboard_ajax/hotel_stats");

        $("#HotelStats #Load5StarHotelsStat").html(result.five_star);
        $("#HotelStats #Load4StarHotelsStat").html(result.four_star);
        $("#HotelStats #Load3StarHotelsStat").html(result.three_star);
        $("#HotelStats #Load2StarHotelsStat").html(result.two_star);
        $("#HotelStats #Load1StarHotelsStat").html(result.one_star);
        $("#HotelStats #LoadEconomyHotelsStat").html(result.economy);

    }

    // function LoadCounts() {
    //     Counts = AjaxResponse("dashboard_ajax/all_counts");
    //     $("#B2cCount #B2C").html(Counts.b2c);
    //     $("#B2bCount #B2B").html(Counts.b2b);
    //     $("#ExternalAgents #External").html(Counts.external_agents);
    //     $("#TotalPilgrim #TotalPax").html(Counts.TotalPax);
    //
    // }

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
        LoadHotelsStat();
        // LoadCounts();
        <?=$PAGEJS?>
    }, 1000)
</script>
