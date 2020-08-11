<div class="container">
    <div class="jumbotron">
    <h1>profile of <?php echo $name; ?></h1>
    </div>

    <div class="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Edit <?php echo"{$name}'s profile";?></h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="label-control col-sm-4">Name</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control name" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label-control col-sm-4">E-mail</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control email" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label-control col-sm-4">Tel</label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control tel" value="<?php echo $tel; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label-control col-sm-4">Password</label>
                        <div class="col-sm-6">
                        <input type="password" class="form-control passwd">
                        <input type="hidden" class="admin_id" value="<?php echo $admin_id;?>" >
                        </div>
                    </div>
                </form>
                <div class="modal_status">
                    <pre>Please ,confirm your password to save the change</pre>
                </div>
            </div>
            <div class="modal-footer">
                    <div class="form-group">
                        <button class="btn btn-info btnSave" type="button">
                            Save
                        </button>
                    </div>

            </div>
        </div>
    </div>


</div><!--end of the html-->
<?php 
    require("admin_profileJS.php");
