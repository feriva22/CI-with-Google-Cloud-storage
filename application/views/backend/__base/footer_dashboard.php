                <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © 2020 <a href="mailto:fericodeva69@gmail.com" target="_top" >Global Solusi Informatika</a>.</span>
                    </div>
                </footer>  
            </div>
        </div>
        

        <script>
            var base_url = '<?php echo base_url();?>';
            var csrf_name = '<?php echo $this->security->get_csrf_token_name();?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap4-toggle/bootstrap4-toggle.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/moment/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/select2/js/select2.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/dist/js/theme.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-toast/js/jquery.toast.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-confirm/jquery-confirm.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/js.cookie.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/fabricjs/fabric.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap-tokenfield/bootstrap-tokenfield.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/modernizr-2.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/printThis/printThis.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datedropper/datedropper.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/Print.js/print.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/loadingoverlay/loadingoverlay.min.js"></script>


        
        <?php if(!empty($plugin)):?>
            <!-- add js plugin -->
            <?php foreach($plugin as $js):?>
                <script type="text/javascript" src="<?php echo base_url().''.$js;?>"></script>
            <?php endforeach;?>
        <?php endif;?>

        <script src="<?php echo base_url();?>assets/dist/js/site.js"></script>
        <script src="<?php echo base_url();?>assets/dist/js/masterTemplate.js"></script>
        <?php if(!empty($custom_js)):?>
            <!-- user defined js -->
            <?php
            $this->view($custom_js['src'],$custom_js['data']); 
            ?>
        <?php endif;?>
        
    </body>
</html>
