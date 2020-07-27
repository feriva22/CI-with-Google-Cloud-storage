<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_modulemenu extends MY_Model {
    protected $pk_col = 'mdm_id';
    protected $table_name = 'modulemenu';

    public function __construct()
    { parent::__construct(); }

    public function select(){
        if($this->default_select){
            $this->db->select('mdm_id');
            $this->db->select('mdm_staffgroup');
            $this->db->select('mdm_title');
            $this->db->select('mdm_class');
            $this->db->select('mdm_url');
            $this->db->select('mdm_parent');
            $this->db->select('mdm_group');
            $this->db->select('mdm_order');
            $this->db->select('mdm_status');

        } 
        else{
            //for detail get like sensitive information
            $this->db->select('mdm_id');
            $this->db->select('mdm_staffgroup');
            $this->db->select('mdm_title');
            $this->db->select('mdm_class');
            $this->db->select('mdm_url');
            $this->db->select('mdm_parent');
            $this->db->select('mdm_group');
            $this->db->select('mdm_order');
            $this->db->select('mdm_status');

        }
        $this->db->from($this->table_name);
    }

    public function insert( 
                            $mdm_staffgroup = FALSE,
                            $mdm_title = FALSE,
                            $mdm_class = FALSE,
                            $mdm_url = FALSE,
                            $mdm_parent = FALSE,
                            $mdm_group = FALSE,
                            $mdm_order = FALSE,
                            $mdm_status = FALSE
                        ){
        $data = array();
        if($mdm_staffgroup !== FALSE) $data['mdm_staffgroup'] = $mdm_staffgroup;
        if($mdm_title !== FALSE) $data['mdm_title'] = trim($mdm_title);
        if($mdm_class !== FALSE) $data['mdm_class'] = trim($mdm_class);
        if($mdm_url !== FALSE) $data['mdm_url'] = trim($mdm_url);
        if($mdm_parent !== FALSE) $data['mdm_parent'] = $mdm_parent;
        if($mdm_group !== FALSE) $data['mdm_group'] = trim($mdm_group);
        if($mdm_order !== FALSE) $data['mdm_order'] = $mdm_order;
        if($mdm_status !== FALSE) $data['mdm_status'] = $mdm_status;

        $this->db->insert($this->table_name,$data);
        return $this->db->insert_id();
    }

    public function update( $mdm_id = FALSE,
                            $mdm_staffgroup = FALSE,
                            $mdm_title = FALSE,
                            $mdm_class = FALSE,
                            $mdm_url = FALSE,
                            $mdm_parent = FALSE,
                            $mdm_group = FALSE,
                            $mdm_order = FALSE,
                            $mdm_status = FALSE){
        $data = array();
        if($mdm_staffgroup !== FALSE) $data['mdm_staffgroup'] = $mdm_staffgroup;
        if($mdm_title !== FALSE) $data['mdm_title'] = trim($mdm_title);
        if($mdm_class !== FALSE) $data['mdm_class'] = trim($mdm_class);
        if($mdm_url !== FALSE) $data['mdm_url'] = trim($mdm_url);
        if($mdm_parent !== FALSE) $data['mdm_parent'] = $mdm_parent;
        if($mdm_group !== FALSE) $data['mdm_group'] = trim($mdm_group);
        if($mdm_order !== FALSE) $data['mdm_order'] = $mdm_order;
        if($mdm_status !== FALSE) $data['mdm_status'] = $mdm_status;
        return $this->db->update($this->table_name,$data,'mdm_id = '.$mdm_id);
    }

	public function init_datatable($filter_cols=array(), $order_cols=array(),$callback_addparam = NULL){
		//dt parameter for indexing
		$col_datatable = array(
			array('db' => 'mdm_id', 	'dt' => 0, 'search' => false),
			array('db' => 'mdm_staffgroup', 	'dt' => 2, 'search' => true),
			array('db' => 'mdm_title', 	'dt' => 3, 'search' => true),
			array('db' => 'mdm_class', 	'dt' => 4, 'search' => false),
			array('db' => 'mdm_url', 	'dt' => 5, 'search' => false),
			array('db' => 'mdm_parent', 	'dt' => 6, 'search' => false),
			array('db' => 'mdm_group', 	'dt' => 7, 'search' => false),
			array('db' => 'mdm_order', 	'dt' => 8, 'search' => false),
			array('db' => 'mdm_status', 	'dt' => 9, 'search' => false)



		);

		$this->process_datatable($col_datatable,implode(" AND ",$filter_cols),implode(" , ",$order_cols),$callback_addparam);
	}

    


}