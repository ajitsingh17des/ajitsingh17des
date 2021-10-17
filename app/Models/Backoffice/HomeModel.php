<?php namespace App\Models\Backoffice;
use CodeIgniter\Model;

class HomeModel extends Model
{
	public $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
	}
	
	public function saveRecord($tblName='', $data=array())
	{
		$builder = $this->db->table($tblName);		
		return $builder->insert($data);
	}
	
	public function getRows($tblName='', $fields='*', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0){
		
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
	
		return $qry->getResultArray();
	}
	
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
		
}