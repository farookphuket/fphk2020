<section id="my_post">
  <?php
    foreach($get_ar as $row):
      $approve = "<span class='badge badge-success'>Yes</span>";
      if($row->ar_is_approve == 0):
        $approve = "<span class='badge badge-danger'>No</span>";
      endif;
      $public = "<span class='badge badge-success'>Yes</span>";
      if($row->ar_show_public == 0):
        $public = "<span class='badge badge-danger'>No</span>";
      endif;
      ?>
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="text-center">
              <?php echo $row->ar_title;?>
            </h1>
            <hr class="my-4">
            <p>&nbsp;</p>
          </div>
          <div class="col-lg-12">
            <?php echo $row->ar_summary; ?>
            <p>&nbsp;</p>
            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                  <th>Date</th>
                  <td>
                    <p>
                      <strong>
                        Create :
                      </strong>
                      &nbsp;<?php echo $row->date_add;?>&nbsp;
                      <strong>
                        Update :
                      </strong>&nbsp;
                      <?php echo $row->date_edit; ?>
                    </p>
                  </td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>
                    <p>
                      <strong>Approved :</strong>&nbsp;
                      <?php echo $approve;?>&nbsp;
                      <strong>Show Public :</strong>&nbsp;
                      <?php echo $public;?>
                    </p>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-lg-12">
            <p>&nbsp;</p>
            <?php echo $row->ar_body;?>
          </div>
        </div>
      </div>
      <?php
    endforeach;
  ?>
</section>
