<?php

class Tour extends MY_Controller{

    protected $_tb_tour = "tbl_tour";
    protected $_tb_cat = "tbl_cat";
    protected $_tb_seo = "seo";

    //-----public string
    public $ip;
    public $browser;
    public $os;
    public $user_id;
    public $user_name;

    public $sysName;
    public $sysVersion;
    public $sysDate;


    protected $moderate;
    protected $is_admin;
    protected $is_login;
    protected $user_type;


    function __construct(){
        parent::__construct();

        //--library
        $this->load->library("pagination");

        //--model
        $this->load->model("Mdl_tour");
        $this->load->model("Mdl_seo");
        $this->load->helper("cookie");


        //--basic info
        // $this->ip = $this->Mdl_tour->getIP();
        // $this->browser = $this->Mdl_tour->getBrowser();
        // $this->os = $this->Mdl_tour->getOS();
        // $this->user_name = $this->Mdl_tour->getUserName();
        // $this->ip = $this->Mdl_tour->getUserId();

        //---system app info
        $this->sysName = "Tour";
        $this->sysVersion = "3.25";
        $this->sysDate = "17-Feb-2020";
        $this->data["sysName"] = $this->sysName;
        $this->data["sysVersion"] = $this->sysVersion;
        $this->data["sysDate"] = $this->sysDate;

        $this->data["user_id"] = $this->user_id;

        $this->moderate = $this->user_is_mod();
        $this->is_admin = $this->user_is_admin();
        $this->is_login = $this->user_is_login();
        $this->user_type = $this->getUserType();
        if(!$this->user_type):
          $this->user_type = "visitor";
        endif;

    }

    //--List all the tour program
    function index(){

        if($this->is_login):
            $url = site_url("tour/own");
            if($this->is_admin):
                $url = site_url("tour/admin");
            endif;
            if($this->moderate):
                $url = site_url("tour/mod");
            endif;
            redirect($url);
        endif;
        $where = array(
            "mark_draft " => 0
        );
        $this->data["subview"] = "tour/index";
        $this->data["meta_title"] = "Read and Book your tour by {$this->sysName} version {$this->sysVersion} | {$this->user_type} ";

        $get = $this->Mdl_tour->getTour($where)->result();
        $num = count($get);
        //$page = $this->input->get("page");
        $per_page = 10;
        $page = (!$page = $this->input->get("page"))?$page=$per_page:$page=$page;
        $this->data["get_tour"] = $get;
        $this->data["num_tour"] = $num;
        $this->data["page"] = $page;

        $this->load->view("_layout_main",$this->data);
    }

    //--------------------------------

    //---   detail
    function detail($id){
        $where = array(
            "t_id" => $id,
            "mark_draft " => 0 
        );
        $og_title = "";
        $g = $this->Mdl_tour->getTour($where)->result();
        foreach($g as $row):
            $og_title = "{$row->t_name}";
            $this->data["publisher"] = $row->name;
            $this->data["page_description"] = $row->kw_page_des;
            $this->data["page_keyword"] = $row->kw_page_des;
            $this->data["og_url"] = $row->og_url;

            
        endforeach;

        $this->data["get"] = $g;
        $this->data["meta_title"] = "{$og_title} | {$this->sysName} | {$this->data['user_type_text']}";
        $this->data["subview"] = "tour/tour_detail";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);
    }



   
    /*
     *
     *  Admin section create on 14-Feb-2020
     *
     */

    function admin(){
        $this->data["meta_title"] = "{$this->user_type_text} | {$this->user_name} {$this->user_id} | {$this->sysName}";
        $this->data["subview"] = "admin/tour/index";
        $tmp = "_ADMIN_TMP";
        $this->load->view($tmp,$this->data);
    }
    //-----------------
    //---- adminGetList
    function adminGetList($page=1){
        $get_all = $this->Mdl_tour->all()->result();
        $num_all = count($get_all);

        //--- pagination
        $per_page = 4;
        $url = "adminGetList";
        $conf = $this->getConfPagin($per_page,$num_all,$url);
        $this->pagination->initialize($conf);

        $start = ($page-1)*$per_page;
        $get_t = $this->Mdl_tour->getTour("",$per_page,$start)->result();

        $this->o_put["get_all"] = $get_all;
        $this->o_put["get_tour"] = $get_t;
        $this->output->set_output(json_encode($this->o_put));

    }
    //----------------------------
    //---   adminEdit
    function adminEdit($id){
        $g = $this->Mdl_tour->getTour(array("t_id" => $id))->result();
        $this->o_put["get"] = $g;
        $this->output->set_output(json_encode($this->o_put));
    }

    //------------------------------
    //---   adminSave
    function adminSave(){
        $s = $this->Mdl_tour->adminSave();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["t_id"] = $s["t_id"];
        $this->output->set_output(json_encode($this->o_put));
    }

    function adminDel($id){
        $g = $this->Mdl_tour->adminDel(array("t_id" => $id));
        $this->o_put["msg"] = $g["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }

    /*
     *
     *  END OF Admin section create on 14-Feb-2020
     *
     */




}//end of file
