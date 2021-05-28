<?php

require_once ('db.class.php');

    class functions{

         //ainda sao necessarios ajustes nessa funcao byDouglas 13/08
        function retAulaId($titleAula, $docenteId){

            $objDb = new db();
            $link = $objDb ->conecta_mysql();

            $sqlReturnId = "select distinct a.id as aulaid
                            from aula as a
                            inner join docente as d on d.ID = a.IDDOCENTE
                            where a.TITLE = '".$titleAula."' and a.IDDOCENTE = $docenteId";

            $aulaId = mysqli_query($link,$sqlReturnId);

            if($aulaId){
                while ($nAulas = mysqli_fetch_array($aulaId, MYSQLI_ASSOC)){
                    echo $nAulas['aulaid'];
                }
            }else{
                null;
            }
        }

        function retCountAulas($docenteId){
            $objdb = new db();
            $link = $objdb->conecta_mysql();
            $sqlNaulas = "select count(*) as nAulas from aula where iddocente = $docenteId";
            $resultadoid = mysqli_query($link, $sqlNaulas);
            if ($resultadoid) {
                $dados_usuario = mysqli_fetch_array($resultadoid);
                if (isset($dados_usuario['nAulas'])) {
                    echo $dados_usuario['nAulas'];
                } else {
                    echo '0';
                }
            }
        }

        function retComentariosAula($idAula){
            $objDb = new db();
            $link = $objDb ->conecta_mysql();

            $projetaComentarios="select ac.idcomentario, c.descricao, date_format(c.datacomentario,'%d %b %Y %H %i') as datacomentario, 
                                 ac.idaula, d.id as iddocente, d.nome as nomedocente
                                 from aulacomentarios as ac 
                                 inner join comentario as c on c.id = ac.IDCOMENTARIO
                                 inner join aula as a on a.ID = ac.IDAULA
                                 left join docente as d on d.ID = c.IDDOCENTE
                                 where a.ID = $idAula order by c.DATACOMENTARIO DESC";

            $consulta = mysqli_query($link, $projetaComentarios);

            if($consulta){
                while ($dadosComentarios = mysqli_fetch_array($consulta,MYSQLI_ASSOC)){
                        echo "<li>
                            <i class='fa fa-comments bg-blue'></i>
                            <div class='timeline-item'>
                                <span class='time'><i class='fa fa-clock-o'></i>".$dadosComentarios['datacomentario']."</span>
                                <h3 class='timeline-header'><a href='verPerfil.php?idDocente=".$dadosComentarios['iddocente']."'>".$dadosComentarios['nomedocente']."</a> comentou</h3>
                                <div class='timeline-body'>";
                                    echo $dadosComentarios['descricao'];
                          echo "</div>
                            </div>
                        </li>";
                }
            }
        }

        function retNSeguidores($docenteId){

            $objdb = new db();
            $link = $objdb->conecta_mysql();

            $sqlNseguidos = "select count(*) as nSeguidores 
                             from seguidores 
                             where IDSEGUIDO = $docenteId and DATADEIXOUDESEGUIR is null";

            $resultadoid = mysqli_query($link, $sqlNseguidos);
            if ($resultadoid) {
                $dados_usuario = mysqli_fetch_array($resultadoid);
                if (isset($dados_usuario['nSeguidores'])) {
                    echo $dados_usuario['nSeguidores'];
                } else {
                    echo '0';
                }
            }
        }

        function retNSeguidos($docenteId){
            $objdb = new db();
            $link = $objdb->conecta_mysql();
            $sqlNseguidores = "select count(*) as nSeguindo 
                               from seguidores 
                               where IDSEGUIDOR = $docenteId 
                               and DATADEIXOUDESEGUIR is null";

            $resultadoid = mysqli_query($link, $sqlNseguidores);
            if ($resultadoid) {
                $dados_usuario = mysqli_fetch_array($resultadoid);
                if (isset($dados_usuario['nSeguindo'])) {
                    echo $dados_usuario['nSeguindo'];
                } else {
                    echo '0';
                }
            }

        }

        function retNcomentariosAula($aulaid){
            $objdb = new db();
            $link = $objdb->conecta_mysql();

            $sqlNcomentarios = "select cast(count(IDCOMENTARIO) as char(255)) as nComentariosAula
                                from aulacomentarios where IDAULA = $aulaid ";

            $nComentarios = mysqli_query($link, $sqlNcomentarios);

            if($nComentarios){
                $nComentariosAula = mysqli_fetch_array($nComentarios);
                if (isset($nComentariosAula['nComentariosAula'])){
                    echo 'Comentários('.$nComentariosAula['nComentariosAula'].')';
                    //echo $nComents;
                }else{
                    echo 'Comentários(0)';
                }
            }
        }

        function retCidadeProfile($docenteId){
            $objdb = new db();
            $link = $objdb->conecta_mysql();

            $sqlRetCidade = "select c.descricao, c.id, d.id, d.nome 
                            from docente as d
                            inner join cidade as c on c.ID = d.IDCIDADE
                            where d.ID = $docenteId";

            $retCidade = mysqli_query($link, $sqlRetCidade);

            if($retCidade){
                $sCidade = mysqli_fetch_array($retCidade);
                if(isset($sCidade['descricao'])){
                    echo $sCidade['descricao'];
                }else{
                    echo 'Sem Localidade informada...';
                }
            }
        }

        function retSobreMim($docenteId){
            $objDb = new db();
            $link = $objDb ->conecta_mysql();

            $sqlReturnSobreMim = "select convert(d.resumo, char(5000)) as sobreMim
                                  from docente as d
                                  where d.ID = $docenteId";
            $sobreMim = mysqli_query($link,$sqlReturnSobreMim);

            if ($sobreMim){
                $carregaSobre = mysqli_fetch_array($sobreMim);
                if(isset($carregaSobre['sobreMim'])){
                    echo $carregaSobre['sobreMim'];
                }else{
                    echo 'Sem resumo informado...';
                }

            }
        }

        function retFormacao($docenteId){
            $objDb = new db();
            $link = $objDb ->conecta_mysql();

            $sqlRetFormacao = "select gi.id, gi.descricao
                               from docente as d
                               inner join grauinstrucao as gi on gi.ID = d.IDGRAUINSTRUCAO
                               where d.id = $docenteId";

            $formacaoDocente = mysqli_query($link, $sqlRetFormacao);

            if($formacaoDocente){
                $carregaFormacao = mysqli_fetch_array($formacaoDocente);
                if(isset($carregaFormacao['descricao'])){
                    echo $carregaFormacao['descricao'];
                }else{
                    echo 'Grau de instrução não informado...';
                }
            }
        }

        function retNomeDocente($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlRetNome = "select d.id, d.nome
                           from docente as d
                           where d.ID = $docenteId";

            $nomeDocente = mysqli_query($link, $sqlRetNome);

            if($nomeDocente){
                $carregaNome = mysqli_fetch_array($nomeDocente);

                if(isset($carregaNome['nome'])){
                    echo $carregaNome['nome'];
                }else{
                    echo 'Problema para exibir o nome...';
                }
            }
        }

        function retMediaAula($aulaId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlRetMediaDocente = "select round(avg(nota),1) as mediaAula
                                   from avaliacao where NOTA > 0.0 and IDAULA = $aulaId";

            $retMedia = mysqli_query($link, $sqlRetMediaDocente);

            if($retMedia){
                $carregaMediaDocente = mysqli_fetch_array($retMedia);
                if(isset($carregaMediaDocente['mediaAula']) && $carregaMediaDocente['mediaAula']>0.1){
                    echo $carregaMediaDocente['mediaAula'];
                }else{
                    echo 'x.x';
                }
            }
        }

        function clearId($id){
            $LetraProibi = Array(" ",",",".","'","\"","&","|","!","#","$","¨","*","(",")","`","´","<",">",";","=","+","§","{","}","[","]","^","~","?","%");
            $special = Array('Á','È','ô','Ç','á','è','Ò','ç','Â','Ë','ò','â','ë','Ø','Ñ','À','Ð','ø','ñ','à','ð','Õ','Å','õ','Ý','å','Í','Ö','ý','Ã','í','ö','ã',
                'Î','Ä','î','Ú','ä','Ì','ú','Æ','ì','Û','æ','Ï','û','ï','Ù','®','É','ù','©','é','Ó','Ü','Þ','Ê','ó','ü','þ','ê','Ô','ß','‘','’','‚','“','”','„');
            $clearspc = Array('a','e','o','c','a','e','o','c','a','e','o','a','e','o','n','a','d','o','n','a','o','o','a','o','y','a','i','o','y','a','i','o','a',
                'i','a','i','u','a','i','u','a','i','u','a','i','u','i','u','','e','u','c','e','o','u','p','e','o','u','b','e','o','b','','','','','','');
            $newId = str_replace($special, $clearspc, $id);
            $newId = str_replace($LetraProibi, "", trim($newId));
            return strtolower($newId);
        }

        function retInteressesDocente($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlLevantaInteresses = "select d.id as idDocente, i.id as idInteresse, i.descricao as descInteresse
                                    from docenteinteresses
                                    inner join docente as d on d.ID = docenteinteresses.IDDOCENTE
                                    inner join interesse as i on i.ID = docenteinteresses.IDINTERESSE
                                    where d.ID = $docenteId";

            $interessesDocente = mysqli_query($link, $sqlLevantaInteresses);

            if($interessesDocente){
                while ($reg=mysqli_fetch_array($interessesDocente, MYSQLI_ASSOC)){

                    echo'<span class="label label-primary list-interesses">'. $reg['descInteresse'].'</span> ';

                }
            }

        }

        function retMediaDocente($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlLevantaMediaDocente = "select d.id, d.nome, round(avg(a.nota),1) as media
            from avaliacao as a
            inner join aula on aula.ID = a.IDAULA
            inner join docente as d on d.ID = aula.IDDOCENTE
            where d.ID = $docenteId";

            $sqlMediaDocente = mysqli_query($link, $sqlLevantaMediaDocente);

            if($sqlMediaDocente){
                $mediaDocente = mysqli_fetch_array($sqlMediaDocente);
                if(isset($mediaDocente['media']) && $mediaDocente['media']>0.1){
                    echo $mediaDocente['media'];
                }else{
                    echo 'x.x';
                }
            }
        }

        function retListaSeguidores($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlCarregaSeguidos="select d.id, d.nome, d.email, s.datacomecouseguir
                        from seguidores as s
                        inner join docente as d on d.ID = s.IDSEGUIDOR
                        where s.IDSEGUIDO = $docenteId";

            $carregaSeguidores = mysqli_query($link, $sqlCarregaSeguidos);

            if($carregaSeguidores){

                while($seguidor = mysqli_fetch_array($carregaSeguidores, MYSQLI_ASSOC)){

                    if(isset($seguidor['id']) && $seguidor['id']<>''){
                        $idDocente = $seguidor['id'];
                    }
                    if(isset($seguidor['nome']) && $seguidor['nome']<>''){
                        $nomeSeguidor = $seguidor['nome'];
                    }
                    if(isset($seguidor['email']) && $seguidor['email']<>''){
                        $emailSeguidor = $seguidor['email'];
                    }
                    if(isset($seguidor['datacomecouseguir']) && $seguidor['datacomecouseguir']<>''){
                        $comecouSeguir = $seguidor['datacomecouseguir'];
                    }


                    echo '<div class="list-group-item">
                        <div class="user-panel">
                            <div class="pull-left img-circle img-bordered-sm"
                                style="background: url('.retFoto($seguidor['id']).') center">
                            </div>
                            <div class="pull-left info dark">
                                <a href="verPerfil.php?idDocente='.$idDocente.'">
                                    <p class="dark"><strong>'.$nomeSeguidor.'</strong></p>
                                    <p class="dark"><small>'.$emailSeguidor.'</small></p>
                                </a>
                            </div>
                        </div>
                    </div>';

                }
            }else{
                echo 'ops! tivemos problemas para recuperar seus seguidores...</br>';
            }
        }

        function retListaSeguidos($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlCarregaSeguidos="select d1.id, d1.nome, d1.email, s.datacomecouseguir
                        from seguidores as s
                        inner join docente as d1 on d1.ID = s.IDSEGUIDO
                        inner join docente as d on d.ID = s.IDSEGUIDOR
                        where s.IDSEGUIDOR = $docenteId";

            //echo $sqlCarregaSeguidos;

            $carregaSeguidores = mysqli_query($link, $sqlCarregaSeguidos);

            if($carregaSeguidores){

                while($seguidor = mysqli_fetch_array($carregaSeguidores, MYSQLI_ASSOC)){

                    if(isset($seguidor['id']) && $seguidor['id']){
                        $idDocente = $seguidor['id'];
                    }
                    if(isset($seguidor['nome']) && $seguidor['nome']<>''){
                        $nomeSeguidor = $seguidor['nome'];
                    }
                    if(isset($seguidor['email']) && $seguidor['email']<>''){
                        $emailSeguidor = $seguidor['email'];
                    }
                    if(isset($seguidor['datacomecouseguir']) && $seguidor['datacomecouseguir']<>''){
                        $comecouSeguir = $seguidor['datacomecouseguir'];
                    }
                    //echo '</br>nome do caboclo...'.$nomeSeguidor;

                    echo '<div class="list-group-item">
                        <div class="user-panel">
                            <div class="pull-left img-circle img-bordered-sm"
                                style="background: url('.retFoto($seguidor['id']).') center">
                            </div>
                            <div class="pull-left info dark">
                                <a href="verPerfil.php?idDocente='.$idDocente.'">
                                    <p class="dark"><strong>'.$nomeSeguidor.'</strong></p>
                                    <p class="dark"><small>'.$emailSeguidor.'</small></p>
                                </a>
                            </div>
                        </div>
                    </div>';

                }
            }else{
                echo 'ops! tivemos problemas para recuperar seus seguidores...</br>';
            }
        }

        function criaNotificacaoAula($docenteId, $titleAula){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlSeguindo = "select IDSEGUIDOR 
                            from seguidores 
                            where IDSEGUIDO = (select iddocente 
                                               from aula 
                                               where title = '$titleAula' and iddocente = $docenteId);";

            $carrega = mysqli_query($link, $sqlSeguindo);

            if($carrega){
                while($dadosCarregados = mysqli_fetch_array($carrega, MYSQLI_ASSOC)){
                    $instrucaoInsert = "insert into notificacaodocente(id, IDNOTIFICACAO,IDDOCENTE) VALUES";
                    foreach ($dadosCarregados as $idSeguidor){
                        $idSeguidorr = $idSeguidor;
                        $instrucaoInsert .="(null, (select id from notificacao order by id desc limit 1),'{$idSeguidorr}'),";
                    }
                    $instrucaoInsert = substr($instrucaoInsert,0,-1);

                    if(mysqli_query($link, $instrucaoInsert)){
                        echo 'criou registro em notificaodocente <br/>';
                    }else{
                        echo 'deu ruim pra registrar nas notificaoesdocente...<br/>';
                    }
                }


            }

        }

        function criaNotificacaoComentario($aulaId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlSeguindo = "select distinct IDSEGUIDO
                            from seguidores
                            where IDSEGUIDO = (select iddocente from aula 
                                               where id = $aulaId);";

            try{
                $carrega = mysqli_query($link, $sqlSeguindo);
                if($carrega){
                    while($dadosCarregados = mysqli_fetch_array($carrega, MYSQLI_ASSOC)){
                        $instrucaoInsert = "insert into notificacaodocente (id, idnotificacao, iddocente) values";
                        foreach ($dadosCarregados as $idSeguidor){
                            $idSeguidorr = $idSeguidor;
                            $instrucaoInsert .="(null, (select id from notificacao order by id desc limit 1),'{$idSeguidorr}'),";
                        }
                        $instrucaoInsert = substr($instrucaoInsert,0,-1);

                        if(mysqli_query($link, $instrucaoInsert)){
                            echo "criou o registro em notificacao docente, a partir do comentario...";
                        }else{
                            echo "deu ruim na criacao de notificacao docente, a partir do comentario...";
                        }
                    }
                }
            }catch (Exception $e){
                echo "Houve um problem para retornar a lista de seguidores...: ".$e->getMessage();
            }


        }

        function retNotificoes($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlCarregaNotificacoes = "select DISTINCT nd.id, n.id as idNotificao, n.titulo, n.MENSAGEM, n.dataenvio,
                                       n.IDAULA, nd.IDDOCENTE, d.NOME as NOMEDOCENTE
                                       from notificacao as n
                                       inner join notificacaodocente as nd on nd.IDNOTIFICACAO = n.ID
                                       inner join aula as a on a.ID = n.IDAULA
                                       inner join docente as d on d.ID = a.IDDOCENTE
                                       where (nd.IDDOCENTE in(select idseguidor 
                                                              from seguidores
                                                              inner join docenteconfig as d2 on d2.iddocente = seguidores.IDSEGUIDOR
                                                              where IDSEGUIDOR = $docenteId and (d2.notificacaoaula = 1 or d2.notificacaocomentario = 1 or d2.notificacaoseguidor = 1 or d2.notificacaoavaliacao = 1)) 
                                                              and (nd.DATALEITURA is null)) and a.PUBLICA = 1;";

            $carregaNotificacoes = mysqli_query($link, $sqlCarregaNotificacoes);

            if($carregaNotificacoes){
                while($notificao = mysqli_fetch_array($carregaNotificacoes, MYSQLI_ASSOC)){
                    echo '<li>
                        <a href="verAulaNotificacao.php?idAula='.$notificao['IDAULA'].'&idNotificacaoDocente='.$notificao['id'].'">
                            <h5><i class="fa fa-certificate text-aqua"></i> Nova aula de '.$notificao['NOMEDOCENTE'].'</h5>
                            <h5 class="h5-word-wrap">'.$notificao['titulo'].'</h5>
                        </a>
                    </li>';
                }
//                echo "<li class='footer'><a href='#'>Ver Tudo</a></li>";
            }
        }

        function retNNotificacoes($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sqlCarregaNComentarios = "select count(DISTINCT nd.id, n.id, n.titulo, n.MENSAGEM, n.dataenvio, n.IDAULA, nd.IDDOCENTE) as nNotificacoes
                                       from notificacao as n
                                       inner join notificacaodocente as nd on nd.IDNOTIFICACAO = n.ID
                                       inner join aula as a on a.ID = n.IDAULA
                                       where (nd.IDDOCENTE in(select idseguidor 
                                                              from seguidores
                                                              inner join docenteconfig as d2 
                                                              on d2.id = seguidores.IDSEGUIDOR 
                                                              where IDSEGUIDOR = $docenteId and (d2.notificacaoaula = 1 or d2.notificacaocomentario = 1 or d2.notificacaoseguidor = 1 or d2.notificacaoavaliacao = 1)) and (nd.DATALEITURA is null))and a.PUBLICA = 1";

            $carregaNComentarios = mysqli_query($link, $sqlCarregaNComentarios);

            if($carregaNComentarios){
                $nNotificaoes = mysqli_fetch_array($carregaNComentarios);

                if(isset($nNotificaoes['nNotificacoes'])&&$nNotificaoes['nNotificacoes']>0){
                    $n = $nNotificaoes['nNotificacoes'];
                    echo "<span class='label label-warning'>$n</span>";
                }
            }
        }

        function retFoto($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sql = "select d.id, cast(d.foto as char(255)) as caminhoFoto
                    from docente as d
                    where d.id = $docenteId";

            if($carregaCaminho = mysqli_query($link, $sql)) {
                $caminhoFotoPerfil = mysqli_fetch_array($carregaCaminho);

                $caminho = $caminhoFotoPerfil['caminhoFoto'];
                $idDocente = $caminhoFotoPerfil['id'];
                echo $caminho;

                if($handle = opendir($caminho)){
                    if($entry = readdir($handle)){
                        if($entry !='..'&& $entry !='.'){
                            //echo "<img src='".$caminho."/".$entry."' class='img-circle' alt='User Image'/>";
                            $caminhoFoto = $caminho."/".$entry;
                            return $caminhoFoto;
                        }else{
                            echo 'FODEO';
                        }
                    }
                }else{
                    echo 'FODEU2';
                }
                opendir($caminho);
                $entry = readdir($caminho);
                if ($entry != '..' && $entry != '.') {
                    //echo "<img src='".$caminho."/".$entry."' class='img-circle' alt='User Image'/>";
                    $caminhoFoto = $caminho . "/" . $entry;
                    return $caminhoFoto;
                } else {
                    echo 'FODEO';
                }
            }
        }

        function retSugestoes($docenteId){
            $objDb = new db();
            $link = $objDb->conecta_mysql();

            $sql = "select d.id as docenteid, d.nome, d.email
                    from docente as d
                    where exists(
                            select distinct a.iddocente, avg(av.nota), av.idaula
                            from aula as a
                            inner join avaliacao as av on a.id = av.idaula
                            inner join aulainteresses as ai on ai.idaula = a.id
                            inner join interesse as i on i.id = ai.idinteresse
                            where ((d.id = a.iddocente) and i.id in(
                                select di.idinteresse
                                from docenteinteresses as di
                                where di.iddocente = $docenteId
                            ))	
                            group by av.idaula, a.iddocente, av.idaula 
                            having avg(av.nota) > 4.0
                    ) and d.id <> $docenteId
                    limit 3;";

            try{
                $carregaSugestoes = mysqli_query($link, $sql);
                if($carregaSugestoes){
                    while($sugestao = mysqli_fetch_array($carregaSugestoes,MYSQLI_ASSOC)){
                        echo "<div class='list-group-item'>";

                            echo "<div class='user-panel'>";

                                echo "<div class='pull-left img-circle img-bordered-sm' style='background: url(".retFoto($sugestao['docenteid']).")'>";
                                echo "</div>";

                                echo "<div class='pull-left info dark'>";
                                    echo '<a href="verPerfil.php?idDocente='.$sugestao[docenteid].'">';
                                        echo "<p class='dark'><strong>".$sugestao['nome']."</strong></p>";
                                        echo "<p class='dark'><small>".$sugestao['email']."</small></p>";
                                    echo "</a>";
                                echo "</div>";

                            echo "</div>";

                        echo "</div>";
                    }
                }
            }catch (Exception $e){
                echo "Tivemos problemas para carregar as suas sugestões";
            }



        }
    }
?>