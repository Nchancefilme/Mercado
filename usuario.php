<?php


function validar($usuario,$senha){
    include('db.class.php');

    $sql ="SELECT * FROM usuarios WHERE nomeUsuario=? AND senhaUsuario=?";

    $sql1 = $obj->prepare($sql);

    $sql1->execute([$usuario,$senha]);

    $dado = $sql1->rowCount();
    if($dado>0){

        $dado = $sql1->fetch();
        session_start();

      $_SESSION['codigoUsuario'] = $dado['codigoUsuario'];
    

      $_SESSION['nomeUsuario'] = $dado['nomeUsuario'];
      

      $_SESSION['nomeCompletoUsuario'] = $dado['nomeCompletoUsuario'];
      

      $_SESSION['acessoUsuario'] = $dado['acessoUsuario'];
      

        $_SESSION['codigoEmpresa'] = $dado['codigoEmpresa'];
        return true;

    }else{


            return false;

        }
    
}

?>