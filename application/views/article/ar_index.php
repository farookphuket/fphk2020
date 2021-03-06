<section id="article">
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="col-lg-12">
                    <h1 class="text-center">Recent post</h1>
                    <hr class="my-4" />
                </div>
            </div>


            <div class="col-lg-12">
                <?php
                    if($num_ar == 0):

                        ?>
                        <div class="alert alert-danger">
                            <h2 class="text-center">There is no data.</h2>
                        </div>
                        <?php

                    else:
                        foreach($get_ar as $row):
                            $ln_read = site_url("article/read/{$row->uniq_id}");
                            ?>
                        <div class="card">
                            <div class="card-header">
                                <h2><?php echo $row->ar_title;?></h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <?php
                                            echo $row->ar_summary;
                                        ?>
                                    </div>
                                    <!--articcle table content-->
                                    <div class="col-lg-5">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                            <tr>
                                                    <th>Create By</th>
                                                    <td>
                                                    <?php echo $row->name;?>
                                                    </td>
                                                </tr>

                                            <tr>
                                                    <th>Create Date</th>
                                                    <td>
                                                    <?php echo $row->date_add ;?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Last Edit</th>
                                                    <td>
                                                    <?php echo $row->date_edit ;?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>has read</th>
                                                    <td>
                                                    <?php echo $row->ar_read_count ;?>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                            <a href="<?php echo $ln_read;?>" class="btn btn-primary btnRead" target="_blank">read more</a>
                            </div>
                        </div>

                        <br />
                            <?php
                        endforeach;



                        if($pagination):
                        echo"<div class=' pagination'>{$pagination}</div>";
                      endif;
                    endif;

                ?>
            </div>

        </div>
    </div>
</section>
