<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<link href="<?= $template ?>plugins/flatpickr/flatpickr.css" rel="stylesheet" type="text/css">
<link href="<?= $template ?>plugins/flatpickr/custom-flatpickr.css" rel="stylesheet" type="text/css">
<?php

use App\Models\HRModel;

$HrModel = new HRModel();

$session = session();
$Date = date("Y-m-d");
$SessionFilters = $session->get('HrDashboardSessionFilter');
if (isset($SessionFilters['SelectedDate']) && $SessionFilters['SelectedDate'] != '') {
    $Date = date("Y-m-d", strtotime($SessionFilters['SelectedDate']));
}

$LastPunchingDateData = $HrModel->GetAllAttendancePunchingData($order_by = 'DESC', $limit = 1);
$EmployeesTodayAttendance = $HrModel->GetAllEmployeesCheckInCheckOut();
$MonthlyTopFiveEmployees = $HrModel->MonthlyTopFiveEmployees();

?>
<style>
    .table > thead > tr > th {
        color: black;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 layout-spacing">
                <h6> HR Dashboard
                    <badge class="badge badge-warning badge-mini"><b>Last Punch &raquo;
                            <?= ((date("Y-m-d") == date('Y-m-d', strtotime($LastPunchingDateData[0]['punch_time']))) ?
                                date('h:i A', strtotime($LastPunchingDateData[0]['punch_time'])) :
                                date('d M, Y h:i A', strtotime($LastPunchingDateData[0]['punch_time']))) ?></b>
                    </badge>
                </h6>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="HrDashboardSearchFiltersForm">
                    <button onclick="HrDashboardFiltersFormSubmit( 'HrDashboardSearchFiltersForm' );" type="button"
                            class="btn btn_customized
                     btn-mini float-right">Apply Filter
                    </button>
                    <input type="hidden" name="SessionKey" id="SessionKey" value="HrDashboardSessionFilter">
                    <input value="<?= $Date ?>" id="rangeCalendarFlatpickr" name="SelectedDate"
                           style="width: 35%;float: right !important; margin-right: 5px !important;"
                           class="form-control flatpickr flatpickr-input active" type="text"
                           placeholder="Select Date..">
                    </h4>
                </form>
            </div>
            <!--<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-five widget-table-one" style="float: right;width: 63%;padding: 2px;">
                    <div class="widget-content">
                        <div class="widget-content p-1 text-center">
                            <div id="TransactionStatsRecords">
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <span> <h4 class="ml-2"
                                                           style="font-size: 12px;">Last Punching Time &raquo; <? /*= ((date("Y-m-d") == date('Y-m-d', strtotime($LastPunchingDateData[0]['punch_time']))) ? date('h:i A', strtotime($LastPunchingDateData[0]['punch_time'])) : date('d M, Y h:i A', strtotime($LastPunchingDateData[0]['punch_time']))) */ ?></h4></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
        <div style="margin-top: 15px !important;" class="row layout-top-spacing">
            <div class="col-md-8">
                <h6>Employees Attendance &raquo; <small id="EmployeeAttendanceDateDiv"
                                                        style="color: #DDA420; font-weight: bold;">( <?= date("d M, Y", strtotime($Date)) ?>
                        )</small></h6>
            </div>
            <div class="col-md-4">
                <h6 class="float-right mb-2 ">
                    <button type="button" onclick="LoadModal('human_resource/manual_attendance_import', 0,'modal-md')"
                            class="btn btn-lg btn-primary btn-success">Manual Attendance Import
                    </button>
                </h6>

            </div>
            <div class="col-md-12">
                <div class="row" id="EmployeesAttendanceRecordDiv"></div>
            </div>
            <?php /*            if (count($EmployeesTodayAttendance) > 0) {

                            foreach ($EmployeesTodayAttendance as $ETA) {

                                echo '<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                                            <div class="widget widget-card-four">
                                                <div class="widget-content">
                                                    <div class="w-content">
                                                        <div class="w-info">
                                                            <h6 class="value"> ' . date('h:i A', strtotime($ETA['CheckInDate'])) . ' </h6>
                                                            <p class=""><a href="javascript:void(0);">' . ucwords($ETA['Employee']) . '</a></p>
                                                        </div>
                                                        <div class="">
                                                            <div class="w-icon">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                     stroke-linecap="round" stroke-linejoin="round"
                                                                     class="feather feather-users">
                                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                                    <circle cx="9" cy="7" r="4"></circle>
                                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                            }
                        } else {

                            echo '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                                    <div class="alert alert-danger text-center font-weight-bold">No Record Found...!</div>
                                </div>';

                        } */ ?>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <h6>Top 5 Employees <b style="color: #DDA420;">(<?= date("d M, Y", strtotime("-15 days")) ?>
                        , <?= date("d M, Y") ?> )</b></h6>
                <table class="table table-sm table-bordered table-striped ">
                    <thead style="background: #DDA420; font-weight: bold; color: black !important;">
                    <tr>
                        <th style="background: #7F6A394A !important; text-align: center;" width="100" rowspan="2">Date
                        </th>
                        <th style="text-align: center;" colspan="5">Employees</th>
                    </tr>
                    <tr style="background: #7F6A394A !important;">
                        <th>#1</th>
                        <th>#2</th>
                        <th>#3</th>
                        <th>#4</th>
                        <th>#5</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $html = '';
                    if (count($MonthlyTopFiveEmployees) > 0) {

                        foreach ($MonthlyTopFiveEmployees as $Date => $EmployeeDetails) {

                            $html .= '<tr>
                                                <td style="background: #ebeb7c !important;"><b>' . date("d M, Y", strtotime($Date)) . '</b></td>';
                            for ($i = 0; $i < 5; $i++) {
                                $html .= '<td style="font-size: 10px !important;">' . ((isset($EmployeeDetails[$i]) && $EmployeeDetails[$i] != '') ? $EmployeeDetails[$i] : '-') . '</td>';
                            }
                            $html .= '</tr>';
                        }
                    }
                    echo $html;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?= $template ?>plugins/flatpickr/flatpickr.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        PlzWait('show');
        setTimeout(function () {
            LoadTodayEmployeeAttendance();
        }, 10);

        var f3 = flatpickr(document.getElementById('rangeCalendarFlatpickr'), {
            mode: "single",
        });
    });

    function LoadTodayEmployeeAttendance() {

        var html = '';

        var AttendanceData = AjaxResponse('hr/get_employees_checkin_checkout_data');
        var AttendanceRecord = AttendanceData.Record;
        var Date = AttendanceData.Date;
        if (AttendanceRecord != '' && AttendanceRecord != null) {

            for (var i = 0; i < AttendanceRecord.length; i++) {

                html += '<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">\
                            <div class="widget widget-card-four">\
                                <div class="widget-content">\
                                    <div class="w-content">\
                                        <div class="w-info">\
                                          <div> <span class="CheckIn" style="font-size: 14px;font-weight: bolder;color: #dda420;" > CheckIn </span>\
                                           <span class="CheckOut" style="font-size: 14px;font-weight: bolder;float: right;margin-right: 0px;color: #dda420;"> CheckOut </span></div>\
                                           <span> <h6 class="value"> ' + AttendanceRecord[i].CheckInDate + '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' + AttendanceRecord[i].CheckOutDate + ' </h6></span>\
                                            <p class="" style="display: inline;"><a href="<?=SeoUrl('hr/employee_attendance')?>/' + AttendanceRecord[i].EmployeeID + '-' + AttendanceRecord[i].Employee + '" target="_blank" >' + AttendanceRecord[i].Employee + '</a></p><span style="margin-left: 7px;font-weight: bold;">(' + AttendanceRecord[i].TIMEDIFF + ')</span>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                         </div>';
            }

        } else {

            html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">\
                        <div class="alert alert-danger text-center font-weight-bold">No Record Found...!</div>\
                </div>';
        }
        PlzWait('hide');
        $("h6 small#EmployeeAttendanceDateDiv").html('( ' + Date + ' )');
        $("div#EmployeesAttendanceRecordDiv").html(html);
    }

    function HrDashboardFiltersFormSubmit(parent) {

        PlzWait('show');
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            setTimeout(function () {
                LoadTodayEmployeeAttendance();
            }, 500);
        }
    }

</script>