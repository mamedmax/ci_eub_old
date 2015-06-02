<script>
	$(document).ready(function(){  
		$("#loader").hide();
		$("#loader2").hide();
		$(".alert").hide();
        //$('#editKelas').show();
        listUser();

        function listUser(){
        	var c = $("#txtcari").val();
                
            $.ajax({
                url:"<?php echo base_url();?>admin/listUser",
                type:"POST",
                data:"c="+c,
                typeData:"json",
                beforeSend:function(){
                    $("#loader2").show();
                    //alert("eaaa...");
                },
                success:function(text){
                	var html = "";
                    console.log(text);
           	        $("#datausr tr").remove(); 
                    //var json = JSON.stringify(text);
                    $.each(JSON.parse(text), function(key, val){
                        html += "<tr id='"+val.id_user+"'>";
                        html += "<td><a href='#' data-toggle='modal' data-target='#addusrMdl' data-id='"+val.id_user+"' data-usr='"+val.username+"' data-nm='"+val.nama+"' data-pos='"+val.posisi+"' >"+val.id_user+"</a></td>";
                        html += "<td>"+val.username+"</td>";
                        html += "<td>"+val.nama+"</td>";
                        html += "<td>"+val.posisi+"</td>";
                        html += "<td><button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delusrMdl' data-id='"+val.id_user+"' data-usr='"+val.nama+"' >";
                        html += "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>";
                        html += "</button></td>";
                        html += "</tr>";
                    });              
                                            
                        
                    $("#datausr").append(html);
                    $("#loader2").hide();

                },
                error:function(){
                	$("#gagal").fadeIn().delay(1000).fadeOut();
                }


            });

        }

        $('#addusrMdl').on('show.bs.modal', function(e) {
        	var id = $(e.relatedTarget).data('id');

        	if (id == null ){
        		
                $(".modal-title").html("Tambah User");
                $("[name=pwd]").attr('placeholder','');
                $("[name=idusr]").val("");
				$("[name=usrname]").val("");
				$("[name=nama]").val("");
				$("[name=posisi]").val("");

				$("#btnaksi").attr('name','simpanusr');

	            $("[name='simpanusr']").click(function(){
	                var idusr = $("[name=idusr]").val();
	                var usr = $("[name=usrname]").val();
	                var pwd = $("[name=pwd]").val();
	                var nama = $("[name=nama]").val();
	                var pos = $("[name=posisi]").val();
	                        
	                if (idusr == "" ||usr == "" ||pwd == "" ||nama == "" ||pos == "" ){
	                    $("#kosong").fadeIn().delay(1800).fadeOut();
	                            //$(".alert").show();
	                            //alert("yoooo");
	                } else {

	                            $.ajax({
	                                url:"<?php echo base_url();?>admin/addUsr",
	                                type:"POST",
	                                data:"idusr="+idusr+"&usr="+usr+"&pwd="+pwd+"&nm="+nama+"&pos="+pos,
	                                beforeSend:function(){
	                                    $("#loader").show();
	                                    //alert(data);
	                                },
	                                success:function(text){
	                                    console.log(text);
	                                    //alert("eaaa...lg");
	                                    $("#sukses").fadeIn().delay(1800).fadeOut();
	                                    $("#loader").hide();
	                                    //$("#sakses").fadeIn().delay(16500).fadeOut();
	                                    //$("#sakses").fadeIn().show();
	                                    $("[name=idusr]").val("");
						                $("[name=usrname]").val("");
						                $("[name=pwd]").val("");
						                $("[name=nama]").val("");
						                $("[name=posisi]").val("");
	                                    //$("#addKls")[0].reset();
	                                    listUser();
	                                    
	                                },
	                                error:function(text){
	                                	console.log(text);
	                                    //$("#gagal").fadeIn().delay(1800).fadeOut();
	                                }
	                            });
	                } 
	            });

			}else{

				var usr = $(e.relatedTarget).data('usr');
                //var pwd = $(e.relatedTarget).data('pwd');
                var nm = $(e.relatedTarget).data('nm');
                var pos = $(e.relatedTarget).data('pos');


        		$(".modal-title").html("Edit User");
				$("#btnaksi").attr('name','updateUsr').html("Update");

        		$("[name=idusr]").attr('readonly','').val(id);
				$("[name=usrname]").val(usr);
				$("[name=pwd]").attr('placeholder','Ganti pwd');
				$("[name=nama]").val(nm);
				$("[name=posisi]").val(pos);


				$("[name='updateUsr']").click(function(){
					
					$(".alert").hide();

                    var idusr = $("[name=idusr]").val();
                    var usr = $("[name=usrname]").val();
                    var pwd = $("[name=pwd]").val();
                    var nama = $("[name=nama]").val();
                    var pos = $("[name=posisi]").val();

                    alert("id "+idusr+" usr "+usr+" pwd "+pwd+" ");

                    if (idusr == "" ||usr == "" ||nama == "" ||pos == "" ){
                        $("#kosong").fadeIn().delay(1800).fadeOut();
                                //$(".alert").show();
                                //alert("yoooo");
                    } else {

                                $.ajax({
                                    url:"<?php echo base_url();?>admin/updateUsr",
                                    type:"POST",
                                    data:"idusr="+idusr+"&usr="+usr+"&pwd="+pwd+"&nm="+nama+"&pos="+pos,
                                    beforeSend:function(){
                                        $("#loader").show();
                                        //alert(data);
                                    },
                                    success:function(text){
                                        console.log(text);
                                        //alert("eaaa...lg");
                                        $("#sukses").fadeIn().delay(1800).fadeOut();
                                        $("#loader").hide();
                                        //$("#sakses").fadeIn().delay(16500).fadeOut();
                                        //$("#sakses").fadeIn().show();
                                        //$("#addKls")[0].reset();
                                        listUser();
                                        
                                    },
                                    error:function(text){
                                        console.log(text);
                                        //$("#gagal").fadeIn().delay(1800).fadeOut();
                                    }
                                });
                    } 

				});



			}
        });


		$('#delusrMdl').on('show.bs.modal', function(e) {

                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');
                var usr = $(e.relatedTarget).data('usr');

                //populate the textbox
                //$(e.currentTarget).find('label[name="id"]').val(id);

                //var id = this.id;                       
                            //var idtr = id.split(' ').join('_');
                            
                $(".modal-body").html("Yakin akan menghapus <b>"+id+" - "+usr+"</b>?");
                //$(".iddel").val(id);
                //$(".idtr").html(id);
        

        	$("#delUsr").click(function(){
            	var idtr = id;  
                $.ajax({
                    url:"<?php echo base_url();?>admin/delUsr",
                    type: "POST",
                    data: "id="+id,                    
                    beforeSend:function(){
                        $("#loader").show();
                    },
                    success: function(id){
                        //console.log(id);
                        $("#loader").hide();
                        //listUser();  
                        //$('table#akad tr#'+id).fadeOut(600).remove();
                        
                                         //table#test tr#3' 
                        $("#"+idtr).fadeOut(650).remove(); //remove tr
                        //alert(idtr);.
                        $('#delusrMdl').modal('hide');  
                        

					},
                    error: function(){
                        $("#loader").fadeOut(600).hide();  
                        $("#gagal").show();
                        setTimeout(function(){$("#gagal").slideUp();},3000);                        
                    }
                           
				});
            }); 
		});

		

    });

</script>

<div id="page-wrapper">

	<div class="row">
        <div class="col-lg-12">
          	<h3 class="page-header">Data User Akademik</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addusrMdl">
                Tambah User
            </button>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <input type="text" id="txtcariuser" class="form-control" placeholder="Cari User...">
                <span class="input-group-btn">
                    <button class="btn btn-info" id="bcariuser" type="button">Cari</button>
                </span>
                
            </div>
        </div>

    </div>

    <!-- Tabel User -->
    <div class = "row col-md-offset-2">
        &nbsp;<img id="loader2" src="<?php echo base_url(); ?>assets/images/loading.gif" >
    </div>
    <div class = "row">
        <div class="alert alert-danger">Tidak ditemukan Data Kelas</div>
    </div>

    <div class="row">
        <div class="table-responsive col-lg-10">
            <table id="akad" class="table table-bordered table-striped table-hover">
                <thead> 
                    <th width="8%"># User</th>
                    <th width="15%">Username</th>
                    <th width="20%">Nama</th>
                    <th width="20%">Posisi</th>
                    <th width="5%" align="center">Aksi</th>
                </thead>    
                <tbody id="datausr">
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <!-- Modal | Tambah Kelas -->
        <div class="modal fade" id="addusrMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Tambah User</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmaddusr" role="form">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label>ID User</label>
                                        <input type="text" name="idusr" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Username</label>
                                    <input type="text" name="usrname" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Password</label>
                                    <input type="password" name="pwd" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Nama</label>
                                    <input type="text" name="nama" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Posisi</label>
                                    <input type="text" name="posisi" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                           
                            <div id="sukses" class="alert alert-success">Data berhasil disimpan!</div>
                            <div id="kosong" class="alert alert-danger">Form Isian Kosong!</div>
                            <div id="gagal" class="alert alert-danger">Data gagal disimpan!</div>
                                                        
                        </form>
                    </div>
                    <div class="modal-footer" align="center">
                        <img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" name="simpanusr" id="btnaksi" class="btn btn-primary" >Simpan</button>
                    </div>

                </div>
            </div>
        </div>




        <!-- Modal | Delete User -->
        <div class="modal fade" id="delusrMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Hapus Data</h4>
                    </div>
                    <div class="modal-body">
                        <p>Yakin hapus data?</p>
                    </div>
                                
                    <div class="modal-footer" align="center">
                        <!--<img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >-->
                        <button name="selesai" class="btn btn-default" data-dismiss="modal" >Batal</button>
                        <button name="delUsr" id="delUsr" class="btn btn-danger" >Hapus</button>
                        <input type="hidden" class="iddel" name="iddel" />
                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
        <!-- /.modal fade -->
        </div>  
           
</div>
<!-- /#page-wrapper -->