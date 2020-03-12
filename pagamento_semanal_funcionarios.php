<?php
include_once 'src/controller/ControllerPagamentoFuncionarios.php';
include_once 'src/controller/ControllerEtapas.php';
include_once 'src/controller/ControllerFuncionarios.php';
include_once 'src/modal/table/PagamentoSemanalFuncionarios.php';
include_once 'src/controller/ControllerFormaPagamento.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastrar o valor das etapas a pagar dos funcionarios</title>
<!-- BOOTSTRAP STYLES-->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- CUSTOM STYLES-->
<link href="assets/css/custom.css" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans'
	rel='stylesheet' type='text/css' />
</head>
<body>
	<div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><i class="fa fa-shopping-cart fa-1x"></i> da Madeira</a> 
            </div>
    <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"> 
  		<?php echo date("d-m-Y");?>
	</div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="img/logo.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a  href="index.php"><i class="fa fa-desktop fa-3x"></i> Home</a>
                    </li>
                     <li>
                        <a  href="contrato.php"><i class="fa fa-suitcase fa-3x"></i> Contratos </a>
                    </li>
                    <li>
                        <a  href="dados_obra.php"><i class="fa fa-wrench fa-3x"></i> Dados da Obra</a>
                    </li>
						   <li  >
                        <a   href="etapas.php"><i class="fa fa-calendar fa-3x"></i> Etapas</a>
                    </li>	
					                   
                    <li>
                        <a href="#"><i class="fa fa-dedent fa-3x"></i> Cadastro \ Listagem <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="cadastro_clientes.php">Cadastro de clientes</a>
                            </li>
                            <li>
                                <a href="cadastro_funcionarios.php">Cadastro de Funcionarios</a>
                            </li>
                            <li>
                                <a href="cadastra_forma_pagamento.php">Cadastrar forma de pagamento</a>
                            </li>
                            <li>
                                <a href="#">Listagem de Dados<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="lista_clientes.php">Lista de clientes</a>
                                    </li>
                                    <li>
                                        <a href="lista_funcionarios.php">Lista de funcionarios</a>
                                    </li>
                                    <li>
                                        <a href="lista_forma_pagamento.php">Lista forma de pagamento</a>
                                    </li>

                                </ul>
                               
                            </li>
                        </ul>
                      </li>  
                    <li>
                        <a   href="lista_contrato_em_andamento.php"><i class="fa fa-warning fa-3x"></i> Contratos e suas etapas em andamento </a>
               		</li>
               		<li>
                        <a class="active-menu" href="pagamento_semanal_funcionarios.php"><i class="fa fa-dollar fa-3x"></i> Pagamento semanal funcionarios </a>
               		</li>
               		<li>
                        <a href="Adicionar_adicionais_obra.php"><i class="fa fa-sitemap fa-3x"></i> Adicionar adicionais nas etapas das obras </a>
               		</li>
                </ul>
               
            </div>
            
        </nav> 
 				<!-- /. NAV SIDE  -->
		<div id="page-wrapper">
			<div id="page-inner">
				<div class="row">
					<div class="col-md-12">
						<h2>Cadastrar pagamentos funcionarios</h2>
					</div>
				</div>
				
				<hr />
				<!-- /. ROW  -->
				<div class="row">
					<div class="col-md-12">
						<!-- Form Elements -->
						<div class="panel panel-default">
							<div class="panel-heading">Cadastro de pagamento de funcionarios</div>
							
		<?php
		if (!empty($_POST)){
			if (empty($_POST['idFuncionario']) || empty($_POST['totalPagar']) || empty($_POST['dataPgto']) 
			|| empty($_POST['idFormaPagamento']) || empty($_POST['idEtapa'])){
		?>
		<div class="alert alert-error"><font size="3px" color="red"> Campos vazio nao permitido </font></div>
		<?php
			} else {

				$idFuncionario = $_POST['idFuncionario'];
				$totalPagar = $_POST['totalPagar'];
				$dataPgto = $_POST['dataPgto'];
				$idFormaPagamento = $_POST['idFormaPagamento'];
				$idEtapa = $_POST['idEtapa'];
				
				//Lista pelo id
				//E preciso primeiro pegar o id do pagamento que foi cadastrado, a etapa e o id do funcionario para depois alaterar
				$pgtoDAO = new ControllerPagamentoFuncionarios();
				$arraayId = $pgtoDAO->ListaPelosIds($idFuncionario, $idEtapa);
				
				if (count($arraayId) > 0){
					
					$idPgto = 0;
					foreach ($arraayId as $pgtoDAO => $v){
						$idPgto = $v['id'];
					}
					
					$pagamento = new PagamentoSemanalFuncionarios();
					$pagamento->totalPagar = $totalPagar;
					$pagamento->id = $idPgto;
					$pagamento->dataPagamento = $dataPgto;
					$pagamento->forma_pagamento_id = $idFormaPagamento;
					$pagamento->status = 'pg_pendente';
	
					$pgtoDAO = new ControllerPagamentoFuncionarios();
					$result = $pgtoDAO->CadastraPagamento($pagamento);
					
					if($result){
						?> <script type="text/javascript"> alert('Pagamento funcionario cadastrado com sucesso!'); window.location="index.php";  </script> <?php
					} else {
						?><div class="alert alert-error"><font size="3px" color="red"> Erro ao cadastra, causa possivel <?php echo $result; ?></font></div><?php
					}
					
				} else {
					?><div class="alert alert-error"><font size="3px" color="red"> Esse funcionario nao fez essa etapa, verifique e tente novamente</font></div><?php
				}
					
			}

		}//Fecha o if que verifica se o post foi executado
		?>
							
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h3>Informe o valor a ser pago para os funcionarios</h3>
										<form role="form" action="" method="post">
											<div class="form-group">
	                                   		<label for="disabledSelect">Seleciona o Funcionario: </label>
	                                    	<select id="Select" class="form-control" name="idFuncionario">
		                                    	<?php 
													//Lista todos os clientes
													$funDAO = new ControllerFuncionarios();
													$arrayFuncionario = $funDAO->lista();
													foreach ($arrayFuncionario as $funDAO => $funcionario){
												?>
												<option value="<?php echo $funcionario['id']; ?>"><?php echo $funcionario['nome']; ?></option>
												<?php } ?>
		                              		</select>
                                    		</div>
											<div class="form-group">
												<label>Total a pagar:</label> <input name="totalPagar" class="form-control" />
											</div>
											<div class="form-group">
												<label>Data do pagamento:</label> <input type="date" name="dataPgto" class="form-control" />
											</div>
											<div class="form-group">
	                                   		<label for="disabledSelect">Seleciona a forma de pagamento: </label>
	                                    	<select id="Select" class="form-control" name="idFormaPagamento">
		                                    	<?php 
													//Lista todos os clientes
													$pagDAO = new ControllerFormaPagamento();
													$arrayPgto = $pagDAO->lista();
													foreach ($arrayPgto as $pagDAO => $pgto){
												?>
												<option value="<?php echo $pgto['id']; ?>"><?php echo $pgto['tipo_pagamento']; ?></option>
												<?php } ?>
		                              		</select>
                                    		</div>
                                    		<div class="form-group">
	                                   		<label for="disabledSelect">Seleciona a etapa a pagar: </label>
	                                    	<select id="Select" class="form-control" name="idEtapa">
		                                    	<?php 
													//Lista todos os clientes
													$etaDAO = new ControllerEtapas();
													$arrayEtapas = $etaDAO->ListaPorEtapas();
													foreach ($arrayEtapas as $etaDAO => $e){
												?>
												<option value="<?php echo $e['id']; ?>">
													<?php echo "Fase do contrato: "; echo $e['nome_etapas']; echo " | "; echo $e['nome_contrato']; ?>
												</option>
												<?php } ?>
		                              		</select>
                                    		</div>

											<button type="submit" class="btn btn-primary">Salvar</button>
									<button type="reset" class="btn btn-default">Limpar</button>

										</form>


									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Form Elements -->
				</div>
			</div>

		</div>
		<!-- /. PAGE INNER  -->
	</div>
	<!-- /. WRAPPER  -->
	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
	<!-- JQUERY SCRIPTS -->
	<script src="assets/js/jquery-1.10.2.js"></script>
	<!-- BOOTSTRAP SCRIPTS -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- METISMENU SCRIPTS -->
	<script src="assets/js/jquery.metisMenu.js"></script>
	<!-- CUSTOM SCRIPTS -->
	<script src="assets/js/custom.js"></script>


</body>
</html>
