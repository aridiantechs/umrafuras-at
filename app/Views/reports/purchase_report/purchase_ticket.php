<!--  BEGIN CONTENT AREA  -->
<!--<div id="content" class="main-content">-->
<!--    <div class="layout-px-spacing">-->
<!--        <div class="row layout-top-spacing">-->
<!--            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">-->
<!--                <h4 class="page-head"> --><?//= ucwords(str_replace("_", " ", $Link)) ?><!-- Report-->
<!--                </h4>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->




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
                                <h3> Ticket Vendor Reports</h3>
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Ticket Issue</h6>
                                        <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_issue" target="_blank"> Read
                                                More</a>
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
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Ticket Reissue
                                        </h6>
                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_reissue" target="_blank"> Read
                                                More</a>
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
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-7.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Refund
                                        </h6>
                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_refund" target="_blank"> Read
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
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-6.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">ADM
                                        </h6>
                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_adm" target="_blank"> Read
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
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Group Wise
                                        </h6>
                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_group_wise" target="_blank"> Read
                                                More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="row p-2">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <div class="page-title">
                                <h3>Summary</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="rs-icon pb-3"><img
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail Report
                                        </h6>
                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_detail_report"
                                               target="_blank"> Read More</a>
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
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-6.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Country Wise</h6>
                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_country_wise" target="_blank">
                                                Read
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
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-7.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Month Wise</h6>
                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_month_wise" target="_blank">
                                                Read More</a></div>
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
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Year Wise
                                        </h6>
                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_year_wise" target="_blank">
                                                Read
                                                More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4 mt-4">
                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="rs-icon pb-3"><img
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-19.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Airline Wise
                                        </h6>
                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_airline_wise" target="_blank">
                                                Read
                                                More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4 mt-4">
                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="rs-icon pb-3"><img
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png "></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">International
                                        </h6>
                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_international" target="_blank">
                                                Read
                                                More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4 mt-4">
                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="rs-icon pb-3"><img
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Domestic
                                        </h6>
                                        <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_domestic" target="_blank">
                                                Read
                                                More</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4 mt-4">
                        <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="rs-icon pb-3"><img
                                                    src="<?= $template ?>assets/img/rs-icons/icon-rs-6.png"></div>
                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail Report Amount Wise
                                        </h6>
                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                            <a href="<?= $path ?>reports/purchase_ticket_detail_report_amount_wise" target="_blank">
                                                Read
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