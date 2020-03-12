<?php 
include_once 'src/controller/ControllerEtapas.php';
include_once 'src/controller/ControllerContrato.php';

//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Bahia');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Projeto Obra</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
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
                        <a class="active-menu"  href="index.php"><i class="fa fa-desktop fa-3x"></i> Home</a>
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
                        <a href="pagamento_semanal_funcionarios.php"><i class="fa fa-dollar fa-3x"></i> Pagamento semanal funcionarios </a>
               		</li>
               		<li>
                        <a href="Adicionar_adicionais_obra.php"><i class="fa fa-sitemap fa-3x"></i> Adicionar adicionais nas etapas das obras </a>
               		</li>
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">

                 <!-- /. ROW  -->
                 <?php 
                 $conDAO = new ControllerContrato();
                 $arrayContraCon = $conDAO->QtdContratosConcluida();
                 $conDAO = new ControllerContrato();
                 $arrayContraAber = $conDAO->QtdContratosAberto();
                 $conDAO = new ControllerContrato();
                 $arrayContraEmAnd = $conDAO->QtdContratosEmAndamento();
                 $conDAO = new ControllerContrato();
                 $arrayContraTotais = $conDAO->QtdContratosTotais();
                 
                 $concluido = 0;
                 $aberto = 0;
                 $andamento = 0;
                 $totais = 0;
                 
                 foreach ($arrayContraCon as $conDAO => $con){
                 	$concluido = $con['concluido'];
                 }
                 foreach ($arrayContraAber as $conDAO => $aber){
                 	$aberto = $aber['aberto'];
                 }
                 
                 foreach ($arrayContraEmAnd as $conDAO => $emAnd){
                 	$andamento = $emAnd['andamento'];
                 }
                 foreach ($arrayContraTotais as $conDAO => $tot){
                 	$totais = $tot['totais'];
                 }
                 
                 ?>
                  <hr />
                <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <?php echo $concluido; ?>
                </span>
                <div class="text-box" >
                    <p class="main-text">Contratos</p>
                    <p class="text-muted">Finalizados</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <?php echo $aberto; ?>
                </span>
                <div class="text-box" >
                    <p class="main-text">Contratos</p>
                    <p class="text-muted">Abertos</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <?php echo $andamento; ?>
                </span>
                <div class="text-box" >
                    <p class="main-text">Contratos</p>
                    <p class="text-muted">Em andamento</p>
                </div>
             </div>
		     </div>
		       <div class="col-md-3 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <?php echo $totais; ?>
                </span>
                <div class="text-box" >
                    <p class="main-text">Contratos</p>
                    <p class="text-muted">Totais</p>
                </div>
             </div>
		     </div>
			</div>
			
			
                 <!-- /. ROW  -->
                <hr /> 
                <?php
                	$etaDAO = new ControllerEtapas();
					$recListaPorEtapa = $etaDAO->listaPorPorcetagem();
					if (!empty($recListaPorEtapa)){ 
                ?>
                 <div class="row">
                    <div class="col-md-12" align="center">
                     <h2 style="color: #1E90FF;">Porcetagem de conclusao de cada etapa do contrato em andamento</h2>   
                    </div>
                </div>
                <?php }//fechar a verificação da etapa ?>
                <?php foreach ($recListaPorEtapa as $etaDAO => $valor){ ?>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
	                        <div class="panel-heading">
	                            Nome contrato: <?php echo $valor['nome'];?>
	                        </div>
	                       
	                        <div class="panel-body">
		                       <div class="progress progress-striped active">
							  		<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" 
							  		aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $valor['porcentagem_total'];?>%">
		    							<?php echo $valor['porcentagem_total'];?>%
								  	</div>
								</div>
	                        </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <hr>
                 
				  <!-- /. ROW  -->
                <div class="row">                     
					<div class="col-md-6 col-sm-12 col-xs-12">                     
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            Relatorio de custo total de adicionais
                        </div>
                        <div class="panel-body" align="center">
						    <a href="relatorio_total_custo_adicionais.php"> gerar relatorio </a>
                        </div>
                    </div>            
					</div>
                    <div class="col-md-6 col-sm-12 col-xs-12">                     
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                             Relatorio por etapas do contrato
                        </div>
                        <div class="panel-body" align="center">
                            <a href="relatorio_total_pagar_por_etapas.php"> gerar relatorio </a>
                        </div>
                    </div>            
					</div> 
				</div>
                

				  <!-- /. ROW  -->
                <div class="row">                     
					<div class="col-md-6 col-sm-12 col-xs-12">                     
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                            Relatorio de obra pagar por contrato
                        </div>
                        <div class="panel-body" align="center">
                            <a href="relatorio_total_obra_paga_por_contrato.php"> gerar relatorio </a>
                        </div>
                    </div>            
					</div>
                    <div class="col-md-6 col-sm-12 col-xs-12">                     
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">
                             Relatorio total de venda
                        </div>
                        <div class="panel-body" align="center">
                            <a href="relatorio_total_vendas.php"> gerar relatorio </a>
                        </div>
                    </div>            
					</div> 
				</div>
       
        </div>
                 
               </div>  
                
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
