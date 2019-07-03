<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>ABT - Login</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/fonts/stylesheet.css")?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/fonts/font-awesome/css/font-awesome.min.css"); ?>">
	<style>
		*{
			font-size:12px;
		}
		body {
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
			font-family: 'ubunturegular', 'Helvetica Neue', Helvetica, Arial, sans-serif;
			font-weight: 400;
			padding:20px;
			font-size:12px;
			margin:0;
			background-color:#2980b9;
		}
		.logo{
			text-align:center;
			margin-bottom:10px;
		}
		.logo img.pdam{
			background-color:#fff;
			width:100px;
			border-radius:50%;
			padding:10px;
			margin-left:0px;
		}
		.logo img.app{
			background-color:#eee;
			width:60px;
			border-radius:50%;
			margin-left:-25px;
		}
		.titleBox{
			font-size:26px;
			text-align:center;
			padding:0 10px 10px 10px;
			color:#fff;
		}
		.supTitle{
			font-size:16px;
			color:#fff;
			z-index:10;
			padding:0 10px 0 10px;
		}
		.supTitle span{
			background-color:#f39c12;
			padding:5px;
			border-radius:6px;
			margin:1px;
		}
		.box{
			width:300px;
			margin:auto;
			border-radius:4px;
		}
		.inputText, .inputButton{
			width:100%;
			-webkit-box-sizing : border-box;‌​
			-moz-box-sizing : border-box;
			box-sizing : border-box;
			border:none;
			font-size:14px;
			transition:all ease-in-out 0.15s;
		}
		.inputText{
			padding:15px;
			background-color:#fff;
			border-bottom:#ddd solid 1px;
			text-align:center;
		}
		.inputButton{
			padding:10px;
			background-color:#2ecc71;
			font-size:16px;
			border-bottom:#27ae60 solid 3px;
			border-radius:4px;
			color:#fff;
		}
		.inputButton:hover{
			background-color:#27ae60;
			border-bottom:#1f9f55 solid 3px;
			color:#eee;
			text-shadow: 0px 0px 3px #fff;
		}
		.inputArea, .buttonArea{
			padding:10px;
		}
		.inputArea input:first-child {
			border-radius:4px 4px 0 0;
		}
		.inputArea input:last-child {
			border-bottom:none;
			border-radius:0 0 4px 4px;
			border-bottom:#ddd solid 3px;
		}
		.footer{
			text-align:center;
			color:#fff;
			padding-top:10px;
		}
		#infoArea{color:#fff; text-align:center;}
	</style>
</head>
<body>
	<div class="logo"><img src="<?php echo base_url("dist/ui/img/logo_pdam2.png") ?>" class="pdam"><img class="app" src="<?php echo base_url("dist/ui/img/logo_app.png") ?>"></div>
	<div class="box">
		<div class="supTitle"><span>Login</span></div>
		<div class="titleBox">Aplikasi Satuan Pengawasan Internal</div>
		<form id="formLogin">
			<div class="inputArea">
				<input type="text" class="inputText" placeholder="Username" name="lName"/>
				<input type="password" class="inputText" placeholder="Password" name="lPass"/>
			</div>
			<div id="infoArea"></div>
			<div class="buttonArea">
				<input type="button" value="LOGIN" class="inputButton" id="btnSubmit"/>
			</div>
		</form>
	</div>
	<div class="footer">&copy; SIM PDAM Kota Malang</div>
	<script type="text/javascript" src="<?php echo base_url("dist/ui/jquery.min.js"); ?>"></script>
	<script>
		$(document).ready(function() {
			$("#btnSubmit").click(function(){
				var target = "#infoArea";
				$.ajax({
					url			: "<?php echo base_url(); ?>"+"index.php/main/validasiLogin", 
					type		: "POST", 
					dataType	: "html",
					data		: $("#formLogin").serialize(),
					beforeSend	: function(){
						$(target).html('<h2><i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;&nbsp;Loading . . . .</h2>');
					},
					success: function(response){
						if(response == '1'){
							window.location.replace ('<?php echo base_url()?>');
						}else{
							$(target).html(response);
						}
					},
					error: function(){
						alert('error');
					},
				});
				return false;
			});
			$("input[name='lName']").focus();
		});
		$(document).keypress(function(e) {
			if(e.which == 13) {
				$('#btnSubmit').focus().click();
			}
		});
	</script>
</body>
</html>