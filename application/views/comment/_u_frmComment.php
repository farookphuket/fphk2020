



<form class="form-horizontal" action="<?php echo site_url("comment/uSaveComment");?>" id="commentForm">
            <!--comment user name-->
            <div class="form-group">
                <label for="c_user_name">Name</label>
                <input type="text" name="c_user_name" class="form-control c_user_name" required minlength="2">
                <input type="hidden" class="c_id" name="c_id">
                <input type="hidden" class="comment_url" name="comment_url" value="<?php echo current_url();?>">
                <input type="hidden" class="owner_email" name="owner_email">
<?php
            $c_user_id = 0;
            if($is_login):
                $c_user_id = $user_id;
            endif;

?>
            <input type="hidden" name="c_user_id" value="<?php echo $c_user_id; ?>" class="c_user_id">
            </div>

            <!--comment user email-->
            <div class="form-group">
                <label for="c_user_email">Email</label>
                <input type="email" name="c_user_email" class="form-control c_user_email" >
                <p class="pt-2">Your email will not show to public | email ของคุณจะไม่แสดงต่อสาธารณะ</p>

            </div>

            <div class="from-group">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="text-center">
                Dear visitor 
                    </h1>
                    <p class="pt-4">
                        We need you to confirm that you are a real person not a robot so by enter your email in the above email field is required we will sent email to you with the confirmation link that need you to click to activate it for us.
                    </p>
                        
                    </div>
                    <div class="col-lg-6">
                        <h1 class="text-center">
                ท่านที่เคารพทุกท่าน 
                    </h1>
                    <p class="pt-4">
                        เราต้องการให้ท่าน "ยืนยัน" ว่าท่านไม่ใช่โปรแกรม ทั้งนี้เราได้ส่งลิ้งค์ไปทางอีเมลที่ท่านได้กรอกเอาไว้ กรุณาคลิกลิ้งค์ที่ท่านได้รับทางอีเมลของท่านเพื่อ "ยืนยัน" ด้วยครับ
                    </p>
                        
                    </div>


                    <div class="col-lg-12">
                        <div class="float-right">
                            <a style="color:white;" class="btn btn-primary lnSent">Yes, sent me a code</a >
                        </div>
                    </div>
                </div>
                
                <p class="pt-5">&nbsp;</p>


            </div>
            <!--comment title-->
            <div class="form-group">
                <label for="c_title">Title</label>
                <input type="text" name="c_title" class="form-control c_title" required>


            </div>

            <!--comment body-->
            <div class="form-group">
                <label for="c_body">Comment</label>
                <textarea name="c_body" class="form-control c_body"  rows="9"></textarea>

            </div>


            

            <div class="commentResult">

            </div>
            <!--button area-->
            <div class="form-group">
                <div class="float-right">
                  <button class="btn btn-primary btnSave" type="submit" form="commentForm">
                      Comment
                    </button>
                </div>

            </div>
            <p class="pt-4">&nbsp;</p>



        </form>
