<?php namespace App\Models\Backoffice;
use CodeIgniter\Model;

class ProfileModel extends Model
{
	public $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
	}
	
	public function getUserData($tblName='', $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->select('*');
		$builder->where($condition);
		$query = $builder->get();
		$data = $query->getResult();
		return $data;
	}
	
	public function updateUserData($tblName='', $data=array(), $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->where($condition);
		$update = $builder->update($data);
		return $update;
	}
	
	public function updateUserPassword($tblName='', $data=array(), $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->where($condition);
		$update = $builder->update($data);
		return $update;
	}
		
}