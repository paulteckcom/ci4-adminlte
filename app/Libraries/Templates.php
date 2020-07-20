<?php 
namespace App\Libraries\Templetes;

// Templates class to handle template layout
class Templates	{

	//render layout
	function render($file, $data = [])	{
		$ci = & get_instance();

		$data = array_merge($data, [
			'mainPage' => $file, 
			'sessionMsg' => $ci->sessionMsg()
		]);
		$ci->load->view('layout/index', $data);
	}

}

