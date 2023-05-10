<?php namespace App\Controllers;


use App\Models\Crud;
use App\Models\HRModel;
use App\Models\Main;

class LeaveManagement extends BaseController
{

    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();
    }

    public function index()
    {
        echo "index page";
        exit;
    }

    public function employees()
    {
        $data = $this->data;
        $EmployeesData = new HRModel();
        $data['EmployeesData'] = $EmployeesData->EmployeesList();

        echo view('header', $data);
        echo view('human_resource/employees', $data);
        echo view('footer', $data);
    }

    public function employee_attendance()
    {
        $data = $this->data;

        $segment = getSegment(3);
        $Array = explode('-', $segment);
        $id = $Array[0];

        $AttendanceData = new HRModel();
        $data['EmployeeAttendance'] = $AttendanceData->EmployeeAttendanceCurrentMonth($id);
        $data['EmployeeInfo'] = $AttendanceData->EmployeeDataByID($id);
        echo view('header', $data);
        echo view('human_resource/employee_attendance', $data);
        echo view('footer', $data);
    }


    public
    function get_employees_checkin_checkout_data()
    {

        $HrModel = new HRModel();
        $FinalArray = array();
        $session = session();
        $Date = date("d M, Y");
        $SessionFilters = $session->get('HrDashboardSessionFilter');
        if (isset($SessionFilters['SelectedDate']) && $SessionFilters['SelectedDate'] != '') {
            $Date = date("d M, Y", strtotime($SessionFilters['SelectedDate']));
        }
        $EmployeesTodayAttendance = $HrModel->GetAllEmployeesCheckInCheckOut();
        foreach ($EmployeesTodayAttendance as $ETAD) {

            $result = array();
            $result['EmployeeID'] = $ETAD['EmployeeID'];
            $result['Employee'] = ucwords($ETAD['Employee']);
            $result['CheckInDate'] = ((isset($ETAD['CheckInDate']) && $ETAD['CheckInDate'] != '') ? date("h:i A", strtotime($ETAD['CheckInDate'])) : ' - ');
            $result['CheckOutDate'] = ((isset($ETAD['CheckOutDate']) && $ETAD['CheckOutDate'] != '') ? date("h:i A", strtotime($ETAD['CheckOutDate'])) : ' - ');
            $timeFirst = '';
            $timeSecond = '';
            $timeFirst = strtotime($ETAD['CheckInDate']);
            $timeSecond = strtotime($ETAD['CheckOutDate']);
            $TIMEDIFFInSeconds = $timeSecond - $timeFirst;

            if ($ETAD['CheckInDate'] != '' && $ETAD['CheckOutDate'] != '') {
                $result['TIMEDIFF'] = ((isset($TIMEDIFFInSeconds) && $TIMEDIFFInSeconds != '') ? gmdate("H:i:s", $TIMEDIFFInSeconds) : ' - ');
            } else {
                $result['TIMEDIFF'] = ' - ';
            }

            $FinalArray['Record'][] = $result;
        }
        $FinalArray['Date'] = $Date;

        echo json_encode($FinalArray);
    }

    public function leaves()
    {
        $data = $this->data;
        $HrModel = new HRModel();
        $data['AllLeaves'] = $HrModel->GetAllLeaves();
        $data['DepartmentsData'] = $HrModel->AllDepartments();
        $data['employees'] = $HrModel->AllEmployeesRecords();
        echo view('header', $data);
        echo view('human_resource/leaves', $data);
        echo view('footer', $data);
    }

    public function SaveLeave_ApplicationForm()
    {

        $data = $this->data;
        $HrModel = new HRModel();
        $UID = 0;


        $station = $this->request->getVar('station');
        $name_of_applicant = $this->request->getVar('name_of_applicant');
        $leave_category = $this->request->getVar('leave_category');
        $date_from = $this->request->getVar('date_from');
        $date_to = $this->request->getVar('date_to');
        $reason = $this->request->getVar('reason');
        $backup_person = $this->request->getVar('backup_person');
        $hod_approval = $this->request->getVar('hod_approval');
        $leave_status = 'in_progress';
        $SubmittedBy = $this->request->getVar('name_of_applicant');

        $records = array();
        $records['Station'] = $station;
        $records['EmployeeID'] = $name_of_applicant;
        $records['LeaveCategory'] = $leave_category;
        $records['From'] = str_replace("T", ' ', $date_from);;
        $records['To'] = str_replace("T", ' ', $date_to);
        $records['Reason'] = $reason;
        $records['BackupPerson'] = $backup_person;
        $records['ApprovalAuthority'] = $hod_approval;
        $records['Status'] = $leave_status;
        $records['SubmittedBy'] = $SubmittedBy;


        $saveRecords = $HrModel->SaveApplicantData($records, $UID);
    }

    public function attendance_report()
    {
        $data = $this->data;
        $EmployeesData = new HRModel();
        $data['EmployeesData'] = $EmployeesData->AllEmployees();
        $data['DepartmentsData'] = $EmployeesData->AllDepartments();
        //$data['EmployeesAttendanceLastMonth'] = $EmployeesData->EmployeesLastMonthAttendance();
        echo view('header', $data);
        echo view('human_resource/attendance_report', $data);
        echo view('footer', $data);
    }

    public function HTMLLeaveData()
    {
        $data = $this->data;
        $HrModel = new HRModel();

        $LeaveType = $this->request->getVar('LeaveCategory');
        $EmployeeID = $this->request->getVar('EmployeeID');
        if ($EmployeeID != '') {
            $CountLeaves = $HrModel->GetTotalLeaveRecords($EmployeeID, $LeaveType);

            $LeaveCategory = str_replace('_', ' ', $LeaveType);

            $TotalLeaves = $data['LeaveCategory'][$LeaveType]['total'];
            $RemainingLeaves = $TotalLeaves - $CountLeaves;
//        echo '<div>
//                    <label for="" class="text-primary"> Total  </label></br>
//                    <strong class="text-success ">Acquire  </strong>
//                    <strong class="text-danger ml-3">Remaining   </strong>
//              </div>';

            echo '<span class="badge badge-primary ">Total ' . ucwords($LeaveCategory) . '  : ' . $TotalLeaves . '  </span>
                  <span class="badge badge-danger ">Used : ' . $CountLeaves . '</span>  
                  <span class="badge badge-success">Remaining : ' . $RemainingLeaves . '</span>
                  <input type="hidden" id="total_leave_category_balance" value="' . $RemainingLeaves . '">';
        } else {
            echo '<span class="badge badge-danger"><b>Please Select Name Of Applicant<b></span> ';
        }


    }

    public function manual_attendance_import_form_submit()
    {
        $HrModel = new HRModel();
        $EmployeesData = $HrModel->GetActiveEmployeeData();

        if (isset($_FILES["manual_attendance_uploaded_file"]["name"])) {

            $pathFile = $_FILES["manual_attendance_uploaded_file"]["tmp_name"];
            $objPHPExcel = LoadExcelIO();
            $object = $objPHPExcel::load($pathFile);

            $MainArray = array();
            foreach ($object->getWorksheetIterator() as $worksheet) {

                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for ($row = 2; $row <= $highestRow; $row++) {

                    $RegNo = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $Name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $DeptNo = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $DeptName = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $Date = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $DevNo = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $VerifyMode = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $ManuallyAdded = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $Temperature = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $TemperatureAlarm = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $Remarks = $worksheet->getCellByColumnAndRow(10, $row)->getValue();

                    $EmployeeID = ((isset($EmployeesData[$RegNo]['id']) && $EmployeesData[$RegNo]['id'] != '') ? $EmployeesData[$RegNo]['id'] : 0);
                    $Date = date("Y-m-d H:i:s", strtotime($Date));
                    $CheckAttendance = $HrModel->CheckAttPunchesEmployeeAttendanceByDateTime($EmployeeID, $Date);
                    if (!isset($CheckAttendance['UID'])) {
                        $AttendanceData = array(
                            'SystemDate' => date("Y-m-d H:i:s"),
                            'EmployeeID' => $EmployeeID,
                            'PunchTime' => trim($Date),
                            'TerminalID' => trim($DevNo)
                        );
                        $HrModel->UploadEmployeesAttendance($AttendanceData);
                    }
                }
            }

            $result = array();
            $result['status'] = 'success';
            $result['message'] = 'Employees Attendance Successfully Uploaded';

        } else {

            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'File Not Found, To Upload Attendance';
        }

        echo json_encode($result);
    }

    public function delete_leave_application_record()
    {

        $UID = $this->request->getVar('UID');
        $record['Archive'] = 1;
        $HrModel = new HRModel();
        $HrModel->delete_application_data($record, $UID);

    }

    public function get_employees_departments()
    {
        $data = $this->data;
        $HrModel = new HRModel();
        $DepartmentID = $this->request->getVar('departmentID');
        $DepartmentTeam = $HrModel->GetEmployeeByDepartment($DepartmentID);

        echo json_encode($DepartmentTeam);

    }

    public function roasters_report()
    {
        $data = $this->data;
        $EmployeesData = new HRModel();
        $data['EmployeesData'] = $EmployeesData->AllEmployeesRoasters();
        $data['DepartmentsData'] = $EmployeesData->AllDepartments();
        echo view('header', $data);
        echo view('human_resource/roasters_report', $data);
        echo view('footer', $data);
    }

    public function save_add_roaster_form()
    {
        $data = $this->data;
        $HrModel = new HRModel();

        $Date = $this->request->getVar('date');
        $Department = $this->request->getVar('department');
        $Employees = $this->request->getVar('employees');

        foreach ($Employees as $key => $value) {
            $record = array();
            $record['EmployeeID'] = $key;
            $record['RoasterDate'] = $Date;
            $counterId = $HrModel->SaveRoasterRecords($record);
        }
        $response['status'] = 'success';
        $response['message'] = 'Roaster Added Successfully...';
        echo json_encode($response);

//        echo "<pre>";
//        print_r($record);
//        exit;
    }

    public function delete_roaster_by_Id()
    {
        $Id = $this->request->getVar('ID');
        $Date = $this->request->getVar('Date');
        $RoasterDate = $Date . " 00:00:00";

        $Crud = new Crud();
        $table = 'hr."roaster"';
        $where = array('EmployeeID' => $Id, 'RoasterDate' => $RoasterDate);
        $DeleteRecord = $Crud->DeleteRecord($table, $where);

        $response = array();
        $response['status'] = 'success';
        echo json_encode($response);
    }

    public function employee_summary()
    {
        $data = $this->data;
        $EmployeesData = new HRModel();
        $data['EmployeesData'] = $EmployeesData->AllEmployeesSummary();
        $data['DepartmentsData'] = $EmployeesData->AllDepartments();
        echo view('header', $data);
        echo view('human_resource/employee_summary', $data);
        echo view('footer', $data);
    }

    public function add_leave_mobile()
    {
        $data = $this->data;
        $record = new HRModel();
        $data['employees'] = $record->AllEmployeesRecords();
        echo view('human_resource/add_leave_form', $data);
    }

}
