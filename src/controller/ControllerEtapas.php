<?php
include_once 'Conexao/Conexao.php';

class ControllerEtapas {

	private $conn = null;
	
	public function cadastrar(Etapas $etapas) {
	
		try {
			
			$sql = "INSERT INTO etapas (porcentagem, nome, custo, status, funcionario_id, contrato_id, porcentagem_total, data_inicio, data_termino)	VALUES 
			('" . $etapas->porcentagem . "', '" . $etapas->nome . "', '". $etapas->custo ."', '" . $etapas->status . "', '" . $etapas->funcionario_id . "', 
			'" . $etapas->contrato_id . "', '" . $etapas->porcentagemTotal . "', '" . $etapas->dataInicio . "', '" . $etapas->dataTermino . "')";
			
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
		
			$sql = "UPDATE etapas SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
		
		$sql = "SELECT * FROM etapas";

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
	
	/*
	public function ListaPeloContrato($idContrato){
		
		$sql = "SELECT * FROM etapas e INNER JOIN contrato c ON(e.contrato_id = c.id) WHERE e.contrato_id = '".$idContrato."'";

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
	*/
	
	//Faz a listagem das etapas, mais verificar se ela ja foi paga
	public function ListaPorEtapas(){
		
		$sql = "SELECT e.nome as nome_etapas, c.nome as nome_contrato, e.id 
				FROM etapas e INNER JOIN contrato c ON(e.contrato_id = c.id) 
				INNER JOIN pagamento_semanal_funcionarios psf ON(e.id = psf.etapas_id)
				WHERE (c.status LIKE 'fase de etapas' OR c.status = 'concluido') AND psf.status = 'a_receber'";

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
	
	//Lista por etapa para o index
	public function listaPorPorcetagem(){
		
		$sql = "SELECT MAX(e.porcentagem_total) as porcentagem_total, c.nome FROM etapas e 
				INNER JOIN contrato c ON(e.contrato_id = c.id) 
				WHERE c.status = 'fase de etapas' GROUP BY e.contrato_id ORDER BY e.id DESC";

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
	

	//Lista por etapa para o index
	public function listaUltimoId(){
		
		$sql = "SELECT id FROM etapas ORDER BY id DESC LIMIT 1";

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
	public function ValidarDados($nome, $idContrato){
		
		$sql = "SELECT * FROM etapas WHERE nome = '".$nome."' AND contrato_id = '".$idContrato."' AND status = 'ativado'";

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
	
	//Retorna a ultima porcetagem para aumentar
	public function RetornaPorcentagemTotal($idContrato){
		
		$sql = "SELECT porcentagem_total FROM etapas WHERE contrato_id = '".$idContrato."' ORDER BY id DESC LIMIT 1";

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