<script>
    $(document).ready(function(){
        $("#loader").show();
        listdosen();



        function listdosen(){
            var id = "<?php echo $this->session->userdata('id_kls'); ?>";
                
            $.ajax({
                url:"<?php print base_url();?>mhs/listdosen",
                type:"POST",
                data:"id="+id,
                typeData:"json",
                //contentype: 'application/json; charset=utf-8',
                beforeSend:function(){
                    $("#loader").show();
                    //alert("eaaa...");
                },
                success:function(text){
                    var html = "";
                    console.log(text);
                    $("#data tr").remove(); 
                    //var json = JSON.stringify(text);
                    $.each(JSON.parse(text), function(k, v){
                                html += "<tr id='"+v.id_dosen+"'><td>"+v.id_dosen+"</td>";
                                html += "<td><a class='cekst' href='#' data-id="+v.id_dosen+" data-parm="+v.stat+" >"+v.nama_dosen+"</a></td><td>"+v.matakuliah+"</td>";
                                html += "<td>"+v.stat+"</td>";
                                //html += "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>";
                                //html += "</button></td>";
                                html += "</tr>";
                    
                    });
                    
                    $("#data").append(html);
                    $("#loader").hide();


                    $('.cekst').click(function(){
                        //var parm = $(this).data('parm');
                        //var id = $(this).data('id');

                        var parm = this.getAttribute('data-parm')
                        var id = this.getAttribute('data-id')
                        

                        if(parm == "Sudah")
                        {
                            alert("sudah diisi");

                        }else{

                            window.location.replace("<?php echo base_url();?>mhs/isieub/"+id+"")
                        }
                   });
                   
                },
                error:function(myJson){
                            $("#gagal").fadeIn().delay(800).fadeOut();
                        }
                    });
            }

            //function cekStat(){
                


    });
</script>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">EUB Dosen</h3>
        </div>
    </div>
    <!-- /.col-lg-12 -->

    <div class="panel body">
    	<div class="row">
                    

        </div>
        <!-- /.row -->
      <div class="row">
                <div class="col-lg-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Daftar Dosen
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="listdosen" >
                                    <thead>
                                        <tr>
                                            <th width="10%"># Dosen</th>
                                            <th>Nama Dosen</th>
                                            <th>Mata Kuliah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="data">
                                        
                                    </tbody>
                                    <img align="center" id="loader" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                
                         
            </div>
            <!-- /.row -->
        </div>
</div>
<!-- /#page-wrapper -->