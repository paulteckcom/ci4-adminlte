<?php 

function render($core, $file, $data = [])	{

	$data = array_merge($data, [
		'mainPage' => $file
	]);
	echo view('layout/index', $data);
}

?>