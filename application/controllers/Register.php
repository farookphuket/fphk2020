<?php 


class Register extends MY_Controller{


    public $user_type;
    
    protected $user_id;
    protected $user_name;
    protected $user_email;

    protected $_tb_user = "users";


    //----output
    public $o_put;
    public $msg;

    function __construct(){
        parent::__construct();

        $this->load->model("Mdl_register");
        $this->load->model("Mdl_users");

    }


    function index(){
        $this->data["subview"] = "users/frm_register";
        $this->data["meta_title"] = "New register ";

        $tmp = "_layout_main";

        $this->load->view($tmp,$this->data);
    }


    //----check email
    function chEmail(){
        $email = $this->input->post("user_email");
        
        $ch = $this->_chExitEmail($email);
        
        $this->o_put["msg"] = $ch["msg"];
        $this->o_put["err"] = $ch["err"];
        $this->output->set_output(json_encode($this->o_put));
        
    }


    //----check user name
    function chName(){
        $name = $this->input->post("user_name");
        $n = $this->_chExitUser($name);
        
        $this->o_put["err"] = $n["err"];
        $this->o_put["msg"] = $n["msg"];

        $this->output->set_output(json_encode($this->o_put));
    }

    

    //-------check if the user name is exited
    function _chExitUser($name){
        /*---in the future if there is another like check for the name resurve is need so we can extend this method for another check  
        //---return msg and status
        */
        $data = array();
        $msg = "";
        $err = 0;

        $get = $this->Mdl_register->getUser(array("name" => $name))->result();
        $num = count($get);
        if($num >= 1):
            $err = 1;
            $msg = "Error : The name {$name} is already exited.";
        else:
            $err = 0;
            $msg = "The name {$name} is okay";
        

        endif;
        $data["err"] = $err;
        $data["msg"] = $msg;
        return $data;
    }

    //---check if the email is exited
    function _chExitEmail($email){
        $pass = 0;
        $data = array();
        $err = 0;
        $msg = "";
        //---check validate email
        if(!$this->is_valid_email($email)):
            $err = 1;
            $msg = "Error : not valid email";
        else:

            $get = $this->Mdl_register->getUser(array("email" => $email))->result();
            $num = count($get);
            if($num != 0):
                $err = 1;
                $msg = "Error : The email {$email} is exited";
            else:
                $err = 0;
                $msg = "The email {$email} is okay to use";
            endif;

        endif;
        
        $data["err"] = $err;
        $data["msg"] = $msg;
        return $data;
        
    }

    function userRegister(){
        //---last check
        $reg_name = $this->input->post("user_name");
        $reg_email = $this->input->post("user_email");
        $reg_pass = $this->make_hash($this->input->post("user_pwd"));
        
        $site = site_url();
        $msg_tmp_1 = "<h2>Dear {$reg_name}</h2><p>welcome to {$site}.</p>";
        //---add new user
        $u_data = array(
            "name" => $reg_name,
            "passwd" => $reg_pass,
            "email" => $reg_email,
            "date_register" => $this->today_andTime,
            "user_type" => 409,
            "about_user" => $msg_tmp_1,
            "user_ip" => $this->Mdl_users->ip
        );
        $u_key = $this->Mdl_users->saveUser($u_data);
        
        //---sent to user email for the activate key
        $active_url = site_url("register/cmdActiveUser/{$u_key}");

        //---email to user
        $uEmail_title = "Hello {$reg_name}, welcome to {$site}.";

        $uEmail_body = "<h2>Dear {$reg_name}</h2><p>You have registered with {$site} on {$this->today_andTime}</p><p>You have to activate your account before you can login</p><strong>Please click on </strong><p><a href='{$active_url}' target='_blank'>Activate my account</a></p>";
        
        //---send user email
        $this->sendMailTo(null,$reg_email,$uEmail_title,$uEmail_body);

        //---send email to admin
        $aEmail_title = "New register on {$site}!";
        $aEmail_body = "<h1>New register from {$site} by {$reg_name}</h1><p>Date on {$this->today_andTime}</p><p>Got new member!!.</p>";
        $this->sendMailTo(null,$this->admin_email,$aEmail_title,$aEmail_body);

        //---display the result
        $this->o_put["msg"] = "You have registered.";
        $this->output->set_output(json_encode($this->o_put));
    }
    //---------------------------
    //------cmdActiveUser
    function cmdActiveUser($id){
        //---search by id
        $get = $this->Mdl_users->getUsers(array("id" => $id))->result();

        //--user name
        $u_name = "";
        $u_email = "";
        $u_id = "";

        $msg = "";
        $err = 0;

        if(count($get) != 0):
            foreach($get as $row):
                $u_name = $row->name;
                $u_email = $row->email;
                $u_id = $row->id;
            endforeach;

            //---update user account
            $u_data = array("is_activated" => 1);
            $this->Mdl_users->saveUser($u_data,array("id" => $u_id));
            $msg = "<p><span class='alert alert-success'>Success</span>: your account has been activated</p><p>Please go to login page</p>";


            //---send admin email
            $emailTitle = "The user name {$u_name} has activate his account!";
            
            $emailBody = "<h1>The user {$u_name}</h1><p>user email {$u_email} has been activate his account name {$u_name} on Date {$this->today_andTime}</p>";
            $this->sendMailTo(null,$this->admin_email,$emailTitle,$emailBody);

        else:
            $msg = "Error : we cannot find your account!";
            $err = 1;
        endif;

        //---display on the screen
        $this->data["msg"] = $msg;
        $this->data["subview"] = "users/user_is_activate";
        $this->data["meta_title"] = "Activate user from email link";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);
    }
    //------------------------
    
    
}//---end of class Register end of file Register.php
