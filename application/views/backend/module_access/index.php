<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-fw fa-lock bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi manajemen Module Access</span>
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
                        <table id="module_access_table" class="table ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Aksi</th>
                                    <th>Module</th>
                                    <th>Staff Group</th>
                                    <th>Create</th>
                                    <th>Read</th>
                                    <th>Update</th>
                                    <th>Delete</th>
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
                        <input type="hidden" id="mda_id" name="mda_id"/>
                          <div class="form-group col-6">
                            <label for="mda_module">Module</label>
                            <select class="form-control" name="mda_module" id="mda_module">
                              <option value="">Silahkan pilih</option>
                              <?php foreach($data_module as $row){ ?>
                                  <option value="<?php echo $row->mdl_id; ?>"><?php echo $row->mdl_name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>
                          <div class="form-group col-6">
                            <label for="mda_staffgroup">Staff Group</label>
                            <select class="form-control" name="mda_staffgroup" id="mda_staffgroup">
                              <option value="">Silahkan pilih</option>
                              <?php foreach($data_staffgroup as $row){ ?>
                                  <option value="<?php echo $row->sdg_id; ?>"><?php echo $row->sdg_name; ?></option>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>
                          <!--
                          <div class="form-group col-6">
                            <label for="mdm_staffgroupacc">Staff Group Akses</label><br>
                            <select class="selectpicker form-control col-8" data-selected-text-format="count > 0" multiple data-live-search="true" id="mdm_staffgroupacc">
                              <?php foreach($data_staffgroup as $row){ ?>
                                  <optgroup label="Group <?php echo $row->sdg_name; ?>" data-id="<?php echo $row->sdg_id;?>">
                                    <option  value="create">Create</option>
                                    <option  value="read">Read</option>
                                    <option  value="update">Update</option>
                                    <option  value="delete">Delete</option>
                                  </optgroup>
                                <?php } ?>
                            </select>
                            <small class="form-text text-muted"></small>
                          </div>-->
                          <div class="form-group col-6">
                            <label for="">Hak Akses</label>
                            <div class="form-check mx-sm-2">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check_all">
                                    <span class="custom-control-label">&nbsp; All Privilege</span>
                                </label>
                            </div>
                            <div class="form-check mx-sm-2">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mda_create"  id="mda_create">
                                    <span class="custom-control-label">&nbsp; Create</span>
                                </label>
                            </div>
                            <div class="form-check mx-sm-2">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mda_read" id="mda_read">
                                    <span class="custom-control-label">&nbsp; Read</span>
                                </label>
                            </div>
                            <div class="form-check mx-sm-2">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mda_update" id="mda_update">
                                    <span class="custom-control-label">&nbsp; Update</span>
                                </label>
                            </div>
                            <div class="form-check mx-sm-2">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="mda_delete" id="mda_delete">
                                    <span class="custom-control-label">&nbsp; Delete</span>
                                </label>
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