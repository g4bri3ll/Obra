<?php
include_once 'Conexao/Conexao.php';

class ControllerAdicionais {

	private $conn = null;
	
	public function cadastrar(Adicionais $adicionais) {
	
		try {
			
			$sql = "INSERT INTO adicionais (nome_adicional, valor_adicional, etapas_id, status, contrato_id, data_adicional)	VALUES 
			('" . $adicionais->nome_adicionais . "', '" . $adicionais->valor . "', '" . $adicionais->etapas_id . "', 
			'" . $adicionais->status . "', '" . $adicionais->contrato_id . "', '" . $adicionais->data . "')";
			
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

	//deleta pelo id selecionado
	public function CancelarPeloId($status, $id) {

		try {
		
			$sql = "UPDATE adicionais SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
		
		$sql = "SELECT * FROM adicionais";

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