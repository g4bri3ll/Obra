<?php

class Clientes{
	
	private $id;
	private $nome;
	private $telefone;
	private $endereco;
	private $cpf;
	private $rg;
	private $email;
	private $status;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}