<?php
include_once 'Conexao/Conexao.php';

class ControllerDadosObra {

	private $conn = null;
	
	public function cadastrar(DadosObra $dadosObra) {
	
		try {
			
			$sql = "INSERT INTO dados_obra (total_contrato, mao_obra_ser_pago, valor_material_usado, status, contrato_id, lucro)	VALUES 
			('" . $dadosObra->totalContrato . "', '" . $dadosObra->maoObraSerPago . "', '". $dadosObra->valorTotalMaterialUsado ."', 
			'" . $dadosObra->status . "', '" . $dadosObra->contrato_id . "', '" . $dadosObra->totalContrato . "')";
			
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

	//alterando o lucro do contrato por etapas em etapas.php
	public function AlteraLucro($lucro, $idContrato) {
		
		try {
			
			$sql = "UPDATE dados_obra SET lucro='" . $lucro . "' WHERE contrato_id = '" . $idContrato . "'";
			
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
		
			$sql = "UPDATE dados_obra SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
	
	//Lista
	public function lista(){
		
		$sql = "SELECT * FROM dados_obra";

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

	//Lista contrato para altera o lucro para etapas.php e para adicionar_adicionais_obra.php
	public function ListaParaAlteraLucro($idContrato){
		
		$sql = "SELECT lucro FROM dados_obra WHERE contrato_id = '".$idContrato."'";

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