     <!-- mads script-->
    <script>
        $(document).ready(function() {
            $('#dataTables-dosen').DataTable({
                responsive: true

            });
        });

        
        $(document).ready(function(){ 
                $("#loader").hide();
                $("#loader2").hide();
                $("#loaders").hide();
                $(".alert").hide();
                //$("#gagal").hide();
                //$("#sakses").hide();
                                
                $("[name=simpanDsn]").click(function(){
                    var id = $("[name=idDsn]").val();
                    var nama = $("[name=namaDsn]").val();
                    
                    if(id == "" || nama == ""){
                        $("#kosong").fadeIn().delay(1650).fadeOut();
                    } else {

                        $.ajax({
                            url:"<?php print base_url();?>admin/addDosen",
                            type:"POST",
                            data:"id="+id+"&nama="+nama,
                            beforeSend:function(){
                                $("#loader").show();
                            },
                            success:function(){
                                //console.log(data);
                                $("#loader").hide();
                                $("#kosong").hide();
                                $("#success").fadeIn().delay(1650).fadeOut();
                                $("#addDosen")[0].reset();
                                //initDataTable();
                            },
                            error:function(){
                                $("#danger").fadeIn().delay(1650).fadeOut();
                            }
                        });
                    }

                });
                $("[name=selesai], #close").click(function() {
                    //window.location.href = window.location.href;
                    location.reload(true);
                });
            
            //$('.label.label-warning').on('click', function (e) {
            

            

            $("[name=deldetMtk]").click(function(){
                $("#loaderTb").show();
                //$(".alert").hide();
                //var stok = $("#liststokbuku tr").length;
                //var id = this.id.split("--"); 
                var ids = $("#ids").val();    
                var kls = $(e.relatedTarget).data('kls');
                var mtk = $(e.relatedTarget).data('mtk');                                  
                                        
                var conf = confirm("Hapus data?");
                if (conf == false ){
                    return false;
                }else{        }
                
                //var iddos = $("#id_dosen").val();
                //var nama = $("#nama_dosen").val();

                

                alert(ids+"_"+kls+"_"+mtk);
                //$("#detail tr").remove();
                //$("#id_dosen").val(id);
                /*
                if (ids=="" || iddos=="" ||nama=="") {
                    $("#kosongUp").fadeIn().delay(1600).fadeOut();
                    $("#loader").hide();
                } else {*/
                    $.ajax({
                        url:"<?php echo base_url();?>admin/delmtkDosen",
                        type:"POST",
                        data:"ids="+ids+"&kls="+kls+"&mtk="+mtk,
                        typeData:"json",
                        //contentype: 'application/json; charset=utf-8',
                        beforeSend:function(data){
                            $("#loaderTb").show();
                            alert("dodol");
                            console.log(data);
                        },
                        success:function(data){
                            console.log(data);
                            $("#loaderTb").hide();
                            //$("#successDel").fadeIn().delay(1600).fadeOut();
                            detailDos(ids);
                        },
                        error:function(data){
                            $("#gagalUp").fadeIn().delay(2000).fadeOut();
                            //alert(data);
                        }
                    });
                    //}
            });
                           
                
            
            //$("#detDos").click(function(){
            $('#detDos').on('show.bs.modal', function(e) {
                $("#loaderTb").hide();
                $(".alert").hide();
                //var id = $("#iddos").attr("data-parm");

                var id = $(e.relatedTarget).data('parm');
                //alert(id);
                loadDosen(id);
                loadKl();
                detailDos(id);
                //alert("Emang iye.....");
                $('.label.label-warning').click(function(){
                //e.preventDefault();
                //var id = $(this).data('id');

                //$("#delMtk").click(function(){

                alert("bisa dongmmmmm...");
            });
                 

            });

            function detailDos(id){
                $("#detail tr").remove();

                $.ajax({
                    url:"<?php echo base_url();?>admin/detailDosen",
                    type:"POST",
                    data:"id="+id,
                    typeData:"json",
                    //contentype: 'application/json; charset=utf-8',
                    beforeSend:function(){
                        //$("#loader").show();
                        $("#loaderTb").show();
                        //alert("dodol");
                    },
                    success:function(myjson){
                        //$("#id_dosen").val(id);
                        var html = "";
                        var j = 0;
                        console.log(myjson);
                        //$("#detail tr").remove(); 
                            //var json = JSON.stringify(text);
                        $.each(JSON.parse(myjson), function(key, val){
                            if ( j == 0 ){
                                /*$("#nama_dosen").val(val.nama_dosen);
                                $("#id_dosen").val(val.id_dosen);
                                $("#ids").val(val.id_dosen);*/
                            }

                            html += "<tr id='"+val.id_kls+"' ><td>"+val.id_kls+"</td><td><a href='#' id='deldetMtk' >"+val.matakuliah+"</a></td>";
                            html += "<td><span idm='"+val.id_kls+"_"+val.matakuliah+"' class='label label-warning' name='deletMtk' style='cursor:pointer;margin-top:18px'><i class='glyphicon glyphicon-trash'></i></span>";
                            //html += "<td><button data-parm='"+val.id_kls+"' id='dldetMtk' >delet</button>";
                            //html += "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>";
                            html += "</td>";
                            html += "</tr>";

                            j = j + 1;
                        });
                        
                        $("#deldetMtk").click(function(){
                             alert("ayo dongss...");
                        });



                        

                        
                        
                       

                        $("#detail").append(html);
                        //$("#loader").hide();
                        $("#loaderTb").hide();
                    
                    },
                    error:function(myJson){
                        $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                        //$("#loader").hide();
                        $("#loaderTb").hide();
                    }
                });
            }

            function loadKl()
            {

                $.ajax({
                            url:'<?php echo base_url();?>admin/getKls',
                            type: "POST",
                            typeData:"json",
                            beforeSend:function(){
                                $("#loader").show();
                            },              
                            success: function(myjson){  
                                var select  = $("#klsList");
                                select.empty();
                                select.append("<option value='' selected >-- Pilih --</option>");
                                            
                                console.log("edit "+myjson);
                                            
                                $.each(JSON.parse(myjson), function(k, v) {                         
                                   
                                        select.append("<option value='"+v.id_kls+"'><strong>"+v.kelas+"</strong></option>");                      
                                }); 
                                            
                                $("#loader").hide();
                                            
                                console.log($("#klsList").val());
                                                                        
                            },
                            error: function(){
                                $("#loader").hide();
                                alert("Data kelas tak berhasil di tampilkan");                    
                            }

                        }); 

            }

            function loadDosen(id){
                //$("#detail tr").remove();

                $.ajax({
                    url:"<?php echo base_url();?>admin/getDosen",
                    type:"POST",
                    data:"id="+id,
                    typeData:"json",
                    //contentype: 'application/json; charset=utf-8',
                    beforeSend:function(){
                        $("#loader").show();
                        //$("#loaderTb").show();
                        //alert("dodol");
                    },
                    success:function(myjson){
                        $("#id_dosen").val(id);
                        //var html = "";
                        //var j = 0;
                        console.log(myjson);
                        //$("#detail tr").remove(); 
                            //var json = JSON.stringify(text);
                        $.each(JSON.parse(myjson), function(key, val){
                            //if ( j == 0 ){
                                $("#nama_dosen").val(val.nama_dosen);
                                //$("#id_dosen").val(val.id_dosen);
                                $("#ids").val(val.id_dosen);
                            
                        });
                    },
                    error:function(myJson){
                        $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                        $("#loader").hide();
                        //$("#loaderTb").hide();
                    }
                });
                        

            }

            $("#addDetail").click(function() {
                var iddos = $("#id_dosen").val();
                var idkls = $("#klsList").val();
                var mtk = $("#matakuliah").val();

                //alert(iddos+"_"+idkls+"_"+mtk);
                
                if(idkls == "" || mtk == ""){
                    $("#kosong1").fadeIn().delay(1650).fadeOut();
                    //alert("kosong");
                } else {

                    $.ajax({
                            url:"<?php echo base_url();?>admin/addDetdos",
                            type:"POST",
                            data:"iddos="+iddos+"&idkls="+idkls+"&mtk="+mtk,
                            beforeSend:function(){
                                $("#loaderTb").show();
                            },
                            success:function(){
                                //console.log(data);
                                $("#loaderTb").hide();
                                //$("#kosong").hide();
                                $("#success1").fadeIn().delay(1650).fadeOut();
                                //$("#addDet")[0].reset();
                                detailDos(iddos);
                                $("#matakuliah").val("");
                            },
                            error:function(){
                                $("#danger").fadeIn().delay(1650).fadeOut();
                                $("#loaderTb").hide();
                            }
                    });
                }
                

            });

            $('#deldosenMdl').on('show.bs.modal', function(e) {

                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');

                //populate the textbox
                //$(e.currentTarget).find('label[name="id"]').val(id);

                //var id = this.id;                       
                //var idtr = id.split(' ').join('_');
                            
                $(".modal-body").html("Yakin akan menghapus <b>"+id+"</b>?");
                $(".iddel").val(id);
                //$(".idtr").html(idtr);
                $("#loaderdel").hide();
            });

            $("[name=delDos]").click(function(){
                var id = $(".iddel").val();
                
                $.ajax({
                    url:"<?php echo base_url();?>admin/delDosen",
                    type: "POST",
                    data: "id="+id,                    
                    beforeSend:function(){
                        $("#loader").show();
                    },
                    success: function(id){
                        $("#loader").hide();
                        $('#deldosenMdl').modal('hide');
                        location.reload(true);
                    },
                    error: function(){
                        $("#loader").hide();  
                        $("#danger-add.alert.alert-danger").show();
                        setTimeout(function(){$("#danger-add.alert.alert-danger").slideUp();},3000);                        
                    }
                });
            });
                

            $('#updateDos').click(function(){
                $("#loader").show();

                var ids = $("#ids").val();
                var iddos = $("#id_dosen").val();
                var nama = $("#nama_dosen").val();
                
                if (ids=="" || iddos=="" ||nama=="") {
                    $("#kosongUp").fadeIn().delay(1600).fadeOut();
                    $("#loader").hide();
                } else {
                    $.ajax({
                        url:"<?php echo base_url();?>admin/updateDosen",
                        type:"POST",
                        data:"ids="+ids+"&iddos="+iddos+"&nama="+nama,
                        typeData:"json",
                        //contentype: 'application/json; charset=utf-8',
                        beforeSend:function(data){
                            $("#loader").show();
                            //alert("dodol");
                        },
                        success:function(data){
                            
                            $("#loader").hide();
                            $("#successUp").fadeIn().delay(1600).fadeOut();
                            detailDos(iddos);
                        },
                        error:function(data){
                            $("#gagalUp").fadeIn().delay(2000).fadeOut();
                            //alert(data);
                        }
                    });
                }
            });

            


        });
//});



    </script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Dosen</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
	
    <div class="row">
        <div class="col-lg-12">
            <!-- Button trigger modal -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#dosenMdl">
                    Tambah
                </button>
            <!--<div class="panel panel-default">-->

                <div class="panel-body">
                    <?php
                        if (empty($hasil))
                        {
                            echo "Tidak ada data dosen";
                        } else {

                    ?>
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover " id="dataTables-dosen">
                                <thead>
                                    <tr>
                                        <th width="25%">Kode Dosen</th>
                                        <th>Nama Dosen</th>
                                        <th width="10%" >&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //$no = 1;
                                        foreach($hasil as $data):
                                    ?>
                                    <tr>
                                        <td><?php echo $data->id_dosen; ?></td>
                                        <td><a href="#detDos" data-toggle="modal" data-target="#detDos" data-parm="<?php echo $data->id_dosen;?>" id="iddos"><?php echo $data->nama_dosen; ?></a></td>
                                        <!-- <td><a href="<?php echo base_url()?>admin/delDosen/<?php echo $data->id_dosen;?>">Hapus</a></td> -->                                    
                                        <td>
                                            <!--<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#updateDos" data-parm="<?php echo $data->id_dosen;?>" >
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>-->
                                            <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deldosenMdl" data-id="<?php echo $data->id_dosen;?>" >
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </td>                                            
                                    </tr>
                                    <?php
                                        //$no++;
                                        endforeach;
                                    ?>
                                </tbody>
                                <?php } ?>   
                            </table>
                            <!-- /.dataTables-dosen -->
                        </div>
                        <!-- /.dataTable_wrapper -->
                    </div>
                    <!-- /.panel-body -->

                    <!-- Modal | Tambah Dosen -->
                    <div class="modal fade" id="dosenMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Tambah Dosen</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="addDosen" role="form">
                                        <div class="form-group">
                                            <label>Kode Dosen</label>
                                            <input name="idDsn" class="form-control" required="required" >
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Dosen</label>
                                            <input name="namaDsn" class="form-control" placeholder="" required="required" >
                                        </div>
                                            <!--<button name="simpan" type="submit" class="btn btn-default">Simpan</button>
                                            <button name="reset" type="reset" class="btn btn-default">Reset</button>
                                            -->
                                            
                                            <div id="success" class="alert alert-success">Data berhasil disimpan</div>
                                            <div id="kosong" class="alert alert-danger">Form Isian Kosong</div>
                                                        
                                    </form>
                                </div>
                                <div class="modal-footer" align="center">
                                    <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                                    <button type="button" name="simpanDsn" class="btn btn-primary" >Simpan</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal fade -->
                    </div>

                    <!-- Modal | Detail Dosen -->
                    <div class="modal fade" id="detDos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="detDosLabel">Detail Dosen</h4>
                                        <img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                                </div>
                                <div class="modal-body">
                                    <div class="panel-body">
                                        <div id="successUp" class="alert alert-success">Data berhasil ter-update</div>
                                        <div id="kosongUp" class="alert alert-danger">Form Isian Kosong</div>
                                        <div id="gagalUp" class="alert alert-danger">Form Isian Kosong</div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Kode Dosen</label>
                                                <input id="id_dosen" name="id_dosen" class="form-control" >
                                                <input id="ids" name="ids" type="hidden">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:10px">
                                            <div class="form-group col-md-9">
                                                <label>Nama Dosen</label>
                                                <input id="nama_dosen" name="nama_dosen" class="form-control" >
                                                
                                            </div>
                                            <div class="form-group col-md-3" style="margin-top:25px">
                                                <button id="updateDos" class="btn btn-primary" >Update</button>
                                            </div>
                                        </div>
                                        <div class="row">&nbsp;</div>
                                        <div class="row"> 
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <select class="form-control" id="klsList" >
                                                      <option>1</option>
                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                  <input id="matakuliah" type="text" class="form-control" placeholder="Mata Kuliah">
                                                  <span class="input-group-btn">
                                                    <button id="addDetail" class="btn btn-default" type="button">Tambah</button>
                                                  </span>
                                                </div><!-- /input-group -->
                                              </div><!-- /.col-lg-6 -->
                                            <div id="gagals" class="alert alert-danger">Proses gagal...</div>
                                            <div id="success2" class="alert alert-success">Data berhasil disimpan</div>
                                            <div id="kosong2" class="alert alert-danger">Form Isian Kosong</div>
                                                <!--<button id="deldetMtk" class="label label-warning" >Testo</button>-->
                                        </div>
                                        <br/>
                                            <div class="row">
                                                <img id="loaderTb" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                                                <div id="success1" class="alert alert-success">Data berhasil disimpan</div>
                                                <div id="kosong1" class="alert alert-danger">Form Isian Kosong</div>

                                                    <table class="table table-hover table-responsive">
                                                        <thead> 
                                                            <th width="16%">Kelas</th>
                                                            <th width="50%">Mata Kuliah</th>
                                                            <th width="6%" >&nbsp;</th>
                                                        </thead>
                                                    </table>
                                                
                                                <div id="list" style="height:158px; overflow-y:scroll" class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <tbody id="detail">
                                                            <!--<tr>
                                                                <td><p>Data tidak ditemukan</p></td>
                                                            </tr-->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>
                                <!--<div class="modal-footer" align="center">
                                    <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                                    
                                </div>-->
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal fade -->
                    </div>

                    <!-- Modal | Delete Dosen -->
                    <div class="modal fade" id="deldosenMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    <button type="button" name="delDos" class="btn btn-danger" >Hapus</button>
                                    <input name="iddel" class="iddel" type="hidden" class="form-control" />
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal fade -->
                    </div>

                    <!-- Modal | Update Dosen -->
                    <div class="modal fade" id="updateDos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="detDosLabel">Update Dosen</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="panel-body">
                                         
                                            <div class="form-group">
                                                <label>Kode Dosen</label>
                                                <input id="id_dosen" name="id_dosen" class="form-control" readonly="">
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Dosen</label>
                                                <input id="nama_dosen" name="nama_dosen" class="form-control" >
                                            </div>
                                    </div>        
                                </div>
                                <div class="modal-footer" align="center">
                                    <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                                    <button type="button" name="simpan" class="btn btn-primary" >Simpan</button>
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal fade -->
                    </div>


                </div>
                <!-- /.panel-body -->
            <!--</div>-->
            <!-- /.panel panel-default -->

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->        
</div>
<!-- /#page-wrapper -->
