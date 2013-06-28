<?php
include('pdo.php');
session_start();
if($_SESSION['usuario'] == NULL){
    $gbd = NULL;
    header("Location: perfil.php?user=".$_GET['user']."");
}else{
    if(isset($_GET['ser'])){
    $sentence4 = $gbd->prepare("SELECT * FROM registros WHERE user='".$_SESSION['usuario']."'");
    $sentence4->execute();
    $nero = $sentence4->fetch(PDO::FETCH_ASSOC);
    $sentencia = $gbd->prepare("SELECT id FROM registros WHERE user= ?");
    $sentencia->bindParam(1, $_GET['user']);
    $sentencia->execute(); //Te vendría mejor esto
    $iduserrecibe = $sentencia->fetch(PDO::FETCH_ASSOC);
    $sentencia2 = $gbd->prepare("INSERT INTO amigos(iduserpide, iduserrecibe) VALUES(:iduserpide, :iduserrecibe)");
    $sentencia2->bindParam(':iduserpide', $_SESSION['id']);
    $sentencia2->bindParam(':iduserrecibe', $iduserrecibe['id']);
    $sentencia2->execute();
    $sentence = $gbd->prepare("INSERT INTO notificaciones(iduser, idusernot, amigoperfil, razon) VALUES(:iduser, :idusernot, :amigoperfil, :razon)");
    $razon = $nero['nombre']." te ha enviado una petición de amistad.";
    $sentence->bindParam(':iduser', $_SESSION['id']);
    $sentence->bindParam(':idusernot', $iduserrecibe['id']);
    $sentence->bindParam(':amigoperfil', $_SESSION['id']);
    $sentence->bindParam(':razon', $razon);
    $sentence->execute();
    $sentence2 = $gbd->prepare("SELECT * FROM registros WHERE id='".$iduserrecibe['id']."'");
    $sentence2->execute();
    $sentence->execute();
    $nif = $sentence2->fetch(PDO::FETCH_ASSOC);
    $numnotif=$nif['notifreg'] + 1;
    $siria = $gbd->prepare("UPDATE registros SET notifreg='".$numnotif."' WHERE user='".$nif['user']."'");
    $siria->execute();
    $sentence->execute();
    $gbd = NULL;
    header("Location: perfil.php?user=".$_GET['user']."");
    }else{
        if(isset($_GET['noser'])){
            if(!isset($_GET['ser'])){
            $sentence4 = $gbd->prepare("SELECT * FROM registros WHERE user='".$_SESSION['usuario']."'");
            $sentence4->execute();
            $nero = $sentence4->fetch(PDO::FETCH_ASSOC);
            $sentencia = $gbd->prepare("SELECT id FROM registros WHERE user= ?");
            $sentencia->bindParam(1, $_GET['user']);
            $sentencia->execute();
            $iduserrecibe = $sentencia->fetch(PDO::FETCH_ASSOC);
            $sentencia2 = $gbd->prepare("DELETE FROM amigos WHERE iduserpide='".$_SESSION['id']."' AND iduserrecibe='".$iduserrecibe['id']."'");
            $sentencia2->execute();
            $sentencias = $gbd->prepare("DELETE FROM amigos WHERE iduserpide='".$iduserrecibe['id']."' AND iduserrecibe='".$_SESSION['id']."'");
            $sentencias->execute();
            $sentence = $gbd->prepare("INSERT INTO notificaciones(iduser, idusernot, amigoperfil, razon) VALUES(:iduser, :idusernot, :amigoperfil, :razon)");
            $razon = $nero['nombre']." te ha quitado como amigo.";
            $sentence->bindParam(':iduser', $_SESSION['id']);
            $sentence->bindParam(':idusernot', $iduserrecibe['id']);
            $sentence->bindParam(':amigoperfil', $_SESSION['id']);
            $sentence->bindParam(':razon', $razon);
            $sentence->execute();
            $sentence2 = $gbd->prepare("SELECT * FROM registros WHERE id='".$iduserrecibe['id']."'");
            $sentence2->execute();
            $nif = $sentence2->fetch(PDO::FETCH_ASSOC);
            $numnotif=$nif['notifreg'] + 1;
            $siria = $gbd->prepare("UPDATE registros SET notifreg='".$numnotif."' WHERE user='".$nif['user']."'");
            $siria->execute();
            $gbd = NULL;
            header("Location: perfil.php?user=".$_GET['user']."");
        }else{}
    }else{
        if(isset($_GET['rechazar'])){
            $sentence4 = $gbd->prepare("SELECT * FROM registros WHERE user='".$_SESSION['usuario']."'");
            $sentence4->execute();
            $nero = $sentence4->fetch(PDO::FETCH_ASSOC);
            $sentencia2 = $gbd->prepare("DELETE FROM amigos WHERE iduserpide='".$_GET['userpide']."' AND iduserrecibe='".$_SESSION['id']."'");
            $sentencia2->execute();
            $sentence = $gbd->prepare("INSERT INTO notificaciones(iduser, idusernot, amigoperfil, razon) VALUES(:iduser, :idusernot, :amigoperfil, :razon)");
            $razon = $nero['nombre']." ha rechazado tu petición.";
            $sentence->bindParam(':iduser', $_SESSION['id']);
            $sentence->bindParam(':idusernot', $_GET['userpide']);
            $sentence->bindParam(':amigoperfil', $_SESSION['id']);
            $sentence->bindParam(':razon', $razon);
            $sentence->execute();
            $sentence2 = $gbd->prepare("SELECT * FROM registros WHERE id='".$_GET['userpide']."'");
            $sentence2->execute();
            $nif = $sentence2->fetch(PDO::FETCH_ASSOC);
            $numnotif=$nif['notifreg'] + 1;
            $siria = $gbd->prepare("UPDATE registros SET notifreg='".$numnotif."' WHERE user='".$nif['user']."'");
            $siria->execute();
            $gbd = NULL;
            header("Location: perfil.php?user=".$nif['user']."");
        }else{
            $sentence4 = $gbd->prepare("SELECT * FROM registros WHERE user='".$_SESSION['usuario']."'");
            $sentence4->execute();
            $nero = $sentence4->fetch(PDO::FETCH_ASSOC);
            $sentence4 = $gbd->prepare("INSERT INTO amigos(iduserpide, iduserrecibe) VALUES(:iduserpide2, :iduserrecibe2)");
            $sentence4->bindParam(':iduserpide2', $_SESSION['id']);
            $sentence4->bindParam(':iduserrecibe2', $_GET['userpide']);
            $sentence4->execute();
            $sentence5 = $gbd->prepare("INSERT INTO notificaciones(iduser, idusernot, amigoperfil, razon) VALUES(:iduser, :idusernot, :amigoperfil, :razon)");
            $razon = $nero['nombre']." ha aceptado tu solicitud.";
            $sentence5->bindParam(':iduser', $_SESSION['id']);
            $sentence5->bindParam(':idusernot', $_GET['userpide']);
            $sentence5->bindParam(':amigoperfil', $_SESSION['id']);
            $sentence5->bindParam(':razon', $razon);
            $sentence5->execute();
            $sentence6 = $gbd->prepare("SELECT * FROM registros WHERE id='".$_GET['userpide']."'");
            $sentence6->execute();
            $nif = $sentence6->fetch(PDO::FETCH_ASSOC);
            $numnotif=$nif['notifreg'] + 1;
            $siria = $gbd->prepare("UPDATE registros SET notifreg='".$numnotif."' WHERE user='".$nif['user']."'");
            $siria->execute();
            $gbd = NULL;
            header("Location: perfil.php?user=".$nif['user']."");
        }
    }
}
}
?>
