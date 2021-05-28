<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 22/09/2017
 * Time: 00:12
 */
    require_once ('db.class.php');


class funcoesAdm{

    function retAulasPublicas(){

        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "SELECT COUNT(*) as nAulas FROM aula where publica = 1";
        if($aulasPublicas = mysqli_query($link, $sql)){
            $nAulasPublicas = mysqli_fetch_array($aulasPublicas);
            if(isset($nAulasPublicas['nAulas'])){
                echo $nAulasPublicas['nAulas'];
            }else{
                echo 'N.A';
            }
        }
    }

    function retAulasPrivadas(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "SELECT COUNT(*) as nAulas FROM aula where publica = 0";
        if($aulasPrivadas = mysqli_query($link, $sql)){
            $nAulasPrivadas = mysqli_fetch_array($aulasPrivadas);
            if(isset($nAulasPrivadas['nAulas'])){
                echo $nAulasPrivadas['nAulas'];
            }else{
                echo 'N.A';
            }
        }
    }

    function retNUsuariosAtivos(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "SELECT COUNT(*) as nUsuarios FROM docente where situacao = 1";
        if($usuariosAtivos = mysqli_query($link, $sql)){
            $nUsuariosAtivos = mysqli_fetch_array($usuariosAtivos);
            if(isset($nUsuariosAtivos['nUsuarios'])){
                echo $nUsuariosAtivos['nUsuarios'];
            }else{
                echo 'N.A';
            }
        }
    }

    function retNComentarios(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "SELECT COUNT(*) as nComentarios FROM comentario";
        if($comentarios = mysqli_query($link, $sql)){
            $nComentarios = mysqli_fetch_array($comentarios);
            if(isset($nComentarios['nComentarios'])){
                echo $nComentarios['nComentarios'];
            }else{
                echo 'N.A';
            }
        }
    }

    function retNAcessos(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select count(*) as nAcessos from logacesso";
        if($acessos = mysqli_query($link, $sql)){
            $nAcessos = mysqli_fetch_array($acessos);
            if(isset($nAcessos['nAcessos'])){
                echo $nAcessos['nAcessos'];
            }else{
                echo 'N.A';
            }
        }
    }

    function retMediaAvaliacoes(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select round(avg(nota),1) as media from avaliacao";
        if($media = mysqli_query($link, $sql)){
            $vlMedio = mysqli_fetch_array($media);
            if(isset($vlMedio['media'])){
                echo $vlMedio['media'];
            }else{
                echo 'N.A';
            }
        }
    }

    function retContatos(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select c.id as idcontato, c.title, c.iddocente, d.nome, d.email, 
                date_format(c.datacomentario, '%Y %m %d %T') as datacontato,
                c.comentario, c.status 
                from contato as c 
                inner join docente as d on d.id = c.iddocente 
                where c.status = 0 and title<>'' and comentario <> ''
                order by c.datacomentario desc";

        if($carregaContatos = mysqli_query($link, $sql)){
            while($contato = mysqli_fetch_array($carregaContatos, MYSQLI_ASSOC)){
                echo '<form action="atualizaContatosAdm.php" method="post">';
                    echo '<hr/>';
                    echo '<div class="list-group-item">';
                    echo '<strong>'.$contato['nome'].'</strong> em: '.$contato['datacontato'].' <strong>Escreveu...: </strong></br>';
                    //echo '</br></br>';
                    echo '<input type="hidden" value="'.$contato['idcontato'].'" name="idContato"/>';
                    echo'<h3>'.$contato['comentario'].'</h3> <br/> <strong>E-mail usuário...: </strong>'.$contato['email'].'</br>';
                    echo '</a>';
                    echo '<p class="list-group-item-text pull-right">';
                    echo '<label class="w3-text-blue">
                            <input type="checkbox" value="1" name="ckStatus" id="idStatus"/>Resolvido
                          </label>';
                    /*if($contato['status']==0){
                        echo '<label class="w3-text-blue"><input type="checkbox" value="1" name="ckStatus" id="idStatus"/>Resolvido</label>';
                    }*/
                    /*if($contato['status']==1){
                        echo '<label class="w3-text-blue"><input type="checkbox" value="1" name="ckStatus" id="idStatus" checked/>Resolvido</label>';
                    }*/
                    echo '<br/>';
                    echo '<input type="submit" class="btn pull-right" value="Resolver"></input>';
                    echo'<div class="clearfix"></div>';
                    //echo '<br/>';
                    echo '</div>';
                    echo '<hr/>';
                echo '</form>';
            }
        }
    }

    function retStats(){
        $objDb = new db();
        $link = $objDb->conecta_mysql();

        $sql = "select * from v_info_statisticas";

        if($carregaConsulta = mysqli_query($link, $sql)){
            $carregaStats = mysqli_fetch_array($carregaConsulta);
            echo "
                    <div class=\"row\">
                                <div class=\"col-lg-2 col-xs-2\">
                                    <!-- small box -->
                                    <div class=\"small-box bg-aqua\">
                                        <div class=\"inner\">
                                            <h3>".$carregaStats['nAulasPublicas']."</h3>

                                            <p>Aulas Públicas</p>
                                        </div>
                                        <div class=\"icon\">
                                            <i class=\"ion ion-ios-bookmarks-outline\"></i>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class=\"col-lg-2 col-xs-2\">
                                        
                                    <div class=\"small-box bg-green\">
                                        <div class=\"inner\">
                                            <h3>
                                                ".$carregaStats['nAulasPrivadas']."
                                                <sup style=\"font-size: 20px\"></sup></h3>

                                            <p>Aulas Privadas</p>
                                        </div>
                                        <div class=\"icon\">
                                            <i class=\"ion ion-ios-bookmarks\"></i>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class=\"col-lg-2 col-xs-2\">
                                    
                                    <div class=\"small-box bg-green\">
                                        <div class=\"inner\">
                                            <h3>
                                            ".$carregaStats['mConteudosAvaliados']."
                                            <sup style=\"font-size: 20px\"></sup></h3>

                                            <p>Média avl. das aulas</p>
                                        </div>
                                        <div class=\"icon\">
                                            <i class=\"ion ion-ios-star-half\"></i>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class=\"col-lg-2 col-xs-2\">
                                    
                                    <div class=\"small-box bg-green\">
                                        <div class=\"inner\">
                                            <h3>
                                            ".$carregaStats['nComentariosEmAula']."
                                                <sup style=\"font-size: 20px\"></sup></h3>

                                            <p>Comentários em aulas</p>
                                        </div>
                                        <div class=\"icon\">
                                            <i class=\"ion ion-chatbubbles\"></i>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class=\"col-lg-2 col-xs-2\">
                                    
                                    <div class=\"small-box bg-yellow\">
                                        <div class=\"inner\">
                                            <h3>".$carregaStats['nUsuariosAtivos']."</h3>

                                            <p>Usuários Ativos</p>
                                        </div>
                                        <div class=\"icon\">
                                            <i class=\"ion ion-ios-people\"></i>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class=\"col-lg-2 col-xs-2\">
                                    
                                    <div class=\"small-box bg-red\">
                                        <div class=\"inner\">
                                            <h3>".$carregaStats['nAcessos']."</h3>

                                            <p>Total Acesos</p>
                                        </div>
                                        <div class=\"icon\">
                                            <i class=\"ion ion-ios-pulse-strong\"></i>
                                        </div>
                                        
                                    </div>
                                </div>
                                <p>
                                </p>
                        </div>";
            echo "<hr>";
            echo "<div class='col-lg-6 col-xs-6'>";
                echo "<br/>";
                echo "<div>
                        <div class='small-box bg-red'>
                            <h3>$carregaStats[aulaMaisAcessada]</h3>
                            <p>Aula Mais Acessada</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-android-done-all\"></i>
                        </div>
                      </div>";
                echo "<hr>";
                echo "<div>
                        <div class='small-box bg-red'>
                            <h3>$carregaStats[aulaMaisComentada]</h3>
                            <p>Aula Mais Comentada</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-chatbubble-working\"></i>
                        </div>
                      </div>";
            echo "</div>";
            echo "<hr>";
            echo "<br/>";
            echo "<div class='col-lg-2 col-xs-2'>
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>".$carregaStats['nAcessosLastDay']."</h3>
                                <p>Acessos Ontem</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-ios-calendar-outline\"></i>
                        </div>
                    </div>
                  </div>
                  <div class='col-lg-2 col-xs-2'>
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>".$carregaStats['nMas']."</h3>
                            <p>Usuários Masc</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-male\"></i>
                        </div>
                    </div>
                  </div>
                  <div class='col-lg-2 col-xs-2'>
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>".$carregaStats['nFem']."</h3>
                                <p>Usuários Fem</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-female\"></i>
                        </div>
                    </div>
                  </div>
                  <div class='col-lg-2 col-xs-2'>
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>".$carregaStats['nInd']."</h3>
                            <p>Usuários Ind</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-transgender\"></i>
                        </div>
                    </div>
                  </div>
                  <div class='col-lg-2 col-xs-2'>
                    <div class='small-box bg-red'>
                        <div class='inner'>
                            <h3>".$carregaStats['mediaSessoes']."</h3>
                                <p>Tempo Médio Logado</p>
                        </div>
                        <div class=\"icon\">
                            <i class=\"ion ion-ios-time\"></i>
                        </div>
                    </div>
                  </div>";
        }else{
            echo 'Não foi possível carregar os dados da View';
        }
    }


}
?>