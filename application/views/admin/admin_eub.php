<script>
	$(document).ready(function(){
        $("#loader").hide();
        $("#loader2").hide();
        
        $("#seluruh").hide();
        $("#perkelas").hide();
        $("#persoal").hide();
        $("#lain").hide();

        $("#lap-kls").hide();
        $("#lap-rekap").hide();

        $("#bt_all").click(function(){

        	$("#seluruh").show();
        	$("#perkelas").hide();
        	$("#persoal").hide();
            $("#lap-kls").hide();
            $("#lap-rekap").hide();
        	eubAllDosen();

            $("#data-lap-all tr").remove(); 

        });

        $("[href=#perkelas]").click(function(){

        	$("#seluruh").hide();
        	$("#perkelas").show();
        	$("#persoal").hide();
            $("#lap-rekap").hide();
        	loadK();

            $("#data-lap-kls tr").remove(); 

        });
        $("[href=#persoal]").click(function(){

        	$("#seluruh").hide();
        	$("#perkelas").hide();
        	$("#persoal").show();
            $("#lap-kls").hide();
            $("#lap-rekap").hide();
        	loadK();

            $("#data-lap-rekap tr").remove(); 
            
        });

        $("#klsList2").change(function(){
            loadDsn();

        });

        $("#lapKls").click(function(){
            $("#lap-kls").hide();

        	if ( $("#klsList").val() == '' )
        	{
        		$('#alertKls').modal('show');

        	} else {

	        	$("#lap-kls").show();
	        	eubDsnKls();

	        }

        });

        $("#rekap").click(function(){
            $("#lap-rekap").show();
            loadRekapDsn();
        });

        $("#printEubAll").click(function(){
        	window.print();

        });

        $("#printKls").click(function(){
        	window.print();

        });


        function eubAllDosen()
        {

        	$.ajax({
                url:"<?php print base_url();?>admin/eubAllDosen",
                type:"POST",
                data:"",
                typeData:"json",

                beforeSend:function(){
                	$("#loader").show();
                            //alert("eaaa...");
                },
                success:function(text){
                    var html = "";
                    console.log(text);
                    $("#data-lap-all tr").remove(); 
                                //var json = JSON.stringify(text);
                    var no = 0;
                    $.each(JSON.parse(text), function(k, v){

                    	no = no + 1;
                        html += "<tr id='"+v.id_eub_dosen+"' >";
                        html += "<td>"+no+"</td><td>"+v.id_dosen+"</td><td>"+v.nama_dosen+"</td>";
                        html += "<td>"+v.nilai+"</td><td>"+v.ket+"</td>";
                        html += "</tr>";
                     
                    });                  
                        $("#data-lap-all").append(html);
                        $("#loader").hide();

                    

                },
                error:function(){
                    $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                    $("#loader").hide();
                }
            });
        }

        function loadK()
        {
            $.ajax({
                url:'<?php echo base_url();?>admin/getKls',
                type: "POST",
                typeData:"json",
                beforeSend:function(){
                    $("#loader").show();

                    $("#loader3").show();
                },              
                success: function(myjson){  //data adalah hasil respon atau kirim data dari 
                    var select  = $("#klsList");
                    var sel = $("#klsList2");
                    select.empty();
                    sel.empty();
                    select.append("<option value='' selected > -- Pilih -- </option>");
                    sel.append("<option value='' selected > -- Pilih Kelas -- </option>");
                    $("#dsnList").append("<option value='' selected >  ----------   Pilih Dosen   ---------  </option>");
                    console.log("edit "+myjson);
                    
                    $.each(JSON.parse(myjson), function(k, v) {                         
                                                
                        select.append("<option value='"+v.id_kls+"'><strong>"+v.kelas+"</strong></option>");
                        sel.append("<option value='"+v.id_kls+"'><strong>"+v.kelas+"</strong></option>");                
                                             
                    }); 
                    $("#loader").hide();
                    $("#loader3").hide();
                                            
                    console.log($("#klsList").val());

                },
                error: function(){
                    $("#loader").hide();
                    $("#loader3").hide();
                    alert("Data kelas tak berhasil ditampilkan");                    
                }

            }); 

        }

        function loadDsn()
        {
            var id = $("#klsList2").val();

            $.ajax({
                url:'<?php echo base_url();?>admin/getDsnOnKls',
                type: "POST",
                data:"id="+id,
                typeData:"json",
                beforeSend:function(){
                    $("#loader3").show();
                },              
                success: function(myjson){  //data adalah hasil respon atau kirim data dari 
                    var sel = $("#dsnList");
                    sel.empty();
                    sel.append("<option value='' selected >  ----  Pilih Dosen  ----  </option>");
                    console.log("edit "+myjson);
                    
                    $.each(JSON.parse(myjson), function(k, v) {                         
                                                
                        sel.append("<option value='"+v.id_dosen+"'><strong> "+v.id_dosen+" - "+v.nama_dosen+" </strong></option>");                
                                             
                    }); 
                    $("#loader3").hide();
                                            
                    console.log($("#dsnList").val());

                },
                error: function(){
                    $("#loader3").hide();
                    alert("Data dosen gagal ditampilkan");                    
                }

            }); 

        }


        function eubDsnKls()
        {
        	var k = $("#klsList").val();

        	$.ajax({
                url:"<?php print base_url();?>admin/eubDsnKls",
                type:"POST",
                data:"k="+k,
                typeData:"json",

                beforeSend:function(){
                	$("#loader2").show();
                            //alert("eaaa...");
                },
                success:function(text){
                    var html = "";
                    console.log(text);
                    $("#data-lap-kls tr").remove(); 
                                //var json = JSON.stringify(text);
                    
                    if (text == "[]")
                    {
                    	//$("#lap-kls").remove();
                    	//$("#lap-kls").append("<p>Data Evaluasi untuk kelas ini belum terisi.</p>");
                    	html += "<tr><td colspan='5' >Data Evaluasi untuk kelas ini belum terisi</td></tr>";

                    } else {
	                    var no = 0;
	                    $.each(JSON.parse(text), function(k, v){

	                    	no = no + 1;
	                        html += "<tr id='"+v.id_eub_dosen+"' >";
	                        html += "<td>"+no+"</td><td>"+v.id_dosen+"</td><td>"+v.nama_dosen+"</td>";
	                        html += "<td>"+v.nilai+"</td><td>"+v.ket+"</td>";
	                        html += "</tr>";
	                     
	                    });  
	                } 

                        $("#data-lap-kls").append(html);

                        $("#lblKls").text(k);
                        $("#loader2").hide();

                    

                },
                error:function(){
                    $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                    $("#loader2").hide();
                }
            });
        }

        function loadRekapDsn()
        {
            var kl = $("#klsList2").val();
            var ds = $("#dsnList").val();

            $.ajax({
                url:"<?php print base_url();?>admin/rekapDsn",
                type:"POST",
                data:"k="+kl+"&d="+ds,
                typeData:"json",

                beforeSend:function(){
                    $("#loader3").show();
                            //alert("eaaa...");
                },
                success:function(text){
                    var html = "";
                    console.log(text);
                    $("#data-lap-rekap tr").remove(); 
                                //var json = JSON.stringify(text);
                    
                    if (text == "[]")
                    {
                        //$("#lap-kls").remove();
                        //$("#lap-kls").append("<p>Data Evaluasi untuk kelas ini belum terisi.</p>");
                        html += "<tr><td colspan='18' align='center' >Data rekap belum terisi!</td></tr>";

                    } else {
                        var no = 0;
                        $.each(JSON.parse(text), function(k, v){

                            no = no + 1;
                            html += "<tr id='"+v.id_eub_dosen+"' >";
                            html += "<td>"+no+"</td><td>"+v.s1+"</td><td>"+v.s2+"</td><td>"+v.s3+"</td>";
                            html += "<td>"+v.s4+"</td><td>"+v.s5+"</td><td>"+v.s6+"</td><td>"+v.s7+"</td>";
                            html += "<td>"+v.s8+"</td><td>"+v.s9+"</td><td>"+v.s10+"</td><td>"+v.s11+"</td>";
                            html += "<td>"+v.s12+"</td><td>"+v.s13+"</td><td>"+v.s14+"</td><td>"+v.s15+"</td>";
                            html += "<td>"+v.s16+"</td><td>"+v.totalp+"</td>";
                            html += "</tr>";
                         
                        });  
                    } 

                        $("#tb-lap-rekap").append(html);

                        $("#lblKls2").text(kl);
                        $("#loader3").hide();

                    

                },
                error:function(){
                    $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                    $("#loader2").hide();
                }
            });

        }


    });

</script>

<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Laporan Evaluasi Dosen</h3>
        </div>
    </div>
    <!-- /.col-lg-12 -->

   	<div class="row" >
   		<div class="col-lg-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                	<a href="#seluruh" data-toggle="tab" id="bt_all" >Hasil Nilai Keseluruhan</a>
                </li>
                <li>
                	<a href="#perkelas" data-toggle="tab" >Hasil Nilai Per Kelas</a>
                </li>
                <li><a href="#persoal" data-toggle="tab">Laporan Hasil Detail</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="seluruh">
	                <div class="row">
	                	<br/>
	                	<div class="col-lg-12">
	                    	<div class="panel panel-default">
	                        	<div class="panel-heading">
	                        		<img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
	                        		<button id="printEubAll" type="button" class="btn btn-info" >Cetak</button>
	                        	</div>
	                        	<!-- /.panel-heading -->
	                        	<div class="panel-body">
	                            	<div class="table-responsive">
	                            		<table id="lap-all" class="table table-striped table-bordered table-hover">
		                                    <thead>
		                                        <tr>
		                                            <th>#</th>
		                                            <th width="10%" align="center" >Kode Dosen</th>
		                                            <th>Nama Dosen</th>
		                                            <th align="center" >Nilai</th>
		                                            <th align="center" >Keterangan</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody id="data-lap-all">
		                                    	<tr>
		                                    	</tr>
		                                    </tbody>
		                                </table>
	                            	</div>

	                            </div>
	                        </div>
	                    </div>
	                </div>

                </div>


                <div class="tab-pane fade" id="perkelas">
                	<br/>
                	<div class="row"> 
                        <div class="col-lg-3 col-lg-offset-0">
                            <div class="input-group">
                                <select class="form-control" id="klsList" >
                                    <option>1</option>
                                </select>
                                <span class="input-group-btn">
                                	<button id="lapKls" type="button" class="btn btn-info">Tampilkan</button>
                                </span>

                            </div>
                            <img id="loader2" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                            
                        </div>
                    </div>
                    <div class="row">
	                	<br/>
	                	<div class="col-lg-12">
	                    	<div class="panel panel-default" id="lap-kls" >
	                        	<div class="panel-heading">
	                        		<button id="printKls" type="button" class="btn btn-info" >Cetak</button>&nbsp;&nbsp;
	                        		Kelas: <span id="lblKls"></span>
	                        	</div>
	                        	<!-- /.panel-heading -->
	                        	<div class="panel-body">
	                            	<div class="table-responsive">
	                            		<table id="tb-lap-kls" class="table table-striped table-bordered table-hover">
		                                    <thead>
		                                        <tr>
		                                            <th>#</th>
		                                            <th width="10%" align="center" >Kode Dosen</th>
		                                            <th>Nama Dosen</th>
		                                            <th align="center" >Nilai</th>
		                                            <th align="center" >Keterangan</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody id="data-lap-kls">
		                                    	<tr>
		                                    	</tr>
		                                    </tbody>
		                                </table>
	                            	</div>

	                            </div>
	                        </div>
	                    </div>
	                </div>

                </div>


                <div class="tab-pane fade" id="persoal">
                    <br/>
                    <div class="row"> 
                        <div class="col-md-3">
                            <div class="input-group">
                                <select class="form-control" id="klsList2" >
                                    <option>1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <select class="form-control" id="dsnList" >
                                    <option>1</option>
                                </select>
                                <span class="input-group-btn">
                                    <button id="rekap" type="button" class="btn btn-info">Tampilkan</button>
                                </span>

                            </div>
                            <img id="loader3" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                            
                        </div>
                    </div>
                    <div class="row">
                        <br/>
                        <div class="col-lg-12">
                            <div class="panel panel-default" id="lap-rekap" >
                                <div class="panel-heading">
                                    <button id="printRekap" type="button" class="btn btn-info" >Cetak</button>&nbsp;&nbsp;
                                    Kelas: <span id="lblKls2"></span>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="tb-lap-rekap" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th colspan="16" align="center" >Jawaban dari soal:</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                                <tr>
                                                    <th># Mhs</th>
                                                    <th align="center" >1</th>
                                                    <th align="center" >2</th>
                                                    <th align="center" >3</th>
                                                    <th align="center" >4</th>
                                                    <th align="center" >5</th>
                                                    <th align="center" >6</th>
                                                    <th align="center" >7</th>
                                                    <th align="center" >8</th>
                                                    <th align="center" >9</th>
                                                    <th align="center" >10</th>
                                                    <th align="center" >11</th>
                                                    <th align="center" >12</th>
                                                    <th align="center" >13</th>
                                                    <th align="center" >14</th>
                                                    <th align="center" >15</th>
                                                    <th align="center" >16</th>
                                                    <th align="center" >Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-lap-rekap">
                                                <tr>
                                                    <td align="center" colspan="18">Data empty!</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="tab-pane fade" id="lain">
                                    <h4>Settings Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
                       <!-- </div>-->
                        <!-- /.panel-body -->
                    <!--</div>-->
                    <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
   	</div>

   	<div class = "row">
   		<div class="modal fade" id="alertKls" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <!--<div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>-->
                    <div class="modal-body">
                        <p align="center">Kelas belum dipilih!</p>
                    </div>
                    <!--<div class="modal-footer" align="center">
                        <img id="loader3" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" id="updatekls" name="updatekls" class="btn btn-primary" >Update</button>
                    </div>-->

                </div>
            </div>
        </div>  
   	</div>





</div>
<!-- /#page-wrapper -->