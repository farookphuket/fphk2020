<?php

    class Mdl_cat extends MY_Model{

        
        
        protected $_tb_cat = "tbl_cat";
        protected $_tb_user = "users";


        public function __construct(){
            
            parent::__construct();
        }


        function saveCat($data,$where=false){

            $cat_id = "";
            if(!$where):
                $save = $this->saveTB($this->_tb_cat,$data);
                $cat_id = $save;
            else:
                $save = $this->saveTB($this->_tb_cat,$data,$where);
                $cat_id = $where["cat_id"];
            endif;
            return $cat_id;
        }

        function getCat($where=false){
            $get = "";
            if(!$where):
                $get = $this->getTB($this->_tb_cat);
            else:
                $get = $this->getTB($this->_tb_cat,$where);
            endif;
            return $get;
        }



}//end of the file 
