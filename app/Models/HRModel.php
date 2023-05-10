<?php

namespace App\Models;

use CodeIgniter\Model;

class HRModel extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $session = session();
        $session = $session->get();
        $this->data['session'] = $session;
    }

    public function OfficalHolidays()
    {
        $officalHolidays = array();
        $officalHolidays[] = '2022-11-26';

        return $officalHolidays;
    }

    public
    function GetActiveEmployeeData()
    {
        $MainArray = array();
        $Crud = new Crud();
        $SQL = ' SELECT public."hr_employee".*
                    FROM public."hr_employee"
                    WHERE public."hr_employee"."emp_active" = 1 
                  ORDER BY public."hr_employee"."emp_firstname" ASC ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        foreach ($FinalArray as $FA) {
            $MainArray[$FA['emp_pin']] = $FA;
        }

        return $MainArray;
    }

    public
    function CheckAttPunchesEmployeeAttendanceByDateTime($EmployeeUID, $DateTime)
    {
        $Crud = new Crud();
        $SQL = ' SELECT hr."att_punches".*
                    FROM hr."att_punches"
                    WHERE hr."att_punches"."PunchTime" = \'' . trim(date("Y-m-d H:i:s", strtotime($DateTime))) . '\'
                    AND hr."att_punches"."EmployeeID" = ' . $EmployeeUID . ' ';
        $FinalArray = $Crud->ExecuteSQL($SQL);

        return $FinalArray[0];
    }

    public
    function UploadEmployeesAttendance($AttendanceData = array())
    {

        $Crud = new Crud();
        $table = 'hr."att_punches"';
        $Crud->AddRecord($table, $AttendanceData);
    }

    public
    function AllEmployees()
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
        if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
            $ArrayKey = array();
            $DepartmentsVariable = $SessionFilters['Departments'];
            foreach ($DepartmentsVariable as $key => $value) {
                $ArrayKey[] = $key;
            }
            $Departments = implode(',', $ArrayKey);
        } else {
            $Departments = '';
        }


        $FinalArray = array();
        $Crud = new Crud();
//        $table = 'public."hr_employee"';
        $SQL = 'SELECT public."hr_employee".*,public."hr_department"."dept_name" FROM public."hr_employee"
                LEFT JOIN public."hr_department" ON "hr_employee"."department_id"  = "hr_department"."id" ';
        if (isset($Departments) && $Departments != '') {
            $SQL .= '  WHERE  public."hr_employee"."department_id" IN  ( ' . $Departments . '  ) ';
        }

        $SQL .= 'ORDER BY "hr_employee"."emp_firstname"';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public
    function AllEmployeesSummary()
    {
        $session = session();
        $SessionFilters = $session->get('EmployeeSummarySessionFilter');
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
        if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
            $ArrayKey = array();
            $DepartmentsVariable = $SessionFilters['Departments'];
            foreach ($DepartmentsVariable as $key => $value) {
                $ArrayKey[] = $key;
            }
            $Departments = implode(',', $ArrayKey);
        } else {
            $Departments = '';
        }


        $FinalArray = array();
        $Crud = new Crud();
//        $table = 'public."hr_employee"';
        $SQL = 'SELECT public."hr_employee".*,public."hr_department"."dept_name" FROM public."hr_employee"
                LEFT JOIN public."hr_department" ON "hr_employee"."department_id"  = "hr_department"."id" ';
        if (isset($Departments) && $Departments != '') {
            $SQL .= ' WHERE public."hr_employee"."department_id" IN  ( ' . $Departments . '  ) ';
        }

//        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '' && isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
//            $SQL .= ' AND public."hr_employee"."department_id" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['to'])) . '\' ';
//        }

        $SQL .= 'ORDER BY "hr_employee"."emp_firstname"';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function AllEmployeesRoasters()
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
        if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
            $ArrayKey = array();
            $DepartmentsVariable = $SessionFilters['Departments'];
            foreach ($DepartmentsVariable as $key => $value) {
                $ArrayKey[] = $key;
            }
            $Departments = implode(',', $ArrayKey);
        } else {
            $Departments = '';
        }


        $FinalArray = array();
        $Crud = new Crud();
//        $table = 'public."hr_employee"';
        $SQL = 'SELECT public."hr_employee".*,public."hr_department"."dept_name" FROM public."hr_employee"
                LEFT JOIN public."hr_department" ON "hr_employee"."department_id"  = "hr_department"."id" ';
        if (isset($Departments) && $Departments != '') {
            $SQL .= '  WHERE  public."hr_employee"."department_id" IN  ( ' . $Departments . '  ) ';
        }

        $SQL .= 'ORDER BY "hr_employee"."emp_firstname"';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function EmployeesList()
    {

        $FinalArray = array();
        $Crud = new Crud();
//        $table = 'public."hr_employee"';
        $SQL = 'SELECT public."hr_employee".*,public."hr_department"."dept_name" FROM public."hr_employee"
                LEFT JOIN public."hr_department" ON "hr_employee"."department_id"  = "hr_department"."id" 
                ORDER BY "hr_employee"."emp_firstname"';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function AllEmployeesRecords()
    {
        $FinalArray = array();
        $Crud = new Crud();
        $SQL = 'SELECT public."hr_employee".*,public."hr_department"."dept_name" FROM public."hr_employee"
                LEFT JOIN public."hr_department" ON "hr_employee"."department_id"  = "hr_department"."id" 
                ORDER BY "hr_employee"."emp_firstname"';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public
    function GetAllAttendancePunchingData($OrderBy = 'ASC', $limit = 0)
    {

        $Crud = new Crud();
        $SQL = ' SELECT public."att_punches".*
                        FROM public."att_punches"
                ORDER BY public."att_punches"."punch_time"  ' . $OrderBy . ' ';
        if ($limit > 0) {
            $SQL .= ' LIMIT ' . $limit . ' ';
        }
        $AttendancePunchingData = $Crud->ExecuteSQL($SQL);

        return $AttendancePunchingData;
    }

    public
    function GetAllEmployeesCheckInCheckOut()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['HrDashboardSessionFilter'];

        $Crud = new Crud();

//        $SQL_OLD = 'SELECT "hr_employee"."id" AS "EmployeeID", CONCAT("hr_employee"."emp_firstname",\' \', "hr_employee"."emp_lastname") AS "Employee",
//                MIN( "att_punches"."punch_time" ) AS "CheckInDate", MAX( "att_punches"."punch_time" ) AS "CheckOutDate"
//                FROM "public"."att_punches"
//                JOIN public."hr_employee" ON ( public."hr_employee"."id" = public."att_punches"."employee_id" )
//                WHERE 1=1';
//        if (isset($SessionFilters['SelectedDate']) && $SessionFilters['SelectedDate'] != '') {
//            $SQL_OLD .= ' AND "att_punches"."punch_time" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['SelectedDate'])) . ' 00:00:01\' AND \'' . date("Y-m-d", strtotime($SessionFilters['SelectedDate'])) . ' 23:59:59\' ';
//        } else {
//            $SQL_OLD .= ' AND "att_punches"."punch_time" BETWEEN \'' . date("Y-m-d") . ' 00:00:01\' AND \'' . date("Y-m-d") . ' 23:59:59\' ';
//        }
//        $SQL_OLD .= 'GROUP BY "hr_employee"."id", "hr_employee"."emp_firstname"
//                ORDER BY "CheckInDate" DESC';

        $SQL = ' SELECT * FROM (
                
                SELECT DISTINCT "hr_employee"."id" AS "EmployeeID",  CONCAT("hr_employee"."emp_firstname",\' \', "hr_employee"."emp_lastname") AS "Employee",
               ( SELECT MIN( "att_punches"."punch_time" ) FROM  public."att_punches" WHERE "att_punches"."workstate" = 0 ';

        if (isset($SessionFilters['SelectedDate']) && $SessionFilters['SelectedDate'] != '') {
            $SQL .= '  AND "att_punches"."employee_id" = "hr_employee"."id" AND "att_punches"."punch_time" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['SelectedDate'])) . ' 00:00:01\' AND \'' . date("Y-m-d", strtotime($SessionFilters['SelectedDate'])) . ' 23:59:59\'  ) AS  "CheckInDate",
              ( SELECT MAX( "att_punches"."punch_time" ) FROM  public."att_punches" WHERE "att_punches"."workstate" = 1 
                AND "att_punches"."employee_id" = "hr_employee"."id" AND "att_punches"."punch_time" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['SelectedDate'])) . ' 00:00:01\' AND \'' . date("Y-m-d", strtotime($SessionFilters['SelectedDate'])) . ' 23:59:59\'  ) AS  "CheckOutDate" 
                
                
                ';
        } else {
            $SQL .= '  AND "att_punches"."employee_id" = "hr_employee"."id" AND "att_punches"."punch_time" BETWEEN \'' . date("Y-m-d") . ' 00:00:01\' AND \'' . date("Y-m-d") . ' 23:59:59\'  ) AS  "CheckInDate",
              ( SELECT MAX( "att_punches"."punch_time" ) FROM  public."att_punches" WHERE "att_punches"."workstate" = 1 
                AND "att_punches"."employee_id" = "hr_employee"."id" AND "att_punches"."punch_time" BETWEEN \'' . date("Y-m-d") . ' 00:00:01\' AND \'' . date("Y-m-d") . ' 23:59:59\' ) AS  "CheckOutDate" 
                
                 ';
        }
        $SQL .= '  FROM "public"."att_punches"
                JOIN public."hr_employee" ON ( public."hr_employee"."id" = public."att_punches"."employee_id" )
                WHERE "att_punches"."terminal_id" = ' . FingerPrintID() . '  
                ORDER BY "CheckInDate" DESC 
                ) AS "MAinQuery"
                WHERE "MAinQuery"."CheckInDate" IS NOT NULL OR "MAinQuery"."CheckOutDate" IS NOT NULL ';

        $TodayAttendanceRecord = $Crud->ExecuteSQL($SQL);

        return $TodayAttendanceRecord;
    }


    public
    function MonthlyTopFiveEmployees()
    {

        $Crud = new Crud();
        $FinalArray = array();

        $SQL = 'SELECT "Date", STRING_AGG(CONCAT( "Employee", \' ( \', TO_CHAR("CheckInDate"::TIME , \'HH12:MI PM\') , \' ) \' ), \',\') AS "EmployeeDetail"
                FROM(
                
                       SELECT  TO_CHAR( "att_punches"."punch_time" :: DATE, \'yyyy-mm-dd\') AS "Date",
                              CONCAT("hr_employee"."emp_firstname", \' \', "hr_employee"."emp_lastname") AS "Employee",
                             MIN( "att_punches"."punch_time" ) AS "CheckInDate",
                           rank() OVER (PARTITION BY date_trunc(\'day\', MIN( "att_punches"."punch_time" )) ORDER BY MIN( "att_punches"."punch_time" ) ASC ) AS "ArrivalNo"
                       FROM "public"."att_punches"
                       JOIN public."hr_employee" ON ( public."hr_employee"."id" = public."att_punches"."employee_id" )
                       WHERE date_trunc(\'day\', "att_punches"."punch_time") BETWEEN \'' . date("Y-m-d", strtotime("-15 days")) . '\' AND \'' . date("Y-m-d") . '\'
                      GROUP BY TO_CHAR( "att_punches"."punch_time" :: DATE, \'yyyy-mm-dd\'),
                      "hr_employee"."emp_firstname", "hr_employee"."emp_lastname"
                ) AS "MainQuery" WHERE "ArrivalNo" <= 5 
                GROUP BY "Date" ORDER BY "Date" ASC';

        $MonthlyTopFiveEmployeesData = $Crud->ExecuteSQL($SQL);
        foreach ($MonthlyTopFiveEmployeesData as $MTPED) {
            $FinalArray[$MTPED['Date']] = explode(",", $MTPED['EmployeeDetail']);
        }

        return $FinalArray;
    }


    public function CheckAction($ID, $TerminalName)
    {
        $finalArray = array();
        $Crud = new Crud();
        $SQL = 'SELECT COUNT("att_punches"."id") AS "FinalData" FROM "public"."att_punches" WHERE "att_punches"."employee_id" =  ' . $ID . ' 
                AND "att_punches"."terminal_id" = (SELECT "public"."att_terminal"."id" FROM "public"."att_terminal"  WHERE "att_terminal"."terminal_type" = \'' . $TerminalName . '\')';
        $finalArray = $Crud->ExecuteSQL($SQL);
        return $finalArray;

    }

    public function EmployeeAttendanceCurrentMonth($id)
    {
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
        }


        $finalArray = array();
        $Crud = new Crud();
        /*$SQL = 'SELECT  "public"."hr_employee"."id", "public"."hr_employee"."emp_firstname",
                "public"."hr_employee"."emp_lastname",
                 To_Char("att_punches"."punch_time"::DATE,\'DD MON, YYYY\'),
                    MIN( "att_punches"."punch_time" ) AS "CheckInDate",
                    MAX( "att_punches"."punch_time" ) AS "CheckOutDate"
                      FROM "public"."att_punches"
                    JOIN "public"."hr_employee" ON ( "public"."hr_employee"."id" = "public"."att_punches"."employee_id" )
                  WHERE 1=1
                AND  "att_punches"."punch_time" BETWEEN \'' . date("Y-m-1") . '  00:00:01\' AND \'' . date("Y-m-d") . '  23:59:59\'
                      AND "att_punches"."employee_id" = ' . $id . '
                GROUP BY To_Char("att_punches"."punch_time"::DATE, \'DD MON, YYYY\') ,"public"."hr_employee"."emp_firstname","public"."hr_employee"."emp_lastname",
                "public"."hr_employee"."id"
                ORDER BY "CheckInDate" DESC';*/
        $SQL = 'Select
MQ."employee_id",
MQ."EmployeeName",
To_Char(MQ."PunchDate",\'DD MON, YYYY\') AS "PunchDate",
MQ."Actualtimetable_start",
MQ."timetable_start",
MQ."timetable_end",
MQ."timetable_checkout_end",
(select to_char(MIN("AP"."punch_time")::TIME, \'HH12:MI AM\')
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
) AS "FingerPrintCheckIn",
(select to_char(MAX("AP"."punch_time")::TIME, \'HH12:MI AM\')
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=1
) AS "FingerPrintCheckOut",
(select to_char(MIN("AP"."punch_time")::TIME, \'HH12:MI AM\')
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Access Door\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
) AS "AccessDoorCheckIn",
(select to_char(MAX("AP"."punch_time")::TIME, \'HH12:MI AM\')
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Access Door\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
) AS "AccessDoorCheckOut",
(select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
) AS "FingerPrintCheckIn",
(select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
) AS "FingerPrintCheckInDateTime",
(SELECT (DATE_PART(\'hour\', (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time - MQ."timetable_start"::time) * 60 +
               DATE_PART(\'minute\', (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time - MQ."timetable_start"::time)) * 60 +
               DATE_PART(\'second\', (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time - MQ."timetable_start"::time)) AS "LateTimeSeconds",
TO_CHAR(((SELECT (DATE_PART(\'hour\', (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time - MQ."timetable_start"::time) * 60 +
               DATE_PART(\'minute\', (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time - MQ."timetable_start"::time)) * 60 +
               DATE_PART(\'second\', (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time - MQ."timetable_start"::time)) || \' second\')::interval, \'HH24:MI:SS\') AS "LateTime",
(
SELECT (DATE_PART(\'hour\', MQ."timetable_end"::time - MQ."Actualtimetable_start"::time) * 60 +
               DATE_PART(\'minute\', MQ."timetable_end"::time - MQ."Actualtimetable_start"::time)) * 60 +
               DATE_PART(\'second\', MQ."timetable_end"::time - MQ."Actualtimetable_start"::time)


) AS "WorkingTime",
(
SELECT (DATE_PART(\'hour\', MQ."timetable_end"::time - (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time) * 60 +
               DATE_PART(\'minute\', MQ."timetable_end"::time - (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time)) * 60 +
               DATE_PART(\'second\', MQ."timetable_end"::time - (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time)
) AS "WorkedTime",
(Select (SELECT (DATE_PART(\'hour\', MQ."timetable_end"::time - MQ."Actualtimetable_start"::time) * 60 +
               DATE_PART(\'minute\', MQ."timetable_end"::time - MQ."Actualtimetable_start"::time)) * 60 +
               DATE_PART(\'second\', MQ."timetable_end"::time - MQ."Actualtimetable_start"::time))
-(
SELECT (DATE_PART(\'hour\', MQ."timetable_end"::time - (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time) * 60 +
               DATE_PART(\'minute\', MQ."timetable_end"::time - (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time)) * 60 +
               DATE_PART(\'second\', MQ."timetable_end"::time - (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id"=MQ."employee_id" 
AND "AP"."punch_time"::date=MQ."PunchDate"::date
AND "AP"."workstate"=0
)::time)
)
) AS "WorkedTimeDiff",
(CASE when (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id" = MQ."employee_id" 
AND "AP"."punch_time"::date = MQ."PunchDate"::date
AND "AP"."workstate"=0
) IS NULL then (select count(hr."leaves"."UID") 
from hr."leaves"
where daterange(hr."leaves"."From"::Date, hr."leaves"."To"::Date, \'[]\') && daterange(MQ."PunchDate"::Date, MQ."PunchDate"::Date, \'[]\')
AND hr."leaves"."EmployeeID"=MQ."employee_id") else 0 end) AS "OnLeave",
(CASE when (select MIN("AP"."punch_time")::TIME
 FROM  public."att_punches" AS "AP"
 LEFT JOIN public."att_terminal" ON (public."att_terminal"."id"="AP"."terminal_id" AND public."att_terminal"."terminal_name"=\'Finger Print\')
where "AP"."employee_id" = MQ."employee_id" 
AND "AP"."punch_time"::date = MQ."PunchDate"::date
AND "AP"."workstate"=0
) IS NULL then (select count(hr."roaster"."UID") 
from hr."roaster"
where hr."roaster"."RoasterDate"::Date=MQ."PunchDate"::Date
AND hr."roaster"."EmployeeID"=MQ."employee_id") else 0 end) AS "Roaster"
FROM
(
select t."id" AS "employee_id",
v::date AS "PunchDate",
t."EmployeeName",
t."Actualtimetable_start",
t."timetable_start",
t."timetable_end",

t."timetable_checkout_end"
FROM 
  (select public."hr_employee"."id",
CONCAT(public."hr_employee"."emp_firstname", \' \', public."hr_employee"."emp_lastname") as "EmployeeName",

public."att_timetable"."timetable_start"::time AS "Actualtimetable_start",
public."att_timetable"."timetable_start"::time+ INTERVAL \'15 min\' AS "timetable_start",
public."att_timetable"."timetable_end",

public."att_timetable"."timetable_checkout_end"::time,
v 
From public."hr_employee"';
        if (isset($DateINBetween) && $DateINBetween != '') {
            //$SQL .= ' WHERE public."att_punches"."punch_time" BETWEEN \'' . $StartDateFilter . '  00:00:01\' AND \'' . $EndDateFilter . '  23:59:59\' ';
            $SQL .= 'cross join generate_series(\'' . $StartDateFilter . '\', \'' . $EndDateFilter . '\', interval \'1 day\') v';
        } else {
           // $SQL .= ' WHERE public."att_punches"."punch_time" BETWEEN \'' . $StartDate . '  00:00:01\' AND \'' . $EndDate . '  23:59:59\' ';
            $SQL .= 'cross join generate_series(\'' . $StartDate . '\', \'' . $EndDate . '\', interval \'1 day\') v';
        }

$SQL .= ' INNER JOIN public."hr_department" ON public."hr_department"."id"=public."hr_employee"."department_id"
INNER JOIN public."att_department_shift" ON public."att_department_shift"."department_id" = public."hr_department"."id" 
INNER JOIN public."att_employee_shift" ON public."att_employee_shift"."shift_id"=public."att_department_shift"."shift_id"
INNER JOIN public."att_shift_details" ON  public."att_shift_details"."shift_id" = public."att_employee_shift"."shift_id" 
INNER JOIN public."att_timetable" ON public."att_timetable"."id"=public."att_shift_details"."timetable_id"
) t
LEFT join public."att_punches" on public."att_punches"."punch_time"::date= date(t.v)
 
where t."id"=' . $id . '
Group By
t."id",
"PunchDate",
"EmployeeName",
t."Actualtimetable_start",
t."timetable_start",
t."timetable_end",

t."timetable_checkout_end"
order by "PunchDate" ASC
) AS MQ';
        $finalArray = $Crud->ExecuteSQL($SQL);
        return $finalArray;
    }

    public function EmployeeDataByID($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT * FROM "public"."hr_employee" WHERE "hr_employee"."id" =  ' . $ID . '   ';
        $finalArray = $Crud->ExecuteSQL($SQL);
        return $finalArray[0];

    }

    public function AllDepartments()
    {
        $Crud = new Crud();
//        $table = 'public."hr_employee"';
        $SQL = 'SELECT  "hr_department"."id","hr_department"."dept_name","hr_department"."description","hr_department"."company_id" 
                FROM public."hr_department"';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function SaveApplicantData($records, $UpdateID)
    {
        $Crud = new Crud();
        $table = 'hr."leaves"';
        $results = array();
        if ($UpdateID == 0) {
            $InsertID = $Crud->AddRecord($table, $records);
            $results['status'] = 'success';
            $results['message'] = 'Application Added Successfully';
        } else {
            $where = array('UID' => $UpdateID);
            $Crud->UpdateRecord($table, $records, $where);
            $results['status'] = 'success';
            $results['message'] = 'Application Updated Successfully';
        }

        echo json_encode($results);


    }

    public function GetAllLeaves()
    {
        $session = session();
        $SessionFilters = $session->get('LeaveApplicationSessionFilter');

        if (isset($SessionFilters['applicant_name']) && $SessionFilters['applicant_name'] != '') {
            $ApplicantName = $SessionFilters['applicant_name'];
        } else {
            $ApplicantName = '';
        }
        if (isset($SessionFilters['leave_category']) && $SessionFilters['leave_category'] != '') {
            $LeaveCategoryInSession = $SessionFilters['leave_category'];
        } else {
            $LeaveCategoryInSession = '';
        }
        if (isset($SessionFilters['FromTo']) && $SessionFilters['FromTo'] != '') {
            $DateINBetween = $SessionFilters['FromTo'];

            $DATEArray = explode('to', $DateINBetween);
            $StartDate = $DATEArray[0];
            $EndDate = $DATEArray[1];

        } else {
            $DateINBetween = '';
        }
        if (isset($SessionFilters['Department_id']) && $SessionFilters['Department_id'] != '') {
            $Department_id = $SessionFilters['Department_id'];
        } else {
            $Department_id = '';
        }


        $Crud = new Crud();
        $SQL = 'SELECT hr."leaves"."UID","leaves"."SystemDate","leaves"."Station","hr_employee"."department_id","hr_employee"."id" AS "EmployeeID",
                CONCAT("hr_employee"."emp_firstname",\' \', "hr_employee"."emp_lastname") AS "EmployeeName",
                "leaves"."LeaveCategory",
                "leaves"."From","leaves"."To","leaves"."Reason", "leaves"."Status",
                (SELECT CONCAT("hr_employee"."emp_firstname",\' \', "hr_employee"."emp_lastname") 
                FROM public."hr_employee" WHERE "hr_employee"."id" = "leaves"."BackupPerson" ) AS "BackupPersonName" ,
                ( SELECT "hr_employee"."emp_firstname" FROM public."hr_employee" WHERE "hr_employee"."id" = "leaves"."ApprovalAuthority"
                ) AS "ApprovalAuthorityName" ,
                (main."Users"."FullName") AS "SubmitBY"
                FROM hr."leaves" 
                LEFT JOIN public."hr_employee" ON  public."hr_employee"."id" = hr."leaves"."EmployeeID" 
                LEFT JOIN main."Users" ON main."Users"."UID" =  hr."leaves"."SubmittedBy"
                WHERE "leaves"."Archive" = 0 ';

        if (isset($Department_id) && $Department_id != '') {
            $SQL .= ' AND "hr_employee"."department_id" =   ' . $Department_id . '';
        }
        if (isset($ApplicantName) && $ApplicantName != '') {
            $SQL .= ' AND "hr_employee"."id" =   ' . $ApplicantName . '';
        }

        if (isset($LeaveCategoryInSession) && $LeaveCategoryInSession != '') {
            $SQL .= ' AND "leaves"."LeaveCategory" =  \'' . $LeaveCategoryInSession . '\'  ';
        }
        if (isset($DateINBetween) && $DateINBetween != '') {
            $SQL .= '  AND  hr."leaves"."From"::date IN(SELECT generate_series(date \'' . $StartDate . '\', \'' . $EndDate . '\', \'1 day\')::date)
              AND hr."leaves"."To"::date IN(SELECT generate_series(date \'' . $StartDate . ' \',\'' . $EndDate . '\', \'1 day\')::date)';
        }

        $SQL .= 'ORDER BY hr."leaves"."UID" DESC';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function GetTotalLeaveRecords($EmployeeID, $LeaveCategory)
    {
        $StartYearDate = date('Y-01-01');
        $EndYearDate = date('Y-12-31');
        $Crud = new Crud();
//        $SQL_OLD = 'SELECT COUNT(hr."leaves"."UID") FROM hr."leaves" WHERE "leaves"."LeaveCategory" = \'' . $LeaveCategory . '\'
//                AND hr."leaves"."EmployeeID" =  ' . $EmployeeID . ' AND "leaves"."Archive" = 0 ';

        $SQL = 'SELECT COUNT(hr."leaves"."UID") FROM hr."leaves" 
                WHERE "leaves"."LeaveCategory" = \'' . $LeaveCategory . '\'
                AND hr."leaves"."EmployeeID" = ' . $EmployeeID . '
                AND "leaves"."SystemDate"::date IN ( SELECT generate_series(date \'' . $StartYearDate . '\',\'' . $EndYearDate . '\', \'1 day\')::date)
                AND "leaves"."Archive" = 0 
                ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray[0]['count'];

    }

    public function LeaveCategoryByID($ID, $StartDate, $EndDate)
    {
        $Crud = new Crud();
        $SQL = 'SELECT  "leaves"."From","leaves"."To", "leaves"."LeaveCategory" FROM hr."leaves" 
                WHERE hr."leaves"."EmployeeID" = ' . $ID . ' ';

        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function EmployeesLastMonthAttendance()
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
        if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
            $ArrayKey = array();
            $DepartmentsVariable = $SessionFilters['Departments'];
            foreach ($DepartmentsVariable as $key => $value) {
                $ArrayKey[] = $key;
            }
            $Departments = implode(',', $ArrayKey);
        } else {
            $Departments = '';
        }


        $EndMonthDate = $Year . "-" . $Month . "-21";
        $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
        $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));
        $Crud = new Crud();
        $FinalArray = array();

//        $SQL_Old = 'SELECT DISTINCT "att_punches"."employee_id" AS "EmployeeID",
//                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')) AS "Date",
//                MIN("att_punches"."punch_time") as "TimeIN" ,
//                TO_CHAR(("att_timetable"."timetable_start"::time + INTERVAL \'15 min\'),\'HH24:MI\') AS "ShiftStart"
//                FROM public."att_punches"
//                LEFT JOIN public."hr_employee" ON public."hr_employee"."id" = "att_punches"."employee_id"
//                LEFT JOIN public."att_department_shift" ON public."att_department_shift"."department_id" = public."hr_employee"."department_id"
//                LEFT JOIN public."att_shift_details" ON ( public."att_shift_details"."shift_id" = public."att_department_shift"."shift_id" AND public."att_shift_details"."timetable_id" > 0 )
//                LEFT JOIN public."att_timetable" ON public."att_timetable"."id" = public."att_shift_details"."timetable_id"
//                WHERE TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')
//                BETWEEN \'' . $StartMonthDate . '\' AND \'' . $EndMonthDate . '\'
//                GROUP BY
//                "att_punches"."employee_id",
//                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')),
//                public."att_timetable"."timetable_start"
//                ORDER BY "att_punches"."employee_id",(TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\'))';

        $SQL = 'SELECT DISTINCT "att_punches"."employee_id" AS "EmployeeID",
                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')) AS "Date",
                MIN("att_punches"."punch_time") as "TimeIN" ,
                MAX("att_punches"."punch_time") as "TimeOUT" ,
                TO_CHAR(("att_timetable"."timetable_start"::time),\'HH24:MI\') AS "ShiftStart",
                TO_CHAR(("att_timetable"."timetable_start"::time + INTERVAL \'15 min\'),\'HH24:MI\') AS "LateStart",
                TO_CHAR(("att_timetable"."timetable_end"::time),\'HH24:MI\') AS "ShiftEnd"
                FROM public."att_punches" LEFT JOIN public."hr_employee" ON public."hr_employee"."id" = "att_punches"."employee_id"
                LEFT JOIN public."att_department_shift" ON public."att_department_shift"."department_id" = public."hr_employee"."department_id"
                LEFT JOIN public."att_shift_details" ON ( public."att_shift_details"."shift_id" = public."att_department_shift"."shift_id"
                AND public."att_shift_details"."timetable_id" > 0 ) LEFT JOIN public."att_timetable" ON public."att_timetable"."id" = public."att_shift_details"."timetable_id"
                WHERE ';
        if (isset($Departments) && $Departments != '') {
            $SQL .= ' public."hr_employee"."department_id" IN  ( ' . $Departments . '  ) AND ';
        }

        $SQL .= 'TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\') BETWEEN \'' . $StartMonthDate . '\' AND \'' . $EndMonthDate . '\'
                GROUP BY "att_punches"."employee_id",
                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')),
                public."att_timetable"."timetable_start",
                public."att_timetable"."timetable_end"
                ORDER BY "att_punches"."employee_id",
                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\'))';

        $AttendanceArray = $Crud->ExecuteSQL($SQL);
        foreach ($AttendanceArray as $value) {
//            $FinalArray[$value['EmployeeID']][$value['Date']] = $value['TimeIN'];
            $FinalArray[$value['EmployeeID']][$value['Date']] = array('TimeIN' => $value['TimeIN'], 'TimeOUT' => $value['TimeOUT'], 'ShiftStart' => $value['ShiftStart'], 'LateStart' => $value['LateStart'], 'ShiftEnd' => $value['ShiftEnd']);
        }

        return $FinalArray;
    }


    public function EmployeesSummaryReport()
    {

        $session = session();
        $SessionFilters = $session->get('EmployeeSummarySessionFilter');
        $From = $To = '';
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
        if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
            $ArrayKey = array();
            $DepartmentsVariable = $SessionFilters['Departments'];
            foreach ($DepartmentsVariable as $key => $value) {
                $ArrayKey[] = $key;
            }
            $Departments = implode(',', $ArrayKey);
        } else {
            $Departments = '';
        }

        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '') {
            $From = $SessionFilters['from'];
        }

        if (isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
            $To = $SessionFilters['to'];
        }

        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '' && isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
            $StartMonthDate = $From;
            $EndMonthDate = $To;
        } else {
            $Month = date("m");
            $Year = date("Y");
            $EndMonthDate = $Year . "-" . $Month . "-21";
            $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
            $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));

        }


//        $EndMonthDate = $Year . "-" . $Month . "-21";
//        $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
//        $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));


        $Crud = new Crud();
        $FinalArray = array();

//        $SQL_Old = 'SELECT DISTINCT "att_punches"."employee_id" AS "EmployeeID",
//                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')) AS "Date",
//                MIN("att_punches"."punch_time") as "TimeIN" ,
//                TO_CHAR(("att_timetable"."timetable_start"::time + INTERVAL \'15 min\'),\'HH24:MI\') AS "ShiftStart"
//                FROM public."att_punches"
//                LEFT JOIN public."hr_employee" ON public."hr_employee"."id" = "att_punches"."employee_id"
//                LEFT JOIN public."att_department_shift" ON public."att_department_shift"."department_id" = public."hr_employee"."department_id"
//                LEFT JOIN public."att_shift_details" ON ( public."att_shift_details"."shift_id" = public."att_department_shift"."shift_id" AND public."att_shift_details"."timetable_id" > 0 )
//                LEFT JOIN public."att_timetable" ON public."att_timetable"."id" = public."att_shift_details"."timetable_id"
//                WHERE TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')
//                BETWEEN \'' . $StartMonthDate . '\' AND \'' . $EndMonthDate . '\'
//                GROUP BY
//                "att_punches"."employee_id",
//                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')),
//                public."att_timetable"."timetable_start"
//                ORDER BY "att_punches"."employee_id",(TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\'))';

        $SQL = 'SELECT DISTINCT "att_punches"."employee_id" AS "EmployeeID",
                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')) AS "Date",
                MIN("att_punches"."punch_time") as "TimeIN" ,
                MAX("att_punches"."punch_time") as "TimeOUT" ,
                TO_CHAR(("att_timetable"."timetable_start"::time),\'HH24:MI\') AS "ShiftStart",
                TO_CHAR(("att_timetable"."timetable_start"::time + INTERVAL \'15 min\'),\'HH24:MI\') AS "LateStart",
                TO_CHAR(("att_timetable"."timetable_end"::time),\'HH24:MI\') AS "ShiftEnd"
                FROM public."att_punches" LEFT JOIN public."hr_employee" ON public."hr_employee"."id" = "att_punches"."employee_id"
                LEFT JOIN public."att_department_shift" ON public."att_department_shift"."department_id" = public."hr_employee"."department_id"
                LEFT JOIN public."att_shift_details" ON ( public."att_shift_details"."shift_id" = public."att_department_shift"."shift_id"
                AND public."att_shift_details"."timetable_id" > 0 ) LEFT JOIN public."att_timetable" ON public."att_timetable"."id" = public."att_shift_details"."timetable_id"
                WHERE ';
        if (isset($Departments) && $Departments != '') {
            $SQL .= ' public."hr_employee"."department_id" IN  ( ' . $Departments . '  ) AND ';
        }

        $SQL .= 'TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\') BETWEEN \'' . $StartMonthDate . '\' AND \'' . $EndMonthDate . '\'
                GROUP BY "att_punches"."employee_id",
                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\')),
                public."att_timetable"."timetable_start",
                public."att_timetable"."timetable_end"
                ORDER BY "att_punches"."employee_id",
                (TO_CHAR("att_punches"."punch_time",\'YYYY-MM-DD\'))';
//        echo $SQL;
//        exit;

        $AttendanceArray = $Crud->ExecuteSQL($SQL);
        foreach ($AttendanceArray as $value) {
//            $FinalArray[$value['EmployeeID']][$value['Date']] = $value['TimeIN'];
            $FinalArray[$value['EmployeeID']][$value['Date']] = array('TimeIN' => $value['TimeIN'], 'TimeOUT' => $value['TimeOUT'], 'ShiftStart' => $value['ShiftStart'], 'LateStart' => $value['LateStart'], 'ShiftEnd' => $value['ShiftEnd']);
        }

        return $FinalArray;
    }


    public function GetLeavesCategoryDataByDate()
    {
        $Crud = new Crud();
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

        $SQL = 'SELECT * 
        FROM hr."leaves"
        where hr."leaves"."From"::date IN(SELECT generate_series(date \'' . $StartMonthDate . '\',\'' . $EndMonthDate . '\', \'1 day\')::date)
        AND hr."leaves"."To"::date IN(SELECT generate_series(date \'' . $StartMonthDate . '\',\'' . $EndMonthDate . '\', \'1 day\')::date) AND hr."leaves"."Archive" = 0';
        $EmployeeLeaves = $Crud->ExecuteSQL($SQL);
        $FinalArray = array();

        foreach ($EmployeeLeaves as $value) {
            $From = date('Y-m-d', strtotime($value['From']));
            $To = date('Y-m-d', strtotime($value['To']));
            for ($i = $From; $i <= $To; $i = date('Y-m-d', strtotime($i . "+1 days"))) {
                $FinalArray[$value['EmployeeID']][$i] = $value['LeaveCategory'];
//                $FinalArray[$value['EmployeeID']][$i] =  array('LeaveCategory'=>$value['LeaveCategory']);
            }
        }
        return $FinalArray;
    }

    public function GetEmployeesLeavesCategoryDataByDate()
    {
        $Crud = new Crud();
        $session = session();
        $SessionFilters = $session->get('EmployeeSummarySessionFilter');
        $From = $To = '';
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


        $SQL = 'SELECT * 
        FROM hr."leaves"
        where hr."leaves"."From"::date IN(SELECT generate_series(date \'' . $StartMonthDate . '\',\'' . $EndMonthDate . '\', \'1 day\')::date)
        AND hr."leaves"."To"::date IN(SELECT generate_series(date \'' . $StartMonthDate . '\',\'' . $EndMonthDate . '\', \'1 day\')::date) AND hr."leaves"."Archive" = 0';
        $EmployeeLeaves = $Crud->ExecuteSQL($SQL);
        $FinalArray = array();

        foreach ($EmployeeLeaves as $value) {
            $From = date('Y-m-d', strtotime($value['From']));
            $To = date('Y-m-d', strtotime($value['To']));
            for ($i = $From; $i <= $To; $i = date('Y-m-d', strtotime($i . "+1 days"))) {
                $FinalArray[$value['EmployeeID']][$i] = $value['LeaveCategory'];
//                $FinalArray[$value['EmployeeID']][$i] =  array('LeaveCategory'=>$value['LeaveCategory']);
            }
        }
        return $FinalArray;
    }

    public
    function delete_application_data($record, $UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'hr."leaves"';
        $where = array('UID' => $UID);

        $record_id = $Crud->UpdateRecord($table, $record, $where);

        $response = array();
        $response['record_id'] = $record_id;
        $response['status'] = 'success';
        echo json_encode($response);

    }

    public function GetApplicationRecords($UID)
    {
        $Crud = new Crud();
        $table = 'hr."leaves"';
        $where = array('UID' => $UID);
        $FinalArray = $Crud->SingleRecord($table, $where);

        return $FinalArray;
    }

    public function GetEmployeeByDepartment($DepartmentID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT "hr_employee"."id",
                CONCAT("hr_employee"."emp_firstname" ,\' \',"hr_employee"."emp_lastname") AS "EmployeeName"
                FROM public."hr_employee" Where "hr_employee"."department_id" =  ' . $DepartmentID . ' ';
        $FinalArray = $Crud->ExecuteSQL($SQL);

        return $FinalArray;
    }

    public function SaveRoasterRecords($record)
    {
        $Crud = new Crud();
        $table = 'hr."roaster"';
        $returnId = $Crud->AddRecord($table, $record);
        return $returnId;
    }

    public function GetRoastersByDate()
    {
        $Crud = new Crud();
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
        if (isset($SessionFilters['Departments']) && $SessionFilters['Departments'] != '') {
            $ArrayKey = array();
            $DepartmentsVariable = $SessionFilters['Departments'];
            foreach ($DepartmentsVariable as $key => $value) {
                $ArrayKey[] = $key;
            }
            $Departments = implode(',', $ArrayKey);
        } else {
            $Departments = '';
        }

        $EndMonthDate = $Year . "-" . $Month . "-21";
        $StartMonthDate = date("Y-m-d", strtotime("-1 Month", strtotime($EndMonthDate)));
        $EndMonthDate = date("Y-m-d", strtotime("-1 day", strtotime($EndMonthDate)));

//        $SQL_old = 'SELECT "roaster"."EmployeeID",To_char("roaster"."RoasterDate",\'YYYY-MM-DD\') AS "RoasterDate"
//                FROM "hr"."roaster" WHERE "roaster"."RoasterDate" BETWEEN \'' . $StartMonthDate . '\' AND \'' . $EndMonthDate . '\'';

        $SQL = 'SELECT "roaster"."EmployeeID",To_char("roaster"."RoasterDate",\'YYYY-MM-DD\') AS "RoasterDate" , "hr_employee"."department_id" AS "DepartmentID"
                FROM "hr"."roaster" 
                LEFT JOIN public."hr_employee" ON public."hr_employee"."id" = "roaster"."EmployeeID"  WHERE';

        if (isset($Departments) && $Departments != '') {
            $SQL .= ' "hr_employee"."department_id" IN (' . $Departments . ') AND ';
        }
        $SQL .= '  "roaster"."RoasterDate"  BETWEEN \'' . $StartMonthDate . '\' AND \'' . $EndMonthDate . '\'';

        $RoastersDate = $Crud->ExecuteSQL($SQL);
        foreach ($RoastersDate as $value) {
//            $FinalArray[$value['EmployeeID']] = $value['RoasterDate'];
            $FinalArray[$value['EmployeeID']][$value['RoasterDate']] = 'OFF';

        }
//        $FinalArray = array_column($RoastersDate, 'RoasterDate','EmployeeID');
        return $FinalArray;


    }


}