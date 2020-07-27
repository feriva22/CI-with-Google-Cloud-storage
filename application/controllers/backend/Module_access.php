<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_access extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_moduleaccess','m_module','m_staffgroup'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('module_access',IS_ROOT); //check for current module, this module just for root
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Manajemen Module Access';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/module_access'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();
        $data['data_module'] = $this->m_module->get("mdl_status != ".DELETED);
        $data['data_staffgroup'] = $this->m_staffgroup->get("sdg_status !=".DELETED);

        render_backendpage('backend/module_access/index',$data);

    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array();

        $this->m_moduleaccess->init_datatable($filter_cols,array("mda_id desc"));
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('mda_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_moduleaccess->set_select_mode('detail');
        $detail = $this->m_moduleaccess->get_by_multiple_column(array(
                                                                    'mda_id' => $pk_id
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
        $this->form_validation->set_rules('mda_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('mda_module'  , 'Module'  , 'required|integer');
        $this->form_validation->set_rules('mda_staffgroup'  , 'Staff group'  , 'required|integer');


        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('mda_id') == ''){

                $data_exist = $this->m_moduleaccess->get_by_multiple_column(array(
                                                            'mda_staffgroup' => $this->input->post('mda_staffgroup'),
                                                            'mda_module' => $this->input->post('mda_module')
                                                            ));
                                                   
                if($data_exist !== NULL){                    
                    json_response('error','Data sudah ada');
                }
                else{
                    $mda_id = $this->m_moduleaccess->insert($this->input->post('mda_module'),
                    $this->input->post('mda_staffgroup'),
                    $this->input->post('mda_create') !== NULL ? GRANTED : UNGRANTED,
                    $this->input->post('mda_read') !== NULL ? GRANTED : UNGRANTED,
                    $this->input->post('mda_update') !== NULL ? GRANTED : UNGRANTED,
                    $this->input->post('mda_delete') !== NULL  ? GRANTED : UNGRANTED
                    );
                    json_response('success','Sukses menambah');
                }

            }
            //update
            else{
                $pk_id = $this->input->post('mda_id');
                //make integer
                $pk_id = intval($pk_id);
                $edited = $this->m_moduleaccess->get_by_multiple_column(array(
                                                'mda_id' => $pk_id
                ));
                if($edited !== NULL){
                    $this->m_moduleaccess->update($pk_id,
                                                $this->input->post('mda_module'),
                                                $this->input->post('mda_staffgroup'),
                                                $this->input->post('mda_create') !== NULL ? GRANTED : UNGRANTED,
                                                $this->input->post('mda_read') !== NULL ? GRANTED : UNGRANTED,
                                                $this->input->post('mda_update') !== NULL ? GRANTED : UNGRANTED,
                                                $this->input->post('mda_delete') !== NULL  ? GRANTED : UNGRANTED
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
        if($this->input->post('mda_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('mda_id') as $row){
			$row = intval($row);
            $deleted = $this->m_moduleaccess->get_by_column($row);
			if($deleted !== NULL){
                $this->m_moduleaccess->delete_permanent($row);
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