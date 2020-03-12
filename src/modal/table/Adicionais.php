<?php

class Adicionais{
	
	private $id;
	private $nome_adicionais;
	private $valor;
	private $contrato_id;
	private $etapas_id;
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