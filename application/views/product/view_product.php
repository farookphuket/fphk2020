<section id="view_product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
<?php
    //var_dump($get);
    foreach($get as $row):
        
        ?>
    <div class="container">
        <h1 class="text-center">
<?php 
        echo $row->pd_title;
?>
        </h1>
        <p class="text-center">
            <?php echo $row->cat_section; ?>
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Seller</th>
                    <td>
                        <?php echo $row->name; ?>
                    </td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><?php echo $row->pd_price; ?> THB.</td>
                </tr>
            </table>
        </div>
        <div class="card">
            <div class="card-body">
<?php echo $row->pd_summary; ?>
            </div>
        </div>
        <p class="pt-4">&nbsp;</p>
        <?php echo $row->pd_body; ?>
    </div>
<?php
    endforeach;
?> 
            </div>
        </div>
    </div>
</section>
