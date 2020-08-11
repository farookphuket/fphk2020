<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin extends MY_Controller{
    protected $user_id;
    protected $user_name;
    protected $is_login;
    protected $is_admin;

    public $o_put;


    protected $_tb_user = "users";

    function __construct() {
        parent::__construct();
		    $this->is_admin = $this->session->userdata("is_admin");
        $this->user_is_login();
        $this->user_id = $this->session->userdata("user_id");
        $this->user_is_admin();
        $this->user_name = $this->session->userdata("user_name");

        //Load the library..edit on Mon-31-July-2017
        $this->load->library("pagination");

        //Load the models
        $this->load->model("Mdl_users");
		    $this->load->model("Mdl_article");
        $this->load->model("Mdl_admin");
        $this->load->model("Mdl_cat");
        $this->load->model("Mdl_booking");
        $this->load->model("Mdl_faq");
        $this->load->model("Mdl_notice");
        if(!$this->is_admin):
            //echo"No Admin..";
            redirect(site_url("users/logout"));
            exit();
        endif;
    }


    function index(){
        if($this->is_admin):
            redirect(site_url("admin/u/"));
        endif;
        $this->data["meta_title"] = "admin page | {$this->user_name}";
        $this->data["subview"] = "admin/admin_index";


        $this->load->view("_layout_admin",$this->data);
    }
    //---





    //--------------------
    //-------- u
    function u(){
        if(!$this->is_admin):
            //echo"not admin";
            redirect(site_url("users/logout"));
            exit();
        endif;

        $this->data["subview"] = "admin/admin_index";
        $this->data["meta_title"] = "{$this->user_type_text} | welcome {$this->user_name}";


        //--get Article
        $ar_list = $this->Mdl_article->GET_ARTICLE(null,6)->result();
        $this->data["get_ar"] = $ar_list;

        $template = "_ADMIN_TMP";
        $this->load->view($template,$this->data);
    }

  //--------------------
  //------profile admin can edit his profile
  function profile(){
    if(!$this->is_admin):
      redirect(site_url("users/logout"));
      exit();
    endif;
    $this->data["meta_title"] = "{$this->user_name}'s profile | Admin";
    $this->data["subview"] = "admin/profile";
    $tmp = "_ADMIN_TMP";
    $this->load->view($tmp,$this->data);
  }

  //--------------
  //-----edit
  function edit(){
    $where = array("id" => $this->user_id);
    $get = $this->Mdl_users->getUsers($where)->result();
    $this->o_put["get"] = $get;
    $this->output->set_output(json_encode($this->o_put));
  }

  //-------checkPass
  function checkPass(){
    $oPass = $this->input->post("oldPass");
    $needCheck = $this->make_hash($this->input->post("passConfirm"));
    //--compare the password and user send password
    //--
    $msg = "Error : wrong password!";
    $err = 1;
    if($needCheck == $oPass):
      $err = 0;
      $msg = "Success : STATUS is unlock!";
    endif;
    $this->o_put["error"] = $err;
    $this->o_put["msg"] = $msg;
    $this->output->set_output(json_encode($this->o_put));
  }

  //---saveProfile
  function saveProfile(){
    $oldPass = $this->input->post("oldPass");
    $p = $this->input->post("newPass");

    $id = $this->input->post("u_id");
    $name = $this->input->post("u_name");
    $email = $this->input->post("u_email");
    $tel = $this->input->post("u_tel");

    $nP = $oldPass;
    $newPass = $this->make_hash($p);
    if(!empty($p)):
      $nP = $newPass;
    endif;
    //--for debugging
    //echo"the new pass is {$nP} | the old pass is {$oldPass}";
    $u_data = array(
      "name" => $name,
      "passwd" => $nP,
      "email" => $email,
      "tel" => $tel
    );
    $this->Mdl_users->saveUser($u_data,array("id" => $id));

    $this->o_put["url"] = site_url("users/logout");
    $this->o_put["msg"] = "Success : your profile has been save , please login again";
    $this->output->set_output(json_encode($this->o_put));
  }
  //----------------

  /*
   *
   *    Section Post in admin
   *    This section has create on 9-Jan-2020
   */

  function getCountPost(){
      $get = $this->Mdl_article->GET_ARTICLE()->result();
      $num = count($get);
      $this->o_put["num_all"] = $num;
      $this->o_put["get"] = $get;
      $this->output->set_output(json_encode($this->o_put));
  }
  /*
   *    END OF POST SECTION
   */
}//end of file
