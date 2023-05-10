<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/widgets/modules-widgets.css">
<style>
    .loader-position {
        margin: 50% auto;
    }
</style>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <h4>Welcome "<?= $session['name'] ?>" as <?= $user_types[$session['type']] ?></h4>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing" id="MainGroupStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">
                        <div class="header">
                            <div class="header-body">
                                <h6>Current Stats</h6>
                            </div>
                        </div>
                        <div class="widget-content p-1 text-center">
                            <div id="GroupStatsRecords"><div class="spinner-grow text-warning align-self-center loader-position"></div></div>
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
    function LoadGroupStats(dateString) {
        $("#MainGroupStats #GroupStats").html("");
        result = AjaxResponse("dashboard_ajax/mofa_dashboard_group_stats", "date=" + dateString);
        $("#MainGroupStats #GroupStatsRecords").html(result.record_html);

        setInterval(function () {
            // LoadGroupStats(dateString)
        }, 60000)
    }

    setTimeout(function () {
        LoadGroupStats('current-month');
    }, 1000)
</script>
