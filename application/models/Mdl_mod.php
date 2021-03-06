<?php

class Mdl_mod extends MY_Model{




        protected $is_login;
        protected $is_admin;
        protected $moderate;

        //---table to call
        protected $_tb_user = "users";

        public $os;
        public $ip;
        public $browser;
        public $user_name;
        public $user_id;
        public $user_type;

        public function __construct(){
            parent::__construct();

            $this->user_name = $this->getUserName();
            $this->user_type = $this->getUserType();
            $this->user_id = $this->getUserId();
            //--table user
            //$this->_tb_user = $this->Mdl_users->_tb_user;
        }


        //-----
        //----GET_PROFILE
        function GET_PROFILE(){
          $where = array("{$this->_tb_user}.id" => $this->user_id);
          $get = $this->Mdl_users->GET_USER($where)->result();
          return $get;
        }
        //----------
        //---modCheckPass
        function modCheckPass(){
          $p = $this->getEl("passConf");
          $confPass = $this->make_hash($p);

          $where = array(
            "{$this->_tb_user}.id" => $this->user_id,
            "{$this->_tb_user}.passwd" => $confPass
          );
          $get = $this->Mdl_users->GET_USER($where)->result();
          $num = count($get);
          $data = array("match" => $num);
          return $data;
        }

        //----
        //----- saveMyProfile
        function saveMyProfile(){
          $user_id = $this->getEl("mId");
          $user_name = $this->getEl("mName");
          $user_email = $this->getEl("mEmail");
          $user_tel = $this->getEl("mTel");
          $user_about = $this->getEl("about_user");
          $nP = $this->getEl("newPass");
          $newPass = $this->make_hash($nP);
          $data = array(
            "new_pass" => $newPass
          );
          return $data;
        }





}//end of the file
