<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_group extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_staffgroup'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('staff_group'); //check for current module, this module just for root
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Manajemen Staff Group';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/staff_group'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        render_backendpage('backend/staff_group/index',$data);

    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("sdg_status != ".DELETED);

        $this->m_staffgroup->init_datatable($filter_cols,array("sdg_name desc"));
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('sdg_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_staffgroup->set_select_mode('detail');
        $detail = $this->m_staffgroup->get_by_multiple_column(array(
                                                                    'sdg_id' => $pk_id,
                                                                    'sdg_status !=' => DELETED
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
        $this->form_validation->set_rules('sdg_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('sdg_name'  , 'Nama staff group'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('sdg_desc'  , 'Deskripsi staff group'  , 'trim|max_length[255]');
        $this->form_validation->set_rules('sdg_status'  , 'Status staff group'  , 'integer');
        
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('sdg_id') == ''){
                $sdg_id = $this->m_staffgroup->insert($this->input->post('sdg_name'),
                                                $this->input->post('sdg_desc'),
                                                $this->input->post('sdg_status') == PUBLISH ? PUBLISH : DRAFT
                                                );

                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('sdg_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_staffgroup->get_by_multiple_column(array(
                                                'sdg_id' => $pk_id,
                                                'sdg_status !=' => DELETED
                ));
                if($edited !== NULL){
                    $this->m_staffgroup->update($pk_id,
                                                $this->input->post('sdg_name'),
                                                $this->input->post('sdg_desc'),
                                                $this->input->post('sdg_status') == PUBLISH ? PUBLISH : DRAFT);
            
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
        if($this->input->post('sdg_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('sdg_id') as $row){
			$row = intval($row);
            $deleted = $this->m_staffgroup->get_by_column($row);
			if($deleted !== NULL){
                $this->m_staffgroup->update_single_column('sdg_status', DELETED, $row);
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