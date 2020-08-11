<?php

    class Mdl_booking extends MY_Model{

        
        
        //protected $_tb_ar = "tbl_article";
        //protected $_tb_cat = "tbl_cat";
        protected $_tb_booking = "tbl_booking";
        protected $_payment_info = "tbl_booking_payment_info";
        protected $_user_info = "tbl_booking_user_info";

        protected $_tb_tour = "tbl_tour";
        protected $_tb_notice = "tbl_notification";

        //protected $user_id;
        
        //----public
        public $ip;
        public $browser;
        public $os;
        public $user_name;
        public $user_id;


        public function __construct(){
            parent::__construct();

            $this->ip = $this->getIP();
            $this->os = $this->getOS();
            $this->browser = $this->getBrowser();
            $this->user_name = $this->getUserName();
            $this->user_id = $this->getUserId();
            //$this->user_type = $this->get_userType();
        }


    //--getBooking
    function getBooking($where=false,$limit=false,$offset=false){
        $get = 0;
        if(!$where):
            //get everything
            /*
            $get = $this->getTB($this->_tb_booking,null,$limit,$offset);
            comment out Fri 11 May 2018
            */
            $get = $this->db 
                    ->order_by("going_date","DESC")
                    ->limit($limit,$offset)
                    ->get($this->_tb_booking);
        else:
            /*
            $get = $this->getTB($this->_tb_booking,$where,$limit,$offset);
            */
            $get = $this->db 
                    ->order_by("going_date","DESC")
                    ->where($where)
                    ->limit($limit,$offset)
                    ->get($this->_tb_booking);
        endif;
        return $get;
    }
    //------------------

    ////////////////////////////////////
    /////////       15-jan-2019
    //////////////////////////////////////
    function calTourPrice($where){
        $get = $this->db
                         ->where($where)
                         ->get($this->_tb_tour);
        return $get;
    }

    
    
    
    
    //------save_booking
    function save_booking($data,$where=false){
        $id = 0;

        $save = "";
        if(!$where):
            $save = $this->saveTB($this->_tb_booking,$data);
            $id = $save;
        else:
            $save = $this->saveTB($this->_tb_booking,$data,$where);
            $id = $where["bk_id"];
        endif;

        return $id;
    }

    //----------------------
    function savePaymentInfo($data,$where=false){
        if(!$where):
            $this->saveTB($this->_payment_info,$data);
        else:
            $this->saveTB($this->_payment_info,$data,$where);
        endif;
    }
    //-------------------------
    //--------saveUserInfo------------
    function saveUserInfo($data,$where=false){
        if(!$where):
            $this->saveTB($this->_user_info,$data);
        else:
            $this->saveTB($this->_user_info,$data,$where);
        endif;

    }




    //-----------------------------------
    function delBooking($id){
        if($id):
            $this->delTB($this->_tb_booking,$id);
        else:
            return false;
        endif;
        return true;
    }


    //------------------------------------------------------------
    //----------------Admin and  moderate-----------------------------------
    function modGetAllBooking($where=false,$limit=false,$offset=false){

        $j1 = "{$this->_tb_booking}.bk_id={$this->_payment_info}.bk_id";
        $j2 = "{$this->_tb_booking}.bk_id={$this->_user_info}.bk_id";

        $get = "";
        
        if($where):
            $get = $this->db
                                    ->where($where)
                                    ->join("{$this->_payment_info}",$j1)
                                    ->join($this->_user_info,$j2)
                                    ->order_by("{$this->_tb_booking}.bk_date","DESC")
                                    ->limit($limit,$offset)
                                    ->get($this->_tb_booking);

        else:
            $get = $this->db
                                    ->join("{$this->_payment_info}",$j1)
                                    ->join($this->_user_info,$j2)
                                    ->order_by("{$this->_tb_booking}.bk_date","DESC")
                                    ->limit($limit,$offset)
                                    ->get($this->_tb_booking);
        endif;
        

        return $get;
        

    }


    //----------------------------
    
    //--------saveNotice 17 jan 19
    function saveNotice($data){
        $this->db
                ->set($data)
                ->insert($this->_tb_notice);
    }
   


}//end of the file 
