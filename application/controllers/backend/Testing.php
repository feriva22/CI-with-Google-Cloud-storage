<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./vendor/autoload.php');

use Google\Cloud\Storage\StorageClient;

class Testing extends CI_Controller {
    public function __construct() {
        parent::__construct();

    }

    public function index(){
        $this->load->view('backend/testing/index');
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

    public function list($prefix = ''){
        $objects = list_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$prefix,TRUE);
        foreach($objects as $object){
            echo $object->name() . '<br>';
        }
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
            download_gcs_file(GCS_PETRO_KEY,BUCKET_PETRO_NAME,$obj_name);
        } catch(Exception $e){
            echo "Exception type :".get_class($e);
            echo "\n<br>Message: ".$e->getMessage();
            return;
        }
    }
}

?>