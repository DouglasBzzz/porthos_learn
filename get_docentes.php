<?php
session_start();

if(!isset($_SESSION['login'])){
    header('Location: index.php?erro=1');
}

require_once ('db.class.php');
require_once ('functions.php');
include ('nFuncoes.php');

$nomeDocente = addslashes($_POST['nome_docente']);
$iddocente = $_SESSION['id'];

$objdb = new db();
$link = $objdb ->conecta_mysql();

//$sql = "SELECT ID, NOME, EMAIL FROM DOCENTE where (NOME like '%$nomeDocente%' or LOGIN like '%$nomeDocente%' or
//        NICKNAME like '%$nomeDocente%') and ID <> '$iddocente' and SITUACAO = 1"; < funcional, apenas alterando para saber quando o usuario ja esata seguind outro. byDouglas

$sql2 = "select DISTINCT d.ID, d.NOME, d.LOGIN, d.EMAIL, s.ID as idTbSeguidores, s.IDSEGUIDO, s.IDSEGUIDOR, 
         s.DATACOMECOUSEGUIR, s.DATADEIXOUDESEGUIR, s.seguindo,
         case
	      when s.seguindo is null then 0
          when s.seguindo = 1 then 1
		 else 0
         end as seguindo2 
         from docente as d
         left join seguidores as s on (s.IDSEGUIDOR = $iddocente and d.ID = s.IDSEGUIDO)
         where (d.NOME like '%$nomeDocente%' or LOGIN like '%$nomeDocente%') and d.ID <> $iddocente and d.ID > 0 and situacao = 1
                group by d.id 
                order by d.NOME, d.id";

$resultadoid = mysqli_query($link, $sql2);

if($resultadoid){
    if(mysqli_num_rows($resultadoid) > 0){
        while($registro = mysqli_fetch_array($resultadoid, MYSQLI_ASSOC)){

            echo '<div class="list-group-item">
            <div class="user-panel">
                <div class="pull-left img-circle img-bordered-sm" 
                    style="background: url('.retFoto($registro['ID']).') center">
                </div>
                <div class="pull-left info dark">
                    <a href="verPerfil.php?idDocente='.$registro['ID'].'">
                        <p class="dark"><strong>'.$registro['NOME'].'</strong></p>
                        <p class="dark"><small>'.$registro['LOGIN'].'</small></p>
                    </a>
                </div>';


            //$seguindo = isset($registro['ID']) && !empty($registro['ID']) ? 'S' : 'N';
            //$seguindo = isset($registro['seguindo2']) == 1 ? 'S':'N';
            if(isset($registro['seguindo2'])&&$registro['seguindo2']==1){
                $seguindo = 'S';
            }else{
                $seguindo = 'N';
            }

            $btnSeguir = 'block';
            $btnDeixarSeguir = 'block';

            if ($seguindo == 'S'){
                $btnSeguir = 'none';
            }else{
                $btnDeixarSeguir='none';
            }

            //echo '<button type="button" class="btn btn-default" id="btn_ver_'.$registro['ID'].'">Ver perfil</button>';
            echo '</br>
                <div class="form-group pull-right"> ';
            echo '<button type="button" class="btn btn-primary btn_seguir pull-right" id="btn_seguir_'.$registro['ID'].'" 
                data-iddocenteseguido="'.$registro['ID'].'" style="display: '.$btnSeguir.'" ><i class="fa fa-user-plus"></i> Seguir</button>';

            echo '<button type="button" style="display:'.$btnDeixarSeguir.'"  class="btn btn-danger btn_deixar_seguir pull-right" 
                id="btn_deixarseguir_'.$registro['ID'].'" data-iddocenteseguido="'.$registro['ID'].'" ><i class="fa fa-user-times"></i> Deixar de seguir</button>';
            echo '</div>';
            echo'</p>';
            echo '<div class="clearfix"></div>
            </div>
        </div>';
        }
    }else{
        echo 'Não há registro de <strong>DOCENTES </strong> para sua busca';
    }

}else{
    echo 'Erro ao consultar usuários...';
}
/*if(mysqli_num_rows($resultadoid) > 0){
    //echo 'oi';
}else{
    echo 'Não há registro de docentes para sua busca...';
}*/
?>