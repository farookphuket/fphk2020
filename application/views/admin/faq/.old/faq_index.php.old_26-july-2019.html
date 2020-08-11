<div class="jumbotron">
        <h1>Faq Managing year : <?php echo date("Y",time());?></h1>
        
</div>
<div class="well">
    <ul class="what-new">
        <li>Last update Mon 9 Apr 2018: show form answer faq</li>
        <li>
            Tue/10/Apr/2018 : answer to the faq
        </li>
        <li>
            Wed/10/Apr/2018 : set faq show or hide ,add delete feature to faq
        </li>
    </ul>
</div>
<div class="page-header">
    <h2>All FAQ <?php echo $num_faq;?> item(s).</h2>
    
</div> 

<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <th>
            #
        </th>
        <th>Title</th>
        <th>user email</th>
        <th>date</th>
        <th>Show/Hide</th>
        <th>answer</th>
    </thead>
    <tbody>
        <?php 
            if($get_faq == 0):
                ?>
                <tr>
                    <td>There is no data</td>
                </tr>
                <?php
                else:
                    $num = 0;
                    foreach($get_all_faq as $row):
                        $num++;
                        ?>
                    <tr>
                        <td><?php echo $num;?></td>
                        <td>
                            <div class="row">
                                <a href="#" data-id="<?php echo $row->faq_id;?>" class="ln_read">
                                <?php echo $row->faq_title;?>
                                </a>
                                &nbsp;|
                                <?php echo $row->faq_name;?>
                                |&nbsp;
                                
                                <?php echo $row->faq_email;?>
                                |&nbsp;
                                <button type="button" class="btn btn-danger btn-sm del_faq" data-faq_id="<?php echo $row->faq_id; ?>">
                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                </button>
                                
                            </div>
                        
                        
                        </td>
                        <td>
                        <?php echo $row->faq_email; ?>
                        </td>
                        <td>
                        <?php echo $row->faq_date; ?>
                        </td>
                        <td>
                        <?php 
                            $label = "Hide";
                            if($row->faq_is_show != 0):
                                $label = "Show";
                            endif; 
                            echo $label;
                        ?>
                        </td>
                        <td>
                        <?php echo $row->faq_has_ans; ?>
                        </td>
                    </tr>
                        <?php
                    endforeach;
                    if($num_faq > $per_page):
                        ?>
                    <tr>
                        <td colspan="6">
                        <div class="pagination">
                        <?php echo $this->pagination->create_links();?>
                        </div>
                        </td>
                    </tr>
                        <?php
                    endif;
                    ?>

                    <?php
            endif;
        ?>
    </tbody>
</table>
</div>
<div class="modal fade mdReplyForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title mdFaqTitle">Re :</h1>
            </div>
            <div class="modal-body">
                <div class="faq_body">
                    faq body goes here.
                </div>
                <div class="form-group well">
                <label class="label-control col-sm-4">mark as Public</label>
                <div class="col-sm-6 input-group">
                    <span class="input-group-addon">
                    <input type="checkbox" name="faq_pub" class="faq_pub">
                    </span>
                    <input type="text" class="form-control f_txt">
                </div>
                </div>
                <div class="ans_list">

                </div>
                <div class="page-header">
                    <h2>Answer to faq : <span class="faq_name"></span></h2>
                </div>
                <div class="form formAns">
                    <form class="form-horizontal" id="ansFaq" action="<?php echo site_url("faq/admin");?>">
                        <div class="form-group">
                            <label class="label-control col-sm-4">Title</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control ans_title" name="ans_title">
                                <input type="hidden" class="faq_id" name="faq_id">
                                <input type="hidden" class="ans_id" name="ans_id">
                            </div>
                        </div>
                        <div class="form-group">
                           <textarea class="form-control tinymce ans_body" name="ans_body">

                            </textarea>
                        </div>
                        <div class="form-group">
                            <label class="label-control col-sm-4">&nbsp;</label>
                            <div class="col-sm-6">
                            <button class="btn btn-info btnReply" type="submit" form="ansFaq">
                            Reply 
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require("faqJS.php");
