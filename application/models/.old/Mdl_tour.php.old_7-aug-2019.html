<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Mdl_tour extends MY_Model{
    protected $_tb_tour = "tbl_tour";
    protected $_tb_seo = "seo";
    


    public $today;

    public $ip;
    public $os;
    public $browser;

    public $user_name;
    public $user_id;

    function __construct() {
        parent::__construct();
        $this->today = date("Y-m-d",time());

        $this->user_name = $this->getUserName();
        $this->user_id = $this->getUserId();
        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();
    }


    function getTour($where=false,$limit=false,$offset=false){

        if(!$where):
            $get = $this->db
                    ->order_by("date_create","DESC") 
                    ->get($this->_tb_tour,$limit,$offset);
        else:
            $get = $this->db
                    ->where($where)
                    ->order_by("date_create","DESC") 
                    ->get($this->_tb_tour,$limit,$offset);
        endif;
        return $get;
    }
    //----

    //---11-1-19 get Tour item with seo
    function seoGetTour($w){
        $where = array(
            "{$this->_tb_tour}.t_id" => $w
        );

        $j1 = "{$this->_tb_seo}.kw_id = {$this->_tb_tour}.kw_id";
        $get = $this->db
                    ->join($this->_tb_tour,$j1)
                    ->where($where)
                    ->get($this->_tb_seo);
        
       return $get;
        
    }

    //---saveTour
    function saveTour($data,$where=false){
        $save = 0;
        $t_id = 0;
        if(!$where):
            $save = $this->saveTB($this->_tb_tour,$data);
            $t_id = $save;
        else:
            $save = $this->saveTB($this->_tb_tour,$data,$where);
            $t_id = $where["t_id"];
        endif;

        return $t_id;
    }

    //----delTour
    function delTour($where){
        $this->delTB($this->_tb_tour,$where);
        return true;
    }
    

    


   
    
    

    
    

}//end of Mdl_tour

