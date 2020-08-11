<?php
/*
* class Users last edit on Sat-3-Sep-2016
*
*/
class Mdl_login extends MY_Model{
    protected $_tb_user = "users";
    protected $_order_by;

    //add $_tb_user on Thu 15 June 2017

    public $ip;
    public $browser;
    public $os;

    /*
     *  Copy from "MY_Model.php" on 31-Dec-2019
     *
     */
    protected $is_login;
    protected $is_admin;
    protected $moderate;
    protected $user_id;
    public $user_name;
    public $user_type;
    public $user_email;
    public $user_type_text;



    function __construct() {
        parent::__construct();

        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();
        
   }


    function all(){
        $get = $this->db
                    ->order_by("date_register","DESC")
                    ->get($this->_tb_user);
        return $get;
    }

    function find($id){
        $get = $this->db
                    ->where($id)
                    ->get($this->_tb_user);
        return $get;
    }

    function getLogin(){
        $u_email = $this->getEl("u_email");
        $u_pass = $this->getEl("u_pass");
        $de_pass = $this->make_hash($u_pass);

        $url = site_url("login");
        $err = 0;
        $have = $this->_ck_user($u_email,$de_pass);
        if($have["have"] != 0):
            
            if($this->_user_is_ban($u_email)):
               $msg = "your account is BAN"; 
                $err = 1;
            endif;
            if(!$this->_user_is_activated($u_email)):
                $msg = "your account is NOT ACTIVATE";
                $err = 1;
            endif;
        else:
            $msg = "Sorry! wrong user name or password";
            $err = 1;
        endif;
        if($err == 0):
            //$t = $this->_user_privilege($u_email);
            $sess = $this->_user_set_sess($u_email);

            $url = $sess["url"];
            $this->session->set_userdata($sess);
            $em = $sess["user_email"];
            $msg = "Welcome {$sess['user_name']} you are {$sess['user_type_text']}";
        endif;

        $r_data = array(
            "msg" => $msg,
            "url" => $url
        );
        return $r_data;
    }
   

    //-- check if this user is exited
    function _ck_user($email,$pass){
        $where = array(
            "email" => $email,
            "passwd" => $pass
        );
        $get = $this->find($where)->result();
        $count = count($get);

        
        $r_data = array("have" => $count);
        return $r_data;
                    
    }

    ///////////////////////////////
    //------ find if the user ban
    function _user_is_ban($email){
        $where = array(
            "email" => $email,
            "is_ban !=" => 0
        );
        $get = $this->find($where)->result();
        $count = count($get);
        $ban = 0;
        if($count != 0):
           $ban = 1;      
        endif;
        return $ban;
    }
    /////////////////////////////////
    //--------- _user_is_activated
    function _user_is_activated($email){
        $where = array(
            "email" => $email,
            "is_activated !=" => 0
        );
        $active = 1;
        $get = $this->find($where)->result();
        $count = count($get);
        if($count == 0):
            $active = 0;
        endif;
        return $active;
    }
    ///////////////////////////////////
    /*
     *  now get the user privilege
     *  Admin
     *  Moderate
     *  Member
     */

    function user_privilege($u){

        $where = array("email" => $u);
        $get = $this->find($where)->result();
        
        $get_type = "Anonymous";
        $mod = 0;
        $admin = 0;

        foreach($get as $row):

            $mod = $row->moderate;           
            if($row->user_type == 642):
                $admin = 1;
            endif;
            $get_type = "Member";
                
        endforeach;
        if($admin != 0):
             
            $this->is_admin = 1;
            $get_type = "Admin";
            endif;

        if($mod != 0):
            $this->moderate = 1;
            $get_type = "Moderate";
            endif;

        
        $this->user_type_text = $get_type;
        return $get_type;
    }
    //--------------------------------
    /////////////////////////////////
    //------    _user_set_sess
    function _user_set_sess($mail){
        $name = "";
        $email = "";
        $u_id = "";
        $url = site_url();
        $where = array(
            "email" => $mail
        );
       $get = $this->find($where)->result(); 
        foreach($get as $row):
            $name = $row->name;
            $email = $row->email;
            $u_id = $row->id;
        endforeach;

            $gt = $this->user_privilege($email);

            
            if($this->user_type_text == "Moderate"):
                $url = site_url("mod");
                $this->moderate = 1;
               endif; 
            if($this->user_type_text == "Admin"):
                $url = site_url("admin");
                $this->is_admin = 1;
                endif;

            if($this->user_type_text == "Member"):
                $url = site_url("users/u");
                endif;
            $u_data = array(
                "user_name" => $name,
                "user_id" => $u_id,
                "user_email" => $email,
                "user_type_text" => $gt,
                "is_login" => true,
                "is_admin" => $this->is_admin,
                "moderate" => $this->moderate,
                "url" => $url
            );

            //---   set user session

            return $u_data;
    }
    
    
    //--------- useGoogleService
    function useGoogleService(){
		$u_email = $this->getEl("gmail");
		$u_name = $this->getEl("google_name");
		//--- check if this user exited
		$ck = $this->find(array("email" => $u_email))->result();
		$num_ck = count($ck);
		
		$u = $this->_user_set_sess($u_email);
		//---- 
		if($num_ck == 0):
			$msg = "Welcome {$u_name} CODE : NEW_REGISTER";
			$url = site_url("users/u");
			
			$about_user = "<div class='card'>
			<div class='card-header'>
				<h1 class='text-center bg-primary'>Dear {$u_name}</h1>
			</div>
			<div class='card-body'>
				<p>
					your account has create by your google account which is using you google user name @{$u_name} as your password.
				</p>
				<p>
					please feel free to change it as you wish.
				</p>
			
			</div>
			</div>";
			$u_new_pass = $this->make_hash($u_name);
			$u_new_data = array(
				"name" => $u_name,
				"passwd" => $u_new_pass,
				"user_ip" => $this->ip,
				"email" => $u_email,
				"user_type" => 409,
				"is_activated" => 1,
				"date_register" => $this->today_andTime,
				"about_user" => $about_user
			);
			
			$this->SAVE($u_new_data,$this->_tb_user);
		else:
			
			$this->session->set_userdata($u);
			$url = $u["url"];
			$msg = "Welcome back {$u_name}";
			
		endif;
		
		
		//$msg = "hello there this is your email {$u_email}";
		
		
		
		
		//--- sent respons back with the url for redirect
		$r_data = array(
			"msg" => $msg,
			"url" => $url
		);
		
		return $r_data;
		
	}
	
	
	/*
	 *  FB login create on 9 Apr 2020
	 * 
	 */
	 function useFacebookLogin(){
		 $url = "";
		 $msg = "";
		 $action_id = $this->getEl("action_id");
		 
		 if(!$action_id):
			
				$msg = "There is no action!";
			else:
			
			$name = $this->getEl("fb_name");
			$email = $this->getEl("fb_email");
			
			
			
			if($email == 0):
				$email = $action_id;
			endif;
			//$msg = "welcome {$name} your email is {$email}";
			//-- check user
			$create_new = 0;
			$e_name = $this->find(array("name" => $name))->result();
			if(count($e_name) == 0):
				$create_new = 1;
			endif;
			$ex_email = $this->find(array("email" => $email))->result();
			if(count($ex_email) == 0):
				$create_new = 1;
			endif;
			
			
			if($create_new != 0):
				$this->facebook_create_user($name,$email);
				
				$u = $this->_facebook_set_user();
				$eurl = $u["url"];
				$msg = "Welcome {$name} ,CODE : new user";
			else:
				
				$u = $this->_facebook_set_user();
				
				$eurl = $u["url"];
				$ename = $u["name"];
				$msg = "Welcome back {$ename}, CODE : exited user";
			endif;
			$url = $eurl;
			
		 endif;
		 
		 $r_data = array(
			"msg" => $msg,
			"url" => $url
 		 );
 		 
 		 return $r_data;
		 
	}
	
	function facebook_create_user($name,$email){
		//-- new user data
		$about_user = "<div class='card'>
			<div class='card-header bg-warning'>
				<h2 class='text-center'>info {$name}</h2>
			</div>
			<div class='card-body'>
				<p>dear {$name} as you maybe know that your user account has created without an email this will maybe cause error message in the future if you notice this please refer to edit your profile by adding your valid email in the e-mail field to avoid an Error message</p>
				<div class='table-responsive'>
				<table class='table table-striped'>
					<tr>
						<th>user name</th>
						<td>{$name}</td>
					</tr>
					<tr>
						<th>password</th>
						<td>{$name}</td>
					</tr>
					<tr>
						<th>email</th>
						<td>{$email}</td>
					</tr>
				</table>
				</div>
				<p>note : you can ignore this message by delete all of this message in the textbox then press 'save' button</p>
			</div>
		</div>";
		$nP = $this->make_hash($name);
		
		
		$fb_data = array(
			"name" => $name,
			"passwd" => $nP,
			"email" => $email,
			"about_user" => $about_user,
			"user_ip" => $this->ip,
			"user_type" => 409,
			"is_activated" => true,
			"date_register" => $this->today_andTime
		);
		$this->SAVE($fb_data,$this->_tb_user);
	}
	
	function _facebook_set_user(){
		$email = $this->getEl("fb_email");
		$name = "";
		
		$is_admin = "";
		$moderate = "";
		$user_type_text = "";
		$user_id = "";
		$url = "";
		
		
		if($email == 0):
			$email = $this->getEl("action_id");
		endif;
		$get = $this->find(array("email" => $email))->result();
		if(count($get) != 0):
			foreach($get as $row):
				$name = $row->name;
				$user_id = $row->id;
				if($row->user_type == 642):
					$is_admin = true;
				endif;
				
				if($row->moderate != 0):
					$moderate = true;
				endif;
			endforeach;
			
			if($is_admin):
				$url = site_url("admin/u");
				$user_type_text = "Admin";
			elseif($moderate):
				$url = site_url("moderate/u");
				$user_type_text = "Moderate";
			else:
				$url = site_url("users/u");
				$user_type_text = "Member";
			endif;
			
			$user_data = array(
				"user_name" => $name,
				"user_email" => $email,
				"user_id" => $user_id,
				"user_type_text" => $user_type_text,
				"is_login" => true,
				"is_admin" => $is_admin,
				"moderate" => $moderate
			);
			$this->session->set_userdata($user_data);
			
		endif;
		$r_data = array(
			"url" => $url,
			"name" => $name
			
		);
		return $r_data;
	}
    

}//end class
