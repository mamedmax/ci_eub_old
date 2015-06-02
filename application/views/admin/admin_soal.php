	<script>
        


        $(document).ready(function(){
			$("#loader").hide();
			$("#loaderTbl").hide();
			$(".alert").hide();

            listsoal();
            $("#loads").click(function(){
            
                listsoal();
            });

			$("[name=simpanSoal]").click(function(){
                    var id = $("#id_soal").val();
                    var soal = $("#soal").val();
                    
                    if(id == "" || soal == ""){
                        $("#kosong").fadeIn().delay(1650).fadeOut();

                    } else {
                        $.ajax({
                            url:"<?php echo base_url();?>admin/addSoal",
                            type:"POST",
                            data:"id="+id+"&soal="+soal,
                            beforeSend:function(){
                                $("#loader").show();
                                //alert(id+"_"+soal);
                            },
                            success:function(){
                                //console.log(data);
                                //$("#add").show();
                                $("#loader").hide();
                                //$("#kosong").show();
                                $("#success").fadeIn().delay(1650).fadeOut();
                                $("#frmaddsoal")[0].reset();
                                //initDataTable();
                                //$("#add").show();
                                $("#cari").val("");
                                listsoal();
                            },
                            error:function(){
                                //console.log(data);
                                //alert(data);
                                $("#gagal").fadeIn().delay(1650).fadeOut();
                                $("#loader").hide();
                            }
                        });
                    }

            });
            

            function listsoal(){
                var c = $("#cari").val();
                 //var c = "";

                $.ajax({
                    url:"<?php echo base_url();?>admin/loadSoal",
                    type:"POST",
                    data:"c="+c,
                    typeData:"json",
                    beforeSend:function(){
                        $("#loaderTbl").show();
                    },
                    success:function(text){
                        var html = "";
                        console.log(text);
                        
                        $("#datasoal tr").remove(); 

                        $.each(JSON.parse(text), function(k, v){
                            html += "<tr id='"+v.id_soal+"'>";
                            html += "<td><a href='#' data-toggle='modal' data-target='#editsoalMdl' data-id='"+v.id_soal+"' >"+v.id_soal+"</a></td><td>"+v.soal+"</td>";
                            html += "<td><button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delsoalMdl' data-id='"+v.id_soal+"' >";
                            html += "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button></td>";
                            html += "</tr>";


                        });
                        
                        $("#datasoal").append(html);
                        $("#loaderTbl").hide();

                        

                    },
                    error:function(){
                        $("#gagal").fadeIn().delay(1650).fadeOut();
                        $("#loaderTbl").hide();
                    }
                });

            }

            $('#delsoalMdl').on('show.bs.modal', function(e) {

                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');


                //populate the textbox
                //$(e.currentTarget).find('label[name="id"]').val(id);

                //var id = this.id;                       
                            //var idtr = id.split(' ').join('_');
                            
                $(".modal-body").html("Yakin akan menghapus <b>"+id+"</b>?");
                $("#iddel").val(id);
                $("#loaderdel").hide();
                //$(".idtr").html(idtr);

                $("#delSoal").click(function(){
                var id = $('#iddel').val();

                    $.ajax({
                        url:"<?php echo base_url();?>admin/delSoal",
                        type: "POST",
                        data: "id="+id,                    
                        beforeSend:function(){
                                    $("#loaderdel").show();
                        },
                        success: function(id){
                                    $("#loaderdel").hide();
                                    //alert(id);
                                    listsoal();
                                    $('#delsoalMdl').modal('hide');
                                    //$("tr#"+id).fadeOut(500); //remove tr
                                    

                        },
                        error: function(){
                                    $("#loaderdel").hide();  
                                    $("#gagal").show();
                                    setTimeout(function(){$("#danger").slideUp();},3000);                        
                        }



                    });

                });
            });

            $('#editsoalMdl').on('show.bs.modal', function(e) {
                $("#loadered").hide();
                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');
                $("#edid_soal").val(id);
                getaSoal(id);
                $("#edsoal").focus();
                //alert(id);

            });

            function getaSoal(id)
            {
                //val id = $id;
                $.ajax({
                    url:"<?php echo base_url();?>admin/getSoal",
                    type:"POST",
                    data:"id="+id,
                    typeData:"json",
                    beforeSend:function(){
                        $("#loadered").show();
                        //alert(id);
                    },
                    success:function(text){
                        //s$("#id_soal").val(id);
                        console.log(text);

                        $.each(JSON.parse(text), function(k, v){
                            
                            $("#edsoal").val(v.soal);

                        });


                        $("#loadered").hide();
                    },
                    error: function(){
                        $("#loadered").hide();  
                        $("#gagal").show();
                    }
                });

            }

            $("#updateSoal").click(function(){
                var id = $("#edid_soal").val();
                var soal = $("#edsoal").val();

                if (soal == "") {
                    $("#kosong_ed").fadeIn().delay(1650).fadeOut();
                }else{

                    $.ajax({
                        url:"<?php echo base_url();?>admin/updateSoal",
                        type:"POST",
                        data:"id="+id+"&s="+soal,
                        typeData:"json",
                        beforeSend:function(){
                            $("#loadered").show();
                            //alert(s);
                        },
                        success:function(data){
                            //s$("#id_soal").val(id);
                            //console.log(data);
                            $("#success_ed").fadeIn().delay(1650).fadeOut();
                            listsoal();
                            $("#loadered").hide();
                            delay(1800);
                            $('#editsoalMdl').modal('hide');
                        },
                        error: function(){
                            $("#loadered").hide();  
                            $("#gagal_ed").show();
                        }

                    });
                }

            });
                        




            


        });


    </script>


<div id="page-wrapper">
    <div class="row">
        &nbsp;
    </div>
	<div class="row">
        <div class="col-lg-2">
            <button name="tampiltambah" class="btn btn-default" data-toggle="modal" data-target="#addsoalMdl">Tambah</button>
        </div>
        <div class="col-lg-4">
            <div class="input-group">
                <input type="text" id="cari" class="form-control" placeholder="Cari Soal">
                <span class="input-group-btn">
                    <button id="loads" class="btn btn-default" type="button">Cari</button>
                </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->

	</div>

	<div class="row">
		<div class="panel-body">
            <div class="table-responsive">
                <img id="loaderTbl" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                <table class="table table-bordered table-striped table-hover">
                    <thead> 
                        <th width="6%">#Soal </th>
                        <th width="" >Soal</th>
                        <th width="6%" align="center">&nbsp;</th>
                    </thead>

                    <tbody id="datasoal">
                    </tbody>
                </table>
            </div>
        </div>
                              		               	

	</div>

    <div class="row" >
        <!-- Modal | Tambah Soal -->
        <div class="modal fade" id="addsoalMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Tambah Soal</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmaddsoal" role="form">
                            <div class="panel-body">
                                <div class="row col-md-2">
                                    <div class="form-group">
                                        <label>No. Soal</label>
                                        <input name="edid_soal" id="id_soal" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="form-group">
                                        <label>Soal</label>
                                        <textarea class="form-control" id="soal" required="required"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="success" class="alert alert-success">Data berhasil disimpan!</div>
                            <div id="kosong" class="alert alert-danger">Form Isian Kosong!</div>
                            <div id="gagal" class="alert alert-danger">Data gagal disimpan!</div>
                                                        
                        </form>
                    </div>
                    <div class="modal-footer" align="center">
                        <img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" name="simpanSoal" class="btn btn-primary" >Simpan</button>
                    </div>

                </div>
            </div>
        </div>  

        <!-- Modal | Edit Soal -->
        <div class="modal fade" id="editsoalMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">  
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Edit Soal</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frmeditsoal" role="form">
                            <div class="panel-body">
                                <div class="row col-md-2">
                                    <div class="form-group">
                                        <label>No. Soal</label>
                                        <input name="id_soal" id="edid_soal" class="form-control" required="required"  readonly>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="form-group">
                                        <label>Soal</label>
                                        <textarea class="form-control" id="edsoal" required="required"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id="success_ed" class="alert alert-success">Data berhasil disimpan!</div>
                            <div id="kosong_ed" class="alert alert-danger">Form Isian Kosong!</div>
                            <div id="gagal_ed" class="alert alert-danger">Data gagal disimpan!</div>
                                                        
                        </form>
                    </div>
                    <div class="modal-footer" align="center">
                        <img id="loadered" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" id="updateSoal" class="btn btn-primary" >Update</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal | Delete Dosen -->
        <div class="modal fade" id="delsoalMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Data</h4>
                    </div>
                    <div class="modal-body">
                        <p>Yakin hapus data?</p>
                        <!-- <input name="id" class="form-control" ></input> -->
                    </div>
                    <div class="modal-footer" align="center">
                        <img id="loaderdel" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" id="delSoal" class="btn btn-danger" >Hapus</button>
                        <input id="iddel" class="iddel" type="hidden" class="form-control" />
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal fade -->
        </div>                                                                

    </div>




	
            
</div>
<!-- /#page-wrapper -->