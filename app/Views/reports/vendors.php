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
                <?php if ($CheckAccess['umrah_reports_vendors_vendor_reports_hotel_brn_vendor_report']
                    || $CheckAccess['umrah_reports_vendors_vendor_reports_tpt_brn_vendor_report']
                    || $CheckAccess['umrah_reports_vendors_vendor_reports_visa_vendor_report']
                    || $CheckAccess['umrah_reports_vendors_vendor_reports_hotel_vendor_report']
                    || $CheckAccess['umrah_reports_vendors_vendor_reports_transport_vendor_report']

                  ) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Vendor Reports</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_vendors_vendor_reports_hotel_brn_vendor_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-2.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Hotel BRN
                                                    Vendor </h6>
                                                <div class="green-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/hotel_brn_vendor"
                                                       target="_blank"> Read
                                                        More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_vendor_reports_tpt_brn_vendor_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-3.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    TPT
                                                    BRN
                                                    Vendor
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/tpt_brn_vendor" target="_blank">
                                                        Read
                                                        More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_vendor_reports_visa_vendor_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-20.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Visa
                                                    Vendor
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/visa_vendor" target="_blank">
                                                        Read
                                                        More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_vendor_reports_hotel_vendor_report']) { ?>
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
                                                    Vendor
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/hotel_vendor" target="_blank">
                                                        Read
                                                        More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_vendor_reports_transport_vendor_report']) { ?>
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
                                                    Vendor
                                                </h6>
                                                <div class="orange-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/transport_vendor"
                                                       target="_blank">
                                                        Read
                                                        More</a></div>
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
                                            <a href="<? /*= $path */ ?>vendor_reports/report_creator" target="_blank"> Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_vendors_summary_hotel_brn_vendor_summary_report']
                    || $CheckAccess['umrah_reports_vendors_summary_tpt_brn_vendor_summary_report']
                    || $CheckAccess['umrah_reports_vendors_summary_visa_vendor_summary_report']
                    || $CheckAccess['umrah_reports_vendors_summary_hotel_vendor_summary_report']
                    || $CheckAccess['umrah_reports_vendors_summary_tpt_vendor_summary_report']

                ) { ?>
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="page-title">
                                    <h3>Summary</h3>
                                </div>
                            </div>
                        </div>
                        <?php if ($CheckAccess['umrah_reports_vendors_summary_hotel_brn_vendor_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-5.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Hotel
                                                    BRN
                                                    Vendor Summary
                                                </h6>
                                                <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/hotel_brn_vendor_summary"
                                                       target="_blank"> Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_summary_tpt_brn_vendor_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-xl-0 mb-lg-0 mb-md-4 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-6.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    TPT
                                                    BRN
                                                    Vendor Summary</h6>
                                                <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/tpt_brn_vendor_summary"
                                                       target="_blank">
                                                        Read
                                                        More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_summary_visa_vendor_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-7.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Visa
                                                    Vendor Summary</h6>
                                                <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/visa_vendor_summary"
                                                       target="_blank">
                                                        Read More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_summary_hotel_vendor_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-19.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    Hotel
                                                    Vendor Summary
                                                </h6>
                                                <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/hotel_vendor_summary"
                                                       target="_blank">
                                                        Read
                                                        More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_vendors_summary_tpt_vendor_summary_report']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
                                <div class="widget widget-card-four btb-box p-xl-3 p-lg-3 p-md-3 p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100">
                                                <div class="rs-icon pb-3"><img
                                                            src="<?= $template ?>assets/img/rs-icons/icon-rs-19.png">
                                                </div>
                                                <h6 class="value text-xl-right text-lg-right text-md-right text-right">
                                                    TPT
                                                    Vendor Summary
                                                </h6>
                                                <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">
                                                    <a href="<?= $path ?>vendor_reports/tpt_vendor_summary"
                                                       target="_blank">
                                                        Read
                                                        More</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Ticket Vendor</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Ticket-->
                <!--                                            Issue-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/ticket_issue" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Ticket-->
                <!--                                            Reissue</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/ticket_reissue" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">-->
                <!--                                            Refund</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/refund" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">A D M-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/adm" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Groupwise-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/groupwise" target="_blank"> Read-->
                <!--                                                More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Summary</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail-->
                <!--                                            Report-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/detail_report" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Country-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/country_wise" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Month-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/month_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Year Wise-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/year_wise" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Airline-->
                <!--                                            Wise-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/airline_wise" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">-->
                <!--                                            International-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/international" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Domestic-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/domestic" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-19.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail-->
                <!--                                            Report Amount Wise-->
                <!--                                        </h6>-->
                <!--                                        <div class="dodgerblue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/detail_report_amount_wise"-->
                <!--                                               target="_blank"> Read-->
                <!--                                                More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Visa Vendor</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Visa-->
                <!--                                            Issue-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/visa_issue" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Reject-->
                <!--                                            Visa</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/reject_visa" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Refund-->
                <!--                                            Visa</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/refund_visa" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Summary</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/visa_detail" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Vendor-->
                <!--                                            Country Wise</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/vendor_country_wise" target="_blank">-->
                <!--                                                Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Visa-->
                <!--                                            Country Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/visa_country_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Month-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/visa_month_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Year-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/visa_year_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Hotel Vendor</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Cancel-->
                <!--                                            Booking-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/cancel_booking" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Confirm-->
                <!--                                            Booking</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/confirm_booking" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">-->
                <!--                                            Refund</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_refund" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Change-->
                <!--                                            Booking</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/change_booking" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Hotel-->
                <!--                                            Allotment</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_allotment" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Summary</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail-->
                <!--                                            Report-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_detail_report" target="_blank">-->
                <!--                                                Read More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Country-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_country_wise" target="_blank">-->
                <!--                                                Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Category-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_category_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Hotel-->
                <!--                                            With Month Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_with_month_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Hotel-->
                <!--                                            With Year Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/hotel_with_year_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>TPT Vendor</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Confirm-->
                <!--                                            Booking-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_confirm_booking" target="_blank">-->
                <!--                                                Read More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Refund-->
                <!--                                            Booking</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_refund_booking" target="_blank">-->
                <!--                                                Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Change-->
                <!--                                            Booking</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_change_booking" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Summary</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail-->
                <!--                                            Report-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_detail_report" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-5.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Country-->
                <!--                                            Wise-->
                <!--                                        </h6>-->
                <!--                                        <div class="pink-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_country_wise" target="_blank"> Read-->
                <!--                                                More</a>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Category-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_category_wise" target="_blank"> Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Month-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_month_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Year-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tpt_year_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Tours Vendor</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Confirm-->
                <!--                                            Booking</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_confirm_booking" target="_blank">-->
                <!--                                                Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Change-->
                <!--                                            Booking</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_change_booking" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">-->
                <!--                                            Refund</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_refund_booking" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!---->
                <!--                </div>-->


                <!--                <div class="row p-2">-->
                <!--                    <div class="col-lg-12">-->
                <!--                        <div class="page-header">-->
                <!--                            <div class="page-title">-->
                <!--                                <h3>Summary</h3>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-6.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Detail-->
                <!--                                            Report</h6>-->
                <!--                                        <div class="yellow-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_detail_report" target="_blank">-->
                <!--                                                Read-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Country-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_country_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Package-->
                <!--                                            Category Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_package_category_wise"-->
                <!--                                               target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Month-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_month_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
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
                <? //= $template ?><!--assets/img/rs-icons/icon-rs-7.png"></div>-->
                <!--                                        <h6 class="value text-xl-right text-lg-right text-md-right text-right">Year-->
                <!--                                            Wise</h6>-->
                <!--                                        <div class="blue-box rs-btn text-center mt-2 float-xl-right float-lg-right float-md-right float-right">-->
                <!--                                            <a href="-->
                <? //= $path ?><!--vendor_reports/tour_year_wise" target="_blank">-->
                <!--                                                Read More</a></div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!---->
                <!---->
                <!--                </div>-->


                <div class="mt-5">

                </div>


            </div>
        </div>
    </div>

</div>