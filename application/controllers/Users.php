<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {


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
    public $sysName = "Users";
    public $sysVersion = "2.10";
    public $sysDate = "24-July-2019";

  function __construct() {
    parent::__construct();

    //---load library
    $this->load->library("pagination");

    $this->load->model("Mdl_users");

    //check the user session
    $this->is_login = $this->user_is_login();
    $this->user_name = $this->getUserName();
    $this->user_id = $this->getUserId();
    $this->is_admin = $this->user_is_admin();
    $this->user_pass = $this->session->userdata("user_pass");
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
            $url = site_url("users/u/");
            if($this->is_admin):
                $url = site_url("users/admin");
              else:
                $url = site_url("users/mod");
            endif;
          else:
            $url = site_url();
        endif;
        redirect($url);

    }//end of index


    /*
     *  Last edit 22-Dec-2019
     */
    function all(){
        $get = $this->Mdl_users->ALL()->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }





    //----
    function u(){

        if(!$this->is_login):
            redirect(site_url("users/logout"));
            exit();
        endif;
        //$this->data["user_id"] = $this->user_id;
        $this->data["subview"] = "users/member_summary";
        $this->data["meta_title"] = "{$this->user_type_text}&nbsp;|&nbsp;welcome {$this->user_name}";
        $this->load->view("_MEMBER_TMP",$this->data);

    }
    //----------
    //----editProfile 21-july-2019
    function editProfile(){
      $where = array("id" => $this->user_id);
      $get = $this->Mdl_users->getUsers($where)->result();
      $this->o_put["get"] = $get;
      $this->output->set_output(json_encode($this->o_put));
    }
    //----------------
    //----checkPass
    function checkPass(){
      $oPass = $this->input->post("oldPass");
      $c = $this->input->post("passConfirm");
      $confPass = $this->make_hash($c);
      if($confPass == $oPass):
        $msg = "success : STATUS is unlock!";
        $err = 0;
      else:
        $err = 1;
        $msg = "Error : wrong password!";
      endif;
      $this->o_put["error"] = $err;
      $this->o_put["msg"] = $msg;
      $this->output->set_output(json_encode($this->o_put));
    }
    //----------------
    //----saveMemberProfile
    function saveMemberProfile(){
      $id = $this->input->post("u_id");
      $name = $this->input->post("u_name");
      $oldPass = $this->input->post("oldPass");
      $p = $this->input->post("newPass");
      $email = $this->input->post("u_email");
      $tel = $this->input->post("u_tel");
      $about = $this->input->post("u_about");

      $newPass = $this->make_hash($p);

      $msg = "";
      $err = 0;

      if(empty($p)):
        $p = $oldPass;
        //$msg = "Old pass = [{$oldPass}] not change";
      else:

        $p = $newPass;
        //$msg = "change from {$oldPass} to new pass = [{$p}] will change ";
      endif;
      $u_data = array(
        "name" => $name,
        "email" => $email,
        "passwd" => $p,
        "tel" => $tel,
        "about_user" => $about,
        "is_activated" => 0
      );
      $this->Mdl_users->saveUser($u_data,array("id" => $id));
      //---update user then send him an email activate link
      $active_url = site_url("register/cmdActiveUser/{$id}");
      $uMailTitle = "Dear {$name} you just update your profile";
      $uMailBody = "<div style='border:1px dashed #ff0000;'>
      <h1 style='text-align:center;color:green;'>
      Dear {$name} you just update your profile.
      </h1>
      <p>
      you have receive this e-mail because you just have update your profile<br />
      once this process has done you need to re-activate your account by click on the link below.
      </p>
      <p>
      <a href='{$active_url}' target='_blank'>Activate My Account</a>
      </p>
      <p style='text-align:right;'>
      best regards.
      </p>
      <p style='text-align:right;'>
       {$this->admin_email}
      </p>
      </div>";
      $this->sendMailTo(null,$email,$uMailTitle,$uMailBody);
      //$this->o_put["error"] = $err;
      $msg = "Success : your profile has been update,please check your email and login again";
      $this->o_put["msg"] = $msg;
      //---user have to login again after make change
      $this->o_put["url"] = site_url("users/logout");
      $this->output->set_output(json_encode($this->o_put));
    }

    


    //no need to edit
    function logout(){

        $user_data = array("user_name","user_id","is_login","is_admin");
        $this->session->unset_userdata($user_data);
        $this->session->sess_destroy();
        redirect(site_url());
    }
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
//---------adminEditUser
function adminSaveUser(){

    $user_name = $this->input->post("user_name");
    $user_id = $this->input->post("user_id");
    $user_email = $this->input->post("user_email");
    $user_tel = $this->input->post("user_tel");
    $user_pass = $this->make_hash("1234");

    $user_ban = ($user_ban = $this->input->post("user_ban"))?$user_ban = 2: $user_ban = 0;

    $user_active = ($user_active = $this->input->post("user_active"))?$user_active = 2: $user_active = 0;

    $user_mod = ($user_mod = $this->input->post("user_mod"))?$user_mod = 2: $user_mod = 0;

    $about_user = $this->input->post("about_user");

    $user_data = array(
        "name" => $user_name,
        "passwd" => $user_pass,
        "email " => $user_email,
        "tel" => $user_tel,
        "user_type" => 409,
        "moderate" => $user_mod,
        "is_activated" => $user_active,
        "is_ban" => $user_ban,
        "date_register" => $this->today,
        "about_user" => $about_user
    );


   if(!$user_id):
        if($this->getExitUserName($user_name)):
            //---make sure that this user name is not exit then create new user
            $msg = "Error : This user name {$user_name} is exit! ";
        else:
            $save = $this->Mdl_users->saveUser($user_data);
            $user_id = $save;
            $msg = "Success : The user name {$user_name } is created!";

        endif;

    else:
        //---update this user
        unset($user_data["date_register"]);
        unset($user_data["about_user"]);
        unset($user_data["passwd"]);
        $user_data["last_update"] = $this->today;
        $user_id = $user_id;
        $save = $this->Mdl_users->saveUser($user_data,array("id" => $user_id));
        $msg = "Success : data of {$user_name} has been updated";
   endif;


    $this->o_put["msg"] = $msg;
    $this->o_put["user_id"] = $user_id;
    $this->output->set_output(json_encode($this->o_put));
}
//---------------
//-------adminDelUser
function adminDelUser($id){
    $where = array("id" => $id);
    $get = $this->Mdl_users->getUsers($where)->result();

    $name = "";
    $email = "";
    $u_id = "";
    foreach($get as $row):
        //---for the future improve
        $name = $row->name;
        $email = $row->email;
        $u_id = $row->id;
    endforeach;
    $this->Mdl_users->delUser(array("id" => $u_id));
    $this->o_put["msg"] = "Success : user name {$name} has been deleted!";
    $this->o_put["user_id"] = $u_id;

    $this->output->set_output(json_encode($this->o_put));
}

function getExitUserName($name){
    $where =    /*
    End of private method

*/
/*
    confirm the password before process
*/ array(
        "name" => $name
    );
    $get = $this->Mdl_users->getUsers($where)->result();
    $num = count($get);
    $repeat = 0;
    if($num):
        $repeat = 1;

    endif;
    return $repeat;
}

//-----------end of admin section

}//end of the class users
