<?php echo $form;?>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

var urlUpload = '<?php echo $url;?>';

$('#formUpload').submit(function(e){
	e.preventDefault();
	var formData = new FormData(this);
	// Display the key/value pairs
	for(var pair of formData.entries()) {
   		console.log(pair[0]+ ', '+ pair[1]); 
	}


	$.ajax({
            url: urlUpload,
            data: formData,
			type: 'post',
            mimeType: 'multipart/form-data',
            contentType: false,
            cache: false,
			processData: false,
            success: (resp)=>{
                console.log(resp);
            },
            error: (jxhr)=>{
				console.log(jxhr);
			},
			statusCode: {
				303: function(){
					alert('uploaded');
				}
			}
        })
});

</script>