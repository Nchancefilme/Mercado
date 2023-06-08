<?php



function listar(){


    include('db.class.php');
    ?>
    
    <form action="#" class="formPesquisa" style="width: 100%;" method="POST">
    <h1>Usuários</h1>
        <input type="search" name="buscar" placeholder="Pesquise pelo nome..." style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>
        <input type="hidden" name="accao" value="buscar">
        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    </form>
    <form action="?page=user&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">
        <input type="hidden" name="accao" value="adicionar">
        <button type="submit" class="fa fa-plus" >Adicionar usuario</button>
        
    </form>

<?php

$sql = "SELECT * FROM usuarios ORDER BY nomeUsuario";

$res = $obj->prepare($sql);
$res -> execute();
$qtd = $res -> rowCount();

if($qtd > 0) {
print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

print "<tr>";
print "<th>#</th>";
print "<th>Nome do usuário</th>";
print "<th>Nome completo</th>";
print "<th>E-mail</th>";
print "<th>Genero</th>";
print "<th>Acções</th>";
print "</tr>";
$count=1;
while($row = $res -> fetch()) {
    print "<tr>";
    print "<td>" .$count. "</td>";
    print "<td>" .$row['nomeUsuario']. "</td>";
    print "<td>" .$row['nomeCompletoUsuario']. "</td>";
    print "<td>" .$row['emailUsuario']. "</td>";
    print "<td>" .$row['generoUsuario']. "</td>";
    print "<td>
        <button onclick=\"location.href='?page=user&accao=editar&id=".$row['codigoUsuario']."';\" class='btn btn-success'>Editar</button>
        <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=user&accao=excluir&id=".$row['codigoUsuario']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
    </td>";
    print "</tr>";
    $count+=1;
}
    print "</table>";
} else {
print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
}

}



function editar(){
    
    include('db.class.php');
    $sql = "SELECT * FROM usuarios WHERE codigoUsuario=? ORDER BY nomeCompletoUsuario";



    $res = $obj->prepare($sql);

    $res -> execute([$_REQUEST['id']]);

   if($dado = $res->fetch()){

    $nomeUsuario=$dado['nomeUsuario'];

    $nomeCompletoUsuario=$dado['nomeCompletoUsuario'];

    $emailUsuario=$dado['emailUsuario'];

    $generoUsuario=$dado['generoUsuario'];

    $codigoEmpresa= $dado['codigoEmpresa'] ;

    $acessoUsuario = $dado['acessoUsuario'];
    $codigoUsuario = $dado['codigoUsuario'];

    ?>

    <form class="EditarForm" action="?page=user&accao=actualizar" method="POST">

<h1>Edição do usuário: <?php echo $nomeUsuario ?></h1>

<input type="hidden" name="accao" value="actualizar">

<input type="hidden" name="idUsuario" value="<?php echo $codigoUsuario?>">

<div class="mb-3">

 <label>Nome do usuário <span style="color: red;font-size:20px;">*</span></label>

 <input type="text" name="nomeUsuario" class="form-control" value="<?php echo $nomeUsuario ?>" required>

</div>



<div class="mb-3">

 <label>Nome completo <span style="color: red;font-size:20px;">*</span></label>

 <input type="text" name="nomeCompletoUsuario" class="form-control" value="<?php echo $nomeCompletoUsuario ?> " required>

</div>



<div class="mb-3">

 <label>E-mail</label>

 <input type="email" name="emailUsuario" class="form-control" value="<?php echo $emailUsuario ?>" >

</div>

<div class="mb-3">

 <label>Género <span style="color: red; font-size:20px;">*</span></label>

 <select  name="generoUsuario" class="form-control">
    <option><?php echo $generoUsuario ?></option>
    <option>M</option>
    <option>F</option>
 </select>
  

</div>

<div class="mb-3">

 <label>Acesso <span style="color: red;font-size:20px;">*</span></label>

 <select name="acessoUsuario" class="form-control">
    <option><?php echo $acessoUsuario ?></option>
    <option>A</option>
    <option>B</option>
    <option>C</option>
    <option>D</option>
 </select>
  

</div>

<div class="mb-3">

 <label>Código da empresa <span style="color: red;font-size:20px;">*</span></label>

 <input type="number" name="codigoEmpresa" class="form-control" value="<?php echo $codigoEmpresa ?>" required >

</div>



    </div>

    <div class="mb-3">
    
    <button name="tipo" value="avancada" type="submit" class="fa" id="salvar" style="padding:10px;width:max-content;margin-top:10px">GUARDAR</button>

    </div>



</form>



<?php
}
}
function actualizar($nomeUsuario,$nomeCompletoUsuario,$email,$genero,$acesso,$codigoEmpresa,$idUsuario){

    include('db.class.php');
    $sql = "UPDATE usuarios SET nomeUsuario=?, nomeCompletoUsuario=?, emailUsuario=?,
    generoUsuario=?, acessoUsuario=?, codigoEmpresa=? WHERE codigoUsuario=? ";

    $sql1 = $obj->prepare($sql);
    if($sql1->execute([$nomeUsuario,$nomeCompletoUsuario,$email,$genero,$acesso,$codigoEmpresa,$idUsuario])){
        print "<script> alert('Usuário actualizado com sucesso!');</script>";
        print "<script> location.href='?page=user&accao=listar';</script>";

    }else{
        print "<script> alert('Erro ao actualizar o usuário!');</script>";
        print "<script> location.href='?page=user&accao=editar';</script>";
    }

}

function excluir($idUsuario){

    include('db.class.php');
    $sql = "DELETE FROM usuarios WHERE codigoUsuario=? ";

    $sql1 = $obj->prepare($sql);
    if($sql1->execute([$idUsuario])){
        print "<script> alert('Usuário excluido com sucesso!');</script>";
        print "<script> location.href='?page=user&accao=listar';</script>";

    }else{
        print "<script> alert('Erro ao excluir o usuário!');</script>";
        print "<script> location.href='?page=user&accao=listar';</script>";
    }

}

function adicionar($nomeUsuario,$nomeCompleto,$email,$genero,$acesso,$codigoEmpresa){
    include('db.class.php');

    $sql = "SELECT * FROM usuarios WHERE nomeUsuario like '%$nomeUsuario'
    OR nomeUsuario like '%$nomeUsuario%' OR nomeUsuario like '$nomeUsuario%'
    OR nomeCompletoUsuario like '%$nomeCompleto'
    OR nomeCompletoUsuario like '%$nomeCompleto%'
    OR nomeCompletoUsuario like '$nomeCompleto%'";

    $res = $obj->prepare($sql);
    $res -> execute();
    $qtd = $res -> rowCount();

    if($qtd <= 0) {

        $senhaUsuario=$nomeUsuario.".".date('Y');
        $sql = "INSERT INTO usuarios (nomeUsuario,senhaUsuario,nomeCompletoUsuario,
        emailUsuario,generoUsuario,acessoUsuario,codigoEmpresa) values (?,?,?,?,?,?,?)";

    $res = $obj->prepare($sql);
    
    
    if($res -> execute([
        $nomeUsuario,
        md5($senhaUsuario),
        $nomeCompleto,
        $email,
        $genero,
        $acesso,
        $codigoEmpresa
    ])) {
        print "<script> alert('usuário registado!');</script>";
        print "<script> location.href='?page=user&accao=listar';</script>";

    }else{
        print "<script> alert('usuário não registado!');</script>";
        print "<script> location.href='?page=user&accao=adiconar&fase=inicial';</script>";
    }


    }else{
        print "<script> alert('usuário já registado!');</script>";
        print "<script> location.href='?page=user&accao=adiconar&fase=inicial';</script>";
    }
    

}
function buscarUsuario($nome){


    include('db.class.php');
    

    $sql ="SELECT * FROM usuarios  where (nomeUsuario like '%$nome' or nomeUsuario like '%$nome%' or nomeUsuario like '$nome%' OR nomeCompletoUsuario like '%$nome' or nomeCompletoUsuario like '%$nome%' or nomeCompletoUsuario like '$nome%' ) Order by nomeCompletoUsuario";

    $sql1 = $obj->prepare($sql);

    $sql1->execute();

    $qtd = $sql1 -> rowCount();



    ?>

    

<form action="?page=user&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

<h1>Usuários</h1>

    <input style="padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..." value="<?php echo $nome?>" style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>

    <input type="hidden" name="accao" value="buscar">

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<form action="?page=user&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">

    <input type="hidden" name="accao" value="adicionar">

    <button type="submit" class="fa fa-plus" >Adicionar usuário</button>

    

</form>

    <?php

    if($qtd > 0) {

        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



        print "<tr>";

        print "<th>#</th>";

        print "<th>Nome do usuário</th>";

        print "<th>Nome Completo</th>";

        print "<th>Email do usuário</th>";
	    print "<th>Genero</th>";


        print "<th>Acções</th>";

        print "</tr>";

        $count = 1;

        while($row = $sql1 -> fetch()) {

            print "<tr>";

            print "<td>" .$count. "</td>";

            print "<td>" .$row['nomeUsuario']. "</td>";

            print "<td>" .$row['nomeCompletoUsuario']. "</td>";

            print "<td>" .$row['emailUsuario']. "</td>";
	        print "<td>" .$row['generoUsuario']. "</td>";


            print "<td>

           <button onclick=\"location.href='?page=user&accao=editar&id=".$row['codigoUsuario']."';\" class='btn btn-success'>Editar</button>

                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=user&accao=excluir&id=".$row['codigoUsuario']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>


            </td>";

            print "</tr>";
            $count+=1;
        }

            print "</table>";

    } else {

        print "<form action='portal.php'>

        <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

        </form>";

        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

    }

}


switch ($_REQUEST['accao']){
    case 'listar':{
        listar();

    }
    break;
    case 'editar':{
        editar();

    }
    break;
    case 'adicionar':{
        switch ($_REQUEST["fase"]){
            case 'inicial':{
                ?> <form action="?page=user&accao=adicionar&fase=final" class="formAdicionar" method="POST">
    
        <input type="hidden" name="accao" value="adicionar">
    
    <h1>Adicionar usuário</h1>
    
    
    
    <div class="mb-3">
    
     <label>Nome do usuário</label>
    
     <input type="text" name="nomeUsuario" class="form-control" required>
    
    </div>
    
    
    
    <div class="mb-3">
    
     <label>Nome completo</label>
    
     <input type="text" name="nomeCompletoUsuario" class="form-control" required>
    
    </div>
    
    
    
    <div class="mb-3">
    
     <label>Email</label>
    
     <input type="email" name="email" class="form-control" >
    
    </div>
    <div class="mb-3">
    
     <label>Gênero</label>
    
     <select  name="generoUsuario" class="form-control" required>

     <option>M</option>
     <option>F</option>
     </select>
    
    </div>

    <div class="mb-3">
    
     <label>Acesso</label>
    
     <select  name="acessoUsuario" class="form-control" required>

     <option>A</option>
     <option>B</option>
     <option>C</option>
     <option>D</option>
     </select>
    
    </div>
    
    
    
    <div class="mb-3">
    
     <label>Código da empresa</label>
    
     <input type="number" name="codigoEmpresa" class="form-control" required> 
      </input>
    
    </div>
 
    <div class="mb-3">
    
     <button type="submit" class="btn btn-primary">GUARDAR</button>
    
    </div>
    
    
    
      <?php
    
            }
            break;
        case 'final':{
            $nomeUsuario=addslashes($_POST['nomeUsuario']);
            $nomeCompleto=addslashes($_POST['nomeCompletoUsuario']);
            $email=addslashes($_POST['email']);
            $genero=addslashes($_POST['generoUsuario']);
            $acesso=addslashes($_POST['acessoUsuario']);
            $codigoEmpresa=addslashes($_POST['codigoEmpresa']);
            adicionar($nomeUsuario,$nomeCompleto,$email,$genero,$acesso,$codigoEmpresa);
           
        }
        break;
    }

    }
    break;
    case 'actualizar':{
        if(isset($_POST['nomeUsuario']) && !empty($_POST['nomeUsuario']) 
        && isset($_POST['nomeCompletoUsuario']) && !empty($_POST['nomeCompletoUsuario']) 
        && isset($_POST['generoUsuario']) && !empty($_POST['generoUsuario'])
        && isset($_POST['acessoUsuario']) && !empty($_POST['acessoUsuario'])
        && isset($_POST['codigoEmpresa']) && !empty($_POST['codigoEmpresa'])){
            $idUsuario = addslashes($_POST['idUsuario']) ;
            $nome = addslashes($_POST['nomeUsuario']) ;
            $nomeCompletoUsuario =addslashes($_POST['nomeCompletoUsuario']);
            $emailUsuario =addslashes($_POST['emailUsuario']);
            $generoUsuario =addslashes($_POST['generoUsuario']);
            $acessoUsuario =addslashes($_POST['acessoUsuario']);
            $codigoEmpresa =addslashes($_POST['codigoEmpresa']);
        actualizar($nome,$nomeCompletoUsuario,
        $emailUsuario,$generoUsuario,$acessoUsuario,$codigoEmpresa,$idUsuario);
        }else{
            print "<script> alert('Por favor preencha todos os campos obrigatórios!');</script>";
            print "<script> location.href='?page=user&accao=editar&id=".$_POST['idUsuario']."';</script>";
        }

    }
    break;
    
   
    case 'buscar':{
       buscarUsuario($_POST['buscar']);

    }
    break;
    case 'excluir':{
        excluir($_REQUEST['id']);

    }
    break;
    


}
?>