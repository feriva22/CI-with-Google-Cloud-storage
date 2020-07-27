<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_modulemenu','m_staffgroup'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('module_menu',IS_ROOT); //check for current module, this module just for root
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Manajemen Module Menu';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/module_menu'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();
        $data['data_staffgroup'] = $this->m_staffgroup->get('sdg_status != '.DELETED);
        $data['data_parent'] = $this->m_modulemenu->get('mdm_status != '.DELETED);

        render_backendpage('backend/module_menu/index',$data);

    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("mdm_status != ".DELETED);

        $this->m_modulemenu->init_datatable($filter_cols,array("mdm_id desc"));
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('mdm_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_modulemenu->set_select_mode('detail');
        $detail = $this->m_modulemenu->get_by_multiple_column(array(
                                                                    'mdm_id' => $pk_id,
                                                                    'mdm_status !=' => DELETED
                                                                ));
                                                    
        //output
        if($detail !== NULl){
            $detail->mdm_staffgroup = explode(",",$detail->mdm_staffgroup);
            json_response('success','',$detail);
        }
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
        $this->form_validation->set_rules('mdm_id'    , 'Id'                , 'integer');
        $this->form_validation->set_rules('mdm_title'       , 'Judul Menu'  , 'required|trim|max_length[255]');
        $this->form_validation->set_rules('mdm_class'       , 'Icon Class Menu'  , 'trim|max_length[255]');
        $this->form_validation->set_rules('mdm_url'         , 'Url Menu'    , 'trim|max_length[255]');
        $this->form_validation->set_rules('mdm_parent'      , 'Parent Menu' , 'integer');
        $this->form_validation->set_rules('mdm_group'       , 'Group Menu'  , 'trim|max_length[255]');
        $this->form_validation->set_rules('mdm_order'       , 'Urutan Menu' , 'required|integer');
        $this->form_validation->set_rules('mdm_status'      , 'Status Menu' , 'integer');

        
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('mdm_id') == ''){
                $data_staffgroup = "";
                if($this->input->post('mdm_staffgroup') !== NULL){
                    if(is_array($this->input->post('mdm_staffgroup'))){
                        $data_staffgroup = implode(",",$this->input->post('mdm_staffgroup'));
                    }
                }

                $mdm_id = $this->m_modulemenu->insert(($data_staffgroup !== "") ? $data_staffgroup : FALSE,
                                                    $this->input->post('mdm_title'),
                                                    ($this->input->post('mdm_class') !== "") ? $this->input->post('mdm_class') : FALSE,
                                                    $this->input->post('mdm_url'),
                                                    ($this->input->post('mdm_parent') !== "") ? $this->input->post('mdm_parent') : FALSE, 
                                                    ($this->input->post('mdm_group') !== "") ? $this->input->post('mdm_group') : FALSE,
                                                    $this->input->post('mdm_order'),
                                                    $this->input->post('mdm_status') == PUBLISH ? PUBLISH : DRAFT
                                                );

                json_response('success','Sukses menambah');
            }
            //update
            else{
                $pk_id = $this->input->post('mdm_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_modulemenu->get_by_multiple_column(array(
                                                'mdm_id' => $pk_id,
                                                'mdm_status !=' => DELETED
                ));
                if($edited !== NULL){

                    $data_staffgroup = "";
                    if($this->input->post('mdm_staffgroup') !== NULL){
                        if(is_array($this->input->post('mdm_staffgroup'))){
                            $data_staffgroup = implode(",",$this->input->post('mdm_staffgroup'));
                        }
                    }

                    $this->m_modulemenu->update($pk_id,
                                                ($data_staffgroup !== "") ? $data_staffgroup : FALSE,
                                                $this->input->post('mdm_title'),
                                                ($this->input->post('mdm_class') !== "") ? $this->input->post('mdm_class') : FALSE,
                                                $this->input->post('mdm_url'),
                                                ($this->input->post('mdm_parent') !== "") ? $this->input->post('mdm_parent') : FALSE, 
                                                ($this->input->post('mdm_group') !== "") ? $this->input->post('mdm_group') : FALSE,
                                                $this->input->post('mdm_order'),
                                                $this->input->post('mdm_status') == PUBLISH ? PUBLISH : DRAFT                                
                                                );
            
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
        if($this->input->post('mdm_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('mdm_id') as $row){
			$row = intval($row);
            $deleted = $this->m_modulemenu->get_by_column($row);
			if($deleted !== NULL){
                $this->m_modulemenu->delete_permanent($row);
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