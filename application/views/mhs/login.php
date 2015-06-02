
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EUB LP3I-PSM">
    <meta name="author" content="ahmad">

    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" />

   <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url();?>assets/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/dist/css/sb-admin-2_login.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- JQuery Plugin -->
	<script src="<?php echo base_url();?>assets/js/jquery-1.11.2.min.js"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script>
		$(document).ready(function(){
			$("#loader").hide();
			$("#kosong").hide();
            $("#notloggin").hide();

            $("#dologin").click(function(){
					//alert("lho...");
                    var nim = $("#nim").val();
                    var pwd = $("#pwd").val();
					
					console.log(nim+"="+pwd);                                                                                                                                                                                                                                                                                                        
                    
                    if (nim == "" || pwd== ""){
                        $("#kosong").fadeIn().delay(5600).fadeOut();
                        //$(".alert").show();
                        //alert(uname+"__"+pwd);
                    } else {

                        $.ajax({
                            url:"<?php echo base_url();?>mhs/dologin",
                            type:"POST",
                            data:"nim="+nim+"&pw="+pwd,
                            beforeSend:function(){
                                $("#loader").show();
                                //alert(data);
                                //console.log(data);
                            },
                            success:function(text){	
								console.log(text);							
								$.each(JSON.parse(text), function(key, val){
									if(val.mhs_logged_in == "TRUE")
                                    {

                                        $("#notloggin").hide();
                                        $('#loader').hide();
                                        window.location="<?php echo base_url();?>mhs/dashboard";

                                    }else
                                    if(val.mhs_logged_in !== "TRUE")
                                    {
                                        //
                                        //alert("NIM & Password Salah!");
                                        $("#notloggin").show();
                                        $('#loader').hide();
                                         location.reload(true);
                                         return false;

                                    }
                                
                                    
									
							     });
    							$('#loader').hide();
                                //$("#notloggin").show();

							},
							error:function(text){
								$('#loader').hide();
								$('#notloggin').fadeIn().delay(3000).fadeOut();
							}
                        });
                    } 
            });



        });
	
	</script>
	
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>-->

        <a class="navbar-brand" href="<?php echo base_url();?>mhs" ><img src="<?php echo base_url();?>assets/images/lp3i_logo.png" id="logo" height="50px"></a>
        <a class="navbar-brand" href="<?php echo base_url();?>mhs" >Sistem Informasi Evaluasi Umpan Balik
                                                              <small>Politeknik LP3I Jakarta Kampus Pasar Minggu</small></a>
          
    </div>
    <!-- /.navbar-header -->
</nav>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
			&nbsp;<br/>
		</div>
		
		<div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">EUB Login Mahasiswa</h3>
                    </div>
                    <div class="panel-body">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="NIM" id="nim" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="pwd" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <p id="notloggin" class="text-danger text-center">NIM dan password salah...!!!</p>
                                    <p id="kosong" class="text-danger text-center">NIM dan password kosong...!!!</p>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button id="dologin" class="btn btn-lg btn-success btn-block">
                                    <img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                                    Login
                                </button>
                            </fieldset>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->

</body>
</html>