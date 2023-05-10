<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Groups;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Pilgrims;
use App\Models\Crud;
class Mofa extends BaseController
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

    public function index()
    {
        $data = $this->data;

        /*$listMofa = new MofaProcess();
        $data['records'] = $listMofa->GetMOFAlist();*/

//        print_r($data['records']);exit;

        echo view('header', $data);
        echo view('mofa/index', $data);
        echo view('footer', $data);
    }

    public function visa_not_printed()
    {
        $data = $this->data;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();

        $listMofa = new MofaProcess();
        $data['records'] = $listMofa->VISANotPrinted();
        // echo "<pre>";
        // print_r($data['records']); exit;
        echo view('header', $data);
        echo view('mofa/visa_not_printed', $data);
        echo view('footer', $data);
    }

    public function visa_issued()
    {
        $data = $this->data;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();

        $listMofa = new MofaProcess();
        $data['records'] = $listMofa->VisaIssued();
        // echo "<pre>";
        // print_r($data['records']); exit;
        echo view('header', $data);
        echo view('mofa/visa_issued', $data);
        echo view('footer', $data);
    }

    public function visa_details()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('mofa/visa_details', $data);
        echo view('footer', $data);
    }


    public function fetch_visa_details()
    {
        $data = $this->data;

        $Crud = new Crud();
        $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
        $LookupsOptions='';
        foreach ($data['LookupsOptions'] as $options) {
            $LookupsOptions.='<option value=' . $options['UID'] . '>' . $options['Name'] . '</option>';
                                    }
        $Pilgrims = new Pilgrims();
        $records = $Pilgrims->get_visa_details_datatables();
        $totalfilterrecords = $Pilgrims->count_visa_details_filtered();
        $dataList = array();
        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $cnt++;
            $sub_array = array();
            $sub_array['DT_RowId']= 'RowNo_'.$cnt;
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/P/', $record['UID']);

            $actions = '<button id="multiple-reset" class="btn btn-primary" type="button" onclick="VisaDetailsSubmit(\'PilgrimVisaAssignForm\','.$cnt.');" style="margin-bottom: 10px;">Update </button>';

            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Country'];

            $sub_array[] = $Statuses[$record['CurrentStatus']];
            $sub_array[] = '<div class="form-group"><input type="hidden" class="form-control" id="UID" name="UID" value="' . $record['UID'] . '">
                                     <input type="text" class="form-control" id="VisaNumber" name="Visa[' . $record['UID'] . '][Number]" style="width: 100px;"></div>';
            $sub_array[] = '<div class="form-group"><input type="date" class="form-control" id="VisaIssueDate" name="Visa[' . $record['UID'] . '][IssueDate]" style="width: 170px;"></div>';
            $sub_array[] = '<div class="form-group">
                                    <select class="form-control" id="VisaType" name="Visa[' . $record['UID'] . '][Type]">'.$LookupsOptions.'
                                    </select>';
            if($data['CheckAccess']['umrah_activity_visa_management_manage_visa_update']){
                $sub_array[] = $actions;
            }else{
                $sub_array[] = '-';
            }

            $dataList[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    /** Jawad Code Start*/

    public
    function fetch_manage_mofa_record(){

        $data = $this->data;

        $dataList = array();
        $listMofa = new MofaProcess();
        /*$data['records'] = $listMofa->GetMOFAlist();*/

        $records = $listMofa->get_manage_mofa_datatables();
        $totalfilterrecords = $listMofa->count_manage_mofa_filtered();

        foreach ($records as $record) {

            $cnt++; $sub_array = array();

            $AgentDropDown = '<div class="form-group pull-right">
                                <select onchange="MOFAFileAssign(this.value, '.$record['UID'].');"
                                        class="form-control" title="Agents" id="Agents'.$record['UID'].'"
                                        name="Agents">
                                        '.$data['AgentsExceptSubAgents']['html'].'
                                </select>
                            </div>';

            $sub_array[] = '<label class="new-control new-checkbox checkbox-primary"
                                   style="height: 18px; margin: 0 auto;">
                                <input type="checkbox" class="new-control-input todochkbox"
                                       id="chk'.$record['UID'].'" data-mufaid="'.$record['UID'].'">
                                <span class="new-control-indicator"></span>
                            </label>';
            $sub_array[] = $AgentDropDown;
            $sub_array[] = $record['Operator'];
            $sub_array[] = $record['ExtAgent'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PKGCode'];
            $sub_array[] = $record['PrintDate'];
            $sub_array[] = $record['PilgrimName'];
            $sub_array[] = $record['PilgrimID'];
            $sub_array[] = $record['Age'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PassportNo'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['IssueDateTime'];
            $sub_array[] = $record['Embassy'];
            $sub_array[] = $record['Relation'];
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['Address'];
            $sub_array[] = $record['SubAgentName'];
            $sub_array[] = $record['MOINumber'];
            $sub_array[] = $record['INSURANCE_POLICY_ID'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    /** Jawad Code ENDS*/

}
