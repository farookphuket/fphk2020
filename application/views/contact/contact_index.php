
    <div class="jumbotron">
        <h1>Contact Us</h1>
    </div>
    <div class="col-sm-10">

        <pre>
            <img src="<?php echo site_url("public/img/contact-farook.png");?>" >
        </pre>
    </div>
    <div class="col-sm-10">
        <div class="page-header">
            <h1>FAQ</h1>
        </div>
        
    </div>
    <div class="col-sm-10">
        <div class="page-header">
            <h1>Ask your own question</h1>
        </div>
        <p>
            <ul class='alert alert-warning'>
                <li>Your question will be show after approve from Admin</li>
                <li>You will recieve e-mail from <?php echo $admin_email;?> in your Inbox. only if you provide your valid e-mail.</li>
            </ul>
        </p>
        
        <form class="form-horizontal" id="frm_contact" method="post" action="<?php echo site_url("contact/sendQuestion");?>">
            <div class="form-group">
                <label class="label-control col-sm-4">E-mail</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control faq_email" name="faq_email">
                    <input type="hidden" class="faq_id" name="faq_id">
                    <input type="hidden" name="faq_ip" value="<?php echo $ip; ?>">
                    <input type="hidden" class="faq_edit">

                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control faq_title" name="faq_title">
                </div>
            </div>
             <div class="form-group">
                <label class="label-control col-sm-4">Message</label>
                <div class="col-sm-6">
                    <textarea class="form-control faq_body" name="faq_body">
                    </textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">&nbsp;</label>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-info btn_contact">
                        Sent Message
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="label-control col-sm-4">&nbsp;</label>
                <div class="col-sm-6">
                   <div class="modal_status">

                    </div>
                </div>
            </div>
    </form>
    </div>



<?php 
    require("contactJS.php");







