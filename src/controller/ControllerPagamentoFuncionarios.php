<?php
include_once 'Conexao/Conexao.php';

class ControllerPagamentoFuncionarios {

	private $conn = null;
	
	/*
	public function cadastrar(PagamentoSemanalFuncionarios $pagamentoSemanalFuncionarios) {
	
		try {
			
			$sql = "INSERT INTO pagamento_semanal_funcionarios (funcionarios_id, nome_funcionarios, total_pagar, status, data_pagamento, forma_pagamento_id, etapas_id)	VALUES 
			('" . $pagamentoSemanalFuncionarios->funcionario_id . "', '" . $pagamentoSemanalFuncionarios->nomeFuncionario . "', '". $pagamentoSemanalFuncionarios->totalPagar ."', 
			'" . $pagamentoSemanalFuncionarios->status . "', '" . $$pagamentoSemanalFuncionarios->dataPagamento . "', '" . $pagamentoSemanalFuncionarios->forma_pagamento_id . "',
			'" . $pagamentoSemanalFuncionarios->etapa_id . "')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
							
			return true;
			
		} catch ( PDOException $e ) {
			return "erro de banco de dados";
		}
			
	}*/

	public function cadastrarIds($idEtapas, $idFuncionarios, $status) {
	
		try {
			
			$sql = "INSERT INTO pagamento_semanal_funcionarios (funcionario_id, status, etapas_id)	VALUES 
			('" . $idFuncionarios . "', '" . $status . "', '". $idEtapas ."')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
							
			return true;
			
		} catch ( PDOException $e ) {
			return "erro de banco de dados";
		}
			
	}

	//alterar os dados de pagamento do cliente, vindo da tela de pagamento_semanal_funcionarios.php
	public function CadastraPagamento(PagamentoSemanalFuncionarios $pagamento) {
		
		try {
			
			$sql = "UPDATE pagamento_semanal_funcionarios SET total_a_receber ='" . $pagamento->totalPagar . "', data_pagamento ='" . $pagamento->dataPagamento . "', 
					forma_pagamento_id ='" . $pagamento->forma_pagamento_id . "', status ='" . $pagamento->status . "' WHERE id = '" . $pagamento->id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return "erro de banco de dados"; 
			
		}
		
	}
	
	
	//deleta pelo id selecionado
	public function CancelarPeloId($status, $id) {

		try {
		
			$sql = "UPDATE pagamento_semanal_funcionarios SET status='" . $status . "' WHERE id = '" . $id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e){
			return "erro de banco de dados";
		}
		
	}
	
	//Lista para o listaSetor
	public function lista(){
		
		$sql = "SELECT * FROM pagamento_semanal_funcionarios";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}

	//Lista pelo id da etapa e funcionario
	public function ListaPelosIds($idFuncionario, $idEtapa){
		
		$sql = "SELECT id FROM pagamento_semanal_funcionarios WHERE funcionario_id = '".$idFuncionario."' AND etapas_id = '".$idEtapa."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
}

?>