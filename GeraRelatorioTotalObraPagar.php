<?php
include_once 'src/controller/ControllerContrato.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
<link href="assets/css/custom.css" rel="stylesheet" />
</head>
<body style="background-color: #525659;">

	<div style="padding-top: 30px;">
	
		<div class="col-md-1 col-sm-6 col-xs-6"></div>
		<div class="col-md-10 col-sm-6 col-xs-6" style="background-color: #FFFFFF;" align="center">
		
		<?php

			if (!empty($_POST)){
				$dataInicio = $_POST['dataInicio'];
				$dataFinal = $_POST['dataFinal'];
					
				//Gerando a pagina de relatorio para mostra no pdf
				$conDAO = new ControllerContrato();
				$array = $conDAO->ListaRelatorioMaoObraPagar($dataInicio, $dataFinal);
				
		?>
		<div class="panel-body">
			<div class="table-responsive">
				<h2 style="padding-top: 30px; color: #000000;">Relatorio de mao de obra a pagar</h2><br>
				<table class="table table-striped table-bordered table-hover" id="dataTables-example"
				style="padding-bottom: 40px">
					
					<tr>
						<th>Nome do contrato</th>
						<th>Nome da etapa</th>
						<th>Nome do funcionario</th>
						<th>Total a receber</th>
						<th>data do pagamento</th>
						<th>Porcetagem da etapa</th>
						<th>Data do inicio</th>
						<th>Data Final</th>
					</tr>
					<?php foreach ($array as $conDAO => $dados){ ?>
					<tr class="odd gradeX">
						<td><?php echo $dados['nome_contrato']; ?></td>
						<td><?php echo $dados['nome_etapa']; ?></td>
						<td><?php echo $dados['nome_funcionario']; ?></td>
						<td><?php echo $dados['total_a_receber']; ?></td>
						<td><?php echo $dados['data_pagamento']; ?></td>
						<td><?php echo $dados['porcentagem']; ?></td>
						<td><?php echo $dados['data_inicio']; ?></td>
						<td><?php echo $dados['data_termino']; ?></td>
					</tr>
					<?php } ?>
				
				</table>
			</div>
		</div>
		<?php }//Fecha o post se houver ?>
		
		</div>
		<div class="col-md-1 col-sm-6 col-xs-6"></div>
	</div>

</body>
</html>