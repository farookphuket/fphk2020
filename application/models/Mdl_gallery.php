<?php

class Mdl_gallery extends MY_Model{
    protected $_tb_gall = "gallery_1";
    protected $_order_by;


    public $ip;
    public $browser;
    public $os;

    public $user_name;
    public $user_id;

    protected $is_admin;

    function __construct(){
        parent::__construct();

        $this->ip = $this->getIP();
        $this->os = $this->getOS();
        $this->browser = $this->getBrowser();
        $this->user_name = $this->getUserName();
        $this->user_id = $this->getUserId();

        $this->is_admin = $this->session->userdata("is_admin");
        
    }

    //---get 
    function get($where=false,$limit=false,$offset=false){
        $get = 0;
        if($where):
            $get = $this->db
                        ->where($where)
                        ->order_by("date_add","DESC")
                        ->get($this->_tb_gall,$limit,$offset);
        else:
            $get = $this->db
                        ->order_by("date_add","DESC")
                        ->get($this->_tb_gall,$limit,$offset);
        endif;

        return $get;
    }

    //--save function 
    function save($data,$where=false){
        $save = 0;
        $g_id = 0;
        if($where):
            $save = $this->saveTB($this->_tb_gall,$data,$where);
            $g_id = $where["pic_id"];
        else:
            $save = $this->saveTB($this->_tb_gall,$data);
            $g_id = $save; 
        endif;
        return $g_id;
    }

    function del($where){
        $this->delTB($this->_tb_gall,$where);
        return true;
    }


    function userGetPic($where){
        //--use this method as ajax call
        
        $get = $this->db
                    ->select("*")
                    ->from($this->_tb_gall) 
                    ->where($where)
                    ->get();
        $out = '';

        foreach($get->result() as $row):
            $thumb = site_url("public/image/thumb/{$row->thumb_name}");
            $full_pic = site_url("public/image/{$row->pic_name}");

            $pic_bb_code = "&lt;img src='{$full_pic}' class='responsive' &gt;";
            $thumb_bb_code = "&lt;img src='{$thumb}' class='responsive' &gt;";
            
            $opt = "<option value='0'>No</option>";
            if($row->allow_public != 0):
                $opt = "<option value='1'>Yes</option>";  
            endif;

            $admin_per = "<span class='label label-danger'>Not Allow</span>";
            if($row->admin_allow != 0):
                $admin_per = "<span class='label label-success'> Allow</span>";
            endif;

            $out .= "<p class='cf'>&nbsp;</p>";
            $out .= "<div class='page-header'>
                <h2>
                    Photo Gallery 1.02
                </h2>
            </div>";
            $out .= '<div class="col-md-12">';

            //--image full pic
            $out .= "<p class='text-center'><img src='{$full_pic}' class='responsive'></p>";
            $out .= "<p class='text-center'><img src='{$thumb}' class='responsive'></p>";
            $out .= "<form class='form-horizontal'>";
            
            //--copy code for tumbnail
            $out .= "<div class='form-group'>
            <label class='label-control col-sm-4'>BB CODE Thumbnail</label>
            <div class='col-sm-6'>
            <textarea class='form-control pic_code' readonly='readonly'>{$thumb_bb_code}</textarea>
            </div>
            </div>";

            //--copy bb code for the full pic 
            $out .= "<div class='form-group'>
            <label class='label-control col-sm-4'>BB CODE FULL PIC</label>
            <div class='col-sm-6'>
            <textarea class='form-control pic_code' readonly='readonly'>{$pic_bb_code}</textarea>
            </div>
            </div>";


            //--change the title of this image
            $out .= "<div class='form-group'>
            <label class='label-control col-sm-4'>BB CODE Thumbnail</label>
            <div class='col-sm-6'>
                <input type='text' value='{$row->pic_title}' class='form-control pic_title' data-pic_id='{$row->pic_id}'>
            </div>
            </div>";

            $out .= "<div class='form-group'>
            <label class='label-control col-sm-4'>Show Image to Public</label>
            <div class='col-sm-6'>
                <select class='form-control pic_pub' data-pic_id='{$row->pic_id}'>
                    {$opt}
                    <option value='0'>NO</option>
                    <option value='1'>Yes</option>
                </select>
            </div>
            </div>";

            $out .= "<div class='form-group'>
            <label class='label-control col-sm-4'>Admin Permission</label>
            <div class='col-sm-6'>
                <h4>{$admin_per}</h4>
            </div>
            </div>";
            
            
            $out .= "</form>";


            $out .= "</div>";
            $out .= "<p class='cf'>&nbsp;</p>";
        endforeach;

        return $out;

    }

    function getPic($where=false,$limit=false,$offset=false){
        $out = "";

        if($where != null):
            $get = $this->db
                    ->order_by("date_add","DESC")
                    ->where($where)
                    ->get($this->_tb_gall,$limit,$offset);
        else:
            $get = $this->db
                    ->select("*")
                    ->from($this->_tb_gall)
                    ->order_by("date_add","DESC")
                    ->limit($limit,$offset)
                    ->get();
        endif;
        
        foreach($get->result() as $row):
            $full_pic = site_url("public/image/{$row->pic_name}");
            $thumb_pic = site_url("public/image/thumb/{$row->thumb_name}");

            $msg_head = "<p>to edit this image title,allow,set public you can do it by below form</p>";
            if($this->is_admin):
                $msg_head = "<p>to edit this image title,allow,set public or delete you can do it by below form</p>";
            endif;

            $full_bb_code = "&lt;img class='responsive' src='$full_pic'&gt;";
            $thumb_bb_code = "&lt;img class='responsive' src='$thumb_pic'&gt;";
            $out .= "<div class='col-md-10'>";
            $out .="<div class='page-header'>
                <h2>file name {$row->pic_name} owner id {$row->user_id}</h2>
            </div>";
            
            $out .= $msg_head;

            $out .= "<p>
            <a href='{$full_pic}' title='show full pic' target='_blank'>
                <img class='responsive' src='{$full_pic}'>
            </a>
            </p>";

            //--option for public or private image
            $opt_label = "<option value=0>Set Public</option>";
            if($row->allow_public != 0):
                $opt_label = "<option value=1>Public</option>";
            else:
                $opt_label = "<option value=0>Private</option>";
            endif;

            //--option for public or private image
            $opt_ad = "<option value=0>Set Permission</option>";
            if($row->admin_allow != 0):
                $opt_ad = "<option value=1>Allowed</option>";
            else:
                $opt_ad = "<option value=0>Deny</option>";
            endif;
            
            //--only need the form bootstrap style
            $out .= "<form class='form-horizontal'>";
            
            //--edit the title of this image
            $out .= "<div class='form-group'>
                <label class='label-control col-sm-4'>Edit</label>
                <div class='col-sm-6'>
                <input type='text' class='form-control pic_title' data-pic_id='{$row->pic_id}' value='{$row->pic_title}'>
                </div>
            </div>";

            //--public or private this image
            $out .= "<div class='form-group'>
                <label class='label-control col-sm-4'>Show to</label>
                <div class='col-sm-6'>
                    <select class='form-control pic_pub' data-pic_id='{$row->pic_id}'>
                        {$opt_label}
                        <option value='0'>Private</option>
                        <option value='1'>Public</option>
                        
                    </select>
                </div>
            </div>";

            //--admin allow or deny this image
            //--public or private this image
            $out .= "<div class='form-group'>
                <label class='label-control col-sm-4'>Admin Permission</label>
                <div class='col-sm-6'>
                    <select class='form-control pic_perm' data-pic_id='{$row->pic_id}'>
                        {$opt_ad}
                        <option value='0'>Deny</option>
                        <option value='1'>Allowed</option>
                        
                    </select>
                </div>
            </div>";
            
            //--textarea full pic
            $out .= "
            <div class='form-group'>
                <label class='label-control col-sm-4'>BBCode full image</label>
                <div class='col-sm-6'>
                    <textarea class='form-control pic_code' data-pic_id='{$row->pic_id}' readonly='readonly'>{$full_bb_code}</textarea>
                </div>
            </div>
            ";
            $out .= "
            <div class='form-group'>
                <label class='label-control col-sm-4'>BBCode for Thumbnail</label>
                <div class='col-sm-6'>
                    <textarea class='form-control pic_code' data-pic_id='{$row->pic_id}' readonly='readonly'>{$thumb_bb_code}</textarea>
                </div>
            </div>
            ";

            
            if($this->is_admin):
                //---delete button
                $out .= "
                <div class='form-group'>
                    <label class='label-control col-sm-4'>&nbsp;</label>
                    <div class='col-sm-6'>
                        <button class='btn btn-danger btnDelPic' data-pic_id='{$row->pic_id}'>
                        Delete
                        </button>
                    </div>
                </div>
                ";
            endif;

            //--close form
            $out .= "</form>";
            
            //---close div.col-md-10
            $out .= "</div>";
        endforeach;

        return $out;
    }

    function getPicDetail($limit,$offset){
        $out = "";

        $this->db->select("*");
        $this->db->from($this->_tb_gall);
        $this->db->order_by("date_add","DESC");
        $this->db->limit($limit,$offset);

        $q = $this->db->get();

        $out .= "<div class='gallery cf'>";
        $num = 0;
        foreach($q->result() as $row):
            $num++;
            $thumb_pic = site_url("public/image/thumb/{$row->thumb_name}");
            $out .= "<div class='img_thumb'>
            <img src='{$thumb_pic}'>
            </div>";
        endforeach;

        $out .= "</div>";
        return $out;
    }

    function countPic($where=false){
        $get = 0;
        $num = 0;
        if($where):
            $get = $this->db
                        ->where($where)
                        ->order_by("date_add","DESC")
                        ->get($this->_tb_gall);
        else:
            $get = $this->db
                        ->order_by("date_add","DESC") 
                        ->get($this->_tb_gall);
        endif;
        $num = count($get->result());

        return $num;
    }
    

}//end of file
