




<footer class="footer">
    
        
    <div class="container footer">
        
        <p class="text-muted">
            
            
            Power by <?php echo"{$a_name}";?> on Dec 2017
            & Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  '& KickAss Version <strong>' . CI_VERSION . '</strong>' : '' ?>

        
        </p>
        <span class="visiter" id="visiter">
                
        </span>&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    
</footer>
<?php 
    require_once(APPPATH."../public/js/customJS.php");

?>
</body>
</html>