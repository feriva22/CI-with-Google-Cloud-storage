<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
//THIS IS HELPER FOR EXTEND EXISTING LIBRARY GOOGLE CLOUD STORAGE 
//requirement library : google/cloud-storage: "^1.22"

require('./vendor/autoload.php');

use Google\Cloud\Storage\StorageClient;

if (!function_exists('upload_gcs_file')){
    /**
     * Function to extend upload function in Google Cloud Storage
     * @param string $key_file
     * @param string $bucket_name
     * @param string $file_path
     * @param string $prefix directory name on upload
     * @param string $upload_name if NULL will be use name file on $file_path
     * @param array  $options options for parsing in Google Cloud Storage upload method 
     * @return Google\Cloud\Storage\StorageObject
     * @throws \Exception
     */
     function upload_gcs_file(string $key_file,string $bucket_name,string $file_path,
                              string $prefix = '',string $upload_name = NULL, 
                              array $options = []){
        //RUN Validation First
        //run check file key is exist 
        if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }
        //run check file path is exist
        if(!file_exists($file_path)){
            throw new Exception('File to upload does not exist');
        }
        //check prefix parameters
        $prefix = ($prefix !== '' && substr($prefix,strlen($prefix)-1) !== '/') ? "$prefix/" : $prefix;
        $prefix = ($prefix == '/') ? '' : $prefix;

        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);

        $bucket = $storage->bucket($bucket_name);

        //set object name, if upload_name not set use name of file_path 
        $object_name = $prefix.(isset($upload_name) ? $upload_name : basename($file_path));

        //param parse to upload method
        $params = [ 'name' => $object_name];
        if(!empty($options)){
            $params = array_merge($params,$options);
        }

        //upload file
        $obj_data = $bucket->upload(fopen($file_path, 'r'),$params);
        //check file  on cloud storage
        if($obj_data->exists()){
            return $obj_data;
        } else {
            return NULL;
        }
     }
}

if (!function_exists('info_gcs_file')){
    /**
     * Function to get info about object on google cloud storage
     * @param string $key_file
     * @param string $bucket_name
     * @param string $object_name
     * 
     * @return Google\Cloud\Storage\StorageObject
     * @throws \Exception
     */
    function info_gcs_file(string $key_file,string $bucket_name,string $object_name){
        //run check file key is exist 
        if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }
        
        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);

        $bucket   = $storage->bucket($bucket_name);
        $obj_data = $bucket->object($object_name);

        
        if($obj_data->exists()){
            return $obj_data;
        } else {
            return NULL;
        }
    }
}

if (!function_exists('list_gcs_file')){
    /**
     * Function to get list object stored in Google Cloud Storage
     * @param string $key_file
     * @param string $bucket_name
     * @param string $prefix
     * @param bool   $exactMatch use if use exact result when use $prefix
     * @param array  $options
     * 
     * @return Google\Cloud\Storage\ObjectIterator<Google\Cloud\Storage\StorageObject>
     * @throws \Exception
     */
     function list_gcs_file(string $key_file,string $bucket_name,string $prefix = '',bool $exactMatch = false,array $options = []){
        //run check file key is exist 
         if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }
        //check prefix parameters
        $prefix = ($exactMatch && $prefix !== '' && substr($prefix,strlen($prefix)-1) !== '/') ? "$prefix/" : $prefix;
        $prefix = ($prefix == '/') ? '' : $prefix;

        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);
        $bucket = $storage->bucket($bucket_name);
        $params = ['prefix' => $prefix];
        if($exactMatch){
            $params['delimiter'] = $prefix;
        }
        if(!empty($options)){
            $params = array_merge($params,$options);
        }

        $objects = $bucket->objects($params);
        return $objects;
     }
}

if (!function_exists('generate_v4_post_policy')){
	/**
	 * Generates a V4 POST Policy to be used in an HTML form and echo's form.
	 *
	 * @param string $bucketName the name of your Google Cloud bucket.
	 * @param string $objectName the name of your Google Cloud object.
	 *
	 * @return void
	 */
	function generate_v4_post_policy($key_file, $bucketName,$objectName)
	{
		$storage = new StorageClient([
            'keyFilePath' => $key_file
		]);
		$bucket = $storage->bucket($bucketName);

		$object = $bucket->object($objectName);
		/*$url = $object->signedUploadUrl(new \DateTime('tomorrow'), [
			'version' => 'v4'
		]);
		return $url;*/
		
		$response = $bucket->generateSignedPostPolicyV4($objectName, new \DateTime('+10 minutes'), [
			
			'fields' => [
				 'x-goog-meta-hello' => 'tes',
				 'success_action_redirect' => 'http://localhost/backend/testing/confirmUploaded',
				 'success_action_status' => '201'
			]
		]);
		$url = $response['url'];
		$output = "<form method='POST' id='formUpload' enctype='multipart/form-data'>" . PHP_EOL;
		foreach ($response['fields'] as $name => $value) {
			$output .= "  <input name='$name' value='$value' type='hidden'/>" . PHP_EOL;
		}
		$output .= "  <input type='file' name='file'/><br />" . PHP_EOL;
		$output .= "  <input type='submit' value='Upload File' name='submit'/><br />" . PHP_EOL;
		$output .= "</form>" . PHP_EOL;

		return [$output,$url];
	}
}

function get_bucket_info($key_file, $bucketName){
	$storage = new StorageClient([
		'keyFilePath' => $key_file
	]);
	$bucket = $storage->bucket($bucketName);

	$result_update = $bucket->update([
		'cors' => [
			'origin' => ['http://localhost'],
			'method' => ['GET','POST','PUT','DELETE'],
			"responseHeader" => ["Access-Control-Allow-Origin"],
			"maxAgeSeconds"=> 3600
		]
	]);

	var_dump($result_update);
}

if (!function_exists('delete_gcs_file')){
    /**
     * Function to delete object on google cloud storage
     * @param string $key_file
     * @param string $bucket_name
     * @param string $object_name
     * @param array  $options parsing option to existing option in library
     * 
     * @return bool
     * @throws \Exception
     */
     function delete_gcs_file(string $key_file,string $bucket_name,string $object_name,array $options = []){
        //run check file key is exist 
        if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }
        
        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);

        $bucket   = $storage->bucket($bucket_name);
        $obj_data = $bucket->object($object_name);
        if($obj_data->exists()){
            try {
                $obj_data->delete($options);
                return TRUE;
            }catch(Exception $e){
                throw new Exception($e->getMessage());
            }
        } else {
            return FALSE;
        }
     }
}


if (!function_exists('modify_gcs_file')){
    /**
     * Modify object on Google Cloud Storage
     * @param string $key_file
     * @param string $bucket_name
     * @param string $object_name
     * @param array  $action      available action : rename, update_metadata, add_acl, update_acl, delete_acl
     * @param array  $params  
     * 
     * @return bool
     * @throws \Exception
     */
     function modify_gcs_file(string $key_file,string $bucket_name,string $object_name,string $action,array $params){
        //run check file key is exist 
        if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }

        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);

        $bucket   = $storage->bucket($bucket_name);
        $obj_data = $bucket->object($object_name);
        
        if($obj_data->exists()){
            if($action == 'rename'){
                if(!isset($params['name'])){
                    throw new Exception('Please provide "name" key on params array');
                }
                $res = $obj_data->rename($params['name'],$params);
                if($res !== NULL) {return TRUE;};
            }
            else if($action == 'update_metadata'){
                if(!isset($params['metadata'])){
                    throw new Exception('Please provide "metadata" key value on params array');
                }
                $res = $obj_data->update($params);
                if($res !== NULL) {return TRUE;};
            }
            else if($action == 'add_acl'){
                if(!isset($params['entity'])){
                    throw new Exception('Please provide "entity" key on params array');
                }
                if(!isset($params['role'])){
                    throw new Exception('Please provide "role" key on params array');
                }
                $obj_acl = $obj_data->acl();
                $res = $obj_acl->add($params['entity'],$params['role']);
                if($res !== NULL) {return TRUE;};
            }
            else if($action == 'edit_acl'){
                if(!isset($params['entity'])){
                    throw new Exception('Please provide "entity" key on params array');
                }
                if(!isset($params['role'])){
                    throw new Exception('Please provide "role" key on params array');
                }
                $obj_acl = $obj_data->acl();
                $res = $obj_acl->update($params['entity'],$params['role']);
                if($res !== NULL) {return TRUE;};
            }
            else if($action == 'delete_acl'){
                if(!isset($params['entity'])){
                    throw new Exception('Please provide "entity" key on params array');
                }
                $obj_acl = $obj_data->acl();
                $obj_acl->delete($params['entity']);
                return TRUE;
            }
            else{
                throw new Exception('Action supported only : rename,update_metadata,add_acl,edit_acl,delete_acl');
            }
        } 
        return FALSE;
     }
}


if (!function_exists('get_acl_gcs')){
    /**
     * Function to get info about acl on object or bucket google cloud storage
     * @param string $key_file
     * @param string $type          available is bucket or file
     * @param string $bucket_name
     * @param string $object_name
     * @param string $entity        specific on predefined Entity
     * 
     * @return array
     * @throws \Exception
     */
    function get_acl_gcs(string $key_file,string $type, string $bucket_name,string $object_name = NULL,string $entity = NULL){
        //run check file key is exist 
        if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }
        
        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);
        
        $bucket   = $storage->bucket($bucket_name);
        $params = [];
        if(isset($entity)){
            $params = ['entity' => $entity];
        }
        if($type == 'bucket'){
            $acl = $bucket->acl();
            $res = $acl->get($params);
            return $res;
        }
        else if($type == 'object'){
            if($object_name == ''){
                throw new Exception('Object name cannot empty');
            }
            $obj_data = $bucket->object($object_name);
            if($obj_data->exists()){
                $acl = $obj_data->acl();
                $res = $acl->get($params);
                return $res;
            } else {
                return NULL;
            }
        }
        else{
            throw new Exception('Type supported only : bucket,object');
        }
    }
}


if (!function_exists('download_gcs_file')){
    /**
     * Function to download file on Google cloud storage
     * @param string $key_file
     * @param string $bucket_name
     * @param string $object_name
     * 
     * @return array
     * @throws \Exception
     */
    function download_gcs_file(string $key_file,string $bucket_name,string $object_name){
        //run check file key is exist 
        $start = microtime(TRUE);

        if(!file_exists($key_file)){
            throw new Exception('Key file "'.$key_file.'" is Not Found');
        }
        
        //define storage class
        $storage = new StorageClient([
            //keyfile for authentication
            'keyFilePath' => $key_file
        ]);

        $expire = new \DateTime('+ ' . 360 . ' seconds');
        $options  = [
            'method' => 'GET'
        ];

        $bucket   = $storage->bucket($bucket_name);
        $obj_data = $bucket->object($object_name);
        $url      = $obj_data->signedUrl($expire,$options);

        if($obj_data->exists()){
            header('Location: '.$url,TRUE,302);
            die();
        }else{
            http_response_code(404);
            echo 'File Not Found';
        }
        
    }

}
