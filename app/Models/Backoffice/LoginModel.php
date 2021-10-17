<?php namespace App\Models\Backoffice;
use CodeIgniter\Model;

class LoginModel extends Model
{
	public $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
	}
	
	public function getVerifiedLogin($tblName='', $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->select('id,first_name,last_name,address,emailid,profile_image,country,state,city,contact_no,login_type');
		$builder->where($condition);
		$query = $builder->get();
		$data = $query->getResult();
		
		return $data;
	}
	
	public function solveCustomQuery($sql='')
	{
		$qry = $this->db->query($sql);
		return $qry->getResultArray(); 
	} 
	public function getRows($tblName='',$fields='*',$cond=array(),$order_by='',$Order='ASC',$limit_from=0,$limit=0)
	{
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
		
		return $qry->getResultArray();
	}
	
	public function getRowsWithJoin($tblName='', $fields='*', $jointblName='', $joinOn='', $joinType='', $cond=array(), $order_by='', $Order='ASC', $limit_from=0, $limit=0)
	{  
		$builder = $this->db->table($tblName);
		$builder->select($fields);
		$builder->join($jointblName, $joinOn, $joinType);
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($tblName.'.'.$order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}  
		$qry = $builder->get();
		return $qry->getResultArray();
	}
	
	public function getWherein($tblName='',$fields='*',$cond=array(),$where_in=array(), $order_by='',$Order='ASC',$limit_from=0,$limit=0)
	{
		$builder = $this->db->table($tblName);	
		$builder->select($fields);
		if(!empty($where_in)){$builder->whereIn('id', $where_in);}
	    if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, $Order);}
		if($limit){$builder->limit($limit, $limit_from);}
		$qry = $builder->get();
		
		return $qry->getResultArray();
	}
	
	public function saveRecord($tblName='', $data=array())
	{
		$builder = $this->db->table($tblName);		
		return $builder->insert($data);
	}
	
	public function updateRecord($tblName='', $data=array(), $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->where($condition);
		$update = $builder->update($data);
		return $update;
	}
	
	
	
	
	
	
	
		
}