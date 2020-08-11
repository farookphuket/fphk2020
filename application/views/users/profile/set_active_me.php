<section id="re_active">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
<?php
    if($msg):
        echo $msg;
       // echo"<br />your sess ip is {$sess_ip}";
    endif;

?>
            </div>
        </div>
    </div>
</section>
<script charset="utf-8">
    $(function(){

        const $resetMe = (function(){

            let ck_timeout = <?php echo $timeout; ?>;
            let ck_url = Cookies.get("url");

            if(ck_timeout === undefined){
                ck_timeout = 0;
            }
            if(ck_url === undefined){
                ck_url = "<?php echo $url; ?>";
            }

            function checkTheURL(){
                console.log(`The url is ${ck_url} the time is ${ck_timeout}`);
                if(parseInt(ck_timeout) === 0){
                    alert(`Sorry : your link has expired`);
                    setTimeout(()=>{
                        location.href = ck_url;
                    },5000);
                }
            }
            function takeMeHome(){
                checkTheURL();
                setTimeout(()=>{
                    location.href = ck_url;
                    //alert(`the url is ${ck_url}`);
                },8000);
            }
            function getEl(el){
                return $(el);
            }
            function getEvent(){
                takeMeHome();
            }
            return{getEvent:getEvent}
        })();
        $resetMe.getEvent();

    });   
</script>
