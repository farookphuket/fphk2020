<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Last Edit 16 Jan 2020 using Laptop
 */
class Mdl_article extends MY_Model{

    //--- table
    protected $_tb_ar = "tbl_article";
    protected $_tb_seo = "seo";
    protected $_tb_user = "users";
    protected $_tb_cat = "tbl_cat";

    public $ip;
    public $os;
    public $browser;

    //---visiter info
    public $user_name;
    public $user_id;
    public $user_ip;


    //---protected
    protected $is_login;
    protected $is_admin;
    protected $moderate;


    function __construct() {
        parent::__construct();

        //$this->load->library("pagination");

        $this->user_name = $this->getUserName();
        $this->user_id = $this->getUserId();
        $this->is_admin = $this->user_is_admin();
        $this->is_login = $this->user_is_login();
        $this->moderate = $this->user_is_mod();

        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();
    }


    function all(){
        $get = $this->db
                    ->get($this->_tb_ar);
        return $get;
    }
    function find($where){
        $j1 = "{$this->_tb_seo}.kw_id={$this->_tb_ar}.kw_id";

        $get = $this->db
                    ->join($this->_tb_seo,$j1)
                    ->where($where)
                    ->get($this->_tb_ar);
                    
        return $get;
    }        


    function GET_ARTICLE($where=false,$limit=false,$offset=false){
        $get = 0;
        $j1 = "{$this->_tb_user}.id={$this->_tb_ar}.ar_user_id";
        $j2 = "{$this->_tb_seo}.kw_id={$this->_tb_ar}.kw_id";
        $j3 = "{$this->_tb_cat}.cat_id = {$this->_tb_ar}.cat_id";
        if($where):
            $get = $this->db
                        ->join($this->_tb_user,$j1)
                        ->join($this->_tb_seo,$j2)
                        ->join($this->_tb_cat,$j3)
                        ->order_by("{$this->_tb_ar}.date_add","DESC")
                        ->where($where)
                        ->get($this->_tb_ar,$limit,$offset);

            else:
                $get = $this->db
                        ->join($this->_tb_user,$j1)
                        ->join($this->_tb_seo,$j2)
                        ->join($this->_tb_cat,$j3)
                        ->order_by("{$this->_tb_ar}.date_add","DESC")
                        ->get($this->_tb_ar,$limit,$offset);


            endif;
        return $get;
    }
    
    function read($where){
        $get = $this->GET_ARTICLE($where)->result();
        $ar_id = 0;
        $last_num = 0;
        foreach($get as $row):
            $ar_id = $row->ar_id;
        endforeach;
        $this->num_read($ar_id); 


        return $get;  

    }

    function num_read($id){
        $where = array("ar_id" => $id);
        $get = $this->find($where)->result(); 
        $ar_id = 0;
        $last_count = 0;
        $add_count = 1;
        $last_view_date = "";
        $last_view_ip = "";

        //$sum_tmp = "";
        foreach($get as $row):
            $ar_id = $row->ar_id;
            $last_count = $row->ar_read_count;
            $last_view_ip = $row->last_view_ip;
            $last_view_date = $row->last_view_date;
            //$sum_tmp = $row->ar_summary;
        endforeach;
        $up_data = array(
            "last_view_ip" => $this->ip,
            "last_view_date" => $this->today
        );

        if($last_view_ip != $this->ip || $last_view_date != $this->today):
            $last_count++;
            $up_data["ar_read_count"] = $last_count;
            //$up_data["ar_summary"] = $sum_tmp."<h1>test number {$last_count} ha ha<h1>";
        endif;

        $this->SAVE($up_data,$this->_tb_ar,array("ar_id" => $ar_id));

    }
   
    function uSavePost(){

        $ar_id = $this->getEl("ar_id");
        $kw_id = $this->getEl("kw_id");

        //---meta keyword
        $og_url = $this->getEl("og_url");
        $keyword = $this->getEl("keyword");
        $keydes = $this->getEl("keydes");

        //--- post form
        $ar_title = $this->getEl("ar_title");
        $ar_sum = $this->getEl("ar_summary");
        $ar_body = $this->getEl("ar_body");
        $pub = $this->getEl("is_pub");
        !($pub)?$pub=0:$pub=1;

        $seo_data = array(
            "kw_page_keyword" => $keyword,
            "kw_page_des" => $keydes,
            "og_title" => $keyword,
            "og_description" => $keydes,
            "og_site_name" => site_url(),
            "article_publisher" => $this->user_name,
            "kw_date_add" => $this->today_andTime
        );

        //--- Post data
        $ar_data = array(
            "ar_title" => $ar_title,
            "ar_summary" => $ar_sum,
            "ar_body" => $ar_body,
            "ar_show_public" => $pub,
            "ar_post_by" => $this->user_name,
            "ar_user_id" => $this->user_id,
            "ar_post_ip" => $this->ip,
            "date_add" => $this->today_andTime,
            "date_edit" => $this->today_andTime
        );

        $msg = "";

        if($ar_id && $kw_id):
           //-- update post id 

            unset($seo_data["kw_date_add"]);
            unset($seo_data["article_publisher"]);
            unset($ar_data["date_add"]);

            $this->SAVE($ar_data,$this->_tb_ar,array("ar_id" => $ar_id));
            $this->SAVE($seo_data,$this->_tb_seo,array("kw_id" => $kw_id));
            $msg = "Success : item id @{$ar_id} on key @{$kw_id} has been updated";
        else:
            //-- create new post
            
            $uniq_id = $this->randomChar(200);
            $ar_data["uniq_id"] = $uniq_id;
            $og_url = site_url("article/read/{$uniq_id}");

            //--- create the seo tag
            $kw_id = $this->SAVE($seo_data,$this->_tb_seo);
            
            $save = $this->SAVE($ar_data,$this->_tb_ar); 
            $ar_id = $save;

            //--- update the og url
            $seo_data["kw_canonical"] = $og_url;
            $seo_data["og_url"] = $og_url;
            $this->SAVE($seo_data,$this->_tb_seo,array("kw_id" => $kw_id));

            //--- update the kw id
            $ar_data["kw_id"] = $kw_id;
            $this->SAVE($ar_data,$this->_tb_ar,array("ar_id" => $ar_id));

           $msg = "Success : data has been created id @{$ar_id}"; 
            
        endif;

        $r_data = array(
            "msg" => $msg,
            "ar_id" => $ar_id
        );
        return $r_data;
    }

    function uDelPost($where){
        $get = $this->find($where)->result();
        $kw_id = 0;
        $ar_id = 0;
        foreach($get as $row):
            $kw_id = $row->kw_id;
            $ar_id = $row->ar_id; 
        endforeach;
         
        $this->DEL(array("kw_id" => $kw_id),$this->_tb_seo);
        $this->DEL(array("ar_id" => $ar_id),$this->_tb_ar);


    }    
    //-----------------------------
    /*
     * END OF MEMBER SECTION
     */

    

    //-----------------------------------------
    
    /*
     *  ADMIN SECTION START 16-Jan-2020
     */
    function adminSave(){
        
        $is_approve = $this->getEl("is_approve");
        $is_index = $this->getEl("is_index");
        $is_public = $this->getEl("is_pub");
        $cat_id = $this->getEl("set_cat");

        !($is_approve)?$is_approve=0:$is_approve = 2;
        !($is_index)?$is_index=0:$is_index = 2;
        !($is_public)?$is_public=0:$is_public = 2;

        $ar_id = $this->getEl("ar_id");
        $ar_user_id = $this->getEl("ar_user_id");
        $kw_id = $this->getEl("kw_id");

        //---meta keyword
        $og_url = $this->getEl("og_url");
        $keyword = $this->getEl("keyword");
        $keydes = $this->getEl("keydes");

        //--- post form
        $ar_title = $this->getEl("ar_title");
        $ar_sum = $this->getEl("ar_sum");
        $ar_body = $this->getEl("ar_body");
        
        $seo_data = array(
            "kw_page_keyword" => $keyword,
            "kw_page_des" => $keydes,
            "og_title" => $keyword,
            "og_description" => $keydes,
            "og_site_name" => site_url(),
            "article_publisher" => $this->user_name,
            "kw_date_add" => $this->today_andTime
        );

        //--- Post data
        $ar_data = array(
            "ar_title" => $ar_title,
            "cat_id" => $cat_id,
            "ar_summary" => $ar_sum,
            "ar_body" => $ar_body,
            "ar_show_public" => $is_public,
            "ar_show_index" => $is_index,
            "ar_is_approve" => $is_approve,
            "ar_post_by" => $this->user_name,
            "ar_user_id" => $this->user_id,
            "ar_post_ip" => $this->ip,
            "date_add" => $this->today_andTime,
            "date_edit" => $this->today_andTime
        );

        
        $msg = "";
        if($ar_id && $kw_id):
           //-- update post id 

            unset($seo_data["kw_date_add"]);
            unset($seo_data["article_publisher"]);
            unset($ar_data["date_add"]);
            if($this->user_id != $ar_user_id):
                unset($ar_data["ar_post_by"]);
                unset($ar_data["ar_post_ip"]);
                unset($ar_data["ar_user_id"]);
            endif;

            $this->SAVE($ar_data,$this->_tb_ar,array("ar_id" => $ar_id));
            $this->SAVE($seo_data,$this->_tb_seo,array("kw_id" => $kw_id));
            $msg = "Success : item id @{$ar_id} on key  id @{$kw_id} has been updated";
        else:
            //-- create new post
            
            $uniq_id = $this->randomChar(200);
            $ar_data["uniq_id"] = $uniq_id;
            $og_url = site_url("article/read/{$uniq_id}");

            //--- create the seo tag
            $kw_id = $this->SAVE($seo_data,$this->_tb_seo);
            
            $save = $this->SAVE($ar_data,$this->_tb_ar); 
            $ar_id = $save;

            //--- update the og url
            $seo_data["kw_canonical"] = $og_url;
            $seo_data["og_url"] = $og_url;
            $this->SAVE($seo_data,$this->_tb_seo,array("kw_id" => $kw_id));

            //--- update the kw id
            $ar_data["kw_id"] = $kw_id;
            $this->SAVE($ar_data,$this->_tb_ar,array("ar_id" => $ar_id));

           $msg = "Success : data has been created id @{$ar_id} on key id @{$kw_id}"; 
            
        endif;

        $r_data = array(
            "msg" => $msg,
            "ar_id" => $ar_id
        );
        return $r_data;

    }

    //-----------------------------
    //--- adminDel
    function adminDel($where){
        $get = $this->find($where)->result();
        $cat_id = 0;
        $ar_id = 0;
        $kw_id = 0;
        $post_by = "";
        $ar_title = "";
        foreach($get as $row):
            $ar_id = $row->ar_id;
            $cat_id = $row->cat_id;
            $kw_id = $row->kw_id;
            $post_by = $row->ar_post_by;
            $ar_title = $row->ar_title;
        endforeach;

            $this->DEL(array("kw_id" => $kw_id),$this->_tb_seo);
            $this->DEL(array("ar_id" => $ar_id),$this->_tb_ar);

        $msg = "Success : the post {$ar_title} by {$post_by} has been deleted";

        $r_data = array(
            "msg" => $msg
        );
        return $r_data;
    }

     /*
     *  ADMIN SECTION END 16-Jan-2020
     */



}//end of Mdl_article
