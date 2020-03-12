<?php

class Contrato{
	
	private $id;
	private $nome;
	private $valor_total;
	private $cliente_id;
	private $forma_pagamento_id;
	private $status;
	private $data;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}