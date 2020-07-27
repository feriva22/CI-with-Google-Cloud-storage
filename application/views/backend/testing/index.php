<form action="<?php echo base_url();?>backend/testing/upload" method="post" enctype="multipart/form-data">
<input type="file" name="file" id=""><br>
<br><br>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">


<button type="submit"> Uplaod</button>
</form>