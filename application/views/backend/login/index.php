<div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100" style="background-color: #f5f5f5 !important;">
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto mx-auto">
                        <div class="authentication-form mx-auto">
                            <div class="row">
                                <div class="col-12" >
                                    <img class="mx-auto d-block" style="height: 200px; width: 300;" src="<?php echo base_url();?>assets/img/default/backend.png" alt="">
                                </div>
                            </div>
                            <p></p>
                            <h3 class="text-center">Login Sistem Backend</h3>

                            <p></p>
                            <div id="alert_notice">
                            </div>
                            
                            <form id="formLogin">
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username"  value="">
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="">
                                    <i class="ik ik-lock"></i>
                                </div>
                                <div class="sign-btn text-center" >
                                    <button type="submit" class="btn btn-theme mb-4" id="loginBtn">Masuk</button>
                                </div>
                            </form>

                            <!--
                            <div class="register">
                                <p>Don't have an account? <a href="register.html">Create an account</a></p>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>