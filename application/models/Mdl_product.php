<?php



 class Mdl_product extends MY_Model{


     protected $_tb_product = "tbl_product";
     protected $_tb_user = "users";
     protected $_tb_seo = "seo";
     protected $_tb_cat = "tbl_cat";

    public $ip;
    public $browser;
    public $os;

    

    function __construct(){
      parent::__construct();

        //--------
        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();

    }


    function find($where){
        $get = $this->db
            ->where($where)
            ->get($this->_tb_product);
    }
    //-------------------------
    //---   getByCat
    function getByCat($where=false,$limit=false,$offset=false){

        //$cat_id = $this->getEl("ck_cat_id");
        $get = "";

        $j1 = "{$this->_tb_user}.id={$this->_tb_product}.pd_user_id";
        $j2 = "{$this->_tb_cat}.cat_id={$this->_tb_product}.cat_id";

        if($where):
            
            $get = $this->db
                        ->join($this->_tb_user,$j1)
                        ->join($this->_tb_cat,$j2)
                        ->where($where) 
                        ->order_by("pd_date_create","DESC")
                        ->get($this->_tb_product);
        endif;
        




        return $get;
    }
    //--------------------------
    function getProduct($where=false,$limit=false,$offset=false){
        $get = "";

        //--- join table user,cat,seo
        $j1 = "{$this->_tb_user}.id={$this->_tb_product}.pd_user_id";
        $j2 = "{$this->_tb_cat}.cat_id={$this->_tb_product}.cat_id";
        $j3 = "{$this->_tb_seo}.kw_id={$this->_tb_product}.kw_id";

        if($where):
            $get = $this->db
                        ->join($this->_tb_user,$j1)
                        ->join($this->_tb_cat,$j2)
                        ->join($this->_tb_seo,$j3)
                        ->where($where)
                        ->order_by("pd_date_create","DESC")
                        ->get($this->_tb_product,$limit,$offset);
        else:
            $get = $this->db
                        ->join($this->_tb_user,$j1)
                        ->join($this->_tb_cat,$j2)
                        ->join($this->_tb_seo,$j3)
                        ->order_by("pd_date_create","DESC")
                        ->get($this->_tb_product,$limit,$offset);
 
        endif;
        return $get;
    }

    /*
     * ADMIN SECTION START 21-Feb-2020
     *
     */
    
    //--- adminSave
    function adminSave(){
        $action_code = $this->getEl("action_code");
        $pd_id = $this->getEl("p_id");
        $pd_user_id = $this->getEl("pd_user_id");
        $app_uri = $this->getEl("app_uri");

        $pd_title = $this->getEl("p_name");
        $pd_sum = $this->getEl("p_sum");
        $pd_body = $this->getEl("p_body");
        $pd_price = $this->getEl("p_price");
        
        $cat_id = $this->getEl("cat_id");
        $kw_id = $this->getEl("kw_id");

        $onSale = $this->getEl("onSale");
        !($onSale)?$onSale=0:$onSale=2;

        if(!$pd_user_id):
            $pd_user_id = $this->user_id;
        endif;
        //--- seo
        $keyword = $this->getEl("keyword");
        $keydes = $this->getEl("keydes");

        $seo_data = array(
            "kw_page_keyword" => $keyword,
            "kw_page_des" => $keydes,
            "og_title" => $keyword,
            "og_description" => $keydes,
            "og_type" => $app_uri,
            "og_site_name" => site_url()
        );
        $pd_data = array(
            "pd_title" => $pd_title,
            "pd_summary" => $pd_sum,
            "pd_body" => $pd_body,
            "pd_price" => $pd_price,
            "pd_public" => $onSale,
            "cat_id" => $cat_id
        );

        $msg = "";

        if(!$action_code || $action_code != $this->user_id):
            $msg = "Error : there is no action code";

        else:
            $og_url = "";

            if(!$pd_id):
                //-- create 
                $pd_uniq_id = $this->randomChar(150);

                $pd_data["pd_user_id"] = $pd_user_id;
                $pd_data["pd_uniq_id"] = $pd_uniq_id;
                $pd_id = $this->SAVE($pd_data,$this->_tb_product);
                //--- set seo
                $og_url = site_url("product/detail/{$pd_uniq_id}");
                $seo_data["og_url"] = $og_url;
                $seo_data["kw_canonical"] = $og_url;
                $seo_data["article_publisher"] = $this->user_name;
                $kw_id = $this->SAVE($seo_data,$this->_tb_seo);
                //--- update product table for kw_id
                $pd_update = array("kw_id" => $kw_id);
                $this->SAVE($pd_update,$this->_tb_product,array("pd_id" => $pd_id));
                
                $msg = "Success : product has been created at @{$pd_id}";
            else:
            //--- update
                $this->SAVE($seo_data,$this->_tb_seo,array("kw_id" => $kw_id));
                $pd_data["pd_date_update"] = $this->today_andTime;

                $this->SAVE($pd_data,$this->_tb_product,array("pd_id" => $pd_id));
             $msg = "Data has been updated @{$pd_id}";
            endif;

        endif;
        
        $r_data = array(
            "msg" => $msg,
            "pd_id" => $pd_id
        );
        return $r_data;
    }
    //-------------------
    //---   adminDel
    function adminDel($where){
        $get = $this->getProduct($where)->result();

        $kw_id = 0;
        $pd_id = 0;

        $title = "";
        $post_name = "";
        foreach($get as $row):
            $title = $row->pd_title;
            $post_name = $row->name; 
            $kw_id = $row->kw_id;
            $pd_id = $row->pd_id;

        endforeach;
            $this->DEL(array("kw_id" => $kw_id),$this->_tb_seo);
            $this->DEL(array("pd_id" => $pd_id),$this->_tb_product);
            $msg = "Success : product @{$title} by @{$post_name} has been deleted!";

            $r_data = array(
                "msg" => $msg
            );
        return $r_data;
    }
        
     /*     --------- END ADMIN ---------- */
 }
