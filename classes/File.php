<?php 

abstract class File {
	protected function read($name){
		$file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $name);
		return json_decode($file, true);
	}
}