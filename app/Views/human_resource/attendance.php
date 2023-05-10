<?php

use App\Models\HRModel;

$HrModel = new HRModel();
$LastPunchingDateData = $HrModel->GetAllAttendancePunchingData($order_by = 'DESC', $limit = 1);
$EmployeesTodayAttendance = $HrModel->GetAllEmployeesTodayAttendance();
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
                <h6>Employees Attendance &raquo; <small
                            style="color: #DDA420; font-weight: bold;">( <?= date("d M, Y") ?> )</small></h6>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 layout-spacing">

                <div class="widget widget-five widget-table-one" style="float: right;width: 63%;padding: 2px;">
                    <div class="widget-content">
                        <div class="widget-content p-1 text-center">
                            <div id="TransactionStatsRecords">
                                <div class="transactions-list">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <span> <h4 class="ml-2"
                                                           style="font-size: 12px;">Last Punching Time &raquo; <?= ((date("Y-m-d") == date('Y-m-d', strtotime($LastPunchingDateData[0]['punch_time']))) ? date('h:i A', strtotime($LastPunchingDateData[0]['punch_time'])) : date('d M, Y h:i A', strtotime($LastPunchingDateData[0]['punch_time']))) ?></h4></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row layout-top-spacing">
            <?php
            if (count($EmployeesTodayAttendance) > 0) {

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

            } ?>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <h6><b style="color: #DDA420;">( <?= date("M, Y") ?> )</b> Top 5 Employees</h6>
                <table class="table table-bordered table-striped">
                    <thead style="background: #DDA420; font-weight: bold; color: black !important;">
                    <tr>
                        <th width="150" rowspan="2">Date</th>
                        <th style="text-align: center;" colspan="5">Employees</th>
                    </tr>
                    <tr>
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
                        if(count($MonthlyTopFiveEmployees) > 0){

                            foreach($MonthlyTopFiveEmployees as $Date => $EmployeeDetails){

                                $html.='<tr>
                                            <td>'.date("d M, Y", strtotime($Date)).'</td>';
                                for($i=0; $i<5; $i++){
                                    $html.='<td>'.( ( isset($EmployeeDetails[$i]) && $EmployeeDetails[$i] != '' )? $EmployeeDetails[$i] : '-' ).'</td>';
                                }
                                $html.='</tr>';
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