<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-box bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi manajemen module</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url();?>backend/dashboard"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title;?>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="slide-content col-md-12" id="table_wrapper">
                <div class="card">
                    <div class="card-header"><h3><?php echo $page_title;?></h3></div>
                    <div class="card-body">
                        <div class="float-sm-right">
                            <a class="btn btn-danger btn-sm delete_role" id="multidel_act" >
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                            <a class="btn btn-success btn-sm add_role" id="add_act" >
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                        </div>
                        <br>
                        <br>
                        <div class="table-responsive">
                        <table id="module_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Aksi</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Relative URL</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="detail_wrapper" style="display: none;">
                <div class="card">
                    <div class="card-header" id="detail_title"><h3></h3></div>
                    <div class="card-body">
                    <form id="form_detail" data-mode="">
                        <input type="hidden" id="mdl_id" name="mdl_id"/>
                          <div class="form-group">
                            <label for="mdl_name">Nama Module</label>
                            <input type="text" id="mdl_name" name="mdl_name" class="form-control col-6" placeholder="Masukkan nama module">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group ">
                            <label for="mdl_desc">Deskripsi Module</label>
                            <input type="text" id="mdl_desc" name="mdl_desc" class="form-control col-6" placeholder="Masukkan Deskripsi Module ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group field-edit">
                            <label for="mdl_relativeurl">Relative URL</label>
                            <input type="text" id="mdl_relativeurl" name="mdl_relativeurl" class="form-control col-6" disabled>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mdl_status">Status</label>
                            <br>
                            <input type="checkbox" id="mdl_status" class="switch-slider" name="mdl_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Publish" data-off="Draft" data-width="90">
                          </div>
                          <button type="submit" class="btn btn-primary float-right">Submit</button>
                          <button type="button" class="btn btn-light float-right mr-2" onclick="hide_detail()">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>