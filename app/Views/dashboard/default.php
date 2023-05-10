<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<!--xxxxxxxxxxxxxxx-->
<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/widgets/modules-widgets.css">
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 layout-spacing" id="MainAgentsChart">
                <div class="widget widget-five">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Monthly Agents Revenue</h6>
                                <p class="meta-date" id="agentsChartDate">Nov 2019</p>
                            </div>
                        </div>
                        <div class="widget-content p-3">
                            <div id="loadAgentsChart" class="text-center" align="center"></div>
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
                                <h6>Entered Today</h6>
                                <p class="meta-date"><?php echo date("d M, Y", strtotime(date("Y-m-d"))); ?></p>
                            </div>
                        </div>
                        <div class="w-content">
                            <div class="">
                                <p class="task-left" id="TodayStatsEntered"></p>
                            </div>
                        </div>
                        <hr class="text-white">
                        <br/><br/>
                        <div class="header">
                            <div class="header-body">
                                <h6>Exited Today</h6>
                                <p class="meta-date"><?php echo date("d M, Y", strtotime(date("Y-m-d"))); ?></p>
                            </div>
                        </div>
                        <div class="w-content">
                            <div class="">
                                <p class="task-left" id="TodayStatsExit"></p>
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
                                <p class="meta-date" id="PilgrimsChatDate">Nov 2019</p>
                            </div>

                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadPilgrimsChat('current-week');">Current Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadPilgrimsChat('current-month');">Current Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadPilgrimsChat('last-month');">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadPilgrimsChat('3-months');">Last 3 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadPilgrimsChat('6-months');">Last 6 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadPilgrimsChat('current-year');">Current Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div id="LoadPilgrimsChat" class="text-center" align="center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row layout-top-spacing">

            <!--            Groups                       -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainGroupStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> Groups</h6>
                                <p class="meta-date" id="GroupStatsDate">Nov 2019</p>
                            </div>

                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadGroupStats('current-week');">Current Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadGroupStats('current-month');">Current Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadGroupStats('last-month');">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadGroupStats('3-months');">Last 3 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadGroupStats('6-months');">Last 6 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadGroupStats('current-year');">Current Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content p-1">
                            <div id="GroupStatsRecords"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Transaction                       -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainTransactionStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> Transactions</h6>
                                <p class="meta-date" id="TransactionStatsDate">Nov 2019</p>
                            </div>

                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadTransactionStats('current-week');">Current Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadTransactionStats('current-month');">Current Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadTransactionStats('last-month');">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadTransactionStats('3-months');">Last 3 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadTransactionStats('6-months');">Last 6 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadTransactionStats('current-year');">Current Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content p-1">
                            <div id="TransactionStatsRecords"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Entry Exit ELM                       -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainELMStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6> ENTRY & EXIT - ELM</h6>
                                <p class="meta-date" id="ELMStatsDate">Nov 2019</p>
                            </div>

                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadELMStats('current-week');">Current Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadELMStats('current-month');">Current Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadELMStats('last-month');">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadELMStats('3-months');">Last 3 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadELMStats('6-months');">Last 6 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadELMStats('current-year');">Current Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content p-1">
                            <div id="ELMStatsRecords"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--            Transaction                       -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainMofaStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">

                        <div class="header">
                            <div class="header-body">
                                <h6>Photo rejected by MOFA</h6>
                                <p class="meta-date" id="MofaStatsDate">Nov 2019</p>
                            </div>

                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadMofaStats('current-week');">Current Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadMofaStats('current-month');">Current Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadMofaStats('last-month');">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadMofaStats('3-months');">Last 3 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadMofaStats('6-months');">Last 6 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadMofaStats('current-year');">Current Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content p-1">
                            <div id="MofaStatsRecords"></div>
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
<!--                                <p class="meta-date" id="RecentActivitiesDate">Nov 2019</p>-->
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
<!--                                           onclick="LoadRecentActivities('current-week');">Current Week</a>-->
<!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                           onclick="LoadRecentActivities('current-month');">Current Month</a>-->
<!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                           onclick="LoadRecentActivities('last-month');">Last Month</a>-->
<!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                           onclick="LoadRecentActivities('3-months');">Last 3 Months</a>-->
<!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                           onclick="LoadRecentActivities('6-months');">Last 6 Months</a>-->
<!--                                        <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                           onclick="LoadRecentActivities('current-year');">Current Year</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="widget-content">
                            <div class="mt-container mx-auto mt-4" style="height: 357px;">
                                <div class="timeline-line" id="RecentActivitiesRecords"></div>
                            </div>
                            <div class="tm-action-btn">
                                <button class="btn" onclick="location.href='<?= $path ?>home/activities'">View All
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
                                <p class="meta-date" id="RecentActivitiesDate">Nov 2019</p>
                            </div>

                            <div class="task-action">
                                <div class="dropdown  custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadRecentActivities('current-week');">Current Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadRecentActivities('current-month');">Current Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadRecentActivities('last-month');">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadRecentActivities('3-months');">Last 3 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadRecentActivities('6-months');">Last 6 Months</a>
                                        <a class="dropdown-item" href="javascript:void(0);"
                                           onclick="LoadRecentActivities('current-year');">Current Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div class="mt-container mx-auto mt-4" style="height: 357px;">
                                <div class="timeline-line" id="RecentActivitiesRecords"></div>
                            </div>
                            <div class="tm-action-btn">
                                <button class="btn" onclick="location.href='<?= $path ?>home/activities'">View All
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

<script type="application/javascript">
    function LoadTodayStats() {
        $("#MainTodayStats #TodayStatsEntered").html("");
        $("#MainTodayStats #TodayStatsExit").html("");
        result = AjaxResponse("dashboard_ajax/today_stats", "");

        // $("#MainRecentActivities #RecentActivitiesDate").html(result.date_html);
        $("#MainTodayStats #TodayStatsEntered").html(result.today_enter);
        $("#MainTodayStats #TodayStatsExit").html(result.today_exit);
    }


    function LoadGroupStats(dateString) {
        $("#MainGroupStats #GroupStats").html("");
        result = AjaxResponse("dashboard_ajax/group_stats", "date=" + dateString);

        $("#MainGroupStats #GroupStatsDate").html(result.date_html);
        $("#MainGroupStats #GroupStatsRecords").html(result.record_html);
    }

    function LoadTransactionStats(dateString) {
        $("#MainTransactionStats #TransactionStats").html("");
        result = AjaxResponse("dashboard_ajax/transaction_stats", "date=" + dateString);

        $("#MainTransactionStats #TransactionStatsDate").html(result.date_html);
        $("#MainTransactionStats #TransactionStatsRecords").html(result.record_html);
    }

    function LoadELMStats(dateString) {
        $("#MainELMStats #ELMStats").html("");
        result = AjaxResponse("dashboard_ajax/elm_stats", "date=" + dateString);

        $("#MainELMStats #ELMStatsDate").html(result.date_html);
        $("#MainELMStats #ELMStatsRecords").html(result.record_html);
    }

    function LoadMofaStats(dateString) {
        $("#MainMofaStats #MofaStats").html("");
        result = AjaxResponse("dashboard_ajax/mofa_stats", "date=" + dateString);

        $("#MainMofaStats #MofaStatsDate").html(result.date_html);
        $("#MainMofaStats #MofaStatsRecords").html(result.record_html);
    }


    function LoadRecentActivities(dateString) {
        $("#MainRecentActivities #RecentActivitiesRecords").html("");
        result = AjaxResponse("dashboard_ajax/recent_activities", "date=" + dateString);

        $("#MainRecentActivities #RecentActivitiesDate").html(result.date_html);
        $("#MainRecentActivities #RecentActivitiesRecords").html(result.record_html);
    }


    function LoadPilgrimsChat(dateString) {
        $("#MainPilgrimsChat #LoadPilgrimsChat").html("");
        result = AjaxResponse("dashboard_ajax/pilgrims_chat", "date=" + dateString);

        $("#MainPilgrimsChat #PilgrimsChatDate").html(result.date_html);

        var options = {
            chart: {
                type: 'donut',
                width: '100%'
            },
            colors: ['#5c1ac3', '#e2a03f', '#e7515a', '#e2a03f'],
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
                                color: '#bfc9d4',
                                offsetY: 16,
                                formatter: function (val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                color: '#888ea8',
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
                width: 25,
                colors: '#0e1726'
            },
            series: [result.total_enter, result.total_exit, result.total_process],
            labels: ['Entered', 'Exits', 'In-Process'],
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
    }

    function loadAgentsChart(agent) {
        $("#MainAgentsChart #loadAgentsChart").html("");
        result = AjaxResponse("dashboard_ajax/agents_chart", "agent=" + agent);
        $("#MainAgentsChart #agentsChartDate").html(result.agent);
        var options1 = {
            chart: {
                fontFamily: 'Nunito, sans-serif',
                height: 365,
                type: 'area',
                zoom: {
                    enabled: false
                },
                dropShadow: {
                    enabled: true,
                    opacity: 0.3,
                    blur: 5,
                    left: -7,
                    top: 22
                },
                toolbar: {
                    show: false
                },
                events: {
                    mounted: function (ctx, config) {
                        const highest1 = ctx.getHighestValueInSeries(0);
                        const highest2 = ctx.getHighestValueInSeries(1);

                        ctx.addPointAnnotation({
                            x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
                            y: highest1,
                            label: {
                                style: {
                                    cssClass: 'd-none'
                                }
                            },
                            customSVG: {
                                SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                cssClass: undefined,
                                offsetX: -8,
                                offsetY: 5
                            }
                        })

                        ctx.addPointAnnotation({
                            x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
                            y: highest2,
                            label: {
                                style: {
                                    cssClass: 'd-none'
                                }
                            },
                            customSVG: {
                                SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                cssClass: undefined,
                                offsetX: -8,
                                offsetY: 5
                            }
                        })
                    },
                }
            },
            colors: ['#1b55e2', '#e7515a'],
            dataLabels: {
                enabled: false
            },
            markers: {
                discrete: [{
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 5
                }, {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 4
                }]
            },
            subtitle: {
                text: 'Revenue',
                align: 'left',
                margin: 0,
                offsetX: -10,
                offsetY: 35,
                floating: false,
                style: {
                    fontSize: '14px',
                    color: '#888ea8'
                }
            },
            title: {
                text: '10,840',
                align: 'left',
                margin: 0,
                offsetX: -10,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize: '25px',
                    color: '#bfc9d4'
                },
            },
            stroke: {
                show: true,
                curve: 'smooth',
                width: 2,
                lineCap: 'square'
            },
            series: [{
                name: 'Income',
                data: result.data
            }],
            labels: result.label,
            xaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    show: true
                },
                labels: {
                    offsetX: 0,
                    offsetY: 5,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Nunito, sans-serif',
                        cssClass: 'apexcharts-xaxis-title',
                    },
                }
            },
            yaxis: {
                labels: {
                    formatter: function (value, index) {
                        return (value / 1000) + 'K'
                    },
                    offsetX: -22,
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Nunito, sans-serif',
                        cssClass: 'apexcharts-yaxis-title',
                    },
                }
            },
            grid: {
                borderColor: '#191e3a',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: -10
                },
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -50,
                fontSize: '16px',
                fontFamily: 'Nunito, sans-serif',
                markers: {
                    width: 10,
                    height: 10,
                    strokeWidth: 0,
                    strokeColor: '#fff',
                    fillColors: undefined,
                    radius: 12,
                    onClick: undefined,
                    offsetX: 0,
                    offsetY: 0
                },
                itemMargin: {
                    horizontal: 0,
                    vertical: 20
                }
            },
            tooltip: {
                theme: 'dark',
                marker: {
                    show: true,
                },
                x: {
                    show: false,
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: .28,
                    opacityTo: .05,
                    stops: [45, 100]
                }
            },
            responsive: [{
                breakpoint: 575,
                options: {
                    legend: {
                        offsetY: -30,
                    },
                },
            }]
        }

        var chart1 = new ApexCharts(
            document.querySelector("#loadAgentsChart"),
            options1
        );

        chart1.render();
    }


    LoadPilgrimsChat('current-month');
    agentId = $('#MainAgentsChart #agent').val();
    loadAgentsChart(agentId);
    LoadRecentActivities('current-month');
    LoadTodayStats();
    LoadGroupStats('current-month');
    LoadTransactionStats('current-month');
    LoadELMStats('current-month');
    LoadMofaStats('current-month');


</script>
