<div class="tab-pane" id="config">
	<?php
        //session_start();
        //require_once ('db.class.php');
        //require_once ('functions.php');
		$objDb = new db();
		$link = $objDb->conecta_mysql();

		$idDocente = $_SESSION['id'];

		$sqlCarregaDadosDocente = "select distinct d.id, d.nome, d.login, date_format(d.datanascimento,'%d %b %Y') as datanascimento, 
                                   case
                                       when d.GENERO = 0 then 'M'
                                       when d.GENERO = 1 then 'F'
                                       when d.GENERO = 2 then 'I'
                                   end as sexo, d.email, d.cell, ifnull(cast(d.resumo as char(5000)), 'Sem resumo informado') as resumo, 
                                   ifnull(d.INSTITUICAO,'Sem instituição informada')as instituicao, d.IDGRAUINSTRUCAO,
                                   gi.descricao as grauInstrucaoDesc, d.RECEBENOTIFICACAO, d.DATANASCIMENTOPUBLICA, d.IDCIDADE, c.descricao as cidDesc,
                                   (select a.datainclusao 
                                      from aula as a 
                                     where IDDOCENTE = d.id 
                                   ORDER BY DATAINCLUSAO desc limit 1) as dtUltimoPost
                                   from docente as d
                                   left join aula as a on a.IDDOCENTE = d.ID
                                   left join grauinstrucao as gi on gi.ID = d.IDGRAUINSTRUCAO
                                   left join cidade as c on c.ID = d.IDCIDADE
                                   where d.id = $idDocente";

		$sqlCarregaInteressesDocente = "select di.IDDOCENTE, d.nome, di.IDINTERESSE, i.descricao
                                        from docenteinteresses as di
                                        inner join docente as d on d.ID = di.IDDOCENTE
                                        inner join interesse as i on i.ID = di.IDINTERESSE
                                        where di.IDDOCENTE = $idDocente";

		$resultado = mysqli_query($link,$sqlCarregaDadosDocente);
		$resultadoInteresses = mysqli_query($link, $sqlCarregaInteressesDocente);

			if($resultado){
				while ($dadosDocente = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
					echo '<div class="box-noborder box-widget-settings widget-user">
						<div class="widget-user-header bg-black"
	                        style="background: url('.retCapa($_SESSION['id']).') center">
							<h3 class="widget-user-username">'.$dadosDocente['nome'].' <i class="fa fa-camera pull-right" data-toggle="modal" data-target="#modalCapa"></i></h3>
						</div>

                        <div class="widget-user-image img-user" id="edit-profile">
                            <div class="profile-user-img img-responsive img-circle" data-toggle="modal" data-target="#modalUser"
                            style="background: url('.retFoto($_SESSION['id']).') center">
                            <i class="fa fa-camera pull-right"></i>
                            </div>
                        </div>
					</div>';

					/* MODAL TROCA IMAGEM USUARIO*/
					echo' <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalUserLabel">
                        <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
				                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                    <h4 class="modal-title" id="exampleModalLabel">Alterar imagem de usuário</h4>
			                    </div>
			                    <div class="modal-body">
				                    <form method="POST" action="salvaFoto.php" enctype="multipart/form-data">
				                        <div class="form-group">
                                            <label class="control-label">Selecione uma imagem:</label>
                                            <input id="imgUser" name="imgUser" type="file" class="file" data-show-upload="false" data-show-caption="true">
                                            <label class="desc-label">Tamanho máximo: 1500kB | Formatos aceitos: JPG, PNG, GIF</label>
                                            <br/>
                                        </div>
				                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				                        <button type="submit" class="btn btn-success">Alterar</button>
			                        </form>
			                    </div>
			                </div>
		                </div>
					</div>';

                    /* MODAL TROCA IMAGEM CAPA/FUNDO*/
                    echo' <div class="modal fade" id="modalCapa" tabindex="-1" role="dialog" aria-labelledby="modalCapaLabel">
                        <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
				                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                    <h4 class="modal-title" id="exampleModalLabel">Alterar imagem de capa</h4>
			                    </div>
			                    <div class="modal-body">
				                    <form method="POST" action="salvaCapa.php" enctype="multipart/form-data">
				                        <div class="form-group">
                                            <label class="control-label">Selecione uma imagem: </label>
                                            <input id="imgCapa" name="imgCapa" type="file" class="file" data-show-upload="false" data-show-caption="true">
                                            <label class="desc-label">Tamanho máximo: 1500kB | Formatos aceitos: JPG, PNG, GIF</label>
                                            <br/>
                                        </div>
				                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				                        <button type="submit" class="btn btn-success">Alterar</button>
			                        </form>
			                    </div>
			                </div>
		                </div>
					</div>';


					echo '<form class="form-horizontal" action="updateDocente.php" method="post">';
						/*-----Nome-----*/
						echo '<div class="form-group">
								<label for="inputNome" class="col-sm-2 control-label">Nome</label>

								<div class="col-sm-10">
									<input type="text" name="nome" class="form-control" id="inputNome" placeholder="Nome e Sobrenome" value="'.$dadosDocente['nome'].'">
								</div>
							  </div>';
						/*-----Login-----*/
						echo '<div class="form-group">
								<label for="inputLogin" class="col-sm-2 control-label">Login</label>

								<div class="col-sm-10">
									<input type="text" name="login" class="form-control" disabled id="inputLogin" placeholder="Login" value="'.$dadosDocente['login'].'">
								</div>
							  </div>';
                        /*-----senha-----*/
                        echo '<div class="form-group">
								<label for="inputSenha" class="col-sm-2 control-label">Senha</label>

								<div class="col-sm-10">
									<input type="password" name="senha" class="form-control" id="inputSenha" placeholder="Alterar Senha">
								</div>
							  </div>';
						/*-----Email-----*/
						echo '<div class="form-group">
								<label for="inputEmail" class="col-sm-2 control-label">Email</label>

								<div class="col-sm-10">
									<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="'.$dadosDocente['email'].'">
								</div>
							  </div>';
						/*-----Sobre-----*/
						echo '<div class="form-group">';
                            echo '<label for="inputSobre" class="col-sm-2 control-label">Sobre mim</label>';

                            echo '<div class="col-sm-10">';
                                echo '<textarea class="form-control" name="about" id="inputSobre" placeholder="Conte-nos sobre você...">'.$dadosDocente['resumo'].'</textarea>';
                            echo '</div>';
                        echo '</div>';
						/*-----DataNasc-----*/
						echo '<div class="form-group">
								<label for="inputDataNasc" class="col-sm-2 control-label">Data Nascimento</label>
								
								<div class="col-sm-10">
								    <input type="text" disabled name="dataNascimento" class="form-control pull-right" id="datepicker" value="'.$dadosDocente['datanascimento'].'">
								</div>
							  </div>';
						/*-----Celular-----*/
                    ?>
						<div class="form-group">
							<label for="inputFone" class="col-sm-2 control-label">Celular</label>

							<div class="col-sm-10">
                                <input type="text" name="cell" class="form-control" id="inputFone" onkeyup="mascara(this,mtel);" maxlength="15" value="<?php echo''.$dadosDocente['cell'].''; ?>">
                            </div>
								
							  </div>
                        <?php
						/*-----Instituição-----*/
						echo '<div class="form-group">
								<label for="inputInstituicao" class="col-sm-2 control-label">Instituição</label>

								<div class="col-sm-10">
								  <input type="text" name="instituicao" class="form-control" id="inputInstituicao" placeholder="Instituição" value="'.$dadosDocente['instituicao'].'">
								</div>
							  </div>';
						/*-----Formação-----*/
						echo '<div class="form-group">
								<label for="inputFormacao" class="col-sm-2 control-label">Formação</label>

								<div class="col-sm-10">
								  <select class="form-control select2" id="inputFormacao" name="inputFormacao" style="width: 100%;">';
                                  echo "<option value = '".$dadosDocente['IDGRAUINSTRUCAO']."'selected>".$dadosDocente['grauInstrucaoDesc']."</option>";
                                  $result = mysqli_query($link, "select id, descricao from grauinstrucao");
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                                        }
								  echo '</select>
								</div>
							  </div>';
						/*-----Cidade-----*/
						echo'<div class="form-group">
								<label for="inputCidade" class="col-sm-2 control-label">Cidade</label>

								<div class="col-sm-10">';
								  $result = mysqli_query($link, "select c.id, c.descricao, c.IDESTADO,
                                                                       concat(c.DESCRICAO,' - ',e.sigla) as city
                                                                       from cidade as c
                                                                       inner join estado as e on e.id = c.IDESTADO;");
									echo '<select class="form-control select2" id="inputCidade" name="inputCidade" style="width: 100%;">';
                                    echo "<option value = '".$dadosDocente['IDCIDADE']."'selected>".$dadosDocente['cidDesc']."</option>";
									while ($row = mysqli_fetch_array($result)) {
										echo "<option value='" . $row['id'] . "'>" . $row['city'] . "</option>";
                                    }
									echo "</select>";
						echo' </div>
							  </div>';
                        /*-----Seleção das áreas de interesse-----*/

                        $sqlComparaDocenteInteresses = "select di.id, di.iddocente, i.descricao
                                                        from docenteinteresses as di 
                                                        inner join interesse as i on i.ID = di.IDINTERESSE
                                                        where di.IDDOCENTE = $idDocente";
                        $resultInteresses = mysqli_query($link, $sqlComparaDocenteInteresses);

                        $inteDocente = mysqli_fetch_array($resultadoInteresses);

                        if($resultadoInteresses){
                            echo '<div class="form-group">
                                <label class="col-sm-2 control-label">Áreas de Interesse</label>
                                <div class="col-sm-10">';

                                    $result = mysqli_query($link, "select id, descricao from interesse order by descricao");

                                    echo '<select class="form-control select2" data-placeholder="Selecione seus interesses" multiple="multiple" name="listInteresses[]" id="interesses" style="width: 100%;">';

                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['descricao'] . "</option>";
                                        }
                                    echo '</select>
                                </div>
                            </div>';
                        }

                    /*echo '<div class="form-group">
                                <label class="col-sm-2 control-label">Áreas de Interesse</label>
                                <div class="col-sm-10">';
                        echo '<select class="form-control select2" multiple="multiple" name="listInteresses[]" id="interesses" style="width: 100%;>';

                        echo '</select>';
                        echo '</div>';
                    echo '</div>';*/

						/*-----Genero-----*/
						if ($dadosDocente['sexo'] == 'M'){
							echo'<div class="form-group">
								<label for="radioGenero" class="col-sm-2 control-label">Gênero</label>

								<div class="col-sm-offset-2-confg col-sm-10" id="radioGenero">
								  <div class="radio">
									<label>
									  <input type="radio" name="radioGenero" id="inputRadioMasculino" value="0" checked> Masculino
									</label>

									<label>
									  <input type="radio" name="radioGenero" id="inputRadioFeminino" value="1"> Feminino
									</label>

									<label>
									  <input type="radio" name="radioGenero" id="inputRadioOutro" value="2"> Outro
									</label>
								  </div>
								</div>
							  </div>';

						 } elseif ($dadosDocente['sexo'] =='F') {
							echo'<div class="form-group">
								<label for="radioGenero" class="col-sm-2 control-label">Gênero</label>

								<div class="col-sm-offset-2-confg col-sm-10" id="radioGenero">
								  <div class="radio">
									<label>
									  <input type="radio" name="radioGenero" id="inputRadioMasculino" value="0"> Masculino
									</label>

									<label>
									  <input type="radio" name="radioGenero" id="inputRadioFeminino" value="1" checked> Feminino
									</label>

									<label>
									  <input type="radio" name="radioGenero" id="inputRadioOutro" value="2"> Outro
									</label>
								  </div>
								</div>
							  </div>';

						}elseif ($dadosDocente['sexo']=='I'){
							echo'<div class="form-group">
								<label for="radioGenero" class="col-sm-2 control-label">Gênero</label>

								<div class="col-sm-offset-2-confg col-sm-10" id="radioGenero">
								  <div class="radio">
									<label>
									  <input type="radio" name="radioGenero" id="inputRadioMasculino" value="0"> Masculino
									</label>

									<label>
									  <input type="radio" name="radioGenero" id="inputRadioFeminino" value="1"> Feminino
									</label>

									<label>
									  <input type="radio" name="radioGenero" id="inputRadioOutro" value="2" checked> Outro
									</label>
								  </div>
								</div>
							  </div>';
						}

						/*-----Opções em Checkbox-----*/
						echo '<div class="form-group">';
						if ($dadosDocente['DATANASCIMENTOPUBLICA']=='1') {
                            echo '<label for="checkDtNascPublica" class="col-sm-2 control-label">Opções:</label>
								<div class="col-sm-offset-2-confg col-sm-10">
								  <div class="checkbox">
									<label>
									  <input type="hidden" id="checkDtNascPublica" name="checkDtNascPublica" value="0">
									  <input type="checkbox" id="checkDtNascPublica" name="checkDtNascPublica" value="1" checked> Data de nascimento pública
									</label>
								  </div>';
                        }
                        if ($dadosDocente['DATANASCIMENTOPUBLICA']=='0') {
                            echo '<label for="checkDtNascPublica" class="col-sm-2 control-label">Opções:</label>
                                    <div class="col-sm-offset-2-confg col-sm-10">
                                      <div class="checkbox">
                                        <label>
                                          <input type="hidden" id="checkDtNascPublica" name="checkDtNascPublica" value="0">
                                          <input type="checkbox" id="checkDtNascPublica" name="checkDtNascPublica" value="1" > Data de nascimento pública
                                        </label>
                                      </div>';
                        }
						if($dadosDocente['RECEBENOTIFICACAO']=='1') {
                            echo '<div class="checkbox">
									<label>
									  <input type="hidden" name="checkReceberNotificacao" id="checkReceberNotificacao" value="0">  
									  <input type="checkbox" name="checkReceberNotificacao" id="checkReceberNotificacao" value="1" checked> Receber Notificações
									</label>
								  </div>
								</div>';
                        }
                        if ($dadosDocente['RECEBENOTIFICACAO']=='0'){
                            echo '<div class="checkbox">
									<label>
									  <input type="hidden" name="checkReceberNotificacao" id="checkReceberNotificacao" value="0">  
									  <input type="checkbox" name="checkReceberNotificacao" id="checkReceberNotificacao" value="1"> Receber Notificações
									</label>
								  </div>
								</div>';
                        }

						echo '</div>';


						/*-----Seleção do tema-----*/
						echo '<div class="form-group">
							  	<label for="selectTema" class="col-sm-2 control-label">Tema:</label>
							  	   <div class="col-sm-10">
                                     <ul class="list-unstyled clearfix" id="selectTema">';
                                        /*-----Azul-----*/
                                        echo'<li style="float:left; width: 6.5%; padding: 5px;">
                                            <a href="javascript:void(0);" data-skin="skin-blue" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                                    <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
                                                <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
                                        </li>';
                                        /*-----Azul-Light-----*/
                                        echo' <li style="float:left; width: 6.5%; padding: 5px;">
                                            <a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                                    <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
                                                <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
                                        </li>';
                                        /*-----Verde-----*/
                                        echo '<li style="float:left; width: 6.5%; padding: 5px;">
                                            <a href="javascript:void(0);" data-skin="skin-green" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                                    <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
                                                <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
                                        </li>';
                                        /*-----Verde-Light-----*/
                                        echo '<li style="float:left; width: 6.5%; padding: 5px;">
										    <a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                                    <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
										        <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
										</li>';
                                        /*-----Roxo-----*/
                                        echo '<li style="float:left; width: 6.5%; padding: 5px;">
                                            <a href="javascript:void(0);" data-skin="skin-purple" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                                    <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
                                                <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
                                        </li>';
                                        /*-----Roxo-Light-----*/
                                        echo '<li style="float:left; width: 6.5%; padding: 5px;">
										    <a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                                    <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
										        <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
										</li>';
                                        /*-----Vermelho-----*/
                                        echo '<li style="float:left; width: 6.5%; padding: 5px;">
                                            <a href="javascript:void(0);" data-skin="skin-red" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                                    <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
                                                <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
                                        </li>';
                                        /*-----Vermelho-Light-----*/
                                        echo '<li style="float:left; width: 6.5%; padding: 5px;">
										    <a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                                    <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
										        <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
										</li>';
                                        /*-----Amarelo-----*/
                                        echo'<li style="float:left; width: 6.5%; padding: 5px;">
                                            <a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                                    <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
                                                <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
                                        </li>';
                                        /*-----Amarelo-Light-----*/
										echo'<li style="float:left; width: 6.5%; padding: 5px;">
										    <a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; 
                                                box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                    <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                                    <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                                </div>
										        <div>
                                                    <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                    <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                                </div>
                                            </a>
										</li>
									 </ul>
								   </div>
							    </div>';

						/*-----Botões-----*/
						echo '<div class="box-footer">
								<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalInativa" ><i class="fa fa-user-times"></i> Inativar Conta</button>
								<a href="settings.php" class="btn btn-default">Mostrar Mais</a>
								<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i>  Salvar </button>
							  </div>';

                    /* MODAL INATIVA CONTA antigo NÃO É UTILIZADO - UTILIZADO ABAIXO*/
                    echo' <div class="modal fade" id="modalInativaUsuario" tabindex="-1" role="dialog" aria-labelledby="modalInativaLabel">
                        <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
				                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                    <h4 class="modal-title" id="exampleModalLabel"> Inativar conta </h4>
			                    </div>
			                    <div class="modal-body">
				                    <form method="post" action="desativaDocente.php" >
				                        <div class="form-group">
                                            <label class="control-label"> Deseja realmente Inativar sua conta? </label>
                                            <br/>
                                            <input type="hidden" name="idUsarioSessao" id="idUsarioSessao" value="'.$_SESSION['id'].'"/>
                                            <br/>
				                        </div>
                                    </form>
			                    </div>
			                </div>
		                </div>
					</div>';
                    /*Deixei os dois no código pois desta forma funciona a inativação. Caso o bloco acima seja excluido, o modal de inativação abaixo nao funciona
                    #soDeusSabe #picollo*/
                    /* MODAL INATIVA CONTA*/
                    echo' <div class="modal fade" id="modalInativa" tabindex="-1" role="dialog" aria-labelledby="modalInativaLabel">
                        <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
				                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                    <h4 class="modal-title" id="exampleModalLabel">Inativação de conta</h4>
			                    </div>
			                    <div class="modal-body">
				                    <form method="POST" action="desativaDocente.php" enctype="multipart/form-data">
				                        <div class="form-group">
				                            <input type="hidden" name="idUsarioSessao" id="idUsarioSessao" value="'.$_SESSION['id'].'"/>
                                            <label class="control-label">Deseja realmente inativar sua conta?</label>
                                            <label class="desc-label">Você não poderá mais acessá-la e esta operação não pode ser desfeita.</label>
                                            <br/>
                                        </div>
				                        <button type="button" class="btn btn-primary" data-dismiss="modal">Voltar</button>
				                        <button type="submit" class="btn btn-danger">Inativar e Sair!</button>
			                        </form>
			                    </div>
			                </div>
		                </div>
					</div>';
				}
			}
	?>
</div>