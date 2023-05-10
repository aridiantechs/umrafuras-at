<?php namespace App\Controllers;

use App\Models\Admin;
use App\Models\Api;
use App\Models\Crud;
use App\Models\Groups;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Users;
use App\Models\Agents;
use App\Models\Voucher;
use App\Models\Website;


class Web_form_process extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        if ($this->data['module'] != 'form_process' && $this->data['page'] != 'system_user_form_submit') {
            $session = session();
            $this->MainModel->CheckUser($session->get());
        }
    }

    public
    function content_form_submit()
    {
//        $data = $this->data;
        // echo "<pre>"; print_r($_POST);

        $UID = $this->request->getVar('UID');
        $DomainID = $this->request->getVar('DomainID');
        $physical = $this->request->getVar('physical');
        $SeoTitle = $this->request->getVar('SeoTitle');
        $MetaDesc = $this->request->getVar('MetaDesc');
        $MetaKeywords = $this->request->getVar('MetaKeywords');
        $contentTitle = $this->request->getVar('contentTitle');
        $Description = $this->request->getVar('Description');
        $showOnFooter = $this->request->getVar('showOnFooter');

        $ContentDataSubmit = new Website();
        $records = array();
        $records['PagePhysical'] = $physical;
        $records['Title'] = $contentTitle;
        $records['Description'] = $Description;
        $records['SeoTitle'] = $SeoTitle;
        $records['SeoMetaKeywords'] = $MetaKeywords;
        $records['SeoDescription'] = $MetaDesc;
        $records['DomainID'] = $DomainID;
        $records['ShowOnFooter'] = $showOnFooter;
        // print_r($records); exit;

        $ContentDataSubmit->ContentFormSubmit($records, $UID);
    }

    public
    function meta_content_form_submit()
    {
//        $data = $this->data;
        // echo "<pre>"; print_r($_POST); exit;

        $Key = $this->request->getVar('Key');
        $DomainID = $this->request->getVar('DomainID');
        $MetaContent = $this->request->getVar('Meta');

        $MetaContentDataSubmit = new Website();
        $records = array();
        $records['PagePhysical'] = $Key;
        $records['DomainID'] = $DomainID;
        $records['MetaContent'] = $MetaContent;
        // print_r($records); exit;

        $MetaContentDataSubmit->MetaContentFormSubmit($records);
    }

    public
    function remove_content()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Website();
        $DltOperator->DeleteContent($UID);
    }

}
