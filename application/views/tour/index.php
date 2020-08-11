<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Our tour program
            </h2>
            <hr class="my-4" />

        </div>
        <div class="container">
            <?php 
            if($num_tour == 0):
                ?> 
            <div class="alert alert-danger">
                <h2>There is no tour program found.</h2>
            </div>
                <?php
            endif;
            foreach($get_tour as $row):
                ?>
            <div class="card">
                <div class="card-header">
                    <h2>
                    <?php echo $row->t_name; ?>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <?php 
                                echo $row->t_summary;
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Where to</th>

                                        <td>
                                            <?php 
                                        echo $row->t_destination;
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>how long</th>

                                        <td>
                                            <?php 
                                                echo $row->t_duration;
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>Full price</th>

                                        <td>
                                            <?php 
                                                echo $row->full_price;
                                            ?>
                                        </td>

                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary btnReadTour" href="<?php echo site_url("tour/detail/{$row->t_id}");?>" target="_blank">Read More</a>
                </div>
            </div>
            <br />
                <?php
            endforeach;

            ?>
        </div>

    </div>

</div>