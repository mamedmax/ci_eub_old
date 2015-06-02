<!DOCTYPE html>
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
			$(".alert").hide();
            $("#kosong").hide();
            $("#notloggin").hide();

            $("#dologin").click(function(){
					doLogged();
                    //return false;
            });

            function doLogged()
            {
                //alert("lho...");
                    var uname = $("#uname").val();
                    var pwd = $("#pwd").val();
                    
                    //console.log(uname+"="+pwd);                                                                                                                                                                                                                                                                                                        
                    
                    if (uname == "" || pwd== ""){
                        $("#kosong").fadeIn().delay(1800).fadeOut();
                        //$(".alert").show();
                        //alert(uname+"__"+pwd);
                    } else {

                        $.ajax({
                            url:"<?php echo base_url();?>admin/dologin",
                            type:"POST",
                            data:"un="+uname+"&pw="+pwd,
                            beforeSend:function(){
                                $("#loader").show();
                                $("#dologin").html("<img id='loader' src='<?php echo base_url();?>assets/images/loading.gif' >");
                                
                            },
                            success:function(text){ 
                                console.log(text);                          
                                $.each(JSON.parse(text), function(key, val){
                                    if(val.logged_in !== "true" )
                                    {
                                        //$('#loader').hide();
                                        console.log(text);
                                        //alert("Data login salah!");
                                        location.reload();
                                        
                                        /*$('#loader').hide();
                                        $("#uname").val("");
                                        $("#pwd").val("");
                                        $("#dologin").html("Login Lagi");
                                        */
                                        //return true;

                                    }else
                                    if(val.logged_in == "true") {
                                        //console.log(text);
                                        //alert("Gagal bro");
                                        window.location="<?php echo base_url();?>admin/dashboard";
                                        $('#loader').hide();
                                        $("#uname").val("");
                                        $("#pwd").val("");
                                        //$("#dologin").html("Login Lagi");
                                        return true;

                                    }else{

                                        location.reload();
                                    }
                                    
                                });
                                $('#loader').hide();
                                //return false;
                            },
                            error:function(text){
                                $('#loader').hide();
                                $('#gagal').fadeIn().delay(800).fadeOut();
                            }
                        });
                    } 

            }


        });
	
	</script>
	
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="<?php echo base_url();?>admin" ><img src="<?php echo base_url();?>assets/images/lp3i_logo.png" id="logo" height="50px"></a>
        <a class="navbar-brand" href="<?php echo base_url();?>admin">Sistem Informasi Evaluasi Umpan Balik
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
                        <h3 class="panel-title">EUB Login Akademik</h3>
                    </div>
                    <div class="panel-body">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" id="uname" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="pwd" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <!--<label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>-->
                                    <p id="notloggin" class="text-danger text-center">username dan password salah...!!!</p>
                                    <p id="kosong" class="text-danger text-center">username dan password kosong...!!!</p>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button id="dologin" class="btn btn-lg btn-success btn-block">Login</button>
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