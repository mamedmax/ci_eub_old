<script>
    

    $(document).ready(function() {
        
        $('#tblmhs').DataTable({
            "responsive": true,
            //"processing": true,
            //"serverSide": true,
            //"ajax": "<?php echo base_url(); ?>admin/dosenDt",
            //"paging":   true,
            //"ordering": true,
            
            /*"columns":[
                {"data":"id_dosen"},
                {"data":"nama_dosen"}

            ]*/

        });


    });



</script>

<div id="page-wrapper">

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
                                        
                                    </tr>
                                </thead>
                                <tbody id="datamhs">
                                    
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