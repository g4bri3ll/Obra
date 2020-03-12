<?php

class PagamentoSemanalFuncionarios{
	
	private $id;
	private $funcionario_id;
	private $totalPagar;
	private $dataPagamento;
	private $valorPagamentoEtapa;
	private $forma_pagamento_id;
	private $status;
	private $data_pagamento_etapa;
	private $etapa_id;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}