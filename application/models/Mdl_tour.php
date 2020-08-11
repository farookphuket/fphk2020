<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Mdl_tour extends MY_Model{
    protected $_tb_tour = "tbl_tour";
    protected $_tb_seo = "seo";
    protected $_tb_user = "users";



    public $today;

    public $ip;
    public $os;
    public $browser;

    public $user_name;
    public $user_email;
    public $user_id;

    function __construct() {
        parent::__construct();
        $this->today = date("Y-m-d",time());

        $this->user_name = $this->getUserName();
        $this->user_email = $this->getUserEmail();
        $this->user_id = $this->getUserId();
        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();
    }


    function find($where){
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_tour);
        return $get;
    }

    function all(){
        $get = $this->db
                    ->order_by("t_create","DESC")
                    ->get($this->_tb_tour);
        return $get;
    }




    function getTour($where=false,$limit=false,$offset=false){

        //--- need to join table
        $j1 = "{$this->_tb_tour}.user_id={$this->_tb_user}.id";
        $j2 = "{$this->_tb_tour}.kw_id={$this->_tb_seo}.kw_id";

        if(!$where):
            $get = $this->db
                    ->order_by("{$this->_tb_tour}.t_date_create","DESC")
                    ->join($this->_tb_user,$j1)
                    ->join($this->_tb_seo,$j2)
                    ->get($this->_tb_tour,$limit,$offset);
        else:
            $get = $this->db
                    ->join($this->_tb_user,$j1)
                    ->join($this->_tb_seo,$j2)
                    ->where($where)
                    ->order_by("{$this->_tb_tour}.t_date_create","DESC")
                    ->get($this->_tb_tour,$limit,$offset);
        endif;
        return $get;
    }
    //----

    
    
    
    
    

    /*
     *  Admin section
     */

    function adminSave(){
        $action_id = $this->getEl("action_id"); //--- from the user session
        
        $t_id = $this->getEl("t_id");

        //---   seo key tag
        $og_url = "";
        $keyword = $this->getEl("keyword");
        $keydes = $this->getEl("keydes");
        $kw_id = $this->getEl("kw_id");

        //---   price location duration
        $full_price = $this->getEl("full_price");
        $location = $this->getEl("location");
        $duration = $this->getEl("duration");
        
        
        $title = $this->getEl("title");
        $summary = $this->getEl("tour_summary");
        $body = $this->getEl("tour_detail");

        $draft = $this->getEl("mark_draft");
        if(!$draft):
            $draft = 0;
        else:
            $draft = 2;
       endif; 

        $og_data = array(
            "kw_page_keyword" => $keyword,
            "kw_page_des" => $keydes,
            "og_title" => $keyword,
            "og_description" => $keydes,
            "article_publisher" => $this->user_name
        );

        $t_data = array(
            "t_name" => $title,
            "t_summary" => $summary,
            "t_program" => $body,
            "t_duration" => $duration,
            "t_destination" => $location,
            "mark_draft" => $draft,
            "full_price" => $full_price
        );

        if(!$action_id):
            $msg = "Error : There is no action id";
        else:
            


            if(!$t_id):
                //---- new program

                $kw_id = $this->SAVE($og_data,$this->_tb_seo);
                $t_data["user_id"] = $this->user_id;
                $t_data["kw_id"] = $kw_id; 
                $t_id = $this->SAVE($t_data,$this->_tb_tour);

                $og_url = site_url("tour/detail/{$t_id}");
                $og_up = array(
                    "kw_canonical" => $og_url,
                    "og_url" => $og_url,
                    "og_type" => "service : tour",
                    "og_site_name" => site_url()
                );
                $this->SAVE($og_up,$this->_tb_seo,array("kw_id" => $kw_id));
                $t_up = array(
                    "kw_id" => $kw_id
                );
                $this->SAVE($t_up,$this->_tb_tour,array("t_id" => $t_id));


                $msg = "Success : program has been created @{$t_id} the draft is {$draft}"; 
            else:

                unset($og_data["article_publisher"]);
                $this->SAVE($og_data,$this->_tb_seo,array("kw_id" => $kw_id));
                $t_data["t_update"] = $this->today_andTime;
                $this->SAVE($t_data,$this->_tb_tour,array("t_id" => $t_id));
                
                $msg = "Success : program has updated @{$t_id} draft is {$draft}"; 
            endif;
         
        endif;

        
        $r_data = array(
            "msg" => $msg,
            "t_id" => $t_id
        );

        return $r_data;
    } 
    //----------------------------
    //---   adminDel
    function adminDel($id){
        $kw_id = 0;
        $t_id = 0;
        $get = $this->getTour($id)->result();
        foreach($get as $row):
            $kw_id = $row->kw_id;
            $t_id = $row->t_id;
        endforeach;
            
            $this->DEL(array("t_id" => $t_id),$this->_tb_tour);
            $this->DEL(array("kw_id" => $kw_id),$this->_tb_seo);
            $r_data = array("msg" => "success : data has been removed");
           return $r_data; 

    }



}//end of Mdl_tour
