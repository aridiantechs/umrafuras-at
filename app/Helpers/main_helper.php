<?php
require_once APPPATH . "/ThirdParty/phpexcel/Classes/PHPExcel.php";
require_once APPPATH . "/ThirdParty/phpexcel/Classes/PHPExcel/IOFactory.php";

use App\Models\Crud;
use App\Models\Main;
use App\Models\BrnRecords;

if (!function_exists('LoadExcel')) {
    function LoadExcel()
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        return $objPHPExcel;
    }
}
if (!function_exists('LoadExcelIO')) {
    function LoadExcelIO()
    {
        return $objPHPExcel = new PHPExcel_IOFactory();
    }
}
if (!function_exists('ExcelStyleFill')) {
    function ExcelStyleFill()
    {
        return $objPHPExcel = new PHPExcel_Style_Fill();
    }
}

if (!function_exists('getSegment')) {

    function getSegment(int $number)
    {
        $request = \Config\Services::request();

        if ($request->uri->getTotalSegments() >= $number && $request->uri->getSegment($number)) {
            return $request->uri->getSegment($number);
        } else {
            return false;
        }
    }

}
if (!function_exists('OptionName')) {
    function OptionName($UID)
    {
        $Crud = new Crud();
        $table = 'main."LookupsOptions"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['Name'];
    }
}
if (!function_exists('AgentName')) {
    function AgentName($UID)
    {
        $Crud = new Crud();
        $table = 'main."Agents"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['FullName'];
    }
}
if (!function_exists('CityName')) {
    function CityName($UID, $field = 'Name')
    {
        $Crud = new Crud();
        $table = 'main."Cities"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options[$field];
    }
}
if (!function_exists('HotelName')) {
    function HotelName($UID, $field = 'Name', $self = 0)
    {
        $Crud = new Crud();
        if ($self == 0) $table = 'packages."Hotels"';
        if ($self == 1) $table = 'packages."OtherHotels"';
        $options = $Crud->SingleRecord($table, array("UID" => $UID));
        return $options[$field];
    }
}

if (!function_exists('dateRange')) {
    function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = [];
        $current = strtotime($first);
        $last = strtotime($last);

        while ($current <= $last) {

            $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }
}


if (!function_exists('ZiyaratName')) {
    function ZiyaratName($UID, $field = 'Name')
    {
        $Crud = new Crud();
        $table = 'packages."Ziyarats"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options[$field];
    }
}
if (!function_exists('TransportName')) {
    function TransportName($UID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT packages."Transport"."Type", 
                            main."LookupsOptions"."Name" 
                            FROM packages."Transport"
                            INNER JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Transport"."Type"
                            WHERE packages."Transport"."UID" = ' . $UID . '';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['Name'];

    }
}
if (!function_exists('CountryName')) {
    function CountryName($UID, $field = 'Name')
    {
        $Crud = new Crud();
        $table = 'main."Countries"';
        $options = $Crud->SingleRecord($table, $wheres = array("ISO2" => $UID));
        return $options[$field];
    }
}
if (!function_exists('LoadImage')) {
    function LoadImage($UID)
    {

        $Main = new Main();
        $data = $Main->DefaultVariable();
        $path = $data['path'];
        if ($UID > 0) {
            $img = ' <div class="image"><img src="' . $path . 'home/load_file/' . $UID . '" class="Image" style="width:80px;height:80px;"></div>';
        } else {
            $img = ' <div class="image"><img src="' . $path . 'home/load_file/0" class="Image" style="width:80px;height:80px;"></div>';
        }
        return $img;
    }
}
if (!function_exists('CountryCode')) {
    function CountryCode($Name, $field = 'ISO2')
    {
        $Crud = new Crud();
        $table = 'main."Countries"';
        $options = $Crud->SingleRecord($table, $wheres = array("Name" => $Name));
        return $options[$field];
    }
}
if (!function_exists('AirportName')) {
    function AirportName($UID)
    {
        $Crud = new Crud();
        $table = 'main."Airports"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['Name'];
    }
}
if (!function_exists('AirportCode')) {
    function AirportCode($UID)
    {
        $Crud = new Crud();
        $table = 'main."Airports"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['Code'];
    }
}

if (!function_exists('AirlineCode')) {
    function AirlineCode($UID)
    {
        $Crud = new Crud();
        $table = 'main."Airlines"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['Code'];
    }
}
if (!function_exists('AirlineName')) {
    function AirlineName($UID)
    {
        $Crud = new Crud();
        $table = 'main."Airlines"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['FullName'];
    }
}
if (!function_exists('DomainName')) {
    function DomainName($UID)
    {
        $Crud = new Crud();
        $table = 'websites."Domains"';
        $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
        return $options['FullName'];
    }
}

if (!function_exists('Countries')) {
    function Countries($datatype = 'records', $selected = '')
    {
        $Crud = new Crud();
        $table = 'main."Countries"';
        $options = $Crud->ListRecords($table, array(), array("Name" => 'ASC'));
        $final = array();
        $final['records'] = $options;
        $HTML = '';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['ISO2'] . '" ' . (($selected == $option['ISO2']) ? 'selected' : '') . '>' . $option['Name'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }
}

if (!function_exists('Cities')) {
    function Cities($CountryCode, $datatype = 'records', $selected = '')
    {
        $Crud = new Crud();
        $table = 'main."Cities"';
        $options = $Crud->ListRecords($table, array("CountryCode" => $CountryCode), array("Name" => 'ASC'));
        $final = array();
        $final['records'] = $options;
        $HTML = '';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['Name'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }
}

if (!function_exists('BarCode')) {
    function BarCode($code)
    {
        $Main = new Main();
        $data = $Main->DefaultVariable();
        $path = $data['path'];

        return $path . 'barcode.php?text=' . $code;
    }
}

if (!function_exists('Money')) {
    function Money($data)
    {
        if (trim($data) == 0) {
            $val = "-";
        } else {
            $val = number_format(trim($data), 2) . ' SAR';
        }
        return $val;
    }
}
if (!function_exists('NUMBER')) {
    function NUMBER($data)
    {
        if (trim($data) == 0) {
            $val = "-";
        } else {
            $val = number_format(trim($data), 0);
        }
        return $val;
    }
}

if (!function_exists('SeoUrl')) {
    function SeoUrl($url, $full = true)
    {
        $url = trim($url);
        $url = preg_replace('/[^a-zA-Z0-9_\/]/', '-', trim($url));
        $url = strtolower($url);
        $url = str_replace("--", "-", $url);
        $url = str_replace("--", "-", $url);
        $url = str_replace("--", "-", $url);
        if ($full) {
            return base_url($url);
        } else {
            return $url;
        }

    }
}

if (!function_exists('Code')) {
    function Code($prefix = '', $id)
    {
        if ($id > 0) {
            if ($prefix == 'UF') {
                $str = str_repeat("0", 7 - strlen($id)) . $id;
            } else {
                $str = $prefix . str_repeat("0", 7 - strlen($id)) . $id;
            }

            return $str;
        } else {
            return "-";
        }

    }
}


if (!function_exists('CurrConvert')) {
    function CurrConvert($from, $to, $value = 1)
    {
        $curl = curl_init();
        $url = "https://v6.exchangerate-api.com/v6/f621e7696f0461816e7ef54a/latest/" . $from;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        //print_r($response);
        $err = curl_error($curl);
        curl_close($curl);
        if ($response['result'] == 'success') {
            return $value * $response['conversion_rates'][$to];
        } else {
            echo "<pre>";
            /////////////////////////// Second Free API
            $req_url = 'https://api.exchangerate.host/convert?from=' . $from . '&to=' . $to;
            $response_json = file_get_contents($req_url);
            $response = json_decode($response_json, true);
            if ($response['success'] == 1) {
                return $value * $response['result'];
            } else {
                /////////////////////////// Third Free API
                return $value * 0;
            }
        }
    }
}

if (!function_exists('DATEFORMAT')) {
    function DATEFORMAT($date)
    {
        if ($date != NULL && $date != '') {
            $str = date("d M, Y ", strtotime($date));
        } else {
            $str = "-";
        }
        return $str;
    }
}
if (!function_exists('MultiDate')) {
    function MultiDate($date)
    {
        //echo $date;
        $dateArray = explode("to", $date);
        $start = date("Y-m-d", strtotime(trim($dateArray[0])));
        $end = date("Y-m-d", strtotime(trim($dateArray[1])));

        return array("start" => $start, "end" => $end);
    }
}
if (!function_exists('TIMEFORMAT')) {
    function TIMEFORMAT($time)
    {
        if ($time != NULL && $time != '') {
            $str = date("h:i A", strtotime($time));
        } else {
            $str = "-";
        }
        return $str;
    }
}

if (!function_exists('TimeDiff')) {
    function TimeDiff($Stime, $Etime)
    {
        $to_time = strtotime($Stime);
        $from_time = strtotime($Etime);
        //return round(abs($to_time - $from_time) / 60,2);
        return $to_time - $from_time;
    }
}
if (!function_exists('DateDiff')) {
    function DateDiff($Start, $End)
    {
        $date1=date_create(date("Y-m-d", strtotime($Start)));
        $date2=date_create(date("Y-m-d", strtotime($End)));
        $diff=date_diff($date1,$date2);
        return (int) $diff->format("%R%a");
    }
}

if (!function_exists('DATA')) {
    function DATA($str)
    {
        if ($str != NULL && $str != '') {
        } else {
            $str = "-";
        }
        return $str;
    }
}

if (!function_exists('AGE')) {
    function AGE($date)
    {
//        $birthDate = date("m/d/Y", strtotime($date));
//        $birthDate = explode("/", $birthDate);
//        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
//            ? ((date("Y") - $birthDate[2]) - 1)
//            : (date("Y") - $birthDate[2]));
//        return $age;
        $dateOfBirth = date("Y-m-d", strtotime($date));
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return (int)$diff->format('%y');
    }
}

if (!function_exists('CAPTCHA')) {
    function CAPTCHA()
    {
        $code = strtoupper(substr(rand(100000000000000, 999999999999999), 5, 6));
        return $code;
    }
}

if (!function_exists('THUMB')) {
    function THUMB($src)
    {
        $URL = "";
        return $URL;
    }
}

if (!function_exists('StatusCheckList')) {
    function StatusCheckList()
    {
        $Entry = array('jeddah-arrival', 'check-in-jeddah');

        $InKSA = array('travel-voucher-not-issued', 'travel-voucher-issued', '',
            'yanbu-arrival', 'medina-arrival', 'sea-arrival', 'check-in-medina', 'check-out-medina', 'check-out-mecca', 'check-in-mecca',
            'visa-issued', 'visa-not-printed', 'without-mofa', 'with-mofa', 'arrival');
        $ForArrival = array('mofa-issued', 'visa-issued');

        $InProcess = array('mofa-upload', 'mofa-issued', 'elm-upload', 'new', 'visa-issued');
        $Exit = array('departure-jeddah', 'departure-medina', 'departure-mecca');
        $Arrival = array("jeddah-arrival", 'yanbu-arrival', 'by-road-arrival', 'medina-arrival', 'sea-arrival');
        $CheckinKSA = array('check-in-mecca', 'check-in-medina', 'check-in-jeddah');
        $CheckInMecca = array("check-in-mecca");
        $CheckOutMecca = array("check-out-mecca");
        $ForArrivalMedina = array("check-out-mecca", "yanbu-arrival", "medina-arrival", "check-out-jeddah", "jeddah-arrival");
        $ForArrivalJeddah = array("jeddah-arrival", "check-out-mecca", "check-out-medina", "yanbu-arrival", "medina-arrival");
        $ForArrivalMecca = array("jeddah-arrival", "medina-arrival", "yanbu-arrival", "medina-arrival", "check-out-medina", "check-out-jeddah");
        $CheckInMedina = array("check-in-medina");
        $CheckOutMedina = array("check-out-medina");
        $CheckInMedinaMeta = array("check_in_medina_status");
        $CheckInJeddah = array("check-in-jeddah");
        $CheckOutJeddah = array("check-out-jeddah");
        $PAXInMecca = array("check-in-mecca");
        $PAXInMedina = array("check-in-medina");
        $PAXInJeddah = array("check-in-jeddah");
        $Allow = array("allow-tpt-arrival", "allow-htl-mecca", "allow-htl-medina", "allow-htl-jeddah");
        $AllowTransport = array("allow-tpt-arrival", "allow-tpt-mecca", "allow-tpt-medina", "allow-tpt-jeddah");
        $AllowHotel = array("allow-htl-mecca", "allow-htl-medina", "allow-htl-jeddah");
        $TotalPAXInSaudia = array("check-in-jeddah", "check-in-mecca", "check-in-medina");
        $ForExit = array_merge($ForArrival, $TotalPAXInSaudia);

        $final = array("Entry" => $Entry, "Exit" => $Exit, "InKSA" => $InKSA, "InProcess" => $InProcess
        , "Arrival" => $Arrival, "ForArrival" => $ForArrival, "ForExit" => $ForExit, "CheckinKSA" => $CheckinKSA,
            "CheckInMecca" => $CheckInMecca, "CheckInMedina" => $CheckInMedina, "CheckOutMecca" => $CheckOutMecca,
            "CheckOutMedina" => $CheckOutMedina, "CheckOutJeddah" => $CheckOutJeddah, "CheckInMedinaMeta" => $CheckInMedinaMeta,
            "CheckInJeddah" => $CheckInJeddah, "PAXInMecca" => $PAXInMecca, "PAXInMedina" => $PAXInMedina, "Allow" => $Allow,
            "AllowHotel" => $AllowHotel, "AllowTransport" => $AllowTransport,
            "PAXInJeddah" => $PAXInJeddah, "TotalPAXInSaudia" => $TotalPAXInSaudia, "ForArrivalMedina" => $ForArrivalMedina,
            "ForArrivalJeddah" => $ForArrivalJeddah, "ForArrivalMecca" => $ForArrivalMecca);

        return $final;
    }
}


if (!function_exists('GetBrnList')) {
    function GetBrnList($datatype = 'records', $BRNType, $selected = 0)
    {
        $Crud = new Crud();
        if ($BRNType == 'transport') {
            /*    $SQL = '
                SELECT * FROM "BRN"."brn"
                WHERE "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
                ORDER BY "BRN"."brn"."ExpireDate" ';*/


            $SQL = ' SELECT * from (
                SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' 
                AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
            ) AS "MainQuery"
            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
            
            UNION
            
            SELECT * from (
                SELECT "BRN"."brn".*, 0 AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                WHERE  "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQuery"
                WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
                AND "MainQuery"."UID" NOT IN (
                SELECT "UID" from (
                    SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                    (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                    FROM "BRN"."brn"
                    INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT)
                    WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                    GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                    ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQueryB"
	            WHERE (cast("MainQueryB"."TotelHotelBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint) OR cast("MainQueryB"."TotelTranpsortBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint))
)  ';


//            $SQL = '
//            SELECT * from (
//                SELECT
//                       "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
//                       (case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
//                       (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
//                FROM "BRN"."brn"
//                INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
//                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\'
//                AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
//                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
//                ORDER BY "BRN"."brn"."ExpireDate"
//             ) AS "MainQuery"
//            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)
//            OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)) ';


        } else {
            /*    $SQL = '
                SELECT * FROM "BRN"."brn"
                WHERE "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
                ORDER BY "BRN"."brn"."ExpireDate" ';*/

            $SQL = ' SELECT * from (
                SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" on ( CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT) )
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' 
                AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
            ) AS "MainQuery"
            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
            
            UNION
            
            SELECT * from (
                SELECT "BRN"."brn".*, 0 AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                WHERE  "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQuery"
                WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
                AND "MainQuery"."UID" NOT IN (
                SELECT "UID" from (
                    SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                    (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                    FROM "BRN"."brn"
                    INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                    WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                    GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                    ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQueryB"
	            WHERE (cast("MainQueryB"."TotelHotelBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint) OR cast("MainQueryB"."TotelTranpsortBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint))
)  ';

//            $SQL = '
//            SELECT * from (
//                SELECT
//                       "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
//                       (case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
//                       (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
//                FROM "BRN"."brn"
//                INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
//                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
//                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
//                ORDER BY "BRN"."brn"."ExpireDate"
//             ) AS "MainQuery"
//            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)
//            OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)) ';
        }

//        echo nl2br($SQL); exit;
        $options = $Crud->ExecuteSQL($SQL);
        $final = array();
        $final['records'] = $options;

        $HTML = '<option value="0" ' . (($selected == 0) ? 'selected' : '') . '>Cash</option>';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['BRNCode'] . '</option>';
        }
        $final['html'] = $HTML;
        $final['sql'] = $SQL;

        return $final[$datatype];
    }
}
if (!function_exists('GetBrnListByTypeOLD')) {
    function GetBrnListByTypeOLD($datatype = 'records', $BRNType, $selected = 0)
    {
        $Crud = new Crud();
        /*  $SQL = '
          SELECT *
          FROM "BRN"."brn"
          WHERE "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."UseType" = \'' . $BRNType . '\'
          ORDER BY "BRN"."brn"."ExpireDate"
          ';*/

        if ($BRNType == 'visa_and_transport') {
            $SQL = ' SELECT * from (
                SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' 
                AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\'
                AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."UseType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
                ORDER BY "BRN"."brn"."ExpireDate"
            ) AS "MainQuery"
            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
        
            UNION
        
            SELECT * from (
                SELECT "BRN"."brn".*, 0 AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                WHERE  "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND "BRN"."brn"."UseType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
                ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQuery"
                WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
                AND "MainQuery"."UID" NOT IN (
                SELECT "UID" from (
                    SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                    (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                    FROM "BRN"."brn"
                    INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                    WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."UseType" =  \'' . $BRNType . '\'
                    GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
                    ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQueryB"
	            WHERE (cast("MainQueryB"."TotelHotelBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint) OR cast("MainQueryB"."TotelTranpsortBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint))
)  ';


//            $SQL = '
//            SELECT * from (
//                SELECT
//                       "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
//                       (case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
//                       (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
//                FROM "BRN"."brn"
//                INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
//                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\'
//                AND "BRN"."brn"."UseType" = \'' . $BRNType . '\'
//                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
//                ORDER BY "BRN"."brn"."ExpireDate"
//             ) AS "MainQuery"
//            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)
//            OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)) ';
        } else {

            $SQL = ' SELECT * from (
                SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' 
                AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."UseType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
                ORDER BY "BRN"."brn"."ExpireDate"
            ) AS "MainQuery"
            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
            
            UNION
            
            SELECT * from (
                SELECT "BRN"."brn".*, 0 AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                WHERE  "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\' AND "BRN"."brn"."UseType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
                ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQuery"
                WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
                AND "MainQuery"."UID" NOT IN (
                SELECT "UID" from (
                    SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                    (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                    FROM "BRN"."brn"
                    INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                    WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND "BRN"."brn"."UseType" =  \'' . $BRNType . '\'
                    GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
                    ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQueryB"
	            WHERE (cast("MainQueryB"."TotelHotelBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint) OR cast("MainQueryB"."TotelTranpsortBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint))
)  ';
            /// AND \'TODAY()\' >= "BRN"."brn"."GenerateDate"  /////(Dont remove this comment . Shaheryar)
            /// \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND

//            $SQL = '
//            SELECT * from (
//                SELECT
//                       "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
//                       (case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
//                       (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
//                FROM "BRN"."brn"
//                INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
//                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."UseType" = \'' . $BRNType . '\'
//                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."UseType"
//                ORDER BY "BRN"."brn"."ExpireDate"
//             ) AS "MainQuery"
//            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)
//            OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)) ';

        }

//        echo nl2br($SQL); exit;
        $options = $Crud->ExecuteSQL($SQL);
        $final = array();
        $final['records'] = $options;
        //$final['sql'] = $SQL;

        $HTML = '<option value="0" ' . (($selected == 0) ? 'selected' : '') . '>Cash</option>';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['BRNCode'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }
}

if (!function_exists('GetBrnListByType')) {
    function GetBrnListByType($datatype = 'records', $BRNType, $selected = 0)
    {
        $Crud = new Crud();
        $SQL = '
        SELECT *
        FROM "BRN"."brn"
        WHERE "BRN"."brn"."UseType" = \'' . $BRNType . '\' 
        AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\'
        ORDER BY "BRN"."brn"."ExpireDate" ';

        //echo nl2br($SQL); exit;
        $options = $Crud->ExecuteSQL($SQL);
        $final = array();
        $final['records'] = $options;
        $final['sql'] = $SQL;

        $HTML = '<option value="0" ' . (($selected == 0) ? 'selected' : '') . '>Cash</option>';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['BRNCode'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }
}


if (!function_exists('GetVoucherBrnList')) {
    function GetVoucherBrnList($VoucherID = 0, $BRNType, $selected = 0)
    {
        $Crud = new Crud();


        if ($BRNType == 'transport') {

            $SQL = ' SELECT * from (
                SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
               INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
            ) AS "MainQuery"
            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
            UNION
            SELECT * from (
                SELECT "BRN"."brn".*, 0 AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                WHERE  "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQuery"
                WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
                AND "MainQuery"."UID" NOT IN (
                SELECT "UID" from (
                    SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                    (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                    FROM "BRN"."brn"
                    INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                    WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                    GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                    ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQueryB"
	            WHERE (cast("MainQueryB"."TotelHotelBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint) OR cast("MainQueryB"."TotelTranpsortBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint))
)  ';

//            $SQL = '
//            SELECT * from (
//                SELECT
//                       "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
//                       (case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
//                       (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
//                FROM "BRN"."brn"
//                INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
//                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\'
//                AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
//                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
//                ORDER BY "BRN"."brn"."ExpireDate"
//             ) AS "MainQuery"
//            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)
//            OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)) ';
        } else {

            $SQL = ' SELECT * from (
                SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
            ) AS "MainQuery"
            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
            
            UNION
            
            SELECT * from (
                SELECT "BRN"."brn".*, 0 AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                FROM "BRN"."brn"
                WHERE  "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQuery"
                WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint) OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint))
                AND "MainQuery"."UID" NOT IN (
                SELECT "UID" from (
                    SELECT "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",(case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
                    (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
                    FROM "BRN"."brn"
                    INNER JOIN "pilgrim"."meta" on (CAST("pilgrim"."meta"."Value" as TEXT) = CAST("BRN"."brn"."UID" AS TEXT))
                    WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" =  \'' . $BRNType . '\'
                    GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
                    ORDER BY "BRN"."brn"."ExpireDate"
                ) AS "MainQueryB"
	            WHERE (cast("MainQueryB"."TotelHotelBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint) OR cast("MainQueryB"."TotelTranpsortBRN" as bigint) > cast("MainQueryB"."BRNUsed" as bigint))
)  ';

//            $SQL = '
//            SELECT * from (
//                SELECT
//                       "BRN"."brn".*, COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
//                       (case when "BRN"."brn"."BRNType"= \'hotel\' then "BRN"."brn"."Beds" end) as "TotelHotelBRN",
//                       (case when "BRN"."brn"."BRNType"= \'transport\' then "BRN"."brn"."Seats" end) as "TotelTranpsortBRN"
//                FROM "BRN"."brn"
//                INNER JOIN "pilgrim"."meta" on CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
//                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%brn%\' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate" AND "BRN"."brn"."BRNType" = \'' . $BRNType . '\'
//                GROUP BY "BRN"."brn"."UID", "BRN"."brn"."BRNCode", "BRN"."brn"."BRNType"
//                ORDER BY "BRN"."brn"."ExpireDate"
//             ) AS "MainQuery"
//            WHERE (cast("MainQuery"."TotelHotelBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)
//            OR cast("MainQuery"."TotelTranpsortBRN" as bigint) > cast("MainQuery"."BRNUsed" as bigint)) ';
        }

//        $SQL = '
//        SELECT *
//        FROM "BRN"."brn"
//        WHERE  "BRN"."brn"."BRNType" = \'' . $BRNType . '\'';
//        if ($VoucherID == 0) {
//            $SQL .= ' AND "BRN"."brn"."ExpireDate" >= \'TODAY()\' AND \'TODAY()\' >= "BRN"."brn"."GenerateDate"';
//        }
//
//        $SQL .= ' ORDER BY "BRN"."brn"."ExpireDate"';
        $options = $Crud->ExecuteSQL($SQL);


        $HTML = '<option value="0" ' . (($selected == 0) ? 'selected' : '') . '>Cash</option>';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['BRNCode'] . '</option>';
        }


        return $HTML;
    }
}


if (!function_exists('CurrentStatus')) {
    function CurrentStatus($ID)
    {
        $Crud = new Crud();
        $where = array("UID" => $ID);
        $Status = $Crud->SingleRecord('pilgrim."master"', $where);
        return $Status['CurrentStatus'];
    }
}
if (!function_exists('UserNameByID')) {
    function UserNameByID($ID)
    {
        $Crud = new Crud();
        if ($ID != NULL && $ID != '') {
            $where = array("UID" => $ID);
            $User = $Crud->SingleRecord('main."Users"', $where);
            $name = $User['FullName'];
        } else {
            $name = "-";
        }
        return $name;

    }
}
if (!function_exists('GetIDwithTable')) {
    function GetIDwithTable($ID, $Table)
    {
        $Crud = new Crud();
        if ($ID != NULL && $ID != '') {
            $where = array("UID" => $ID);
            $User = $Crud->SingleRecord($Table, $where);
            $name = $User['FullName'];
        } else {
            $name = "-";
        }
        return $name;

    }

}
if (!function_exists('ShiftSession')) {
    function ShiftSession($UID, $AccountType)
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $HTML = '';
//        $Email = $Crud->SingleRecord('main."Users"', array("UID" => $ID));
        if ($session['profile']['Email'] == 'admin@admin.com' || $session['profile']['Email'] == 'admin@umrahfuras.com') {
            $HTML .= '<span class="mt-2 float-right"  onclick="ShiftLoginSession(' . $UID . ',\'' . $AccountType . '\');" style="cursor: pointer"><badge class="badge badge-mini badge-success">Shift Session</badge></span>';

        } else {
            $HTML .= '';
        }
//        $HTML .= '<span class="mt-2"  onclick="ShiftLoginSession(' . $UID . ',\''.$AccountType.'\');" style="cursor: pointer"><badge class="badge badge-mini badge-success">Shift Session</badge></span>';

        return $HTML;

    }

}
if (!function_exists('VoucherCode')) {
    function VoucherCode($AgentID)
    {
        $prefix = 'V/A/' . $AgentID . "/";

        $Crud = new Crud();
        $table = 'voucher."Master"';
        $vouchers = $Crud->ListRecords($table, array("AgentUID" => $AgentID));
//        print_r($vouchers);

        $str = $prefix . (count($vouchers) + 1);
        if ($vouchers['VoucherCode'] == $str) {
            $str = $prefix . (count($vouchers) + 1);
        }
        return $str;
    }
}
if (!function_exists('ActivityStatuses')) {
    function ActivityStatuses($VoucherID)
    {

        $Crud = new Crud();
        $SQL = 'SELECT 
                Distinct
                voucher."Pilgrim"."VoucherUID",
                voucher."Master"."VoucherCode",
                voucher."Master"."ArrivalType",
                "VP1"."PilgrimUID" AS "LeaderPilgrimUID",
                "Airports1"."Code" AS "SectorFromCode",
                "Airports2"."Code" AS "SectorToCode",
                "Airports2"."CountryCode" AS "CountryCode",
                (select pilgrim."master"."CurrentStatus"
                    FROM  pilgrim."master"
                    where pilgrim."master"."UID" = "VP1"."PilgrimUID"
                   ),
                    (select voucher."AccommodationDetails"."City"
                    FROM  voucher."AccommodationDetails"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    Order by voucher."AccommodationDetails"."CheckIn" ASC Limit 1
                   )
               
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID")
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."meta" ON pilgrim."master"."UID"=pilgrim."meta"."PilgrimUID"
                
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID" 
                LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID" = voucher."Master"."UID"
                LEFT JOIN main."Airports" AS "Airports1" ON ((cast("Airports1"."UID" as character varying)) = voucher."Flights"."SectorFrom" AND "Airports1"."CountryCode"=\'SA\')
                LEFT JOIN main."Airports" AS "Airports2" ON ((cast("Airports2"."UID" as character varying)) = voucher."Flights"."SectorTo"  AND "Airports2"."CountryCode"=\'SA\')
                WHERE voucher."Master"."UID"=' . $VoucherID . ' AND voucher."Flights"."FlightType"=\'Departure\'';
        $rslt = $Crud->ExecuteSQL($SQL);
        //print_r($rslt);
        $StatusCheckList = StatusCheckList();
        $records = array();
        $Allow = array('allow-tpt-arrival');
        $ForArrival = array_merge($Allow, $StatusCheckList['ForArrival']);
        foreach ($rslt as $r) {
            $currentStatus = $r['CurrentStatus'];
            if (in_array($currentStatus, $ForArrival)) {

                ////////// NOT Arival
                if ($r['ArrivalType'] == 'Air' && $r['SectorToCode'] == 'JED' && $r['CountryCode'] == 'SA') {
                    $records['jeddah-arrival'] = "Jeddah Arrival";

                }
                if ($r['ArrivalType'] == 'Air' && $r['SectorToCode'] == 'YNB' && $r['CountryCode'] == 'SA') {

                    $records['yanbu-arrival'] = " Yanbu Arrival";
                }
                if ($r['ArrivalType'] == 'Air' && $r['SectorToCode'] == 'MED' && $r['CountryCode'] == 'SA') {

                    $records['medina-arrival'] = "Medina Arrival";

                }
                if ($r['ArrivalType'] == 'Land') {
                    $records['by-road-arrival'] = "By Road Arrival";
                }
                if ($r['ArrivalType'] == 'Sea') {
                    $records['sea-arrival'] = "Sea Arrival";
                }

            } else {
                ////////// ARIVAL
                $PilgrimLastActivity = PilgrimLastActivity($r['LeaderPilgrimUID'], 'check-in-jeddah-status');
                $Allow = array('allow-htl-jeddah', 'allow-htl-medina', 'allow-htl-mecca');
                $Arrival = array_merge($Allow, $StatusCheckList['Arrival']);

                if (in_array($currentStatus, $Arrival)) {
                    $city = CityName($r['City']);

                    if ($city == 'Jeddah') {
                        $records['check-in-jeddah'] = "Check In Jeddah";
                        $records['check-in-mecca'] = "Check In Mecca";
                        $records['check-in-medina'] = "Check In Medina";
                    }
                    if ($city == 'Mecca') {
                        $records['check-in-mecca'] = "Check In Mecca";
                    }
                    if ($city == 'Medina') {
                        $records['check-in-jeddah'] = "Check In Jeddah";
                        $records['check-in-mecca'] = "Check In Mecca";
                        $records['check-in-medina'] = "Check In Medina";
                    }

                } else {
                    if ($currentStatus == 'check-in-jeddah') {
                        $records['check-out-jeddah'] = "Check Out jeddah";
                        $records['departure-jeddah'] = "Departure Jeddah";
                    }
                    if ($currentStatus == 'check-in-mecca') {
                        $records['check-out-mecca'] = "Check Out Mecca";
                        $records['departure-mecca'] = "Departure Mecca";
                    }
                    if ($currentStatus == 'check-in-medina') {
                        $records['check-out-medina'] = "Check Out Medina";
                        $records['departure-medina'] = "Departure Medina";
                    }
                    if ($currentStatus == 'check-out-jeddah') {
                        $records['check-in-mecca'] = "Check In Mecca";
                    }
                    if ($currentStatus == 'check-out-mecca') {
                        $records['check-in-medina'] = "Check In Medina";
                        $records['departure-mecca'] = "Departure Mecca";
                    }
                    if ($currentStatus == 'check-out-medina') {
                        $records['check-in-mecca'] = "Check In Mecca";
                    }
                }
            }


        }

        $SQL = 'SELECT *
                FROM "voucher"."Flights"
                WHERE voucher."Flights"."FlightType"=\'Departure\' 
                AND voucher."Flights"."ArrivalDate" >= CURRENT_DATE 
                AND voucher."Flights"."VoucherID" = ' . $VoucherID;
        $rslt = $Crud->ExecuteSQL($SQL);

        if (isset($rslt[0]['UID']) && $rslt[0]['UID'] > 0) {
            $records['allow-tpt-arrival'] = "Allow Transport Arrival";
        }


//        $records['allow-htl-mecca'] = "Allow Hotel Mecca";
//        $records['allow-tpt-mecca'] = "Allow Transport Mecca (Chk/Out)";
//        $records['allow-htl-medina'] = "Allow Hotel Medina";
//        $records['allow-tpt-medina'] = "Allow Transport Medina (Chk/Out)";
//        $records['allow-htl-jeddah'] = "Allow Hotel Jeddah";
//        $records['allow-tpt-jeddah'] = "Allow Transport Jeddah (Chk/Out)";

        //echo "<pre>".$SQL; print_r($records);

        return $records;
    }
}

//if (!function_exists('AllowHotelActivityStatuses')) {
//    function AllowHotelActivityStatuses()
//    {
//
//        $records['allow-htl-mecca'] = "Allow Hotel Mecca";
//        $records['allow-htl-medina'] = "Allow Hotel Medina";
//        $records['allow-htl-jeddah'] = "Allow Hotel Jeddah";
//
//        // echo "<pre>".$SQL; print_r($records);
//
//       return $records;
//
//    }
//}
if (!function_exists('AllowTransportActivityStatuses')) {
    function AllowTransportActivityStatuses()
    {


        $records['allow-tpt-mecca'] = "Allow Transport Mecca";
        $records['allow-tpt-medina'] = "Allow Transport Medina";
        $records['allow-tpt-jeddah'] = "Allow Transport Jeddah";

        // echo "<pre>".$SQL; print_r($records);

        return $records;

    }
}
if (!function_exists('ArrivalActivityStatuses')) {
    function ArrivalActivityStatuses($CityName)
    {
        // mecca : 258342 medina : 258343 jeddah : 258336
//        if ($CityName == '258342' || $CityName == '258343' || $CityName == '258336') {
//            $records[strtolower($CityName) . '-arrival'] = $CityName . " Arrival";
//        } else {
//            $records['other-arrival'] = "Other Arrival";
//        }
        $records[strtolower($CityName) . '-arrival'] = $CityName . " Arrival";
//        $records['sea-arrival'] = "Sea Arrival";
//        $records['by-road-arrival'] = "By Road Arrival";

        return $records;

    }
}
if (!function_exists('CheckOutActivityStatuses')) {
    function CheckOutActivityStatuses($CityName)
    {
        // mecca : 258342 medina : 258343 jeddah : 258336
//        if ($CityName == '258342' || $CityName == '258343' || $CityName == '258336') {
//            $records['check-out-' . strtolower($CityName)] = "Check Out " . $CityName;
//        } else {
//            $records['check-out-other'] = "Check Out Other";
//
//        }
        $records['check-out-' . strtolower($CityName)] = "Check Out " . $CityName;
        return $records;
    }
}
if (!function_exists('DepartureActivityStatuses')) {
    function DepartureActivityStatuses($CityName)
    {
        // mecca : 258342 medina : 258343 jeddah : 258336
//        if ($CityName == '258342' || $CityName == '258343' || $CityName == '258336') {
//            $records['departure-' . strtolower($CityName)] = "Departure " . $CityName;
//        } else {
//            $records['departure-other'] = "Departure Other";
//        }
        $records['departure-' . strtolower($CityName)] = "Departure " . $CityName;
        return $records;
    }
}

if (!function_exists('PilgrimLastActivity')) {
    function PilgrimLastActivity($PilgrimID, $CurrentStatus = '', $order = 'DESC')
    {
        $Crud = new Crud();
        if ($CurrentStatus != '') {
            $allowwhere = "AND \"meta\".\"Option\" NOT LIKE '%allow%'";
            if (strpos($CurrentStatus, 'allow') !== false) {
                $allowwhere = "";
            }

            $SQL = 'SELECT replace("meta"."Option", \'-status\', \'\') as "LastActivity", "meta"."UID","meta"."SystemDate","meta"."AllowReference"
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%-status%\' 
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                AND "meta"."Option" != \'' . $CurrentStatus . '\' 
                 ' . $allowwhere . ' 
                AND "meta"."UID" < ( SELECT "meta"."UID"	
                FROM "pilgrim"."meta" 
                WHERE "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                AND "meta"."Option" = \'' . $CurrentStatus . '\'
                ORDER BY "SystemDate" ' . $order . ' LIMIT 1)
                ORDER BY "SystemDate" DESC LIMIT 1';
            $record = $Crud->ExecuteSQL($SQL);
            $LastActivity = $record[0]['LastActivity'];

            $Final = array();
            $Final['LastActivity'] = $LastActivity;
            $Final['SQL'] = $SQL;
            $Final['Record'] = $record;
            $Final['LastActivityRecordID'] = $record[0]['UID'];
            $Final['LastActivityRecordTime'] = date('H:i:s', strtotime($record[0]['SystemDate']));
            $Final['LastActivityRecordAllowID'] = $record[0]['AllowReference'];

            $SQL = 'SELECT *
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%' . $LastActivity . '%\' 
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                ORDER BY "meta"."SystemDate" DESC';
            $records = $Crud->ExecuteSQL($SQL);
            $activities = array();
            foreach ($records as $record) {
                $AllowReference = $record['AllowReference'];
                $activities[$record['Option']] = $record['Value'];
            }
            $activities[$record['AllowReference']] = $AllowReference;

            $Final['ActivityRecords'] = $activities;
            return $Final;
        }

        if ($CurrentStatus == '') {
            $SQL = 'SELECT replace("meta"."Option", \'-status\', \'\') as "LastActivity"
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%-status%\' AND "meta"."Option" NOT LIKE \'%allow%\'
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                ORDER BY "SystemDate" DESC LIMIT 1';
            $record = $Crud->ExecuteSQL($SQL);
            $LastActivity = $record[0]['LastActivity'];

            $Final = array();
            $Final['LastActivity'] = $LastActivity;
            $Final['SQL'] = $SQL;
            $Final['LastActivityRecordID'] = $record[0]['UID'];

            $SQL = 'SELECT *
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%' . $LastActivity . '%\' 
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                ORDER BY "meta"."SystemDate" DESC';
            $records = $Crud->ExecuteSQL($SQL);
            $activities = array();
            foreach ($records as $record) {
                $AllowReference = $record['AllowReference'];
                $activities[$record['Option']] = $record['Value'];
            }
            $activities['AllowReference'] = $AllowReference;

            $Final['ActivityRecords'] = $activities;
            return $Final;
        }


    }
}
if (!function_exists('PilgrimCurrentActivity')) {
    function PilgrimCurrentActivity($PilgrimID, $CurrentStatus, $ref = 0)
    {
        $Crud = new Crud();
        $RefWhere = '';
        if ($ref > 0) {
            $RefWhere = ' AND "meta"."AllowReference" = ' . $ref . ' ';
        }
        if ($CurrentStatus != '') {
            $SQL = 'SELECT * FROM "pilgrim"."meta"
            WHERE "meta"."PilgrimUID" = \'' . $PilgrimID . '\'
            AND "meta"."Option" = \'' . $CurrentStatus . '-status\' 
            ' . $RefWhere . '
            LIMIT 1';
            $record = $Crud->ExecuteSQL($SQL);

            $Final = array();
            $Final['CurrentActivity'] = $CurrentStatus;
            $Final['SQL'] = $SQL;
            $Final['LastActivityRecordID'] = $record[0]['UID'];
            $Final['LastActivitySystemUser'] = $record[0]['CreatedBy'];
            $Final['LastActivityRecordTime'] = date('H:i:s', strtotime($record[0]['SystemDate']));

            $SQL = 'SELECT *
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%' . $CurrentStatus . '%\' 
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                ' . $RefWhere . '
                ORDER BY "meta"."SystemDate" DESC';
            $records = $Crud->ExecuteSQL($SQL);
            $activities = array();
            foreach ($records as $record) {
                $activities[$record['Option']] = $record['Value'];
            }

            $Final['ActivityRecords'] = $activities;
            return $Final;
        }

        if ($CurrentStatus == '') {
            $SQL = 'SELECT replace("meta"."Option", \'-status\', \'\') as "LastActivity"
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%-status%\' 
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\'
                ' . $RefWhere . ' 
                ORDER BY "SystemDate" DESC LIMIT 1';
            $record = $Crud->ExecuteSQL($SQL);
            $LastActivity = $record[0]['LastActivity'];

            $Final = array();
            $Final['LastActivity'] = $LastActivity;
            $Final['SQL'] = $SQL;
            $Final['LastActivityRecordID'] = $record[0]['UID'];

            $SQL = 'SELECT *
                FROM "pilgrim"."meta" 
                WHERE "meta"."Option" LIKE \'%' . $LastActivity . '%\' 
                AND "meta"."PilgrimUID" = \'' . $PilgrimID . '\' 
                ' . $RefWhere . '
                ORDER BY "meta"."SystemDate" DESC';
            $records = $Crud->ExecuteSQL($SQL);
            $activities = array();
            foreach ($records as $record) {
                $activities[$record['Option']] = $record['Value'];
            }

            $Final['ActivityRecords'] = $activities;
            return $Final;
        }


    }
}
if (!function_exists('BRNCode')) {
    function BRNCode($UID, $field = 'BRNCode')
    {
        if ($UID > 0) {
            $Crud = new Crud();

            $table = 'BRN."brn"';
            $options = $Crud->SingleRecord($table, $wheres = array("UID" => $UID));
            return $options[$field];
        } else {
            return "Cash";
        }

    }
}
if (!function_exists('GetWebsiteDomainIDs')) {
    //// GetWebsiteDomainIDs('agent', $AgentUID)
    function GetWebsiteDomainIDs()
    {
        $session = session();
        $session = $session->get();

        $domainIds = array();
        $domainIds[] = $session['domainid'];

        if ($session['AgentLogged'] == 1) {
            $domainIds[] = $session['profile']['WebsiteDomain'];
            $Crud = new Crud();
            $where = array("Name" => $session['profile']['Domain']);
            $AgentDomain = $Crud->SingleRecord('websites."Domains"', $where);
            if ($AgentDomain['UID']) {
                $domainIds[] = $AgentDomain['UID'];
            }
        }
        $domainIds = array_unique($domainIds);
        //print_r($domainIds); print_r($session);
        return $domainIds;
    }
}
if (!function_exists('GetAllAgents')) {
    function GetAllAgents($agentid)
    {
        $session = session();
        $session = $session->get();

        $final = array();
        $Crud = new Crud();

        $final[] = $agentid;
        if ($session['AgentLogged']) {
            $rslt1 = $Crud->ListRecords('main."Agents"', array("ParentID" => $agentid));
        } else {
//            $rslt1 = $Crud->ListRecords('main."Agents"', array("Type !=" => 'sub_agent'));
            $rslt1 = $Crud->ListRecords('main."Agents"', array("Archive" => 0), array("FullName" => 'ASC'));
        }

        foreach ($rslt1 as $rs1) {
            $final[] = $rs1['UID'];
        }

        return implode(",", $final);
    }
}

if (!function_exists('CroneHierarchyUsers')) {
    function CroneHierarchyUsers($user_id, $user_type, $crone = false)
    {
        $Crud = new Crud();
        $final = array();
//        if ($crone)
        $final[] = $user_id;
//        if ($user_type == 'sale_agent') {
//            $SaleAgent = $Crud->SingleRecord('sale_agent."Agents"', array("UID" => $user_id));
//            $SQL = 'SELECT *
//                FROM "sale_agent"."Meta"
//                WHERE sale_agent."Meta"."Option" = \'Agent_ID\'
//                AND sale_agent."Meta"."SaleAgentID" = ' . $SaleAgent['UID'] . ' ';
//            $rslt1 = $Crud->ExecuteSQL($SQL);
//        } else {
//            $where = array("ParentID" => $user_id);
//            $rslt1 = $Crud->ListRecords('main."Agents"', $where);
//        }
//
//        foreach ($rslt1 as $rs1) {
//            if ($user_type == 'sale_agent') {
//                $rs1['UID'] = $rs1['Value'];
//            }
//            $final[] = $rs1['UID'];
//            $where = array("ParentID" => $rs1['UID']);
//            $rslt2 = $Crud->ListRecords('main."Agents"', $where);
//            foreach ($rslt2 as $rs2) {
//                $final[] = $rs2['UID'];
//                $where = array("ParentID" => $rs2['UID']);
//                $rslt3 = $Crud->ListRecords('main."Agents"', $where);
//                foreach ($rslt3 as $rs3) {
//                    $final[] = $rs3['UID'];
//                    $where = array("ParentID" => $rs3['UID']);
//                    $rslt4 = $Crud->ListRecords('main."Agents"', $where);
//                    foreach ($rslt4 as $rs4) {
//                        $final[] = $rs4['UID'];
//                        $where = array("ParentID" => $rs4['UID']);
//                        $rslt5 = $Crud->ListRecords('main."Agents"', $where);
//                        foreach ($rslt5 as $rs5) {
//                            $final[] = $rs5['UID'];
//                        }
//                    }
//                }
//            }
//        }
        $final = array_unique($final);
        return implode(",", $final);
    }
}


if (!function_exists('HierarchyUsers')) {
    function HierarchyUsers($user_id)
    {
        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $final = array();
        $final[] = $user_id;
        //echo"<pre>";print_r($session);exit;
        if ($session['account_type'] == 'sale_agent') {
            $SaleAgent = $Crud->SingleRecord('sale_agent."Agents"', array("UID" => $user_id));

            $SQL = 'SELECT *
                FROM "sale_agent"."Meta"
                WHERE sale_agent."Meta"."Option" = \'Agent_ID\'  
                AND sale_agent."Meta"."SaleAgentID" = ' . $SaleAgent['UID'] . ' ';

            $rslt1 = $Crud->ExecuteSQL($SQL);
//            echo "<pre>";
//            print_r($rslt1);
//            exit;

//            $where = array("SalesmanID" => $SaleAgent['UID']);
//            $rslt1 = $Crud->ListRecords('main."Agents"', $where);


        } else {
            $where = array("ParentID" => $user_id);
            $rslt1 = $Crud->ListRecords('main."Agents"', $where);
        }

        foreach ($rslt1 as $rs1) {
            if ($session['account_type'] == 'sale_agent') {
                $rs1['UID'] = $rs1['Value'];
            }
            $final[] = $rs1['UID'];
            $where = array("ParentID" => $rs1['UID']);
            $rslt2 = $Crud->ListRecords('main."Agents"', $where);
            foreach ($rslt2 as $rs2) {
                $final[] = $rs2['UID'];
                $where = array("ParentID" => $rs2['UID']);
                $rslt3 = $Crud->ListRecords('main."Agents"', $where);
                foreach ($rslt3 as $rs3) {
                    $final[] = $rs3['UID'];
                    $where = array("ParentID" => $rs3['UID']);
                    $rslt4 = $Crud->ListRecords('main."Agents"', $where);
                    foreach ($rslt4 as $rs4) {
                        $final[] = $rs4['UID'];
                        $where = array("ParentID" => $rs4['UID']);
                        $rslt5 = $Crud->ListRecords('main."Agents"', $where);
                        foreach ($rslt5 as $rs5) {
                            $final[] = $rs5['UID'];
                        }
                    }
                }
            }
        }

        $final = array_unique($final);
        return implode(",", $final);
    }
}


if (!function_exists('BellNotificationUsers')) {
    function BellNotificationUsers($user_id)
    {

        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $final = array();
        $final[] = $user_id;

        $where = array("UserType" => 'admin', "Archive" => 0, "DomainID" => $session['domainid']);
        $rslt1 = $Crud->ListRecords('main."Users"', $where);
        foreach ($rslt1 as $rs1) {
            $final[] = $rs1['UID'];
        }


        if ($session['account_type'] == 'agent') {
            $where = array("Option" => 'Agent_ID', "Value" => $user_id);
            $rslt2 = $Crud->ListRecords('sale_agent."Meta"', $where);
            foreach ($rslt2 as $rs2) {
                $final[] = $rs2['SaleAgentID'];
            }
        }
        if ($session['account_type'] == 'sub_agent') {
            $where = array("UID" => $user_id, "WebsiteDomain" => $session['domainid'], "Archive" => 0);
            $rslt3 = $Crud->ListRecords('main."Agents"', $where);
            foreach ($rslt3 as $rs3) {
                $final[] = $rs3['ParentID'];

                $where = array("Option" => 'Agent_ID', "Value" => $rs3['ParentID']);
                $rslt4 = $Crud->ListRecords('sale_agent."Meta"', $where);
                foreach ($rslt4 as $rs4) {
                    $final[] = $rs4['SaleAgentID'];
                }

            }

            $where = array("Option" => 'Agent_ID', "Value" => $user_id);
            $rslt4 = $Crud->ListRecords('sale_agent."Meta"', $where);
            foreach ($rslt4 as $rs4) {
                $final[] = $rs4['SaleAgentID'];
            }

        } else if ($session['account_type'] == 'sale_agent') {
            $final[] = $user_id;
        }

        $final = array_unique($final);
        return $final;
//        return implode(",", $final);
    }
}


if (!function_exists('RandomFileName')) {
    function RandomFileName()
    {
        return md5(time());
    }
}
if (!function_exists('LoadFileTemp')) {
    function LoadFileTemp($UID)
    {

        ini_set('memory_limit', '512M');
        ob_start();
        if ($UID == NULL || $UID == '' || $UID == 0) {
            $UID = 0;
        }
        $Crud = new Crud();
        $File = $Crud->SingleRecord('uploads."Files"', array("UID" => $UID));
        //echo $File['UID']; echo $File['Ext']; exit;

        // send headers then display image
        $fname = explode("/", $File['Ext']);
        $File['Ext'] = $fname[1];
        $image_file = base64_decode($File['Content']);
        //$imagebase64 = base64_decode($image_file);
        $filename = uniqid() . "." . $File['Ext'];
        $file = ROOT . "/temp/" . $filename;
        fopen($file, "w+");
        file_put_contents($file, $image_file);
        $fileurl = PATH . "/temp/" . $filename;

        return array("url" => $fileurl, "file" => $file);

    }
}

if (!function_exists('CKHBlank')) {
    function CKHBlank($variable, $blank = '')
    {
        if (isset($variable)) {
            return $variable;
        } else {
            return $blank;
        }
    }
}

if (!function_exists('timeDiff')) {
    function timeDiff($firstTime, $lastTime)
    {
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);
        $timeDiff = $lastTime - $firstTime;
        return gmdate("H:i:s", $timeDiff);
    }
}

if (!function_exists('PROPER')) {
    function PROPER($String)
    {
        return trim(ucwords(str_replace("-", " ", $String)));
    }
}

if (!function_exists('GetBrnID')) {
    function GetBrnID($String = '')
    {
        $BrnRecord = new BrnRecords();
        $BrnData = $BrnRecord->GetLessUsedBrn($String);
        $BrnUID = ((isset($BrnData['UID']) && $BrnData['UID'] != '') ? $BrnData['UID'] : 0);

        return $BrnUID;
    }
}
if (!function_exists('PassWord')) {
    function PassWord($q, $status)
    {
        if ($status == 'hide') {
            $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
            $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
            return ($qEncoded);
        }

        if ($status == 'show') {
            $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
            $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
            return ($qDecoded);
        }
    }
}
if (!function_exists('SalesActionButtons')) {
    function SalesActionButtons()
    {
        $session = session();
        $session = $session->get();
        if ($session['type'] == 'sale-officer') {
            $html = '';
            $html .= '<li class="nav-item"> <div class="leadbtngroup">';
            $html .= '<button class="btn btn-sm btn-outline-danger leadsbtn">Dialing Start</button>';
            $html .= '<button class="btn btn-sm btn-outline-success leadsbtn">Follow Ups Start</button>';
            $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn">Organing Start</button>';
            $html .= '<button class="btn btn-sm btn-outline-warning leadsbtn">Training Start</button>';
            $html .= '</div></li>';
            echo $html;

        }
    }
}
if (!function_exists('TimeTrackActions')) {
    function TimeTrackActions()
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');

        $html = '';
        $html .= '<div class="leadbtngroup">';
        $SQL = "SELECT * FROM main.\"UserTimetrack\" WHERE main.\"UserTimetrack\".\"ActivityStop\" IS NULL AND main.\"UserTimetrack\".\"UserID\" = '" . $UserUID . "' AND main.\"UserTimetrack\".\"TrackDate\" = '" . date("Y-m-d") . "' ";
        $Records = $Crud->ExecuteSQL($SQL);
        //print_r($Records);
        if (isset($Records[0]['UID'])) {
            $activityType = $Records[0]['ActivityType'];
            //////////////////////////// DIALING
            $SQL = "SELECT * FROM main.\"UserTimetrack\" WHERE main.\"UserTimetrack\".\"ActivityStop\" IS NULL AND main.\"UserTimetrack\".\"UserID\" = '" . $UserUID . "' AND main.\"UserTimetrack\".\"ActivityType\" = '" . $activityType . "' AND main.\"UserTimetrack\".\"TrackDate\" = '" . date("Y-m-d") . "' ";
            $Records = $Crud->ExecuteSQL($SQL);
            //print_r($Records);
            if (isset($Records[0]['UID'])) {
                $html .= '<button class="btn btn-sm btn-outline-danger leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'' . $activityType . '\', ' . $Records[0]['UID'] . ')">' . ucwords($activityType) . ' Stop</button> ';
            } else {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'' . $activityType . '\', 0)">' . ucwords($activityType) . ' Start</button> ';
            }
        } else {
            //////////////////////////// DIALING
            $SQL = "SELECT * FROM main.\"UserTimetrack\" WHERE main.\"UserTimetrack\".\"ActivityStop\" IS NULL AND main.\"UserTimetrack\".\"UserID\" = '" . $UserUID . "' AND main.\"UserTimetrack\".\"ActivityType\" = 'dialing' AND main.\"UserTimetrack\".\"TrackDate\" = '" . date("Y-m-d") . "' ";
            $Records = $Crud->ExecuteSQL($SQL);
            //print_r($Records);
            if (isset($Records[0]['UID'])) {
                $html .= '<button class="btn btn-sm btn-outline-danger leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'dialing\', ' . $Records[0]['UID'] . ')">Dialing Stop</button> ';
            } else {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'dialing\', 0)">Dialing Start</button> ';
            }

            //////////////////////////// Follow Ups
            $SQL = "SELECT * FROM main.\"UserTimetrack\" WHERE main.\"UserTimetrack\".\"ActivityStop\" IS NULL AND main.\"UserTimetrack\".\"UserID\" = '" . $UserUID . "' AND main.\"UserTimetrack\".\"ActivityType\" = 'followups' AND main.\"UserTimetrack\".\"TrackDate\" = '" . date("Y-m-d") . "' ";
            $Records = $Crud->ExecuteSQL($SQL);
//            print_r($Records);
            if (isset($Records[0]['UID'])) {
                $html .= '<button class="btn btn-sm btn-outline-danger leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'followups\', ' . $Records[0]['UID'] . ')">Follow-UPs Stop</button> ';
            } else {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'followups\', 0)">Follow-UPs Start</button> ';
            }

            //////////////////////////// Organic Work
            $SQL = "SELECT * FROM main.\"UserTimetrack\" WHERE main.\"UserTimetrack\".\"ActivityStop\" IS NULL AND main.\"UserTimetrack\".\"UserID\" = '" . $UserUID . "' AND main.\"UserTimetrack\".\"ActivityType\" = 'organic' AND main.\"UserTimetrack\".\"TrackDate\" = '" . date("Y-m-d") . "' ";
            $Records = $Crud->ExecuteSQL($SQL);
            //print_r($Records);
            if (isset($Records[0]['UID'])) {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'organic\', ' . $Records[0]['UID'] . ')">Organic Stop</button> ';
            } else {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'organic\', 0)">Organic Start</button> ';
            }

            //////////////////////////// Training Work
            $SQL = "SELECT * FROM main.\"UserTimetrack\" WHERE main.\"UserTimetrack\".\"ActivityStop\" IS NULL AND main.\"UserTimetrack\".\"UserID\" = '" . $UserUID . "' AND main.\"UserTimetrack\".\"ActivityType\" = 'training' AND main.\"UserTimetrack\".\"TrackDate\" = '" . date("Y-m-d") . "' ";
            $Records = $Crud->ExecuteSQL($SQL);
            //print_r($Records);
            if (isset($Records[0]['UID'])) {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'training\', ' . $Records[0]['UID'] . ')">Training  Stop</button> ';
            } else {
                $html .= '<button class="btn btn-sm btn-outline-primary leadsbtn" onclick="UpdateUserTimeTrack(' . $UserUID . ', \'training\', 0)">Training  Start</button> ';
            }
        }
        $html .= '</div>';
        echo $html;
    }
}

///////////////////////////////////////////////////////// SALES RELATED FUNCTIONS ////////////////////////////////////////////////////

if (!function_exists('LeadAccess')) {
    function LeadAccess($lead_id)
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');

        $Agents = HierarchyUsers($UserUID);
        $SQL = "SELECT * FROM `leads` WHERE `Agent` in (" . $Agents . ") AND `UID` = " . $lead_id;
        $Records = $Crud->ExecuteSQL($SQL);
        if (count($Records) > 0) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('WorkSheetAccess')) {
    function WorkSheetAccess($worksheet_uid)
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');

        $Users = HierarchyUsers($UserUID);
        $SQL = "SELECT sales.\"Worksheet\".* FROM sales.\"Worksheet\" WHERE sales.\"Worksheet\".\"UserID\" in (" . $Users . ") AND sales.\"Worksheet\".\"UID\" = " . $worksheet_uid;
        $Records = $Crud->ExecuteSQL($SQL);
        if (count($Records) > 0) {
            return true;
//            print_r($Records);
//            exit;
        } else {
            return false;
//            print_r($Records);
//            exit;
        }
    }
}
//if (!function_exists('ContactValidate')) {
//    function ContactValidate($mobile)
//    {
//        $mobile = str_replace("+92", "0", $mobile);
//        $mobile = str_replace("+923", "923", $mobile);
//        $mobile = str_replace("+9203", "923", $mobile);
//
//        if (strlen($mobile) == 11)
//            $mobile = 92 . substr($mobile, 1, 10);
//        if (strlen($mobile) == 10)
//            $mobile = 92 . $mobile;
//
//        return $mobile;
//    }
//}
if (!function_exists('ContactValidate')) {
    function ContactValidate($mobile)
    {

        $mobile = trim($mobile);
//        $mobile = str_replace("+92", "0", $mobile);
        $mobile = str_replace(" ", "", $mobile);
        $mobile = str_replace("-", "", $mobile);
//        $mobile = str_replace("+923", "923", $mobile);
//        $mobile = str_replace("+9203", "923", $mobile);
        $mobile = str_replace("+", "", $mobile);
        $mobile = str_replace(".", "", $mobile);
        $mobile = str_replace(",", "", $mobile);
        $mobile = str_replace("_", "", $mobile);
        $mobile = str_replace("(", "", $mobile);
        $mobile = str_replace(")", "", $mobile);

        if (strlen($mobile) == 11)
//            $mobile = 92 . substr($mobile, 1, 10);
            if (strlen($mobile) == 10)
//            $mobile = 92 . $mobile;
                //923455913609
                if (strlen($mobile) < 11) {
                    $mobile = '';
                }
        if (strlen($mobile) > 12) {
            $mobile = '';
        }
        return $mobile;
    }
}

if (!function_exists('LeadDuplicateCheck')) {
    function LeadDuplicateCheck($Category, $mobile)
    {
        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $final = array_unique($mobile);
        $ContactNumbers = implode("','", $final);
        $mobile = "'" . $ContactNumbers . "'";


        $SQL = ' SELECT "sales"."Leads"."ContactNo" AS "Contact" FROM "sales"."Leads" WHERE "LeadCategory" =  \'' . $Category . '\' 
        AND "DomainID" =  ' . $session['domainid'] . ' 
        AND "sales"."Leads"."ContactNo" IN (' . $mobile . ')
        OR "UID" IN ( 
            SELECT "LeadID" FROM "sales"."LeadsMeta" WHERE "Value" IN (' . $mobile . ') AND "Options" = \'MobileNumber1\' AND "Value" IS NOT NULL
        )
        
        UNION 
        
        SELECT "sales"."Leads"."WhatsAppNo" AS "Contact" FROM "sales"."Leads" WHERE "LeadCategory" =  \'' . $Category . '\'
        AND "DomainID" =  ' . $session['domainid'] . '
        AND  "sales"."Leads"."WhatsAppNo" IN (' . $mobile . ')
        OR "UID" IN ( 
            SELECT "LeadID" FROM "sales"."LeadsMeta" WHERE "Value" IN (' . $mobile . ') AND "Options" = \'MobileNumber1\' AND "Value" IS NOT NULL
        ) 
        ';

        //echo '<br>'.nl2br($SQL).'<br>';
        $LeadExisting = $Crud->ExecuteSQL($SQL);
        if (count($LeadExisting) > 0) {
            return 1;
        } else {
            return 0;
        }

    }
}
if (!function_exists('WhatsAppUrl')) {
    function WhatsAppUrl($number)
    {
        $url = 'https://wa.me/' . $number;
        return $url;
    }
}
if (!function_exists('StatusString')) {
    function StatusString($Status)
    {
        $Status = ucfirst(str_replace("_", " ", $Status));
        return $Status;
    }
}

if (!function_exists('TotalDuration')) {
    function TotalDuration($Durations)
    {

//        $Durations = array();
//        $Durations[] = "25:01:02";
//        $Durations[] = "05:01:02";
//        $Durations[] = "41:01:02";
        $totalSec = 0;
        if (is_array($Durations) && count($Durations) > 0) {
            foreach ($Durations as $Duration) {
                $matches0 = explode(':', $Duration);
                if (count($matches0) > 2)
                    $totalSec += $matches0[0] * 60 * 60 + $matches0[1] * 60 + $matches0[2];
            }
            $h = intval(($totalSec) / 3600);
            $m = intval(($totalSec - $h * 3600) / 60);
            $s = $totalSec - $h * 3600 - $m * 60;
            return $str = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . str_pad($m, 2, '0', STR_PAD_LEFT) . ':' . str_pad($s, 2, '0', STR_PAD_LEFT);
        } else {
            return '-';
        }
    }
}

if (!function_exists('BellNotification')) {
    function BellNotification($description, $reftype, $refid, $UserUID = 0)
    {
        $Crud = new Crud();
        $session = session();
        $DomainID = $session->get('domainid');

        if ($UserUID == 0) {
            $UserUID = $session->get('id');
        }

        $record = array(
            'SystemDate' => date("Y-m-d H:i:s"),
            'UserID' => $UserUID,
            'Description' => $description,
            'RefType' => $reftype,
            'RefUID' => $refid,
            'DomainID' => $DomainID,
            'ReadFlag' => 0
        );

        $Records = $Crud->AddRecord('main."UserNotifications"', $record);
        if ($Records > 0) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('UserName')) {
    function UserName($ID)
    {
        $Crud = new Crud();
        $table = 'main."Users"';
        $options = $Crud->SingleRecord($table, array("UID" => $ID));
        return $options['FullName'];
    }
}

///////////////////////////////////////////////////////// SALES RELATED FUNCTIONS ////////////////////////////////////////////////////

if (!function_exists('GetLastPostData')) {
    function GetLastPostData($url)
    {
        //$rss = simplexml_load_file('http://fetchrss.com/rss/632037cfc6507e40c164f8b3632037a828e73e6286538322.xml');
        $rss = simplexml_load_file($url);
        $item = json_decode(json_encode($rss->channel->item), true);

        return ['page_title' => $rss->channel->title, 'page_publish' => $item['pubDate']];
    }
}
//final
if (!function_exists('Form_Field_Check')) {
    function Form_Field_Check($table, $column_name, $column_value)
    {
        $Crud = new Crud();
        $validate = $Crud->SingleRecord($table, $wheres = array($column_name => trim($column_value)));
        return $validate[$column_name];
    }
}
if (!function_exists('FingerPrintID')) {
    function  FingerPrintID()
    {
        $Crud = new Crud();
        $table = 'public."att_terminal"';
        $where = array('terminal_type'=>'K50');
        $ID = $Crud->SingleRecord($table,$where);
        return $ID['id'];

    }
}
///// Get Pilgrim on Activitity Base
if (!function_exists('Get_Pilgrim_On_Activity_Based')) {
    function Get_Pilgrim_On_Activity_Based($AllowReference, $OptionArray)
    {
        $Crud = new Crud();
        $OptionArray = array_unique($OptionArray);

        $like_statements = array();

        foreach ($OptionArray as $value) {
            $like_statements[] = "pilgrim.\"meta\".\"Option\" Like '%" . $value . "%'";
        }
        $like_string = "(" . implode(' OR ', $like_statements) . ")";
        //echo $like_string;exit();
        $SQL = 'SELECT count(DISTINCT pilgrim."meta"."PilgrimUID") AS "Voucher_pilgrim"
					FROM pilgrim."meta"
					WHERE pilgrim."meta"."AllowReference" = \'' . $AllowReference . '\'
					AND (' . $like_string . ')';
//echo $SQL;exit();
        $RecordExisting = $Crud->ExecuteSQL($SQL);
        //echo '<pre>';print_r($RecordExisting);exit();
        return $RecordExisting[0]['Voucher_pilgrim'];//exit();
    }
}
?>