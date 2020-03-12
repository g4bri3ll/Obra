<?php
include_once 'Conexao/Conexao.php';

class ControllerContrato {

	private $conn = null;
	
	public function cadastrar(Contrato $contrato) {
	
		try {
			
			$sql = "INSERT INTO contrato (nome, valor_total, status, cliente_id, forma_pagamento_id, data)	VALUES 
			('" . $contrato->nome . "', '" . $contrato->valor_total . "', '" . $contrato->status . "', '" . $contrato->cliente_id . "', 
			'" . $contrato->forma_pagamento_id . "', '" . $contrato->data . "')";
			
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
	public function alterar(Contrato $contrato) {
		
		try {
			
			$sql = "UPDATE contrato SET nome='" . $contrato->nome . "', valor_total='" . $contrato->valor_total . "', 
			cliente_id='" . $contrato->cliente_id . "', forma_pagamento_id='" . $contrato->forma_pagamento_id . "' WHERE id = '" . $contrato->id . "'";
			
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

	//Se o contrato for selecionado na tela de dados_obra.php ele entra em estado de espera
	public function alteraStatusDadosObra($status, $id) {
		
		try {
			
			$sql = "UPDATE contrato SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
		
			$sql = "UPDATE contrato SET status='" . $status . "' WHERE id = '" . $id . "'";
			
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
	
	public function lista(){
		
		$sql = "SELECT * FROM contrato";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}

	//Lista relatorios por total de contrato a pagar
	//Totais de recebimento (venda) 
	public function ListaRelatorioTotalVenda($dataInicio, $dataFinal){
		
		$sql = "SELECT * FROM contrato c INNER JOIN forma_pagamento fp ON(c.forma_pagamento_id = fp.id) 
				WHERE c.data BETWEEN '".$dataInicio."' AND '".$dataFinal."'";

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
	
	//Total de contrto a pagar por etapas
	//Totais a pagar uma previsão até o término das obras..
	public function ListaRelatorioPorEtapas($dataInicio, $dataFinal){
		
		$sql = "SELECT c.nome as nome_c, f.nome as nome_f, e.porcentagem, e.custo, e.data_inicio, e.data_termino 
				FROM contrato c INNER JOIN etapas e ON(c.id = e.contrato_id) 
				INNER JOIN funcionarios f ON(e.funcionario_id = f.id)
				WHERE e.data_inicio >= '".$dataInicio."' AND e.data_termino <= '".$dataFinal."'";

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
	
	//Total de a pagar por mão de obra
	//Total de mão de obra pago
	public function ListaRelatorioMaoObraPagar($dataInicio, $dataFinal){
		
		$sql = "SELECT c.nome as nome_contrato, e.nome as nome_etapa, f.nome as nome_funcionario, psf.total_a_receber,
				psf.data_pagamento, e.porcentagem, e.data_inicio, e.data_termino  
				FROM contrato c INNER JOIN etapas e ON(c.id = e.contrato_id)
				INNER JOIN funcionarios f ON(e.funcionario_id = f.id)
				INNER JOIN pagamento_semanal_funcionarios psf ON(e.id = psf.etapas_id) 
				WHERE psf.data_pagamento BETWEEN '".$dataInicio."' AND '".$dataFinal."'";

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
	
	//Total de custo adicionais por obras
	//Total de custo adicional( pode nomear dessa forma)
	public function ListaRelatorioCustoAdicionais($dataInicio, $dataFinal){
		
		$sql = "SELECT * FROM contrato c INNER JOIN adicionais a ON(c.id = a.contrato_id) 
				WHERE c.data BETWEEN '".$dataInicio."' AND '".$dataFinal."'";

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
	
	//mostra os dados do contrato em andamento
	public function ContratosEmAndamento(){
		
		$sql = "SELECT co.nome, co.valor_total, cl.nome as nome_cliente, co.status FROM contrato co 
			INNER JOIN clientes cl ON(co.cliente_id = cl.id) WHERE co.status = 'fase de etapas' OR co.status = 'aberto'";

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
	public function listaTodosContratoAberto(){
		
		$sql = "SELECT * FROM contrato WHERE status = 'aberto'";

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
	
	public function listaTodosContratoEmAndamento(){
		
		$sql = "SELECT * FROM contrato WHERE status = 'em espera' OR status = 'fase de etapas'";

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
	
	//Lista a quantidade de contrato por periodo
	public function QtdContratosConcluida(){
		
		$sql = "SELECT COUNT(status) as concluido FROM contrato WHERE status LIKE 'concluido'";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resul = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resul)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista a quantidade de contrato por periodo
	public function QtdContratosAberto(){
		
		$sql = "SELECT COUNT(status) as aberto FROM contrato WHERE status LIKE 'aberto'";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resul = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resul)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista a quantidade de contrato por periodo
	public function QtdContratosEmAndamento(){
		
		$sql = "SELECT COUNT(status) as andamento FROM contrato WHERE status LIKE 'em espera' OR status LIKE 'fase de etapas'";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resul = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resul)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista a quantidade totais de contratos
	public function QtdContratosTotais(){
		
		$sql = "SELECT COUNT(status) as totais FROM contrato";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resul = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resul)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista para o listaSetor
	public function ValidarDados($nome){
		
		$sql = "SELECT * FROM contrato WHERE nome = '".$nome."' AND status = 'aberto'";

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