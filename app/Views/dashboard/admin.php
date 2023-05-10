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
                    <div class="main-title pb-5">Main Dashboard <img class="float-right"
                                                                     src="<?= $template ?>assets/img/bismALLAH-hotel.png">
                    </div>

                </div>
                <div class="sub-title pb-4 pt-5">Umrah</div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="header">
                                <div class="frush-sub-title">Country Wise Sale</div>
                                <ul class="header-dropdown">
                                </ul>
                            </div>
                            <div class="body">
                                <div id="Salary_Statistics" class="chartist"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="body">
                                <h5 class="frush-sub-title">Total Pilgram</h5>
                                <div class="text-center">
                                    <div class="sparkline-pie m-t-20">6,4,8</div>
                                    <div class="stats-report m-b-30">
                                        <div class="stat-item">
                                            <h5 class="sub-text">Total Pax</h5>
                                            <b class="col-black">84.60%</b></div>
                                        <div class="stat-item">
                                            <h5 class="sub-text">Enter</h5>
                                            <b class="col-black">15.40%</b></div>
                                        <div class="stat-item">
                                            <h5 class="sub-text">Exit</h5>
                                            <b class="col-black">5.10%</b></div>
                                        <div class="stat-item">
                                            <h5 class="sub-text">In KSA</h5>
                                            <b class="col-black">5.10%</b></div>
                                        <div class="stat-item">
                                            <h5 class="sub-text">In Process</h5>
                                            <b class="col-black">5.10%</b></div>
                                    </div>
                                    <span id="sparkline-compositeline">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Visitor</div>
                                </div>
                            </div>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i>
                                    </li>
                                    <li><i class="feather icon-maximize full-card"></i></li>
                                    <li><i class="feather icon-minus minimize-card"></i></li>
                                    <li><i class="feather icon-refresh-cw reload-card"></i></li>
                                    <li><i class="feather icon-chevron-left open-card-option"></i></li>
                                </ul>
                            </div>
                            <div class="card-block ">
                                <div id="statistics-chart" style="height:240px" class="chart-shadow"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Category Wise Sale</div>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-center" style="height: 250px;">
                                <div class="chart w-100" style="height: calc(250px - 1.25rem * 2);">
                                    <canvas id="genderChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sub-title pb-4 pt-4">Ticket</div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="title">Country Wise Sale</div>
                                </div>
                                <div class="col-lg-8 col-md-6 col-sm-8 pb-3">
                                    <div id="ticket-world-map-markers" class="jvector-map" style="height: 300px"></div>
<!--                                    <script>-->
<!--                                        $(function () {-->
<!--                                            if ($('#ticket-world-map-markers').length > 0) {-->
<!--                                                $('#ticket-world-map-markers').vectorMap(-->
<!--                                                    {-->
<!--                                                        map: 'world_mill_en',-->
<!--                                                        backgroundColor: 'transparent',-->
<!--                                                        borderColor: '#fff',-->
<!--                                                        borderOpacity: 0.25,-->
<!--                                                        borderWidth: 0,-->
<!--                                                        color: '#e6e6e6',-->
<!--                                                        regionStyle: {-->
<!--                                                            initial: {-->
<!--                                                                fill: '#cccccc'-->
<!--                                                            }-->
<!--                                                        },-->
<!---->
<!--                                                        markerStyle: {-->
<!--                                                            initial: {-->
<!--                                                                r: 5,-->
<!--                                                                'fill': '#fff',-->
<!--                                                                'fill-opacity': 1,-->
<!--                                                                'stroke': '#000',-->
<!--                                                                'stroke-width': 1,-->
<!--                                                                'stroke-opacity': 0.4-->
<!--                                                            },-->
<!--                                                        },-->
<!---->
<!--                                                        markers: [{-->
<!--                                                            latLng: [21.00, 78.00],-->
<!--                                                            name: 'INDIA : 350'-->
<!---->
<!--                                                        },-->
<!--                                                            {-->
<!--                                                                latLng: [-33.00, 151.00],-->
<!--                                                                name: 'Australia : 250'-->
<!---->
<!--                                                            },-->
<!--                                                            {-->
<!--                                                                latLng: [36.77, -119.41],-->
<!--                                                                name: 'USA : 250'-->
<!---->
<!--                                                            },-->
<!--                                                            {-->
<!--                                                                latLng: [55.37, -3.41],-->
<!--                                                                name: 'UK   : 250'-->
<!---->
<!--                                                            },-->
<!--                                                            {-->
<!--                                                                latLng: [25.20, 55.27],-->
<!--                                                                name: 'UAE : 250'-->
<!---->
<!--                                                            }],-->
<!---->
<!--                                                        series: {-->
<!--                                                            regions: [{-->
<!--                                                                values: {-->
<!--                                                                    "US": '#2CA8FF',-->
<!--                                                                    "SA": '#01b2c6',-->
<!--                                                                    "AU": '#18ce0f',-->
<!--                                                                    "IN": '#f96332',-->
<!--                                                                    "GB": '#FFB236',-->
<!--                                                                },-->
<!--                                                                attribute: 'fill'-->
<!--                                                            }]-->
<!--                                                        },-->
<!--                                                        hoverOpacity: null,-->
<!--                                                        normalizeFunction: 'linear',-->
<!--                                                        zoomOnScroll: false,-->
<!--                                                        scaleColors: ['#000000', '#000000'],-->
<!--                                                        selectedColor: '#000000',-->
<!--                                                        selectedRegions: [],-->
<!--                                                        enableZoom: false,-->
<!--                                                        hoverColor: '#fff',-->
<!--                                                    });-->
<!--                                            }-->
<!--                                        }-->
<!--                                        $('#india').vectorMap({-->
<!--                                            map: 'in_mill',-->
<!--                                            backgroundColor: 'transparent',-->
<!--                                            regionStyle: {-->
<!--                                                initial: {-->
<!--                                                    fill: '#f96332'-->
<!--                                                }-->
<!--                                            }-->
<!--                                        });-->
<!--                                        $('#usa').vectorMap({-->
<!--                                            map: 'us_aea_en',-->
<!--                                            backgroundColor: 'transparent',-->
<!--                                            regionStyle: {-->
<!--                                                initial: {-->
<!--                                                    fill: '#2CA8FF'-->
<!--                                                }-->
<!--                                            }-->
<!--                                        });-->
<!--                                        $('#australia').vectorMap({-->
<!--                                            map: 'au_mill',-->
<!--                                            backgroundColor: 'transparent',-->
<!--                                            regionStyle: {-->
<!--                                                initial: {-->
<!--                                                    fill: '#18ce0f'-->
<!--                                                }-->
<!--                                            }-->
<!--                                        });-->
<!--                                        $('#uk').vectorMap({-->
<!--                                            map: 'uk_mill_en',-->
<!--                                            backgroundColor: 'transparent',-->
<!--                                            regionStyle: {-->
<!--                                                initial: {-->
<!--                                                    fill: '#00ced1'-->
<!--                                                }-->
<!--                                            }-->
<!--                                        });-->
<!--                                    </script>-->

                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-4 pt-3 pb-5">
                                    <h6 class="count-name">Turkey <span class="float-right">$293,792</span></h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-purp"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">Iran <span class="float-right">$293,792</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-green"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">UK <span class="float-right">$293,792</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">Pakistan <span class="float-right">$293,792</span>
                                        </h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-yellow"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">Russia <span class="float-right">$293,792</span>
                                        </h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-orange"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">Australia <span class="float-right">$293,792</span>
                                        </h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-purp"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">Algeria <span class="float-right">$293,792</span>
                                        </h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-green"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">China <span class="float-right">$293,792</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">United States <span
                                                    class="float-right">$293,792</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-yellow"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-3">Dubai <span class="float-right">$293,792</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-orange"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="title">Airline Base Target</div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Emirate <span class="float-right">4/65</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-orange"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Gulf Air <span class="float-right">15/92</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-yellow"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Etihad Airways <span
                                                    class="float-right">85/112</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-green"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Saudi Airline <span
                                                    class="float-right">119/212</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Turkish <span class="float-right">22/212</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-blue"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Air China <span class="float-right">4/65</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-orange"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Cathay Pacific <span
                                                    class="float-right">15/92</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-yellow"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Jet Airways <span class="float-right">85/112</span>
                                        </h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-green"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Singapore Airlines <span
                                                    class="float-right">119/212</span></h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="airline-det p-3 mt-3">
                                        <h6 class="count-name pb-2">Lufthansa <span class="float-right">22/212</span>
                                        </h6>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success for-count-blue"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="widget-card-four">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-info-green">
                                            <b>Visitor <span>+20</span></b>
                                            <h6 class="value pt-3">256</h6>
                                            <div class="w-summary-details">
                                                <div class="w-summary-stats">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="widget-card-four">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-info-purple">
                                            <b>Booking <span>+10</span></b>
                                            <h6 class="value pt-3">256</h6>
                                            <div class="w-summary-details">
                                                <div class="w-summary-stats">
                                                    <div class="progress for-blue-bar">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="widget-card-four">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-info-orange">
                                            <b>Ticket Issue <span>+20</span></b>
                                            <h6 class="value pt-3">256</h6>
                                            <div class="w-summary-details">
                                                <div class="w-summary-stats">
                                                    <div class="progress for-orange-bar">
                                                        <div class="progress-bar bg-gradient-success" role="progressbar"
                                                             style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Month Wise Sale</div>
                                </div>
                            </div>
                            <div class="card-box pb-4">
                                <div id="morris-bar-stacked" style="height: 310px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Year Wise Sale</div>
                                </div>
                            </div>
                            <div id="line-example"></div>
                        </div>
                    </div>
                </div>

                <div class="sub-title pb-4 pt-4">Hotel</div>
                <div class="row card-group-row">
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count for-height">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Country Wise</div>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-center">
                                <div class="chart fr-mrg w-100">
                                    <canvas id="bar-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 mt-lg-0 mt-md-5 mt-5">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Category Wise</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-2"></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-8 mt-top">
                                    <div id="CategorySaleDonatChart"></div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-2"></div>
                            </div>
                            <div class="row text-center mt-4 mb-4">
                                <div class="col-lg-1 col-md-1 col-sm-12 col-12"></div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                                    <div class="blue-clr-bar"></div>
                                    <h4 class="fs-18 hotel-rating text-black mt-3">2,512</h4>
                                    <img class="" src="<?= $template ?>assets/img/1-star.png">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                                    <div class="orange-clr-bar"></div>
                                    <h4 class="fs-18 hotel-rating text-black mt-3">45,612</h4>
                                    <img class="" src="<?= $template ?>assets/img/2-star.png">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                                    <div class="purple-clr-bar"></div>
                                    <h4 class="fs-18 hotel-rating text-black mt-3">45,612</h4>
                                    <img class="" src="<?= $template ?>assets/img/3-star.png">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                                    <div class="yellow-clr-bar"></div>
                                    <h4 class="fs-18 hotel-rating text-black mt-3">45,612</h4>
                                    <img class="" src="<?= $template ?>assets/img/4-star.png">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-4">
                                    <div class="green-clr-bar"></div>
                                    <h4 class="fs-18 hotel-rating text-black mt-3">45,612</h4>
                                    <img class="" src="<?= $template ?>assets/img/5-star.png">
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-12 col-12"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Visitor</p>
                                    <span class="fs-35 text-black font-w600">93
                                                <svg class="ml-1" width="19" height="12" viewBox="0 0 19 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.00401 11.1924C0.222201 11.1924 -0.670134 9.0381 0.589795 7.77817L7.78218 0.585786C8.56323 -0.195262 9.82956 -0.195262 10.6106 0.585786L17.803 7.77817C19.0629 9.0381 18.1706 11.1924 16.3888 11.1924H2.00401Z"
                                                          fill="#33C25B"/>
                                                </svg>
                                            </span>
                                </div>
                                <canvas class="lineChart" id="chart_widget_2" height="85"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Booking</p>
                                    <span class="fs-35 text-black font-w600">56
                                                <svg class="ml-1" width="19" height="12" viewBox="0 0 19 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.00401 11.1924C0.222201 11.1924 -0.670134 9.0381 0.589795 7.77817L7.78218 0.585786C8.56323 -0.195262 9.82956 -0.195262 10.6106 0.585786L17.803 7.77817C19.0629 9.0381 18.1706 11.1924 16.3888 11.1924H2.00401Z"
                                                          fill="#f12e55"/>
                                                </svg>
                                            </span>
                                </div>
                                <canvas class="lineChart" id="chart_widget_2" height="85"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12 mt-lg-0 mt-md-5 mt-sm-5 mt-0">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="d-flex align-items-end">
                                <div>
                                    <p class="title fs-14 mb-1">Refund / Cancel</p>
                                    <span class="fs-35 text-black font-w600">93
                                                <svg class="ml-1" width="19" height="12" viewBox="0 0 19 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.00401 11.1924C0.222201 11.1924 -0.670134 9.0381 0.589795 7.77817L7.78218 0.585786C8.56323 -0.195262 9.82956 -0.195262 10.6106 0.585786L17.803 7.77817C19.0629 9.0381 18.1706 11.1924 16.3888 11.1924H2.00401Z"
                                                          fill="#f99f4b"/>
                                                </svg>
                                            </span>
                                    <span class="fs-35 text-black font-w600">93
                                                <svg class="ml-1" width="19" height="12" viewBox="0 0 19 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.00401 11.1924C0.222201 11.1924 -0.670134 9.0381 0.589795 7.77817L7.78218 0.585786C8.56323 -0.195262 9.82956 -0.195262 10.6106 0.585786L17.803 7.77817C19.0629 9.0381 18.1706 11.1924 16.3888 11.1924H2.00401Z"
                                                          fill="#f99f4b"/>
                                                </svg>
                                            </span>
                                </div>
                                <canvas class="lineChart" id="chart_widget_2" height="85"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-title pb-4 pt-4">Transport</div>
                <div class="row card-group-row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="frush-sub-title">Country Wise</div>

                            <div class="card-block pt-5 pb-5">
                                <div class="row">
                                    <div class="col-sm-8 ">
                                        <div id="transport-world-map-marker" class="jvector-map"
                                             style="height: 300px"></div>
                                    </div>
<!--                                    <script>-->
<!--                                        $(function () {-->
<!---->
<!--                                            if ($('#transport-world-map-marker').length > 0) {-->
<!---->
<!--                                                $('#transport-world-map-marker').vectorMap(-->
<!--                                                    {-->
<!--                                                        map: 'world_mill_en',-->
<!--                                                        backgroundColor: 'transparent',-->
<!--                                                        borderColor: '#fff',-->
<!--                                                        borderOpacity: 0.25,-->
<!--                                                        borderWidth: 0,-->
<!--                                                        color: '#e6e6e6',-->
<!--                                                        regionStyle: {-->
<!--                                                            initial: {-->
<!--                                                                fill: '#cccccc'-->
<!--                                                            }-->
<!--                                                        },-->
<!---->
<!--                                                        markerStyle: {-->
<!--                                                            initial: {-->
<!--                                                                r: 5,-->
<!--                                                                'fill': '#fff',-->
<!--                                                                'fill-opacity': 1,-->
<!--                                                                'stroke': '#000',-->
<!--                                                                'stroke-width': 1,-->
<!--                                                                'stroke-opacity': 0.4-->
<!--                                                            },-->
<!--                                                        },-->
<!---->
<!--                                                        markers: [{-->
<!--                                                            latLng: [21.00, 78.00],-->
<!--                                                            name: 'INDIA : 350'-->
<!---->
<!--                                                        },-->
<!--                                                            {-->
<!--                                                                latLng: [-33.00, 151.00],-->
<!--                                                                name: 'Australia : 250'-->
<!---->
<!--                                                            },-->
<!--                                                            {-->
<!--                                                                latLng: [36.77, -119.41],-->
<!--                                                                name: 'USA : 250'-->
<!---->
<!--                                                            },-->
<!--                                                            {-->
<!--                                                                latLng: [55.37, -3.41],-->
<!--                                                                name: 'UK   : 250'-->
<!---->
<!--                                                            },-->
<!--                                                            {-->
<!--                                                                latLng: [25.20, 55.27],-->
<!--                                                                name: 'UAE : 250'-->
<!---->
<!--                                                            }],-->
<!---->
<!--                                                        series: {-->
<!--                                                            regions: [{-->
<!--                                                                values: {-->
<!--                                                                    "US": '#2CA8FF',-->
<!--                                                                    "SA": '#01b2c6',-->
<!--                                                                    "AU": '#18ce0f',-->
<!--                                                                    "IN": '#f96332',-->
<!--                                                                    "GB": '#FFB236',-->
<!--                                                                },-->
<!--                                                                attribute: 'fill'-->
<!--                                                            }]-->
<!--                                                        },-->
<!--                                                        hoverOpacity: null,-->
<!--                                                        normalizeFunction: 'linear',-->
<!--                                                        zoomOnScroll: false,-->
<!--                                                        scaleColors: ['#000000', '#000000'],-->
<!--                                                        selectedColor: '#000000',-->
<!--                                                        selectedRegions: [],-->
<!--                                                        enableZoom: false,-->
<!--                                                        hoverColor: '#fff',-->
<!--                                                    });-->
<!--                                            }-->
<!---->
<!---->
<!--                                        });-->
<!--                                    </script>-->
                                    <div class="col-sm-4 ">
                                        <div id="allocation-chart" style="height:250px" class="chart-shadow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="frush-sub-title">Vehicle Wise</div>
                            <!-- EXTRA AREA CHART Ends -->
                            <!-- Area Chart start -->
                            <div class="row">
                                <div class="col-lg-12 d-none">
                                    <div class="card">
                                        <div class="">
                                            <h5>Area Chart</h5>
                                            <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                        </div>
                                        <div class="">
                                            <div id="area-example"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Area Chart Ends -->
                                <!-- LINE CHART start -->
                                <div class="col-12 col-lg-6 d-none">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Line Chart</h5>
                                            <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                        </div>
                                        <div class="card-block">
                                            <div id="line-example"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-7 col-12">
                                    <div class="card-block">
                                        <div id="donut-example"></div>
                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-5 col-12">
                                    <div class="row mt-5 pt-4">
                                        <div class="col-lg-6 col-md-6 col-sm-2 col-4 mb-4">
                                            <div class="vehi-info-green">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-1 col-3 mt-1">
                                                        <div class="green-dot"></div>
                                                    </div>
                                                    <div class="col-lg-9 col-9">
                                                        <div class="vehi-text">
                                                            Car <strong>54</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-2 col-4 mb-4">
                                            <div class="vehi-info-blue">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-1 col-3 mt-1">
                                                        <div class="green-dot"></div>
                                                    </div>
                                                    <div class="col-lg-9 col-9">
                                                        <div class="vehi-text">
                                                            GMC <strong>54</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-2 col-4 mb-4">
                                            <div class="vehi-info-orange">
                                                <div class="row">
                                                    <div class="col-lg-3 col-3 mt-1">
                                                        <div class="green-dot"></div>
                                                    </div>
                                                    <div class="col-lg-9 col-9">
                                                        <div class="vehi-text">
                                                            HI <strong>54</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-2 col-4 mb-4">
                                            <div class="vehi-info-red">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-1 col-3 mt-1">
                                                        <div class="green-dot"></div>
                                                    </div>
                                                    <div class="col-lg-9 col-9">
                                                        <div class="vehi-text">
                                                            Coaster <strong>54</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 d-none d-lg-inline"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-2 col-4">
                                            <div class="vehi-info-yellow">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-1 col-3 mt-1">
                                                        <div class="green-dot"></div>
                                                    </div>
                                                    <div class="col-lg-9 col-9">
                                                        <div class="vehi-text">
                                                            BUS <strong>54</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 d-none d-lg-inline"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div id="apexspark1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div id="apexspark2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div id="apexspark3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-title pb-4 pt-4">Tourism</div>
                <div class="row card-group-row">
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Country Wise</div>
                                </div>
                            </div>
                            <div class="card-block ">
                                <div id="revenue-chart" style="height:345px" class="chart-shadow"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 mt-lg-0 mt-md-0 mt-5">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="row p-4">
                                <div class="col-lg-8 col-md-8 col-6">
                                    <div class="title">Category Wise</div>
                                </div>
                            </div>
                            <div class="card-block pt-lg-5 mt-lg-5">
                                <div id="data-use-chart" style="height:245px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="widget-card-four">
                                <div class="widget-content ">
                                    <div class="w-content">
                                        <div class="w-info w-info-purple">
                                            <b>Visitor <span>35,500</span></b>
                                            <div id="mytask-layout" class="theme-indigo">
                                                <div id="apex-circle-chart-multiple"
                                                     style="min-height: 228.7px;width: 536px;"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="widget-card-four">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-info-purple">
                                            <b>Booking <span>35,500</span></b>
                                            <div id="mytask-layout" class="theme-indigo">
                                                <div id="apex-circle"
                                                     style="min-height: 228.7px;width: 536px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="widget-card-four">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-info-purple">
                                            <b>Cancel Booking <span>35,500</span></b>
                                            <div id="mytask-layout" class="theme-indigo">
                                                <div id="apex-circle-chart-cancel-booking"
                                                     style="min-height: 228.7px;width: 536px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-title pb-4 pt-4">visa</div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="frush-sub-title">Country Wise</div>
                            <div class="theme-indigo">
                                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                                </div>
                                <!-- chart apex -->
                                <div class="card-body">
                                    <div id="apex-simple-bubble"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <div class="frush-sub-title">Category Wise</div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="tick-info p-3 mt-4">
                                        <div class="sub-title">Ticketing</div>
                                        <div class="sub-txt">Event Organizer</div>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-2">$12352<span
                                                    class="float-right">Due date: 12/05/2020</span></h6>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="tick-info p-3 mt-4">
                                        <div class="sub-title">Agency</div>
                                        <div class="sub-txt">Creative Agency</div>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-2">$12352<span
                                                    class="float-right">Due date: 12/05/2020</span></h6>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="tick-info p-3 mt-4">
                                        <div class="sub-title">Agency</div>
                                        <div class="sub-txt">Creative Agency</div>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-2">$12352<span
                                                    class="float-right">Due date: 12/05/2020</span></h6>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="tick-info p-3 mt-4">
                                        <div class="sub-title">Ticketing</div>
                                        <div class="sub-txt">Event Organizer</div>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-2">$12352<span
                                                    class="float-right">Due date: 12/05/2020</span></h6>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="tick-info p-3 mt-4 mb-4">
                                        <div class="sub-title">Agency</div>
                                        <div class="sub-txt">Creative Agency</div>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-2">$12352<span
                                                    class="float-right">Due date: 12/05/2020</span></h6>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="tick-info p-3 mt-4 mb-4">
                                        <div class="sub-title">Agency</div>
                                        <div class="sub-txt">Creative Agency</div>
                                        <div class="w-summary-stats">
                                            <div class="progress bar-set for-margin">
                                                <div class="progress-bar bg-gradient-success  for-count-pink"
                                                     role="progressbar" style="width: 65%" aria-valuenow="65"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <h6 class="count-name pt-2">$12352<span
                                                    class="float-right">Due date: 12/05/2020</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <b>Visitor</b>
                            <div class="card-box widget-box-four for-color">
                                <div id="dashboard-1" class="widget-box-four-chart"></div>
                                <div class="wigdet-four-content pull-left">
                                    <h3 class="for-color m-b-0 m-t-20"><span data-plugin="counterup">5,2548</span></h3>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <b> Booking</b>
                            <div class="card-box widget-box-four for-color">
                                <div id="dashboard-2" class="widget-box-four-chart"></div>
                                <div class="wigdet-four-content pull-left">
                                    <h3 class="for-color m-b-0 m-t-20"><span data-plugin="counterup">65,241</span></h3>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <b>In Process</b>
                            <div class="card-box widget-box-four for-color">
                                <div id="dashboard-3" class="widget-box-four-chart"></div>
                                <div class="wigdet-four-content pull-left">
                                    <h3 class="for-color m-b-0 m-t-20"><span data-plugin="counterup">28,5960</span></h3>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card hotel-sal-count umrah-sect p-4">
                            <b>Issue</b>
                            <div class="card-box widget-box-fourr">
                                <div id="dashboard-3" class="widget-box-four-chart"></div>
                                <div class="wigdet-four-content pull-left">
                                    <h3 class="for-color m-b-0 m-t-20"><span data-plugin="counterup">28,5960</span></h3>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-title pb-4 pt-4">Visitor</div>
                <div class="row card-group-row">
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-group-row__card hotel-sal-count">
                            <div class="card-body">
                                <div class="title">Daily Wise Visitor</div>
                                <div id="mytask-layout" class="theme-indigo">
                                    <div class="card-body">
                                        <div id="apex-timeline"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 card-group-row__col">
                        <div class="card card-body card-group-row__card hotel-sal-count pb-5">
                            <div class="title">Category Wise</div>
                            <div class="pt-5 pb-5">
                                <canvas id="lineChart" height="300" class="m-t-10 d-none"></canvas>
                                <canvas id="doughnut" class="mt-3" height="300" class="m-t-10"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg">
                        <div class="row card-group-row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 card-group-row__col">
                                <div class="card card-group-row__card card-body card-body-x-lg"
                                     style="position: relative; padding-bottom: calc(80px - 1.25rem); overflow: hidden; z-index: 0;">
                                    <div class="card-header__title frush-sub-title mb-2">Total Visitor</div>
                                    <div class="text-amount">&dollar;8,391</div>
                                    <div class="text-stats text-success">31.5% <i class="fa fa-arrow-up"
                                                                                  aria-hidden="true"></i></div>
                                    <div class="chart"
                                         style="height: 80px; position: absolute; left: 0; right: 0; bottom: 0;">
                                        <canvas id="productsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 card-group-row__col">
                                <div class="card card-group-row__card card-body card-body-x-lg"
                                     style="position: relative; padding-bottom: calc(80px - 1.25rem); overflow: hidden; z-index: 0;">
                                    <div class="card-header__title frush-sub-title mb-2">Unique Visitor</div>
                                    <div class="text-amount">15,021</div>
                                    <div class="text-stats text-danger">31.5% <i class="fa fa-arrow-down"
                                                                                 aria-hidden="true"></i></div>
                                    <div class="chart"
                                         style="height: 80px; position: absolute; left: 0; right: 0; bottom: 0;">
                                        <canvas id="coursesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 card-group-row__col">
                                <div class="card card-group-row__card card-body card-body-x-lg"
                                     style="position: relative; padding-bottom: calc(80px - 1.25rem); overflow: hidden; z-index: 0;">
                                    <div class="card-header__title frush-sub-title mb-2">Old Visitor</div>
                                    <div class="text-amount">&dollar;8,391</div>
                                    <div class="text-stats text-success">31.5% <i class="fa fa-arrow-up"
                                                                                  aria-hidden="true"></i></div>
                                    <div class="chart"
                                         style="height: 80px; position: absolute; left: 0; right: 0; bottom: 0;">
                                        <canvas id="productsChart-1"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 card-group-row__col">
                                <div class="card card-group-row__card card-body card-body-x-lg"
                                     style="position: relative; padding-bottom: calc(80px - 1.25rem); overflow: hidden; z-index: 0;">
                                    <div class="card-header__title frush-sub-title mb-2">Confirm Visitor</div>
                                    <div class="text-amount">15,021</div>
                                    <div class="text-stats text-danger">31.5% <i class="fa fa-arrow-down"
                                                                                 aria-hidden="true"></i></div>
                                    <div class="chart"
                                         style="height: 80px; position: absolute; left: 0; right: 0; bottom: 0;">
                                        <canvas id="coursesChar-1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sub-title pb-4 pt-4">Hajj</div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-body card-group-row__card hotel-sal-count">
                            <div class="title">Country Wise</div>
                            <div class="card-block pt-4 pb-4">
                                <div id="btc-eth-chart" style="height:260px" class="chart-shadow"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-body card-group-row__card hotel-sal-count">
                            <div class="title">Package Category Wise</div>
                            <div class="chart-container">
                                <div class="" style="height:320px" id="platform_type_dates_donut"></div>
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
        <script src="<?=$template ?>assets/bundles/jvectormap.js"></script>
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

