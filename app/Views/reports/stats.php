<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/report-statistics.css">
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/umrahfuras-dashboard.css">
<style>
    #reports_page a {
        color: white;
    }
</style>

<div class="main-container sidebar-closed sbar-open" id="reports_page" style="width: 100%">
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="analytics">
                <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_manage_pilgrim_report']
                    || $CheckAccess['umrah_reports_stats_pilgrim_management_pilgrim_count_report']
                    || $CheckAccess['umrah_reports_stats_pilgrim_management_group_stats_report']
                    || $CheckAccess['umrah_reports_stats_pilgrim_management_elm_data_summary_daywise_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Pilgrim Management </h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_manage_pilgrim_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-1.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Manage
                                                    Pilgrim Report</h6>
                                                <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/pilgrim_list" target="_blank"> Read
                                                        More *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_pilgrim_count_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-2.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Pilgrim
                                                    Count</h6>
                                                <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/pilgrim_count" target="_blank"> Read
                                                        More *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_group_stats_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Group
                                                    Stats</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/group_stats" target="_blank"> Read More
                                                        *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_pilgrim_management_elm_data_summary_daywise_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    ELM Data
                                                    Summary DayWise</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/elm_summary_daywise" target="_blank">
                                                        Read
                                                        More *</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!--<div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="rs-icon pb-3"><img
                                                    src="<? /*= $template */ ?>assets/img/rs-icons/icon-rs-4.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Report
                                            Creator</h6>
                                        <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<? /*= $path */ ?>reports/report_creator" target="_blank"> Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    </div> <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_statistics_status_summary_report']
                    || $CheckAccess['umrah_reports_stats_statistics_agent_monitor_screen_report']
                    || $CheckAccess['umrah_reports_stats_statistics_external_monitor_screen_report']
                    || $CheckAccess['umrah_reports_stats_statistics_agent_work_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Statistics</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_statistics_status_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Status
                                                    Summary Report</h6>
                                                <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <!--                                            <a href="-->
                                                    <? //= $path ?><!--reports/summary_report" target="_blank"> Read More</a>-->
                                                    <a href="<?= $path ?>home/stats" target="_blank"> Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_statistics_agent_monitor_screen_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-6.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Agent
                                                    Monitor Screen Report </h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/agent_monitor_screen" target="_blank">
                                                        Read
                                                        More ***</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_statistics_external_monitor_screen_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-7.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    External
                                                    Agent Monitor Screen</h6>
                                                <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/external_agent_monitor_screen"
                                                       target="_blank">
                                                        Read More ***</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_statistics_agent_work_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-19.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Agent
                                                    Work Report</h6>
                                                <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/agent_work_report" target="_blank">
                                                        Read
                                                        More *</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_arrival_airport_report']
                    || $CheckAccess['umrah_reports_stats_arrival_departure_late_departure_report']
                    || $CheckAccess['umrah_reports_stats_arrival_departure_departure_airport_report']
                    || $CheckAccess['umrah_reports_stats_arrival_departure_departure_hotel_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Arrival / Departure</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_arrival_airport_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-13.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Arrival
                                                    Airport</h6>
                                                <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/arrival_airport" target="_blank"> Read
                                                        More
                                                        *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_late_departure_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Late Departure
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/late_departure" target="_blank"> Read
                                                        More
                                                        *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_departure_airport_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-15.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Departure
                                                    Airport</h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/departure_airport" target="_blank">
                                                        Read
                                                        More **</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_arrival_departure_departure_hotel_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-16.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Departure
                                                    Hotel</h6>
                                                <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/departure_hotel" target="_blank"> Read
                                                        More
                                                        **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_hotel_arrival_hotel_report']
                    || $CheckAccess['umrah_reports_stats_hotel_actual_hotel_report']
                    || $CheckAccess['umrah_reports_stats_hotel_bed_loss_report']
                    || $CheckAccess['umrah_reports_stats_hotel_hotel_summary_report']
                    || $CheckAccess['umrah_reports_stats_hotel_hotel_arrangement_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Hotel</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_hotel_arrival_hotel_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-14.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Arrival
                                                    Hotel</h6>
                                                <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/arrival_hotel" target="_blank"> Read
                                                        More
                                                        **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_hotel_actual_hotel_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3">
                                                    <img src="<?= $template ?>assets/img/rs-icons/icon-rs-9.png"></div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Actual Hotel Report</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/hotel" target="_blank"> Read More *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_hotel_bed_loss_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3">
                                                    <img src="<?= $template ?>assets/img/rs-icons/icon-rs-17.png"></div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Bed Loss
                                                </h6>
                                                <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/bed_loss" target="_blank"> Read More
                                                        **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_hotel_hotel_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3">
                                                    <img src="<?= $template ?>assets/img/rs-icons/icon-rs-10.png"></div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Hotel
                                                    Summary</h6>
                                                <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/hotel_summary" target="_blank"> Read
                                                        More
                                                        **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_hotel_hotel_arrangement_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3">
                                                    <img src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png"></div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Hotel
                                                    Arrangement Report
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/hotel_arrangement" target="_blank">
                                                        Read
                                                        More **</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_transport_actual_used_report']
                    || $CheckAccess['umrah_reports_stats_transport_seat_loss_report']
                    || $CheckAccess['umrah_reports_stats_transport_arrival_summary_report']
                    || $CheckAccess['umrah_reports_stats_transport_used_transport_summary_report']
                    || $CheckAccess[' umrah_reports_stats_transport_vehicle_arrangement_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Transport</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_transport_actual_used_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-11.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Actual Used Transport</h6>
                                                <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/transport" target="_blank"> Read More
                                                        **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_transport_seat_loss_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-12.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Seat Loss
                                                </h6>
                                                <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/seat_loss" target="_blank"> Read More
                                                        **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_transport_arrival_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-8.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Arrival
                                                    Summary Report</h6>
                                                <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/arrival_summary_layout"
                                                       target="_blank">
                                                        Read
                                                        More **</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_transport_used_transport_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-12.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Used Transport Summary</h6>
                                                <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/transport_summary" target="_blank">
                                                        Read
                                                        More **</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_transport_vehicle_arrangement_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Vehicle
                                                    Arrangement Report
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/vehicle_arrangement" target="_blank">
                                                        Read
                                                        More **</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_issue_report']
                        || $CheckAccess['umrah_reports_stats_voucher_voucher_not_approved_report']
                        || $CheckAccess['umrah_reports_stats_voucher_approved_voucher_report']
                        || $CheckAccess['umrah_reports_stats_voucher_update_voucher_report']
                        || $CheckAccess['umrah_reports_stats_voucher_refund_voucher_report']
                        || $CheckAccess['umrah_reports_stats_voucher_executed_voucher_report']
                        || $CheckAccess['umrah_reports_stats_voucher_without_voucher_arrival_report']
                        || $CheckAccess['umrah_reports_stats_voucher_voucher_summary_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Voucher</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_issue_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 mb-xl-0 mb-lg-0 mb-md-3 mb-3">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-22.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Voucher
                                                    Issue Report</h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/voucher_issue_report" target="_blank">
                                                        Read
                                                        More **</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_not_approved_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 mb-xl-0 mb-lg-0 mb-md-3 mb-3">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-4.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Voucher
                                                    Not Approved

                                                </h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/pending_voucher_report"
                                                       target="_blank">Read
                                                        More **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_approved_voucher_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 mb-xl-0 mb-lg-0 mb-md-3 mb-3">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-4.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Approved
                                                    Voucher Report
                                                </h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/approved_voucher_report"
                                                       target="_blank">Read
                                                        More **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_update_voucher_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 mb-xl-0 mb-lg-0 mb-md-3 mb-3">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-10.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Update
                                                    Voucher Report
                                                </h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/update_voucher_list" target="_blank">Read
                                                        More **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_refund_voucher_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 mb-xl-0 mb-lg-0 mb-md-3 mb-3"
                                 style="margin-top: 25px;">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-4.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Refund
                                                    Voucher Report
                                                </h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/refund_voucher_list" target="_blank">Read
                                                        More ***</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_executed_voucher_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 mb-xl-0 mb-lg-0 mb-md-3 mb-3"
                                 style="margin-top: 25px;">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-4.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Executed
                                                    Voucher Report
                                                </h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/executed_voucher" target="_blank">Read
                                                        More
                                                        *</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_without_voucher_arrival_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4" style="margin-top: 25px;">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Without Voucher Arrival
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/without_voucher_arrival"
                                                       target="_blank"> Read
                                                        More **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4" style="margin-top: 25px;">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Voucher Summary
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/voucher_summary" target="_blank"> Read
                                                        More **</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>


                <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_purchase_report']
                    || $CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_use_visa_report ']
                    || $CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_balance_visa_report']
                    || $CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_use_actual_report']
                    || $CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_balance_actual_report']
                    || $CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_summary_report']

                    || $CheckAccess['umrah_reports_stats_brn_transport_transport_brn_purchase_report']
                    || $CheckAccess['umrah_reports_stats_brn_transport_transport_brn_use_visa_report']
                    || $CheckAccess['umrah_reports_stats_brn_transport_transport_brn_balance_visa_report']
                    || $CheckAccess['umrah_reports_stats_brn_transport_transport_brn_use_actual_report']
                    || $CheckAccess['umrah_reports_stats_brn_transport_transport_brn_balance_actual_report']
                    || $CheckAccess['umrah_reports_stats_brn_transport_transport_brn_summary_report']) { ?>
                    <div class="transport-hotel-brn">
                        <div class="row p-2">
                            <div class="col-lg-12">
                                <div class="page-header">
                                    <div class="page-title">
                                        <h3>BRN Hotel / Transport</h3>
                                    </div>
                                </div>
                            </div>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_purchase_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-7.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Hotel BRN Purchase
                                                    </h6>
                                                    <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/htl_purchase" target="_blank">
                                                            Read More *</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_use_visa_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-8.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Hotel BRN Use Visa
                                                    </h6>
                                                    <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/htl_use_visa" target="_blank"> Read
                                                            More *</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_balance_visa_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-11.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Hotel BRN Balance Visa
                                                    </h6>
                                                    <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/htl_balance_visa" target="_blank">
                                                            Read
                                                            More ***</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_use_actual_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-10.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Hotel BRN Use Actual
                                                    </h6>
                                                    <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/hotel_use_actual" target="_blank">
                                                            Read
                                                            More ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_balance_actual_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-11.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Hotel BRN Balance Actual
                                                    </h6>
                                                    <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/htl_balance_actual"
                                                           target="_blank"> Read
                                                            More ***</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_hotel_hotel_brn_summary_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-16.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Hotel BRN Summary
                                                    </h6>
                                                    <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/brn_summary_htl" target="_blank">
                                                            Read More
                                                            ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4">-->
                            <!--                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">-->
                            <!--                            <div class="widget-content">-->
                            <!--                                <div class="w-content">-->
                            <!--                                    <div class="w-info w-100">-->
                            <!--                                        <div class="rs-icon pb-3"><img-->
                            <!--                                                    src="-->
                            <? //= $template ?><!--assets/img/rs-icons/icon-rs-16.png"></div>-->
                            <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">-->
                            <!--                                            Hotel BRN Use-->
                            <!--                                        </h6>-->
                            <!--                                        <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                            <!--                                            <a href="-->
                            <? //= $path ?><!--reports/hotel_brn_use" target="_blank"> Read More</a>-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                        </div>

                        <div class="row p-2">
                            <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_purchase_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Transport BRN Purchase
                                                    </h6>
                                                    <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/trp_brn_purchase" target="_blank">
                                                            Read
                                                            More ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_use_visa_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Transport BRN use Visa
                                                    </h6>
                                                    <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/trp_use_visa" target="_blank"> Read
                                                            More
                                                            ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_balance_visa_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-7.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Transport BRN Balance Visa
                                                    </h6>
                                                    <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/trp_balance_visa" target="_blank">
                                                            Read More ***</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_use_actual_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-4.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Transport BRN Use Actual
                                                    </h6>
                                                    <div class="lightseagreen-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/trp_use_actual" target="_blank">
                                                            Read
                                                            More
                                                            ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_balance_actual_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Transport BRN Balance Actual
                                                    </h6>
                                                    <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/actual_trp_balance"
                                                           target="_blank">
                                                            Read
                                                            More ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($CheckAccess['umrah_reports_stats_brn_transport_transport_brn_summary_report']) { ?>
                                <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                    <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                        <div class="widget-content">
                                            <div class="w-content">
                                                <div class="w-info w-100">
                                                    <div class="rs-icon pb-3"><img
                                                                src="<?= $template ?>assets/img/rs-icons/icon-rs-17.png">
                                                    </div>
                                                    <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                        Transport BRN Summary
                                                    </h6>
                                                    <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                        <a href="<?= $path ?>reports/brn_summary_ptl" target="_blank">
                                                            Read
                                                            More
                                                            ***</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--                    <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">-->
                            <!--                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">-->
                            <!--                            <div class="widget-content">-->
                            <!--                                <div class="w-content">-->
                            <!--                                    <div class="w-info w-100">-->
                            <!--                                        <div class="rs-icon pb-3"><img-->
                            <!--                                                    src="-->
                            <? //= $template ?><!--assets/img/rs-icons/icon-rs-17.png"></div>-->
                            <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">-->
                            <!--                                            Transport BRN Use-->
                            <!--                                        </h6>-->
                            <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                            <!--                                            <a href="-->
                            <? //= $path ?><!--reports/transport_brn_use" target="_blank"> Read More</a>-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!--                        </div>-->
                            <!--                    </div>-->
                        </div>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_pending_report'] || $CheckAccess['umrah_reports_stats_passport_management_passport_complete_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Passport Management</h3>
                                </div>
                            </div>
                        </div>
                        <!--                    <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">-->
                        <!--                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">-->
                        <!--                            <div class="widget-content">-->
                        <!--                                <div class="w-content">-->
                        <!--                                    <div class="w-info w-100">-->
                        <!--                                        <div class="rs-icon pb-3"><img-->
                        <!--                                                    src="-->
                        <? //= $template ?><!--assets/img/rs-icons/icon-rs-17.png"></div>-->
                        <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Passport-->
                        <!--                                            Information Report</h6>-->
                        <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                        <!--                                            <a href="-->
                        <? //= $path ?><!--reports/elm_report" target="_blank"> Read More</a>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">-->
                        <!--                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">-->
                        <!--                            <div class="widget-content">-->
                        <!--                                <div class="w-content">-->
                        <!--                                    <div class="w-info w-100">-->
                        <!--                                        <div class="rs-icon pb-3"><img-->
                        <!--                                                    src="-->
                        <? //= $template ?><!--assets/img/rs-icons/icon-rs-18.png"></div>-->
                        <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Passport-->
                        <!--                                            Summary Daywise</h6>-->
                        <!--                                        <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                        <!--                                            <a href="-->
                        <? //= $path ?><!--reports/elm_report" target="_blank"> Read More</a>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                   -->
                        <!--                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4">-->
                        <!--                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">-->
                        <!--                            <div class="widget-content">-->
                        <!--                                <div class="w-content">-->
                        <!--                                    <div class="w-info w-100">-->
                        <!--                                        <div class="rs-icon pb-3"><img-->
                        <!--                                                    src="-->
                        <? //= $template ?><!--assets/img/rs-icons/icon-rs-20.png"></div>-->
                        <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">ELM Data-->
                        <!--                                            Summary DayWise</h6>-->
                        <!--                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                        <!--                                            <a href="-->
                        <? //= $path ?><!--reports/elm_summary_daywise" target="_blank"> Read-->
                        <!--                                                More</a></div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4">-->
                        <!--                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">-->
                        <!--                            <div class="widget-content">-->
                        <!--                                <div class="w-content">-->
                        <!--                                    <div class="w-info w-100">-->
                        <!--                                        <div class="rs-icon pb-3"><img-->
                        <!--                                                    src="-->
                        <? //= $template ?><!--assets/img/rs-icons/icon-rs-20.png"></div>-->
                        <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">ELM Data-->
                        <!--                                            Summary DayWise</h6>-->
                        <!--                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                        <!--                                            <a href="-->
                        <? //= $path ?><!--reports/elm_summary_daywise" target="_blank"> Read-->
                        <!--                                                More</a></div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_pending_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Passport
                                                    Pending </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/passport_pending" target="_blank"> Read
                                                        More *</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_passport_management_passport_complete_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Passport
                                                    Complete</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/passport_completed" target="_blank">
                                                        Read
                                                        More *</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_stats_sale_hotel_sale_summary_report']
                    || $CheckAccess['umrah_reports_stats_sale_transport_sale_summary_report']
                    || $CheckAccess['umrah_reports_stats_sale_service_sale_summary_report']
                    ) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Sale</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_stats_sale_hotel_sale_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Hotel
                                                    Sale Summary</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/hotel_sale_summary" target="_blank">
                                                        Read
                                                        More ***</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_sale_transport_sale_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Transport
                                                    Sale Summary</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/transport_sale_summary"
                                                       target="_blank">
                                                        Read
                                                        More ***</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_stats_sale_service_sale_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Service
                                                    Sale Summary</h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/service_sale_summary" target="_blank">
                                                        Read
                                                        More ***</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($CheckAccess['umrah_reports_stats_extras_tafeej_report']) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Extras</h3>
                                </div>
                            </div>
                        </div> <?php if ($CheckAccess['umrah_reports_stats_extras_tafeej_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Tafeej
                                                    Report
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>reports/tafeej_report" target="_blank"> Read
                                                        More ***</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                    </div>
                <?php } ?>

                <div class="mt-5">

                </div>


            </div>
        </div>
    </div>
</div>
