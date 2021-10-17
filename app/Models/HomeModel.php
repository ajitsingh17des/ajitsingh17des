<?php 
namespace App\Models;
use CodeIgniter\Model;

class HomeModel extends Model
{
	public $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
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
}