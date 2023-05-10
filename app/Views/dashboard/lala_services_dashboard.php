<style>
    #admin-dashboard .card {
        border-radius: 2rem !Important;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/umrahfuras-dashboard.css">

<!-- END YEAR WISE SALE GRAPH -->

<link rel="stylesheet" href="<?= $template ?>assets/vendor/chartist/css/chartist.min.css">
<link rel="stylesheet" href="<?= $template ?>assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?= $template ?>assets/css/main.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/hotel.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/furas-makkah-all-charts.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/my-task-style.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/color_skins.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/morris.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/components.css">
<link rel="stylesheet" href="<?= $template ?>assets/css/jquery-jvectormap-2.0.3.css">

<!-- Total Visitor, Uniquer Visitor. Old Visitor, Confirm Visitor CSS -->

<link type="text/css" href="<?= $template ?>assets/css/app.css" rel="stylesheet">
<link type="text/css" href="<?= $template ?>assets/css/app.rtl.css" rel="stylesheet">

<link type="text/css" href="<?= $template ?>assets/css/vendor-material-icons.css" rel="stylesheet">
<link type="text/css" href="<?= $template ?>assets/css/vendor-material-icons.rtl.css" rel="stylesheet">

<!-- Total Visitor, Uniquer Visitor. Old Visitor, Confirm Visitor CSS END -->
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content pt-4">
    <div class="layout-px-spacing" id="admin-dashboard">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="analytics">
                    <div class="main-title pb-5">LALA Services Dashboard <img class="float-right"
                                                                              src="<?= $template ?>assets/img/bismALLAH-hotel.png">
                    </div>

                </div>


                <div class="row card-group-row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Hotel</p>
                                    <span class="fs-35 text-black font-w600">15
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Transport</p>
                                    <span class="fs-35 text-black font-w600">10
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Hajj</p>
                                    <span class="fs-35 text-black font-w600">14
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Visa</p>
                                    <span class="fs-35 text-black font-w600">12
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Ticket</p>
                                    <span class="fs-35 text-black font-w600">20
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Tourism</p>
                                    <span class="fs-35 text-black font-w600">10
                                            </span>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="row layout-top-spacing">
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget-three">
                            <div class="widget-heading">
                                <h5 class="">Summary</h5>
                            </div>
                            <div class="widget-content">
                                <div class="order-summary">
                                    <div class="summary-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Income</h6>
                                                <p class="summary-count">92,600</p>
                                            </div>
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Profit</h6>
                                                <p class="summary-count">37,515</p>
                                            </div>
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Expenses</h6>
                                                <p class="summary-count">55,085</p>
                                            </div>
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-heading">
                                <h5 class="">Visa</h5>
                            </div>
                            <div class="widget-content">
                                <div class="vistorsBrowser">
                                    <div class="browser-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6>Arrival</h6>
                                                <p class="browser-count">65%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 65%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="browser-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-compass"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6>Departure</h6>
                                                <p class="browser-count">25%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: 35%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="browser-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                        </div>
                                        <div class="w-browser-details">
                                            <div class="w-browser-info">
                                                <h6>Others</h6>
                                                <p class="browser-count">15%</p>
                                            </div>
                                            <div class="w-browser-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget-three">
                            <div class="widget-heading">
                                <h5 class="">Hotel & Transport Summary</h5>
                            </div>
                            <div class="widget-content">
                                <div class="order-summary">
                                    <div class="summary-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Pending</h6>
                                                <p class="summary-count">60</p>
                                            </div>
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Confirm</h6>
                                                <p class="summary-count">45</p>
                                            </div>
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-list">
                                        <div class="w-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                        </div>
                                        <div class="w-summary-details">
                                            <div class="w-summary-info">
                                                <h6>Cancel</h6>
                                                <p class="summary-count">20</p>
                                            </div>
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 offset-3">
                        <div class="card">
                            <div class="body">
                                <h5 class="frush-sub-title"></h5>
                                <div class="text-center">
                                    <div class=" m-t-20"><img src="<?=$template?>shield_logo_lala_services.png" style="width: 25%;"> </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="<?= $template ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?= $template ?>bootstrap/js/popper.min.js"></script>
    <script src="<?= $template ?>bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            App.init();
        });
    </script>

    <!--    <script src="assets/js/custom.js"></script>-->
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>
    <script src="<?= $template ?>assets/js/widgets/modules-widgets.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


    <!--    <script src="assets/js/custom.js"></script>-->
    <!-- END GLOBAL MANDATORY SCRIPTS -->


    <script src="<?= $template ?>assets/js/dashboard-charts.js"></script>


    <!-- HOTEL WISE GRAPH JS -->
    <!-- App Settings (safe to remove) -->
    <script src="<?= $template ?>assets/js/hotel-sale-wise-graph/settings.js"></script>

    <!-- Global Settings -->
    <script src="<?= $template ?>assets/js/hotel-sale-wise-graph/settings.js"></script>

    <!-- Chart.js -->
    <script src="<?= $template ?>assets/vendor/Chart.min.js"></script>

    <!-- App Charts JS -->
    <script src="<?= $template ?>assets/js/hotel-sale-wise-graph/chartjs-rounded-bar.js"></script>
    <script src="<?= $template ?>assets/js/hotel-sale-wise-graph/charts.js"></script>

    <!-- Chart Samples -->
    <script src="<?= $template ?>assets/js/hotel-sale-wise-graph/page.dashboard.js"></script>

    <!-- Chart.js -->
    <script src="<?= $template ?>assets/vendor/Chart.min.js"></script>
    <!--END HOTEL WISE GRAPH JS -->


    <!-- START HOTEL YEAR WISE GRAPH JS -->
    <!-- amchart js -->
    <script src="<?= $template ?>assets/pages/widget/amchart/amcharts.js"></script>
    <script src="<?= $template ?>assets/pages/widget/amchart/serial.js"></script>
    <script src="<?= $template ?>assets/pages/widget/amchart/light.js"></script>
    <script type="text/javascript" src="<?= $template ?>assets/pages/dashboard/custom-dashboard.min.js"></script>
    <!-- END HOTEL YEAR WISE GRAPH JS -->


    <!-- START HOTEL CATEGORY WISE GRAPH JS -->

    <!-- Required vendors -->
    <script src="<?= $template ?>assets/vendor/catogry-wise-graph/global.min.js"></script>
    <script src="<?= $template ?>assets/vendor/catogry-wise-graph/bootstrap-select.min.js"></script>
    <script src="<?= $template ?>assets/vendor/catogry-wise-graph/Chart.bundle.min.js"></script>
    <script src="<?= $template ?>assets/vendor/catogry-wise-graph/custom.min.js"></script>
    <!-- Apex Chart -->
    <script src="<?= $template ?>assets/vendor/catogry-wise-graph/apexchart.js"></script>
    <!-- Dashboard 1 -->
    <!-- END HOTEL CATEGORY WISE GRAPH JS -->

    <!-- Start main farrush umrah dashbaord -->
    <!--<script src="assets/js/main-dashboard/chartist.bundle.js"></script>
    <script src="assets/js/main-dashboard/mainscripts.bundle.js"></script>
    <script src="assets/js/main-dashboard/index.js"></script>
    <script src="assets/js/main-dashboard/vendorscripts.bundle.js"></script>
    <script src="assets/js/main-dashboard/libscripts.bundle.js"></script>-->

    <script src="<?= $template ?>assets/bundles/vendorscripts.bundle.js"></script>
    <script src="<?= $template ?>assets/bundles/chartist.bundle.js"></script>
    <script src="<?= $template ?>assets/bundles/knob.bundle.js"></script> <!-- Jquery Knob-->
    <script src="<?= $template ?>assets/bundles/mainscripts.bundle.js"></script>
    <script src="<?= $template ?>assets/js/index.js"></script>

    <!-- START HOTEL VISITOR HOTELCATEGORY WISE GRAPH JS
    <script src="assets/bundles/global.min.js"></script>
    <script src="assets/js/custom.min.js"></script> -->
    <script src="<?= $template ?>assets/bundles/Chart.bundle.min.js"></script>
    <script src="<?= $template ?>assets/bundles/dashboard-1.js"></script>
    <script src="<?= $template ?>assets/bundles/jquery.peity.min.js"></script>
    <!-- END HOTEL VISITOR HOTELCATEGORY WISE GRAPH JS -->

    <!-- START  VISITOR CATEGORY WISE GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/chart.min.js"></script>
    <script src="<?= $template ?>assets/bundles/jquery.chartjs.init.js"></script>
    <!-- END  VISITOR CATEGORY WISE GRAPH JS -->

    <!-- Total Visitor, Uniquer Visitor. Old Visitor, Confirm Visitor JS

    <script src="assets/vendor/dom-factory.js"></script>
    <script src="assets/vendor/material-design-kit.js"></script>
    <script src="assets/vendor/Chart.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/charts.js"></script>
    <script src="assets/js/page.dashboard.js"></script>-->

    <!-- Total Visitor, Uniquer Visitor. Old Visitor, Confirm Visitor JS END-->

    <!-- START DIALY WISE VISITOR  GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/apexcharts.bundle.js"></script>
    <script src="<?= $template ?>assets/bundles/index.js"></script>
    <!-- END DIALY WISE VISITOR  GRAPH JS -->

    <!-- START TRANSPORT SECT VISITOR,BOOKING,CANCEL BOOKING GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/chart-apex.js"></script>
    <!-- END TRANSPORT SECT VISITOR,BOOKING,CANCEL BOOKING GRAPH JS -->

    <!-- START TICKET YEAR WISE SALE GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/raphael.min.js"></script>
    <script src="<?= $template ?>assets/bundles/morris.js"></script>
    <script src="<?= $template ?>assets/bundles/morris-custom-chart.js"></script>
    <!-- END TICKET YEAR WISE SALE GRAPH JS -->

    <!-- START TICKET MONTH WISE SALE GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/jquery.dashboard-2.js"></script>
    <!-- END TICKET MONTH WISE SALE GRAPH JS -->

    <!-- START HOTEL VISITOR GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/chartist.js"></script>
    <script src="<?= $template ?>assets/bundles/pie.min.js"></script>
    <script src="<?= $template ?>assets/bundles/ammap.min.js"></script>
    <script src="<?= $template ?>assets/bundles/widget-chart.js"></script>
    <!-- END HOTEL VISITOR GRAPH JS -->

    <!-- START VISA SECTION VISITOR,BOOKING...GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/jquery.waypoints.min.js"></script>
    <script src="<?= $template ?>assets/bundles/jquery.counterup.min.js"></script>
    <script src="<?= $template ?>assets/bundles/jquery.core.js"></script>
    <script src="<?= $template ?>assets/bundles/jquery.sparkline.min.js"></script>
    <script src="<?= $template ?>assets/bundles/jquery.app.js"></script>
    <!-- END VISA SECTION VISITOR,BOOKING...GRAPH JS -->

    <!-- START TICKET  SCOUNTRY WISE SALE...GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/jvectormap.bundle.js"></script>
    <script src="<?= $template ?>assets/bundles/jvectormap.js"></script>
    <!-- END TICKET  SCOUNTRY WISE SALE...GRAPH JS -->

    <!-- START TRANSPORT COUNTRY WISE SECT...GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/usaLow.js"></script>
    <!-- END TRANSPORT COUNTRY WISE SECT...GRAPH JS -->

    <!-- START HAJJ COUNTRY WISE SECT...GRAPH JS
    <script src="assets/bundles/crypto-dashboard.min.js"></script>
    <script src="assets/bundles/pcoded.min.js"></script>tr
    -->
    <!-- END HAJJ COUNTRY WISE SECT...GRAPH JS -->

    <!-- START HAJJ PACKAGE CATAGORY WISE S...GRAPH JS -->
    <script src="<?= $template ?>assets/bundles/jquery.echart.init.js"></script>
    <script src="<?= $template ?>assets/bundles/echarts-all.js"></script>

    <!-- END HAJJ PACKAGE CATAGORY WISE S...GRAPH JS -->


    <script src="<?= $template ?>assets/js/chart.js"></script>
    <script src="<?= $template ?>assets/js/chart.extension.js"></script>
    <script src="<?= $template ?>assets/js/bar-chart.js"></script>

    <script type="text/javascript">

        (function ($) {
            /* "use strict" */

            var dzChartlist = function () {
                let draw = Chart.controllers.line.__super__.draw; //draw shadow
                var screenWidth = $(window).width();
                var CategorySaleDonatChart = function () {
                    var options = {
                        series: [20, 15, 20, 30, 15],
                        chart: {
                            type: 'donut',
                        },
                        legend: {
                            show: false
                        },
                        plotOptions: {
                            pie: {
                                startAngle: -1,
                                donut: {
                                    size: '40%',
                                }
                            },
                        },
                        stroke: {
                            width: '10'
                        },
                        dataLabels: {
                            formatter(val, opts) {
                                const name = opts.w.globals.labels[opts.seriesIndex]
                                return [val.toFixed() + '%']
                            },
                            dropShadow: {
                                enabled: false
                            },
                            style: {
                                fontSize: '14px',
                                colors: ["#ffffff"],
                            }
                        },
                        colors: ['#3a3eb7', '#fbe70a', '#04bb08', '#57aad9', '#f86553'],
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    show: false,
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    var chart = new ApexCharts(document.querySelector("#CategorySaleDonatChart"), options);
                    chart.render();
                }


                /* Function ============ */
                return {
                    init: function () {
                    },


                    load: function () {
                        CategorySaleDonatChart();
                    },

                    resize: function () {

                    }
                }

            }();

            jQuery(document).ready(function () {
            });

            jQuery(window).on('load', function () {
                setTimeout(function () {
                    dzChartlist.load();
                }, 1000);

            });

            jQuery(window).on('resize', function () {


            });

        })(jQuery);

    </script>

