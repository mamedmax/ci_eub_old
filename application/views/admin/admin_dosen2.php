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
                    <!--<div class="row">-->
                <div class="panel panel-default">
                        <!--<div class="panel-heading">
                            DataTables Advanced Tables
                        </div> -->
                        <!-- /.panel-heading -->
                <!--<div class="col-lg-12">-->
                                

                                <div class="panel-body">
                            
                                    
                                    <div class="panel-body">
                                        <div class="dataTable_wrapper">
                                            <table class="table table-striped table-bordered table-hover" id="dataTables-dosen">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Dosen</th>
                                                        <th>Nama Dosen</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                        if (empty($hasil))
                                        {
                                            echo "Tidak ada data dosen";
                                        } else 

                                        {
                                    
                                                        //$no = 1;
                                                        foreach ($hasil as $data):
                                                    ?>
                                                    <tr >
                                                        <td><?php echo $data->id_dosen; ?></td>
                                                        <td><a href="#" ><?php echo $data->nama_dosen; ?></a></td>
                                                        <td><a href="<?php echo base_url()?>admin/delDosen/<?php echo $data->id_dosen;?>">Hapus</a></td>                                            
                                                    </tr>
                                                    <?php
                                                    //$no++;
                                                    endforeach;
                                                ?>
                                                </tbody>
                                                
                                            </table>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <!-- /.table-responsive -->
                                        </div>
                                    </div>
                                    <!-- /.panel-body -->

                                
                                
                        
                        </div>
                        <!-- /.panel-body -->

                        <!-- Button trigger modal -->
                            <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                Launch Demo Modal
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                            <input name="id" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nama Dosen</label>
                                                            <input name="nama" class="form-control" placeholder="">
                                                        </div>
                                                        <!--<button name="simpan" type="submit" class="btn btn-default">Simpan</button>
                                                        <button name="reset" type="reset" class="btn btn-default">Reset</button>
                                                            -->
                                                    </form>
                                            

                                        </div>
                                        <div class="modal-footer" align="center">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" name="simpan" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                    
                        
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            
            </div>
            <!-- /.row -->


</div>
<!-- /#page-wrapper -->

