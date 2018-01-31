<?php 

class Users extends File {
 	function get(){
		return $this->read('metricas-interacao-usuarios/src/users.json');
	}
}