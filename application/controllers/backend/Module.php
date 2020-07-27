<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_module'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('module',IS_ROOT); //check for current module, this module just for root
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Manajemen Module';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/module'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        render_backendpage('backend/module/index',$data);

    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("mdl_status != ".DELETED);

        $this->m_module->init_datatable($filter_cols,array("mdl_name desc"));
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('mdl_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_module->set_select_mode('detail');
        $detail = $this->m_module->get_by_multiple_column(array(
                                                                    'mdl_id' => $pk_id,
                                                                    'mdl_status !=' => DELETED
                                                                ));
                                                            
        //output
        if($detail !== NULl) json_response('success','',$detail);
        else json_response('error','Data tidak ada');
    }

    public function add(){

		$this->auth->set_access_create();

		$this->save();
    }
    
    public function edit(){
        $this->auth->set_access_update();

        $this->save();
    }

    private function save(){
        if(!$this->input->is_ajax_request()) show_404();

        //validation
		$this->load->library('form_validation');
        $this->form_validation->set_rules('mdl_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('mdl_name'  , 'Nama Module'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('mdl_desc'  , 'Deskripsi Module'  , 'trim|max_length[255]');
        $this->form_validation->set_rules('mdl_status'  , 'Status Module'  , 'integer');
        
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('mdl_id') == ''){
                $mdl_id = $this->m_module->insert($this->input->post('mdl_name'),
                                                $this->input->post('mdl_desc'),
                                                implode("_",explode(" ",strtolower($this->input->post('mdl_name')))),
                                                $this->input->post('mdl_status') == PUBLISH ? PUBLISH : DRAFT
                                                );

                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('mdl_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_module->get_by_multiple_column(array(
                                                'mdl_id' => $pk_id,
                                                'mdl_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_module->update($pk_id,
                                                $this->input->post('mdl_name'),
                                                $this->input->post('mdl_desc'),
                                                implode("_",explode(" ",strtolower($this->input->post('mdl_name')))),
                                                $this->input->post('mdl_status') == PUBLISH ? PUBLISH : DRAFT);
            
                    json_response('success','Sukses Edit');
                }else
                    json_response('error','Data tidak ditemukan');
            }
        }else
            json_response('error',validation_errors());
    }

    public function delete(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_delete();
        if($this->input->post('mdl_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('mdl_id') as $row){
			$row = intval($row);
            $deleted = $this->m_module->get_by_column($row);
			if($deleted !== NULL){
                $this->m_module->update_single_column('mdl_status', DELETED, $row);
                $all_deleted[] = array("id" => $row, "status" => "success");
			}
        }
        if(count($all_deleted) > 0){
            json_response('success','sukses hapus');
        }else{
            json_response('error','gagal hapus');
        }

    }


    
}