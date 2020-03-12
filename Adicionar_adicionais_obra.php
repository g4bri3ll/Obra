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
<title>Adicionais em obras</title>
<!-- BOOTSTRAP STYLES-->
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- FONTAWESOME STYLES-->
<link href="assets/css/font-awesome.css" rel="stylesheet" />
<!-- MORRIS CHART STYLES-->

<!-- CUSTOM STYLES-->
<link href="assets/css/custom.css" rel="stylesheet" />
<!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans'
	rel='stylesheet' type='text/css' />
<!-- TABLE STYLES-->
<link href="assets/js/dataTables/dataTables.bootstrap.css"
	rel="stylesheet" />
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
                        <a class="active-menu" href="Adicionar_adicionais_obra.php"><i class="fa fa-sitemap fa-3x"></i> Adicionar adicionais nas etapas das obras </a>
               		</li>
                </ul>
               
            </div>
            
        </nav> 
		<!-- /. NAV SIDE  -->
		<div id="page-wrapper">
			<div id="page-inner">
				<div class="row">
					<div class="col-md-12">
						<h2>Adicionais</h2>
					</div>
				</div>
				<!-- /. ROW  -->
				<hr />

				<div class="row">
					<div class="col-md-12">
						<!-- Form Elements -->
						<div class="panel panel-default">
							<div class="panel-heading">Cadastro de adicionais em cada etapa em andamento</div>
							
		<?php
		if (!empty($_POST)){
			if (empty($_POST['adicionais']) || empty($_POST['valor']) || empty($_POST['idContrato']) || empty($_POST['idEtapas'])){
				?><div class="alert alert-error"><font size="3px" color="red"> Campos vazio nao permitido </font></div><?php
			} else {

				$adicionais = $_POST['adicionais'];
				$valor = $_POST['valor'];
				$idContrato = $_POST['idContrato'];
				$idEtapas = $_POST['idEtapas'];

				//Pegar a data do computador
				$data = date('Y-m-d');
				
				$adicionais = new Adicionais();
				$adicionais->nome_adicionais = $adicionais;
				$adicionais->status = 'adicionado';
				$adicionais->valor = $valor;
				$adicionais->contrato_id = $idContrato;
				$adicionais->etapas_id = $idEtapas;
				$adicionais->data = $data;
				
				$adiDAO = new ControllerAdicionais();
				$result = $adiDAO->cadastrar($adicionais);
				
				if($result){
					
					//Pegar o total do lucro da empresa para alterar
					$dadDAO = new ControllerDadosObra();
					$arrayLucro = $dadDAO->ListaParaAlteraLucro($idContrato);
					
					//Coloca o total na variavel
					$lucro = 0;
					foreach ($arrayLucro as $dadDAO => $d){
						$lucro = $d['lucro'];
					}
					
					//Altera o valor do lucro
					$dadDAO = new ControllerDadosObra();
					$dadDAO->AlteraLucro($lucro, $idContrato);
					
					?><script type="text/javascript"> alert('Adicionais cadastrado com sucesso!'); window.location="etapas.php";  </script><?php
					
				} else {
					?><div class="alert alert-error"><font size="3px" color="red"> Erro ao cadastra, causa possivel <?php echo $result; ?></font></div><?php
				}

			}

		}//Fecha o if que verifica se o post foi executado
		?>
							
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<form role="form" action="" method="post">
											<div class="form-group">
												<label>Tipo de adicionais:</label> <input name="adicionais" class="form-control" />
											</div>
											<div class="form-group">
												<label>Valor da adicionais:</label> <input name="valor" class="form-control" />
											</div>
											<div class="form-group">
	                                   		<label for="disabledSelect">Seleciona o Contrato: </label>
							                    <select name="idContrato" id="id_categoria" class="form-control">
												<option value="0" >Escolha um contrato</option>
												<?php
													$sql = "SELECT * FROM contrato WHERE status = 'em espera' OR status = 'fase de etapas'";
													
													$conn = new Conexao();		$conn->openConnect();
													
													$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
													$result = mysqli_query($conn->getCon(), $sql); 
													
													$conn->closeConnect ();
													
													while($row = mysqli_fetch_assoc($result) ) {
														echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
													}
												?>
											</select>
                                    		</div>
                                    		<div class="form-group">
	                                   		<label for="disabledSelect">Seleciona a etapa: </label>
								                <select name="idEtapas" id="id_sub_categoria" class="form-control">
													<option value="0" >Escolha a etapa</option>
												</select>
                                    		</div>

											<button type="submit" class="btn btn-primary">Salvar</button>
											<button type="reset" class="btn btn-default">Limpar</button>

										</form>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("jquery", "1.4.2");
</script>
		
<script type="text/javascript">
$(function(){
	$('#id_categoria').change(function(){
		if( $(this).val() ) {
			$('#id_sub_categoria').hide();
			$('.carregando').show();
			$.getJSON('carrega_etapas.php?search=',{id_categoria: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="#">Escolha Subcategoria</option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id + '">' + j[i].nome_sub_categoria + '</option>';
				}	
				$('#id_sub_categoria').html(options).show();
				$('.carregando').hide();
			});
		} else {
			$('#id_sub_categoria').html('<option value="">– Escolha o setor –</option>');
		}
	});
});
</script>


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
	<!-- /. PAGE WRAPPER  -->
	<!-- /. WRAPPER  -->
	<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
	<!-- JQUERY SCRIPTS -->
	<script src="assets/js/jquery-1.10.2.js"></script>
	<!-- BOOTSTRAP SCRIPTS -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- METISMENU SCRIPTS -->
	<script src="assets/js/jquery.metisMenu.js"></script>
	<!-- DATA TABLE SCRIPTS -->
	<script src="assets/js/dataTables/jquery.dataTables.js"></script>
	<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
	<script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
	<!-- CUSTOM SCRIPTS -->
	<script src="assets/js/custom.js"></script>


</body>
</html>
