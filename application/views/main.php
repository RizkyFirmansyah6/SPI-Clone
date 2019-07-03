<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>App Tutup Sementara</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/default/easyui.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/icon.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/color.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/fonts/stylesheet.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/fonts/font-awesome/css/font-awesome.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("dist/ui/themes/user_defined.css"); ?>">

	<script type="text/javascript" src="<?php echo base_url("dist/ui/jquery.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("dist/ui/jquery.easyui.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("dist/js/datagrid-groupview.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("dist/js/jquery.jQueryRotate.js"); ?>"></script>
	<script>var the_url = "<?php base_url(); ?>";</script>
</head>
<body class="easyui-layout">
	<div data-options="region:'north',border:false" style="height:50px;background:#a1caf4;padding:10px; background-image:url(<?php echo base_url("dist/ui/img/banner.png");?>); background-repeat:no-repeat; background-position:center left;">
		<div class="tagNameArea">
			<span>Login sebagai, <strong style="color:#2c3e50;"><?php echo $this->session->userdata('nama_lengkap'); /*$login = $this->session->userdata('login'); echo $login['nip'];*/ ?>&nbsp;&nbsp;&nbsp;</strong></span> 
			<a href="javascript:void(0)" id="mb" class="easyui-menubutton settingButton" data-options="menu:'#set'">&nbsp;&nbsp;<i class="fa fa-cog fa-lg"></i>&nbsp; &nbsp; Setting &nbsp; </a>
			<div id="set" style="width:150px;">
				<div>Pengaturan User</div>
				<div>Ubah Password</div>
				<div class="menu-sep"></div>
				<div><a href="<?php echo base_url("index.php/main/validasiLogout"); ?>">Log Out</a></div>
			</div>
		</div>
	</div>
	<div data-options="region:'west',split:false,title:'MENU'" style="width:230px;padding:10px;">
		<ul class="" data-options="url:'<?php echo base_url("");?>index.php/Menu/',animate:true,lines:true" id="tt"></ul>
	</div>
		<script type="text/javascript" src="<?php echo base_url("dist/js/customs.js"); ?>"></script>
	<div data-options="region:'center'" id="center" style="">
	</div>
	<div data-options="region:'south',border:false" style="background:#2980b9; color:#ecf0f1; padding:10px; text-align:center;">SIM PDAM Kota Malang</div>
</body>
</html>