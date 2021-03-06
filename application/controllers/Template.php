<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Template extends MY_Controller{
    
    public $o_put;

    //-- table
    protected $_tb_cat = "tbl_cat";

    //--- user data
    public $is_login;
    public $is_admin;
    public $moderate;
    public $user_name;
    public $user_id;

    public $sysName = "Template Gen3";
    public $sysVersion = "3.25";
    public $sysDate = "27-Feb-2020";

    function __construct() {
        parent::__construct();

	//Load the library..edit on Mon-31-July-2017
        $this->load->library("pagination");

        //Load the models
        $this->load->model("Mdl_users");
	$this->load->model("Mdl_tmp");
	$this->load->model("Mdl_cat");

        
        
       $this->data["user_id"] = $this->user_id; 

    }


    function index(){
        $url = "";
        if($this->is_login):
            $url = site_url("template/u");
            if($this->is_admin):
                $url = site_url("template/admin");
            endif;
            redirect($url);
        endif;


    }
    //---
    //-----------------------------
    function getList($page=1){
        $get = $this->Mdl_tmp->getTmp()->result();
        $num = count($get);

        //--- pagination
        $per_page = 4;
        $url = "getList";
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_tmp = $this->Mdl_tmp->getTmp(null,$per_page,$start)->result();
        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
            endif;
        $this->o_put["get_all"] = $get;
        $this->o_put["get_tmp"] = $get_tmp;
        $this->o_put["num_tmp"] = $num;
        $this->output->set_output(json_encode($this->o_put));

    }


    /*
     * tmpGetByCategory create on 24-Mar-2020
     */

    function tmpGetByCategory($cat_id){

        $get = $this->Mdl_tmp->getTmp(array("{$this->_tb_cat}.cat_id" => $cat_id));
        $this->o_put["get"] = $get->result();
        $this->output->set_output(json_encode($this->o_put));

    }


    //-----------------------------
    /*
     *  Admin section 27-Feb-2020
     *
     */
    function admin(){
        $this->data["subview"] = "admin/tmp/index";
        $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | {$this->user_type_text}";

        //-- get the category to show in the form
        $get_cat = $this->Mdl_cat->getCat()->result();
        $this->data["get_cat"] = $get_cat;

        $tmp = "_ADMIN_TMP";
        $this->load->view($tmp,$this->data);
    }

    //----------------------------
    //-- adminEdit
    function adminEdit($id){
        $s = $this->Mdl_tmp->getTmp(array("tmp_id" => $id))->result();
        $this->o_put["get"] = $s;
        $this->output->set_output(json_encode($this->o_put));
    }

    //-------------------------------
    function adminSave(){

        $s = $this->Mdl_tmp->adminSave();
        $this->o_put["tmp_id"] = $s["tmp_id"];
        $this->o_put["msg"] = $s["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }
    //---------------------------
    //--- adminDel
    function adminDel($id){
        $d = $this->Mdl_tmp->adminDel(array("tmp_id" => $id));
        $this->o_put["msg"] = $d["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }


    /*
     *  End of Admin  section
     */
    
  }//end of file
