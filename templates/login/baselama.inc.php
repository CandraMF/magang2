<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="favicon.ico">

    <title>
     <!--JudulApp-->
    </title>
    <link rel="stylesheet" href="templates/login/assets/css/style.default.css" type="text/css" />
	<script type="text/javascript" src="templates/login/noback.js"></script>
	<style>
		bodybg{
			
		}
	</style>
</head>

<body class="loginbody" style=' background-image: url("templates/login/img/bg.jpg");opacity: 0.9;'>
<div class="loginwrapper">
    <div class="loginwrap zindex100 animate2 bounceInDown">
        <h1 class="logintitle">
        <span class="iconfa-lock"></span>
          <!--JudulApp-->
        <span class="subtitle">
          Selamat datang di Inventory Senjaya Steal
        </span>
        </h1>
        <div class="loginwrapperinner">
            <form action='{BaseMain}'  method="post" >
           <p class="animate4 bounceIn">
                <input type="text" id="username" name='uLogin' placeholder="Username" autocomplete="off" />
            </p>
            <p class="animate5 bounceIn">
                <input type="password" id="password" name='pLogin' placeholder="Password" />
            </p>
			<input type="hidden" name="uTahun" value='2022'>
			
            <p class="animate6 bounceIn">
			<div style='display:none'>
			<input type="hidden" name='uToken' value="{--utoken--}"/>
			</div>
                <button class="btn btn-default btn-block">
                    Login
                </button>
            </p>
			<input type="hidden" name="Pg" value='login' >
          

            </form>        </div>
        <!--loginwrapperinner-->
    </div>
  </div>

</div>

<p style="text-align: center;color:white; " class="animate7 fadeInUp"><b>Powered by : jabarsoft @ 2022</b></p>
<!--loginwrapper-->

</body>

</html>