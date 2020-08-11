<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Contact extends MY_Controller{
    protected $user_id;
    protected $user_name;
    protected $is_login;
    protected $is_admin;

 
    //public variable
    public $today;
    public $time;
    public $date_time;
    public $o_put;

    //-----user info
    protected $ip;
    protected $os;
    protected $browser;

    //--table
    protected $_tb_user = "users";
    protected $_tb_faq = "tbl_faq";
    protected $_tb_notice = "tbl_notification";
    
    

    function __construct(){
        parent::__construct();

        //set the user anonymous info
        $this->ip = $this->u_data["ip"];
        $this->os = $this->u_data["os"];
        $this->browser = $this->u_data["browser"];
        $this->today = date("Y-m-d",time());
        $this->time = date("h:i:s",time());
        $this->date_time = date("Y-m-d h:i:s a",time());
        //---collect the user information 

        //load the library
        $this->load->model("Mdl_contact");
        $this->load->model("Mdl_users");
        $this->load->library("pagination");

    }


function index(){
    //if the user not login will load the default contact page
    if($this->is_login):
            $url = site_url("contact/own");
            if($this->is_admin):
                $url = site_url("contact/admin");
            endif;
            redirect($url);
    endif;
    
    
    //not login user will load the contact page in anonymous option
    $this->data["subview"] = "contact/contact_index";
    $this->data["meta_title"] = "Contact us | Please fill the form";

    $this->load->view("_layout_main",$this->data);

}
//------------
function own(){
    if(!$this->is_login):
        redirect(site_url("contact"));
    endif;
    $cmd = $this->input->post("cmd");
    //$u_id = $this->input->post("user_id");
    $faq_title = $this->input->post("faq_title",true);
    $faq_body = $this->input->post("faq_body",true);
    $faq_email = $this->input->post("faq_email",true);
    $faq_id = $this->input->post("faq_id");

    $msg = "";
    $sent_day = "{$this->today}.{$this->time}";
    $faq_data = array(
        "faq_ip" => $this->ip,
        "faq_user_id" => $this->user_id,
        "faq_email" => $faq_email,
        "faq_title" => $faq_title,
        "faq_body" => $faq_body,
        "faq_date" => $this->today,
        "faq_time" => $this->time
    );
    switch($cmd):
        case"getInfo":
            $where = array("id" => $this->user_id);
            $getInfo = $this->Mdl_users->getUsers($where)->result();
            $this->o_put["getMyInfo"] = $getInfo;

            $this->output->set_output(json_encode($this->o_put));

        break;
        case"readMessage":
            //need the join table this time
            $where = array("faq_id" => $faq_id);
            $get_faq = $this->Mdl_contact->getFaq($where)->result();
            $get_ans = $this->Mdl_contact->getAns($where);
            $this->o_put["get_faq"] = $get_faq;
            $this->o_put["get_ans"] = $get_ans;
            $this->output->set_output(json_encode($this->o_put));
        break;
        case"sentMsg":
            $this->Mdl_contact->saveFaq($faq_data);
            $msg = "Success : your message has been send";

            //--sent notification to admin
            $today = date("Y-m-d h:i:s",time());
            $note_title = "New message from member {$this->user_name} on {$today}!";
            $note_body = "The user name {$this->user_name} has send the message to Admin by IP {$this->ip}";
            $note_data = array(
                "notice_title" => $note_title,
                "notice_body" => $note_body,
                "notice_ip" => $this->ip,
                "by_user_name" => $this->user_name

            );
            $this->Mdl_contact->saveTB($this->_tb_notice,$note_data);
            //--end of notification

            $this->o_put["msg"] = $msg;
            $this->output->set_output(json_encode($this->o_put));
        break;
        case"delMessage":
            $this->Mdl_contact->delMessage(array("faq_id" => $faq_id));
            echo"Message has been deleted!";
        break;
        default:

            $get_all_msg = $this->Mdl_contact->getFaq(array("faq_user_id" => $this->user_id))->result();
            $num_all_msg = count($get_all_msg);

            $page = $this->input->get("page");
            if(!$page):
                $page = 1;
            else:
                $page = $page;
            endif;

            $per_page = 10;
            $conf = array();
            $conf["base_url"] = site_url("contact/own/{$page}");
            $conf["total_rows"] = $num_all_msg;
            $conf["per_page"] = $per_page;
            $this->pagination->initialize($conf);

            $get_my_msg = $this->Mdl_contact->getFaq(array("faq_user_id" => $this->user_id),$conf["per_page"],$this->uri->segment(5))->result();
            $this->data["get_my_msg"] = $get_my_msg;

            $this->data["get_all_msg"] = $get_all_msg;
            $this->data["num_all_msg"] = $num_all_msg;
            $this->data["per_page"] = $per_page;


            $this->data["subview"] = "contact/user_contact";
            $this->data["meta_title"] = "Conact admin 1.0.1 | {$this->user_name}'s message to admin";
        
            $this->load->view("_layout_main",$this->data);
        break;
    endswitch;
    
}

//---------------
function getMyQuestion(){
    //wil return the array list if the user is login or return single if no session

    $where_faq = array();
    if(!$this->is_login):
        $where_faq["faq_ip"] = $this->ip;
        $where_faq["faq_date"] = $this->today;
    else:
        //use ajax to fetch data 
        $where_faq["faq_user_id"] = $this->user_id;
    endif;

    $get_faq = $this->Mdl_contact->getFaq($where_faq);
    $num_faq = count($get_faq);

    $this->o_put["num_faq"] = $num_faq;
    $this->o_put["get_all_faq"] = $get_faq;
    $this->output->set_output(json_encode($this->o_put));

}
//------------
function sendQuestion(){

    $q_title = $this->input->post("faq_title");
    $q_body = $this->input->post("faq_body");
    $q_email = $this->input->post("faq_email");

    
    $faq_id = $this->input->post("faq_id");
    $faq_ip = $this->input->post("faq_ip");

    $faq_data = array(
        "faq_ip" => $this->ip,
        "faq_user_id" => $this->user_id,
        "faq_name" => $this->user_name,
        "faq_email" => $q_email,
        "faq_title" => $q_title,
        "faq_body" => $q_body,
        "faq_date" => $this->today,
        "faq_time" => $this->time
    );
    $where_faq = array();
    
    if(!$this->is_login):
        //no log in can only sen one message per day
        unset($faq_data["faq_name"]);
        unset($faq_data["faq_user_id"]);
        $where_faq["faq_ip"] = $faq_ip;
        
    endif;

    if($faq_id):
        $where_faq["faq_id"] = $faq_id;
        $save = $this->Mdl_contact->saveFaq($faq_data,$where_faq);
    else:
        $save = $this->Mdl_contact->saveFaq($faq_data);
    endif;
    $this->o_put["msg"] = "Success : data has been save";
    $this->output->set_output(json_encode($this->o_put));
    
}

//------------



////////////////////////////////////

}//end of file
