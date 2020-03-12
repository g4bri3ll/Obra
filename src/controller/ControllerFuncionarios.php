<?php
include_once 'Conexao/Conexao.php';

class ControllerFuncionarios {

	private $conn = null;
	
	public function cadastrar(Funcionarios $funcionarios) {
	
		try {
			
			$sql = "INSERT INTO funcionarios (nome, telefone, endereco, status, cpf)	VALUES 
			('" . $funcionarios->nome . "', '" . $funcionarios->telefone . "', '". $funcionarios->endereco ."', 
			'" . $funcionarios->status . "', '" . $funcionarios->cpf . "')";
			
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
	public function alterar(Funcionarios $funcionarios) {
		
		try {
			
			$sql = "UPDATE funcionarios SET nome='" . $funcionarios->nome . "', telefone='" . $funcionarios->telefone . "', 
			endereco='" . $funcionarios->endereco . "', cpf='" . $funcionarios->cpf . "' WHERE id = '" . $funcionarios->id . "'";
			
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
		
			$sql = "UPDATE funcionarios SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
		
		$sql = "SELECT * FROM funcionarios WHERE status = 'ativado'";

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
	public function ValidarDados($nome, $telefone, $cpf){
		
		$sql = "SELECT * FROM funcionarios 
		WHERE nome = '".$nome."' 
		AND telefone = '".$telefone."' 
		AND cpf = '".$cpf."'";

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