<?php namespace App\Models\Backoffice;
use CodeIgniter\Model;

class PageModel extends Model
{
	public $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
	}
	
	public function getPageData($tblName='', $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->select('*');
		$builder->where($condition);
		$query = $builder->get();
		$data = $query->getResult();
		return $data;
	}
	
	public function updatePageData($tblName='', $data=array(), $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->where($condition);
		$update = $builder->update($data);
		return $update;
	}		
}