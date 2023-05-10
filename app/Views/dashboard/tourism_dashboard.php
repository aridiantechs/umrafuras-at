<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/umrahfuras-dashboard.css">

<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/hotel.css">
 <!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="analytics">
            <div class="main-title pb-5">Tourism <img class="float-right" src="<?= $template ?>assets/img/bismALLAH-hotel.png"> </div>
            <div class="row card-group-row">
                <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                    <div class="card for-height card-group-row__card hotel-sal-count">
                        <div class="row p-4">
                            <div class="col-lg-8 col-md-8 col-6">
                                <div class="title">Sale Country Wise</div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-6">
                                <select class="select-count p-1 w-100">
                                    <option>Choose Country</option>
                                    <option>Pakistan</option>
                                    <option>India</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-center" style="height: 250px;">
                            <div class="chart w-100" style="height: calc(250px - 1.25rem * 2);">
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 mt-lg-0 mt-md-5 mt-5">
                    <div class="pb-0 for-height hotel-sal-count">
                        <div class="row p-4">
                            <div class="col-lg-8 col-md-8 col-6">
                                <div class="title">Status</div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-6">
                                <select class="select-count p-1 w-100">
                                    <option>Purchase/Sale wise</option>
                                    <option>1 Star</option>
                                    <option>2 Star</option>
                                </select>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-6 pl-4">
                                        <div class="justify-content-between">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-3">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-2 col-2 pt-2">
                                                            <div class="blue-lte-circle"></div>
                                                        </div>
                                                        <div class="col-lg-9 col-md-10 col-10 p-lg-0">
                                                            <h4 class="fs-18 hotel-rating text-black mb-0 font-w600">
                                                                2,512</h4>
                                                            <div class="status-det">Booking</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-3">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-2 col-2 pt-2">
                                                            <div class="purple-lte-circle"></div>
                                                        </div>
                                                        <div class="col-lg-9 col-md-10 col-10 p-lg-0">
                                                            <h4 class="fs-18 hotel-rating text-black mb-0 font-w600">
                                                                456</h4>
                                                            <div class="status-det">In Process</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-3 mt-lg-4 mt-md-4 mt-0">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-2 col-2 pt-2">
                                                            <div class="yellow-lte-circle"></div>
                                                        </div>
                                                        <div class="col-lg-9 col-md-10 col-10 p-lg-0">
                                                            <h4 class="fs-18 hotel-rating text-black mb-0 font-w600">
                                                                951</h4>
                                                            <div class="status-det">In Tour</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-3 mt-lg-4 mt-md-4 mt-0">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-2 col-2 pt-2">
                                                            <div class="pink-lte-circle"></div>
                                                        </div>
                                                        <div class="col-lg-9 col-md-10 col-10 p-lg-0">
                                                            <h4 class="fs-18 hotel-rating text-black mb-0 font-w600">
                                                                157</h4>
                                                            <div class="status-det">Complete</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-6 p-sm-0 m-sm-0">
                                        <div id="CategorySaleDonatChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="hotel-sal-count p-4">
                        <div class="title">Visitor</div>
                        <div class="price text-center">566</div>
                        <div class="red-box"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="hotel-sal-count p-4">
                        <div class="title">Booking</div>
                        <div class="price text-center">566</div>
                        <div class="green-box"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 mt-lg-0 mt-md-5 mt-5">
                    <div class="hotel-sal-count p-4">
                        <div class="title">Cancel Booking</div>
                        <div class="price text-center">156</div>
                        <div class="yellow-box"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="hotel-sal-count p-4">
                        <div class="title">Change Booking</div>
                        <div class="price text-center">156</div>
                        <div class="yellow-box"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mt-lg-0 mt-md-5 mt-5">
                    <div class="hotel-sal-count p-4">
                        <div class="title">Half Refund</div>
                        <div class="price text-center">566</div>
                        <div class="red-box"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mt-lg-0 mt-md-5 mt-5">
                    <div class="hotel-sal-count p-4">
                        <div class="title">Full Refund</div>
                        <div class="price text-center">566</div>
                        <div class="green-box"></div>
                    </div>
                </div>
            </div>
            <div class="row card-group-row mt-5 mb-5">
                <div class="col-lg-6 col-md-6 col-12 card-group-row__col">
                    <div class="card for-height card-group-row__card hotel-sal-count">
                        <div class="row p-4">
                            <div class="col-lg-8 col-md-8 col-6">
                                <div class="title">Sale Category Wise</div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-6">
                                <select class="select-count p-1 w-100">
                                    <option>Choose Month</option>
                                    <option>Feb</option>
                                    <option>March</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body d-block align-items-center" style="height: 250px;">
                             <div class="chart w-100" style="height: calc(250px - 1.25rem * 2);">
                                <canvas id="MonthWise"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 mt-lg-0 mt-md-0 mt-5">
                    <div class="p-2 for-height hotel-sal-count">
                        <div class="card">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Sale Month Wise</div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-6">
                                    <select class="select-count p-1 w-100">
                                        <option>Choose Year</option>
                                        <option>2019</option>
                                        <option>2020</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-block">
                                <div id="data-use-chart" style="height:245px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Global Settings -->
<script src="<?= $template ?>assets/js/hotel-sale-wise-graph/settings.js"></script>

<!-- Chart.js -->
<script src="<?= $template ?>assets/vendor/Chart.min.js"></script>

<!-- App Charts JS -->
<script src="<?= $template ?>assets/js/hotel-sale-wise-graph/chartjs-rounded-bar.js"></script>
<script src="<?= $template ?>assets/js/hotel-sale-wise-graph/charts.js"></script>


<script src="<?= $template ?>assets/pages/widget/amchart/amcharts.js"></script>
<script src="<?= $template ?>assets/pages/widget/amchart/serial.js"></script>
<script src="<?= $template ?>assets/pages/widget/amchart/light.js"></script>
<script type="text/javascript" src="<?= $template ?>assets/pages/dashboard/custom-dashboard.min.js"></script>

<!-- Required vendors -->
<!--<script src="--><?//= $template ?><!--assets/vendor/catogry-wise-graph/global.min.js"></script>-->
<!-- Apex Chart -->
<script src="<?= $template ?>assets/vendor/catogry-wise-graph/apexchart.js"></script>
<!-- Dashboard 1 -->

<script type="text/javascript">
    ! function(e) {
        $('[data-toggle="tab"]').on("hide.bs.tab", function(e) {
            $(e.target).removeClass("active")
        }), Charts.init();
        var e =  function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "roundedBar",
                r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
            r = Chart.helpers.merge({
                barRoundness: 1.2,
                scales: {
                    xAxes: [{
                        maxBarThickness: 15
                    }]
                }
            }, r);
            var a = {
                labels: ["20 Aug", "20 Aug", "20 Aug", "20 Aug", "20 Aug", "20 Aug"],
                datasets: [{
                    label: "Female",
                    data: [25, 20, 30, 22, 17, 10],
                    backgroundColor: '#393c69'
                }, {
                    label: "Male",
                    data: [15, 10, 20, 12, 7, 2],
                    backgroundColor: '#676a9f'
                }]
            };
            Charts.create(e, t, r, a)
        }("#genderChart");
        var e =  function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "roundedBar",
                r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
            r = Chart.helpers.merge({
                barRoundness: 1.2,
                scales: {
                    xAxes: [{
                        maxBarThickness: 15
                    }]
                }
            }, r);
            var a = {
                labels: ["15", "20", "21 ", "22", "24 ", "25"],
                datasets: [{
                    label: "Female",
                    data: [25, 20, 30, 22, 17, 10],
                    backgroundColor: '#393c69'
                }, {
                    label: "Male",
                    data: [15, 10, 20, 12, 7, 2],
                    backgroundColor: '#676a9f'
                }]
            };
            Charts.create(e, t, r, a)
        }("#MonthWise");

    }();

    (function($) {
        /* "use strict" */


        var dzChartlist = function(){
            let draw = Chart.controllers.line.__super__.draw; //draw shadow
            var screenWidth = $(window).width();
            var CategorySaleDonatChart = function(){
                var options = {
                    series: [20, 15, 25,25,15],
                    chart: {
                        type: 'donut',
                    },
                    legend:{
                        show:false
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -86,
                            donut: {
                                size: '40%',
                            }
                        },
                    },
                    stroke:{
                        width:'10'
                    },
                    dataLabels: {
                        formatter(val, opts) {
                            const name = opts.w.globals.labels[opts.seriesIndex]
                            return [ val.toFixed() + '%']
                        },
                        dropShadow: {
                            enabled: false
                        },
                        style: {
                            fontSize: '14px',
                            colors: ["#fff"],
                        }
                    },
                    colors:['#58c0ea','#f6d35f','#7c27fd','#0a930a','#f75e5f'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                show:false,
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
                init:function(){
                },


                load:function(){
                    CategorySaleDonatChart();
                },

                resize:function(){

                }
            }

        }();

        jQuery(document).ready(function(){
        });

        jQuery(window).on('load',function(){
            setTimeout(function(){
                dzChartlist.load();
            }, 1000);

        });

        jQuery(window).on('resize',function(){


        });

    })(jQuery);




</script>