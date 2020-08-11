<form id="fTour" class="form-horizontal" action="<?php echo site_url("tour/adminSave");?>">
  <div class="form-group">
      <label for="og_url">Meta URL</label>
      <input type="text" class="form-control og_url" name="og_url" id="og_url">
  </div>
  <div class="form-group">
      <label for="keyword">Keyword</label>
      <input type="text" class="form-control keyword" name="keyword" id="keyword">
  </div>

  <div class="form-group">
    <label for="keydes">Description Key</label>
    <input type="text" class="form-control keydes" name="keydes" id="keydes">
  </div>
  <h2>&nbsp;</h2>
  <div class="form-group">
      <label for="title">
        Tour Title
      </label>
      <input type="text" name="title" id="title" class="form-control title" />

      <input type="hidden" class="kw_id" name="kw_id" />
      <input type="hidden" class="t_id" name="t_id"/>
    </div>

    <!--duration location price-->
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label for="duration">
                    Tour Duration
                </label>
                <input type="text" name="duration" id="duration" class="form-control duration col-sm-8" >
            </div>

            <div class="col-md-4">
                <label for="location">
                    Tour Location
                </label>
                <input type="text" name="location" id="location" class="form-control location col-sm-8">
            </div>

            <div class="col-md-4">
                <label for="full_price">
                  Tour Price
                </label>
                <input type="number" name="full_price" id="full_price" class="form-control full_price col-sm-4">
            </div>

        </div>

    </div>

    <!--summary-->
    <div class="form-group">
        <label for="tour_summary">Tour summary
        </label>
            <textarea class="form-control tour_summary tinymce" name="tour_summary" id="tour_summary"  rows=10></textarea>
      <p class="pt-4">&nbsp;</p>
      <div class="sumResult">

      </div>
        <p class="pt-4">&nbsp;</p>
    </div>

    <!--detail-->
    <div class="form-group">
      <label for="tour_detail">Tour Detail
      </label>
      <textarea class="form-control tour_detail tinymce" name="tour_detail" id="tour_detail"  rows=25></textarea>
    </div>
    <p class="pt-4">&nbsp;</p>
    <div class="result_body"></div>
    <p class="pt-4">&nbsp;</p>
    <div class="form-check-inline">
      <label class="form-check-label">
        <input type="checkbox" class="form-check-input mark_draft" name="mark_draft" id="mark_draft">
                    Save As Draft | Please uncheck this to public your program
      </label>
    </div>


</form>
