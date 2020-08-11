<?php

class Tour extends MY_Controller{

    protected $_tb_tour = "tbl_tour";
    protected $_tb_cat = "tbl_cat";


    public $ip;
    public $browser;
    public $os;
    public $user_id;
    public $user_name;

    protected $moderate;

    
    function __construct(){
        parent::__construct();

        //--library
        $this->load->library("pagination");

        //--model
        $this->load->model("Mdl_tour");

        //--basic info
        $this->ip = $this->Mdl_tour->getIP();
        $this->browser = $this->Mdl_tour->getBrowser();
        $this->os = $this->Mdl_tour->getOS();
        $this->user_name = $this->Mdl_tour->getUserName();
        $this->ip = $this->Mdl_tour->getUserId();

        $this->moderate = $this->session->userdata("moderate");
    }

    //--List all the tour program
    function index(){

        if($this->is_login):
            $url = site_url("tour/own");
            if($this->is_admin):
                $url = site_url("tour/admin");
            endif;
            if($this->moderate):
                $url = site_url("tour/moderate");
            endif;
            redirect($url);
        endif;
        $this->data["subview"] = "tour/index";
        $this->data["meta_title"] = "our tour program on the web you can booking online";

        $get = $this->Mdl_tour->getTour()->result();
        $num = count($get);
        //$page = $this->input->get("page");
        $per_page = 10;
        $page = (!$page = $this->input->get("page"))?$page=$per_page:$page=$page;
        $this->data["get_tour"] = $get;
        $this->data["num_tour"] = $num;
        $this->data["page"] = $page;

        $this->load->view("_layout_main",$this->data);
    }
    
    //---show detail of the tour program
    function detail($id){

        $get = $this->Mdl_tour->getTour(array("t_id" => $id))->result();

        $this->data["get"] = $get;
        $this->data["subview"] = "tour/tour_detail";
        $this->load->view("_layout_main",$this->data);
    }

    //--
    function summary(){
        //--this method will return the summary
        //--both ajax or method
        $data = array();
        
        $all = $this->Mdl_tour->getTour()->result();
        $data["all_tour"] = count($all);

        

        $this->output->set_output(json_encode($data));
        return $data;
    }


    //---member section
    function own(){
        echo"you are {$this->user_name}";
    }


    //--END OF MEMBER AREA


    function moderate(){
        $cmd = $this->input->post("cmd");

        $t_id = $this->input->post("t_id");//--id of program
        $title = $this->input->post("t_title");
        $body = $this->input->post("t_body");
        $summary = $this->input->post("t_summary");
        $summary = nl2br($summary);
        $price_minimum = $this->input->post("price_minimum");
        $price_full = $this->input->post("price_full");

        $today = date("Y-m-d h:i:s",time());
        $tour_data = array(
           "t_name" => $title,
           "t_program" => $body,
           "t_summary" => $summary,
           "full_price" => $price_full,
           "min_price" => $price_minimum,
           "date_create" => $today,
           "date_update" => $today,
           "user_id" => $this->user_id
            
        );

        

        switch($cmd):
            case"edit":
                $where = array("t_id" => $t_id);
                $get = $this->Mdl_tour->getTour($where)->result();
                $this->o_put["get_tour"] = $get;
                $this->output->set_output(json_encode($this->o_put));
            break;
            case"saveTour":
                $label = "สับสนจัง";
                if(!$t_id):
                    $label = "Created";
                    unset($tour_data["date_update"]);
                    $this->Mdl_tour->saveTour($tour_data);
                else:
                    $label = "Updated";
                    unset($tour_data["date_create"]);
                    $this->Mdl_tour->saveTour($tour_data,array("t_id" => $t_id));
                endif;

                
                echo"Success : The program has been {$label}.";
            break;
            case"delete":
                $this->Mdl_tour->delTour(array("t_id" => $t_id));
                echo"The item has been deleted!";
            break;
            default:
                $this->data["subview"] = "tour/moderate";
                $this->data["meta_title"] = "Moderate page";

                $get = $this->Mdl_tour->getTour()->result();
                $num = count($get);

                $page = $this->input->get("page");
                if(!$page):
                    $page = 0;
                else:
                    $page = $page;
                endif;
                $per_page = 4;

                $conf = array();
                $conf["base_url"] = site_url("tour/moderate/");
                $conf["total_rows"] = $num;
                $conf["per_page"] = $per_page;
                $conf["full_tag_open"] = "<ul class='pagination'><li>";
                $conf["full_tag_close"] = "</li></ul>";

                $this->pagination->initialize($conf);

                $get_tour = $this->Mdl_tour->getTour("",$conf["per_page"],$this->uri->segment(3))->result();
                $this->data["get_tour"] = $get_tour;
                $this->data["num_tour"] = $num;
                $this->data["per_page"] = $per_page;

                // $show_page = $this->uri->segment(3);
                // $page_where = 0;

                // if($show_page == 0):
                //     $show = 1;
                // else:
                //     $page_where = $show_page/$per_page;
                //     $show = $page_where;
                // endif;
                // $this->data["page"] = $show;

                $this->load->view("_layout_moderate",$this->data);
            break;
        endswitch;
    }
    //---admin section
    //--create on Thu 3 May 2018

    
    function admin(){
        $cmd = $this->input->post("cmd");

        $t_id = $this->input->post("t_id");//--id of program
        $title = $this->input->post("t_title");
        $body = $this->input->post("t_body");
        $summary = $this->input->post("t_summary");
        $price_minimum = $this->input->post("price_minimum");
        $price_full = $this->input->post("price_full");

        $today = date("Y-m-d h:i:s",time());
        $tour_data = array(
           "t_name" => $title,
           "t_program" => $body,
           "t_summary" => $summary,
           "full_price" => $price_full,
           "minimum_price" => $price_minimum,
           "date_create" => $today,
           "date_update" => $today,
           "user_id" => $this->user_id
            
        );

        

        switch($cmd):
            case"edit":
                $where = array("t_id" => $t_id);
                $get = $this->Mdl_tour->getTour($where)->result();
                $this->o_put["get_tour"] = $get;
                $this->output->set_output(json_encode($this->o_put));
            break;
            case"saveTour":
                $label = "สับสนจัง";
                if(!$t_id):
                    $label = "Created";
                    unset($tour_data["date_update"]);
                    $this->Mdl_tour->saveTour($tour_data);
                else:
                    $label = "Updated";
                    unset($tour_data["date_create"]);
                    $this->Mdl_tour->saveTour($tour_data,array("t_id" => $t_id));
                endif;

                
                echo"Success : The program has been {$label}.";
            break;
            case"delete":
                $this->Mdl_tour->delTour(array("t_id" => $t_id));
                echo"The item has been deleted!";
            break;
            default:
                $this->data["subview"] = "tour/admin";
                $this->data["meta_title"] = "Admin page";

                $get = $this->Mdl_tour->getTour()->result();
                $num = count($get);

                $page = $this->input->get("page");
                if(!$page):
                    $page = 0;
                else:
                    $page = $page;
                endif;
                $per_page = 4;

                $conf = array();
                $conf["base_url"] = site_url("tour/admin/");
                $conf["total_rows"] = $num;
                $conf["per_page"] = $per_page;
                $conf["full_tag_open"] = "<ul class='pagination'><li>";
                $conf["full_tag_close"] = "</li></ul>";

                $this->pagination->initialize($conf);

                $get_tour = $this->Mdl_tour->getTour("",$conf["per_page"],$this->uri->segment(3))->result();
                $this->data["get_tour"] = $get_tour;
                $this->data["num_tour"] = $num;
                $this->data["per_page"] = $per_page;

                // $show_page = $this->uri->segment(3);
                // $page_where = 0;

                // if($show_page == 0):
                //     $show = 1;
                // else:
                //     $page_where = $show_page/$per_page;
                //     $show = $page_where;
                // endif;
                // $this->data["page"] = $show;

                $this->load->view("_layout_admin",$this->data);
            break;
        endswitch;
    }


    //---end of admin section


}//end of file