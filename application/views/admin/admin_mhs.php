<script>
    

    $(document).ready(function() {
        $('#loader').hide();
        $("#loaderdel").hide();
        $('.alert').hide();
        
        var tbmhs = $('#tblmhs').DataTable({
            responsive: true,
            "ajax": "<?php print base_url();?>admin/listmhs",
            "sAjaxDataProp": "",
            "aoColumns": [
                { "mData": "nim" },
                { "mData": "nama" },
                { "mData": "jekel" },
                { "mData": "angkatan" },
                { "mData": "id_kls" },
                { "mData": "status_" },
                { "mData": "" }
            ],
            "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#delmhsMdl' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>"
                //"defaultContent": "<button class='btn btn-danger btn-xs' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></button>"
                
                }, 
                { "width": "16%", "targets": 0 },
                { "width": "10%", "targets": 3 },
                { "width": "10%", "targets": 4 }

            ],
            "createdRow": function ( row, data, index ) {
                if ( data[5] == 1 ) {
                    $('td', row).eq(5).val("Aktif");
                } else {

                    $('td', row).eq(5).val("Tdk Aktif");
                }
            }

        });

        $('#addmhsMdl').on('show.bs.modal', function(e) {
            loadK();


        });
        var tbl = $('#tblmhs').DataTable();
        $('#tblmhs tbody').on( 'click', 'button', function () {
            var data = tbl.row($(this).parents('tr')).data();
            id = data['nim'];

            $('#delmhsMdl').on('show.bs.modal', function(e) 
            {
                $("#loaderdel").hide();
                $(".modal-body").html("Yakin akan menghapus <b>"+id+"</b>?");
                $("#iddel").val(id);
                            
            });

            $("#delMhs").click(function(){
                var id = $("#iddel").val();                     
                
                $.ajax({
                    url:"<?php echo base_url();?>admin/delMhs",
                    type: "POST",
                    data: "id="+id,                    
                    beforeSend:function(){
                        $("#loaderdel").show();
                    },
                    success: function(id){
                        $("#loaderdel").hide();
                        $('#delmhsMdl').modal('hide');
                        tbmhs.ajax.reload();
                    },
                    error: function(){
                        $("#loaderdel").hide();  
                        $("#danger-add.alert.alert-danger").show();
                        setTimeout(function(){$("#danger-add.alert.alert-danger").slideUp();},3000);                        
                    }
                });
            });

        });




        function loadK()
        {
            $.ajax({
                url:'<?php echo base_url();?>admin/getKls',
                type: "POST",
                typeData:"json",
                beforeSend:function(){
                    $("#loader").show();
                },              
                success: function(myjson){  //data adalah hasil respon atau kirim data dari 
                    var select  = $("#id_kls");
                    select.empty();
                    select.append("<option value='' selected >-- Pilih --</option>");
                    console.log("edit "+myjson);
                    
                    $.each(JSON.parse(myjson), function(k, v) {                         
                                                
                        select.append("<option value='"+v.id_kls+"'><strong>"+v.kelas+"</strong></option>");                
                                             
                    }); 
                    $("#loader").hide();
                                            
                    console.log($("#id_kls").val());

                },
                error: function(){
                    $("#loader").hide();
                    alert("Data kelas tak berhasil ditampilkan");                    
                }

            }); 

        }

        $("#simpanMhs").click(function()
        {
            var nim = $("#nim").val();
            var nama = $("#nama").val();
            var kls = $("#id_kls").val();
            var angk = $("#angk").val();
            var jk = $("#jekel").val();
            var st = $("#status_").val();

                    
            if(nim == "" || nama == "" || kls == "" || angk == "" || jk == "" || st == "" ){
                $("#kosong").fadeIn().delay(1650).fadeOut();
            } else {
                
                $.ajax({
                    url:"<?php print base_url();?>admin/addMhs",
                    type:"POST",
                    data:"nim="+nim+"&nama="+nama+"&kls="+kls+"&angk="+angk+"&jk="+jk+"&st="+st,
                    beforeSend:function(){
                        $("#loader").show();
                        alert("nim="+nim+"&nama="+nama+"&kls="+kls+"&angk="+angk+"&jk="+jk+"&st="+st);
                    },
                    success:function(data){
                        console.log(data);
                        $("#loader").hide();
                        $("#kosong").hide();
                        $("#success").fadeIn().delay(1650).fadeOut();
                        $("#addMhs")[0].reset();
                        tbmhs.ajax.reload();
                    },
                    error:function(){
                        $("#gagal").fadeIn().delay(1650).fadeOut();
                    }
                });
            }

        });
            
    });



</script>

<div id="page-wrapper">
    <div class="col-lg-12">
        <h3 class="page-header">Data Mahasiswa</h3>
    </div>
    <!-- /.col-lg-12 -->
	<div class="row">
        <div class="col-lg-12 ">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addmhsMdl">
                Tambah Mahasiswa
            </button>
        </div>
    </div>
    <!-- /.col-lg-12 -->
    <div class="row">
        <!-- Modal | Tambah Mhs -->
        <div class="modal fade" id="addmhsMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Tambah Mahasiswa</h4>
                            <img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                    </div>
                    <div class="modal-body">
                        <div class="panel-body" style="" >
                            <div id="success" class="alert alert-success">Data berhasil disimpan</div>
                            <div id="kosong" class="alert alert-danger">Form Isian Kosong</div>
                            <div id="gagal" class="alert alert-danger">Form Isian Kosong</div>
                        <form id="addMhs" role="form" >
                            <div class="form-group col-md-6">
                                <label>Kelas</label>
                                <select class="form-control" id="id_kls" >
                                      <option value=""> --- Pilih --- </option>
                                      
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tahun Angkatan</label>
                                <input name="angkatan" id="angk" class="form-control" placeholder="" required="required" >
                            </div>
                            <div class="form-group col-md-5">
                                <label>NIM</label>
                                <input name="nim" id="nim" class="form-control" required="required" >
                            </div>
                            <div class="form-group col-md-8">
                                <label>Nama Mahasiswa</label>
                                <input name="nama" id="nama" class="form-control" placeholder="" required="required" >
                            </div>
                            <div class="form-group col-md-4">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" id="jekel" >
                                      <option value="" selected> --- Pilih --- </option>
                                      <option value="L" >Laki-laki</option>
                                      <option value="P" >Perempuan</option>
                                </select>
                            </div>                           
                            <div class="form-group col-md-5">
                                <label>Status </label>
                                <select class="form-control" id="status_" >
                                      <option value="" selected> --- Pilih --- </option>
                                      <option value="1" >Aktif</option>
                                      <option value="0" >Non-aktif</option>
                                </select>
                            </div>
                            
                                                        
                        </form>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button name="reset" type="reset" class="btn btn-default">Reset</button>
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" id="simpanMhs" class="btn btn-primary" >Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal | Edit Mhs -->
        <div class="modal fade" id="editmhsMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Edit Data Mahasiswa</h4>
                            <img id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                    </div>
                    <div class="modal-body">
                        <div class="panel-body" style="" >
                            <div id="success" class="alert alert-success">Data berhasil disimpan</div>
                            <div id="kosong" class="alert alert-danger">Form Isian Kosong</div>
                            <div id="gagal" class="alert alert-danger">Form Isian Kosong</div>
                        <form id="editMhs" role="form" >
                            <div class="form-group col-md-6">
                                <label>Kelas</label>
                                <select class="form-control" id="id_kls" >
                                    <option value=""> --- Pilih --- </option>
                                      
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tahun Angkatan</label>
                                <input name="angkatan" id="angk" class="form-control" placeholder="" required="required" >
                            </div>
                            <div class="form-group col-md-5">
                                <label>NIM</label>
                                <input name="nim" id="nim" class="form-control" required="required" >
                            </div>
                            <div class="form-group col-md-8">
                                <label>Nama Mahasiswa</label>
                                <input name="nama" id="nama" class="form-control" placeholder="" required="required" >
                            </div>
                            <div class="form-group col-md-4">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" id="jekel" >
                                    <option value="" selected> --- Pilih --- </option>
                                    <option value="L" >Laki-laki</option>
                                    <option value="P" >Perempuan</option>
                                </select>
                            </div>                           
                            <div class="form-group col-md-5">
                                <label>Status </label>
                                <select class="form-control" id="status_" >
                                    <option value="" selected> --- Pilih --- </option>
                                    <option value="1" >Aktif</option>
                                    <option value="0" >Non-aktif</option>
                                </select>
                            </div>
                            
                                                        
                        </form>
                        </div>
                    </div>
                    <div class="modal-footer" align="center">
                        <button name="reset" type="reset" class="btn btn-default">Reset</button>
                        <button type="button" name="selesai" class="btn btn-default" data-dismiss="modal">Selesai</button>
                        <button type="button" id="updateMhs" class="btn btn-primary" >Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal | Delete Dosen -->
        <div class="modal fade" id="delmhsMdl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Data</h4>
                    </div>
                    <div class="modal-body">
                        <p>Yakin hapus data???</p>
                        <!-- <input name="id" class="form-control" ></input> -->
                    </div>
                    <div class="modal-footer" align="center">
                                    <img id="loaderdel" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                                    <button type="button" id="selesai" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <button type="button" id="delMhs" class="btn btn-danger" >Hapus</button>
                                    <input name="iddel" id="iddel" type="hidden" class="form-control" />
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal fade -->
        </div>

    </div>

    <div class="row">
		<div class="col-lg-12">
			
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover " id="tblmhs">
                        <thead>
                            <tr>
                                <th width="25%">NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Kelamin</th>
                                <th>Angkatan</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                                        
                            </tr>
                        </thead>
                        <tbody>
                                    
                        </tbody>
                    </table>
                    <!-- /.dataTables-dosen -->
                </div>
                <!-- /.dataTable_wrapper -->
            </div>
            <!-- /.panel-body -->
            
        </div>
    </div>
            
</div>
<!-- /#page-wrapper -->