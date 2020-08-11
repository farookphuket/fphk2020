<div class="container">
    <div class="jumbotron">
        <h1>Manage the category</h1>
    </div>
    <div class="col-sm-10">
        <div class="page-header">
            <h1>Manage category <?php echo $num_cat; ?> item(s).</h1>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                     <th>
                        Category
                    </th>
                    <th>
                        Section
                    </th>
                    <th>
                        Public | user can edit
                    </th>
                    <th>
                        Manage
                        <button class="label btn-info btnAddCat" type="button">
Add
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
                if($num_cat == 0):
                    ?>
                <tr>
                    <td colspan="3">There is no category found!</td>
                </tr>
                <?php
                else:
                    $num = 0;
                    foreach($get_cat->result() as $row):
                        $num++;

?>
                <tr>
                    <td><?php echo $num;?></td>
                    <td>
                    <?php
                        echo $row->cat_title;

                    ?>
                    <span class="label btn-info">
                        <a href="<?php echo site_url("admin/read_cat/{$row->cat_id}");?>">
                        View <?php echo $row->has_content; ?> item(s).
                        </a>
                    </span>
                    </td>
                    <td>
                    <?php
                        echo $row->cat_section;
                    ?>
                    </td>
                    <td>
                        <?php
                                $yes = "<span class='label-success'>YES</span>";
                                $no = "<span class='label-danger'>NO</span>";
                                $pub = $no;
                                $allow = $no;
                                if($row->cat_show_public == 1):
                                    $pub = $yes;
                                endif;
                                if($row->allow_user_change == 1):
                                    $allow = $yes;
                                endif;

                                echo"{$pub}|{$allow}";
                         ?>
                    </td>
                    <td>
                    <button class="label btn-info btnEditCat" id="<?php echo $row->cat_id; ?>" type="button">
                        Edit
                    </button>
                    <button class="label btn-danger btnDelCat" id="<?php echo $row->cat_id; ?>" type="button">
                        Delete
                    </button>
                    </td>
                </tr>
<?php
                    endforeach;

                endif;

            ?>
            </tbody>
        </table>
    </div>


    <div class="modal fade modalCat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Add new Category</h1>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="label-control col-sm-4">Title</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control cat_title">
                                <input type="hidden" class="cat_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label-control col-sm-4">Section</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control cat_section">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="label-control col-sm-4">Section</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="cat_pub">
                                    </span>
                                    <input type="text" class="form-control pub_txt" value="Pivate" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="cat_change">
                                    </span>
                                    <input type="text" class="form-control change_txt" value="NOT ALLOW" />
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="modal_status">

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info btnSaveCat" type="button">
                        Save
                    </button>
                    <button class="btn btn-default btnCancle" type="button">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modalConf">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Confirm delete</h1>
                </div>
                <div class="modal-body">
                    <div class="conf_result">

                    </div>
                    <div class="cat_title">

                    </div>
                    <ul class="ar_show">

                    </ul>
                    <div class="warning">

                    </div>
                    <input type="hidden" class="cat_id">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btnOK" type="button">
                        yes,I know
                    </button>
                     <button class="btn btn-default btnCancle" type="button">
                        Close
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>




<?php

    require("catJS.php");
