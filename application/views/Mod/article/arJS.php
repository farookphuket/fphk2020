<script>

$(function(){
    var $el = $("#man_article");

    var manAr = (function(){
        
        function getEvent(){
            //alert("test");
            tinymce.remove();
        }
        return{getEvent:getEvent}
    })();
    manAr.getEvent();
});
</script>