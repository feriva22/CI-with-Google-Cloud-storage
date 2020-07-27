<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-file bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi manajemen Dokumen</span>
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
                        <table id="document_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Aksi</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Public URL</th>
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
                        <input type="hidden" id="doc_id" name="doc_id"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="doc_name">Nama Dokumen</label>
                                  <input type="text" id="doc_name" name="doc_name" class="form-control" placeholder="Masukkan nama Dokumen">
                                  <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group ">
                                  <label for="doc_desc">Deskripsi Dokumen</label>
                                  <input type="text" id="doc_desc" name="doc_desc" class="form-control" placeholder="Masukkan Deskripsi Dokumen ">
                                  <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group field-edit">
                                  <label for="doc_public_url">Public URL</label>
                                  <input type="text" id="doc_public_url" name="doc_public_url" class="form-control " disabled>
                                  <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                  <label for="doc_status">Status</label>
                                  <br>
                                  <input type="checkbox" id="doc_status" class="switch-slider" name="doc_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Publish" data-off="Draft" data-width="90">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="doc_file">File Dokumen</label>
                                  <input type="file" accept="image/png, image/jpeg" id="doc_file" name="doc_file" class="form-control " placeholder="Masukkan File Dokumen">
                                  <small class="form-text text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="doc_file">Preview Dokumen</label>
                                    <br>
                                    <img class=" photo_preview  doc_file"  width="200" height="200"/>
                                </div>
                            </div>
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