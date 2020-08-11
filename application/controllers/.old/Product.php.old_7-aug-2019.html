<?php


class Product extends MY_Controller{


  protected $_tb_cat = "tbl_product_cat";
  protected $_tb_product = "tbl_product";

  function __construct(){
    parent::__construct();




    $this->load->model("Mdl_product");
    $this->user_id = $this->session->userdata("user_id");
    $this->is_login = $this->user_is_login();
    $this->user_name = $this->session->userdata("user_name");
    $this->is_admin = $this->user_is_admin();
  }

  function index(){

    $this->data["meta_title"] = "The product";
    $this->data["subview"] = "product/product_index";

//get the product and list on the page
    $where = array("pd_public" => 2);
    $get = $this->Mdl_product->getTB($this->_tb_product,$where);
    $num = count($get->result());
    $this->data["num_product"] = $num;
    $this->data["get_product"] = $get;


    $this->load->view("_layout_main",$this->data);
  }

  function product_admin_api($cmd=false,$id=false){
      
      //check if there are admin
      
      //then require the file to work
      require("product_admin_api.php");
  }
    
//------------------------------------
function getCat($id=false){
    $get = '';
    $data = array();
    $cat_id = $this->input->post("cat_id");
    if($id):
        $get = $this->Mdl_product->getTB($this->_tb_cat,array("cat_id" => $id));
    
        //--get the product in this category
        $j1 = "{$this->_tb_cat}.cat_id={$this->_tb_product}.cat_id";
        $where = array("{$this->_tb_cat}.cat_id" => $id);
        $get_p = $this->db
                    ->join($this->_tb_cat,$j1)
                    ->where($where)
                    ->get($this->_tb_product);
        
        $num_p = count($get_p->result());
        $c_data = array("cat_has_content" => $num_p);
        $this->Mdl_product->saveTB($this->_tb_cat,$c_data,$where);
                    
    
        $data['get_cat'] = $get->result();
        $data['get_p'] = $get_p->result();
        $data['num_p'] = $num_p;
    else:
        $get = $this->Mdl_product->getTB($this->_tb_cat);
        $data['num_cat'] = count($get->result());
        $data['get_cat'] = $get->result();
    endif;
    $this->output->set_output(json_encode($data));

    //return data
    return $data;
}
//----------saveCat Tue 19 Sep 2017
function saveCat(){
    
    $cat_title = $this->input->post("cat_title");
    $cat_des = $this->input->post("cat_des");
    $cat_id = $this->input->post("cat_id");
    
    $cat_today = date("Y-m-d",time());
    $cat_data = array(
        "cat_title" => $cat_title,
        "cat_date_create" => $cat_today,
        "cat_des" => $cat_des
    );
    $msg = array();
    
    if(!$cat_id):
        $save = $this->Mdl_product->saveCat($cat_data);
        $where = array("cat_id" => $save);
        $get = $this->Mdl_product->getTB($this->_tb_cat,$where);
        $msg['result'] = $get->result();
    else:
        unset($cat_data['cat_date_create']);
        $where = array("cat_id" => $cat_id);
        $save = $this->Mdl_product->saveCat($cat_data,$where);
        $get = $this->Mdl_product->getTB($this->_tb_cat,$where);
        $msg['result'] = $get->result();
    endif;
    
    $this->output->set_output(json_encode($msg));
    
}

function getProduct($id=false){

    $data = array();
    if($id):
        $get = $this->Mdl_product->getProduct(array('pd_id' => $id));
    else:
        $get = $this->Mdl_product->getProduct();
    endif;
    $data['get_p'] = $get->result();
    $this->output->set_output(json_encode($data));
}

}//end of the file
