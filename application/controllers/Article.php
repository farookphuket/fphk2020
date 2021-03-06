<?php

class Article extends MY_Controller{

    

    protected $user_id;
    protected $user_ip;
    protected $user_name;
    protected $is_login;
    protected $moderate;//---moderate
    protected $is_admin;

    //---table
    protected $_tb_ar = "tbl_article";
    protected $_tb_cat = "tbl_cat";
    protected $_tb_seo = "seo";
    protected $tb_his;
    protected $_tb_user = "users";

    protected $_post_ip;

    //----owner ID
    protected $_owner_ip;
    protected $_owner_name;
    protected $_owner_email;
    protected $_owner_id;

    //---public
    public $sysName = "";
    public $sysVersion = "";
    public $sysDate = "";

    function __construct(){
        parent::__construct();

        $this->load->model("Mdl_users");
        $this->load->model("Mdl_article");
        $this->load->model("Mdl_seo");
        $this->load->model("Mdl_mod");
        $this->load->model("Mdl_tmp");
        $this->load->model("Mdl_cat");

        //---cookie 7-7-2019
        $this->load->helper("cookie");

        $this->load->library("pagination");

        $this->user_id = $this->Mdl_article->getUserId();

        //---add this line 23-july-2019
        $this->data["user_id"] = $this->user_id;

        $this->user_name = $this->getUserName();
        $this->is_login = $this->user_is_login();
        $this->is_admin = $this->user_is_admin();
        $this->moderate = $this->moderate;
        $this->_post_ip = $this->Mdl_article->ip;

        // show this app info
        $this->sysName = "Article";
        $this->sysVersion = "3.20";
        $this->sysDate = "26-Jan-2019";
        $this->data["sysName"] = $this->sysName;
        $this->data["sysVersion"] = $this->sysVersion;
        $this->data["sysDate"] = $this->sysDate;
        $this->data["is_admin"] = $this->is_admin;

    }

    function index($seg=1){

        //--redirect to specific url if user has login
        $url = site_url("article/index");
        $rd_url = 0;
        if($this->is_login):
            $rd_url = 1;
            $url = site_url("article/u");
            if($this->is_admin):
                $url = site_url("article/admin");
                $rd_url = 1;
            endif;
            if($this->moderate):
                $url = site_url("article/mod");
                $rd_url = 1;
            endif;

        endif;

        if($rd_url == 1):
            redirect($url);
        endif;

        //---get the list of article and pagination them

        $where = array(
            "{$this->_tb_ar}.ar_show_public !=" => 0,
            "{$this->_tb_ar}.ar_is_approve !=" => 0

        );
        $get = $this->Mdl_article->GET_ARTICLE($where)->result();
        //---default for seo head first page list page
        $cur_url = current_url();
        $this->data["og_url"] = "{$cur_url}";
        $this->data["page_keyword"] = "{$this->sysName} version {$this->sysVersion}";
        $this->data["page_description"] = "{$this->sysName} version {$this->sysVersion} | {$this->user_type}";
        $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | welcome  {$this->user_name} {$this->user_type} ";


        $num = count($get);
        //---pagination
        $per_page = 4;
        $url = "article/index";
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $page = $seg;
        $start = ($page-1)*$conf["per_page"];
        $get_post = $this->Mdl_article->GET_ARTICLE($where,$conf["per_page"],$start)->result();

        $this->data["per_page"] = $per_page;
        $this->data["num_ar"] = $num;
        $this->data["get_ar"] = $get_post;
        $this->data["pagination"] = 0;
        if($num >= $per_page):
            $this->data["pagination"] = $this->pagination->create_links();
        endif;


        $this->data["subview"] = "article/ar_index";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);

    }


    /*
     *  for non login just show in the index page by ajax
    *   create section 19-12-2019
     */

    function arGetList($page=1){
        $where = array(
            "ar_show_public !=" => 0,
            "ar_show_index !=" => 0,
            "ar_is_approve !=" => 0,
        );
        $get = $this->Mdl_article->GET_ARTICLE($where)->result();
        $num = count($get);

        //---pagination
        $per_page = 6;
        $url = "arGetList";
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_all = $this->Mdl_article->GET_ARTICLE($where,$per_page,$start)->result();
        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
            endif;

        $this->o_put["get"] = $get;
        $this->o_put["get_all"] = $get_all;
        $this->o_put["num"] = $num;
        $this->output->set_output(json_encode($this->o_put));

    }

/*
 *  END of non login section
 */

    function read($uniq_id){

        //--- the info to show in meta tag
        $post_owner = "";
        $keyword = "";
        $keydes = "";
        $og_url = "";
        $meta_title = "";

        $where = array("uniq_id" => $uniq_id);
        $get = $this->Mdl_article->read($where);

        /*
         * Add the post owner info in the meta head tag
         * 20-Jan-2020
         */
        foreach($get  as $row):
            $post_owner = $row->ar_post_by;
            $keyword = $row->kw_page_keyword;
            $keydes = $row->kw_page_des;
            $og_url = $row->og_url;
            $meta_title = "{$row->ar_title} | BY {$row->ar_post_by}";

        endforeach;

        $this->data["meta_title"] = $meta_title;
        $this->data["publisher"] = $post_owner;
        $this->data["page_description"] = $keydes;
        $this->data["page_keyword"] = "{$keyword}";
        $this->data["og_url"] = $og_url;
        $this->data["og_sitename"] = site_url();

 

        $this->data["get_ar"] = $get;

        $this->data["subview"] = "article/read_article";

        $tmp = "_layout_main";

        $this->load->view($tmp,$this->data);
    }
    //----End of read_article



    //---End not login user

    /* User login as a member */
    function u(){
        if(!$this->is_login):
          redirect(site_url("users/logout"));
          exit();
        endif;
        $this->data["subview"] = "users/Article/index";
        $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | {$this->user_name} | {$this->user_type_text}";
        $tmp = "_MEMBER_TMP";
        $this->load->view($tmp,$this->data);
    }
    /////---------------------------
    //---- list the public post
    function uListPubPost($page=1){
      //--list the public post but not this user id
      $where = array(
        "{$this->_tb_ar}.ar_is_approve !=" => 0,
        "{$this->_tb_ar}.ar_show_public !=" => 0,
        "{$this->_tb_ar}.ar_user_id !=" => $this->user_id
      );
      $get = $this->Mdl_article->GET_ARTICLE($where)->result();

      //---pagination
      $num = count($get);
      $url = "uListPubPost";
      $per_page = 5;
      $conf = $this->getConfPagin($per_page,$num,$url);
      $this->pagination->initialize($conf);
      $start = ($page-1)*$per_page;
      $get_pub = $this->Mdl_article->GET_ARTICLE($where,$per_page,$start)->result();
      if($num > $per_page):
        $this->o_put["pagination"] = $this->pagination->create_links();
      endif;
      $this->o_put["get_pub"] = $get_pub;
      $this->o_put["get_all"] = $get;
      $this->output->set_output(json_encode($this->o_put));
    }
    //----------
    //---- uListPost
    function uList($page=1){
      $where = array(
        "{$this->_tb_ar}.ar_user_id" => $this->user_id
      );
      $get = $this->Mdl_article->GET_ARTICLE($where)->result();
      $num = count($get);
       //---pagination
       $url = "uList";
       $per_page = 15;
       $conf = $this->getConfPagin($per_page,$num,$url);
       $this->pagination->initialize($conf);
       $start = ($page-1)*$per_page;
       $get_my = $this->Mdl_article->GET_ARTICLE($where,$per_page,$start)->result();

       if($num > $per_page):
         $this->o_put["pagination"] = $this->pagination->create_links();
       endif;
       $this->o_put["get_my"] = $get_my;
       $this->o_put["get_all"] = $get;
       $this->output->set_output(json_encode($this->o_put));

    }
    //------------------------
    //------- uEdit 6-aug-2019
    function uEditPost($post_id){
        $where = array("ar_id" => $post_id);
        $edit = $this->Mdl_article->find($where)->result();

        $this->o_put["get"] = $edit;
        $this->output->set_output(json_encode($this->o_put));
    }
    //----------------------------
    
    //----uViewPost
    function uViewPost($id){
      if(!$this->is_login):
        //---redirect
        redirect(site_url("users/logout"));
        exit();

      endif;
      $title_url = current_url();
      $where = array(
        "{$this->_tb_ar}.ar_user_id" => $this->user_id,
        "{$this->_tb_ar}.ar_id" => $id
      );
      $get = $this->Mdl_article->GET_ARTICLE($where)->result();

      foreach($get as $row):
          $ar_title = $row->ar_title;
          $ar_id = $row->ar_id;
          $approve = $row->ar_is_approve;
          $this->data["meta_title"] = "{$title_url}/{$ar_title}";
          $this->data["og_url"]  = current_url();
          $this->data["og_title"] = "{$title_url}/{$ar_title}";
          $this->data["page_description"] = $row->kw_page_des;
          $this->data["page_keyword"] = $row->kw_page_keyword."This the test";
      endforeach;

      $this->data["get_ar"] = $get;
      $this->data["subview"] = "article/uViewPost";
      $tmp = "_DETAIL_TMP";
      $this->load->view($tmp,$this->data);
    }
    //------------------------------
    //------ uSavePost 8 Jan 2020
    function uSavePost(){
      $save = $this->Mdl_article->uSavePost();


      //$this->o_put["pub"] = $save["pub"];
      $this->o_put["ar_id"] = $save["ar_id"];
      $this->o_put["msg"] = $save["msg"];
      //$this->o_put["kw_id"] = $save["kw_id"];
      $this->output->set_output(json_encode($this->o_put));
    }
    //---------------------
    //-------- uDelPost
    function uDelPost($del_id){
        $where = array("ar_id" => $del_id);
        $del = $this->Mdl_article->uDelPost($where);
        $msg = "Success : data has been Deleted!";
        $this->o_put["msg"] = $msg;
        $this->output->set_output(json_encode($this->o_put));
    }

    /* End of user member section */
    //------------End of member area



    //-----------------------------------------------//
    //-----Moderate section----30-july-2019----------//
    /*
    |-- Moderation section
    */
    function mod(){
      if(!$this->moderate):
        redirect(site_url("users/logout"));
        exit();
      endif;
      $this->data["meta_title"] = "{$this->sysName} version {$this->sysVersion} | welcome {$this->user_name} | {$this->user_type}";
      $this->data["subview"] = "Mod/article/ar_index";
      $tmp = "_MOD_TMP";
      $this->load->view($tmp,$this->data);
    }

    //---mod list the post
    function modListPost($seg=1){
      $get = $this->Mdl_article->getArticle()->result();
      $num = count($get);

      //---pagination
      $url = "modListPost";
      $per_page = 5;
      $page = $seg;
      $conf = $this->getConfPagin($per_page,$num,$url);
      $this->pagination->initialize($conf);
      $start = ($page-1)*$per_page;
      $get_ar = $this->Mdl_article->getArticle(null,$per_page,$start)->result();
      if($num >= $per_page):
        $this->o_put["pagination"] = $this->pagination->create_links();
      endif;

      $this->o_put["get_ar"] = $get_ar;
      $this->o_put["get_all"] = $get;

      $this->output->set_output(json_encode($this->o_put));
    }

    //-- mod edit Post
    function modEditPost($id){
      $where = array("{$this->_tb_ar}.ar_id" => $id);
      $get = $this->Mdl_article->seoGetAr($where)->result();
      $this->o_put["get"] = $get;
      $this->output->set_output(json_encode($this->o_put));

    }
    //------
    //-----modFirstSave
    function modFirstSave(){
      $first = $this->Mdl_article->modFirstSave();
      $ar_id = $first["ar_id"];
      $kw_id = $first["kw_id"];
      $this->o_put["ar_id"] = $ar_id;
      $this->o_put["kw_id"] = $kw_id;
      $this->output->set_output(json_encode($this->o_put));
    }
    //-------
    //-----modSavePost
    function modSavePost(){
      $save = $this->Mdl_article->modSavePost();
      $this->o_put["ar_id"] = $save["ar_id"];
      $this->o_put["kw_id"] = $save["kw_id"];

      $this->output->set_output(json_encode($this->o_put));


    }
    //-------------------
    //-------modDelPost 31-july-2019
    function modDelPost($id){
      $del = $this->Mdl_article->modDelPost(array("{$this->_tb_ar}.ar_id" => $id));
      $last_num = $del["last_num"];
      $last_get = $del["last_get"];
      $this->o_put["get"] = $last_get;
      $this->o_put["num"] = $last_num;
      $this->output->set_output(json_encode($this->o_put));
    }
    //-----------
    //----- modGetField
    function _modGetField($f){
      //---reutn get the form field
      return $this->input->post($f);
    }
    //----------------------------------------////


    //-----------admin section------------------///

    function admin($seg=1){
        if(!$this->is_admin):
            redirect(site_url());
        endif;


        $this->data["get_cat"] = $this->Mdl_cat->getCat()->result();
        $this->data["get_tmp"] = $this->Mdl_tmp->getTmp()->result();

                
        $this->data["subview"] = "admin/article/list_article";
        $this->data["meta_title"] = "list article";

        $template = "_ADMIN_TMP";
        $this->load->view($template,$this->data);
    }



    function adminGet($seg=1){

        $get = $this->Mdl_article->GET_ARTICLE()->result();
        $num = count($get);
        $this->o_put["num_ar"] = $num;

        //---pagination page
        $url = "adminListAr";
        $per_page = 5;
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $page = $seg;
        $start = ($page-1)*$per_page;
        $get_ar = $this->Mdl_article->GET_ARTICLE(null,$per_page,$start)->result();

        if($num >= $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;


        $this->o_put["get_ar"] = $get_ar;
        $this->o_put["get_all"] = $get;
        $this->o_put["num_ar"] = $num;
        $this->output->set_output(json_encode($this->o_put));
    }
    //-----------------
    //------adminEditAr 9 jan 2020
    function adminEdit($ar_id){
        $where = array("{$this->_tb_ar}.ar_id" => $ar_id);
        $get = $this->Mdl_article->GET_ARTICLE($where)->result();
        $this->o_put["get_ar"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }
    //---------adminSaveAr 9 jan 2020
    function adminSave(){
      $save = $this->Mdl_article->adminSave();
      $ar_id = $save["ar_id"];
      $msg = $save["msg"];

      $this->o_put["ar_id"] = $ar_id;
      $this->o_put["msg"] = $msg;
      $this->output->set_output(json_encode($this->o_put));

    }

    
    //-------------------
    

    //---adminDelAr
    function adminDel($id){

        $where = array(
            "ar_id" => $id
        );
        $del = $this->Mdl_article->adminDel($where); 
        $this->o_put["msg"] = "{$del["msg"]}";
        $this->output->set_output(json_encode($this->o_put));
    }

    
    

    //--------------end of admin

    //
}//--end of file
