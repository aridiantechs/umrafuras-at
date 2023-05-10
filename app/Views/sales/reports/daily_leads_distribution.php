<?php
$Heads = $DailyLeadsActivityReport['heads'];
$Status = $DailyLeadsActivityReport['status'];
$LeadsStats = $DailyLeadsActivityReport['stats'];

$LeadsStatusDef = array();
foreach ($LeadStatusArray as $StatusKey => $StatusValue) {
    $LeadsStatusDef[$StatusKey] = $StatusValue;
}

$session = session();
$SessionFilters = $session->get('DailyLeadDistributionSessionFilters');

if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
    $Product = $SessionFilters['product'];
}
$StartDate = ((isset($SessionFilters['start_date']) && $SessionFilters['start_date'] != '') ? $SessionFilters['start_date'] : date("Y-m-d"));
$EndDate = ((isset($SessionFilters['end_date']) && $SessionFilters['end_date'] != '') ? $SessionFilters['end_date'] : date("Y-m-d"));

$StartTime = ((isset($SessionFilters['start_time']) && $SessionFilters['start_time'] != '') ? $SessionFilters['start_time'] : '');
$EndTime = ((isset($SessionFilters['end_time']) && $SessionFilters['end_time'] != '') ? $SessionFilters['end_time'] : '');
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Leads Status Distribution Report</h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <div id="toggleAccordion">
                    <div class="card">
                        <div class="card-header">
                            <section class="mb-0 mt-0">
                                <div role="menu" class="" data-toggle="collapse"
                                     data-target="#FilterDetails" aria-expanded="true"
                                     aria-controls="FilterDetails">
                                    Filters
                                </div>
                            </section>
                        </div>
                        <div id="FilterDetails" class="collapse show" data-parent="#toggleAccordion">
                            <div class="card-body">
                                <form method="post"
                                      onsubmit="DailyLeadDistributionFilterFormSubmit( 'DailyLeadDistributionFilterForm' ); return false;"
                                      class="section contact" name="DailyLeadDistributionFilterForm"
                                      id="DailyLeadDistributionFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="DailyLeadDistributionSessionFilters">
                                    <input type="hidden" name="start_date" id="start_date"
                                           value="<?= $StartDate ?>">
                                    <input type="hidden" name="end_date" id="end_date"
                                           value="<?= $EndDate ?>">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Create Date</label>
                                                <input type="text"
                                                       class="form-control multidate"
                                                       name="lead_create_date" id="lead_create_date"
                                                       placeholder="Create Dates" value=""
                                                       onchange="GetLeadCreateDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Start Time</label>
                                                <input value="<?= $StartTime ?>" class="form-control" type="time"
                                                       name="start_time" id="start_time">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">End Time</label>
                                                <input value="<?= $EndTime ?>" class="form-control" type="time"
                                                       name="end_time" id="end_time">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Products</label>
                                                <select name="product" id="product" class="form-control">
                                                    <option value="">Select Product</option>
                                                    <?php
                                                    foreach ($Products as $P) {
                                                        echo '<option '.( ( isset($Product) && $Product == $P )? 'selected' : '' ).' value="' . $P . '">' . ucwords($P) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="DailyLeadDistributionFilterFormSubmit( 'DailyLeadDistributionFilterForm' );"
                                                        id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('DailyLeadDistributionSessionFilters');"
                                                        id="btnreset" type="button" class="btn btn-danger">Clear
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="DailyLeadDistributionFilterAjaxResult"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Agent Name</th>
                                <?php
                                foreach ($Status as $St) {
                                    echo '<th  style="text-align: center">' . (($St == 'sms') ? 'Details on SMS' : $LeadsStatusDef[$St]) . '</th>';
                                } ?>
                                <th>Total Leads</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (count($Heads) > 0) {
                                $cnt = 0;
                                $grandTotal = array();
                                $GrandTotalAgents = array();
                                foreach ($Heads as $Headid => $HeadName) {
                                    $cnt++; ?>
                                    <tr>
                                    <td><?= $cnt ?></td>
                                    <td><?= ucwords($HeadName) ?></td><?php
                                    foreach ($Status as $St) {
                                        $RecordsCnt = (isset($LeadsStats[$Headid][$St]) ? $LeadsStats[$Headid][$St] : 0);
                                        $grandTotal[$St] += $RecordsCnt;
                                        $GrandTotalAgents[$Headid] += $RecordsCnt;
                                        /*if ($St == 'new') {
                                            echo '<th style="text-align: center"><a href="javascript:void(0);" onclick="DailyNewLeadsDisrtibution(\'' . $St . '\',\'' . $Headid . '\')">' . NUMBER($RecordsCnt) . '</a></th>';
                                        } else if ($St == 'sms') {
                                            echo '<th style="text-align: center"><a href="javascript:void(0);" onclick="DailySMSLeadsDisrtibution(\'' . $St . '\',\'' . $Headid . '\')">' . NUMBER($RecordsCnt) . '</a></th>';
                                        } else {
                                            echo '<th style="text-align: center"><a href="javascript:void(0);" onclick="DailyLeadsDisrtibution(\'' . $St . '\',\'' . $Headid . '\')"> ' . NUMBER($RecordsCnt) . ' </a></th>';
                                        }*/
                                        echo '<th style="text-align: center">' . NUMBER($RecordsCnt) . '</th>';
                                    } ?>
                                    <th style="text-align: center"><?= $GrandTotalAgents[$Headid] ?></th>
                                    </tr><?php
                                }
                            } else {
                                $Colspan = count($Status) + 3;
                                echo '<tr><td colspan="' . $Colspan . '"><div class="alert alert-danger text-center font-weight-bold">No Leads Distribution Record Found...!</div></td></tr>';
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="2"> Total</th><?php
                                $Total = 0;
                                foreach ($Status as $St) {
                                    $Total += $grandTotal[$St];
                                    echo '<th style="text-align: center">' . $grandTotal[$St] . '</th>';
                                } ?>
                                <th style="text-align: center"><?= $Total ?></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        setTimeout(function () {
            var StartDate = "<?=$StartDate?>";
            var EndDate = "<?=$EndDate?>";
            $("#start_date").val(StartDate);
            $("#end_date").val(EndDate);
            if (StartDate != '' && EndDate != '') {
                $("#lead_create_date").val(StartDate + " to " + EndDate);
            } else {
                $("form#DailyLeadDistributionFilterForm input#start_date").val('');
                $("form#DailyLeadDistributionFilterForm input#end_date").val('');
            }
        }, 1000);

    });

    function GetLeadCreateDate() {
        const LeadCreateDate = $("#lead_create_date").val();
        const words = LeadCreateDate.split(' to ');
        $("#start_date").val(words[0]);
        $("#end_date").val(words[1]);
    }

    function DailyLeadDistributionFilterFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'DailyLeadDistributionFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('DailyLeadDistributionFilterForm', 'DailyLeadDistributionFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#DailyLeadDistributionFilterForm input#start_date").val('');
            $("form#DailyLeadDistributionFilterForm input#end_date").val('');
            $("form#DailyLeadDistributionFilterForm input#start_time").val('');
            $("form#DailyLeadDistributionFilterForm input#end_time").val('');
            $("form#DailyLeadDistributionFilterForm")[0].reset();
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

    setTimeout(function () {
        $('<a href="<?=$path?>exports/daily_leads_distribution" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
