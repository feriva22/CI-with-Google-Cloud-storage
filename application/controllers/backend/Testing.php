<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

/*
header('Access-Control-Allow-Origin: *');
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
header("Access-Control-Allow-Methods: GET, OPTIONS,POST");
*/
require('./vendor/autoload.php');

use Google\Cloud\Storage\StorageClient;

class Testing extends CI_Controller {
    public function __construct() {
        parent::__construct();

    }

    public function index(){
		$data['url'] = generate_v4_post_policy(GCS_KEY,BUCKET_NAME,'/A.3 List Pegawai Desa.png');

        $this->load->view('backend/testing/index',$data);
    }

    public function upload(){

        $prefix    = 'doc_test';
        $file_name = 'New file.png';
        $file_path = $_FILES['file']['tmp_name'];

        try {
            $resp = upload_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$file_path,$prefix,$file_name);
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
            return;
        }
        var_dump($resp->info());
    }

	public function list()
	{
		$prefix = isset($_GET['dir']) ? urldecode($_GET['dir']) : '/';
        $objects = list_gcs_file(GCS_KEY,BUCKET_NAME,$prefix,TRUE);
        foreach($objects as $object){
            echo $object->name() . '<br>';
        }
	}
	
	public function getUploadSigned(){

		$policy = generate_v4_post_policy(GCS_KEY,BUCKET_NAME,'hilih/yolo.png');

		$data['form'] = $policy[0];
		$data['url'] = $policy[1];
        $this->load->view('backend/testing/index',$data);
	}

	public function confirmUploaded(){
		$objectName = $_POST['key'];
		$bucket = $_POST['bucket'];
		$etag = $_POST['etag'];

		$info = info_gcs_file(GCS_KEY,$bucket,$objectName);

		if(isset($info)){
            echo json_encode(array('status' => 'OK'));
        }else {
			echo json_encode(array('status' => 'Failed'));
        }

	}

	public function bucket_info(){
		get_bucket_info(GCS_KEY,BUCKET_NAME);
	}

    public function info($obj_name){
        $obj_name = urldecode($obj_name);
        try {
            $info = info_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$obj_name);
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
            return;
        }
        if(isset($info)){
            var_dump($info->info());
        }else {
            echo "object \"$obj_name\" not found";
        }
    }

	function downloadFile(){
		$file = isset($_GET['file']) ? urldecode($_GET['file']) : show_error('need input');

		$admin = FCPATH.'gcs_key/long-adviser-271306-742cda3a6376.json';

		download_gcs_file($admin, $this->bucket,$file);
	}

    public function delete($obj_name){
        $obj_name = urldecode($obj_name);
        try {
            if(delete_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$obj_name)){
                echo 'Success Delete';
            }
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
            return;
        }
    }

    public function modify($obj_name){
        $obj_name = urldecode($obj_name);
        $params = [
            'entity' => 'allAuthenticatedUsers',
            'role'   => 'OWNER'
        ];
        try {
            $resp = modify_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$obj_name,'delete_acl',$params);
            $info = info_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$obj_name);
            var_dump($resp);
            var_dump($info->info());
            
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
        }
    }

    public function get_acl_file($obj_name) {
        $obj_name = urldecode($obj_name);
        try {
            $resp = get_acl_gcs(GCS_PETRO_KEY,'object',BUCKET_PETRO_NAME,$obj_name);
            var_dump($resp);    
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
        }
    }


    public function download(){
        //define storage class

        $obj_name = urldecode($_GET['file']);
        try {
            download_gcs_file(GCS_KEY,BUCKET_NAME,$obj_name);
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
            return;
        }
    }
}

?>
