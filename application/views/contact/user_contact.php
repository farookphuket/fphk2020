
<h1 class="page-header">
    <?php echo $user_name;?>'s inbox
</h1>

<div class="row">
    <div class="col-sm-6 well">
            <ul>
                <li>You can sent message to admin </li>
                <li>You can create new message and sent it but you cannot edit your message that you have been send</li>
            </ul>
    </div>
    <div class="col-sm-6 well">
        <ul>
            <li>
                 คุณสามารถส่งข้อความถึง Admin ได้โดยตรง
            </li>
            <li>คุณไม่สามารถแก้ไขข้อความที่ส่งไปแล้วได้ </li>
        </ul>
    </div>
</div>
<button class="btn btn-primary ln_compose btn-sm pull-right" type="button">
<span class="glyphicon glyphicon-plus"></span> Compose
</button>
<label class="alert alert-info">
    You have send <?php echo $num_all_msg;?> msg(s).
</label>
<div class="table-responsive">

<table class="table table-striped">
    <thead>
        <th>#</th>
        <th width="50%">Title</th>
        <th>Date</th>
        <th width="10%">Has Answer</th>
    </thead>
    <tbody class="message_list">
        <?php 
            if($num_all_msg == 0):
                ?>
                <tr>
                    <td colspan="4">There is no data</td>
                </tr>
                <?php
            endif;
            $num = 1;
            foreach($get_my_msg as $row):
                

                ?>
                <tr class="ls_faq">
                    <td>
                        <?php echo $num++;?>
                    </td>
                    <td>
                    
                    <a href="#" data-id="<?php echo $row->faq_id;?>" class="ln_read">
                    <?php echo $row->faq_title;?>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm ln_del" data-id="<?php echo $row->faq_id; ?>">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                    </td>
                    <td>
                    <?php 
                        $day_post = $row->faq_date;
                        $time_post = $row->faq_time;
                        echo"last send : {$day_post} {$time_post}";
                    ?>
                    
                    </td>
                    <td>
                    <?php echo $row->faq_has_ans;?>
                    </td>
                </tr>
                <?php
            endforeach;
            if($num_all_msg > $per_page):
                ?>
                <tr>
                <td colspan="4">
                    <div class="pagination">
                <?php echo $this->pagination->create_links(); ?>
                    </td>
                </td>
                </tr>
                <?php
            endif;
        ?>
    </tbody>
</table>
</div>
<div class="modal fade mdFrmMessage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title">Sent message to Admin</h1>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url("contact/own");?>" method="post" class="form-horizontal" id="frmSendMessage">
                    
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">From</label>
                        <div class="col-sm-6">
                            <input type="text" name="faq_email" class="faq_email form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Message Title</label>
                        <div class="col-sm-6">
                        <input type="hidden" class="faq_id" name="faq_id">
                        <input type="hidden" class="faq_user_id" name="faq_user_id">
                            <textarea class="form-control faq_title" name="faq_title">
                            
                            </textarea> 
                            
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="label-control col-sm-4">&nbsp;</label>
                        <div class="col-sm-6">
                            <div class="title_length">
                            
                            </div>
                            <p class="text_count"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="faq_body" class="faq_body tinymce"></textarea>
                    </div>
                </form>
                <div class="modal_status">

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btnCompose" type="submit" form="frmSendMessage">
                Send Message
                </button>
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                Close
                </button>

            </div>
        </div>
    </div>
</div>
<!--modal user read message -->
<div class="modal fade mdRead">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                Read message
                </h1>
            </div>
            <div class="modal-body">
                <div class="show_faq_body">

                </div>
                <div class="ans_list">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btnClose">
                Close 
                </button>
            </div>
        </div>
    </div>
</div>
<!--End of modal user read message-->
<?php 
    require("user_contactJS.php");







