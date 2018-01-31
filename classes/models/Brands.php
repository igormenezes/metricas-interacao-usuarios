<?php 

class Brands extends File {
 	function get(){
		return $this->read('metricas-interacao-usuarios/src/brands.json');
	}
}