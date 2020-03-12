<?php
include_once 'Conexao/Conexao.php';

class ControllerFormaPagamento {

	private $conn = null;
	
	public function cadastrar(FormaPagamento $formaPagamento) {
	
		try {
			
			$sql = "INSERT INTO forma_pagamento (tipo_pagamento, status) VALUES ('" . $formaPagamento->tipoPagamento . "', '" . $formaPagamento->status . "')";
			
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

	
	//alterar os dados do clientes
	public function alterar(FormaPagamento $formaPagamento) {
		
		try {
			
			$sql = "UPDATE forma_pagamento SET tipo_pagamento='" . $formaPagamento->tipoPagamento . "', 
					status='" . $formaPagamento->telefone . "' WHERE id = '" . $clientes->id . "'";
			
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
		
			$sql = "UPDATE forma_pagamento SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
		
		$sql = "SELECT * FROM forma_pagamento WHERE status = 'ativado'";

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

	//Lista para o listaSetor
	public function ValidarDados($tipoPagamento){
		
		$sql = "SELECT * FROM forma_pagamento WHERE tipo_pagamento = '".$tipoPagamento."' AND status = 'ativado'";

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