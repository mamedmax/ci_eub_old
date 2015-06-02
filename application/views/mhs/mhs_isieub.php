    <style>
			.form-group{
					margin-left : 15px;
			}
			.radio{
					margin-left : 25px;
			}
    </style>

    <script>
        $(document).ready(function(){  
            $("#loader").hide();
            $("#loader2").hide();

            loadsoal();

            function loadsoal(){
                var c = "";
                
                    $.ajax({
                        url:"<?php print base_url();?>admin/loadSoal",
                        type:"POST",
                        data:"c="+c,
                        typeData:"json",
                        //contentype: 'application/json; charset=utf-8',
                        beforeSend:function(){
                            $("#loader").show();
                            //alert("eaaa...");
                        },
                        success:function(text){
                            var html = "";
                            console.log(text);
                            $("#formisi .row").remove(); 
                            var j = 0;
                            $.each(JSON.parse(text), function(k, v){
                                j=j+1;
                                html += "<div class='row'><div class='form-group'>";
                                html += "<label>"+v.id_soal+".&nbsp; "+v.soal+"</label>";
                                html += "<div class='radio'><label>";
                                html += "<input type='radio' name='s_"+j+"' id='s_"+j+"' value='5'>Sangat Baik</label></div>";
                                html += "<div class='radio'><label>";
                                html += "<input type='radio' name='s_"+j+"' id='s_"+j+"' value='4'>Baik</label></div>";
                                html += "<div class='radio'><label>";
                                html += "<input type='radio' name='s_"+j+"' id='s_"+j+"' value='3'>Cukup</label></div>";
                                html += "<div class='radio'><label>";
                                html += "<input type='radio' name='s_"+j+"' id='s_"+j+"' value='2'>Kurang</label></div>";
                                html += "<div class='radio'><label>";
                                html += "<input type='radio' name='s_"+j+"' id='s_"+j+"' value='1'>Sangat Kurang</label></div>";
                                html += "</div></div>";
                                
                            });
                            html += "<div class='row col-sm-offset-1'>";
                            html += "<button type='button' id='saveEubDsn' class='btn btn-primary' >Simpan</button>";
                            html += "<img align='center' id='loader2' src='<?php echo base_url(); ?>assets/images/loading.gif' >";
                            html += "</div>";                 
                                            
                        
                            $("#formisi").append(html);
                            $("#loader").hide();

                            $("#loader2").hide();


                            $("#saveEubDsn").click(function(){
                                //$('type[name="s_1"]:checked').val();

                                var jwb= [];
                                var s=[];
                                var i =0;
                                var cek = "";

                                for(i=1;i<17;i++){
                                    
                                    var s = $("#s_"+i+":checked").val();

                                    if (s !== null ){
                                        cek = s;
                                    jwb.push({
                                            id_soal: i,
                                            n: s
                                        
                                        });
                                    }
                                }

                                if ( cek == null )
                                {
                                    alert('Lengkapi Jawaban!');
                                    return false;

                                } else {

                                console.log(jwb);
                                var json = JSON.stringify(jwb);
                                console.log(json);

                                var idd = "<?php echo $id;?>";
                                var nim = "<?php echo $this->session->userdata('nim');?>";

                                $.ajax({
                                    url:"<?php echo base_url();?>mhs/isieubdosen",
                                    type:"POST",
                                    data:"jsn="+json+"&idd="+idd+"&nim="+nim,
                                    beforeSend:function(){
                                        //alert(idd+"_"+nim);
                                        //alert(json);
                                        $("#loader2").show();
                                    },
                                    success:function(text){

                                        console.log(text);

                                        $("#loader2").hide();
                                        alert("Penilaian Berhasil Disimpan!");

                                        window.location.replace("<?php echo base_url();?>mhs/eubdosen");
                                    },
                                    error:function(text){
                                        console.log(text)
                                        alert("gagal menyimpan data");
                                        $("#loader2").hide();
                                        window.location.replace("<?php echo base_url();?>mhs/eubdosen");
                                    }

                                });

                                }
                            });

                            $("[type=radio]").click(function(){
                                var painCode = $('input[name="s_1"]:checked').val();
                                //alert("The painCode for this person is " + painCode);   
                            });//end click function
                                        
                        },
                        error:function(myJson){
                            $(".alert.alert-danger").fadeIn().delay(800).fadeOut();
                        }
                    });
            }

            

            


        });

        $(document).ready(function(){
            
        });


    </script>

<div id="page-wrapper">

	<div class="row">
                
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                   Form Penilaian Dosen: <strong><?php echo $nm;?></strong>
                </div>
                <div class="panel-body" id="formisi" style="height:505px; overflow-y:scroll">
                    <span id="loader" >
                        <img align="center" src="<?php echo base_url(); ?>assets/images/loading.gif" >
                    </span>
                    <div class="row">
                    	<div class="form-group">
                            <label>Radio Buttons</label><p>Radio Buttons</p>
                            <div class="radio">
                                <label>
                                	<input type="radio" name="s_1" id="s_1" value="5">Sangat Baik
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="s_1" id="s_1" value="4">Baik
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="s_1" id="s_1" value="3">Cukup
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="s_1" id="s_1" value="2">Kurang
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="s_1" id="s_1" value="1">Sangat Kurang
                                </label>
                            </div>
                        </div>
                    </div>
                    
            </div>

        </div>

    </div>
    <!-- /.row -->
            
</div>
<!-- /#page-wrapper -->