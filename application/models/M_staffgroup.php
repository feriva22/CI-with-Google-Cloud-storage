<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_staffgroup extends MY_Model {
    protected $pk_col = 'sdg_id';
    protected $table_name = 'staffgroup';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('sdg_id');
            $this->db->select('sdg_name');
            $this->db->select('sdg_desc');
            $this->db->select('sdg_status');

        } 
        else{
            //for detail get like sensitive information
            $this->db->select('sdg_id');
            $this->db->select('sdg_name');
            $this->db->select('sdg_desc');
            $this->db->select('sdg_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $sdg_name    = FALSE,
                            $sdg_desc    = FALSE,
                            $sdg_status   = FALSE,
                            $sdg_password = FALSE
                            
                            ){
        $data = array();
        if($sdg_name   !== FALSE) $data['sdg_name'] = trim($sdg_name);
        if($sdg_desc   !== FALSE) $data['sdg_desc'] = trim($sdg_desc);
        if($sdg_status  !== FALSE) $data['sdg_status'] = trim($sdg_status);

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $sdg_id = FALSE,
                            $sdg_name    = FALSE,
                            $sdg_desc    = FALSE,
                            $sdg_status   = FALSE
                            ){
        $data = array();
        if($sdg_name   !== FALSE) $data['sdg_name'] = trim($sdg_name);
        if($sdg_desc   !== FALSE) $data['sdg_desc'] = trim($sdg_desc);
        if($sdg_status  !== FALSE) $data['sdg_status'] = trim($sdg_status);
        
        return $this->db->update($this->table_name,$data,'sdg_id = '.$sdg_id);
    }


    public function init_datatable($filter_cols=array(), $order_cols=array(),$callback_addparam = NULL){
		//dt parameter for indexing
		$col_datatable = array(
			array('db' => 'sdg_id', 	'dt' => 0, 'search' => false),
			array('db' => 'sdg_name', 	'dt' => 2, 'search' => true),
			array('db' => 'sdg_desc', 	'dt' => 3, 'search' => true),
			array('db' => 'sdg_status', 	'dt' => 4, 'search' => true)
		);

		$this->process_datatable($col_datatable,implode(" AND ",$filter_cols),implode(" , ",$order_cols),$callback_addparam);
	}
    


}