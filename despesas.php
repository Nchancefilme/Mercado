<?php


function listar(){
    include('db.class.php');
     ?>



<form action="?page=despesa&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Despesas</h1>

    <input style="padding-top:0px;" type="date" name="buscar" placeholder="Pesquise pela data..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<form action="?page=despesa&accao=registar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


    <button type="submit" class="fa fa-plus">Registar despesa</button>



</form>

<?php

  
$usuario=$_SESSION['codigoUsuario'];
$data=date('Y-m-d');

    $sql = "SELECT * FROM despesas inner join usuarios  where despesas.codigoUsuario=usuarios.codigoUsuario and dataDespesa=? and despesas.codigoUsuario=? ORDER BY dataDespesa";



$res = $obj->prepare($sql);

$res -> execute([$data,$usuario]);

$qtd = $res -> rowCount();


$despesaTotal=0;
if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Descrição</th>";

    print "<th>Valor</th>";

    print "<th>Data</th>";
    print "<th>Usuário</th>";

    print "<th>Acções</th>";

    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        $despesaTotal +=$row['valorDespesa'];
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['descricaoDespesa']. "</td>";

        print "<td>" .$row['valorDespesa']. "</td>";

        print "<td>" .$row['dataDespesa']. "</td>";

        print "<td>" .$row['nomeUsuario']. "</td>";

        print "<td>

           
            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=despesa&accao=excluir&id=".$row['codigoDespesa']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=despesa&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}
?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "Despesa total: ".$despesaTotal." Mzn"?></strong></h3>

</div><?php
    
}


function buscar($data){
    include('db.class.php');
     ?>



<form action="?page=despesa&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Despesas</h1>

    <input style="padding-top:0px;" type="date" name="buscar" placeholder="Pesquise pela data..." value="<?php echo $data?>"
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<form action="?page=despesa&accao=registar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


    <button type="submit" class="fa fa-plus">Registar despesa</button>



</form>

<?php

  
$usuario=$_SESSION['codigoUsuario'];

    $sql = "SELECT * FROM despesas inner join usuarios  where despesas.codigoUsuario=usuarios.codigoUsuario and dataDespesa=? and despesas.codigoUsuario=? ORDER BY dataDespesa";



$res = $obj->prepare($sql);

$res -> execute([$data,$usuario]);

$qtd = $res -> rowCount();


$despesaTotal=0;
if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Descrição</th>";

    print "<th>Valor</th>";

    print "<th>Data</th>";
    print "<th>Usuário</th>";

    print "<th>Acções</th>";

    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        $despesaTotal +=$row['valorDespesa'];
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['descricaoDespesa']. "</td>";

        print "<td>" .$row['valorDespesa']. "</td>";

        print "<td>" .$row['dataDespesa']. "</td>";

        print "<td>" .$row['nomeUsuario']. "</td>";

        print "<td>

            

            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=despesa&accao=excluir&id=".$row['codigoDespesa']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=despesa&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}
?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "Despesa total: ".$despesaTotal." Mzn"?></strong></h3>

</div><?php
    
}


function registar(){
    include('db.class.php');
    switch ($_REQUEST['fase']){
        case 'inicial':{
        ?> <form action="?" class="formAdicionar" method="POST">

    <input type="hidden" name="page" value="despesa">
    <input type="hidden" name="accao" value="registar">
    <input type="hidden" name="fase" value="final">

    <h1>Registar despesa</h1>



    <div class="mb-3">

        <label>Descrição</label>

        <input type="text" name="descricaoDespesa" class="form-control" autofocus required>

    </div>



    <div class="mb-3">

        <label>Valor da despesa</label>

        <input type="number" name="valorDespesa" class="form-control" required>


    </div>

    <div class="mb-3">

        <button type="submit" class="btn btn-primary">REGISTAR</button>

    </div>



    <?php
        
    }break;

    case 'final':{

        $descricao = addslashes($_POST['descricaoDespesa']);
        $valor = addslashes($_POST['valorDespesa']);
        $data = date('Y-m-d');
        $usuario=$_SESSION['codigoUsuario'];

        $sql = "INSERT INTO despesas (descricaoDespesa,valorDespesa,dataDespesa,codigoUsuario) Values(?,?,?,?)";
        $sql = $obj->prepare($sql);
        $sql ->execute([$descricao,$valor,$data,$usuario]);
        print "<script>location.href='?page=despesa&accao=listar';</script>";
        
    }break;
        
    }

    

    
}


function excluir($codigoDespesa)
{
   include('db.class.php');
   $sql ="DELETE FROM despesas WHERE codigoDespesa=?";
   $sql = $obj->prepare($sql);
   $sql->execute([$codigoDespesa]);
   print "<script>location.href='?page=despesa&accao=listar';</script>";
   
}

switch ($_REQUEST['accao']){
    
    case 'listar':{
        listar();
        
    }break;
    case 'registar':{
        registar();
        
    }break;
    case 'buscar':{
        buscar($_POST['buscar']);
        
    }break;
    case 'excluir':{
        excluir($_REQUEST['id']);
        
    }break;
}

?>