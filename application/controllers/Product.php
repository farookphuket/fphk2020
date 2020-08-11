<?php


class Product extends MY_Controller{


  protected $_tb_cat = "tbl_cat";
  protected $_tb_product = "tbl_product";

  //---user info
  public $ip;
  public $browser;
  public $os;

  protected $user_id;
  public $user_name;
  public $user_type_text;
  public $is_admin;
  public $is_login;
  public $moderate;

  //------- public
  public $sysName = "Product3";
  public $sysDate = "22 Feb 2020";
  public $sysVersion = "3.20";

  function __construct(){
    parent::__construct();
    $this->load->model("Mdl_product");
    $this->load->model("Mdl_seo");
    $this->load->model("Mdl_tmp");
    $this->load->model("Mdl_cat");
    $this->load->model("Mdl_users");
    $this->load->library("pagination");

    $this->ip = $this->Mdl_product->ip;


    $this->data["sysName"] = $this->sysName;
    $this->data["sysDate"] = $this->sysDate;
    $this->data["sysVersion"] = $this->sysVersion;

  }

  function index(){

    if($this->is_login):
      $url = site_url("product/u");
      if($this->moderate):
        $url = site_url("product/moderate");
      endif;
      if($this->is_admin):
        $url = site_url("product/admin");
      endif;
      redirect($url);
    endif;

      $uri_text = $this->uri->segment(1);
      $where_c = array("cat_uri" => $uri_text);
      $get_cat = $this->Mdl_cat->getCat($where_c)->result();
      $this->data["get_cat"] = $get_cat;

    $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | Buying or Saling.";
    $this->data["subview"] = "product/index";
    $tmp = "_layout_main";


    $this->load->view($tmp,$this->data);

  }
  //------------------------------
/*
  //    None Login user  
  //--- Create 24-Feb-2020 
*/

  //---     getByCat
  function getByCat($page=1){
        $cat_id = $this->Mdl_product->getEl("cookie_product_cat_id");

        $where = array("{$this->_tb_cat}.cat_id" => $cat_id);
        $get = $this->Mdl_product->getByCat($where)->result();

        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
  }
  //---     getProductList
  function getProductList($page=1){
      $where = array(
          "pd_public !=" => 0
      );
      $get = $this->Mdl_product->getProduct($where)->result();
      $num = count($get);

      $this->o_put["get_p"] = $get;
      $this->output->set_output(json_encode($this->o_put));
  }
  //-----------------------
  function detail($uniq_id){
     $where = array(
        "{$this->_tb_product}.pd_uniq_id" => $uniq_id
     );
     $get = $this->Mdl_product->getProduct($where)->result();
     $rUrl = site_url("product/detail/");
     foreach($get as $row):
         $this->data["page_keyword"] = "{$row->kw_page_keyword}";
         $this->data["page_description"] = "{$row->kw_page_des}";
         $this->data["og_url"] = "{$rUrl}{$row->pd_uniq_id}";
         $this->data["og_title"] = "{$row->pd_title}";
         $this->data["og_description"] = "{$row->kw_page_des}";
         $this->data["og_type"] = "Product";
         $this->data["meta_title"] = "{$row->pd_title}|{$this->sysName} version {$this->sysVersion}";
     endforeach;

     $tmp = "_layout_main";
     $this->data["get"] = $get;
     $this->data["subview"] = "product/view_product";
     $this->load->view($tmp,$this->data);
  }

  //-----------------------------
  /* NONE LOGIN userView */

  //------------------------------
  /*  Admin Section  Start*/
  function admin(){
    if(!$this->is_admin):
      redirect(site_url("users/logout"));
      exit();
    endif;
      $title = "Admin manage Product | {$this->user_type_text} | {$this->user_name}";
        $this->data["user_id"] = $this->user_id;
        $uri_text = $this->uri->segment(1);
        $this->data["uri_text"] = $uri_text;


        $get_cat = $this->Mdl_cat->getCat()->result();
        $this->data["get_cat"] = $get_cat;

        //--- getTemplate
        $get_tmp = $this->Mdl_tmp->getTmp()->result();
        $this->data["get_tmp"] = $get_tmp; 

      $this->data["meta_title"] = $title;
      $this->data["subview"] = "admin/product/index";
      $tmp = "_ADMIN_TMP";
      $this->load->view($tmp,$this->data);
  }

  function adminList($page=1){
    $get  = $this->Mdl_product->getProduct()->result();
    $num = count($get);

    $url = "adminList";
    $per_page = 2;
    $conf = $this->getConfPagin($per_page,$num,$url);
    $this->pagination->initialize($conf);
    $start = ($page-1)*$per_page;
    $get_p = $this->Mdl_product->getProduct(null,$per_page,$start)->result();
    if($num > $per_page):
      $this->o_put["pagination"] = $this->pagination->create_links();
    endif;

    $this->o_put["get_all"] = $get;
    $this->o_put["get_p"] = $get_p;
    $this->o_put["num_product"] = $num;
    $this->output->set_output(json_encode($this->o_put));
  }

  //----------------
  //----------   adminEdit
  function adminEdit($id){
    $get = $this->Mdl_product->getProduct(array("{$this->_tb_product}.pd_id" => $id))->result();
    $this->o_put["get"] = $get;
    $this->output->set_output(json_encode($this->o_put));
  }
  //-------------------------
  //----------  adminSave
  function adminSave(){
    $save = $this->Mdl_product->adminSave();
    $this->o_put["pd_id"] = $save["pd_id"];
    $this->o_put["msg"] = $save["msg"];
    $this->output->set_output(json_encode($this->o_put));
  }
  //----------
  //-----   adminDel
  function adminDel($id){
      $del = $this->Mdl_product->adminDel(array("pd_uniq_id" => $id));
      $this->o_put["msg"] = $del["msg"];
      $this->output->set_output(json_encode($this->o_put));
  }

  /* END OF ADMIN SECTION */

}//end of the file
