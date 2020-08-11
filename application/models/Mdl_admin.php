<?php

class Mdl_admin extends MY_Model{

        
        
        protected $_tb_ar = "tbl_article";
        protected $_tb_cat = "tbl_cat";
        protected $_tb_user = "users";
        protected $_tb_notic = "tbl_notification";

        public function __construct(){
            
            parent::__construct();
        }

        function getNotice($where=false,$limit=false,$offset=false){
            $get = 0;
            if($where):
                $get = $this->db
                            ->where($where)
                            ->order_by("notice_date","desc")
                            ->limit($limit,$offset)
                            ->get($this->_tb_notic);
            else:
                $get = $this->db 
                        ->order_by("notice_date","desc")
                        ->limit($limit,$offset)
                        ->get($this->_tb_notic);
            endif;
            
            return $get;
        }
        //---------------------
        

}//end of the file 
