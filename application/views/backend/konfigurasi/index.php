<div class="main-content">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-sliders bg-blue"></i>
                        <div class="d-inline">
                            <h5><?php echo $page_title;?></h5>
                            <span>Modul untuk konfigurasi </span>
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
            <div class="col-md-12" >
                <div class="card  sticky-sidebar">
                    <div class="card-header"><h3>Aplikasi</h3></div>
                    <div class="card-body">
                        <form class="sample-form" id="config-form">
                            <div class="form-group row">
                                <label for="admin_title" class="col-3 col-form-label">admin_title</label>
                                <input type="text" id="admin_title" name="admin_title" class="form-control col-5" value="<?php echo get_valuesettingapp('admin_title')->cfa_value;?>" placeholder="">
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('admin_title')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="current_version" class="col-3 col-form-label">current_version</label>
                                <input type="text" id="current_version" name="current_version" class="form-control col-5" value="<?php echo get_valuesettingapp('current_version')->cfa_value;?>" placeholder="" disabled>
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('current_version')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="format_nomor_surat" class="col-3 col-form-label">format_nomor_surat</label>
                                <input type="text" id="format_nomor_surat" name="format_nomor_surat" class="form-control col-5" value="<?php echo get_valuesettingapp('format_nomor_surat')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('format_nomor_surat')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_camat" class="col-3 col-form-label">sebutan_camat</label>
                                <input type="text" id="sebutan_camat" name="sebutan_camat" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_camat')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_camat')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_desa" class="col-3 col-form-label">sebutan_desa</label>
                                <input type="text" id="sebutan_desa" name="sebutan_desa" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_desa')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_desa')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_dusun" class="col-3 col-form-label">sebutan_dusun</label>
                                <input type="text" id="sebutan_dusun" name="sebutan_dusun" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_dusun')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_dusun')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_kabupaten" class="col-3 col-form-label">sebutan_kabupaten</label>
                                <input type="text" id="sebutan_kabupaten" name="sebutan_kabupaten" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_kabupaten')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_kabupaten')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_kabupaten_singkat" class="col-3 col-form-label">sebutan_kabupaten_singkat</label>
                                <input type="text" id="sebutan_kabupaten_singkat" name="sebutan_kabupaten_singkat" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_kabupaten_singkat')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_kabupaten_singkat')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_kecamatan" class="col-3 col-form-label">sebutan_kecamatan</label>
                                <input type="text" id="sebutan_kecamatan" name="sebutan_kecamatan" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_kecamatan')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_kecamatan')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_kecamatan_singkat" class="col-3 col-form-label">sebutan_kecamatan_singkat</label>
                                <input type="text" id="sebutan_kecamatan_singkat" name="sebutan_kecamatan_singkat" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_kecamatan_singkat')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_kecamatan_singkat')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="sebutan_singkat_kadus" class="col-3 col-form-label">sebutan_singkat_kadus</label>
                                <input type="text" id="sebutan_singkat_kadus" name="sebutan_singkat_kadus" class="form-control col-5" value="<?php echo get_valuesettingapp('sebutan_singkatan_kadus')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('sebutan_singkatan_kadus')->cfa_description;?></b></small>
                            </div>
                            <div class="form-group row">
                                <label for="libreoffice_path" class="col-3 col-form-label">libreoffice_path</label>
                                <input type="text" id="libreoffice_path" name="libreoffice_path" class="form-control col-5" value="<?php echo get_valuesettingapp('libreoffice_path')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('libreoffice_path')->cfa_description;?></b></small>
                            </div>
<div class="form-group row">
                                <label for="no_surat_terakhir" class="col-3 col-form-label">no_surat_terakhir</label>
                                <input type="number" id="no_surat_terakhir" name="no_surat_terakhir" class="form-control col-5" value="<?php echo get_valuesettingapp('no_surat_terakhir')->cfa_value;?>" placeholder="" >
                                <small class="form-text text-muted ml-1"><b><?php echo get_valuesettingapp('no_surat_terakhir')->cfa_description;?></b></small>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
