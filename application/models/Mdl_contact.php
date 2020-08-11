<?php

    class Mdl_contact extends MY_Model{

        
        
        protected $_tb_faq = "tbl_faq";
        protected $_tb_ans = "tbl_faq_answer";
        

        public $user_id;
        public $user_name;
        public $ip;
        public $os;
        public $browser;

        public function __construct(){
            
            parent::__construct();
            $this->user_id = $this->getUserId();
            $this->user_name = $this->getUserName();
            $this->ip = $this->getIP();
            $this->os = $this->getOS();
            $this->browser = $this->getBrowser();
        }

        //----readMessage
        function readMessage($id){
            
            
            $j1 = $this->_tb_faq.".faq_id=".$this->_tb_ans.".faq_id";
            $get = $this->db    
                        ->join($this->_tb_ans,$j1)
                        ->where($id)
                        ->get($this->_tb_faq);
            return $get;

        }

        //------------------
        function getFaq($where = false,$limit=false,$offset=false){
            
            
            if($where):
                /*
                $get_faq = $this->getTB($this->_tb_faq,$where,$limit,$offset)->result();
                comment 26/4/2018
                */
                $q = $this->db
                        ->where($where)
                        ->order_by("faq_date","DESC")
                        ->limit($limit,$offset)
                        ->get($this->_tb_faq);
            else:
                /*
                $get_faq = $this->getTB($this->_tb_faq,null,$limit,$offset)->result();
                comment 26/4/18
                */

                $q = $this->db
                        ->where($where)
                        ->order_by("faq_date","DESC")
                        ->limit($limit,$offset)
                        ->get($this->_tb_faq);

            endif;
            return $q;
        }
        //------------------
        function getAns($where){
            $get = $this->getTB($this->_tb_ans,$where)->result();
            return $get;
        }

        //--------saveFaq
        function saveFaq($data,$where=false){

                $faq_id = "";
                if($where):
                    $faq_id = $where["faq_id"];
                    $save = $this->saveTB($this->_tb_faq,$data,$where);
                else:
                    $save = $this->saveTB($this->_tb_faq,$data);
                    $faq_id = $save;
                endif;
                return $faq_id;
        }
        //----delMessage
        function delMessage($id){
            $this->delTB($this->_tb_faq,$id);
            $this->delTB($this->_tb_ans,$id);
            return true;
        }

}//end of the file 
