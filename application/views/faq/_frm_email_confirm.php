<form id="frmFaqConfirm" action="<?php echo site_url("faq/faqGuestRequest"); ?>">

    <div class="container">
        <div class="col-lg-12">
            <h3 class="text-center">we need your confirm if you are not a robot</h3>
            <p>you request id will be include with the header</p>
            <textarea class="form-control">
<?php
    if($faq_code):
        echo"{$faq_code}";
    endif;
?>
            </textarea>
            <p class="pt-4">&nbsp;</p>
        </div>
    </div>
    
    <div class="form-group">
        <label for="faq_user_name">Your Name</label>
        <input type="text" name="faq_user_name" id="faq_user_name" class="faq_user_name form-control" required>
        <input type="hidden" name="request_id" value="<?php echo $faq_code; ?>">
    </div>

    <div class="form-group">
        <label for="faq_user_email">Your E-mail</label>
        <input type="email" name="faq_user_email" id="faq_user_email"  class="faq_user_email form-control" required>
    </div>
</form>
