<?php


class Gallery extends MY_Controller{

    protected $user_id;
    protected $user_name;
    protected $_is_login;
    protected $is_admin;
    public $img_path;
    public $thumb_path;

    public $today;
function __construct(){
    parent::__construct();
    $this->load->model("Mdl_gallery");
    $this->today = date("Y-m-d h:i:s",time());
    $this->user_id = $this->session->userdata("user_id");
    $this->user_name = $this->session->userdata("user_name");
    $this->_is_login = $this->session->userdata("is_login");
    $this->img_path = realpath(APPPATH."../public/image/");
    $this->thumb_path = $this->img_path."/thumb/";

    $this->is_admin = $this->session->userdata("is_admin");

}

function index(){
    $this->data["subview"] = "gallery/index";
    $this->data["meta_title"] = "Gallery version 1.0";

    $url = site_url("gallery");
    if(isset($this->_is_login)):
        $url = site_url("gallery/own/{$this->user_id}");
        if($this->is_admin):
            $url = site_url("gallery/admin");
        endif;
        redirect($url);
    endif;
    $this->load->view("_layout_main",$this->data);
}//end of index

function add_pic(){
$picTitle = $this->input->post("txtPicTitle");

$conf = array(
    "upload_path" => $this->img_path,
    "allowed_types" => "JPG|jpeg|jpg|gif|x-png|png",
    "max_size" => 1024
    );
    $this->load->library("upload");
    $this->upload->initialize($conf);
//    $this->upload->do_upload();
    if(!$this->upload->do_upload("userfile")):
        var_dump($this->upload->display_errors());
    endif;
    $img_data = $this->upload->data();
 //   var_dump($img_data);
    $thumb_name = "_Thumb_".$img_data["file_name"];
    $thumb_conf = array(
    "source_image" => $img_data["full_path"],
    "new_image" => $this->thumb_path.$thumb_name,
    "maintain_ratio" => true,
    "width" => 250,
    "height" => 250
    );
    $this->load->library("image_lib");
    $this->image_lib->initialize($thumb_conf);
    $this->image_lib->resize();
    if(!$this->image_lib->resize()):
        $this->image_lib->display_errors();
//error resize image
    var_dump($this->image_lib->display_errors());

    endif;

    /*
Upload and resize is ready
    */
if(!empty($picTitle)):
    $picTitle = $picTitle;
else:
    $picTitle = $img_data["file_name"];
endif;

$pic_path = $this->img_path."/".$img_data["file_name"];
$img_add = array(
    "pic_title" => $picTitle,
    "pic_name" => $img_data["file_name"],
    "pic_path" => $img_data["full_path"],
    "thumb_name" => $thumb_name,
    "thumb_path" => $this->thumb_path.$thumb_name,
    "date_add" => $this->today,
    "album_id" => 1,
    "user_id" => $this->user_id
);
$add_me = $this->Mdl_gallery->save($img_add);
if(!$add_me):
    echo"Error : Data cannot be save!";
else:
?>
<p>
<img src="<?php echo site_url("public/image/".$img_data["file_name"]);?>" />
</p>
<p>
<img src="<?php echo site_url("public/image/thumb/".$thumb_name); ?>" />
</p>
<script>
    alert("File <?php echo $img_data['file_name'];?>  is uploaded!");
    setTimeout(function(){
  location.href = "<?php echo site_url("gallery/own/".$this->user_id); ?>";
    },700);
</script>

<?php
endif;

}//end of add_pic

function own($user_id){
    $this->data["subview"] = "gallery/own";
    $this->data["meta_title"] = "{$this->user_name}'s Gallery";
    $this->data["user_name"] = $this->user_name;
    $tb_gall = "gallery_1";
    $per_page = 8;
    $where_1 = array("user_id"=>$this->user_id);
    $get_all = $this->db
                ->where($where_1)
                ->get($tb_gall)->result();
    $num_all = count($get_all);

    //get the pagination
$this->load->library("pagination");
$page_conf = array(
"base_url" => site_url("gallery/own/".$this->user_id."/page/"),
"total_rows" => $num_all,
"per_page" => $per_page
);
$this->pagination->initialize($page_conf);
$this->data["get_my_pic"] = $this->db
                            ->where($where_1)
                            ->get($tb_gall,$page_conf["per_page"],$this->uri->segment(5))->result();
$page = $this->input->get("page");
if(!isset($page)):
$page = $per_page;
else:
$page = $page;
endif;

$this->data["num_my_pic"] = $num_all;
    $where = array("user_id"=> $this->user_id);
    $get_pic = $this->Mdl_gallery->get($where)->result();
    $num_pic = count($get_pic);
    $this->data["get_pic"] = $get_pic;
    $this->data["num_pic"] = $num_pic;

    $this->load->view("_layout_main",$this->data);
}

function show_pic($user_id=null){
    $pic_id = $this->input->post("pic_id");
    $where = array("pic_id"=>$pic_id);
    $get_pic = $this->Mdl_gallery->get($where)->result();
    $pic = array();
    foreach($get_pic as $row):
        $pic["pic_name"]= $row->pic_name;
        $pic["pic_id"] = $row->pic_id;
        $pic["pic_url"] = site_url("public/image/".$row->pic_name);
       $pic["show_img"] = "<img src='{$pic["pic_url"]}' />";

    endforeach;

        echo json_encode($pic);
}


//-----------------
//--Add this line Wed 9/5/18

function admin(){
    if(!$this->is_admin):
        redirect(site_url("gallery"));
    endif;
    $this->data["meta_title"] = "Gallery 1.0 Admin";
    $this->data["subview"] = "gallery/gallery_ADMIN";

    $this->load->view("_layout_admin",$this->data);
}
//-------
//--End of admin


}//end of the file
