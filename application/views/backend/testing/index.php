<?php echo $form;?>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

	function parsexml(data){
		xmlDoc = $.parseXML(data);
		var data = {
			'location': $(xmlDoc).find("Location").text(),
			'bucket': $(xmlDoc).find("Bucket").text(),
			'key': $(xmlDoc).find("Key").text(),
			'etag': $(xmlDoc).find("ETag").text()
		}
		return data;
	}

	function validateFile(data){
		$.ajax({
			url: '<?php echo base_url();?>backend/testing/confirmUploaded',
			data: data,
			type: 'post',
			dataType: 'json',
			success: (resp)=>{
				return resp;
			},
			error: (jxhr)=>{
				console.log(jxhr);
			}
		})

	}

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
                console.log(parsexml(resp));
				validateFile(parsexml(resp));
            },
            error: (jxhr)=>{
				console.log(jxhr);
			}
        })
});

</script>
