<?php

$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

?>

<!DOCTYPE HTML>
<!--
	Porthos Learn by Porthos Software LTDA
	Trabalho de conclusão de curso de Bacharelado em Sistemas de Informação
	Faculdade Mater Dei - 2017
-->
<html lang="pt-br">
<head>
    <title>Porthos Learn&trade;</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="mobile-web-app-capable" content="yes">
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109818462-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109818462-1');
    </script>

</head>
<body class="landing">
<div id="page-wrapper">

    <!-- Header -->
    <header id="header" class="alt">
        <h1><a href="index.php"><img src="images/learn-semlogo25.png"/></a></h1>
        <nav id="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="inscrevase.php">Cadastrar</a></li>
                <li><a href="login.php" class="button">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Banner -->
    <section id="banner">
        <h2><img src="images/learn.png"/></h2>
        <h3>Feito para as pessoas que acreditam na educação.</h3>
        <p>Conecte-se com outros educadores para compartilhamento de conteúdos e experiências. É Grátis!</p>
        <ul class="actions">
            <li><a href="login.php" class="button special">Login</a></li>
            <li><a href="inscrevase.php" class="button">Cadastrar</a></li>
        </ul>
    </section>

    <!-- Main -->
    <section id="main" class="container">

        <section class="box special">
            <header class="major">
                <h2>Uma plataforma para compartilhamento
                    <br />
                    de experiências e conhecimento entre educadores</h2>
                <p>Somos uma startup patobranquense que tem o intuito de contribuir com a educação.
                    <br />No Learn você pode compartilhar conteúdo com outros educadores, disseminando conhecimento.</p>
            </header>
            <span class="image featured"><img src="images/pic01.jpg" alt="" /></span>
        </section>

        <section class="box special features">
            <div class="features-row">
                <section>
                    <span class="icon major fa-book accent2"></span>
                    <h3>Publique seu conteúdo</h3>
                    <p>Visualize os conteúdos de outros educadores e publique o seu, para que o Learn fique cada vez mais completo.</p>
                </section>
                <section>
                    <span class="icon major fa-area-chart accent3"></span>
                    <h3>Adicione criatividade</h3>
                    <p>Insira anexos como pdf's, textos, imagens, vídeos, documentos, planilhas... Deixe seu conteúdo mais interessante para despertar o interesse de quem quer aprender!</p>
                </section>
            </div>
            <div class="features-row">
                <section>
                    <span class="icon major fa-comments-o accent4"></span>
                    <h3>Feedback</h3>
                    <p>Avalie os conteúdos que consumir, contribuindo para que o educador busque o aperfeiçoamento de seu material, tornando a educação mais interessante para todos.</p>
                </section>
                <section>
                    <span class="icon major fa-heart-o accent5"></span>
                    <h3>Siga seus interesses</h3>
                    <p>Siga os principais educadores dos assuntos que são mais relevantes para você.</p>
                </section>
            </div>
        </section>

        <div class="row">
            <div class="6u 12u(narrower)">

                <section class="box special">
                    <span class="image featured"><img src="images/pic02.jpg" alt="" /></span>
                    <h3>Cadastro gratuito</h3>
                    <p>Cadastre-se gratuitamente no Learn e comece a disseminar a educação.</p>
                    <!--                    <ul class="actions">-->
                    <!--                        <li><a href="#" class="button alt">Learn More</a></li>-->
                    <!--                    </ul>-->
                </section>

            </div>
            <div class="6u 12u(narrower)">

                <section class="box special">
                    <span class="image featured"><img src="images/pic03.jpg" alt="" /></span>
                    <h3>Educação é tudo</h3>
                    <p>Acreditamos que uma educação melhor pode transformar o mundo. Junte-se a nós e mostre que é possível.</p>
                    <!--                    <ul class="actions">-->
                    <!--                        <li><a href="#" class="button alt">Learn More</a></li>-->
                    <!--                    </ul>-->
                </section>

            </div>
        </div>

    </section>

    <!-- CTA -->
    <section id="cta">
        <h2><img src="images/apoiase.png"/></h2>
        <h2>Torne-se apoiador do Learn</h2>
        <p>Contribuindo com o Learn você receberá benefícios exclusivos e ajuda a melhorar a educação.</p>
        <form action="inscrevase.php" method="get">
            <ul class="actions">
                <li><a href="https://apoia.se/porthos" class="button"><i class="fa fa-check"></i> Quero apoiar!</a></li>
            </ul>
        </form>
<!--        <h2># todospelaeducação</h2>-->
    </section>

    <!-- Footer -->
    <footer id="footer">
        <ul class="icons">
            <li><img src="images/porthos.png"/></li>
        </ul>
        <ul class="copyright">
            <li><b>&copy; Porthos Software.</b> Todos os direitos reservados.</li>
        </ul>
    </footer>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.dropotron.min.js"></script>
<script src="assets/js/jquery.scrollgress.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="assets/js/main.js"></script>

</body>
</html>