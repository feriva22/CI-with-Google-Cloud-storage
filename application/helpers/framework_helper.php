<?php if (! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('is_exist')){
   /**
    * Digunakan untuk mengecek objek $val kosong atau tidak
    * @param mixed $val
    * 
    * @return boolean
    */
    function is_exist($val){
        return (isset($val) || empty($val)  || trim($val) !== '');
    }
}

if(!function_exists('find_idx_byvalue')){
    
    function find_idx_byvalue($arr,$key,$value){
        $item = null;
        foreach($arr as $struct) {
            if ($value == $struct->$key) {
                $item = $struct;
                break;
            }
        }
        return $item;
    }
}


if (!function_exists('libre_convert_topdf')){
    /**
     * conversi docx to pdf
     * @param mixed $
     * 
     * @return mixed
     */
     function libre_convert_topdf($srcfile,$outdir,$bin = 'libreoffice'){
         if(!is_executable($bin)){
             $resp = new StdClass();
             $resp->msg = 'Konfigurasi path libreoffice salah !';
             return $resp;
         }
         $exec_cmd = $bin.' --headless --convert-to pdf --outdir "'.$outdir.'" "'.$srcfile.'" --nocrashreport --nodefault --nofirststartwizard --nolockcheck --nologo --norestore';
         shell_exec($exec_cmd);
         if(file_exists($outdir.'/'.pathinfo($srcfile)['filename'].'.pdf')){
             return $outdir.'/'.pathinfo($srcfile)['filename'].'.pdf';
         }else{
             $resp = new StdClass();
             $resp->msg = 'Gagal proses konversi data';
             return $resp;
         }
     }
 }
 


if (!function_exists('get_valuesetting')){
   /**
    * Mendapatkan nilai setting pada database
    * @param mixed $key
    * 
    * @return mixed
    */
    function get_valuesetting($key){
        return get_instance()->db->get_where('setting',array('stg_name' => $key))->row()->stg_value; 
    }
}

if (!function_exists('get_valuesettingapp')){
    /**
     * Mendapatkan nilai setting app pada database
     * @param mixed $key
     * 
     * @return mixed
     */
     function get_valuesettingapp($key){
         return get_instance()->db->get_where('config_app',array('cfa_name' => $key))->row(); 
     }
 }

if (!function_exists('set_valuesetting')){
    function set_valuesetting($key,$value){
        return get_instance()->db->update('setting',array('stg_value' => $value),array('stg_name' => $key));
    }
}

if (!function_exists('set_valuesettingapp')){
    function set_valuesettingapp($key,$value){
        return get_instance()->db->update('config_app',array('cfa_value' => $value),array('cfa_name' => $key));
    }
}


if (! function_exists('json_response')) {
   /**
    * extend fungsi json_encode ditambahkan dengan validasi
    * @param mixed $status
    * @param null $message
    * @param null $data
    * @param null $expand_value
    * @param integer $resp_code
    * 
    * @return mixed
    */
    function json_response($status, $message = null, $data = null, $expand_value = null, $resp_code = 200)
    {
        // get main CodeIgniter object
        $CI = get_instance();
        
        if($status === 'error'){
            if(!is_exist($message))
                $message = 'Invalid input';
        }
        $response = array('status' => $status, 
                            'message' => $message,
                            'data' => $data);

        if($expand_value !== NULL && is_array($expand_value)) {
            $response = array_merge($response,$expand_value);
        }

        $CI->output
                    ->set_status_header($resp_code)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($response));
        
    }
}

if(!function_exists('upload_media_photo')){
   /**
    * fungsi untuk upload media photo 
    * @param mixed $selector
    * @param mixed $upload_path
    * @param boolean $encrypt_name
    * 
    * @return mixed
    */
    function upload_media_photo($selector,$upload_path,$encrypt_name = TRUE){
        /* foto modification */
        $response = new stdClass();
        $CI = get_instance();
        $CI->load->library('upload');

        $config['upload_path'] = $upload_path; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size'] = '2048';
        $config['encrypt_name'] = $encrypt_name; //Enkripsi nama yang terupload
        $CI->upload->initialize($config); //initialize upload library
        if(!empty($_FILES[$selector]['name'])){
            if ($CI->upload->do_upload($selector)){  //name of input upload file
                $imgObj = $CI->upload->data();
                //Compress Image
                $config['image_library']='gd2';
                $config['source_image']= $upload_path.''.$imgObj['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= FALSE;
                $config['quality']= '50%';
                $config['width']= 200;
                $config['height']= 200;
                $config['new_image']= $upload_path.$imgObj['file_name'];
                $CI->load->library('image_lib', $config);
                $CI->image_lib->resize();

                $response->success = true;
                $response->data = $imgObj;
            }else{
                $response->success = false;
                $response->data = $CI->upload->display_errors();
            }
        }else{
                $response->success = false;
                $response->data = 'Field '.$selector.' not found';
        }
        return $response;         
    }
}

if(!function_exists('delete_media_photo')){
   /**
    * Fungsi untuk menghapus media photo
    * @param string $upload_name
    * 
    * @return bool
    */
    function delete_media_photo($upload_name){
        if(file_exists($upload_name)){
            unlink($upload_name);
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('upload_media_doc')){
    function upload_media_doc($selector,$upload_path,$encrypt_name = TRUE){
        $response = new stdClass();
        $CI = get_instance();
        $CI->load->library('upload');

        $config['upload_path'] = $upload_path; //path folder
        $config['allowed_types'] = '*'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = $encrypt_name; //Enkripsi nama yang terupload
        $config['max_size'] = '5012';
        $CI->upload->initialize($config); //initialize upload library
        if(!empty($_FILES[$selector]['name'])){
            if ($CI->upload->do_upload($selector)){  //name of input upload file
                $docObj = $CI->upload->data();
                $response->success = true;
                $response->data = $docObj;
            }else{
                $response->success = false;
                $response->data = $CI->upload->display_errors();
            }
        }else{
            $response->success = false;
            $response->data = 'Field '.$selector.' not found';
        }
        return $response;   

    }
}

if(!function_exists('delete_media_doc')){
    function delete_media_doc($upload_name){
        if(file_exists($upload_name)){
            @unlink($upload_name);
        }else{
            return false;
        }
    }
}

if(!function_exists('generate_code')){
   /**
    * Fungsi untuk generate code acak dengan opsional prefix
    * @param mixed $input
    * @param integer $pad_len
    * @param mixed $prefix=NULL
    * 
    * @return string
    */
    function generate_code($input,$pad_len = 7,$prefix=NULL){
        if ($pad_len <= strlen($input))
	    $pad_len += 1;
            //trigger_error('$pad_len less than $input', E_USER_ERROR);
        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
}

if(!function_exists('can_tojson')){
    function can_tojson($json_data){
        json_decode($json_data);
        if(json_last_error() !== JSON_ERROR_NONE){
            return false;
        }else {
            return true;
        }
    }
}


if(!function_exists('validation_array_object')){
    /**
     * Fungsi untuk validasi nilai key value dari array of object
     * @param array $data
     * @param array $validation_data
     * 
     * @return array
     */
    function validation_array_object($data, $validation_data){
        //type of validation data
        /*
        [
            [name_of_key] => 'required|is_numeric|is_string[default]'
        ]
        */
        $resp = new StdClass();
        $resp->data = [];
        $resp->status = true;

        if(gettype($validation_data) !== 'array'){
            $resp->status = false;
            $resp->data = 'Validation is not object';
            return $resp;
        }


        foreach($validation_data as $key => $val) {
            $role = explode('|',$val);
            //check first if role REQUIRED
            $callback_isset = function($item) use ($key) {return (isset($item->{$key}) && $item->{$key} !== '');};
            $callback_isnumber = function($item) use ($key) {return is_numeric($item->{$key});};
            $callback_isstring = function($item) use ($key) {return is_string($item->{$key});};

            if(in_array('required',$role)){
                if(count(array_filter($data,$callback_isset)) > 0){
                                        
                    //check value if role is number
                    if(in_array('is_numeric',$role) && 
                    count(array_filter($data,$callback_isnumber)) ==  0 ) 
                        $resp->data[] = ['key' => $key,'msg' => $key.' Must numeric'];

                    //check value if role is string
                    if(in_array('is_string',$role) && 
                    count(array_filter($data,$callback_isstring)) ==  0 )
                        $resp->data[] = ['key' => $key,'msg' => $key.' Must string'];

                } else {
                    $resp->data[] = [
                        'key' => $key,
                        'msg' => $key.' Missing in data'
                    ];
                }
            }
        }

        if(count($resp->data) != 0){
            $resp->status = false;
        }
        return $resp;
    }

}

if(!function_exists('number_rp')){
   /**
    * Fungsi untuk menambahkan format currency ke number
    * @param mixed $number
    * 
    * @return string
    */
    function number_rp($number){
        return number_format($number,2,',','.');
    }
}

if(!function_exists('tgl_indo')){
    /**
     * Fungsi untuk konversi tanggal ke number
     * @param date date()
     * 
     * @return string
     */
    function tgl_indo($tanggal){
    	$bulan = array (
    		1 =>   'Januari',
    		'Februari',
    		'Maret',
    		'April',
    		'Mei',
    		'Juni',
    		'Juli',
    		'Agustus',
    		'September',
    		'Oktober',
    		'November',
    		'Desember'
    	);
    	$pecahkan = explode('-', $tanggal);
    
    	// variabel pecahkan 0 = tanggal
    	// variabel pecahkan 1 = bulan
    	// variabel pecahkan 2 = tahun
    
    	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}

if(!function_exists('tgl_indo_todate')){
    /**
     * Fungsi untuk konversi tanggal ke number
     * @param date date()
     * 
     * @return string
     */
    function tgl_indo_todate($tanggal){
    	$bulan = array (
                 NULL,
    		  'Januari',
    		'Februari',
    		 'Maret',
    		'April',
    		'Mei',
    		'Juni',
    		'Juli',
    		'Agustus',
    		'September',
    		'Oktober',
    		'November',
    		'Desember'
    	);
    	$pecahkan = explode(' ', $tanggal);
    
    	// variabel pecahkan 0 = tanggal
    	// variabel pecahkan 1 = bulan
    	// variabel pecahkan 2 = tahun
    
    	return $pecahkan[2] . '-' .(array_search($pecahkan[1],$bulan)). '-' . $pecahkan[0];
    }
}


if(!function_exists('render_backendpage')){

   /**
    * Fungsi yang berguna untuk load view 
    * @param string $header_page='backend/__base/header_dashboard'
    * @param string $footer_page='backend/__base/footer_dashboard'
    * @param string $content_page
    * @param bool $load_sidebar
    * @param mixed  $data_parse=NULL  array of object ,key parse as variable on view page
    * 
    * @return void
    */
    function render_backendpage($content_page,
                                $data_parse=NULL,
                                $collapsed_sidebar=FALSE,
                                $load_sidebar=TRUE,
                                $echo = FALSE,
                                $header_page='backend/__base/header_dashboard',
                                $footer_page='backend/__base/footer_dashboard'
                                ){

        $CI = get_instance();
        $data_parse['collapsed_sidebar'] = $collapsed_sidebar;

        if($echo){
            echo $CI->load->view($header_page,$data_parse,TRUE);
        }else{
            $CI->load->view($header_page,$data_parse);
        }

        
        if($load_sidebar){
            $CI->load->model(array('m_modulemenu'));
            $sidebar = $CI->m_modulemenu->get("","mdm_order asc");
            $sidebar_by_group = [];
            if($sidebar !== NULL && $CI->auth->getUsergroup() !== IS_ROOT){
                foreach($sidebar as $key => $item){
                    $item->mdm_staffgroup = explode(",",$item->mdm_staffgroup);
                    foreach($CI->auth->getUsergroup() as $group){
                        if(in_array($group, $item->mdm_staffgroup)){
                            $sidebar_by_group[] = $item;
                            break;
                        }
                    }
                }
                //get all group 
                $all_group = $CI->m_modulemenu->custom_query("SELECT mdm_group FROM modulemenu GROUP BY mdm_group");
                
                $data = generate_sidebar(0,$sidebar_by_group,$all_group,$CI->auth->get_module(),1);
                $data_parse['sidebar'] = $data;
            }
            
        }

        if($load_sidebar){
            if($CI->session->userdata('userID') == IS_ROOT){
                if($echo){
                    echo $CI->load->view('backend/__base/sidebar_root',$data_parse,TRUE);
                }else{
                    $CI->load->view('backend/__base/sidebar_root',$data_parse);
                }
            }else{
                //when login with non root 
                $data_parse['module_now'] = $CI->auth->get_module();
                if($echo){
                    echo $CI->load->view('backend/__base/sidebar_staff',$data_parse,TRUE);
                }else{
                    $CI->load->view('backend/__base/sidebar_staff',$data_parse);
                }
            }
        }
        if($echo){
            echo $CI->load->view($content_page,$data_parse,TRUE);
            echo $CI->load->view($footer_page,$data_parse,TRUE);
        }else{
            $CI->load->view($content_page,$data_parse);
            $CI->load->view($footer_page,$data_parse);
        }
        
    }
}


if(!function_exists('generate_sidebar')){
    function generate_sidebar($parent_id = 0,$data_sidebar,$all_group,$module_now,$count=1,$current_group=''){
        $menu_generated = "";
        
        $count++;
        if($count > 100){ //buat jaga2 jika overhausted
            return false;
        }

        foreach($all_group as $group){
            foreach($data_sidebar as $menu){
                if($group->mdm_group != $menu->mdm_group){
                    continue;
                }
                if($menu->mdm_parent != $parent_id){
                    continue;
                }
                $tot_child = 0;
                $is_clicked = false;
                $menu_slug = $menu->mdm_url;

                foreach($data_sidebar as $child_menu){
                    if($child_menu->mdm_parent != $menu->mdm_id){
                        continue;
                    }
                    if($child_menu->mdm_url == $module_now){
                        $is_clicked = true;
                    }
                    $tot_child++;
                }

                if($current_group != $group->mdm_group && !empty($group->mdm_group)){
                    $menu_generated .= '<div class="nav-lavel">'.$group->mdm_group.'</div>';
                    $current_group = $group->mdm_group;
                }
                if(!empty($menu->mdm_url)){
                    $menu->mdm_url = base_url() .'backend/'. $menu->mdm_url;
                }

                $menu_url = $tot_child > 0 || empty($menu->mdm_url) ? 'javascript:void(0)' : $menu->mdm_url;

                if($tot_child > 0 || $parent_id == 0){
                    $menu_generated .=  '<div class="nav-item '.($tot_child > 0 ? 'has-sub' : '').' '.(($is_clicked || $module_now == $menu_slug) && $module_now != 'dashboard' ? 'active open' : '').'">';
                }

                
                $menu_generated .=  '<a href="'.$menu_url.'" class="'.(($tot_child > 0 && $parent_id == 0) ? '' : 'menu-item').' '.($module_now == $menu_slug ? 'active' : '').'" data-parent="'.$parent_id.'">'.
                                        '<i class="'.$menu->mdm_class.'"></i>'.
                                        '<span>'.$menu->mdm_title.'</span> '.
                                        '</a>';

                if($tot_child > 0){
                    $menu_generated .= '<div class="submenu-content" style="">';
                }
                $menu_generated .= generate_sidebar($menu->mdm_id,$data_sidebar,$all_group,$module_now,$count,$current_group);
                if($tot_child > 0){
                    $menu_generated .= '</div>';
                }
                if($tot_child > 0 || $parent_id == 0){
                    $menu_generated .= '</div>';
                }
                                        
            }
        }
        return $menu_generated;
    }
}