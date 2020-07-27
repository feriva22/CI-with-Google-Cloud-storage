<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-list bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi manajemen Menu Sidebar</span>
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
                        <table id="module_menu_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Aksi</th>
                                    <th>Staff Group</th>
                                    <th>Judul</th>
                                    <th>Class</th>
                                    <th>URL</th>
                                    <th>Parent</th>
                                    <th>Group</th>
                                    <th>Order</th>
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
                        <input type="hidden" id="mdm_id" name="mdm_id"/>
                          
                          <div class="form-group">
                            <label for="mdm_title">Judul Menu</label>
                            <input type="text" id="mdm_title" name="mdm_title" class="form-control col-6" placeholder="Masukkan Judul Menu">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mdm_class">Class</label>
                            <input type="text" id="mdm_class" name="mdm_class" class="form-control col-6" placeholder="Masukkan Icon Class Menu">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mdm_staffgroup">Staff Group </label><br>
                            <select class="selectpicker form-control col-6" name="mdm_staffgroup[]" data-selected-text-format="count > 5" multiple data-live-search="true" id="mdm_staffgroup">
                              <?php foreach($data_staffgroup as $row){ ?>
                                  <option value="<?php echo $row->sdg_id; ?>"><?php echo $row->sdg_name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group ">
                            <label for="mdm_url">URL Menu</label>
                            <input type="text" id="mdm_url" name="mdm_url" class="form-control col-6" placeholder="Masukkan URL menu ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group ">
                            <label for="mdm_parent">Parent</label>
                            <select class="form-control col-6" name="mdm_parent" id="mdm_parent">
                              <option value="">Silahkan pilih</option>
                              <?php foreach($data_parent as $row){ ?>
                                  <option value="<?php echo $row->mdm_id; ?>"><?php echo $row->mdm_title; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div><div class="form-group ">
                            <label for="mdm_group">Group Menu</label>
                            <input type="text" id="mdm_group" name="mdm_group" class="form-control col-6" placeholder="Masukkan Group menu ">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group ">
                            <label for="mdm_order">Order</label>
                            <input type="text" id="mdm_order" name="mdm_order" class="form-control col-6" placeholder="Masukkan Urutan Menu">
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group">
                            <label for="mdm_status">Status</label>
                            <br>
                            <input type="checkbox" id="mdm_status" class="switch-slider" name="mdm_status" checked value="1" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Publish" data-off="Draft" data-width="90">
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