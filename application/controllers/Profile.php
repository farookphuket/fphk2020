<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {


    public $user_name;

    protected $is_login;
    protected $user_id;
    protected $user_email;
    protected $is_admin;
    protected $user_pass;
    protected $moderate;




    //the table name
    //edit on Thu 8 Jun 2017
    protected $_tb_user = "users";
    protected $_tb_notice = "tbl_notification";

    public $o_put;
    public $msg;
    public $today;
    public $user_type;
    public $ip;

    //---sys info
    public $sysName = "Profile";
    public $sysVersion = "1.0";
    public $sysDate = "12-Mar-2020";

  function __construct() {
    parent::__construct();

    //---load library
    $this->load->library("pagination");

    $this->load->model("Mdl_users");
    $this->load->model("Mdl_profile");

    //check the user session
    $this->is_login = $this->user_is_login();
    $this->user_name = $this->getUserName();
    $this->user_id = $this->getUserId();
    $this->is_admin = $this->user_is_admin();
    $this->user_email = $this->getUserEmail();
    $this->moderate = $this->user_is_mod();
    $this->user_type = $this->getUserType();


    //$this->u_data = $this->get_user_info();
    $this->ip = $this->Mdl_users->getIP();

    //----Wed 3 Oct 2018
    //$this->user_type = $this->user_type();
    $this->data["sysInfo"] = "{$this->sysName} version {$this->sysVersion}";

    $this->data["sysName"] = $this->sysName;
    $this->data["sysVersion"] = $this->sysVersion;
    $this->data["sysDate"] = $this->sysDate;

    }

    function index(){

        //if the user enter this page
        //the script will check the session

        //$command = $this->input->post("command");


        $url = "";
        if($this->is_login):
            $url = site_url("profile/u/");
            if($this->is_admin):
                $url = site_url("profile/admin");
              else:
                $url = site_url("profile/mod");
            endif;
          else:
            $url = site_url();
        endif;
        redirect($url);

    }//end of index


    



    //----
    function u(){

        if(!$this->is_login):
            redirect(site_url("users/logout"));
            exit();
        endif;
        //$this->data["user_id"] = $this->user_id;
        $this->data["subview"] = "users/profile/profile";
        $this->data["meta_title"] = "{$this->user_type_text}&nbsp;|&nbsp;welcome {$this->user_name}";
        $this->load->view("_MEMBER_TMP",$this->data);

    }
    //----------

    //--- userGetProfile
    function userGetProfile($id){
        $where = array("id" => $this->user_id);
        $get = $this->Mdl_users->find($where)->result();

        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));

    }
    //--------------
    //--- userProfileEdit
    function userProfileEdit($id){
        $get = $this->Mdl_users->find(array("id" => $id))->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));

    }
    //------------------------
    //----  userProfileSave
    function userProfileSave(){
        $s = $this->Mdl_profile->userProfileSave();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["error_code"] = $s["error_code"];
        $this->output->set_output(json_encode($this->o_put));
    }


    function userProfileSetActiveMe($user_id,$timeout){
        
        $time_now = strtotime($this->today_andTime);
        $time_left = ($timeout-$time_now);        

        $msg = "Error : exit code 1";
        $url = site_url("login");

        if($time_left <= 1):
            $msg = "<div class='alert alert-danger'><h1 class='text-center'>Error</h1>
<p>Error : your link has expired!</p>

</div>";
            $time_left = 0;
            $url = site_url("users/logout");
        else:
            $time_left = $time_left/60;
            
            $g = $this->Mdl_profile->userProfileSetActiveMe(array("id" => $user_id));
            $msg = $g["msg"];
            $url = $g["url"];

        endif;

        $time_send = date("Y-m-d H:i:s",$timeout);
        $time_show = date("Y-m-d H:i:s",$time_left);

        //$msg = "your time send is {$time_send} time show is {$time_show} min now the time left is {$time_left}";
        



        $this->data["timeout"] = $time_left;
        $this->data["is_login"] = $this->is_login;
        $this->data["msg"] = $msg;
        $this->data["url"] = $url;
        $this->data["subview"] = "users/profile/set_active_me";
        $this->data["meta_title"] = "RE-Activate my account";
        $tmp = "_MEMBER_TMP";
        $this->load->view($tmp,$this->data);
    }

    /*
     *  End of user
     *
     */
    
    
   


    ////End of mon-12-Sep-2016
    /*
    //| Add Moderate on 2-Aug-2019
    //|
    //| Update Delete user
    */
    //---mod 23-july-2019
    function mod(){
      if(!$this->moderate):
        redirect(site_url("users/logout"));
        exit();
      endif;
      $tmp = "_MOD_TMP";
      $this->data["subview"] = "Mod/users/user_index";
      $this->data["meta_title"] = "{$this->user_type} | {$this->sysName} version {$this->sysVersion}";
      $this->load->view($tmp,$this->data);
    }
    //------------------
    //---- modList
    function modList($seg=1){
      //$where = array();
      $get = $this->Mdl_users->modGetUser(null)->result();
      $num = count($get);

      //-- pagination
      $per_page = 4;
      $page = $seg;
      $url = "modList";
      $conf = $this->getConfPagin($per_page,$num,$url);
      $this->pagination->initialize($conf);
      $start = ($page-1)*$per_page;
      $get_user = $this->Mdl_users->modGetUser(null,$per_page,$start)->result();
      if($num > $per_page):
        $this->o_put["pagination"] = $this->pagination->create_links();
      endif;
      $this->o_put["get_all"] = $get;
      $this->o_put["get_user"] = $get_user;
      $this->output->set_output(json_encode($this->o_put));
    }
    //-----------------
    //----modEditUser
    function modEditUser($id){
      $get = $this->Mdl_users->GET_USER(array("{$this->_tb_user}.id" => $id))->result();
      $this->o_put["get"] = $get;
      $this->output->set_output(json_encode($this->o_put));
    }
    //---------------
    //------modSaveUser
    function modSaveUser(){
      $save = $this->Mdl_users->modSaveUser();
      $user_id = $save["user_id"];
      $this->o_put["user_id"] = $user_id;
      $this->output->set_output(json_encode($this->o_put));
    }
    //----------------
    //------modDelUser
    function modDelUser($id){
      $del = $this->Mdl_users->modDelUser(array("{$this->_tb_user}.id" => $id));
      //---return count row as last_num
      $last_num = $del["last_num"];
      $this->o_put["last_num"] = $last_num;
      $this->output->set_output(json_encode($this->o_put));
    }

    //---end of mod

    //----------------------------
    //-------adminListUser
    function adminListUser($seg=1){

      $where = array(
          "user_type !=" => 642,
          "id !=" => $this->user_id
      );
      $get = $this->Mdl_users->getUsers($where)->result();
      $num = count($get);

      //----pagination
      $per_page = 4;
      $url = "users/adminListUser";
      $conf = $this->getConfPagin($per_page,$num,$url);
      $this->pagination->initialize($conf);
      $page = $seg;
      $start = ($page-1)*$conf["per_page"];
      $get_user = $this->Mdl_users->getUsers($where,$conf["per_page"],$start)->result();

      if($num >= $per_page):
          $this->o_put["pagination"] = $this->pagination->create_links();
      endif;

      $this->o_put["get_users"] = $get_user;
      $this->o_put["get_all"] = $get;
      $this->o_put["num_user"] = $num;

      $this->output->set_output(json_encode($this->o_put));
    }
//---------------------------------
//--------modViewUser
function modViewUser($id){
    $where = array(
        "{$this->_tb_user}.id" => $id
    );
    $get_user = $this->Mdl_users->getUsers($where)->result();
    $name = "";
    foreach($get_user as $row):
        $name = $row->name;
        $this->data["name"] = $name;
        $this->data["u_id"] = $row->id;
    endforeach;
    $this->data["meta_title"] = "Show info of {$name}.";
    $this->data["subview"] = "admin/user/user_detail";
    $this->load->view("_DETAIL_TMP",$this->data);
}




//---------------admin
  function admin(){
    if(!$this->is_admin):
      redirect(site_url("users/logout"));
      exit();
    endif;
    $sysInfo = $this->data["sysInfo"];
    $tmp = "_ADMIN_TMP";
    $this->data["subview"] = "admin/user/user_index";
    $this->data["meta_title"] = "User System | {$sysInfo}";
    $this->load->view($tmp,$this->data);
  }







//---------adminEditUser---------
function adminEditUser($id){
    $where = array("id" => $id);
    $get = $this->Mdl_users->getUsers($where)->result();
    $this->o_put["get_user"] = $get;
    $this->output->set_output(json_encode($this->o_put));
}














//-----------end of admin section

}//end of the class users
