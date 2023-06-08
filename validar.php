<?php

include('usuario.php');
if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['senha']) && !empty($_POST['senha'])){

    $usuario = addslashes($_POST['nome']);
    $senha = addslashes(md5($_POST['senha']));

    if(validar($usuario,$senha)==true){
        if(!empty($_SESSION['nomeCompletoUsuario'])){
            $_SESSION['estadoServico']="chegada";
           print "<script> location.href='portal.php?page=novoServico&accao=listar';</script>";
           
        }else{
            header('Location:index.php');
        }
    }else{
        print "<script> alert('Dados incorrectos!');</script>";
        print "<script> location.href='index.php';</script>";
    }
}else{
    header('Location:index.php');
}


?>