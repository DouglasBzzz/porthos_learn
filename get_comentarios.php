<?php
/**
 * Created by PhpStorm.
 * User: dougl
 * Date: 15/08/2017
 * Time: 23:07
 */

    session_start();
    require_once ('functions.php');

    $idAula = $_SESSION['idAula'];

    $retComentariosAula = new functions();
    $retComentariosAula -> retComentariosAula($idAula);

?>