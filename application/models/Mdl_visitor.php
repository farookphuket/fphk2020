<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Mdl_visitor extends MY_Model{

    protected $_tb_visit = "tbl_visiter";

    public $ip;
    public $os;
    public $browser;

    public $user_name;
    public $user_id;

    public $today;
    public $month_number;
    public $year_number;
    public $cur_ip;

    function __construct(){
        parent::__construct();

        $this->user_id = $this->getUserId();
        $this->user_name = $this->getUserName();
        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();

        $this->today = date("Y-m-d ",time());
        $this->month_number = date("m",time());
        $this->year_number = date("Y",time());
        $this->cur_ip = $this->ip;
    }


    //---


    function getVisitor(){
        //-- last update 14-Dec-2019
        $get = 0;
        
        //-- get the last visitor of this ip from the database
        

        $num_all = $this->getAllVisitor();
        $num_year = $this->getYearVisitor();
        $num_month = $this->getMonthVisitor();
        $get_today = $this->getTodayVisitor();
        $num_today = $get_today["num_today"];
        $r_data = array(
            "num_all" => $num_all,
            "num_year" => $num_year,
            "num_month" => $num_month,
            "num_today" => $num_today,
        );
        return $r_data;
    }

    function getTodayVisitor(){
        $where = array(
            "v_cur_visit_date" => $this->today,
            "v_last_visit_date" => $this->today,
            "v_ip" => $this->ip
        );
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_visit)->result();
        $num = count($get);
        if($num == 0):
            //--- this ip has not been here today
            //--then record it
            $this->saveVisitor();
            //--- 
        else:
        $where = array(
            "v_cur_visit_date" => $this->today
        );
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_visit)->result();
        $num = count($get);

        endif;

        

        $r_data = array(
            "num_today" => $num
        );
        return $r_data;
    }
    //---------------------
    function getMonthVisitor(){
        $where = array(
            "v_month" => $this->month_number
        );
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_visit)->result();
        $num = count($get);
        return $num;

    }
    //------------------------
    function getYearVisitor(){
        $where = array(
            "v_year" => $this->year_number
        );
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_visit)->result();
        $num = count($get);
        return $num;

    }

    //------------------
    //-- get all visitor 
    //------------------------
    function getAllVisitor(){
        $get = $this->db
                    ->get($this->_tb_visit)->result();
        $num = count($get);
        return $num;

    }

    function saveVisitor(){
        
        //--- record the current ip to the database
        $get = 0;

        //-- check the current ip visitor
        $where = array(
            "v_last_visit_date " => $this->today,
            "v_cur_visit_date " => $this->today,
            "v_ip" => $this->ip
        );
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_visit)->result();
        $num = count($get);

        //--- var for update
        $v_id = 0;
        $last_visit_count = 0;

        if($num == 0):
            //--- this ip never been here today then record this ip
            $v_data = array(
                "v_ip" => $this->ip,
                "v_browser" => $this->browser,
                "v_os" => $this->os,
                "v_month" => $this->month_number,
                "v_year" => $this->year_number,
                "v_cur_visit_date" => $this->today,
                "v_cur_visit_time" => $this->today_andTime,
                "v_last_visit_date" => $this->today,
                "v_last_visit_time" => $this->today_andTime,
                "v_num_time" => 1
            );
            $this->SAVE($v_data,$this->_tb_visit);

        else:
            //--- found this ip so update the table
            foreach($get as $row):
                $last_visit_count = $row->v_num_time;
                $v_id = $row->v_id; 
            endforeach;
        $last_visit_count++;
        $v_data = array(
            "v_num_time" => $last_visit_count,
            "v_last_visit_time" => $this->today_andTime,
            "v_cur_visit_time" => $this->today_andTime,
        );
        $this->SAVE($v_data,$this->_tb_visit,array("v_id" => $v_id));
        endif;
    
    }

    /*
     *  Admin Section
     */ 
    function adminList($where=false,$limit=false,$offset=false){
        $get = "";
        if(!$where):
            $get = $this->db
                    ->order_by("v_last_visit_time","DESC")
                    ->get($this->_tb_visit,$limit,$offset);
            else:
                $get = $this->db
                    ->where($where)
                    ->order_by("v_last_visit_time","DESC")
                    ->get($this->_tb_visit,$limit,$offset);

            endif;

        return $get;
    }


}//end of file
