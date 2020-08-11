<?php

class Comment extends MY_Controller{


    protected $is_login;

    protected $moderate;
    protected $is_admin;


    public $o_put;
    public $user_id;

    public $user_name;
    public $ip;
    public $os;
    public $browser;
    public $post_day;

    public $sysName = "CommentThing3";
    public $sysVersion = 3.2;
    public $sysDate = "21-dec-2019";
    function __construct(){
        parent::__construct();

        $this->load->model("Mdl_comment");
        $this->load->model("Mdl_users");
        $this->load->model("Mdl_article");
        $this->load->library("pagination");
        $this->load->helper("cookie");

        $this->user_id = $this->Mdl_comment->getUserId();
        $this->user_name = $this->Mdl_comment->getUserName();

        $this->is_login = $this->user_is_login();
        $this->is_admin = $this->user_is_admin();
        $this->moderate = $this->user_is_mod();

        $this->ip = $this->Mdl_comment->getIP();
        $this->os = $this->Mdl_comment->getOS();
        $this->browser = $this->Mdl_comment->getBrowser();

        $this->post_day = date("Y-m-d",time());


        $this->data["sysName"] = $this->sysName;
        $this->data["sysVersion"] = $this->sysVersion;
        $this->data["sysDate"] = $this->sysDate;

    }

    function index(){
        $r_url = site_url();

        if($this->is_login):

            if($this->is_admin):
                $r_url = site_url("comment/admin");
              else:
                $r_url = site_url("comment/u/{$this->user_id}");
            endif;
        endif;

        //---redirect to url
        redirect($r_url);
    }


    function getCommentCount($seg=1){
        /*--
        //--will recieve POST section_name item_id
        //--This method will get all of the comment base on the section name and item id recieve by ajax call at the first form load
        */
        $section_name = $this->input->post("section_name");
        $item_id = $this->input->post("item_id");



        $where = array(
            "c_section_name" => $section_name,
            "c_item_id" => $item_id,
            "c_show !=" => 0
        );
        $get = $this->Mdl_comment->getComment($where)->result();
        $num_comment = count($get);

        //---pagination
        $url = "getCommentCount";
        $per_page = 4;
        $conf = $this->getConfPagin($per_page,$num_comment,$url);
        $this->pagination->initialize($conf);
        $page = $seg;
        $start = ($page-1)*$conf["per_page"];

        $get_all_comment = $this->Mdl_comment->getComment($where,$conf["per_page"],$start)->result();
        if($num_comment >= $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;

        $this->o_put["get_comment"] = $get_all_comment;
        $this->o_put["num_comment"] = $num_comment;

        $this->output->set_output(json_encode($this->o_put));
    }

    //-------------------------
    //-----------------------------   
    /*
     *
     *      This method call by ajax to get the list of comment on the page 22-Jan-2020
     *
     */

    function getCommentList($page=1){
        $sec_name = $this->Mdl_comment->getEl("sec_name");

        $item_id = $this->Mdl_comment->getEl("item_id");

        $where = array(
            "c_section_name" => $sec_name,
            "c_item_id" => $item_id,
            "c_show !=" => 0
        );
        $get = $this->Mdl_comment->getComment($where)->result();
        $num = count($get);

        $this->o_put["get_all"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }

    //-------------
    //---   sentUserLink
    function sentUserLink(){
        $h = $this->Mdl_comment->sentUserLink();
        $this->o_put["msg"] = $h["msg"];
        //$this->o_put["link_url"] = $h["link_url"];
        $this->output->set_output(json_encode($this->o_put));
    }
    //---   isRealEmail
    function isRealUser($id){
        $s = $this->Mdl_comment->isRealUser($id);

        $this->data["meta_title"] = "Thank you for your confirmed";
        $this->data["msg"] = $s["msg"];
        $this->data["subview"] = "comment/_confirm_real_user";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);
    }
    //--------------
    //--    no login can edit by his session
    function uEdit($id){
        $where = array(
            "c_user_uniq" => $id
        );
        $get = $this->Mdl_comment->getComment($where)->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }
    function uSaveComment(){
        $s = $this->Mdl_comment->uSaveComment();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["c_id"] = $s["c_id"];
        $this->output->set_output(json_encode($this->o_put));
    }
    /*
     * END OF NON LOGIN
     */
    //-----------------------------
    //-------getMyInfo------------
    function getMyInfo(){
        $where = array(
            "id" => $this->user_id
        );
        $get = $this->Mdl_users->getUsers($where)->result();
        $this->o_put["get_user"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }

    //----------------------------------
    //--getMyComment
    function getCurrentUser(){

        $sec_name = $this->Mdl_comment->getEl("sec_name");

        $item_id = $this->Mdl_comment->getEl("item_id");
        $cur_user_ip = $this->ip;
        $cur_day = $this->today;

        $where = array(
            "c_section_name" => $sec_name,
            "c_item_id" => $item_id,
            "c_user_ip" => $cur_user_ip,
            "c_date" => $cur_day
        );

        $get_cur = $this->Mdl_comment->getComment($where)->result();
        $this->o_put["get_current_user"] = $get_cur;

        $this->output->set_output(json_encode($this->o_put));
    }


    //------------------
    //---function u create on 9-July-2019
    function u($u_id){
      if($this->is_login):
        $this->data["meta_title"] = "{$this->sysName}&nbsp;{$this->sysVersion}.";
        $this->data["subview"] = "comment/_member_index";
        $tmp = "_MEMBER_TMP";
        $this->load->view($tmp,$this->data);
      else:
        redirect(site_url("users/logout"));
        exit();
      endif;

    }

    


    //------------------------------------------------------------------------
    //---------------Admin section Create Sat 1 Sep 2018-----------
    function adminGetAllComment($seg=1){
        $get_c = $this->Mdl_comment->getComment()->result();
        $num_c = count($get_c);


        //--pagination
        $url = "adminGetAllComment";
        $per_page = 10;

        $conf = $this->getConfPagin($per_page,$num_c,$url);
        $this->pagination->initialize($conf);
        $page = $seg;
        $start = ($page-1)*$conf["per_page"];
        $get_all_c = $this->Mdl_comment->getComment(null,$conf["per_page"],$start)->result();
        if($num_c >= $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;

        $this->o_put["get_comment"] = $get_all_c;
        $this->o_put["num_comment"] = $num_c;

        $this->output->set_output(json_encode($this->o_put));
    }

    //--------------------------------------
    //---------------Admin edit  Comment
    function adminEdit($c_id){
        //$c_id = $this->input->post("c_id");
        $where = array("c_id" => $c_id);
        $get_c = $this->Mdl_comment->find($where)->result();
        $this->o_put["get_comment"] = $get_c;

        $this->output->set_output(json_encode($this->o_put));
    }

    //----------------------------------
    //-----------adinSaveComment
    function adminSave(){
        
        $s = $this->Mdl_comment->adminSave();
        $this->o_put["c_id"] = $s["c_id"];
        $this->o_put["msg"] = $s["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }

    //-----------------------------------
    //---   adminDel
    function adminDel($id){
        $d = $this->Mdl_comment->adminDel($id);
        $this->o_put["msg"] = $d["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }

    //------------------------------------------

    function admin(){
        if(!$this->is_admin):
            redirect(site_url());
            exit();
        endif;
        $this->data["meta_title"] = "{$this->sysName} {$this->sysVersion} | {$this->user_name} | {$this->user_type_text}";
        $this->data["subview"] = "admin/comment/index";
        $tmp = "_ADMIN_TMP";

        $this->load->view($tmp,$this->data);
    }


    //----------------End of admin section-----------------------------
}//end of file
