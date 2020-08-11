<div class="jumbotron">
    <h1>Read category</h1>

</div>
<div class="panel panel-info">
    <div class="panel-heading">
        <h2>Title</h2>
    </div>
    <div class="panel-body">
        <table class="table table-striped">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Date</th>
                <th>Post By</th>
                <th>Status</th>
            </thead>
            <tbody>
                <?php 
                if($num_ar < 1):
                    ?>
                <tr>
                    <td colspan="5">
                    There is no data
                    </td>
                </tr>
                    <?php
                else:
                    $num = 0;
                    foreach($get_ar->result() as $row):
                        $num++;

                        ?>
                <tr>
                        <td><?php echo $num;?></td>
                        <td><?php echo $row->ar_title;?></td>
                        <td><?php echo $row->date_add;?></td>
                        <td><?php echo $row->ar_post_by;?></td>
                        <td><?php 
                        
                            $yes = "Yes";
                            $no = "No";
                            $pub = $no;
                            if($row->ar_show_public != 0):
                                $pub = $yes;
                            endif;
                            $ap = $no;
                            if($row->ar_is_approve != 0):
                                $ap = $yes;
                            endif;
                            echo"Public {$pub}| Approve {$ap}";
                        
                        ?></td>
                </tr>
                        <?php
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>
</div>
