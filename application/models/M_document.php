<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_document extends MY_Model {
    protected $pk_col = 'doc_id';
    protected $table_name = 'document';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('doc_id');
            $this->db->select('doc_name');
            $this->db->select('doc_desc');
            $this->db->select('doc_public_url');
            $this->db->select('doc_file_name');
            $this->db->select('doc_public_url AS doc_file');
            $this->db->select('doc_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('doc_id');
            $this->db->select('doc_name');
            $this->db->select('doc_desc');
            $this->db->select('doc_public_url');
            $this->db->select('doc_file_name');
            $this->db->select('doc_public_url AS doc_file');
            $this->db->select('doc_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $doc_name = FALSE,
                            $doc_desc = FALSE,
                            $doc_public_url = FALSE,
                            $doc_file_name = FALSE,
                            $doc_status = FALSE
                        ){
        $data = array();
        if($doc_name !== FALSE) $data['doc_name'] = trim($doc_name);
        if($doc_desc !== FALSE) $data['doc_desc'] = trim($doc_desc);
        if($doc_public_url !== FALSE) $data['doc_public_url'] = trim($doc_public_url);
        if($doc_file_name !== FALSE) $data['doc_file_name'] = trim($doc_file_name);
        if($doc_status !== FALSE) $data['doc_status'] = $doc_status;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $doc_id = FALSE,
                            $doc_name = FALSE,
                            $doc_desc = FALSE,
                            $doc_public_url = FALSE,
                            $doc_file_name = FALSE,
                            $doc_status = FALSE){
        $data = array();
        if($doc_name !== FALSE) $data['doc_name'] = trim($doc_name);
        if($doc_desc !== FALSE) $data['doc_desc'] = trim($doc_desc);
        if($doc_public_url !== FALSE) $data['doc_public_url'] = trim($doc_public_url);
        if($doc_file_name !== FALSE) $data['doc_file_name'] = trim($doc_file_name);
        if($doc_status !== FALSE) $data['doc_status'] = $doc_status;
        
        return $this->db->update($this->table_name,$data,'doc_id = '.$doc_id);
    }



    
    public function init_datatable($filter_cols=array(), $order_cols=array(),$callback_addparam = NULL){
		//dt parameter for indexing
		$col_datatable = array(
			array('db' => 'doc_id', 	'dt' => 0, 'search' => false),
			array('db' => 'doc_name', 	'dt' => 2, 'search' => true),
			array('db' => 'doc_desc', 	'dt' => 3, 'search' => true),
			array('db' => 'doc_public_url', 	'dt' => 4, 'search' => true),
			array('db' => 'doc_status', 	'dt' => 5, 'search' => true)

		);

		$this->process_datatable($col_datatable,implode(" AND ",$filter_cols),implode(" , ",$order_cols),$callback_addparam);
	}
    


}