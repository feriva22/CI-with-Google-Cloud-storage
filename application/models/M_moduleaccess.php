<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_moduleaccess extends MY_Model {
    protected $pk_col = 'mda_id';
    protected $table_name = 'moduleaccess';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('mda_id');
            $this->db->select('mdl_name AS mda_module');
            $this->db->select('sdg_name AS mda_staffgroup');
            $this->db->select('mda_create');
            $this->db->select('mda_read');
            $this->db->select('mda_update');
            $this->db->select('mda_delete');

        } 
        else{
            //for detail get like sensitive information
            $this->db->select('mda_id');
            $this->db->select('mda_module');
            $this->db->select('mda_staffgroup');
            $this->db->select('mda_create');
            $this->db->select('mda_read');
            $this->db->select('mda_update');
            $this->db->select('mda_delete');
        }
        $this->db->from($this->table_name);
        $this->db->join('module','mdl_id = mda_module');
        $this->db->join('staffgroup','sdg_id = mda_staffgroup');
    }

    public function insert( 
                            $mda_module = FALSE,
                            $mda_staffgroup = FALSE,
                            $mda_create = FALSE,
                            $mda_read = FALSE,
                            $mda_update = FALSE,
                            $mda_delete = FALSE
                            ){
        $data = array();
        if($mda_module !== FALSE) $data['mda_module'] = $mda_module;
        if($mda_staffgroup !== FALSE) $data['mda_staffgroup'] = $mda_staffgroup;
        if($mda_create !== FALSE) $data['mda_create'] = $mda_create;
        if($mda_read !== FALSE) $data['mda_read'] = $mda_read;
        if($mda_update !== FALSE) $data['mda_update'] = $mda_update;
        if($mda_delete !== FALSE) $data['mda_delete'] = $mda_delete;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $mda_id = FALSE,
                            $mda_module = FALSE,
                            $mda_staffgroup = FALSE,
                            $mda_create = FALSE,
                            $mda_read = FALSE,
                            $mda_update = FALSE,
                            $mda_delete = FALSE
                            ){
        $data = array();
        if($mda_module !== FALSE) $data['mda_module'] = $mda_module;
        if($mda_staffgroup !== FALSE) $data['mda_staffgroup'] = $mda_staffgroup;
        if($mda_create !== FALSE) $data['mda_create'] = $mda_create;
        if($mda_read !== FALSE) $data['mda_read'] = $mda_read;
        if($mda_update !== FALSE) $data['mda_update'] = $mda_update;
        if($mda_delete !== FALSE) $data['mda_delete'] = $mda_delete;
        
        return $this->db->update($this->table_name,$data,'mda_id = '.$mda_id);
    }



	public function init_datatable($filter_cols=array(), $order_cols=array(),$callback_addparam = NULL){
		//dt parameter for indexing
		$col_datatable = array(
			array('db' => 'mda_id', 	'dt' => 0, 'search' => false),
			array('db' => 'mda_module', 	'dt' => 2, 'search' => true),
			array('db' => 'mda_staffgroup', 	'dt' => 3, 'search' => true),
			array('db' => 'mda_create', 	'dt' => 4, 'search' => false),
			array('db' => 'mda_read', 	'dt' => 5, 'search' => false),
			array('db' => 'mda_update', 	'dt' => 6, 'search' => false),
			array('db' => 'mda_delete', 	'dt' => 7, 'search' => false)


		);

		$this->process_datatable($col_datatable,implode(" AND ",$filter_cols),implode(" , ",$order_cols),$callback_addparam);
	}
    


}