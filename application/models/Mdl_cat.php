<?php

    class Mdl_cat extends MY_Model{

        
        
        protected $_tb_cat = "tbl_cat";
        protected $_tb_user = "users";


        public function __construct(){
            
            parent::__construct();
        }


        function all(){
            $get = $this->db
                        ->order_by("cat_date_create","DESC")
                        ->get($this->_tb_cat);
            return $get;
        }

        function find($where){
            $get = $this->db
                        ->where($where)
                        ->get($this->_tb_cat);
            return $get;
        }


        function getCat($where=false,$limit=false,$offset=false){
            $j1 = "{$this->_tb_user}.id={$this->_tb_cat}.cat_user_id";
            $get  = "";

            if($where):
                $get = $this->db
                            ->join($this->_tb_user,$j1)
                            ->order_by("cat_date_create","DESC")
                            ->where($where)
                            ->get($this->_tb_cat,$limit,$offset);
            else:
                $get = $this->db
                            ->join($this->_tb_user,$j1)
                            ->order_by("cat_date_create","DESC")
                            ->get($this->_tb_cat,$limit,$offset);

            endif;

            return $get;
        }
        //---------------------
        //---   

        /*
         * ADMIN Section START 20-Feb-2020
         *
         */
        function adminSave(){
            $cat_id = $this->getEl("cat_id");
            $cat_uri = $this->getEl("cat_uri");
            $action_code = $this->getEl("action_code");


            //--- text field 
            $title = $this->getEl("cat_title");
            $section = $this->getEl("cat_section");
            $summary = $this->getEl("cat_sum");

            //--- the checkbox
            $allow_change = $this->getEl("allow_change");
            $is_pub = $this->getEl("is_pub");
            $allow_show = $this->getEl("allow_show");
            
            !($allow_change)?$allow_change = 0:$allow_change = 2;
            !($allow_show)?$allow_show = 0:$allow_show = 2;
            !($is_pub)?$is_pub = 0:$is_pub = 2;

            $cat_user_id = $this->getEl("cat_user_id");
            if(!$cat_user_id):
                $cat_user_id = $this->user_id;
            endif;

            $cat_data = array(
                "cat_title" => $title,
                "cat_uri" => $cat_uri,
                "cat_section" => $section,
                "cat_des" => $summary,
                "cat_show_public" => $is_pub,
                "admin_allow_show" => $allow_show,
                "allow_user_change" => $allow_change,
                "cat_user_id" => $cat_user_id
            );
            
            if($action_code != $this->user_id):
                $msg = "Error : command not found";
            else:
            
                if(!$cat_id):
                    //--- create
                    $cat_id = $this->SAVE($cat_data,$this->_tb_cat);
                    $msg = "Success : category has been created @{$cat_id}";

                else:
                    //--- update
                    $cat_data["cat_date_update"] = $this->today_andTime;
                    $this->SAVE($cat_data,$this->_tb_cat,array("cat_id" => $cat_id));          
                    $msg = "Success : category has been updated @{$cat_id}";
                endif;
            endif;




            $r_data = array(
                "msg" => $msg,
                "cat_id" => $cat_id
            );
            return $r_data;
        } 
        //------------------------
        //---   adminDel
        function adminDel(){
            $action_code = $this->getEl("action_code");
            $cat_id = $this->getEl("id");
            $msg = "";

            if($action_code || $action_code != $this->user_id):
                $this->DEL(array("cat_id" => $cat_id),$this->_tb_cat);
                $msg = "you action code is {$action_code} and the id is {$cat_id}";
            else:
                $msg = "Error : there is no action code";
            endif;
            $r_data = array(
                "msg" => $msg
            );
            return $r_data;
        }

        /*
         * ADMIN Section START 20-Feb-2020
         *
         */

        
}//end of the file 
