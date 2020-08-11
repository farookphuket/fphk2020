<section id="google_login">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Google Login</h1>
            </div>
            <div class="col-lg-12">
                <div class="g-signin2" data-onsuccess="onSignIn"></div>

            </div>
        </div>
    </div>
</section>


<script charset="utf-8">
	
	let has_cookie = 0;
	let rd_url = "";
function onSignIn(googleUser) {
          let  profile = googleUser.getBasicProfile();
          has_cookie = 1;
            console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
            console.log('Name: ' + profile.getName());
              console.log('Image URL: ' + profile.getImageUrl());
              console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
            
            
            Cookies.set("g_email",profile.getEmail());
            Cookies.set("g_name",profile.getName());
            Cookies.set("has_cookie",has_cookie);
            
            setTimeout(()=>{
					location.reload();
			},3000);
            
              
    }



$(function(){


    
    
    const $gLogin = (function(){

		let ck_email = Cookies.get("g_email");
		let ck_name = Cookies.get("g_name");
		let ck_has = Cookies.get("has_cookie");
		let $page_status = $(".status");
		let rd_url = Cookies.get("rd_url");
		
		let num_has = 0;
		
		function checkEmailCookie(){
			
			let msg = '';
			if(ck_has === 0){
				msg = `The script will running to check the url is ${rd_url}`;
				
			}else{
				msg = `Stop run this script the email is ${ck_email}`;
				ck_has = 1;
				sentRequest();
			}
			
			console.log(msg);
			
			
		}
		
		
		function sentRequest(){
			
			let url = "<?php echo site_url("login/useGoogleService");?>";
			let data = {
				gmail : ck_email,
				google_name : ck_name
			};
			
			$.post(url,data,function(e){
				
				console.log(e);
				let rs = $.parseJSON(e);
				$page_status.html(rs.msg).show();
				//alert(`redirect to ${rs.url}`);
				setTimeout(()=>{
					$page_status.html("redirecting to member zone").fadeOut("slow");
					Cookies.set("rd_url",rs.url);
					location.href = rs.url;
					
				},2000);
				//location.reload();
					
			});
			
				
			
			
		}
		
		
        function getEvent(){
			let ck_once = "";
			
			if(ck_has === undefined){
				ck_has = 0;
				
			}
			
			if(rd_url === undefined){
				rd_url = "<?php echo current_url();?>";
			}
			
			
			checkEmailCookie();
            
        }
        return{getEvent : getEvent}
    })();
    $gLogin.getEvent();

    
});
</script>
