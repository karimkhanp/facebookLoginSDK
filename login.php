<html>
	<head>
		<title>ThenWat</title>
		<link href = "css/button.css" rel = "stylesheet" type = "text/css">
		<link href = "css/rateit.css" rel = "stylesheet" type = "text/css">
		<!-- Bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" >
        <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
		<script src = "//connect.facebook.net/en_US/all.js"></script>
		<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src = "js/jquery.rateit.js" type = "text/javascript"></script>			
		<style>
			.middle{
				background-color:Yellow;
			}
			sta
			.left{
				background-color:Green;
			}
			.url{
				box-sizing: border-box;
				display: block;
			}
			.url:hover {
				box-shadow: 2px 2px 5px rgba(0,0,0,.2);
			}
			.header{
                background-color: #61B329;
                color: #FFF;
                margin-top: 0px !important;
                margin-bottom: 20px;
                padding-bottom: 9px;
            }
            .page-header-text {
                padding-left: 15px;
                padding-top: 20px;
                padding-bottom: 10px;
                margin: 0px;
            }
		
			
			html, body { margin: 0; padding: 0; border: 0 }
		</style>
		<script>
			$( document ).ready(function()
			{
				console.log( "ready!" );
				//alert("Welcome");
			});
		</script>
	</head>

	<body>
		<div class="page-header header">
            <h1 class="page-header-text">facebook login</h1>
        </div>		
			<table border = "0" width = "100%">
				<tr>
		 			<div class = "middle">
		 				<td style = "width:40%">
		 				<input type = "button" id = "loginButton" class = "btn btn-primary" onclick = "authUser();" value = "Login | Facebook" style = "display:none; left:500px; margin-top:200px; position:relative"/> 
		 				</td> 				
		 			</div>
		 		</tr>		 		
			</table>
		<div id = "fb-root"></div>
		<script type = "text/javascript">
			var userid;
			FB.init({,
			appId: 'fb app id',
			xfbml: true,
			status: true,
			cookie: true,
			});
			FB.getLoginStatus(checkLoginStatus);
			function authUser() 
			{
				FB.login(checkLoginStatus, {scope:'email'});
				// 1. Authenticates app from user when first time he visit the page
				// 2. Next time when user comes on the page automatically perform login if user is logged into his fb a/c and selected remember password
			}
			function checkLoginStatus(response) 
			{				
				if(response && response.status == 'connected') //If user already connected then get his data and store in db. no need for seperate user registration
				{
				FB.api('/me?fields = movies,email,name,gender,locale,location,link', function(mydata) //see facebook login API for more fields
				{
					console.log(mydata.email);
					console.log(mydata.id);
					userid = mydata.id;
					var name = mydata.name;
					gender = mydata.gender;
					locale = mydata.locale;
					city = mydata.location;
					link = mydata.link;
					//alert(name);
					var email = mydata.email;
					//var json = JSON.stringify(mydata.movies.data);
					//var a = JSON.parse(json);
					var picture = "https://graph.facebook.com/"+userid+"/picture?type = small";
					// alert(picture);
					//Here I have used ajax call to store the user profile info in db. You can use it as per your need
					$.post('user_record.php',{ name: name, email: email, userid:userid, picture:picture, gender: gender, locale: locale, city: city, link: link}, function(data)
					{
						var $form = $("<form id = 'form1' method = 'post' action = 'start.php'></form>"); //After storing data into userrecord.php redirecting to new page start.php. You can remove this if you want to stay on same page	
						$form.append('<input type = "hidden" name = "userid" value = "'+userid+'" />');
						$('body').append($form);
						window.form1.submit();
					});
				});
				
				console.log('Access Token: ' + response.authResponse.accessToken);
				}
				else
				{
					document.getElementById('loginButton').style.display = 'block';
				}
			}
		</script>	
	</body>	
</html>
