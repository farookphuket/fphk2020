<form action="<?php echo site_url("faq/faqAdminSave");?>" id="replyFaq">

    <div class="form-group">
        <label for="faq_title">FAQ title</label>
        <input type="text" name="faq_title" id="faq_title" class="faq_title form-control" /> 
        <input type="hidden" class="faq_id" name="faq_id" />
        <input type="hidden" class="faq_email" name="faq_email" />
        
    </div>

    <div class="form-group">
        <label for="faq_body">FAQ Body</label>
        <textarea name="faq_body" id="faq_body" class="form-control faq_body"></textarea>
        <p>&nbsp;</p>
    </div>

    <div class="form-group">
        <label for="">&nbsp;</label>
        <div class="row">
            <div class="col-md-4">
                <input type="checkbox" name="is_show" class="is_show" />  &nbsp;show this F.A.Q
            </div>
        </div>
    
    </div>
    <div class="form-group modal_status">
    
    </div>
</form>
