<div class="jumbotron">
        <h1>Contact Us</h1>
    </div>
    
    <div class="row">
        <div class="col-sm-4">
            <div class="show-list">
                <ul>
                    <li>
                        <div class="content-wrap">
                            <h2>Contact Farook</h2>
                            <p>
                                <img class="responsive" src="<?php echo site_url("public/img/Contact/Farook_wed-19-Sep-2018.png");?>" />
                            </p>
                            <p>
                                
                                <a class="btn btn-primary btnFBContact" href="https://m.me/farook.fuutime" target="_blank">
                        Message Farook on Facebook
                                </a>
                            </p>
                            <p>
                            <a href="https://hangouts.google.com/group/5IMnME8WHmcL1umD3" title="Talk to farook in Hangout as a group chat" class="btn btn-info btn-sm" target="_blank">Talk in Google Hangout</a>
                            </p>
                            <p>
                            Tel. +66 81 397 4489 or +66 95954 3920
                            </p>
                            <p>
                                E-mail : farookphuket@gmail.com
                            </p>
                            <br style="clear:both"/>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="show-list">
                <ul>
                    <li>
                        <div class="content-wrap">
                            <h2>Contact Tee</h2>
                            <p>
                                <img class="responsive" src="<?php echo site_url("public/img/Contact/Tee_wed-19-Sep-2018.png");?>" />
                            </p>
                            <p>
                                
                                <a class="btn btn-primary btnFBContact" href="https://m.me/weekya" target="_blank">
                        Message Tee on Facebook
                                </a>
                            </p>
                            <p>
                            Tel. +66 89 08672119 
                            </p>
                            <p>
                                E-mail : 
                            </p>
                            <br style="clear:both"/>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="show-list">
                <ul>
                    <li>
                        <div class="content-wrap">
                            <h2>Contact Tom</h2>
                            <p>
                                <img class="responsive" src="<?php echo site_url("public/img/Contact/Tom_wed-19-Sep-2018.png");?>" />
                            </p>
                            <p>
                                
                                <a class="btn btn-primary btnFBContact" href="https://m.me/nipon.pannoi" target="_blank">
                        Message Tom on Facebook
                                </a>
                            </p>
                            <p>
                            Tel. +66  862 2432589
                            </p>
                            <p>
                                E-mail : 
                            </p>
                            <br style="clear:both"/>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
            
        
    </div>
    
    
    <div class="col-sm-10">
        <div class="page-header">
            <h1>FAQ</h1>
        </div>   
        <div class="show_faq_list">
            <!--dynamic content here--> 

        </div>
        <div class="show_faq_ans">
            <!--get the dynamic content-->
        </div>


    </div>

    <div class="col-sm-10">
        <div class="page-header">
            <h1>Ask your own question</h1>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <ul>
                    <li class="alert alert-success">
                        please feel free if you have your own question to us.
                    </li>
                </ul>
            </div>
            <div class="col-sm-6">
                <ul>
                    <li class="alert alert-success">
                        มีคำถามอื่นๆ เชิญครับ
                    </li>
                </ul>
            </div>
        </div>
        
        
        <form class="form-horizontal" id="frm_contact" method="post" action="<?php echo site_url("faq/saveFaq");?>">
            <div class="form-group">
                <label for="" class="col-sm-4 label-control">Name</label>
                <div class="col-sm-6">
                    <input type="text" name="faq_name" class="faq_name form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">E-mail</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control faq_email" name="faq_email">
                    <input type="hidden" class="faq_id" name="faq_id">
                    <input type="hidden" name="faq_ip" value="<?php echo $ip; ?>">
                    <input type="hidden" class="faq_edit">

                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control faq_title" name="faq_title">
                </div>
            </div>
             <div class="form-group">
                <label class="label-control col-sm-4">Message</label>
                <div class="col-sm-6">
                    <textarea class="form-control faq_body" name="faq_body">
                    </textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">&nbsp;</label>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-info btnSend">
                        Sent Message
                    </button>&nbsp;
                    
                    <p>&nbsp;</p>
                    <h4>
                    <span class="label label-warning">
                    <?php echo"OS {$os}. {$browser}. IP {$ip}";?>
                    </span>
                    </h4>
                </div>
            </div>

            <div class="form-group">
                <label class="label-control col-sm-4">&nbsp;</label>
                <div class="col-sm-6">
                   <div class="modal_status">

                    </div>
                </div>
            </div>
    </form>
    </div>

<?php 
require("faqJS.php");
