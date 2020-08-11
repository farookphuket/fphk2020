<div class="page-header">
    <h1>
        Tour program for&nbsp; 
        <span class="label label-default">
            <?php echo $user_name; ?>
        </span>
        
        
    </h1>
</div>
<div class="row show-list">
    
    <!--ul start-->
    <ul>
    <?php 
        if($num_tour == 0):

            ?>
            <li>
                <div class="alert alert-danger">
                    <h2>There is no data!</h2>
                </div>
            </li>
            
            <?php

        else:
            
            foreach($get_tour as $row):

                ?>
                <li>
                    <div class="content-wrap">
                        <h2>
                            <a href="<?php echo site_url("tour/detail/{$row->t_id}");?>" target="_blank">
                                <?php echo $row->t_name;?>
                            </a>
                        </h2>
                        
                            <p>
                                <?php echo $row->t_summary; ?>
                            </p>
                        <div class="row">
                            <div class="col-sm-4">
                                <h4>
                                    Minimum 2 people
                                    <span class="label label-warning">
                                        <?php echo $row->full_price; ?>&nbsp;THB. x 1pax.
                                    </span>
                                </h4>
                            </div>

                            <div class="col-sm-4">
                                <h4>
                                    Deposite
                                    <span class="label label-danger">
                                        <?php echo $row->min_price; ?>&nbsp;THB. x 1pax.
                                    </span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <br style="clear:both" />
                </li>
                <?php
            endforeach;
            if($num_tour >= $per_page):

                ?>
                <div class="pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <?php
            endif;

        endif;
        

    ?>
    </ul>
    <!--ul end-->
</div>