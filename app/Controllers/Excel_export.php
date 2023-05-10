<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\HRModel;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;

class Excel_export extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());
    }

    public function agents_list()
    {
        $Records = array();
        $Records['heading'] = "Registered Agents";
        $Records['start_col'] = "A";
        $Records['end_col'] = "D";
        $Records['records_heads'] = array("Sr.", "Code", "Full Name", "Contact Number");

        ////////////// BODY ///////////
        $Agents = new Agents();
        $AgentsRecords = $Agents->ListAgents();

        $exceldata = array();
        $cnt = 1;
        foreach ($AgentsRecords as $AgentsRecord) {
            $exceldata[] = array(
                'sr' => $cnt . " ",
                'code' => Code("UA/A/", $AgentsRecord['UID']),
                'name' => $AgentsRecord['FullName'] . " "
            );
            $cnt++;
        }
        $Records['records'] = $exceldata;

        $this->GenerateExcel($Records);
        exit;
    }

    public function mofa_temp_upload_list()
    {
        $Records = array();
        $Records['heading'] = "MOFA Temp Uploaded Records";
        $Records['start_col'] = "A";
        $Records['end_col'] = "U";
        $Records['records_heads'] = array("Sr.", "Operator", "Ext Agent", "Group", "Print Date", "Pilgrim Name",
            "Pilgrim ID", "Age", "DOB", "Group Name", "Passport No", "MOFA No", "Issue Date Time", "Embassy",
            "PKG Code", "Relation", "Nationality", "Address", "Sub Agent Name", "MOI Number", "Insurance Policy ID");

        ////////////// BODY ///////////
        $listMofa = new MofaProcess();
        $MOFARecords = $listMofa->MOFAlist();

        $exceldata = array();
        $cnt = 1;
        foreach ($MOFARecords as $MOFARecord) {
            $exceldata[] = array(
                'Sr' => $cnt . " ",
                'Operator' => $MOFARecord['Operator'],
                'ExtAgent' => $MOFARecord['ExtAgent'],
                'Group' => $MOFARecord['Group'],
                'PrintDate' => $MOFARecord['PrintDate'],
                'PilgrimName' => $MOFARecord['PilgrimName'],
                'PilgrimID' => $MOFARecord['PilgrimID'],
                'Age' => $MOFARecord['Age'],
                'DOB' => $MOFARecord['DOB'],
                'GroupName' => $MOFARecord['GroupName'],
                'PassportNo' => $MOFARecord['PassportNo'],
                'MOFANumber' => $MOFARecord['MOFANumber'],
                'IssueDateTime' => $MOFARecord['IssueDateTime'],
                'Embassy' => $MOFARecord['Embassy'],
                'PKGCode' => $MOFARecord['PKGCode'],
                'Relation' => $MOFARecord['Relation'],
                'Nationality' => $MOFARecord['Nationality'],
                'Address' => $MOFARecord['Address'],
                'SubAgentName' => $MOFARecord['SubAgentName'],
                'MOINumber' => $MOFARecord['MOINumber'],
                'InsurancePolicyID' => $MOFARecord['INSURANCE_POLICY_ID'],
            );
            $cnt++;
        }
        $Records['records'] = $exceldata;

        $this->GenerateExcel($Records);
        exit;
    }


    public function attendance_report()
    {


        $session = session();
        $SessionFilters = $session->get('AttendenceReportSessionFilter');
        if (isset($SessionFilters['SelectedMonth']) && $SessionFilters['SelectedMonth'] != '') {
            $Month = $SessionFilters['SelectedMonth'];
        } else {
            $Month = date("m");
        }
        if (isset($SessionFilters['SelectedYear']) && $SessionFilters['SelectedYear'] != '') {
            $Year = $SessionFilters['SelectedYear'];
        } else {
            $Year = date("Y");
        }

        $EndMonthDate = $Year . "-" . $Month . "-21";
        $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
        $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));

        $dateArray = $this->displayDate($StartMonthDate, $EndMonthDate);

        $val = '';
        foreach ($dateArray as $key => $value) {
            $val .= $value . "-";
        }

//        echo $val;
        $valueee = explode("-", $val);
        //        print_r($valueee);exit;
//        echo"<br>";
//        $valueee = explode("-", $finalVal);

//        print_r($finalVal);exit;

        $Records = array();
        $Records['heading'] = "Attendance Records";
        $Records['start_col'] = "A";
        $Records['end_col'] = "Z";

        $records_heads = array("Sr.", "Employee Name", "Presents", "Ontime", "Over Time", "Late",
            "Leaves", "Short Leave", "Half Day", "Absents");
        $Records['records_heads'] = (array_merge($records_heads, $valueee));
        ////////////// BODY ///////////
        $HRModel = new HRModel();
        $EmployeesData = $HRModel->AllEmployees();


        $OfficalHolidays = $HRModel->OfficalHolidays();
        $EmployeeAttendance = $HRModel->EmployeesLastMonthAttendance();
        $EmployeeLeaveCategory = $HRModel->GetLeavesCategoryDataByDate();


        $exceldata = array();
        $cnt = 1;
        foreach ($EmployeesData as $record) {

            $Check = '';
            $TotalLate = 0;
            $TotalPresents = 0;
            $TotalAbsents = 0;
            $ShortLeave = 0;
            $HalfDay = 0;
            $OnTime = 0;
            $TotalLeaves = 0;
            foreach ($dateArray as $key => $value) {
                if (date("l", strtotime($key)) == 'Sunday' || in_array(date("Y-m-d", strtotime($key)), $OfficalHolidays)) {
                    $Check .= '-';
                } else {
                    $leave = '';
                    if (isset($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN']) && $EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN'] != '') {
                        $PunchTime = date("H:i:s", strtotime($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN']));
//                                                    $RuleTime = date("H:i:s", strtotime('9:15:0'));
                        if (isset($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['LateStart'])) {
                            $RuleTime = date("H:i:s", strtotime($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['LateStart']));
                            $LateTime = TimeDiff($PunchTime, $RuleTime);
                        } else {
                            $LateTime = 1;
                        }
                        $LeaveCheck = '';
                        if (isset($EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) {
                            $LeaveCheck = '- ' . ucwords(str_replace('_', ' ', $EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) . '';
                            $TotalLeaves = $TotalLeaves + 1;
                        }
                        $Check .= 'P ' . (($LateTime > 0) ? "- " . gmdate("H:i:s", $LateTime) : $LeaveCheck) . '';

                        if ($LateTime > 0 && $LateTime < 2700) {
                            $TotalLate = $TotalLate + 1;
                        } elseif ($LateTime > 2701 && $LateTime < 9000) {
                            $ShortLeave = $ShortLeave + 1;
                        } else if ($LateTime > 9001) {
                            $HalfDay = $HalfDay + 1;
                        } else {
                            $OnTime = $OnTime + 1;
                        }
                        $TotalPresents = $TotalPresents + 1;
                        $Check .= '-';

                    } else {
                        if (isset($EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) {
                            $Check .= ' ' . ucwords(str_replace('_', ' ', $EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) . '';
                            $TotalLeaves = $TotalLeaves + 1;
                            $Check .= '-';
                        } else {
                            $future = DateDiff(date("Y-m-d"), $key);
                            if ($future > 0) {
                                $Check .= '-';
                            } else {
                                $Check .= 'A';
                                $TotalAbsents = $TotalAbsents + 1;
                            }
                            $Check .= '-';
                        }
                    }
                }
            }
//            $test = implode(",", $Check);
//            $test = str_replace("-","," ,$Check);
//            print_r($test);
//            exit;

            $exceldata[] = array(
                'Sr' => $cnt . " ",
                'Employee Name' => $record['emp_firstname'] . " " . $record['emp_lastname'],
                'Presents' => $TotalPresents,
                'Ontime' => $OnTime,
                'Over Time' => '-',
                'Late' => $TotalLate,
                'Leaves' => $TotalLeaves,
                'Short Leave' => $ShortLeave,
                'Half Day' => $HalfDay,
                'Absents' => $TotalAbsents,
                ' '.$valueee.' ' => $Check,
            );
            $cnt++;
        }
        $Records['records'] = $exceldata;

        $this->GenerateExcel($Records);
        exit;
    }


    public function employee_summary()
    {


        $session = session();
        $SessionFilters = $session->get('EmployeeSummarySessionFilter');
//        if (isset($SessionFilters['SelectedMonth']) && $SessionFilters['SelectedMonth'] != '') {
//            $Month = $SessionFilters['SelectedMonth'];
//        } else {
//            $Month = date("m");
//        }
//        if (isset($SessionFilters['SelectedYear']) && $SessionFilters['SelectedYear'] != '') {
//            $Year = $SessionFilters['SelectedYear'];
//        } else {
//            $Year = date("Y");
//        }
//
//        $EndMonthDate = $Year . "-" . $Month . "-21";
//        $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
//        $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));


        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '') {
            $From = $SessionFilters['from'];
        }

        if (isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
            $To = $SessionFilters['to'];
        }

        if ($From != '' && $To != '') {
            $StartMonthDate = $From;
            $EndMonthDate = $To;
        } else {
            $Month = date("m");
            $Year = date("Y");
            $EndMonthDate = $Year . "-" . $Month . "-21";
            $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
            $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));

        }


        $dateArray = $this->displayDate($StartMonthDate, $EndMonthDate);


        $Records = array();
        $Records['heading'] = "Employee Summary";
        $Records['start_col'] = "A";
        $Records['end_col'] = "J";

        $Records['records_heads'] = array("Sr.", "Employee Name", "Presents", "Ontime", "Over Time", "Late",
          "Short Leave", "Half Day", "Absents",  "Leaves");
         ////////////// BODY ///////////
        $HRModel = new HRModel();
        $EmployeesData = $HRModel->AllEmployeesSummary();


        $OfficalHolidays = $HRModel->OfficalHolidays();
        $EmployeeAttendance = $HRModel->EmployeesSummaryReport();
        $EmployeeLeaveCategory = $HRModel->GetEmployeesLeavesCategoryDataByDate();


        $exceldata = array();
        $cnt = 1;
        foreach ($EmployeesData as $record) {

            $Check = '';
            $TotalLate = 0;
            $TotalPresents = 0;
            $TotalAbsents = 0;
            $ShortLeave = 0;
            $HalfDay = 0;
            $OnTime = 0;
            $TotalLeaves = 0;
            foreach ($dateArray as $key => $value) {
                if (date("l", strtotime($key)) == 'Sunday' || in_array(date("Y-m-d", strtotime($key)), $OfficalHolidays)) {
                    $Check .= '-';
                } else {
                    $leave = '';
                    if (isset($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN']) && $EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN'] != '') {
                        $PunchTime = date("H:i:s", strtotime($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['TimeIN']));
//                                                    $RuleTime = date("H:i:s", strtotime('9:15:0'));
                        if (isset($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['LateStart'])) {
                            $RuleTime = date("H:i:s", strtotime($EmployeeAttendance[$record['id']][date("Y-m-d", strtotime($key))]['LateStart']));
                            $LateTime = TimeDiff($PunchTime, $RuleTime);
                        } else {
                            $LateTime = 1;
                        }
                        $LeaveCheck = '';
                        if (isset($EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) {
                            $LeaveCheck = '- ' . ucwords(str_replace('_', ' ', $EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) . '';
                            $TotalLeaves = $TotalLeaves + 1;
                        }
                        $Check .= 'P ' . (($LateTime > 0) ? "- " . gmdate("H:i:s", $LateTime) : $LeaveCheck) . '';

                        if ($LateTime > 0 && $LateTime < 2700) {
                            $TotalLate = $TotalLate + 1;
                        } elseif ($LateTime > 2701 && $LateTime < 9000) {
                            $ShortLeave = $ShortLeave + 1;
                        } else if ($LateTime > 9001) {
                            $HalfDay = $HalfDay + 1;
                        } else {
                            $OnTime = $OnTime + 1;
                        }
                        $TotalPresents = $TotalPresents + 1;
                        $Check .= '-';

                    } else {
                        if (isset($EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) {
                            $Check .= ' ' . ucwords(str_replace('_', ' ', $EmployeeLeaveCategory[$record['id']][date("Y-m-d", strtotime($key))])) . '';
                            $TotalLeaves = $TotalLeaves + 1;
                            $Check .= '-';
                        } else {
                            $future = DateDiff(date("Y-m-d"), $key);
                            if ($future > 0) {
                                $Check .= '-';
                            } else {
                                $Check .= 'A';
                                $TotalAbsents = $TotalAbsents + 1;
                            }
                            $Check .= '-';
                        }
                    }
                }
            }

            $exceldata[] = array(
                'Sr' => $cnt . " ",
                'Employee Name' => $record['emp_firstname'] . " " . $record['emp_lastname'],
                'Presents' => $TotalPresents,
                'Ontime' => $OnTime,
                'Over Time' => '-',
                'Late' => $TotalLate,
                'Short Leave' => $ShortLeave,
                'Half Day' => $HalfDay,
                'Absents' => $TotalAbsents,
                'Leaves' => $TotalLeaves,
            );
            $cnt++;
        }
        $Records['records'] = $exceldata;

        $this->GenerateExcel($Records);
        exit;
    }

    public function displayDate($date1, $date2, $format = 'd M,Y')
    {
        $dates = array();
        $current = strtotime($date1);
        $date2 = strtotime($date2);
        $stepVal = '+1 day';
        while ($current <= $date2) {
            $dates[date('Y-m-d', $current)] = date($format, $current);
            $current = strtotime($stepVal, $current);
        }
        return $dates;
    }


    public function elm_list()
    {
        $Records = array();
        $Records['heading'] = "ELM List";
        $Records['start_col'] = "A";
        $Records['end_col'] = "R";
        $Records['records_heads'] = array("Sr.", "EA Code", "EA Name", "Group Code", "Group Desc", "Pilgrim ID",
            "Name", "Birth Date", "Passport No", "MOI Number", "Visa No", "Entry Date", "Entry Time", "Entry Port",
            "Transport Mode", "Entry Carrier", "Flight No", "Package");

        ////////////// BODY ///////////

        $PilgrimData = new Pilgrims();
        $ELMRecords = $PilgrimData->ELMlistData();

        $listMofa = new MofaProcess();
        $MOFARecords = $listMofa->MOFAlist();

        $exceldata = array();
        $cnt = 1;
        foreach ($ELMRecords as $ELMRecord) {
            $exceldata[] = array(
                'Sr' => $cnt . " ",
                'EACode' => $ELMRecord['EACode'],
                'EAName' => $ELMRecord['EAName'],
                'GroupCode' => $ELMRecord['GroupCode'],
                'GroupDesc' => $ELMRecord['GroupDesc'],
                'PilgrimID' => $ELMRecord['PilgrimID'],
                'Name' => $ELMRecord['Name'],
                'BirthDate' => date("d M, Y ", strtotime($ELMRecord['BirthDate'])),
                'PassportNo' => $ELMRecord['PassportNo'],
                'MOINumber' => $ELMRecord['MOINumber'],
                'VisaNo' => $ELMRecord['VisaNo'],
                'EntryDate' => date("d M, Y ", strtotime($ELMRecord['EntryDate'])),
                'EntryTime' => $ELMRecord['EntryTime'],
                'EntryPort' => $ELMRecord['EntryPort'],
                'TransportMode' => $ELMRecord['TransportMode'],
                'EntryCarrier' => $ELMRecord['EntryCarrier'],
                'FlightNo' => $ELMRecord['FlightNo'],
                'Package' => $ELMRecord['Package'],
            );
            $cnt++;
        }
        $Records['records'] = $exceldata;

        $this->GenerateExcel($Records);
        exit;
    }

    public function b2b_pacakge()
    {
        echo "<pre>";

        $data = array();
        $code = explode("-", getSegment(3));
        $data['record_id'] = $code[0];

        $Packages = new Packages();
        $Crud = new Crud();
        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
        $data['hotels'] = $Packages->ListHotels();
        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
        // echo "<pre>"; print_r($data['hotelsRate']);
        if ($data['hotelsRate']) {
            $aData = array();
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsRecords'] = $aData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        // echo "<pre>"; print_r($data['TransportData']); exit;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $Data = array();
        foreach ($data['TransportDBData'] as $TD) {
            $Data[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
        }
        $data['TransportDBData'] = $Data;
        //echo "<pre>"; print_r($data); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']);
        if ($data['ziyaratRate']) {
            $aData = array();
            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
            }
        }
        $data['ZiyaratRecords'] = $aData;
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        if ($data['ServiceRate']) {
            $aServiceData = array();
            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($data['ServiceData']); exit;

        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        // print_r($data['RoomTypes']);
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        print_r($data['HotelsRecords']);

        $PackageHeading = $data['packageData'][0]['Name'];


        exit;
    }

    public function GenerateExcel($EXCEL)
    {
        $objPHPExcel = LoadExcel();
        $objPHPExcelIO = LoadExcelIO();
        $objPHPExcel_Style_Fill = ExcelStyleFill();

        $objPHPExcel->getActiveSheet()->setTitle(trim($EXCEL['heading']));
        $activeSheet = $objPHPExcel->setActiveSheetIndex(0);

        $row = 1;
        ////////////// HEADER ///////////
        $activeSheet->setCellValue($EXCEL['start_col'] . '1', $EXCEL['heading']);
        $activeSheet->mergeCells($EXCEL['start_col'] . '1:' . $EXCEL['end_col'] . '1');
        $activeSheet->getStyle($EXCEL['start_col'] . '1')->getFont()->setBold(true);
        $activeSheet->getStyle($EXCEL['start_col'] . '1')->getFont()->setSize(14);
        $activeSheet->getStyle($EXCEL['start_col'] . '1')->applyFromArray(
            array(
                'fill' => array(
                    'type' => $objPHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'BFBFBF')
                )
            )
        );
        $row++;

        $headKey = 0;
        for ($col = ord($EXCEL['start_col']); $col <= ord($EXCEL['end_col']); $col++) {
            $activeSheet->setCellValue(chr($col) . $row, $EXCEL["records_heads"][$headKey]);
            $headKey++;
        }

        for ($col = ord($EXCEL['start_col']); $col <= ord($EXCEL['end_col']); $col++) {
            $activeSheet->getStyle(chr($col) . $row)->getFont()->setBold(true);
            $activeSheet->getStyle(chr($col) . $row)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => $objPHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'D9D9D9')
                    )
                )
            );

            $activeSheet->getColumnDimension(chr($col))->setAutoSize(true);
            $activeSheet->getStyle(chr($col))->getFont()->setSize(12);
        }
        $row++;
        $activeSheet->freezePane($EXCEL['start_col'] . $row);
        $activeSheet->fromArray($EXCEL['records'], null, $EXCEL['start_col'] . $row);


        ///////////////////// FILE PROCESS ////////////////////////////////
        foreach ($objPHPExcel->getActiveSheet()->getColumnDimension() as $col) {
            $col->setAutoSize(true);
        }
        $objPHPExcel->getActiveSheet()->calculateColumnWidths();
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $EXCEL['heading'] . '.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $objWriter = $objPHPExcelIO::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }


}
