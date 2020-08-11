<?php


class Booking extends MY_Controller{


    protected $_tb_booking = "tbl_booking";
    protected $_tb_payment = "tbl_booking_payment_info";
    protected $_tb_book_info = "tbl_booking_user_info";

    protected $_tb_tour = "tbl_tour";

    protected $_tb_notice = "tbl_notification";

    public $ip;

    //--pic path
    public $img_path;
    public $thumb_path;

    function __construct(){
        parent::__construct();

        //---load model
        $this->load->model("Mdl_booking");

        //--load library
        $this->load->library("pagination");

        $this->ip = $this->Mdl_booking->ip;

        $this->img_path = realpath(APPPATH."../public/payment_confirm");
        $this->thumb_path = $this->img_path."/thumb/";
    }

    function index(){
        $rd_url = "";
        if($this->is_login):
            $rd_url = site_url("booking/u/{$this->user_id}");
            if($this->is_admin):
                $rd_url = site_url("booking/admin");
            endif;
        endif;

        redirect($rd_url);
        $this->data["meta_title"] = "Make your booking";
        $this->data["subview"] = "booking/book_index";
        $this->load->view("_layout_main",$this->data);
    }

    //---------
    //---------#checkMyBooking 1-1-19
    function checkMyBooking(){
        $email = $this->input->post("ch_email");
        $where = array("{$this->_tb_booking}.bk_email" => $email);
        $get = $this->Mdl_booking->modGetAllBooking($where)->result();
        $num = count($get);
        $msg = "";
        if($num == 0):
            $msg = "Sorry ,we don't find any booking of  {$email} ";
        endif;
        $this->o_put["msg"] = $msg;
        $this->o_put["get_booking"] = $get;
        $this->o_put["num_booking"] = $num;
        $this->output->set_output(json_encode($this->o_put));
    }

    //-------------------------------------
    //-------- #uGetPayTag
    function uGetPayTag($t_id){
        $bk_num = $this->input->post("bk_num");
        $unit_price = 0;
        $price_total = 0;
        $tour_name = "";

        if(!$bk_num):
            $bk_num = 2;
        endif;
        $where = array(
            "{$this->_tb_tour}.t_id" => $t_id
        );
        $get = $this->Mdl_booking->calTourPrice($where)->result();
        foreach($get as $row):
            $unit_price = $row->full_price;
            $tour_name = $row->t_name;
        endforeach;
        $total_price = $unit_price*$bk_num;

        $this->o_put["full_price"] = $total_price;
        $this->o_put["tour_name"] = $tour_name;
        $this->output->set_output(json_encode($this->o_put));

    }

    //--------------------------------------------
    //---------- uSetDateBooking
    function uSetDateBooking(){
        $today = date("Y-m-d",time());
        $date_dep = $this->input->post("bk_dep");
        $date_dep = date("Y-m-d",strtotime($date_dep));
        $valid_day = date("Y-m-d",time()+86400*2);
        $err = 0;
        $msg = "";
        if($date_dep <= $valid_day):
            $err = 1;
            $msg = "Error : you have to booking for later of {$valid_day} or 3 days in advance!";
        else:
            $msg = "your booking is for {$date_dep}";
        endif;
        $this->o_put["error"] = $err;
        $this->o_put["msg"] = $msg;
        $this->output->set_output(json_encode($this->o_put));
    }
    //-----------------
    //------uSaveBooking 16 jan 19
    function uSaveBooking(){
        //----get user data from the form submit by ajax
        $bk_id = 0;
        $go_day = $this->input->post("bk_dep");
        $bk_email = $this->input->post("bk_email");
        $go_day = date("Y-m-d",strtotime($go_day));
        $valid_day = date("Y-m-d",time()+86400*2);

        //---email info
        $s_url = site_url();
        $t_name = "";

        $err = 0;
        $msg = "";
        if($go_day <= $valid_day):
            $err = 1;
            $msg = "Error : your selected date is not valid!";
        else:

            $u_data = $this->uGetFormData();
            $u_data["bk_ip"] = $this->ip;
            $t_name = $u_data["tour_name"];
            $bk_email = $u_data["bk_email"];
            //---save booking to get the key id
            $bk_id = $this->Mdl_booking->save_booking($u_data);

            //---user pay data
            $u_pay = $this->uGetUserPayData();
            $u_pay["bk_id"] = $bk_id;
            $u_pay["user_payment_img"] = "NOT_PAY_YET_1.png";
            $this->Mdl_booking->savePaymentInfo($u_pay);
            //var_dump($u_pay);

            //---user booking detail
            $u_name = "";
            $u_info = $this->uGetBookingInfo();
            $u_info["bk_id"] = $bk_id;
            $u_name = $u_info["bk_user_name"];
            $this->Mdl_booking->saveUserInfo($u_info);


            //----sent admin notice
            $note_title = "The user ip {$this->ip} has do booking on {$this->today_andTime}";
            $note_body = "The user email {$bk_email} has booking on {$this->today_andTime}";

            $note_data = array(
                "notice_title" => $note_title,
                "notice_body" => $note_body,
                "notice_ip" => $this->ip,
                "by_user_name" => $bk_email
            );
            $this->Mdl_booking->saveNotice($note_data);

            //---send user email
            $u_emailTitle = "Thank you for booking with {$s_url}";
            $u_emailBody = "
            <h1>Dear {$u_name}</h1>
            <p>We want to inform you that you have made booking with {$s_url} for the tour name {$t_name} on {$this->today_andTime}</p>
            <p>Please make a payment to confirm your booking.</p>
            ";
            $this->sendMailTo(null,$bk_email,$u_emailTitle,$u_emailBody);

            //----end of send user email

            //---send admin email
            $a_emailTitle = "New booking from {$this->Mdl_booking->ip} on {$this->today_andTime}";
            $a_emailBody = "
            <h1>New booking on {$this->today_andTime}</h1>
            <p>User IP {$this->Mdl_booking->ip}</p>
            <p>User Email {$bk_email}</p>
            ";

            $this->sendMailTo(null,null,$a_emailTitle,$a_emailBody);


            $msg = "Success : your booking has send ";
        endif;


        //----
        $this->o_put["get_booking"] = $this->Mdl_booking->modGetAllBooking(array("{$this->_tb_booking}.bk_id" => $bk_id))->result();
        $this->o_put["msg"] = $msg;
        $this->o_put["error"] = $err;
        $this->o_put["bk_id"] = $bk_id;
        //$this->o_put["bk_email"] = $bk_email;
        $this->output->set_output(json_encode($this->o_put));
    }
    //------------------------------

    //------------------------------

    //---------uGetFormData 17 jan 19
    function uGetFormData(){

        $go_day = $this->input->post("bk_dep");
        $go_day = date("Y-m-d",strtotime($go_day));
        $u_data = array(
            "tour_id" => $this->input->post("tour_id"),
            "bk_email" => $this->input->post("bk_email"),

           "tour_name" => $this->input->post("meta_url"),

           "bk_date" => $this->today,
           "bk_pay_status" => 0,
           "bk_datetime" => $this->today_andTime,
           "going_date" => $go_day
        );

        return $u_data;
    }

    //----uGetUserPayData 17 jan 19
    function uGetUserPayData(){

        $full_price = $this->input->post("bk_price");
        $half_price = $full_price/2;
        $deposit = $half_price/2;

        $data = array(
            "pay_full_price" => $full_price,
            "must_pay_deposite" => $deposit,
            "user_has_pay" => 0,
            "user_pay_as" => "Never Pay"
        );
        return $data;
    }
    //----------------
    //----uGetBookingInfo 17 jan 19
    function uGetBookingInfo(){
        //---this method will return user data from booking form
        //--call by ajax when user has booking
        $go_day = $this->input->post("bk_dep");
        $go_day = date("Y-m-d",strtotime($go_day));
        $data = array(
            "bk_user_ip" => $this->ip,
            "bk_user_name" => $this->input->post("bk_name"),"bk_user_email" => $this->input->post("bk_email"),"bk_user_more" => $this->input->post("bk_pickup"),
            "bk_num_people" => $this->input->post("bk_num"),"bk_date_going" => $go_day,
            "bk_date_booking" => $this->today
        ) ;
        return $data;
    }
    //-----------------
    function u(){
        if(!$this->is_login):
          redirect(site_url("users/logout"));
          exit();
        endif;
        $this->data["subview"] = "booking/own_booking";
        $this->data["meta_title"] = "{$this->user_type}&nbsp;|&nbsp;welcome {$this->user_name}";
        $this->load->view("_MEMBER_TMP",$this->data);
    }
    //-------------
    //----uGetNumBooking
    function uGetNumBooking(){
        $where = array("bk_email" => $this->user_id);
    }

    //-------------------------------------------
    //---------getMyTicketList
    function getMyTicketList($seg=1){

        $u_email= $this->user_email;
        $where = array(
            "bk_email" => $u_email
        );
        $get = $this->Mdl_booking->getBooking($where)->result();
        $num = count($get);

        $this->o_put["get_ticket"] = $get;
        $this->o_put["num_ticket"] = $num;
        $this->output->set_output(json_encode($this->o_put));


    }

    //--------------------
    //--------viewMyTicket
    function viewMyTicket($t_id){

        $where = array("{$this->_tb_booking}.bk_id" => $t_id);
        $detail = $this->Mdl_booking->modGetAllBooking($where)->result();
        $this->o_put["detail"] = $detail;
        $this->output->set_output(json_encode($this->o_put));
    }
    //---------------------
    //-----userSentPayment
    function userSentPayment(){
        $bk_id = $this->input->post("bk_id");
        $email = $this->input->post("cf_email");
        //$u_file = $this->input->post("userfile");
        $where = array("bk_id" => $bk_id);
        //---upload pic
        $this->load->library("upload");
        $conf = array(
            "upload_path" => $this->img_path,
            "allowed_types" => "JPG|jpeg|jpg|gif|x-png|png"
            );
            $this->load->library("upload");
            $this->upload->initialize($conf);
            //    $this->upload->do_upload();
            if(!$this->upload->do_upload("userfile")):
                var_dump($this->upload->display_errors());
            endif;
            $img_data = $this->upload->data();
            //var_dump($img_data);

            $pic_name = $img_data["file_name"];
            $thumb_name = "_Thumb_".$img_data["file_name"];
            $pay_info = array(
                "user_payment_img" => $pic_name,
                "payment_img_thumb" => $thumb_name
            );
            $this->Mdl_booking->savePaymentInfo($pay_info,$where);

            //---get user info
            $u_info = $this->adminGetBookingInfo($bk_id);
            $u_name = $u_info["bk_name"];
            $u_email = $u_info["bk_email"];
            $go_day = $u_info["going_date"];
            $tour_name = $u_info["tour_name"];

            //---send email to admin
            $mail_title = "Payment on request by {$u_name}";
            $mail_body = "
            <h1>The payment request from {$u_name} on {$this->today_andTime}</h1>
            <p>The user email {$u_email} has send the payment picture for the tour {$tour_name} on departure date {$go_day}.</p>

            ";
            $this->sendMailTo(null,$this->admin_email,$mail_title,$mail_body);

            $this->o_put["msg"] = "<p>
            Success : Thank you! please wait for our approve we will get back to you as soon as possible.</p>
            <p>Dear <strong>{$u_name}</strong>
            you will recieve from {$this->admin_email} about your confirmation soon.
            </p>";
            $this->o_put["bk_id"] = $bk_id;
            $this->output->set_output(json_encode($this->o_put));


    }
    //------------------------------------
    //----userPrintTicket
    function userPrintTicket($id){
        $where = array("{$this->_tb_booking}.bk_id" => $id);
        $get = $this->Mdl_booking->modGetAllBooking($where)->result();

        $this->data["meta_title"] = "pritn this document or save this page as *.pdf file";
        $this->data["subview"] = "booking/_print_ticket";
        $this->data["get_booking"] = $get;

        $tmp = "booking/print_TMP";
        $this->load->view($tmp,$this->data);
    }




    //----------------------------------------------------
    //--------------Admin section-------------------
    //------------17-12-18----------------------------
    function admin(){
        //--last edit 8-4-19
        $this->data["meta_title"] = "welcome {$this->user_name}|Admin";
        $this->data["subview"] = "admin/booking/booking_list";
        $tmp = "_ADMIN_TMP";
        $this->load->view($tmp,$this->data);
    }

    //----
    //---adminEditBooking
    function adminEditBooking($id){

        $get = $this->Mdl_booking->modGetAllBooking(array("{$this->_tb_booking}.bk_id" => $id))->result();
        $bk_name = "";
        $bk_id = "";
        foreach($get as $row):
            $bk_id = $row->bk_id;
            $bk_name = $row->bk_user_name;
        endforeach;

        $this->data["meta_title"] = "Editing booking of {$bk_name}";
        $this->data["subview"] = "admin/booking/_frm_booking";
        $tmp = "_ADMIN_TMP";
        $this->data["get"] = $get;

        $this->load->view($tmp,$this->data);



    }

    function adminSaveBooking(){
        $ad_id = $this->user_id;
        $ad_name = $this->user_name;

        $booking_id = $this->input->post("bk_id");



        $full_price = $this->input->post("full_price");
        $depo = $this->input->post("user_pay");

        $collect_more = $full_price-$depo;

        //---pay as deposite or paid
        $pay_as = $this->input->post("pay_option");
        $has_pay = 0;

        $conf = $this->input->post("set_conf");
        if($conf):
            $conf = 1;
            $has_pay = 1;
        else:
            $conf = 0;
        endif;

        //---update user booking data
        $booking_data = array(
            "bk_confirm" => $conf,
            "conf_ip" => $this->Mdl_booking->ip,
            "conf_id" => $ad_id,
            "conf_name" => $ad_name,
            "bk_date_conf" => $this->today_andTime
        );
        $this->Mdl_booking->save_booking($booking_data,array("bk_id" => $booking_id));
        //----update user payment info data
        $payment_data = array(
            "pay_deposite" => $depo,
            "must_collect_more" => $collect_more,
            "day_pay_record" => $this->today_andTime,
            "user_pay_as" => $pay_as,
            "user_has_pay" => $has_pay
        );
        $this->Mdl_booking->savePaymentInfo($payment_data,array("bk_id" => $booking_id));

        //---send email to user if check that they has pay
        //---get the user info to send email

        if($conf == 1):
            $this->adminGetBookingInfo($booking_id);
            $this->sendUserEmail($booking_id);

        endif;


        //---message to screen
        $msg = "Success : booking has been update";
        $this->o_put["msg"] = $msg;
        $this->output->set_output(json_encode($this->o_put));


    }

    //---for the sent email purpose
    function adminGetBookingInfo($bk_id){
        $data = array();
        $where = array("{$this->_tb_booking}.bk_id" => $bk_id);
        $get_u = $this->Mdl_booking->modGetAllBooking($where)->result();
        foreach($get_u as $row):
            $data["bk_name"] = $row->bk_user_name;
            $data["bk_email"] = $row->bk_user_email;
            $data["tour_name"] = $row->tour_name;
            $data["going_date"] = $row->going_date;
        endforeach;

        return $data;
    }

    //----send email to user
    function sendUserEmail($bk_id){
        $u_info = $this->adminGetBookingInfo($bk_id);
        $name = $u_info["bk_name"];
        $email = $u_info["bk_email"];
        $tour_name = $u_info["tour_name"];
        $go_day = $u_info["going_date"];
        $web = site_url();

        $mail_title = "Thank you for your payment  {$name}.";
        $mail_body = "
        <h1>your booking is confirmed</h1>
        <p>
        Dear <strong>{$name}</strong>
        </p>
        <p>your booking with {$web} for {$tour_name} departure date on {$go_day} has been confirmed</p>
        <p>if you want to change the departure day or cancle please do it 2 days before your departure date to get your refound.</p>
        <p>
        <strong>Please Note</strong><br />
        there will be no refound on the departure day at all.
        </p>
        <p>Thank you</p>
        ";
        $this->sendMailTo(null,$email,$mail_title,$mail_body);
    }

    function adminGetBookingList($seg=1){
        $get = $this->Mdl_booking->modGetAllBooking()->result();
        $num_bk = count($get);

        ///----call for paginatoion
        $url = "adminGetBookingList";
        $per_page = 4;

        $conf = $this->getConfPagin($per_page,$num_bk,$url);
        $this->pagination->initialize($conf);
        $page = $seg;
        $start = ($page-1)*$per_page;
        $get_bk = $this->Mdl_booking->modGetAllBooking(null,$per_page,$start)->result();

        if($num_bk >= $per_page):
            $this->o_put["pagination"] = $this->pagination->create_links();
        endif;



        $this->o_put["num_bk"] = $num_bk;
        $this->o_put["get_bk"] = $get_bk;
        $this->o_put["get_all"] = $get;
        $this->output->set_output(json_encode($this->o_put));

    }

    //----------------
    //--------modViewBooking
    function modViewBooking($id){
        $where = array("{$this->_tb_booking}.bk_id" => $id);
        $get = $this->Mdl_booking->modGetAllBooking($where)->result();
        $this->o_put["get_booking"] = $get;
        $this->output->set_output(json_encode($this->o_put));
    }
    //--------modSaveBooking
    function modSaveBooking(){
        $conf_name = $this->user_name;
        $conf_id = $this->user_id;

        $bk_id = $this->input->post("bk_id");
        $num_people = $this->input->post("num_people");
        $full_price = $this->input->post("full_price");
        $cus_depo = $this->input->post("user_pay");

        //---checkbox
        $is_confirm = $this->input->post("set_conf");
        $pay_status = $this->input->post("pay_option");

        $must_collect = ($full_price-$cus_depo);

        $err = 0;
        $msg = "";

        $where_booking = array(
            "bk_id" => $bk_id
        );
        $book_data1 = array(
            "bk_pay_status" => $pay_status,
            "bk_confirm" => $is_confirm,
            "conf_ip" => $this->ip,
            "conf_id" => $this->user_id,
            "conf_name" => $this->user_name,
            "bk_date_conf" => $this->today_andTime
        );
        //--update the table tbl_booking
        $update_1 = $this->Mdl_booking->save_booking($book_data1,$where_booking);

        $book_data2 = array(
            "pay_deposite" => $cus_depo,
            "must_collect_more" => $must_collect,
            "day_pay_record" => $this->today_andTime,
            "user_has_pay" => $is_confirm,
            "user_pay_as" => $pay_status
        );
        //--update table tbl_booking_payment_info
        $update_2 = $this->Mdl_booking->savePaymentInfo($book_data2,$where_booking);

        $msg = "the booking id {$bk_id} has been updated!";

        $this->o_put["msg"] = $msg;
        $this->o_put["bk_id"] = $bk_id;
        $this->output->set_output(json_encode($this->o_put));
    }


}
