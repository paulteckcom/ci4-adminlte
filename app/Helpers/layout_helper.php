<?php 
/**
 * [render description]
 * @param  [type] $core [description]
 * @param  [type] $file [description]
 * @param  array  $data [description]
 * @return [type]       [description]
 */
function render($core, $file, $data = [])	{

	$data = array_merge($data, [
		'mainPage' => $file
	]);

	if(method_exists($core,'sessionMsg')) {
		$data['sessionMsg']	= $core->sessionMsg();
	}

	if($core->session->get('apiData')) {
		$data['apiData']	= $core->session->get('apiData');
	}
	echo view('layout/index', $data);
}

/**
 * [checkAuth description]
 * @param  [type] $core [description]
 * @return [type]       [description]
 */
function checkAuth($core) {
	if (! $core->session->isLoggedIn) {
		return false;
	}

	return true;
}
/**
 * [formatArray description]
 * @param  [type] $input [description]
 * @return [type]        [description]
 */
function formatArray($input, $key, $value, $blank = FALSE) {

	if($blank === TRUE) {
		$output[''] = "Please select";
	}
	// check if input data is array
	if(is_array($input) && count($input) > 0) {
		// loop through array
		foreach($input as $i) {
			$output[$i->$key] = $i->$value; 
		}

		return $output;
	}


	return null;
}

function pp($data, $exit = false) {
	echo "<pre>";
	print_r($data);
	echo "<pre>";
	if($exit) 
	{
		exit();
	}
}
