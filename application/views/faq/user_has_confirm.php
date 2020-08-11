<section id="faq_user_confirm">
<div class="container">
        <?php echo $msg; ?>
        <div id="timerJS">
            <div class="text-center show">
                <p>show</p>
            </div>
        </div>
</div>
</section>
<script>
$(function(){

    const $show = $("#timerJS");
    const GOTO_URL = (function(){
        let display = getEl(".show");
        let go_url = "<?php echo site_url("faq"); ?>";
        function startTimer(duration,display){
            let timer = duration,minutes,seconds;
            setInterval(function(){
                minutes = parseInt(timer/60,10);
                seconds = parseInt(timer % 60,10);

                minutes = minutes < 10 ? "0" +minutes : minutes;
                seconds = seconds < 10 ? "0" +seconds : seconds;
                let t_show = `<p>you can close this page or </p><p>go to ${go_url} in ${seconds} seconds from now.</p>`;
                display.html(t_show);
                if(--timer< 0){
                    timer = duration;
                    location.href = go_url;
                    //console.log(`we go to ${go_url} now`);
                }

            },1000);
        }

        function getEl(el){
            return $show.find(el);
        }
        function getEvent(){
            let tenMins = (60*1)/5;
            
            startTimer(tenMins,display); 
        }
        return{getEvent:getEvent}
    })();
    GOTO_URL.getEvent();

});
</script>

