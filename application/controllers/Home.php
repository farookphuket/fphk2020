<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {


 /*
New edit with the MY_Model class on Thu-25-Aug-2016

*/
        protected $is_login;
        protected $is_admin;

        protected $_tb_ar = "tbl_article";
        protected $_tb_seo = "seo";
        protected $_tb_ustd = "tbl_ustd";

        //--public variable

        public $ip;
        public $os;
        public $browser;
        public $o_put;

    function __construct() {
    parent::__construct();
    $this->is_login = $this->session->userdata("is_login");
        $this->load->model("Mdl_home");
        $this->load->model("Mdl_article");
        $this->load->model("Mdl_tour");
        $this->load->model("Mdl_ustd");

        $this->load->library("pagination");

        //$this->today = date("d-m-Y h:i a",time());
        //$this->u_data = $this->get_user_info();||comment two line out as no use
        $this->ip = $this->Mdl_home->getIP();
        $this->os = $this->Mdl_home->getOS();
        $this->browser = $this->Mdl_home->getBrowser();


        $this->data["is_admin"] = $this->is_admin;
        $this->data["is_login"] = $this->is_login;
        $this->data["moderate"] = $this->moderate;

    }
public function index()
{

    $url = site_url();
    $this->data['subview'] = "home_index";
    $this->data['meta_title'] = "Welcome  to {$url} | {$this->browser_name}";

    //get last what's new for the keyword 
    $where = array(
        "{$this->_tb_ustd}.show_public !=" => 0,
        "{$this->_tb_ustd}.friend_only " => 0,
        "{$this->_tb_ustd}.private_only" => 0
    );
    $se = $this->Mdl_ustd->getSt($where,1)->result();
    foreach($se as $item):
       $this->data["meta_title"] = $item->st_title; 
       $this->data["publisher"] = $item->name; 
       $this->data["page_keyword"] = $item->st_title; 
       $this->data["page_description"] = $item->st_title; 
    endforeach;


    $this->load->view("_layout_main", $this->data);



}//end of index function
//----------------------------
//-------get Recent post
function getRecentPost($seg=1){
    $where = array(
        "{$this->_tb_ar}.ar_show_public !=" => 0,
        "{$this->_tb_ar}.ar_show_index !=" => 0,
        "{$this->_tb_ar}.ar_is_approve !=" => 0
    );
    $get = $this->Mdl_article->seoGetAr($where)->result();
    $num = count($get);


    //---pagination
    $per_page = 5;
    $url = "getRecentPost";
    $conf = $this->getConfPagin($per_page,$num,$url);
    $this->pagination->initialize($conf);
    $page = $seg;
    $start = ($page-1)*$conf["per_page"];
    $get_ar = $this->Mdl_article->seoGetAr($where,$conf["per_page"],$start)->result();

    if($num >= $per_page):
        $this->o_put["pagination"] = $this->pagination->create_links();
    endif;

    $this->o_put["num_ar"] = $num;
    $this->o_put["get_ar"] = $get_ar;
    $this->output->set_output(json_encode($this->o_put));
}


//----------getTourList
function getTourList($seg=1){
    //---Sat 3 Nov 2018
    $where_t = array("mark_draft " => 0);
    $get = $this->Mdl_tour->getTour($where_t)->result();
    $num = count($get);

    $per_page = 4;
    $url = "getTourList";
    $conf = $this->getConfPagin($per_page,$num,$url);
    $this->pagination->initialize($conf);
    $page = $seg;
    $start = ($page-1)*$conf["per_page"];
    $get_all = $this->Mdl_tour->getTour($where_t,$conf["per_page"],$start)->result();

    if($num >= $per_page):
        $this->o_put["pagination"] = $this->pagination->create_links();
    endif;
    $this->o_put["get_tour"] = $get_all;
    $this->o_put["num_tour"] = $num;

    $this->output->set_output(json_encode($this->o_put));
}





}//end of Home class
