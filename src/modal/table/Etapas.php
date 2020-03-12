<?php

class Etapas{
	
	private $id;
	private $porcentagem;
	private $porcentagemTotal;
	private $nome;
	private $custo;
	private $funcionario_id;
	private $status;
	private $contrato_id;
	private $dataInicio;
	private $dataTermino;
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}