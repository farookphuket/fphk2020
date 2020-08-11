<?php
/*
* class Users last edit on Sat-3-Sep-2016
*
*/
class Mdl_profile extends MY_Model{
    protected $_tb_user = "users";
    protected $_order_by;

    //add $_tb_user on Thu 15 June 2017

    public $ip;
    public $browser;
    public $os;

    /*
      Edit moderate section on 1-Aug-2019
    */
    protected $user_id;
    public $user_name;




    function __construct() {
        parent::__construct();

        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();

        //--- 1-Aug-2019
        $this->user_id = $this->getUserId();
        $this->user_name = $this->getUserName();
        $this->load->model("Mdl_login");
   }


    /*
     *  Last edit this on 22-Dec-2019
     *
     *
     */
     
    function ALL(){
        $get = $this->db
                    ->order_by("date_register","DESC")
                    ->get($this->_tb_user);
        return $get;
    }


    //------- function find added on 21 Jan 2020
    function find($where){
        $get = $this->db
                    ->where($where)
                    ->get($this->_tb_user);
        return $get;
    }



/*
 * user profile 12-Mar-2020
 *
 */
    //----------------------
    //--- profileSave  12-Mar-2020
    function userProfileSave(){
        
        $oP = $this->getEl("oldPass");
        $cP = $this->make_hash($this->getEl("passConfirm"));
        $nP = $this->getEl("newPass");

        $u_name = $this->getEl("u_name");
        $u_id = $this->getEl("u_id");
        $u_email = $this->getEl("u_email");
        $u_tel = $this->getEl("u_tel");
        $about_user = $this->getEl("u_about");
        
       $error_code = 1; 

        $msg = "";

        //--- set user data
        $u_data = array(
            "name" => $u_name,
            "email" => $u_email,
            "tel" => $u_tel,
            "user_ip" => $this->ip,
            "about_user" => $about_user,
        );

        if($oP == $cP):
            //-- save and go
            if($nP != ''):
                //--- change password 

                $u_data["passwd"] = $this->make_hash($nP);
            else:
                //--- run null
            endif;    
            
            $error_code = 0;
            $msg = "<span class='alert alert-success'>Your data has been save</span>";
            $u_data["is_activated"] = 0;
            $u_data["last_update"] = $this->today_andTime;
            $this->SAVE($u_data,$this->_tb_user,array("id" => $u_id));

            $this->sentUserProfileUpdate();
        else:
            //--- wrong pass code return ERROR
                
            $msg = "<span class='alert alert-danger'>Error : wrong pass code</span>";
        endif;
        


        $r_data = array(
            "msg" => $msg,
            "error_code" => $error_code
        );
        return $r_data;

    }
    //---------------
    //--- sentUserProfileUpdate 
    function sentUserProfileUpdate(){
        $u_mail = $this->getEl("u_email");
        $u_name = $this->getEl("u_name");

        $time_limit = (60*60)/2;
        $today = strtotime($this->today_andTime);
        $timeout = $today+$time_limit;
        $time_show = date("Y-m-d H:i:s",$timeout);
        $u_url = site_url("profile/userProfileSetActiveMe/{$this->user_id}/{$timeout}");
        
        //--- set seesion
        // $u_session = array(
        //     "sess_id" => $this->user_id,
        //     "sess_timeout" => $timeout,
        //     "sess_email" => $u_mail
        // );
        // $this->session->set_userdata($u_session);

        $our_web = site_url();
        $mail_title = "make change to your profile {$u_name}";
        $mail_body = "<div style='padding:2px;background-color:#e7e7e7;color:green;'>
 <div style='background-color:white;padding:12'>
     <h1 style='text-align:center'>Request : profile change</h1>
    <h2>Dear {$u_name} please confirm this is you</h2>
     <p>
        you have recieve this e-mail because someone(maybe you) make some change to your profile @{$our_web} on {$this->today_andTime} by IP {$this->ip}

    </p>
    <p>This operation need to confirm in order to log-in back to your account again you have to click the link below</p>
    <p>
        please click <a href='{$u_url}' target='_blank'>Here</a> OR copy and paste the url below in your address bar :<br />
        {$u_url}

    </p>
    <p>please note : your link will be expire on {$time_show} today or in 30 minute.</p>
 </div>           
</div>";

        $this->sendMailTo('info@farookphuket.com',$u_mail,$mail_title,$mail_body);

    }

    function userProfileSetActiveMe($where){
        $email = "";
        $u_id = 0;
        $name = "";
        $url = site_url("login");

        $get = $this->find($where)->result();
        foreach($get as $row):
            $email = $row->email;
            $name = $row->name;
            $u_id = $row->id;

        endforeach;
        //--- 
            $u_data = array(
                "is_activated" => 2,
                "last_update" => $this->today_andTime
            );        

            $this->SAVE($u_data,$this->_tb_user,array("id" => $u_id)); 
            $u = $this->Mdl_login->_user_set_sess($email);
            $this->session->set_userdata($u);

            $url = $u["url"];

            $msg = "<div class='alert alert-success'>
                <h1 class='text-center'>Success</h1>
                <p>
                    Your account ::{$email} has been updated,Thank you.
                </p>
            </div>";
        

        $r_data = array(
            "msg" => $msg,
            "url" => $url
        );
        return $r_data;

    } 




/*
 * END of user profile
 *
 */




















    //-----------Update <Sun-17-Dec-2017></Sun-17-Dec-2017>
    //--getUser will return all user if no id
   function getUsers($where_u = false,$limit=false,$offset=false){
      $get = "";
        if($where_u):
            //return one row
            $get = $this->getTB($this->_tb_user,$where_u,$limit,$offset);
        else:
            //return all rows
            $get = $this->getTB($this->_tb_user,null,$limit,$offset);
        endif;
        return $get;
   }

   //------------


   //-----------------
   function saveUser($data,$where=false){

        $save = 0;
        $id = "";
        if(!$where):
            $save = $this->saveTB($this->_tb_user,$data);
            $id = $save;
        else:
            $save = $this->saveTB($this->_tb_user,$data,$where);
            $id = $where["id"];
        endif;


        return $id;

   }

   //------delUser Sat 30 Dec 2017
   function delUser($where){
       $del = $this->delTB($this->_tb_user,$where);

       if($del):
        return true;
       endif;
       return false;

   }

   //--------End of Sun 17 Dec 2017
   /*
    1-Aug-2019 test the GLOBAL function
   */
   function GET_USER($where=false,$limit=false,$offset=false){
      $get = "";
      if($where):
        $get = $this->db
                    ->where($where)
                    ->order_by("date_register","DESC")
                    ->get($this->_tb_user,$limit,$offset);
        else:
          $get = $this->db
                      ->order_by("date_register","DESC")
                      ->get($this->_tb_user,$limit,$offset);
      endif;
      return $get;
   }
   //----------------
   //----SAVE_USER
   function SAVE_USER($data,$where=false){
     $save = "";
     $user_id = 0;
     if($where):
       //---update
       $save = $this->db
                    ->where($where)
                    ->set($data)
                    ->update($this->_tb_user);
      $user_id = $where["id"];
      else:
        //---new user
        $save = $this->db
                     ->set($data)
                     ->insert($this->_tb_user);
       $user_id = $this->db->insert_id();
     endif;
     return $user_id;
   }
   //----------
   //---DEL_USER
   function DEL_USER($where){
     $this->db
            ->where($where)
              ->delete($this->_tb_user);


   }


   //-------------------------
   /*
    END of GLOBAL test method
    1-Aug-2019 test

   */
   //--------------------------------------
   /*
    Modrate Section create on 1-Aug-2019

   */

   function modGetUser($where=false,$limit=false,$offset=false){
     $get = "";
     $user_id = 0;
     if(!$where):
       $where["{$this->_tb_user}.user_type !="] = 642;
       $where["{$this->_tb_user}.moderate"] = 0;
     else:
       $user_id = $where["{$this->_tb_user}.id"];
     endif;
       $get = $this->GET_USER($where,$limit,$offset);
     return $get;
   }

   function modSaveUser(){
     $user_id = $this->modGetEl("user_id");
     $u_name = $this->modGetEl("user_name");
     $u_email = $this->modGetEl("user_email");
     $u_tel = $this->modGetEl("user_tel");
     //$ban = $this->modGetEl("ban");
     //$active = $this->modGetEl("active");

     $ban = ($ban=$this->modGetEl("ban"))?$ban=2:$ban=0;
     $active = ($active=$this->modGetEl("active"))?$active=2:$active=0;

     $user_data = array(
       "name" => $u_name,
       "email" => $u_email,
       "tel" => $u_tel,
       "is_ban" => $ban,
       "is_activated" => $active,
       "last_update" => $this->today
     );
     $this->SAVE_USER($user_data,array("id" => $user_id));
     $data = array(
       "user_id" => $user_id
     );
     return $data;
   }
   //-----------------------
   //------- modDelUser //-- delete user
   function modDelUser($where){
     $del = $this->DEL_USER($where);
     $get = $this->modGetUser()->result();
     $num = count($get);
     $data = array(
       "last_num" => $num
     );
     return $data;
   }
   //-----modGetEl return the input element
   function modGetEl($el){
     return $this->input->post($el);
   }

   /*
    END Of moderate
   */
   //---------------------------------

}//end class
