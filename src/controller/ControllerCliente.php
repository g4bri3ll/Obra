<?php
include_once 'Conexao/Conexao.php';

class ControllerCliente {

	private $conn = null;
	
	public function cadastrar(Clientes $clientes) {
	
		try {
			
			$sql = "INSERT INTO clientes (nome, telefone, endereco, status, cpf, rg, email)	VALUES 
			('" . $clientes->nome . "', '" . $clientes->telefone . "', '". $clientes->endereco ."', '" . $clientes->status . "', '" . $clientes->cpf . "', '" . $clientes->rg . "', '" . $clientes->email . "')";
			
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
	public function alterar(Clientes $clientes) {
		
		try {
			
			$sql = "UPDATE clientes SET nome='" . $clientes->nome . "', telefone='" . $clientes->telefone . "', endereco='" . $clientes->endereco . "', cpf='" . $clientes->cpf . "', rg='" . $clientes->rg . "', email='" . $clientes->email . "' WHERE id = '" . $clientes->id . "'";
			
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
		
			$sql = "UPDATE clientes SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
		
		$sql = "SELECT * FROM clientes WHERE status = 'ativado'";

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

	//Lista somete nome e id
	public function listaNomeId(){
		
		$sql = "SELECT nome, id FROM clientes WHERE status = 'ativado'";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista para o listaSetor
	public function ValidarDados($nome, $telefone, $rg, $cpf, $email){
		
		$sql = "SELECT * FROM clientes 
		WHERE nome = '".$nome."' 
		OR telefone = '".$telefone."' 
		OR rg = '".$rg."' 
		OR cpf = '".$cpf."' 
		OR email = '".$email."'";

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