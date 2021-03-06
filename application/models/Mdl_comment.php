<?php

class Mdl_comment extends MY_Model{


    //--user system
    public $ip;
    public $os;
    public $browser;
    public $browser_name;
    
    //--user
    public $user_id;
    public $user_name;
    public $user_email;
    public $user_uniq_id;

    public $user_sess_name;
    public $user_sess_email;

    //--table
    protected $_tb_comment = "tbl_comment";
    
    function __construct(){
        parent::__construct();
        
    }

    function find($where){
        $get = $this->db
                ->where($where)
                ->get($this->_tb_comment);
        return $get;
    }

    function all(){
        $get = $this->db
                    ->order_by("c_date_create","DESC")
                    ->get($this->_tb_comment);
        return $get;
    }

    function getComment($where=false,$limit=false,$offset=false){
        
        if(!$where):
            $get = $this->db
                    ->order_by("c_date_create","DESC")
                    ->limit($limit,$offset)
                    ->get($this->_tb_comment);
        else:
            $get = $this->db
                    ->order_by("c_date_create","DESC")
                    ->limit($limit,$offset)
                    ->where($where)
                    ->get($this->_tb_comment);
        endif;
        
        
        return $get;
    }

    

    function sentUserLink(){
        $name = $this->getEl("c_user_name");
        $email = $this->getEl("c_user_email");
        $sec_name = $this->getEl("sec_name");
        $sec_id = $this->getEl("sec_id");
        $cur_url = $this->getEl("cur_url");
        //-- data to set
        $uniq_id = $this->randomChar(25);
        $create = strtotime($this->today_andTime);
        $expire = $create+1800;
        $ex_show = date("Y-m-d h:i:s",$expire);
        $u_data = array(
            "c_user_uniq" => $uniq_id,
            "c_user_email" => $email,
            "c_user_name" => $name,
            "c_date" => $this->today,
            "c_date_create" => $this->today_andTime,
            "c_section_name" => $sec_name,
            "c_comment_url" => $cur_url,
            "c_item_id" => $sec_id,
            "c_user_ip" => $this->ip
        );
        $this->SAVE($u_data,$this->_tb_comment);

        /*
         *  sent the email to this user a confirm link
         *
         */
        $cf_link = site_url("comment/isRealUser/{$uniq_id}");
        $our_web = site_url();
        $cur_url = $this->getEl("cur_url");
        $u_title = "Please confirm this was you";
        $u_body = "<p>
dear {$name} you have receive this email to confirm that this is your request 
</p><p>Link 
<a href='{$cf_link}' target='_blank'>Here</a>
</p>
<p>
Please click on the above link before {$ex_show} today.
</p>
";

        $this->sendMailTo("info@farookphuket.com",$email,$u_title,$u_body);
        //--- end sent email
        $msg = "your request has been send! please check your email to confirm your request before {$ex_show} today!";
        $r_data = array(
            "msg" => $msg
        );
        return $r_data;
    }
    
    //--- user has confirm his email
    function isRealUser($id){
        //---   clear the old session if it was there
        $old_sess = array(
            "sess_user_name",
            "sess_user_email",
            "sess_user_expire",
            "action_code"
        );
        if($this->session->userdata("sess_user_expire")):

            $this->session->unset_userdata($old_sess);
            $this->session->sess_destroy();
            $msg = "<p>There is old action it has deleted</p>";
        endif;

        //-- the link will only open from user click on his email
        $name = "";
        $email = "";
        $action_id = "";
        $c_id = 0;
        $time_now = strtotime($this->today_andTime);
        $create = "";
        $expire = "";
        $where = array(
            "c_user_uniq" => $id,
            "c_date" => $this->today,
            "c_user_ip" => $this->ip
        );
        $get = $this->getComment($where)->result();
        $num = count($get);
        foreach($get as $row):
            $name = $row->c_user_name;
            $email = $row->c_user_email;
            $action_id = $row->c_user_uniq;
            $c_id = $row->c_id;
            $create = strtotime($row->c_date_create);
            $expire = (1800)+$create;
            $ex_show = date("Y-m-d H:i:s",$expire);
        endforeach; 
            $u_data = array(
                "action_code" => $action_id,
                "sess_user_name" => $name,
                "sess_user_email" => $email,
                "sess_user_expire" => $expire
            );
            $this->session->set_userdata($u_data);




        if($time_now < $expire):
            $msg = "<p>Thank you for your confirmed</p><p>  your link will be expire at {$ex_show}</p>";
        else:
           if($this->session->userdata("sess_user_expire")): 
                $this->session->unset_userdata($old_sess);
                $this->session->sess_destroy();
            endif;

                $msg = "<div class='text-white'>
 <div class='alert alert-danger'>                   
<p>Sorry your link is expired</p></div></div>";
        endif;
        //--- set user session
        $r_data = array(
            "msg" => $msg
        );
        return $r_data;

    }

    //---------     uSaveComment
    function uSaveComment(){
        $name = $this->session->userdata("sess_user_name");
        $email = $this->session->userdata("sess_user_email");

        $owner_email = $this->getEl("owner_email");
        $c_id = $this->getEl("c_id");
        $action_code = $this->getEl("action_code");
        $sec_name = $this->getEl("sec_name");
        $sec_id = $this->getEl("sec_id");
        $cur_url = $this->getEl("cur_url");
        $c_title = $this->getEl("c_title");
        $c_body = $this->getEl("c_body");

        $u_data = array(
            "c_comment_title" => $c_title,
            "c_comment_body" => $c_body,
            "c_user_uniq" => $action_code,
            "c_user_ip" => $this->ip,
            "c_user_name" => $name, 
            "c_user_email" => $email 
        );

        if($c_id):
            $u_data["c_date_update"] = $this->today_andTime;
            $this->SAVE($u_data,$this->_tb_comment,array("c_id" => $c_id));

        $msg = "update @{$c_id}  {$owner_email} the action id {$action_code}";
        else:
            //--- create new post
            unset($u_data["c_date_update"]);
            $u_data["c_section_name"] = $sec_name;  
            $u_data["c_item_id"] = $sec_id;  
            $u_data["c_date"] = $this->today;  
            $u_data["c_comment_url"] = $cur_url;
            
            $c_id = $this->SAVE($u_data,$this->_tb_comment);
            $msg = "Success : your comment has been set @{$c_id} on action id @{$action_code}";  
        endif;
        $r_data = array(
            "msg" => $msg,
            "c_id" => $c_id
        );
        return $r_data;
    }


    /*
     *  Admin Section 4-Feb-2020
     *
     */

    

    function adminSave(){

        $action_code = $this->getEl("action_code");
        $c_id = $this->getEl("c_id");
        $c_title =$this->getEl("c_title");
        $c_body = $this->getEl("c_body");
        $c_is_show = $this->getEl("c_is_show");

        !$c_is_show?$c_is_show = 0:$c_is_show=2;

        //--- user comment data
        $c_data = array(
            "c_show" => $c_is_show,
            "c_comment_title" => $c_title,
            "c_comment_body" => $c_body,
            "c_date_update" => $this->today_andTime
        );

        if($action_code):
            $msg = "Success : data has been save @{$action_code}";
           $this->SAVE($c_data,$this->_tb_comment,array("c_id" => $c_id)); 
        endif;


        $r_data = array(
            "msg" => $msg,
            "c_id" => $c_id
        );
        return $r_data;
            
        }
    //----------------------
    //---   admninDel
    function adminDel($id){
        $get = $this->find($id);
        $this->DEL(array("c_id" => $id),$this->_tb_comment);
        $msg = "Success : item has been removed";
        $r_data = array(
            "msg" => $msg
        );
       return $r_data; 
    }


}//end of file
