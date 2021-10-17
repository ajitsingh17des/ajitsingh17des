<?php
/**
 *
 *Backend Helper for Layout 
 *
 *
 */
use App\Models\Backoffice\CommonModel;
	
function get_state_name($state_id){
	$model = new App\Models\Backoffice\CommonModel;
	$qry = $model->getRowObject('state', 'state_name',array('state_id'=>$state_id));
	return $qry->state_name;
}

function get_city_name($city_id){
	$model = new App\Models\Backoffice\CommonModel;
	$qry = $model->getRowObject('cities', 'city_name',array('id'=>$city_id));
	return $qry->city_name;
}

	
