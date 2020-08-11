<?php 
class Mdl_faq extends MY_Model{

    protected $_tb_faq = "tbl_faq";
    protected $_tb_ans = "tbl_faq_answer";
    protected $_tb_user = "users";

    public $ip;
    public $browser;
    public $os;


    public $is_login;
    public $is_admin;
    public $moderate;
    
    public function __construct(){
        parent:: __construct();

    }


    function all(){
        $get = $this->db
                    ->get($this->_tb_faq);
        return $get;
    }
    function find($where){

        $get = $this->db
                    ->order_by("faq_date_create","DESC")
                    ->where($where)
                    ->get($this->_tb_faq);
        return $get;
    }


    /*
     * for anonymous user
     *
     */

    //--- the visitor will see on page
    function faqGuestList($where=false,$limit=false,$offset=false){
        $get = "";
        if($where):
            $get = $this->db
                        ->order_by("faq_date_create","DESC")
                        ->where($where)
                        ->get($this->_tb_faq,$limit,$offset);
        else:
            $get = $this->db
                        ->order_by("faq_date_create","DESC")
                        ->get($this->_tb_faq,$limit,$offset);

        endif;
        return $get;
    }

    //-------- the visitor has sent request
    function faqGuestRequest(){
        $request_id = $this->getEl("request_id");
        $faq_name = $this->getEl("faq_user_name",true);
        $faq_email = $this->getEl("faq_user_email",true);
        
        $my_time = strtotime($this->today_andTime)+(60*60)/4;
        $this->timeisup($my_time);
        $time_show = date("Y-m-d H:i:s",$my_time);
        $msg = "<p>dear {$faq_name} please check your email {$faq_email} and click the confirmation link </p><p>NOTE : Your link will be expire on {$time_show} from now.</p>";


       $faq_id = $this->faqGuestConfirmLink($request_id); 


        $r_data = array(
            "msg" => $msg,
            "faq_id" => $faq_id
        );
        return $r_data;
    }


    function faqGuestConfirmLink($request_id){
        $faq_name = $this->getEl("faq_user_name",true);
        $faq_email = $this->getEl("faq_user_email",true);
        
        $faq_data = array(
            "faq_name" => $faq_name,
            "faq_email" => $faq_email,
            "faq_uniq_id" => $request_id
        );
        $faq_id = $this->SAVE($faq_data,$this->_tb_faq);

        $my_time = strtotime($this->today_andTime)+(60*60)/4;
        $this->timeisup($my_time);
        $time_show = date("Y-m-d H:i:s",$my_time);

        $our_web = site_url();
        $ln_confirm = site_url("faq/faqGuestConfirm/{$request_id}/{$my_time}");

        $mail_title = "{$faq_name} Please confirm if this is you!";
        $mail_body = "<div style='padding:20px;'> <div style='padding:5px'>
  <h2>Dear {$faq_name} you just make a request at {$our_web}</h2>           
    <p>someone (maybe you) just make a request at {$our_web} on FAQ but we need you to confirm if you are the one who make a request please click on the link below to confirm that it's you. 
    </p>
    <p>
       <a href='{$ln_confirm}' target='_blank'>
        $ln_confirm
        </a>
    </p>
    <p>
your link will be expire at {$time_show} today.
    </p>
    <p>
PS : if this operation wasn't you please ignore this message.
    </p>
 </div>           
</div>";

        
        $this->sendMailTo($this->admin_email,$faq_email,$mail_title,$mail_body);

        return $faq_id;
    }

    function faqGuestHasConfirm($code){

        $s_name = "";
        $s_email = "";
        $faq_id = "";

        $get = $this->find(array("faq_uniq_id" => $code))->result();
        foreach($get as $row):
        
            $s_name = $row->faq_name;
            $s_email = $row->faq_email;
            $faq_id = $row->faq_id; 
        endforeach;
        
            $u_data = array(
                "faq_user_name" => $s_name,
                "faq_user_email" => $s_email,
                "faq_user_confirm" => 1,
                "faq_id" => $faq_id
            );
        $this->session->set_userdata($u_data);
        $msg = "";

        $faq_data = array(
            "faq_date_update" => $this->today_andTime,
        );
        $this->SAVE($faq_data,$this->_tb_faq,array("faq_id" => $faq_id)); 
        
        $msg = "<div class='alert alert-success'><p>Thank you for your confirm {$s_name}</p></div>";
        $r_data = array(
            "msg" => $msg,
            "faq_id" => $faq_id
        );
        return $r_data;
    }

    function faqGuestSave(){
        $faq_id = $this->session->userdata("faq_id");
        $faq_name = $this->getEl("faq_name",true);
        $faq_email = $this->getEl("faq_email",true);
        $faq_title = $this->getEl("faq_title",true);
        $faq_body = $this->getEl("faq_body",true);

        $faq_data = array(
            "faq_title" => $faq_title,
            "faq_body" => $faq_body,
            "faq_ip" => $this->ip,
            "faq_date_update" => $this->today_andTime,

        );


        $msg = "Success | we will get back to you soon, Thank you.";
        $this->SAVE($faq_data,$this->_tb_faq,array("faq_id" => $faq_id));

        //-- sent admin notice
        $mail_title = "New FAQ from {$faq_name}";
        $mail_body = "<div style='padding:15px;background-color:#e7e7e7'>
<div style='padding:3px;background-color:white;'>
    <h1 style='text-align:center'>New FAQ from {$faq_email}</h1>
    <p>on {$this->today_andTime} IP {$this->ip} </p>
    <div style='padding:5px;background-color:black;color:white;'>
    <h2 style='text-align:center;color:blue;'>{$faq_title}</h2>
    <p>
       {$faq_body} 
    </p>
    </div>
    <p>Go ahead check โลด</p>
</div></div>";

    $this->sendMailTo($faq_email,$this->admin_email,$mail_title,$mail_body);


        $u_data = array("faq_user_name","faq_user_email","faq_uniq_id","faq_user_confirm");
        
        $this->session->unset_userdata($u_data);
        $this->session->sess_destroy();


        $r_data = array("msg" => $msg);
        return $r_data;

    }

    /*
     * END FAQ Guest 22-Mar-2020 
     *
     */

    /*
     *  user Section START 17-Mar-2020
     *
     */
    function faqUserGetList($where=false,$limit=false,$offset=false){

        $j1 = "{$this->_tb_user}.id={$this->_tb_faq}.faq_user_id";
        $get = "";
        if($where):
            $get = $this->db
                        ->join($this->_tb_user,$j1)
                        ->where($where)
                        ->order_by("faq_date_create","DESC")
                        ->get($this->_tb_faq);
        else:
            $get = $this->db
                        
                        ->join($this->_tb_user,$j1)
                        ->order_by("faq_date_create","DESC")
                        ->get($this->_tb_faq);

        endif;
        return $get;
    }


    function faqUserSave(){

        $faq_title = $this->getEl("faq_title",true);
        $faq_body = $this->getEl("faq_body",true);
        $faq_id = $this->getEl("faq_id");
        $faq_uniq_id = $this->getEl("faq_uniq_id");

        $faq_user_email = $this->getEl("faq_user_email");
        $faq_user_id = $this->getEl("faq_user_id");
        $faq_user_name = $this->getEl("faq_user_name");

        $faq_data = array(
            "faq_user_id" => $faq_user_id,
            "faq_title" => $faq_title,
            "faq_body" => $faq_body,
            "faq_name" => $faq_user_name,
            "faq_email" => $faq_user_email,
            "faq_ip" => $this->ip,
            "faq_date_create" => $this->today_andTime,
            "faq_date_update" => $this->today_andTime
            
        );//--- data prepare

        
        if(!$faq_id):
            //-- create
            $faq_uniq_id = $this->randomChar(75);
            $faq_data["faq_uniq_id"] = $faq_uniq_id;
            $s = $this->SAVE($faq_data,$this->_tb_faq);
            $msg = "success : data has been created @{$s}";
            $faq_id = $s;    
            //-- sent user confirm email 
           $this->faqSentUserConfirmLink($faq_uniq_id); 
        else:
            //--- update
            unset($faq_data["faq_date_create"]);
            $this->SAVE($faq_data,$this->_tb_faq,array("faq_id" => $faq_id));
            $msg = "Success : data @{$faq_id} has been updated!";
        endif;

        //----- return data
        $r_data = array(
            "msg" => $msg,
            "faq_id" => $faq_id
        );
        return $r_data;
    }



    function faqSentUserConfirmLink($faq_uniq_id){
        $u_email = $this->getEl("faq_user_email");
        $u_name = $this->getEl("faq_user_name");
        

        $time_now = strtotime($this->today_andTime);
        $time_left = $time_now+(60*60)/2;
        $conf_url = site_url("faq/faqUserHasConfirm/{$faq_uniq_id}/{$time_left}");

        $u_mail_title = "Please confirm it's you {$u_name}";
        $u_mail_body = "<div style='padding:10px;'>
    <h1 style='color:blue;'>Please confirm it you</h1>
    <p>Dear {$u_name}
        &nbsp; please click on the link below
    </p>
    <p>
        <a href='{$conf_url}' target='_blank'>
            {$conf_url}
        </a>
    </p>

</div>";   

        $this->sendMailTo($this->admin_email,$u_email,$u_mail_title,$u_mail_body);
    }

    function faqUserHasConfirm($where){

        $faq_data = array(
            "faq_is_show" => 2,
            "faq_date_update" => $this->today_andTime
        );
        $this->SAVE($faq_data,$this->_tb_faq,$where);
        $msg = "<p>Thank you for your confirmation!</p><p>
you can close this window.
</p>";
        $this->faqSendAdminNotice($where);

        $r_data = array(
            "msg" => $msg
        );
        return $r_data;
    } 

    function faqUserViewFaq($where){
        $get = $this->find($where);        
        return $get;
    }


    function faqSendAdminNotice($c){

        
        $get = $this->find($c)->result();
        $email = "";
        $user_name = "";
        $code = "";
        $u_ip = "";
        $faq_body = "";

        foreach($get as $row):
            $email = $row->faq_email;
            $user_name = $row->faq_name;
            $code = $row->faq_uniq_id;
            $u_ip = $row->faq_ip;
            $faq_body = $row->faq_body;
        endforeach;

            $m_title = "User {$user_name} just confirm his FAQ";
            $m_body = "<div style='padding:10px;'>
 <div style='background-color:#e7e7e7;'>
   <h1 style='text-align:center;color:blue'>New FAQ from {$user_name}</h1>  
<p>The user name {$user_name} has sent FAQ on {$this->today_andTime} using IP {$u_ip}.</p>
<p>FAQ :<br />
{$faq_body}
</p>
<p>using code : {$code}</p>
 </div>               
</div>";
        $this->sendMailTo($email,"info@farookphuket.com",$m_title,$m_body);
    }

    /*
     *
     *  END USER SECTION
     *
     */




    /*
     *
     *  ADMIN SECTION START 13-Feb-2020
     *
     */
    
    function faqAdminGet($where=false,$limit=false,$offset=false){

        $get = "";
        if($where):
            $get = $this->db
                        ->order_by("faq_date_create","DESC")
                        ->where($where)
                        ->get($this->_tb_faq,$limit,$offset);
                        
        else:
            $get = $this->db
                        ->order_by("{$this->_tb_faq}.faq_date_create","DESC")
                        ->get($this->_tb_faq,$limit,$offset);

        endif;
            return $get;
    }

    function faqAdminSave(){
        $faq_id = $this->getEl("faq_id");
        //$faq_uniq_id = $this->getEl("faq_uniq_id");
        $faq_title = $this->getEl("faq_title");
        $faq_body = $this->getEl("faq_body");
        //$faq_show = $this->getEl("is_show");
        $faq_show = ($faq_show = $this->getEl("is_show"))?$faq_show=2:$faq_show=0;
       
        $faq_data = array(
            "faq_title" => $faq_title,
            "faq_body" => $faq_body,
            "faq_is_show" => $faq_show,
            "faq_date_update" => $this->today_andTime,
            "faq_answer_by" => $this->user_name
        );


        $this->SAVE($faq_data,$this->_tb_faq,array("faq_id" => $faq_id));
        $msg = "Success : data has been save";


        $r_data = array(
            "msg" => $msg,
            "faq_id" => $faq_id
        );
        return $r_data;
    }
    //----------------
    //--- faqAdminDel
    function faqAdminDel($where){
        $this->DEL($where,$this->_tb_faq);
        
    }
    



/*
 *  End of ADMIN 19-Mar-2020
 *
 */



    //-------
    function getFaq($where=false,$limit=false,$offset=false){

        $faq_id = 0;
        
        if($where):
            $get = $this->db
                        ->where($where)
                        ->order_by("faq_date_create","DESC")
                        ->get($this->_tb_faq,$limit,$offset);
            
            
        else:
            //$get = $this->getTB($this->_tb_faq,null,$limit,$offset);
            $get = $this->db
                        ->order_by("faq_date_create","DESC")
                        ->get($this->_tb_faq,$limit,$offset);
                        
        endif;

        return $get;

    }


    function adminDel($id){

        $where = array("faq_id" => $id);
        $del = $this->DEL($where,$this->_tb_faq);
        $msg = "Success : data has been deleted";
        $r_data = array(
            "msg" => $msg
        );
        return $r_data;
    }



    //---
    // function numFaqAns($faq_id){
    //     
    //     $where_ans = array("faq_id" => $faq_id);
    //     $get_ans = $this->getTB($this->_tb_ans,$where_ans)->result();
    //     $num_ans = count($get_ans);
    //     
    //     //set faq_data to update
    //     $faq_data = array("faq_has_ans" => $num_ans);
    //     $this->saveTB($this->_tb_faq,$faq_data,array("faq_id" => $faq_id));
    // }

    //---getAns
    // function getAns($where){
    //     $get = $this->db
    //                 ->order_by("ans_date","ANS")
    //                 ->where($where)
    //                 ->get($this->_tb_ans);
    //     return $get;
    // }
    //---------saveAns
    // function saveAns($data,$where=false){
    //     $save = "";
    //     $ans_id = "";
    //     
    //     if($where):
    //         $save = $this->saveTB($this->_tb_ans,$data,$where);
    //         $ans_id = $where["ans_id"];
    //     else:
    //         $save = $this->saveTB($this->_tb_ans,$data);
    //         $ans_id = $save;
    //     endif;
    //     return $ans_id;
    // }

    //--------save data to faq
    // function saveFaq(){
    //     //--- last update 16-Dec-2019
    //     $faq_id = $this->getEl("faq_id");
    //     $faq_name = $this->getEl("faq_name");
    //     $faq_email = $this->getEl("faq_email");
    //     $faq_title = $this->getEl("faq_title");
    //     $faq_body = $this->getEl("faq_body");
    //
    //
    //     $faq_data = array(
    //         "faq_title" => $faq_title,
    //         "faq_ip" => $this->ip,
    //         "faq_name" => $faq_name,
    //         "faq_email" => $faq_email,
    //         "faq_body" => $faq_body,
    //         "faq_date" => $this->today,
    //         "faq_time" => date("H:i:s",time()),
    //         "date_create" => $this->today_andTime,
    //         "date_update" => $this->today_andTime
    //         
    //     );
    //     $msg = "";
    //     
    //     if(!$faq_id):
    //         //--create 
    //        $s = $this->faqSentMailNotice(); 
    //         $save = $this->SAVE($faq_data,$this->_tb_faq);
    //         $faq_id = $save;
    //         $msg = "your message has been save! ,please check your email @".$s["u_email"]." and click the link to confirm that you are a real person.";
    //         
    //     else:
    //         //--- update
    //         unset($faq_data["date_create"]);
    //         $save = $this->SAVE($faq_data,$this->_tb_faq,array("faq_id" => $faq_id));
    //         $msg = "Success : message @{$faq_id} has been updated";
    //     endif;
    //     $r_data = array(
    //         "msg" => $msg,
    //         "faq_id" => $faq_id
    //     );
    //
    //     return $r_data;
    // }



    /*  NO LONGER USE
    function faqSentMailNotice(){
    
        $uEmail = $this->getEl("faq_email");
        $uName = $this->getEl("faq_name");

        $time_create = date("Y-m-d H:i:s",time());
        $time_expire = (strtotime($time_create)+900);

        $expire_show = date("Y-m-d H:i:s",$time_expire);
        //$expire = date("Y-m-d H:i",strtotime('+15 minutes'));

        $ulink = site_url("faq/userHasConfirm/{$this->ip}");

        $conf_link = "<a href='{$ulink}' target='_blank'>Yes, I am a real person</a>";
        /*
         * sent mail to user
         */
        /*
        $u_title = "Dear ${uName} please confirm it was you!";
        $u_body = "<div style='border:2px solid #ff0000;background-color:#e7e7e7;'>
            <h1 style='text-align:center;color:blue;'>dear <u>${uName}</u> please confirm if this was you!</h1>
            <div style='background-color:white;'>
                <h2 style='color:green;text-algin:center'>
                    Dear ${uName} please response this message.
                </h2>
                <p>
                    This message has send from 'https://www.farookphuket.com' as you have requested and enter your email({$uEmail}) into our F.A.Q section on {$this->today_andTime} <br />this is the reason why you have receive this message.

                </p>
                <p>
                    However ! your message will not be appear on the website unless we have prove that you are the real person and your message is not a spam.<br />
to confirm you are a real person please click on the link below within 15 minute (until {$expire_show} ). 
                </p>
                <p>
                    {$conf_link}
                </p>
                <p>&nbsp;</p>
                <p style='text-align:center;color:red'>
                PS : <br />
                Please ignore this email if you never do anything on 'www.farookphuket.com'
                </p>
            </div>
            </div>";
        $this->sendMailTo("info@farookphuket.com",$uEmail,$u_title,$u_body);
        
/*
 * * End user mail
*/

        /*
        $a_title = "new F.A.Q. from farookphuket.com";
        $a_body = "<div style='padding:10px;border:2px solid #ff0000;'>
       <h1>New F.A.Q from ip {$this->ip}</h1>
        <p>The new faq on the website farookphuket.com from the name : {$uName} the email : {$uEmail} on {$this->today_andTime}.      
            
            </div>";
$this->sendMailTo("info@farookphuket.com",null,$a_title,$a_body);
        /*
         *Send mail to admin
         */

        /*
        $r_data = array(
            "u_email" => $uEmail
            
        );
        return $r_data;
    }
    //------------------
    */




    //--    userHasConfirm
//     function userHasConfirm($where){
//         $get = $this->getFaq($where)->result();
//         $start = 0;
//         $expire = 0;
//         $now_time = date("Y-m-d H:i:s",time());
//
//         $uName = "";
//         $uEmail = ""; 
//         $faqTitle = "";
//         $faqBody = "";
//
//         $t_msg = "";
//         foreach($get as $row):
//             $start = strtotime($row->date_create);
//             $uName = $row->faq_name;
//             $uEmail = $row->faq_email;
//             $faqTitle = $row->faq_title;
//             $faqBody = $row->faq_body;
//             $t_msg = $row->date_create; 
//         endforeach;
//
//         $t_create = $start;
//         $t_expire = (60*60)/4+($t_create);
//         $t_show = date("Y-m-d H:i:s",$t_expire);
//
//             $t1 = strtotime($now_time);
//             $t2 = $start;
//             $expire = round(abs($t1-$t2)/60,2);
//
//             $notice_admin = 0;
//             if($expire > 15):
//                 $msg = "<div class='alert alert-danger'>
//                 <h1 class='text-center'>Error : your link has expired</h1>
//                 <p>
//                     <span class='badge badge-danger'>
//                         Sorry :
//                     </span> &nbsp;
//
//                     your link has created on {$t_msg} and will expire on {$t_show}.
//                 </p>
//                 </div>";
//             else:
// $msg = "<div class='alert alert-success'>
//     <h1 class='text-center'>Thank you</h1>
//     <p>thank you for your confirmed,we will post your message on our F.A.Q section soon.</p><p> link created on {$t_msg} will expire on {$t_show}</p></div>";
//                 $notice_admin = 1;
//             endif;
//             //$msg = "<br /><br />your link is create on {$t_msg} but now is {$now_time} it is {$expire} different!";
//
// /*
//  * sent the email notice to admin
//  */
//     $m_title = "The ip {$this->ip} has been proved!";
//     $m_body = "<div style='border:2px solid #ff0000;padding:10px;background-color:#e7e7e7;'>
//   <div style='background-color:white;'>
//     <h1>The user email {$uEmail} has confirm on page</h1>
//     <p>F.A.Q title : <br />
//     {$faqTitle}
//     </p>
//     <p>F.A.Q Body 
//     <br />
//     {$faqBody}
//     </p>
//     <p>at {$this->today_andTime} let go to check!</p>
//     </div>      
//         </div>";
//         if($notice_admin != 0):
//             //-- only notice if the link has not expire
//             $this->sendMailTo(null,'admin@farookphuket.com',$m_title,$m_body);
//         endif;
//             $r_data = array(
//                 "msg" => $msg
//             );
//             return $r_data;
//     }
    //------------delFaq will also delete the answer 
    //--that related to the faq_id 
    // function delFaq($id){
    //     $where = array("faq_id" => $id);
    //     $this->delTB($this->_tb_ans,$where);
    //     $this->delTB($this->_tb_faq,$where);
    //     return true;
    // }

}//-------end of file
