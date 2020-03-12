<?php
include_once 'src/controller/ControllerContrato.php';
include_once 'src/controller/ControllerEtapas.php';
include_once 'src/controller/ControllerFuncionarios.php';
include_once 'src/modal/table/Etapas.php';
include_once 'src/controller/ControllerPagamentoFuncionarios.php';
include_once 'src/controller/ControllerDadosObra.php';

//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Bahia');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastrar as etapas do contrato</title>
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
                        <a href="index.php"><i class="fa fa-desktop fa-3x"></i> Home</a>
                    </li>
                     <li>
                        <a  href="contrato.php"><i class="fa fa-suitcase fa-3x"></i> Contratos </a>
                    </li>
                    <li>
                        <a  href="dados_obra.php"><i class="fa fa-wrench fa-3x"></i> Dados da Obra</a>
                    </li>
						   <li  >
                        <a class="active-menu" href="etapas.php"><i class="fa fa-calendar fa-3x"></i> Etapas</a>
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
                        <a href="pagamento_semanal_funcionarios.php"><i class="fa fa-dollar fa-3x"></i> Pagamento semanal funcionarios </a>
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
						<h2>Cadastrar as etapas do Obra</h2>
						<h5>Welcome a pagina de cadastro das etapas.</h5>

					</div>
				</div>
				
				<hr />
				<!-- /. ROW  -->
				<div class="row">
					<div class="col-md-12">
						<!-- Form Elements -->
						<div class="panel panel-default">
							<div class="panel-heading">Cadastro de etapas da obra</div>
							
		<?php
		if (!empty($_POST)){
			if (empty($_POST['porcetagem']) || empty($_POST['nome']) || empty($_POST['custo']) 
			|| empty($_POST['idContrato']) || empty($_POST['idFuncionario'])){
		?>
		<div class="alert alert-error"><font size="3px" color="red"> Campos vazio nao permitido </font></div>
		<?php
			} else {

				$porcetagem = $_POST['porcetagem'];
				$nome = $_POST['nome'];
				$custo = $_POST['custo'];
				$idContrato = $_POST['idContrato'];
				$idFuncionario = $_POST['idFuncionario'];
				$porcetagemTotal = 0;
				$dataInicio = $_POST['dataInicio'];
				$dataFinal = $_POST['dataFinal'];

				//Verificar se exite alguma porcetagem na etapa do contrato cadastrado
				$etaDAO = new ControllerEtapas();
				$porcetagemT = $etaDAO->RetornaPorcentagemTotal($idContrato);
				if (!empty($porcetagemT)){
					foreach ($porcetagemT as $conDAO =>$valor){
						$vp = $valor['porcentagem_total'];
						$porcetagemTotal = $vp + $porcetagem;
					}
				} else { $porcetagemTotal = $porcetagem; }
				
				//valida se a porcetagem esta abaixo de 100, se tiver ele deixar cadatrar
				if ($porcetagemTotal <= 100){
				
					$etapas = new Etapas();
					$etapas->porcentagem = $porcetagem;
					$etapas->porcentagemTotal = $porcetagemTotal;
					$etapas->nome = $nome;
					$etapas->custo = $custo;
					$etapas->funcionario_id = $idFuncionario;
					$etapas->contrato_id = $idContrato;
					$etapas->status = 'ativado';
					$etapas->dataInicio = $dataInicio;
					$etapas->dataTermino = $dataFinal;
	
					$etaDAO = new ControllerEtapas();
					$result = $etaDAO->cadastrar($etapas);
					
					if($result){
						
						//Diminuir o lucro da empresa cadastrar na fase de dados da obra.
						$dadDAO = new ControllerDadosObra();
						$arrayLucro = $dadDAO->ListaParaAlteraLucro($idContrato);
						$lucro = 0;
						foreach ($arrayLucro as $conDAO => $valorLu){
							$lucro = $valorLu['lucro'] - $custo;
						}
						
						$dadDAO = new ControllerDadosObra();
						$dadDAO->AlteraLucro($lucro, $idContrato);
						
						//Verificar se a porcetagem das etapas chegaram a ser, então muda o status. E finalizar o contrato
						if ($porcetagemTotal === 100){
							$id = $idContrato;
							$status = "concluido";
						} else {
							$id = $idContrato;
							$status = "fase de etapas";
						}
						
						$conDAO = new ControllerContrato();
						$res = $conDAO->alteraStatusDadosObra($status, $id);
						
						if($res){
							//Cadastrar o id da etapa e o funcionario que trabalhar nela
							$idEtapas = 0;
							$status = 'a_receber';

							$etaDAO = new ControllerEtapas();
							$arrayUltimoIdetapas = $etaDAO->listaUltimoId();

							foreach ($arrayUltimoIdetapas as $etaDAO => $value){
								$idEtapas = $value['id'];
							}

							$pfuDAO = new ControllerPagamentoFuncionarios();
							$resultado = $pfuDAO->cadastrarIds($idEtapas, $idFuncionario, $status);


						} else {
							?><div class="alert alert-error"><font size="3px" color="red"> Erro ao cadastra, causa possivel <?php echo $result; ?></font></div><?php
						}

						?><script type="text/javascript"> alert('Etapa do contrato cadastrado com sucesso!'); window.location="etapas.php";  </script><?php
						
					} else {
						?><div class="alert alert-error"><font size="3px" color="red"> Erro ao cadastra, causa possivel <?php echo $result; ?></font></div><?php
					}
					
				} else {
					?><div class="alert alert-error"><font size="3px" color="red"> Esse contrato esta com a porcetagem maior que 100%</font></div><?php
				}

			}

		}//Fecha o if que verifica se o post foi executado
		?>
							
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h3>Informe uma etapa do contrato</h3>
										<form role="form" action="" method="post">
											<div class="form-group">
												<label>Data inicial da etapa:</label> <input type="date" name="dataInicio" class="form-control" />
											</div>
											<div class="form-group">
												<label>Data de entrega da etapa:</label> <input type="date" name="dataFinal" class="form-control" />
											</div>
											<div class="form-group">
												<label>Porcetagem:</label> <input name="porcetagem" class="form-control" />
											</div>
											<div class="form-group">
												<label>Nome:</label> <input name="nome" class="form-control" />
											</div>
											<div class="form-group">
												<label>Custa da etapa:</label> <input name="custo" class="form-control" />
											</div>
											<div class="form-group">
	                                   		<label for="disabledSelect">Seleciona o Contrato: </label>
	                                    	<select id="Select" class="form-control" name="idContrato">
		                                    	<?php 
													//Lista todos os clientes
													$conDAO = new ControllerContrato();
													$arrayContrato = $conDAO->listaTodosContratoEmAndamento();
													foreach ($arrayContrato as $conDAO => $contrato){
												?>
												<option value="<?php echo $contrato['id']; ?>"><?php echo $contrato['nome']; ?></option>
												<?php } ?>
		                              		</select>
                                    		</div>
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
