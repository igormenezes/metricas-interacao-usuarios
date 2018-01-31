<?php 
require '../File.php';
require 'Users.php';

class Interactions extends File {
	private $fileUser;
	private $fileInteractions;
	private $users = [];
	private $brands = [];
	private $interactions = [];
	private $array_quantity_interactions_user;

	function __construct(){
		$users = new Users;
		$this->fileUser = $users->get();
		$this->fileInteractions = $this->read('metricas-interacao-usuarios/src/interactions.json');
	}

	function findData(){
		foreach($this->fileInteractions as $arr){
			if(!in_array($arr['user'], $this->users)){
				$this->users[] = $arr['user'];
				$this->interactions['users'][] = ['id' => $arr['user'], 'quantity' => 1];
			} else{
				$quantidade = count($this->interactions['users']);

				for ($i = 0; $i < $quantidade; $i++) { 
					if($this->interactions['users'][$i]['id'] == $arr['user']){
						$this->interactions['users'][$i]['quantity'] += 1;
						break;
					}
				}
			}

			if(!in_array($arr['brand'], $this->brands)){
				$this->brands[] = $arr['brand'];
				$this->interactions['brands'][] = ['id' => $arr['brand'], 'quantity' => 1];
			}else{
				$quantidade = count($this->interactions['brands']);

				for ($i = 0; $i < $quantidade; $i++) { 
					if($this->interactions['brands'][$i]['id'] == $arr['brand']){
						$this->interactions['brands'][$i]['quantity'] += 1;
						break;
					}
				}
			}
		}

		$this->findNameUser();
	}

    private function findNameUser(){
		$quantidade_interactions = count($this->interactions['users']);

		for($i = 0; $i < $quantidade_interactions; $i++){
			foreach($this->fileUser as $keyUser){
				if($this->interactions['users'][$i]['id'] == $keyUser['id']){
					$this->interactions['users'][$i]['name'] = $keyUser['name']['first'] . ' ' . $keyUser['name']['last'];
				}	
			}
		}
	}

	function get(){
		return $this->order();
	}

	function order(){
		$quantity_interactions = count($this->interactions['users']);
		$ids_repeated = [];

		foreach($this->interactions['users'] as $key){
			$this->array_quantity_interactions_user[] = $key['quantity'];
		}

		arsort($this->array_quantity_interactions_user);

		foreach($this->array_quantity_interactions_user as $quantity_value){
			foreach($this->interactions['users'] as $key){
				if($quantity_value == $key['quantity'] && !in_array($key['id'], $ids_repeated)){
					$order[] = ['id' => $key['id'], 'name' => $key['name'], 'quantity' => $key['quantity']];
					$ids_repeated[] = $key['id'];
					array_values($this->interactions['users']);
					break;
				}
			}
		}

		return $order;
	}
}