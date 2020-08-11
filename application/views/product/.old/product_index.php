<div class="container">
  <div class="jumbotron">
    <h1>Product</h1>
  </div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Title</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
      <?php
        if($num_product != 0):
            $num = 0;
            foreach($get_product->result() as $row):
              $num++;
              ?>
              <tr>
                <td>
                    <?php echo $num; ?>
                </td>
                <td>
                    <?php echo $row->pd_title;?>
                </td>
              </tr>
              <?php
            endforeach;
          else:

            ?>
            <tr>
              <td colspan="3">There are no data</td>
            </tr>
            <?php
        endif;
       ?>
    </body>
</table>

</div>
