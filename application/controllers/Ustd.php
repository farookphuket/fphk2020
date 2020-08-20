<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ustd extends MY_Controller {


    public $user_name;

    protected $is_login;
    protected $user_id;
    protected $user_email;
    protected $is_admin;
    protected $user_pass;
    protected $moderate;




    //the table name
    //edit on Thu 8 Jun 2017
    protected $_tb_ustd = "";
    protected $_tb_cat = "";
    protected $_tb_user = "";
    protected $_tb_notice = "tbl_notification";

    public $o_put;
    public $msg;
    public $user_type;
    public $ip;

    //---sys info
    public $sysName = "Ustd";
    public $sysVersion = "1.39";
    public $sysDate = "15-Mar-2020 3:05 a.m.";

  function __construct() {
    parent::__construct();

    //---load library
    $this->load->library("pagination");

    $this->load->model("Mdl_users");
    $this->load->model("Mdl_ustd");
    $this->load->model("Mdl_cat");

    $this->_tb_ustd = $this->Mdl_ustd->getTable();
    $this->_tb_user = $this->Mdl_users->getTable();
    $this->_tb_cat = $this->Mdl_cat->getTable();
    
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
    $this->ip = $this->Mdl_ustd->getIP();

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
            $url = site_url("ustd/u/");
            if($this->is_admin):
                $url = site_url("ustd/admin");
              else:
                $url = site_url("ustd/mod");
            endif;
          else:
            $url = site_url();
        endif;
        redirect($url);

    }//end of index

    /* non login will get this part */

    function getWhatNewList($page=1){
        $where = array(
            "show_public !=" => 0,
            "private_only" => 0,
            "friend_only" => 0
        );
        $get = $this->Mdl_ustd->getSt($where)->result();
        $num = count($get);


        $url = "getWhatNewList";
        $per_page = 16;

        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);

        $start = ($page-1)*$per_page;
        $get_page = $this->Mdl_ustd->getSt($where,$per_page,$start)->result();
        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;

        $this->o_put["get_all"] = $get_page;
       $this->output->set_output(json_encode($this->o_put)); 

    }


  

    /* END of non login section */

    //----
    function u(){

        if(!$this->is_login):
            redirect(site_url("users/logout"));
            exit();
        endif;
        //$this->data["user_id"] = $this->user_id;
        $this->data["subview"] = "ustd/ustd_member";
        $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | {$this->user_type_text}&nbsp;|&nbsp;welcome {$this->user_name}";
        $this->load->view("_MEMBER_TMP",$this->data);

    }

/*
 * edit this on 15-3-2020
 *
 */

    function ustdGetTemplate($cat_id){
        $s = $this->Mdl_ustd->ustdGetTemplate(array("cat_id" => $cat_id))->result();
        //$s = $cat_id;
        $this->o_put["get_tmp"] = $s;
        $this->output->set_output(json_encode($this->o_put));
    }

    function ustdSetTemplate($t_id){
        $setT = $this->Mdl_ustd->ustdGetTemplate(array("tmp_id" => $t_id))->result();
        $this->o_put["set_tmp"] = $setT;
        $this->output->set_output(json_encode($this->o_put));
    }

    function ustdGet($id){
        $s = $this->Mdl_ustd->find(array("st_id" => $id))->result();
        $this->o_put["get"] = $s;
        $this->output->set_output(json_encode($this->o_put));

    }

/*
 *  END 15-3-2020
 *
 */



    /* Admin section Start Date on 23 Sep 2019 */


    function admin(){
        if(!$this->is_admin):
            echo"You not admin";
            redirect(site_url("users/logout"));
        
            exit();
        endif;
        
        $uri = $this->uri->segment(1);
        $get_cat = $this->Mdl_cat->getCat(
                array("cat_uri" => $uri))->result();
        $this->data["uri"] = $uri;
        $this->data["get_cat"] = $get_cat;
        $this->data["subview"] = "admin/ustd/index";
        $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion}|{$this->user_type_text}| {$this->user_name}";
        $tmp = "_ADMIN_TMP";
        
        $this->load->view($tmp,$this->data);

    }

    function adminGet($page=1){
        $get = $this->Mdl_ustd->ustdAdminGet(null)->result();
        $num = count($get);

        //--- pagination
        $url = "adminGet";
        $per_page = 3;
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_st = $this->Mdl_ustd->ustdAdminGet(null,$per_page,$start)->result();

        if($num > $per_page):
        $this->o_put["pagination"] = $this->pagination->create_links();
            endif;
        
        $this->o_put["get"] = $get_st;
        $this->output->set_output(json_encode($this->o_put));
    }

    function adminEdit($id){
        $where = array("st_id" => $id);
        $get = $this->Mdl_ustd->adminGet($where)->result();
        $num = count($get);

        $this->o_put["num"] = $num;
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }

    function adminSave(){
        $save = $this->Mdl_ustd->adminSave();
        $msg = $save["msg"];
        $this->o_put["msg"] = $msg;
        $this->output->set_output(json_encode($this->o_put));
    }

    function ustdAdminDelete($id){
       // $where = array("{$this->_tb_ustd}.st_id" => $id);
        $del = $this->Mdl_ustd->ustdAdminDelete(array("st_id" => $id));
        $msg = $del["msg"];
        $this->o_put["msg"] = $msg;
        $this->output->set_output(json_encode($this->o_put));
    }

    /* Admin section END */

}//end of the class users
