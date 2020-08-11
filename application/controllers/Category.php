<?php 


class Category extends MY_Controller{


    
    //---user status
    protected $is_login;
    protected $user_name;
    protected $user_id;
    protected $is_admin;
    protected $moderate;
    
    public $os;
    public $browser;
    public $ip;
    public $o_put;

    public $sysName = "Category3";
    public $sysVersion = 3.20;
    public $sysDate = "20-Feb-2020";

    function __construct(){
        parent::__construct();
        $this->load->model("Mdl_cat");
        $this->load->model("Mdl_users");
        $this->load->library("pagination");

        $this->data["sysName"] = $this->sysName;
        $this->data["sysVersion"] = $this->sysVersion;
        $this->data["sysDate"] = $this->sysDate;
    }

    function index(){
        $url = "";
        if($this->is_login):
            $url = site_url("");
            if($this->is_admin):
                $url = site_url("category/admin");
            endif;

                redirect($url);
            else:

            $this->data["subview"] = "category/category_index";

            $this->load->view("_layout_admin",$this->data);

        endif;
        
    }



    /*
     *  Admin section Start 19-Feb-2020
     */
    function admin(){
        if(!$this->is_admin):
            redirect(site_url("users/logout"));            
            exit();
            endif;
        $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | {$this->user_type_text} | {$this->user_name}";
        $this->data["subview"] = "admin/category/cat_index";
            if($this->user_id):
                $this->data["user_id"] = $this->user_id;
            endif;
            $tmp = "_ADMIN_TMP";
            $this->load->view($tmp,$this->data);
    }
    //---------------
    //---   adminList
    function adminList($page=1){
        $get = $this->Mdl_cat->getCat()->result();
        $num = count($get);

        //--- pagination
        $per_page = 4;
        $url = "adminList";
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_cat = $this->Mdl_cat->getCat("",$per_page,$start)->result();
        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
            endif;
        $this->o_put["get"] = $get;
        $this->o_put["get_cat"] = $get_cat;
        $this->output->set_output(json_encode($this->o_put));
    }
    //--------------------
    //---   adminEdit
    function adminEdit($id){
        $get = $this->Mdl_cat->getCat(array("cat_id" => $id))->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }
    //---   adminSave
    function adminSave(){
        $s = $this->Mdl_cat->adminSave();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["cat_id"] = $s["cat_id"];
        $this->output->set_output(json_encode($this->o_put));
    }
    //--------------------
    //---   adminDel
    function adminDel(){
        $d = $this->Mdl_cat->adminDel();
        $this->o_put["msg"] = $d["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }
    /*
     *  Admin section END 19-Feb-2020
     */





}
//---end of file
