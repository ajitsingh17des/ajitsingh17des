<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(0);
namespace App\Libraries;
use App\Models\Backoffice\CommonModel;

class MyCustomLibrariesFunctions 
{   
    public $db;
	
	public function __construct(){
	  $this->db = \Config\Database::connect();
	}
	public function getCountry($tblName)
	{
	  return $this->db->query('select * from '.$tblName.' where status=1 order by country_name ASC')->getResultArray();
	}
    
	public function testing()
	{
	  return 'Hello world';
	}
}