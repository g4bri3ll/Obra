<?php
include_once 'src/controller/ControllerCliente.php';
include_once 'src/controller/ControllerContrato.php';
include_once 'src/controller/ControllerDadosObra.php';
include_once 'src/modal/table/DadosObra.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastra os dados da obra</title>
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
                        <a  class="active-menu"  href="dados_obra.php"><i class="fa fa-wrench fa-3x"></i> Dados da Obra</a>
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
						<h2>Cadastro de dados da obra</h2>
						<h5>Welcome ao cadastro de obras.</h5>

					</div>
				</div>
				<!-- /. ROW  -->
				<hr />
				<div class="row">
					<div class="col-md-12">
						<!-- Form Elements -->
						<div class="panel panel-default">
							<div class="panel-heading">Cadastro</div>
							
		<?php
		if (!empty($_POST)){
			if (empty($_POST['totalContrato']) || empty($_POST['maoObra']) || empty($_POST['valorMaterial']) 
			|| empty($_POST['idContrato'])){
		?>
		<div class="alert alert-error"><font size="3px" color="red"> Campos vazio nao permitido </font></div>
		<?php
			} else {

				$totalContrato = $_POST['totalContrato'];
				$maoObra = $_POST['maoObra'];
				$valorMaterial = $_POST['valorMaterial'];
				$idContrato = $_POST['idContrato'];
				
				//soma os total de mão de obra com o valor do material para saber se o valor do contrato e maior
				$soma = $maoObra + $valorMaterial;
				
				if ($totalContrato > $soma){
					
					$dadosObra = new DadosObra();
					$dadosObra->maoObraSerPago = $maoObra;
					$dadosObra->valorTotalMaterialUsado = $valorMaterial;
					$dadosObra->contrato_id = $idContrato;
					$dadosObra->status = 'ativado';
					$dadosObra->totalContrato = $totalContrato;
	
					$dadDAO = new ControllerDadosObra();
					$result = $dadDAO->cadastrar($dadosObra);
					
					if($result){
						
						$id = $idContrato;
						$status = "em espera";
						
						$conDAO = new ControllerContrato();
						$res = $conDAO->alteraStatusDadosObra($status, $id);
						
						?><script type="text/javascript"> alert('Dados da obra cadastrado com sucesso!'); window.location="etapas.php";  </script><?php
						
					} else {
						?><div class="alert alert-error"><font size="3px" color="red"> Erro ao cadastra, causa possivel <?php echo $result; ?></font></div><?php
					}
				} else {
					?><div class="alert alert-error"><font size="3px" color="red"> O valor da mao de obra e do material a ser usado, nao pode ser maior que o contrato </font></div><?php
				}

			}

		}//Fecha o if que verifica se o post foi executado
		?>
							
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<h3>Informe um novo inicio de obra</h3>
										<form role="form" action="" method="post">
											<div class="form-group">
												<label>Total do contrato:</label> <input name="totalContrato" class="form-control" />
											</div>
											<div class="form-group">
												<label>Mao de obra a ser pago:</label> <input name="maoObra" class="form-control" />
											</div>
											<div class="form-group">
												<label>valor de todo o material a ser usado:</label> <input name="valorMaterial" class="form-control" />
											</div>
                                    		<div class="form-group">
	                                   		<label for="disabledSelect">Contrato: </label>
	                                    	<select id="Select" class="form-control" name="idContrato">
		                                    	<?php 
													//Lista todos os clientes
													$conDAO = new ControllerContrato();
													$arrayContrato = $conDAO->listaTodosContratoAberto();
													foreach ($arrayContrato as $conDAO => $contrato){
												?>
												<option value="<?php echo $contrato['id']; ?>"><?php echo $contrato['nome']; ?></option>
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
