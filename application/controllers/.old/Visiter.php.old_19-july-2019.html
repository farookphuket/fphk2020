<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Visiter extends MY_Controller{

    protected $_tb_visit = "tbl_visiter";


    public $ip;
    public $os;
    public $browser;

    public $user_name;
    public $user_id;

    public $today;
    public $today_time;
    public $today_month;
    public $today_year;
    public $cur_ip;


    function __construct(){
        parent::__construct();
        $this->load->model("Mdl_visiter");
        $this->user_name = $this->Mdl_visiter->getUserName();
        $this->user_id = $this->Mdl_visiter->getUserId();

        $this->os = $this->Mdl_visiter->getOS();
        $this->browser = $this->Mdl_visiter->getBrowser();
        $this->ip = $this->Mdl_visiter->getIP();

        $this->today = date("Y-m-d",time());
        $this->today_month = date("m",time());
        $this->today_year = date("Y",time());
        $this->today_time = date("Y-m-d h:i:s",time());
        $this->cur_ip = $this->ip;
    }

    function index(){
        
    }

    function summary(){

        $data = array();

        $data["ap_name"] = $this->getAppName();
        $data["ap_version"] = $this->getAppVersion();
        
        $v_data = array(
            "v_ip" => $this->cur_ip,
            "v_user_id" => $this->user_id,
            "v_user_name" => $this->user_name,
            "v_browser" => $this->browser,
            "v_os" => $this->os,
            "v_month" => $this->today_month,
            "v_year" => $this->today_year,
            "v_last_visit_date" => $this->today,
            "v_last_visit_time" => $this->today_time,
            "v_cur_visit_date" => $this->today,
            "v_cur_visit_time" => $this->today_time,
            "v_num_time" => 1

        );
        $save = $this->Mdl_visiter->saveVisiter($v_data);

        
        //--how many ip view today
        $v_all = $this->Mdl_visiter->getVisiter()->result();
        $data["all_visit"] = count($v_all);
        
        
        //--how many ip view today
        $v_today = $this->Mdl_visiter->getVisiter(
            array(
                "v_cur_visit_date" => $this->today,
                "v_ip" => $this->ip
                )
        )->result();
        $data["today_visit"] = count($v_today);

        $v_month = $this->Mdl_visiter->getVisiter(
            array(
                "v_month" => $this->today_month
                )
        )->result();
        $data["month_visit"] = count($v_month);

        $v_year = $this->Mdl_visiter->getVisiter(
            array(
                "v_year" => $this->today_year
                )
        )->result();
        $data["year_visit"] = count($v_year);


        
        
        
        $this->output->set_output(json_encode($data));
        
    }

    function getAppVersion(){
        $ver = "1.0";
        return $ver;
    }

    function getAppName(){

        $ap_name = "Visitor Count";
        return $ap_name;
    }


}