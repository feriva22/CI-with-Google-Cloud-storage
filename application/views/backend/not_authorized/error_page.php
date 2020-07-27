<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-alert-circle bg-red"></i>
                        <div class="d-inline">
                            <h5><?php echo $error['title'];?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3><?php echo $error['sub_title'];?></h3></div>
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?php echo $error['description'];?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>