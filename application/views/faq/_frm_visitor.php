<form id="frmFaq" action="<?php echo site_url("faq/faqGuestSave"); ?>">

    <div class="form-group">
        <label for="faq_title">Title</label>
        <input type="text" name="faq_title" class="form-control faq_title" required>
        <input type="hidden" name="faq_id" id="faq_id" value="<?php echo $faq_id; ?>">
    </div>
    <div class="form-group">
        <label for="faq_body">Detail</label>
        <textarea name="faq_body" id="faq_body" class="form-control faq_body"></textarea>
    </div>
    <div class="form-group">
        <label for="btnFaqSave">&nbsp;</label>
        <button class="btn btn-primary btnFaqSave" type="submit" form="frmFaq">Save</button>
    </div>
</form>
