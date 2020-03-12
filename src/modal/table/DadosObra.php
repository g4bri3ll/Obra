<?php

class DadosObra{
	
	private $id;
	private $totalContrato;
	private $maoObraSerPago;
	private $valorTotalMaterialUsado;
	private $lucro;
	private $status;
	private $contrato_id;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}