<?php 
require '../File.php';
require 'Users.php';
require 'Brands.php';

class Interactions extends File {
	private $fileUser;
	private $fileBrand;
	private $fileInteractions;
	private $interactions = [];

	function __construct(){
		$users = new Users;
		$brands = new Brands;
		$this->fileUser = $users->get();
		$this->fileBrand = $brands->get();
		$this->fileInteractions = $this->read('metricas-interacao-usuarios/src/interactions.json');
	}

	function findData($name){
		$users_repeated = [];
		foreach($this->fileInteractions as $arr){
			if(!in_array($arr[$name], $users_repeated)){
				$users_repeated[] = $arr[$name];
				$this->interactions[$name][] = ['id' => $arr[$name], 'quantity' => 1];
			} else{
				$quantidade = count($this->interactions[$name]);

				for ($i = 0; $i < $quantidade; $i++) { 
					if($this->interactions[$name][$i]['id'] == $arr[$name]){
						$this->interactions[$name][$i]['quantity'] += 1;
						break;
					}
				}
			}
		}

		$this->findFieldName($name);
	}

    private function findFieldName($name){
		$quantidade_interactions = count($this->interactions[$name]);
		$file = ($name == 'user') ? $this->fileUser : $this->fileBrand;

		for($i = 0; $i < $quantidade_interactions; $i++){
			foreach($file as $key){
				if($this->interactions[$name][$i]['id'] == $key['id']){
					$value = ($name == 'user') ?  $key['name']['first'] . ' ' . $key['name']['last'] : $key['name'];
					$this->interactions[$name][$i]['name'] = $value;
				}	
			}
		}
	}

	function get($name){
		return $this->order($name);
	}

	function order($name){
		$quantity_interactions = count($this->interactions[$name]);
		$ids_repeated = [];
		$array_quantity_interactions_user = [];

		foreach($this->interactions[$name] as $key){
			$array_quantity_interactions_user[] = $key['quantity'];
		}

		arsort($array_quantity_interactions_user);

		foreach($array_quantity_interactions_user as $quantity_value){
			foreach($this->interactions[$name] as $key){
				if($quantity_value == $key['quantity'] && !in_array($key['id'], $ids_repeated)){
					$order[] = ['id' => $key['id'], 'name' => $key['name'], 'quantity' => $key['quantity']];
					$ids_repeated[] = $key['id'];
					array_values($this->interactions[$name]);
					break;
				}
			}
		}

		return $order;
	}
}