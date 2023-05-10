<?php namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;
use App\Models\Main;

class Crud extends Model
{
    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public
    function AlterDatabase()
    {
        $sql = file_get_contents(ROOT . "/db/alter.sql");
        $sqls = explode(';', $sql);
        array_pop($sqls);
        if (count($sqls) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            foreach ($sqls as $statement) {
                $statment = $statement . ";";
                if ($db->query($statment)) {
                    //echo $db->getLastQuery() . "<hr>";
                }
            }
            $db->close();
        }
    }
    public
    function AlterSalesDatabase()
    {
        $sql = file_get_contents(ROOT . "/db/alter_sales.sql");
        $sqls = explode(';', $sql);
        array_pop($sqls);
        if (count($sqls) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            foreach ($sqls as $statement) {
                $statment = $statement . ";";
                if ($db->query($statment)) {
                    //echo $db->getLastQuery() . "<hr>";
                }
            }
            $db->close();
        }
    }

    public
    function AlterLangTranslations($DefaultTranslation)
    {
        $table = 'main."LanguageTranslations"';
        $Translations = $this->ListRecords($table);
        if (count($Translations) > 0) {
            $TempData = array();
            foreach ($Translations as $thisData) {
                $TempData[$thisData['Code'] . "|" . $thisData['Key']] = $thisData['Value'];
            }
        }
        // print_r($TempData);

        // Final Data Insertion
        $table = 'main."Language"';
        $DefaultLang = 'en';
        $Languages = $this->ListRecords($table);
        $InstRecords = array();
        foreach ($Languages as $thisLang) {
            $lang = $thisLang['Code'];
            foreach ($DefaultTranslation as $key => $value) {
                if (!isset($TempData[$lang . "|" . $key])) {
                    $temp = array();
                    $temp['Code'] = $lang;
                    $temp['Key'] = $key;
                    $temp['Value'] = ($DefaultLang == $lang) ? $value : "";
                    $InstRecords[] = $temp;
                }
            }
        }
        // print_r($InstRecords);
        if (count($InstRecords) > 0) {
            $table = 'main."LanguageTranslations"';
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, true);
            $db->close();
        }
    }

    public function AlterDefaultLookUps($DefaultLookUps)
    {
        $table = 'main."Lookups"';
        $LookUps = $this->ListRecords($table);
        $TempData = array();
        if (count($LookUps) > 0) {
            foreach ($LookUps as $thisData) {
                $TempData[] = $thisData['Key'];
            }
        }
        // print_r($TempData);

        // Final Data Insertion
        $InstRecords = array();
        foreach ($DefaultLookUps as $LookUp) {
            if (in_array($LookUp['Key'], $TempData)) {
                // Update

            } else {
                // Insert
                $temp = array();
                $temp['Key'] = $LookUp['Key'];
                $temp['Name'] = $LookUp['Name'];
                $temp['Description'] = $LookUp['Description'];
                $InstRecords[] = $temp;
            }

        }
//        print_r($InstRecords);
        if (count($InstRecords) > 0) {
            $table = 'main."Lookups"';
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, true);
            $db->close();
        }
    }


    public function AlterDefaultWebsiteSettings($DefaultWebsiteSettings)
    {
        $DomainTable = 'websites."Domains"';
        $Domains = $this->ListRecords($DomainTable);
        $table = 'websites."Settings"';
        $InstRecords = array();
        foreach ($Domains as $Domain) {
            // Final Data Insertion
            foreach ($DefaultWebsiteSettings as $Settings) {
                $record = $this->SingleRecord($table, $wheres = array('Key' => $Settings['Key'], 'DomainID' => $Domain['UID']));
                if (count($record) > 0) {
                    // Update
                } else {
                    // Insert
                    $temp = array();
                    $temp['Segment'] = $Settings['Segment'];
                    $temp['Key'] = $Settings['Key'];
                    $temp['Name'] = $Settings['Name'];
                    $temp['Description'] = '';
                    $temp['DomainID'] = $Domain['UID'];
                    $temp['OrderNo'] = 0;
                    $InstRecords[] = $temp;
                }
            }
        }

        //echo "<pre>"; print_r($InstRecords);
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
        //echo "xxxxxxxxxxxxxxxx";
    }


    public function AlterDefaultSettings($DefaultSettings)
    {

        $DomainTable = 'websites."Domains"';
        $Domains = $this->ListRecords($DomainTable);

        $table = 'main."AdminSettings"';
        $InstRecords = array();

        foreach ($Domains as $Domain) {
            foreach ($DefaultSettings as $Settings) {
                $record = $this->SingleRecord($table, $where = array('Key' => $Settings['Key'], 'DomainID' => $Domain['UID']));
                if (count($record) > 0) {
                } else {
                    $temp = array();
                    $temp['Segment'] = $Settings['Segment'];
                    $temp['Key'] = $Settings['Key'];
                    $temp['Name'] = trim($Settings['Name']);
                    $temp['Description'] = '';
                    $temp['DomainID'] = $Domain['UID'];
                    $temp['OrderNo'] = 0;

                    //$this->AddRecord($table, $temp);
                    $InstRecords[] = $temp;
                }
            }
        }
        //print_r($InstRecords);
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
            //echo "xxxxxxxxxxxxxxxx";
        }
    }

    public function AlterDefaultKeysCounter($DefaultKeysCounter)
    {

        $DomainTable = 'websites."Domains"';
        $Domains = $this->ListRecords($DomainTable);

        $table = 'websites."stats"';
        $InstRecords = array();

        foreach ($Domains as $Domain) {
            foreach ($DefaultKeysCounter as $KeysCounter) {
                $record = $this->SingleRecord($table, $where = array('StatsKey' => $KeysCounter['StatsKey'], 'DomainID' => $Domain['UID']));
                if (count($record) > 0) {
                } else {
                    $temp = array();
                    $temp['StatsKey'] = $KeysCounter['StatsKey'];
                    $temp['Value'] = trim($KeysCounter['Value']);
                    $temp['DomainID'] = $Domain['UID'];

                    //$this->AddRecord($table, $temp);
                    $InstRecords[] = $temp;
                }
            }
        }
        // print_r($InstRecords);
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
            //echo "xxxxxxxxxxxxxxxx";
        }
    }

    public
    function Track($segment, $message)
    {
        $table = 'main."AdminLog"';

        $records = array();
        $records['LogSegment'] = $segment;
        $records['LogNotes'] = $message;
        $records['LogIP'] = $_SERVER['REMOTE_ADDR'];

        $this->AddRecord($table, $records);
    }

    public
    function AddRecord($table, $records, $view = false)
    {
        $db = db_connect();
        $db->db_debug = false;
        $builder = $db->table($table);
        $builder->insert($records);
        if ($view) {
            $QUERY = $db->getLastQuery() . ";<br>";
            $Main = new Main();
//            $Main->SendEmail('info@orixestech.com', 'Umrah Furas :: Insert Query Error', $QUERY);
            echo $QUERY;
        }
        $insertID = $db->insertID();
        $db->close();
        return $insertID;
    }

    public
    function AddBulkRecord($table, $records)
    {
        if (count($records) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($records, null);
            //echo $db->getLastQuery() . "<hr>";
            $db->close();
        }
    }

    public
    function UpdateRecord($table, $records, $where)
    {
        $db = db_connect();
        $builder = $db->table($table);
        if (count($where) > 0) {
            $builder->where($where);
        }
        $builder->update($records);
        // echo $db->getLastQuery() . "<hr>";


        $db->close();
        return true;
    }

    public
    function DeleteRecord($table, $where)
    {
        $db = db_connect();
        $builder = $db->table($table);
        if (count($where) > 0) {
            $builder->where($where);
        }
        $builder->delete();
        $db->close();

        return true;
    }

        public
        function TruncateRecord($table)
        {
            $db = db_connect();
            $builder = $db->table($table);
            $builder->emptyTable();
            $db->close();

            return true;
        }


    public
    function CountRecord($table)
    {
        $db = db_connect();
        $builder = $db->table($table);
        $rslt = $builder->countAll();
        $db->close();
        return $rslt;

    }

    public
    function CountRecordsWithCondition($table, $where)
    {
        $db = db_connect();
        $rslt = $db->table($table)->where($where)->countAllResults();
        // echo $db->getLastQuery() . "<hr>";
        $db->close();
        return $rslt;

    }

    public
    function LookupOptions($key, $type = 'data', $selected = 0)
    {
        $table = 'main."Lookups"';
        $where = array("Key" => $key);
        $data['LookupID'] = $this->SingleRecord($table, $where);

        $table = 'main."LookupsOptions"';
        $where = array("LookupID" => $data['LookupID']['UID'], "Archive" => 0);
        $order = array("OrderID" => "ASC", "Name" => "ASC");
        $options = $this->ListRecords($table, $where, $order);
        if ($type == 'data') {
            return $options;
        } else {
            $html = '';
            foreach ($options as $option) {
                $html .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['Name'] . '</option>';
            }
            return $html;
        }

    }

    public
    function LookupOptionsData($Type)
    {
        $table = 'main."LookupsOptions"';
        $where = array("UID" => $Type, "Archive" => 0);
        //$order = array("OrderID" => "ASC");
        $options = $this->SingleRecord($table, $where);
        return $options;
    }

    public
    function ListRecords($table, $wheres = array(), $order = array(), $limit = 0)
    {
        $db = db_connect();
        $builder = $db->table($table);

        $builder->select('*');
        if (count($wheres) > 0) {
            $builder->where($wheres);
        }
        if (count($order) > 0) {
            foreach ($order as $ordK => $ordV) {
                $builder->orderBy($ordK, $ordV);
            }
        }
        if ($limit > 0) {
            $builder->limit($limit);
        }

        $query = $builder->get();
        $records = $query->getResultArray();
        if (!is_array($records)) {
            $records = array();
        }

        // echo $db->getLastQuery() . "<hr>";
        $db->close();
        return $records;
    }

    public
    function ListDistictRecords($table, $wheres = array(), $order = array(), $limit = 0)
    {
        $db = db_connect();
        $builder = $db->table($table);

        $builder->select('*');
        if (count($wheres) > 0) {
            $builder->where($wheres);
        }
        if (count($order) > 0) {
            foreach ($order as $ordK => $ordV) {
                $builder->orderBy($ordK, $ordV);
            }
        }
        if ($limit > 0) {
            $builder->limit($limit);
        }

        $query = $builder->get();
        $records = $query->getResultArray();
        if (!is_array($records)) {
            $records = array();
        }
        //echo $db->getLastQuery() . "<hr>";
        $db->close();
        return $records;
    }

    public
    function ListJoinRecords($baseTable, $joinTable, $joinCondition, $wheres = array(), $order = array(), $limit = 0)
    {
        $db = db_connect();
        $builder = $db->table($baseTable);
        $builder->select('*');
        $builder->join($joinTable, $joinCondition, "inner");

        if (count($wheres) > 0) {
            $builder->where($wheres);
        }
        if (count($order) > 0) {
            foreach ($order as $ordK => $ordV) {
                $builder->orderBy($ordK, $ordV);
            }
        }
        if ($limit > 0) {
            $builder->limit($limit);
        }

        $query = $builder->get();
        $records = $query->getResultArray();
        if (!is_array($records)) {
            $records = array();
        }

        // echo $db->getLastQuery() . "<hr>";
        $db->close();
        return $records;
    }

    public
    function ExecuteSQL($Query, $view = false)
    {
        $db = db_connect();
        $records = $db->query($Query)->getResult('array');
        if ($view)
            echo $db->getLastQuery() . "<hr>";
        $db->close();
        return $records;
    }


    public
    function SingleRecord($table, $wheres = array(), $view = false)
    {
        $db = db_connect();
        $builder = $db->table($table);

        $builder->select('*');
        if (count($wheres) > 0) {
            $builder->where($wheres);
        }
        $query = $builder->get();
        $record = (array)$query->getRowArray();
        if (!is_array($record)) {
            $record = array();
        }
        //print_r($record);
        //$record = $query->getRowArray();
        if($view) echo $db->getLastQuery() . "<hr>";

        $db->close();
        return $record;
    }

    public
    function UploadFile($file, $single = true)
    {

        if (isset($_FILES[$file]['tmp_name']) && $_FILES[$file]['tmp_name'] != "") {
            if ($single) {
                $recordid = 0;
                $records = array();
                $records['SystemDate'] = 'now()';
                $records['Ext'] = $_FILES[$file]['type'];
                $file_content = file_get_contents($_FILES[$file]['tmp_name']);
                $file_content = base64_encode($file_content);
                $records['Content'] = $file_content;
                $recordid = $this->AddRecord('uploads."Files"', $records);
            } else {
                $recordid = array();
                if (isset($_FILES[$file]['tmp_name'][0]) && $_FILES[$file]['tmp_name'][0] != "") {
                    for ($a = 0; $a < count($_FILES[$file]['name']); $a++) {
                        //echo $_FILES[$file]['tmp_name'][$a];
                        $records = array();
                        $records['SystemDate'] = 'now()';
                        $records['Ext'] = $_FILES[$file]['type'][$a];
                        $file_content = file_get_contents($_FILES[$file]['tmp_name'][$a]);
                        $file_content = base64_encode($file_content);
                        $records['Content'] = $file_content;
                        //print_r($records);
                        $recordid[] = $this->AddRecord('uploads."Files"', $records);
                    }
                }
            }
        }

        return $recordid;
    }


}
