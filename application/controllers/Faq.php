<?php 

class Faq extends MY_Controller{

    //------only work on none login user page

    protected $user_id;
    protected $user_name;
    protected $is_login;
    protected $is_admin;

    //table faq and table answer
    protected $_tb_faq = "tbl_faq";
    protected $_tb_ans = "tbl_faq_answer";

    public $today;
    public $time;
    public $o_put;
     
    //--user info
    public $ip;
    public $browser;
    public $os;

    //-- simple sys info
    public $sysName = "F.A.Q 3";
    public $sysVersion = "3.25";
    public $sysDate = "5-Dec-2019";

    public function __construct(){
        parent::__construct();
        $this->today = date("Y-m-d",time());
        $this->time = date("h:i:s",time());

        //modal
        $this->load->model("Mdl_users");
        $this->load->model("Mdl_faq");
        $this->ip = $this->Mdl_faq->getIP();
        $this->browser = $this->Mdl_faq->getBrowser();
        $this->os = $this->Mdl_faq->getOS();
        
        $this->data["sysName"] = $this->sysName;
        $this->data["sysVersion"] = $this->sysVersion;
        $this->data["sysDate"] = $this->sysDate;
        $this->load->library("pagination");

    }

    function index(){
        if($this->is_login):
            $url = site_url("faq/u");
            if($this->is_admin):
                $url = site_url("faq/admin");
            endif;
            if($this->moderate):
                $url = site_url("faq/mod");
            endif;
            redirect($url);
        endif;
        $this->data["meta_title"] = "Contact our team or feel free to leave your own question here";
        
        $this->data["faq_code"] = $this->randomChar(75);
        $this->data["faq_id"] = 0;
        $this->data["faq_user_name"] = $this->session->userdata("faq_user_name");
        $this->data["faq_user_email"] = $this->session->userdata("faq_user_email");
        $this->data["faq_user_confirm"] = $this->session->userdata("faq_user_confirm");

        $this->data["subview"] = "faq/faq_index";
        $this->load->view("_layout_main",$this->data);

    }

    //----------






    //----- getFaqList
    function getFaqList($seg=1){
        $where = array(
            "faq_is_show !=" => 0
        );
        $get = $this->Mdl_faq->getFaq($where)->result();
        $num = count($get);

        //---pagination
        $per_page = 12;
        $page = $seg;
        $url = "getFaqList";
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_faq = $this->Mdl_faq->getFaq($where,$per_page,$start)->result();

        if($num >= $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;

        $this->o_put["get_all"] = $get;
        $this->o_put["get_faq"] = $get_faq;
        $this->o_put["num"] = $num;

        $this->output->set_output(json_encode($this->o_put));
    }


    /*
     * Anonymous or not login section
     * 21-Mar-2020
     *
     */

    function faqGuestList($page=1){
        $where = array(
            "faq_is_show !=" => 0
        );
        $get = $this->Mdl_faq->faqGuestList($where)->result();
        $num = count($get);

        //-- pagination
        $url = "faqGuestList";
        $per_page = 2;
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_faq = $this->Mdl_faq->faqGuestList($where,$per_page,$start)->result();

        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;
        $this->o_put["get_all"] = $get;
        $this->o_put["get_faq"] = $get_faq;
        $this->output->set_output(json_encode($this->o_put));

    }


    //--- guest sent request
    function faqGuestRequest(){
        $s = $this->Mdl_faq->faqGuestRequest();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["faq_id"] = $s["faq_id"];  
        $this->output->set_output(json_encode($this->o_put));
    }


    function faqGuestConfirm($code,$time){
        $time_now = strtotime($this->today_andTime);
       $time_left = $time-$time_now; 

        $faq_page = site_url("faq");
        $msg = "";
        $meta_title = "";
        if($time_left <= 3):
            $msg = "<div class='alert alert-danger'><h1 class='text-center'>Sorry!</h1>
<p>your link has expired please go to visit {$faq_page}</p>
        </div>";
            $meta_title = "Sorry!";
        else:
            $s = $this->Mdl_faq->faqGuestHasConfirm($code);
            $this->data["faq_id"] = $s["faq_id"];
            $meta_title = "Thank you";

            $msg = $s["msg"];
        endif;

        $this->data["msg"] = $msg;
        $this->data["meta_title"] = $meta_title;
        $this->data["subview"] = "faq/user_has_confirm";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);

    }

    function faqGuestSave(){
        $s = $this->Mdl_faq->faqGuestSave();
        $this->o_put["msg"] = $s["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }



    /*
     *
     * End of NONE login section
     *
     */
    /*
     * User section START 17-Mar-2020
     *
     */
    function u(){

        if(!$this->is_login):
            echo"You're NOT login";
            redirect(site_url("login"));
            exit();
        endif; 
        $get_user = $this->Mdl_faq->faqUserGetList(array("faq_user_id" => $this->user_id))->result();

        $meta_title = "dear {$this->user_name} please feel free to ask we will get back to you as fast as we can";
        $subview = "users/faq/index";

        $tmp = "_MEMBER_TMP";
        $this->data["get_user"] = $get_user;
        $this->data["user_id"] = $this->user_id;
        $this->data["subview"] = $subview;
        $this->data["meta_title"] = $meta_title;
        $this->load->view($tmp,$this->data);
    }
    //------------
    //---   faqUserGetList
    function faqUserGetList($page=1){
        $where = array("faq_user_id" => $this->user_id);
        $s = $this->Mdl_faq->faqUserGetList($where)->result();
        $this->o_put["get_my_faq"] = $s;
        $this->output->set_output(json_encode($this->o_put));
    }


    function faqUserSave(){
        $s = $this->Mdl_faq->faqUserSave();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["faq_id"] = $s["faq_id"];
        $this->output->set_output(json_encode($this->o_put));
    }

    function faqUserHasConfirm($code,$time){

        $time_now = strtotime($this->today_andTime);
        $time_left = ($time-$time_now)/60;

        $time_1 = date("Y-m-d H:i:s",$time);
        //$time_show = date("Y-m-d H:i:s",$time_out);
        
            if($time_left <= 3):
                $msg = "<div class='alert alert-danger'><h1 class='text-center'>Error :</h1><p>your time up!</p></div>";
            else:

        $s = $this->Mdl_faq->faqUserHasConfirm(array("faq_uniq_id" => $code));
        $msg = $s["msg"];
        endif;

        //echo"{$msg} OKEY";
        $this->data["msg"] = $msg;
        $this->data["subview"] = "users/faq/user_has_confirm";
        $this->data["meta_title"] = "Thank you for your confirmation!";
        $tmp = "_MEMBER_TMP";
        $this->load->view($tmp,$this->data);
    }
    //------------------
    //--- faqUserViewFaq
    function faqUserViewFaq($id){
        $where = array("faq_uniq_id" => $id);
        $s = $this->Mdl_faq->faqUserViewFaq($where)->result();
        $this->o_put["get"] = $s;
        $this->output->set_output(json_encode($this->o_put));
    }
    /*
     *
     * User section END
     *
     *
     */






    //----getMyFaq
    function getMyFaq($code){
        $where = array(
            "faq_ip" => $this->ip,
            "faq_date" => $this->today,
            "faq_uniq_id" => $code
        );
        $get = $this->Mdl_faq->find($where)->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    } 
    
    //----------
    //---saveFaq
    function saveFaq(){
        $s = $this->Mdl_faq->saveFaq();
 
        $this->o_put["faq_id"] = $s["faq_id"];
        $this->o_put["msg"] = $s["msg"];
        $this->output->set_output(json_encode($this->o_put));
        
    }
    //---------------
    /*
     *  isRealUser 7-Feb-2020
     *  sent the code to this user request via email
     */ 
    function isRealUser(){
        $s = $this->Mdl_faq->isRealUser();
        $msg = $s["msg"];
        $this->o_put["msg"] = $msg;
        $this->o_put["faq_id"] = $s["faq_id"];
        $this->output->set_output(json_encode($this->o_put)); 
    }
    //----------------
    //---   userHasConfirm
    function userHasConfirm($code){

        $c = $this->Mdl_faq->userHasConfirm($code);

        $this->data["msg"] = $c["msg"];
        //$this->data["faq_id"] = $c["faq_id"];
        $this->data["subview"] = "faq/user_has_confirm";
        $tmp = "_layout_main";
        $this->load->view($tmp,$this->data);

    }

    /*
     *  END OF FAQ user section
     */
    /*
     *  Mod section START 18-12-2019 
     */
   /*mod section */
    function mod(){
        if(!$this->moderate):
            redirect(site_url("users/logout"));
            exit();
        endif;
        echo"This is the mod section";
    }
    

   /*   End of mod section */

    /*
    //---Admin section
    //--last update 25-july-2019 11:00 a.m.
    */
    function admin(){
        if(!$this->is_admin):
            redirect(site_url("users/logout"));
            exit();
        endif;
        $this->data["meta_title"] = "Manage the F.A.Q from the web user | {$this->user_type_text}";
        $this->data["subview"] = "admin/faq/faq_index";
        $tmp = "_ADMIN_TMP";

        $this->load->view($tmp,$this->data);
    }

    //-------
    function faqAdminGet($page=1){
        $s = $this->Mdl_faq->faqAdminGet()->result();
        $num = count($s);
        //--- pagination
        $url = "faqAdminGet";
        $per_page = 4;
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_faq = $this->Mdl_faq->faqAdminGet(null,$per_page,$start)->result();

        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;

        $this->o_put["get"] = $s;
        $this->o_put["get_faq"] = $get_faq;
        $this->output->set_output(json_encode($this->o_put));
    }

    function faqAdminEdit($id){
        $get = $this->Mdl_faq->faqAdminGet(array("faq_id" => $id))->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }


    function faqAdminSave(){
        $s = $this->Mdl_faq->faqAdminSave();
        $this->o_put["msg"] = $s["msg"];
        $this->o_put["faq_id"] = $s["faq_id"];
        $this->output->set_output(json_encode($this->o_put));
    }

    //-----------------
    //--- faqAdminDel

    function faqAdminDel($id){
        $del = $this->Mdl_faq->faqAdminDel(array("faq_id" => $id));
        $this->o_put["msg"] = "success : data removed";
        $this->output->set_output(json_encode($this->o_put));
    }









    /*
     * END of Admin 19-Mar-2020
     */








    //---adminGetAll 25-july-2019
    function adminGetAll($page=1){
        $get = $this->Mdl_faq->all()->result(); 
        $num = count($get);

        //--pagination 
        $per_page = 4;
        $url = "adminGetAll";
        $conf = $this->getConfPagin($per_page,$num,$url);
        $this->pagination->initialize($conf);
        $start = ($page-1)*$per_page;
        $get_faq = $this->Mdl_faq->getFaq("",$per_page,$start)->result();

        if($num > $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
            endif;

        $this->o_put["get"] = $get_faq;
        $this->o_put["get_all"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }
    //----------
    //----adminEdit
    function adminEdit($faq_id){
        
        $where = array("faq_id" => $faq_id);
        $get = $this->Mdl_faq->find($where)->result();
        $this->o_put["get"] = $get;
        $this->output->set_output(json_encode($this->o_put));

    }
    //----adminSave
    function adminSave(){

        $s = $this->Mdl_faq->adminSave();
        $this->o_put["faq_id"] = $s["faq_id"];
        $this->o_put["msg"] = $s["msg"];
        $this->output->set_output(json_encode($this->o_put));
        
    }

    //------------------
    //
    //---   adminDel
    function adminDel($id){
        $g = $this->Mdl_faq->adminDel($id);
        $this->o_put["msg"] = $g["msg"];
        $this->output->set_output(json_encode($this->o_put));
    }


    //------------

    /*
    //End of admin section

    */
    

}//end of file
