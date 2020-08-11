
    
<div class="row">

    <div class="col-sm-6">
      <div class="page-header">
        <h2>Feature on this system!</h2>
      </div>
      <ul>
          <li class="alert alert-info">
              Sat 21/4/2018 : user can login,reset password,write post.
          </li>
          <li class="alert alert-info">
              Sat 21/4/2018 : anonymous can ,register,booking,read article,ask question in FAQ.
          </li>
      </ul>
    </div>
    <div class="col-sm-6">
      <div class="page-header">
        <h2>ระบบนี้ทำอะไรบ้าง!</h2>
      </div>
      <ul>
          <li class="alert alert-info">
              Sat 21/4/2018 : ส่วนสมาชิก สามารถ เข้าใช้งานระบบสมาชิก,เปลี่ยนรหัสผ่าน,เขียนบทความ,อัพโหลดรูป.
          </li>
          <li class="alert alert-info">
              Sat 21/4/2018 : ส่วนผู้ใช้งานทั่วไป สามารถ สมัครสมาชิก,ติดต่อสอบถามใน FAQ(วันละ 1 ข้อความ),การสำรองที่นั่ง(ซื้อตั๋ว),อ่านบทความ.
          </li>
      </ul>
    </div>
</div>

<div class="row">
  <div class="page-header">
    <h2>Article</h2>
  </div>
  <?php
    if($num_ar != 0):
      //--only show if some data
      foreach($get_ar as $row):
      ?>
      <!-- comment out Thu 17 may 2018
        <div class="col-sm-6">
        <h3><?php //echo $row->ar_title;?></h3>
        <p>
          <?php //echo $row->ar_summary;?>
        </p>
        <h4>
        Read <span class="label label-info">
        <a href="<?php //echo site_url("article/read/{$row->ar_id}");?>">
        More?
        </a>
        </span>
        </h4>
      </div> -->
        <!--div panel on Thu 17 may 2018-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>
                   <?php echo $row->ar_title;?>
                    <a href="<?php echo site_url("article/read/{$row->ar_id}");?>" target="_blank">
                        <button type="button" class="btn btn-default btn-sm">
                        
                            <span class="glyphicon glyphicon-new-window"></span> Read More
                        
                        </button>
                    </a>
                </h2>
            </div>
            <div class="panel-body">
                <h3>
                    <?php echo $row->ar_summary;?>
                 </h3>
            </div>
            <div class="panel-footer">
                
            </div>
        </div>
        <!--end panel-->
        
      <?php
    endforeach;
    endif;
  ?>
</div>




<?php

        //require("homeJS.php");
