<?php namespace App\Models\Backoffice;
use CodeIgniter\Model;

class CommonModel extends Model
{
	public $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->session = \Config\Services::session();
	}
	
	public function saveRecord($tblName='', $data=array())
	{
		$builder = $this->db->table($tblName);		
		return $builder->insert($data);
	}
	
	/* start get single row object type & array type 17122021 */
    public function getRowObject($tblName='', $fields='*', $cond=array(),$group_by=''){
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		//$this->db->where('Deleted', 0);
		if(!empty($group_by)){$builder->group_by($group_by, $group_by);}
		$qry = $builder->get();
		return $qry->getFirstRow();
	}
    
	public function getRowArray($tblName='', $fields='*', $cond=array(),$group_by=''){
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		//$this->db->where('Deleted', 0);
		if(!empty($group_by)){$builder->group_by($group_by, $group_by);}
		$qry = $builder->get();
		return array_shift($qry->getResultArray());
	}
	/* end get single row 17122021 */
	public function getRows($tblName='', $fields='*', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0)
	{		
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
		return $qry->getResultArray();
	}
	
	public function getRows_new($tblName='', $fields='*', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0,$groupBy_title='')
	{		
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		if($groupBy_title){$builder->groupBy($groupBy_title);}
		$qry = $builder->get();
		return $qry->getResultArray();
	}
	
// 	public function dateDiffInDays($date1, $date2) 
//         { 
//         	// Calculating the difference in timestamps 
//         	$diff = strtotime($date2) - strtotime($date1); 
        	
//         	// 1 day = 24 hours 
//         	// 24 * 60 * 60 = 86400 seconds 
//         	return abs(round($diff / 86400)); 
        
//         }
	
	public function updateRecord($tblName='', $data=array(), $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->where($condition);
		$update = $builder->update($data);
		return $update;
	}
	
	public function deleteRecord($tblName='', $condition=array())
	{
		$builder = $this->db->table($tblName);
		return $builder->delete($condition); 
	}
	
		public function joinTwoTable($tab1, $tab2, $joinCond = "", $cond=array(), $order_by = "",$column="", $limit_from=0, $limit=0, $group_by = "")
    	{
    		$builder = $this->db->table($tab1);
    		if($column!=''){
    			
    			$builder->select($column);
    		}else{
    			$builder->select('*');
    		}
    		$builder->join($tab2,"$joinCond");
    		if(!empty($cond)){$builder->where($cond);}
    		if($order_by){$builder->orderBy($order_by, 'ASC');}
    		if($limit){$builder->limit($limit, $limit_from);}
    		if($group_by){$builder->groupBy($group_by);}
    		$query = $builder->get();
    		return $query->getResultArray();
    	}
	
	public function getRowsWithJoin($tblName='', $fields='*', $jointblName='', $joinOn='', $joinType='', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0)
	{  
		$builder = $this->db->table($tblName);
		$builder->select($fields);
		$builder->join($jointblName, $joinOn, $joinType);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);} 	
		$qry = $builder->get();
		return $qry->getResultArray();
	}
	
	
	public function deletelikeRecord($tblName='', $condition=array(),$form_view)
	{
		$builder = $this->db->table($tblName);	
		$builder->select("*");
		$builder->whereNotIn('form_id', $form_view);
		if(!empty($condition)){$builder->where($condition);}
		 
	    return $builder->delete(); 
	}

	
	function subCategory($tblName='', $fields='*', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0){
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
		return $qry->getResult();
		
    }
	
	public function solveCustomQuery($sql='')
	{
		$qry = $this->db->query($sql);
		return $qry->getResultArray(); 
	} 
	
	
	public function deleteNotinRecord($tblName='', $condition=array(),$form_view)
	{
		$builder = $this->db->table($tblName);	
		$builder->select("*");
		$builder->whereNotIn('calendar_year', $form_view);
		if(!empty($condition)){$builder->where($condition);}
		 
	    return $builder->delete(); 
	}
	
	public function getRowDistinct($tblName='', $fields='', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0)
	{		
		$builder = $this->db->table($tblName);	
		$builder->distinct($fields);
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
		return $qry->getResultArray();
	}
		

	public	function getprogramm_list($tblName='', $fields='*', $cond=array(), $form_view='',  $order_by='', $Order='ASC', $limit_from=0, $limit=0){
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		$builder->whereIn('school_id', $form_view); 
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
		return $qry->getResultArray();
	}

	public function insert_batch($tblName,$data)
	{
		$builder = $this->db->table($tblName);		
		$builder->insertBatch($data);
	}		
}