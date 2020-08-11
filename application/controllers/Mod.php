<?php


class Mod extends MY_Controller{

    public $user_id;
    public $user_type;
    public $user_name;

    protected $is_login;
    protected $is_admin;
    protected $moderate;

    public $o_put;
    public $sysName = "Moderate";
    public $sysVersion = "2.04";
    public $sysDate = "24-July-2019";

    function __construct(){
        parent::__construct();
        $this->load->model("Mdl_mod");
        $this->load->model("Mdl_users");
        if(!$this->user_is_mod()):
          redirect(site_url("users/logout"));
          exit();
        endif;
        $this->data["sysName"] = $this->sysName;
        $this->data["sysVersion"] = $this->sysVersion;
        $this->data["sysDate"] = $this->sysDate;

        $this->user_id = $this->getUserId();
    }

    function index(){
        if(!$this->moderate):
          echo"Error : you are not MOD";
          exit();
        endif;
        $this->data["subview"] = "Mod/mod_index";
        $this->data["meta_title"] = "Welcome | Moderate | {$this->user_name}";
        $tmp = "_MOD_TMP";
        $this->load->view($tmp,$this->data);
    }

    //-----------
    //---editMyProfile
    function editMyProfile(){
      $get = $this->Mdl_mod->GET_PROFILE();
      $this->o_put["get"] = $get;
      $this->output->set_output(json_encode($this->o_put));
    }

    //---modCheckPass
    function modCheckPass(){
      $check = $this->Mdl_mod->modCheckPass();
      $match = $check["match"];
      $this->o_put["match"] = $match;
      $this->output->set_output(json_encode($this->o_put));
    }
    //----------------
    //--------saveMyProfile
    function saveMyProfile(){
      $save = $this->Mdl_mod->saveMyProfile();

      $this->o_put["new_pass"] = $save["new_pass"];
      $this->output->set_output(json_encode($this->o_put));
    }
    //-----------


}
