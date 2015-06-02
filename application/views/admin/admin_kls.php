	<!-- mads kls script -->
	<script>
		$(document).ready(function(){  
			$("#loader").hide();
			$("#loader2").hide();
			$(".alert").hide();
            $('#editKelas').show();
            listkelas();
            //listkelas();
            //$("#kosong").fadeIn().delay(1650).fadeOut();
            //$("#loader").fadeIn().delay(800).fadeOut();

            $('#addklsMdl').on('show.bs.modal', function(e) {

                
                $("[name=simpankls]").click(function(){
                    //alert("JQUERY SimpanKLS");
                        var idkls = $("[name=idkls]").val();
                        var kls = $("[name=kls]").val();
                        
                        if (idkls == "" ||kls == ""){
                            $("#kosong").fadeIn().delay(1800).fadeOut();
                            //$(".alert").show();
                            //alert("yoooo");
                        } else {

                            $.ajax({
                                url:"<?php echo base_url();?>admin/addKls",
                                type:"POST",
                                data:"idkls="+idkls+"&kls="+kls,
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
                                    $("[name=idkls]").val("");
                                    $("[name=kls]").val("");
                                    //$("#addKls")[0].reset();
                                    listkelas();
                                    
                                },
                                error:function(){
                                    $("#gagal").fadeIn().delay(1800).fadeOut();
                                }
                            });
                        } 
                });
            });
       
        
            $("#bcari").click(function(){
                    //$("#loader2").hide();
                    //$(".alert").hide();
                    listkelas();
            });
        //});

        //$(document).ready(function(){ 
            function listkelas(){
                var c = $("#txtcari").val();
                
                    $.ajax({
                        url:"<?php print base_url();?>admin/kelasCari",
                        type:"POST",
                        data:"c="+c,
                        typeData:"json",
                        //contentype: 'application/json; charset=utf-8',
                        beforeSend:function(){
                            $("#loader2").show();
                            //alert("eaaa...");
                        },
                        success:function(text){
                            var html = "";
                            console.log(text);
                            $("#data tr").remove(); 
                                //var json = JSON.stringify(text);
                            $.each(JSON.parse(text), function(key, val){
                                html += "<tr id='"+val.id_kls+"'>";
                                html += "<td><a href='#' data-toggle='modal' data-target='#editklsMdl' data-id='"+val.id_kls+"' data-kls='"+val.kelas+"' >"+val.id_kls+"</a></td>";
                                html += "<td>"+val.kelas+"</td>";
                                html += "<td><button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delklsMdl' data-id='"+val.id_kls+"' >";
                                html += "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>";
                                html += "</button></td>";
                                html += "</tr>";
                            });              
                                            
                        
                            $("#data").append(html);
                            $("#loader2").hide();

                        },
                        error:function(myJson){
                            $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                        }
                    });
            }

        //});

        
        //$(document).ready(function(){ 
            $("[type=reset]").click(function(){
                //$("#kosong").fadeIn().delay(1650).fadeOut();
                //$("#loader").fadeIn().delay(800).fadeOut();
                $("[name=idkls]").val("");
                $("[name=kls]").val("");
            });

            $('#delklsMdl').on('show.bs.modal', function(e) {

                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');

                //populate the textbox
                //$(e.currentTarget).find('label[name="id"]').val(id);

                //var id = this.id;                       
                            //var idtr = id.split(' ').join('_');
                            
                $(".modal-body").html("Yakin akan menghapus <b>"+id+"</b>?");
                $(".iddel").val(id);
                //$(".idtr").html(idtr);
            });

            $("[name=delKls]").click(function(){
                var id = $(".iddel").val();  

                            $.ajax({
                                url:"<?php echo base_url();?>admin/delKls",
                                type: "POST",
                                data: "id="+id,                    
                                beforeSend:function(){
                                    $("#loader").show();
                                },
                                success: function(id){
                                    $("#loader").hide();
                                    //alert(id);
                                    listkelas();
                                    $('#delklsMdl').modal('hide');                                 

                                },
                                error: function(){
                                    $("#loader").hide();  
                                    $("#danger-add.alert.alert-danger").show();
                                    setTimeout(function(){$("#danger-add.alert.alert-danger").slideUp();},3000);                        
                                }
                            });
            }); 

            $('#editklsMdl').on('show.bs.modal', function(e) {

                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');
                //var id = this.id;
                //var id = $('tr').attr('id');
                var kls = $(e.relatedTarget).data('kls');

                
                $("[name=idkls]").val(id);
                $("[name=kls]").val(kls);
                $("#loader3").hide();

                $("#updatekls").click(function(){
                    var idk = $("#idkls").val();
                    var kl = $("#kls").val();

                    if (kl == "" || idk == "") {
                        $("#kosong_ed").fadeIn().delay(1650).fadeOut();

                    }else{
                        alert(id+" _ "+kl+" _ "+idk);
                        $.ajax({
                            url:"<?php echo base_url();?>admin/updateKls",
                            type:"POST",
                            data:"id="+id+"&idk="+idk+"&k="+kl,
                            beforeSend:function(){
                                $("#loader3").show();

                            },
                            success:function(){
                                listkelas();
                                $("#loader3").hide();
                                $("#sukses_ed").fadeIn().delay(1800).fadeOut();  

                            },
                            error:function(){
                                $("#gagal_ed").fadeIn().delay(1800).fadeOut();

                            }


                        });
                    }

                });

                
            });

     });

	</script>

<div id="page-wrapper">
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Data Kelas</h3>
        </div>
    </div>
    <!-- /.col-lg-12 -->
            
    <div class="row">
        <div class="col-lg-2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addklsMdl">
                Tambah Kelas
            </button>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <input type="text" id="txtcari" class="form-control" placeholder="Cari">
                <span class="input-group-btn">
                    <button class="btn btn-info" id="bcari" type="button">Cari</button>
                </span>
                
            </div>
        </div>

    </div>
    <div class = "row col-md-offset-2">
        &nbsp;<img id="loader2" src="<?php echo base_url(); ?>assets/images/loading.gif" >
    </div>
    <div class = "row">
        <div class="alert alert-danger">Tidak ditemukan Data Kelas</div>
    </div>

    <div class="row">
        <div class="table-responsive col-lg-6">
            <table class="table table-bordered table-striped table-hover">
                <thead> 
                    <th width="30%">Kode Kelas</th>
                    <th width="30%">Kelas</th>
                    <th width="10%" align="center">Aksi</th>
                </thead>    
                <tbody id="data">
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <!-- Modal | Tambah Kelas -->
        <div class="modal fade" id="addklsMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Tambah Kelas</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmaddkls" role="form">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label>Kode Kelas</label>
                                        <input type="text" name="idkls" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                    <input type="text" name="kls" placeholder="" class="form-control"/>
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
                        <button type="button" name="simpankls" class="btn btn-primary" >Simpan</button>
                    </div>

                </div>
            </div>
        </div>  
        <!-- Modal | Edit Kelas -->
        <div class="modal fade" id="editklsMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Edit Kelas</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmaddkls" role="form">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="form-group">
                                        <label>Kode Kelas</label>
                                        <input type="text" name="idkls" id="idkls" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                    <input type="text" name="kls" id="kls" placeholder="" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                           
                            <div id="sukses_ed" class="alert alert-success">Data berhasil di-update!</div>
                            <div id="kosong_ed" class="alert alert-danger">Form Isian Kosong!</div>
                            <div id="gagal_ed" class="alert alert-danger">Data gagal di-update!</div>
                                                        
                        </form>
                    </div>
                    <div class="modal-footer" align="center">
                        <img id="loader3" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" id="updatekls" name="updatekls" class="btn btn-primary" >Update</button>
                    </div>

                </div>
            </div>
        </div>  

        <!-- Modal | Delete Kelas -->
        <div class="modal fade" id="delklsMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <button name="delKls" id="delKls" class="btn btn-danger" >Hapus</button>
                        <input type="hidden" class="iddel" name="iddel" />
                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
        <!-- /.modal fade -->
        </div>

    </div>

            
</div>
<!-- /#page-wrapper -->