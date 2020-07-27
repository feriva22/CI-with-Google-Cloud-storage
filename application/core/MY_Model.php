<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model{

    protected $pk_col = '';
	protected $table_name = '';

	protected $default_select = TRUE;

    public function __construct()
    { parent::__construct(); }
    
    public function custom_query($query,$is_read = TRUE){
		$query_result = $this->db->query($query);
		if($is_read)
			return $query_result->result();
	}
	
	public function get_last_id(){
		$result = $this->get("",$this->pk_col.' desc',1);
		if($result !== NULL){
			return $result->{$this->pk_col};
		}else{
			return 0; //default if table empty return 0
		}
	}
    
    public function count_total($where="", $escape=NULL){
		$this->select();
		if($where !== "") $this->db->where($where, NULL, $escape);
		//return number of data
		return $this->db->count_all_results();
	}
	
	public function set_select_mode($mode){
		$this->default_select = !($mode === 'detail');
	}
    
    public function get($where="", $order="", $limit=NULL, $offset=NULL, $escape=NULL,$like_col=NULL,$like_val=NULL,$or_like_col=NULL, $or_like_val=NULL){
		$this->select();
		if($order !== "") $this->db->order_by($order, '', $escape);

		if(isset($like_col)){
			$this->db->like($like_col,$like_val);
		}

		if(isset($or_like_col)){
			$this->db->or_like($or_like_col,$or_like_val);
		}
		
		if(!is_exist($limit) && !is_exist($offset)) $this->db->limit($limit, $offset);
		else if(!is_exist($limit)) $this->db->limit($limit);

		if($where !== "") $this->db->where($where, NULL, $escape);

		
		//get data and return it
		$query = $this->db->get();
		$result = $query->result();

		if($limit === 1)
			return count($result) == 0 ? NULL : $result[0];

		return $result;
	}
	
	private function get_datatable($where=NULL,$order=NULL,$callback_addparam = NULL){
		
		$result = $this->get($where,$order);
		
		if($callback_addparam !== NULL){
			$return_value = $callback_addparam($result);
			if($return_value !== NULL){
				$result = $return_value;
			}
		}
        
        echo json_encode(array(
            'data' => $result,
            'draw' => $_POST['draw'],
            'recordsTotal' => count($result)
        ));
        exit;
	}
	

	protected function process_datatable($col_datatable = NULL,$where = "",$order = "",$callback_addparam = NULL){
		if(isset($col_datatable) && !is_array($col_datatable) && count($col_datatable) > 0)
			return array();
		
		//GET SEARCH DATA
		$length = $_POST['length'];
		$offset = $_POST['start'];
		$order_idx = isset($_POST['order']) ? $_POST['order'][0]['column'] : "";
		$order_dir = isset($_POST['order']) ? $_POST['order'][0]['dir'] : "";
		$search = trim($_POST['search']['value']);
		$column_param = $_POST['columns'];
		$col_search = "";
		$order_col = "";
		$use_search = false;

		//handling for order and column search
		foreach ($col_datatable as $idx => $item) {
			if($item['search'] && $search !== ""){
				$with_or = $col_search == "" ? "" : " OR ";
				$col_search .= $with_or.$item['db']." LIKE '%$search%'";
				$use_search = true;
			}
			if($order_idx !== "" && $order_idx == $item['dt']){
				$order_col = $order_dir == 'asc' ? $item['db']." ASC" : $item['db']." DESC";
			}
		}

		//add initial value for where if defined
		if($where !== ""){
			$col_search = $where . ($col_search == "" ? "" : " AND ( $col_search ) ");
		}

		//filtering on specific column
		foreach($column_param as $idx => $item){
			if($item['search']['value'] !== ""){
				$use_search = true;
				$this->db->like($item['data'],$item['search']['value']);
			}
		}

		$this->select();

		if($col_search !== ""){
			$this->db->where($col_search); //if not empty so use where
		}
		//ordering data select only one order
		if($order_col !== ""){
			$this->db->order_by($order_col);
		} else {
			$this->db->order_by($order);
		}

		$query = $this->db->get();
		$result = $query->result();

		if($callback_addparam !== NULL){
			$return_value = $callback_addparam($result);
			if($return_value !== NULL){
				$result = $return_value;
			}
		}

		$query_sql = $this->db->last_query();

		if($use_search){
			$record_filtered = count($result);
		} else {
			$record_filtered = $this->count_total($where);
		}
		
		echo json_encode(array(
            'data' => array_slice($result,$offset,$length),
            'draw' => $_POST['draw'],
			'recordsTotal' => $this->count_total($where),
			'recordsFiltered' => $record_filtered,
			'query' => $query_sql
        ));
		exit;
	}

    
    public function get_by_multiple_column($column_definition, $num_return=1, $order_by='', $escape=NULL,$like_col=NULL,$like_val=NULL,$or_like_col=NULL, $or_like_val=NULL){
		//check parameter definition
		if(!is_array($column_definition)) return array();

		if(isset($like_col)){
			$this->db->like($like_col,$like_val);
		}

		if(isset($or_like_col)){
			$this->db->or_like($or_like_col,$or_like_val);
		}

		if(count($column_definition) > 0)
			$this->db->where($column_definition, NULL, $escape);
		$this->select();
		if($order_by !== NULL) $this->db->order_by($order_by, '', $escape);
		if($num_return > 0) $this->db->limit($num_return);

		
		
		$query = $this->db->get();
		$result = $query->result();

		if($num_return === 1){
			return count($result) == 0 ? NULL : $result[0];
		}
		return $result;
    }
    
    public function get_by_column($data, $column='', $num_return=1, $order_by='', $escape=NULL){
		if($column === '')
			$column = $this->pk_col;
		//if no data supplied, return null
		if(empty($data)) return NULL;
		//get data call other method
		return $this->get_by_multiple_column(array($column => $data), $num_return, $order_by, $escape);
    }
    
    public function update_multiple_column($column_data, $id_val, $id_col='', $is_custom_where = FALSE){
		if($id_col == '') $id_col = $this->pk_col;
		return $this->db->update($this->table_name, $column_data, $is_custom_where ? $id_val : "$id_col = '$id_val'");
    }
    
    public function update_single_column($change_column, $change_value, $id_val, $id_col='', $is_custom_where = FALSE){
		return $this->update_multiple_column(array($change_column => $change_value), $id_val, $id_col, $is_custom_where);
	}
	
	public function delete_permanent($id_val,$id_col='', $is_custom_where = FALSE){
		if($id_col == '') $id_col = $this->pk_col;
		return $this->db->delete($this->table_name,$is_custom_where ? $id_val : "$id_col = '$id_val'");
	}
}