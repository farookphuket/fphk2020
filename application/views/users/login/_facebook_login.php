
<section id="facebook_login">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Facebook login</h1>

                <div class="text-center">
					<div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true" onlogin="checkLoginState();"></div>
					
					
					<!--
					<fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
                </fb:login-button>
                -->
                
                </div>
                <form id="sendFB" action="<?php echo site_url("login/useFacebookLogin");?>">
					<input type="hidden" name="fb_name" class="fb_name" />
					<input type="hidden" name="fb_email" class="fb_email" />
					<input type="hidden" name="fb_id" class="fb_id" />
					
                </form>
                
                
            </div>
        </div>
    </div>
</section>




<script>



window.fbAsyncInit = function() {
    FB.init({
          appId      : '517263415883132',
            cookie     : true,
            xfbml      : true,
            version    : 'v6.0'
                                    
});
      
    FB.AppEvents.logPageView();   
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
        
    });
          
      
};







function checkLoginState() {
    FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
              
    });
    
}

function statusChangeCallback(response){
    //console.log(response);
    let url = "";
    let err = 0;
    if(response.status === 'connected'){
		
        getUser();
    }else{
		err = 1;
		url = "<?php echo site_url("login/facebookLogin"); ?>"; 
    }
    
    if(err === 1){
		setTimeout(()=>{
				//location.href = url;
				console.log(`not login yet`);
			},450);
	}
}

function getUser(){
 
	FB.api("/me",function(req){
	  //console.log(req);
	  Cookies.set("fb_name",req.name);
	  
	  Cookies.set("fb_id",req.id);
	  //console.log(req.email);
		if(req.email !== undefined){
		  Cookies.set("fb_email",req.email);
		}else{
			console.log(`There is no email from ${req.name}`);
			req.email = 0;
		}
		let url = "<?php echo site_url("login/useFacebookLogin");?>";
		let data = {
				action_id : req.id,
				fb_name : req.name,
				fb_email : req.email
			};
		$.ajax({
			type : "post",
			url : url,
			data : data,
			success : (e)=>{
				let rs = $.parseJSON(e);
				//console.log(rs);
				setTimeout(()=>{
				 location.href = rs.url;	
				},550);
			}
		});
		
	});	
	
}



(function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) {return;}
              js = d.createElement(s); js.id = id;
              js.src = "https://connect.facebook.net/en_US/sdk.js";
                   fjs.parentNode.insertBefore(js, fjs);
                 
}(document, 'script', 'facebook-jssdk'));


	

</script>
