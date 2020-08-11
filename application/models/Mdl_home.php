<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Mdl_home extends MY_Model{

    protected $_table_name = 'tbl_article';
    protected $_tb_ar = "tbl_article";
    protected $_order_by = 'order';
    function __construct() {
        parent::__construct();
    }


//--getArticle Sat 21/4/2018
  function getArticle($where=false,$limit=false,$offset=false){
    if($where):
      $get = $this->db
                  ->order_by("date_add","desc")
                  ->limit($limit,$offset)
                  ->where($where)
                  ->get($this->_tb_ar);
    else:
      $get = $this->db
                ->order_by("date_add","desc")
                ->limit($limit,$offset)
                ->get($this->_tb_ar);
    endif;
    
    return $get;
  }


}//end of Mdl_home class
