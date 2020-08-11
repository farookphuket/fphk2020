<?php

//---create on 20 Nov 2018
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends MY_Controller{


    //-- protected string as user info
    protected $user_email;
    protected $user_name;
    protected $user_id;

    //---protect string as google user
    protected $g_name;
    protected $g_email;

    //the table name
    //edit on Thu 8 Jun 2017
    protected $_tb_user = "users";


    public $o_put;
    public $msg;
    public $today;
    public $user_type;
    public $ip;

        function __construct() {
            parent::__construct();
            $this->load->model("Mdl_users");
            $this->load->model("Mdl_login");


            $this->user_email =  $this->getUserEmail();

        $this->data["is_admin"] = $this->is_admin;
        $this->data["is_login"] = $this->is_login;
        $this->data["moderate"] = $this->moderate;


        }



    function index(){
        $this->data["meta_title"] = "{$this->sysName} | {$this->browser}";
        $this->data["subview"] = "users/login/login";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);
    }


    /*
     *  forgot password  11-Mar-2020
     *
     */
    function forgot_pass(){
        $this->data["meta_title"] = "forgot you login?";
        $this->data["subview"] = "users/forgot_pass/_frm_reset";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);
    }
    //------------
    //--- showForm
    function googleLogin(){
            

        $this->data["meta_title"] = "Google login";
        $this->data["subview"] = "users/login/_google_login";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);
    }
    //-----------------------
    //------ useGoogleService
    function useGoogleService(){
		
		$get = $this->Mdl_login->useGoogleService();
		$this->o_put["url"] = $get["url"];
		$this->o_put["msg"] = $get["msg"];
		$this->output->set_output(json_encode($this->o_put));
		
		
	}
    
    
    
    //----------------
    
    /*
     * FB login last update 9-Apr-2020 
     */

    function facebookLogin(){
        $this->data["meta_title"] = "Login with your facebook account";
        $this->data["subview"] = "users/login/_facebook_login";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);

    }

    function useFacebookLogin(){
        $s = $this->Mdl_login->useFacebookLogin();
        $this->o_put["name"] = $this->session->userdata("user_name");
        $this->o_put["url"] = $s["url"];
        $this->o_put["msg"] = $s["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }
    
    /*
     *  END OF FB login 9-Apr-2020
     */

    /*
     *  End forgot possword
     */
            
    function getLogin(){
        $g = $this->Mdl_login->getLogin();
        $this->o_put["msg"] = $g["msg"];
        $this->o_put["url"] = $g["url"];
        $this->output->set_output(json_encode($this->o_put));
    }


}
