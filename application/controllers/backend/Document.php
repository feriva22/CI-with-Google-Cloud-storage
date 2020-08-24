<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./vendor/autoload.php');

use Google\Cloud\Storage\StorageClient;


class Document extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_document'));
        
        $this->auth->authenticate(); //authenticate logged in user

        $this->auth->set_module('document'); //check for current module, this module just for root
        
        $this->auth->authorize();    //authorize the user        
	}
	
	public function index()
	{
        $this->auth->set_access_read();

		$data = array();

        $data['page_title'] = 'Manajemen Dokumen';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/document'
        );
        $data['assets_js'] = array();
        $data['role'] = $this->auth->all_permission();

        render_backendpage('backend/document/index',$data,TRUE);

    }

    public function get_datatable(){
        //allow ajax only
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $filter_cols = array("doc_status != ".DELETED);

        $this->m_document->init_datatable($filter_cols,array("doc_name desc"));
    }

    public function detail(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_read();

        $pk_id = $this->input->post('doc_id');
        if($pk_id === NULL)
            json_response('error');

        $pk_id = intval($pk_id);

        $this->m_document->set_select_mode('detail');
        $detail = $this->m_document->get_by_multiple_column(array(
                                                                    'doc_id' => $pk_id,
                                                                    'doc_status !=' => DELETED
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
        $this->form_validation->set_rules('doc_id'    , 'Id'            , 'integer');
        $this->form_validation->set_rules('doc_name'  , 'Nama document'  , 'trim|required|max_length[255]');
        $this->form_validation->set_rules('doc_desc'  , 'Deskripsi document'  , 'trim|max_length[255]');
        $this->form_validation->set_rules('doc_status'  , 'Status document'  , 'integer');
        
        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');
            //insert
            if($this->input->post('doc_id') == ''){

                if($_FILES['doc_file']['name'] !== ""){
                    //show uploading file
                    $file_name = $_FILES['doc_file']['name'];
                    $file_mime = $_FILES['doc_file']['type'];
                    $file_tmp  = $_FILES['doc_file']['tmp_name'];
                    $file_size = $_FILES['doc_file']['size'];

                    //$file_post_tmp = rename($file_tmp,'/tmp/'.$file_name) ? '/tmp/'.$file_name : NULL;

                    if($file_tmp !== NULL){
                        //define storage class

                        $storage = new StorageClient([
                            //keyfile for authentication
                            'keyFilePath' => GCS_KEY
                        ]);
                        
                        $bucket = $storage->bucket(BUCKET_NAME);

                        // Upload a file to the bucket WITH public url.
                        $bucket->upload(
                            fopen($file_tmp, 'r'),
                            [
                                'name' => 'document/'.$file_name //save on directory document
                            ]
                        );
                        //check file 
                        $object = $bucket->object('document/'.$file_name);
                        if($object->exists()){
							$info_obj = $object->info();
                        } else {
                            json_response('error','failed upload data');
                            exit();
                        }
                    }
                    else {
                        json_response('error','Error in retrieving data');
                    }
                }
                $doc_id = $this->m_document->insert($this->input->post('doc_name'),
                                                $this->input->post('doc_desc'),
                                                (isset($info_obj) ? base_url().'backend/document/download?file=document/'.$file_name : FALSE),
                                                (isset($info_obj) ? 'document/'.$file_name : FALSE),
                                                $this->input->post('doc_status') == PUBLISH ? PUBLISH : DRAFT
                                                );

                json_response('success','Sukses menambah',(isset($info_obj) ? $info_obj : NULL));
            }
            //update
            else{
                $pk_id = $this->input->post('doc_id');
                //make integer
                $pk_id = intval($pk_id);

                $edited = $this->m_document->get_by_multiple_column(array(
                                                'doc_id' => $pk_id,
                                                'doc_status !=' => DELETED
                ));




                if($edited !== NULL){
                    //check if has upload file
                    if($_FILES['doc_file']['name'] !== ""){
                        //define storage class
                        $storage = new StorageClient([
                            //keyfile for authentication
                            'keyFilePath' => GCS_KEY
                        ]);
                        
                        $bucket = $storage->bucket(BUCKET_NAME);

                        //retrieving file first on cloud storage
                        $file_old = $bucket->object($edited->doc_file_name);
                        if($file_old->exists()){ //delete file
                            $file_old->delete();
                        }

                        //upload new file
                        $file_name = $_FILES['doc_file']['name'];
                        $file_tmp  = $_FILES['doc_file']['tmp_name'];
                        $bucket->upload(
                            fopen($file_tmp, 'r'),
                            [
                                'name' => 'document/'.$file_name //save on directory document
                            ]
                        );
                        //check file 
                        $object = $bucket->object('document/'.$file_name);
                        if($object->exists()){
                            $info_obj = $object->info();
                        } else {
                            json_response('error','failed upload data');
                            exit();
                        }
                    }

                    $this->m_document->update($pk_id,
                                                $this->input->post('doc_name'),
                                                $this->input->post('doc_desc'),
                                                (isset($info_obj) ? base_url().'backend/document/download?file=document/'.$file_name : FALSE),
                                                (isset($info_obj) ? 'document/'.$file_name : FALSE),
                                                $this->input->post('doc_status') == PUBLISH ? PUBLISH : DRAFT);
            
                    json_response('success','Sukses Edit',(isset($info_obj) ? $info_obj : NULL));
                }else
                    json_response('error','Data tidak ditemukan');
            }
        }else
            json_response('error',validation_errors());
    }


    public function download(){
        $obj_name = urldecode($_GET['file']);
        try {
            download_gcs_file(GCS_KEY,BUCKET_NAME,$obj_name);
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
            return;
        }
    }

    public function delete(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->set_access_delete();
        if($this->input->post('doc_id') === NULL) json_response('error');
        
        $all_deleted = array();
		foreach($this->input->post('doc_id') as $row){
			$row = intval($row);
            $deleted = $this->m_document->get_by_column($row);
			if($deleted !== NULL){
                //$this->m_document->update_single_column('doc_status', DELETED, $row);
                //define storage class
                $storage = new StorageClient([
                    //keyfile for authentication
                    'keyFilePath' => GCS_KEY
                ]);
                
                $bucket = $storage->bucket(BUCKET_NAME);

                //retrieving file first on cloud storage
                $file_old = $bucket->object($deleted->doc_file_name);
                try{
                    $file_old->delete();
                } catch(Exception $e){

                }

                $this->m_document->delete_permanent($row);
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