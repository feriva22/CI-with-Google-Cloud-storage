<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_module extends MY_Model {
    protected $pk_col = 'mdl_id';
    protected $table_name = 'module';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('mdl_id');
            $this->db->select('mdl_name');
            $this->db->select('mdl_desc');
            $this->db->select('mdl_relativeurl');
            $this->db->select('mdl_status');
        } 
        else{
            //for detail get like sensitive information
            $this->db->select('mdl_id');
            $this->db->select('mdl_name');
            $this->db->select('mdl_desc');
            $this->db->select('mdl_relativeurl');
            $this->db->select('mdl_status');
        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $mdl_name = FALSE,
                            $mdl_desc = FALSE,
                            $mdl_relativeurl = FALSE,
                            $mdl_status = FALSE
                        ){
        $data = array();
        if($mdl_name !== FALSE) $data['mdl_name'] = trim($mdl_name);
        if($mdl_desc !== FALSE) $data['mdl_desc'] = trim($mdl_desc);
        if($mdl_relativeurl !== FALSE) $data['mdl_relativeurl'] = trim($mdl_relativeurl);
        if($mdl_status !== FALSE) $data['mdl_status'] = $mdl_status;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $mdl_id = FALSE,
                            $mdl_name = FALSE,
                            $mdl_desc = FALSE,
                            $mdl_relativeurl = FALSE,
                            $mdl_status = FALSE){
        $data = array();
        if($mdl_name !== FALSE) $data['mdl_name'] = trim($mdl_name);
        if($mdl_desc !== FALSE) $data['mdl_desc'] = trim($mdl_desc);
        if($mdl_relativeurl !== FALSE) $data['mdl_relativeurl'] = trim($mdl_relativeurl);
        if($mdl_status !== FALSE) $data['mdl_status'] = $mdl_status;
        
        return $this->db->update($this->table_name,$data,'mdl_id = '.$mdl_id);
    }



    
    public function init_datatable($filter_cols=array(), $order_cols=array(),$callback_addparam = NULL){
		//dt parameter for indexing
		$col_datatable = array(
			array('db' => 'mdl_id', 	'dt' => 0, 'search' => false),
			array('db' => 'mdl_name', 	'dt' => 2, 'search' => true),
			array('db' => 'mdl_desc', 	'dt' => 3, 'search' => true),
			array('db' => 'mdl_relativeurl', 	'dt' => 4, 'search' => true),
			array('db' => 'mdl_status', 	'dt' => 5, 'search' => true)

		);

		$this->process_datatable($col_datatable,implode(" AND ",$filter_cols),implode(" , ",$order_cols),$callback_addparam);
	}
    


}