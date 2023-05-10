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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Manage
                                            Pilgrim Report</h6>
                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/pilgrim_list" target="_blank"> Read More</a>
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Pilgrim
                                            Count</h6>
                                        <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/pilgrim_count" target="_blank"> Read More</a>
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Group
                                            Stats</h6>
                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/group_stats" target="_blank"> Read More</a>
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Agent
                                            Work Report</h6>
                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/agent_work_report" target="_blank"> Read
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
                                            Late Departure
                                        </h6>
                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/late_departure" target="_blank"> Read More</a>
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Passport
                                            Pending</h6>
                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/passport_pending" target="_blank"> Read
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Passport
                                            Complete</h6>
                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/passport_completed" target="_blank"> Read
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
</div>
