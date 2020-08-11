<?php 

    class Seo extends MY_Controller{


        protected $_tb_seo = "seo";

        function __construct(){
            parent::__construct();

        }

        function keyList(){

        }

        function genMetaKeyWord(){
            $this->data["subview"] = "component/_tag_in_head";
            
        }

    }