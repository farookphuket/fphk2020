<form id="frmFaq" action="<?php echo site_url("faq/faqUserSave") ?>">
    <div class="form-group">
        <label for="faq_title">Title</label>
        <input type="text" name="faq_title" id="faq_title" class="form-control faq_title" required>
        <input type="hidden" name="faq_id" id="faq_id">
        <input type="hidden" name="user_email" id="user_email" value="<?php echo $user_email; ?>">
        
        <input type="hidden" name="user_name" id="user_name" value="<?php echo $user_name; ?>">

        <input type="hidden" name="faq_user_id" id="faq_user_id" value="<?php echo $user_id ?>">


    </div>
    <div class="form-group">
        <label for="faq_body">Detail</label>
        <textarea class="form-control faq_body" name="faq_body" id="faq_body"></textarea>
    </div>
</form>
