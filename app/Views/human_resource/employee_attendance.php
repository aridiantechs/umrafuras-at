<?php
$session = session();
$SessionFilters = $session->get('EmployeeAttendanceFiltersForm');


if (isset($SessionFilters['FromTo']) && $SessionFilters['FromTo'] != '') {
    $DateINBetween = $SessionFilters['FromTo'];

    $DATEArray = explode('to', $DateINBetween);
    $StartDateFilter = $DATEArray[0];
    $EndDateFilter = $DATEArray[1];

} else {
    $EndDate = date('Y-m-21');
    $StartDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndDate)));
    $EndDate = date("Y-m-d", strtotime("-1 day", strtotime($EndDate)));
    $DateINBetween = $StartDate . ' to ' . $EndDate;
}
?>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!--            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">-->
            <!--                <h4 class="page-head">-->
            <!--                    -->
            <? //= (isset($EmployeeName) && $EmployeeName != '' ? ucwords($EmployeeName) : 'Employee Attendance'); ?><!--</h4>-->
            <!--            </div>-->
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing details-table">
                <div class="widget-content widget-content-area br-6">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>
                                <?= ucwords($EmployeeInfo['emp_firstname'] . " " . $EmployeeInfo['emp_lastname']) ?>
                                <?php
                                if ($StartDateFilter != '' && $EndDateFilter != '') {
                                    echo '<small>( ' . DATEFORMAT($StartDateFilter) . '  -  ' . DATEFORMAT($EndDateFilter) . ' ) </small>';
                                }
                                ?>

                            </h5>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 layout-spacing"
                             style="text-align: right">
                            <form onsubmit="return false;" class="section contact" id="EmployeeAttendanceFiltersForm">

                                <span><h5 style="display: inline" class="mr-2">Date Range</h5></span>
                                <input type="hidden" name="SessionKey" id="SessionKey"
                                       value="EmployeeAttendanceFiltersForm">


                                <input type="text"
                                       class="mr-3 form-control multidate validate[required,future[now]]"
                                       name="FromTo" id="FromTo" readonly
                                       placeholder="" value="<?= $DateINBetween ?>" style="width: 20%;display: inline;">
                                <button onclick="ClearSession('EmployeeAttendanceFiltersForm');"
                                        id="btnreset" type="button" class="btn btn-danger"
                                        style="float: right;margin-right: 7px;">Clear
                                </button>
                                <button id="applybtn"
                                        class="mr-2 btn btn-success float-right" type="button"
                                        onclick="SaveEmployeeAttendanceFilterForm('EmployeeAttendanceFiltersForm')">
                                    Search
                                </button>


                            </form>
                        </div>
                    </div>
                    <hr style="margin-top: 0px !important;">
                    <div class="row pt-2 pb-2">
                        <div class="col-3">
                            <b>City:</b> <?= ((isset($EmployeeInfo['emp_city']) && $EmployeeInfo['emp_city'] != '') ? $EmployeeInfo['emp_city'] : '-') ?>
                        </div>
                        <div class="col-3">
                            <b>Address: </b> <?= ((isset($EmployeeInfo['emp_address']) && $EmployeeInfo['emp_address'] != '') ? $EmployeeInfo['emp_address'] : '-') ?>
                        </div>
                        <div class="col-3">
                            <b>Contact No:</b> <?= ((isset($EmployeeInfo['emp_phone']) && $EmployeeInfo['emp_phone'] != '') ? '<a target="_blank" href="' . WhatsAppUrl($EmployeeInfo['emp_phone']) . '">' . $EmployeeInfo['emp_phone'] . '</a>' : '-') ?>
                        </div>
                        <div class="col-3">
                            <b>Emergency Contact
                                No: </b> <?= ((isset($EmployeeInfo['emp_emergencyphone1']) && $EmployeeInfo['emp_emergencyphone1'] != '') ? '<a target="_blank" href="' . WhatsAppUrl($EmployeeInfo['emp_emergencyphone1']) . '">' . $EmployeeInfo['emp_emergencyphone1'] . '</a>' : '-') ?>
                        </div>
                    </div>
                    <div class="row pt-2 pb-2">
                        <div class="col-3">
                            <b>Hire Date: </b> <?= ((isset($EmployeeInfo['emp_hiredate']) && $EmployeeInfo['emp_hiredate'] != '') ? DATEFORMAT($EmployeeInfo['emp_hiredate']) : '-') ?>
                        </div>
                        <div class="col-3">
                            <b>Email: </b> <?= ((isset($EmployeeInfo['emp_email']) && $EmployeeInfo['emp_email'] != '') ? $EmployeeInfo['emp_email'] : '-') ?>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
<!--                    <a type="button" class="btn btn_customized  btn-sm float-right" onclick=""-->
<!--                       href="#" target="_blank">PDF-->
<!--                        Export-->
<!--                    </a>-->
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=SeoUrl('exports/employee_attendance/' . $EmployeeInfo['id'] . "-" . $EmployeeInfo['emp_firstname'] . "-" . $EmployeeInfo['emp_lastname'])?>" target="_blank">PDF Export
                    </a>
                    <div class="table-responsive mb-4">
                        <table id="EmployeeAttendance" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>FingerPrint CheckIN</th>
                                <th>FingerPrint CheckOUT</th>
                                <th>AccessDoor CheckIN</th>
                                <th>AccessDoor CheckOUT</th>
                                <th>Late</th>
                                <th>Short Leave</th>
                                <th>Half Day</th>
                                <th>Roaster</th>
                                <th>Leave</th>
                                <th>Absent</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $cnt = 0;
                            foreach ($EmployeeAttendance as $record) {
                                $cnt++; ?>
                                <tr>
                                    <td><?= $cnt ?></td>
                                    <td><?= $record['PunchDate'] ?></td>
                                    <td><?= $record['FingerPrintCheckIn'] ?></td>
                                    <td><?= $record['FingerPrintCheckOut'] ?></td>
                                    <td><?= $record['AccessDoorCheckIn'] ?></td>
                                    <td><?= $record['AccessDoorCheckOut'] ?></td>
                                    <td><?= (isset($record['LateTimeSeconds']) && $record['LateTimeSeconds'] > 0 ? $record['LateTime'] : '-') ?></td>
                                    <td><?= (isset($record['WorkedTimeDiff']) && ($record['WorkedTimeDiff'] > 2700 && $record['WorkedTimeDiff'] < 11700) ? 'Yes' : '-') ?></td>
                                    <td><?= (isset($record['WorkedTimeDiff']) && ($record['WorkedTimeDiff'] > 11700 && $record['WorkedTimeDiff'] < 17100) ? 'Yes' : '-') ?></td>
                                    <td><?= (isset($record['Roaster']) && $record['Roaster'] > 0 ? 'Yes' : '-') ?></td>
                                    <td><?= (isset($record['OnLeave']) && $record['OnLeave'] > 0 ? 'Yes' : '-') ?></td>
                                    <td>-</td>
                                </tr>
                            <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<script type="application/javascript" language="javascript">


    function ClearSession(SessionKey) {
        PlzWait('show');
        $('form#AttendanceReportForm button#btnreset').attr("disabled", true);
        var responce = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (responce.status == 'success') {
            $('form#AttendanceReportForm button#btnreset').attr("disabled", false);
            location.reload();
        }
    }


    function SaveEmployeeAttendanceFilterForm(parent) {

        PlzWait('show');
        var data = $("form#" + parent).serialize();

        var responce = AjaxResponse('filters_session/create_filters_session', data);
        if (responce.status == 'success') {
            $('form#AttendanceReportForm button#applybtn').attr("disabled", false);
            location.reload();
        }

    }


    $('#EmployeeAttendance').DataTable({
        "scrollX": true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [50, 100, 500, 1000],
        "pageLength": 50,
        "searching": false
    });
</script>