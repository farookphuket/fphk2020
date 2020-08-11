<?php

class Mdl_tmp extends MY_Model{

        
        
        protected $_tb_cat = "tbl_cat";
        protected $_tb_user = "users";
        protected $_tb_tmp = "tbl_template";

        public function __construct(){
            
            parent::__construct();
        }



        function getTmp($where=false,$limit=false,$offset=false){
            $j1 = "{$this->_tb_user}.id={$this->_tb_tmp}.tmp_user_id";
            $j2 = "{$this->_tb_cat}.cat_id={$this->_tb_tmp}.cat_id";

            $get = 0;
            if($where):
                $get = $this->db
                            ->join($this->_tb_user,$j1)
                            ->join($this->_tb_cat,$j2)
                            ->where($where)
                            ->order_by("tmp_date_create","DESC")
                            ->limit($limit,$offset)
                            ->get($this->_tb_tmp);
            else:
                $get = $this->db 
                        ->join($this->_tb_user,$j1)
                        ->join($this->_tb_cat,$j2)
                        ->order_by("tmp_date_create","DESC")
                        ->limit($limit,$offset)
                        ->get($this->_tb_tmp);
            endif;
            
            return $get;
        }
        //---------------------


        /*
         *  Admin Section
         */

        function adminSave(){
            $action_code = $this->getEl("action_code");
            $tmp_id = $this->getEl("tmp_id");
            $cat_id = $this->getEl("cat_id");

            $tmp_title = $this->getEl("tmp_title");
            $tmp_des = $this->getEl("tmp_des");
            $tmp_body = $this->getEl("tmp_body");
            $tmp_uri = $this->getEl("tmp_uri");

            $is_pub = $this->getEl("is_pub");
            !($is_pub)?$is_pub=0:$is_pub=2;

            $u_id = $this->getEl("tmp_user_id");
            if(!$u_id):
                $u_id = $this->user_id;
            endif;
            //--- 
            $tmp_data = array(
                "tmp_user_id" => $u_id,
                "tmp_uri" => $tmp_uri,
                "cat_id" => $cat_id,
                "tmp_title" => $tmp_title,
                "tmp_des" => $tmp_des,
                "tmp_body" => $tmp_body,
                "tmp_show_pub" => $is_pub
            );

            $msg = "";

            if($this->user_id != $action_code):
                $msg = "Error : not a command!";
            else:
                //$msg = "The action code {$action_code} cat_id is {$cat_id}";
                if(!$tmp_id):
                    $tmp_id = $this->SAVE($tmp_data,$this->_tb_tmp);
                    $msg = "Success : Template has been created @{$tmp_id}";
                else:
                    $msg = "Updated @{$tmp_id} successfully!";
                    unset($tmp_data["tmp_date_create"]);
                    $this->SAVE($tmp_data,$this->_tb_tmp,array("tmp_id" => $tmp_id));
                endif;


            endif;
            $r_data = array(
                "msg" => $msg,
                "tmp_id" => $tmp_id
            );
            return $r_data;
        } 
        //---------------------
        //--- adminDel
        function adminDel($id){
            $this->DEL($id,$this->_tb_tmp);
            $r_data = array(
                "msg" => "Success : item has been removed"
            );
            return $r_data;
        }


}//end of the file 
