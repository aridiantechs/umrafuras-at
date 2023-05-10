<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Main;
use App\Models\Users;

class Visitor extends BaseController
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

    public function visitors()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/visitors', $data);
        } else {
            echo view('visitor/visitors', $data);

        }
        echo view('footer', $data);
    }

    public function unique_visitor()
    {
        $data = $this->data;

        $data['Link'] = getSegment(3);


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/unique_visitor', $data);
        } else {

            echo view('visitor/unique_visitor', $data);
        }
        echo view('footer', $data);
    }

    public function old_visitor()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/old_visitor', $data);
        } else {

            echo view('visitor/old_visitor', $data);
        }
        echo view('footer', $data);
    }

    public function confirm_visitor()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/confirm_visitor', $data);
        } else {

            echo view('visitor/confirm_visitor', $data);
        }
        echo view('footer', $data);
    }

    public function not_interested_visitor()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/not_interested_visitor', $data);
        } else {

            echo view('visitor/not_interested_visitor', $data);
        }
        echo view('footer', $data);
    }

    public function subscribers()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/subscribers', $data);
        } else {

            echo view('visitor/subscribers', $data);
        }
        echo view('footer', $data);
    }


    public function wallet()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('visitor/wallet', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('visitor/inbox', $data);
        echo view('footer', $data);
    }

    public function query()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('visitor/query', $data);
        echo view('footer', $data);
    }

    public function users()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('visitor/users', $data);
        echo view('footer', $data);
    }


    public function detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/reports/detail_report', $data);
        } else {

            echo view('visitor/reports/detail_report', $data);
        }
        echo view('footer', $data);
    }


    public function country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/reports/country_wise', $data);
        } else {

            echo view('visitor/reports/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function successful_product_wise_visitor()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/reports/successful_product_wise', $data);
        } else {

            echo view('visitor/reports/successful_product_wise', $data);
        }
        echo view('footer', $data);
    }

    public function unsuccessful_product_wise_visitor()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/reports/unsuccessful_product_wise', $data);
        } else {

            echo view('visitor/reports/unsuccessful_product_wise', $data);
        }
        echo view('footer', $data);
    }


    public function product_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('visitor/reports/product_wise', $data);
        echo view('footer', $data);
    }

    public function month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/reports/month_wise', $data);
        } else {

            echo view('visitor/reports/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/visitor/reports/year_wise', $data);
        } else {

            echo view('visitor/reports/year_wise', $data);
        }
        echo view('footer', $data);
    }


}
