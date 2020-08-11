<?php 



class Mdl_register extends MY_Model{

    //---table
    protected $_tb_user = "users";
    

    function __construct(){
        parent::__construct();

        
    }

    function getUser($where=false){
        $get = 0;

        if($where):
            $get = $this->db 
                        ->where($where)
                        ->get($this->_tb_user);
        endif;
        return $get;
    }

}//----end of file