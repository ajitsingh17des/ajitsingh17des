<?php 
namespace App\Models;
use CodeIgniter\Model;

class CommonModel extends Model
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
	
	public function email_send($from='',$to='',$subject='',$message='',$attachment = ''){
    		$email = \Config\Services::email();
    		$config['protocol'] = "smtp";
    		$config['SMTPHost'] = "project-demo.in";
    		$config['SMTPSecure'] = "tls";
    		$config['SMTPPort'] = "25";
    		$config['SMTPUser'] = "stercoEmail@project-demo.in";
    		$config['SMTPPass'] = "sterco@123$123";
    		$config['charset'] = "utf-8";
    		$config['mailtype'] = "html";
    		$config['newline'] = "\r\n";
    		$email->initialize($config);
    		$email->setFrom('enquiretraining@xebia.com', 'Xebiaacademy');
    		$email->setTo($to);
    		$email->setSubject($subject);
    		$email->attach($attachment);
    	//	$email->setReplyTo('hr@stercodigitex.com', 'Sterco Digitex');
    		$email->setMessage($message);
    		 $return = $email->send();
    		echo $email->printDebugger();
    	}
	
	
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
	
	public function joinThreeTable($tab1, $tab2, $tab3, $joinCond = "", $joinCond2 = "", $cond=array(), $order_by = "",$column="", $limit_from=0, $limit=0, $group_by = "")
	{
		$builder = $this->db->table($tab1);
		if($column!=''){
			
			$builder->select($column);
		}else{
			$builder->select('*');
		}
		$builder->join($tab2,"$joinCond");
		$builder->join($tab3,"$joinCond2");
		if(!empty($cond)){$builder->where($cond);}
		if($order_by){$builder->orderBy($order_by, 'ASC');}
		if($limit){$builder->limit($limit, $limit_from);}
		if($group_by){$builder->groupBy($group_by);}
		$query = $builder->get();
		return $query->getResultArray();
	}
	
	


		
		
		
		function select_record($column_name, $table, $condition="") {
			$this -> db -> select($column_name);
			$this -> db -> from($table);
			if($condition){
				foreach($condition as $k=>$v){
					$this->db->where($k, $v);
				}
			}
			$this -> db -> limit(1);
			$query = $this -> db -> get();
			if ($query -> num_rows() == 1) {
				foreach ($query->result() as $row1) {
				}
				return $row1 -> $column_name;
			} else {
				return false;
			}
		}
		
		
		public function deleteRecord($tblName='', $condition=array())
	{
		$builder = $this->db->table($tblName);
		return $builder->delete($condition); 
	}
	
	
	public function updateRecord($tblName='', $data=array(), $condition=array())
	{
		$builder = $this->db->table($tblName);
		$builder->where($condition);
		$update = $builder->update($data);
		return $update;
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
//         //return "neha";
//         }
	
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
	
	public function solveCustomQuery($sql='')
	{
		$qry = $this->db->query($sql);
		return $qry->getResultArray(); 
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
	
	public function saveRecord($tblName='', $data=array())
	{
		$builder = $this->db->table($tblName);		
		return $builder->insert($data);
	}

			
	

	
}