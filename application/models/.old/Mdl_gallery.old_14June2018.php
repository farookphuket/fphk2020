<?php

class Mdl_gallery extends MY_Model{
    protected $_tb_gall = "gallery_1";
    protected $_order_by;


    public $ip;
    public $browser;
    public $os;

    public $user_name;
    public $user_id;

    function __construct(){
        parent::__construct();

        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();
        $this->user_name = $this->getUserName();
        $this->user_id = $this->getUserId();
        
    }

    //---get pic
    function get($where=false,$limit=false,$offset=false){
        $get = 0;
        if($where):
            $get = $this->db
                        ->where($where)
                        ->order_by("date_add","DESC")
                        ->get($this->_tb_gall,$limit,$offset);
        else:
            $get = $this->db
                        ->order_by("date_add","DESC")
                        ->get($this->_tb_gall,$limit,$offset);
        endif;

        return $get;
    }

    //--save function 
    function save($data,$where=false){
        $save = 0;
        $g_id = 0;
        if($where):
            $save = $this->saveTB($this->_tb_gall,$data,$where);
            $g_id = $where["pic_id"];
        else:
            $save = $this->saveTB($this->_tb_gall,$data);
            $g_id = $save; 
        endif;
        return $g_id;
    }
    

}//end of file
