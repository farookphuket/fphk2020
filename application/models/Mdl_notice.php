<?php 



class Mdl_notice extends MY_Model{

    protected $user_id;
    public $user_name;
    protected $is_login;
    protected $is_admin;

    protected $_tb_notice = "tbl_notification";

    function __construct(){
        parent::__construct();
    }


    function getNotice($where=false,$limit=false,$offset=false){

        $get = "";
        if(!$where):
            $get = $this->db 
                                ->order_by("notice_date","DESC")
                                ->limit($limit,$offset)
                                ->get($this->_tb_notice);
        else:
            $get = $this->db 
                                ->order_by("notice_date","DESC")
                                ->where($where)
                                ->limit($limit,$offset)
                                ->get($this->_tb_notice);
        endif;
        return $get;
    }

    //--------------------------
    //-----markAllAsRead
    function markAllAsRead($data,$where=false){
        $save = 0;
        if(!$where):
            $save = $this->db
                                ->update($this->_tb_notice,$data);
        else:
            $save = $this->db
                                ->where($where)
                                ->update($this->_tb_notice,$data);
        endif;
    }



}