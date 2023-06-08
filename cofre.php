<?php

function listar(){
    include('db.class.php');
if($_SESSION['acessoUsuario']=="A" or $_SESSION['acessoUsuario']=="B"){
     
     ?>



<form action="?page=cofre&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Cofre</h1>

    <input style="padding-top:0px;" type="number" name="buscar" placeholder="Pesquise pelo dia..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<form action="?page=cofre&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


    <button type="submit" class="fa fa-plus">Adicionar no cofre</button>



</form>

<?php

  
$empresa=$_SESSION['codigoEmpresa'];
$mes=date('m');

    $sql = "SELECT * FROM cofre inner join empresas  where cofre.codigoEmpresa=empresas.codigoEmpresa and mes=? and cofre.codigoEmpresa=? ORDER BY dia";



$res = $obj->prepare($sql);

$res -> execute([$mes,$empresa]);

$qtd = $res -> rowCount();


$despesaTotal=0;
if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Valor</th>";

    print "<th>Dia</th>";

    print "<th>Mês</th>";
    
    print "<th>Empresa</th>";

    print "<th>Acções</th>";

    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        $despesaTotal +=$row['valorCofre'];
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['valorCofre']. "</td>";

        print "<td>" .$row['dia']. "</td>";
        switch ($row['mes']){
            case '01':{print "<td>Janeiro</td>";}break;
            case '02':{print "<td>Fevereiro</td>";}break;
            case '03':{print "<td>Março</td>";}break;
            case '04':{print "<td>Abrir</td>";}break;
            case '05':{print "<td>Maio</td>";}break;
            case '06':{print "<td>Junho</td>";}break;
            case '07':{print "<td>Julho</td>";}break;
            case '08':{print "<td>Agosto</td>";}break;
            case '09':{print "<td>Setembro</td>";}break;
            case '10':{print "<td>Outubro</td>";}break;
            case '11':{print "<td>Novembro</td>";}break;
            case '12':{print "<td>Dezembro</td>";}break;
        
        }

        print "<td>" .$row['nomeEmpresa']. "</td>";

        print "<td>

           
            <button onclick=\"if(confirm('Tens certesa que pretende excluir')){location.href='?page=cofre&accao=excluir&id=".$row['codigoCofre']."&dia=".$row['dia']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>

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

    <h3 style="margin-left:20px ;"><strong><?php echo "Valor total: ".$despesaTotal." Mzn"?></strong></h3>

</div><?php
    
}else{
     ?>



<form action="?page=cofre&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Cofre</h1>

    <input style="padding-top:0px;" type="number" name="buscar" placeholder="Pesquise pelo dia..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<?php

  
$empresa=1;
$mes=date('m');

    $sql = "SELECT * FROM cofre inner join empresas  where cofre.codigoEmpresa=empresas.codigoEmpresa and mes=? and cofre.codigoEmpresa=? ORDER BY dia";



$res = $obj->prepare($sql);

$res -> execute([$mes,$empresa]);

$qtd = $res -> rowCount();


$despesaTotal=0;

if($qtd > 0) {

print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

        print "<th>#</th>";

        print "<th>Valor</th>";

        print "<th>Dia</th>";

        print "<th>Mês</th>";

        print "<th>Empresa</th>";


        print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
    $despesaTotal +=$row['valorCofre'];

    print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['valorCofre']. "</td>";

        print "<td>" .$row['dia']. "</td>";
        switch ($row['mes']){
        case '01':{print "<td>Janeiro</td>";}break;
        case '02':{print "<td>Fevereiro</td>";}break;
        case '03':{print "<td>Março</td>";}break;
        case '04':{print "<td>Abrir</td>";}break;
        case '05':{print "<td>Maio</td>";}break;
        case '06':{print "<td>Junho</td>";}break;
        case '07':{print "<td>Julho</td>";}break;
        case '08':{print "<td>Agosto</td>";}break;
        case '09':{print "<td>Setembro</td>";}break;
        case '10':{print "<td>Outubro</td>";}break;
        case '11':{print "<td>Novembro</td>";}break;
        case '12':{print "<td>Dezembro</td>";}break;

        }

        print "<td>" .$row['nomeEmpresa']. "</td>";



        print "</tr>";
    $count+=1;
    }

    print "</table>";

} else {

print "<form action='portal.php?page=cofre&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit'
        style='border:none;margin-left:20px;background-color:transparent'>"." "."Voltar</button>

</form>";

print "<p class='alert alert-danger'>Não encontrou resultados no bar!</p>";

}
?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "Valor total: ".$despesaTotal." Mzn"?></strong></h3>

</div><?php
$empresa=2;
$mes=date('m');

    $sql = "SELECT * FROM cofre inner join empresas  where cofre.codigoEmpresa=empresas.codigoEmpresa and mes=? and cofre.codigoEmpresa=? ORDER BY dia";



$res = $obj->prepare($sql);

$res -> execute([$mes,$empresa]);

$qtd = $res -> rowCount();


$despesaTotal=0;


if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Valor</th>";

    print "<th>Dia</th>";

    print "<th>Mês</th>";
    
    print "<th>Empresa</th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        $despesaTotal +=$row['valorCofre'];
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['valorCofre']. "</td>";

        print "<td>" .$row['dia']. "</td>";
        switch ($row['mes']){
            case '01':{print "<td>Janeiro</td>";}break;
            case '02':{print "<td>Fevereiro</td>";}break;
            case '03':{print "<td>Março</td>";}break;
            case '04':{print "<td>Abrir</td>";}break;
            case '05':{print "<td>Maio</td>";}break;
            case '06':{print "<td>Junho</td>";}break;
            case '07':{print "<td>Julho</td>";}break;
            case '08':{print "<td>Agosto</td>";}break;
            case '09':{print "<td>Setembro</td>";}break;
            case '10':{print "<td>Outubro</td>";}break;
            case '11':{print "<td>Novembro</td>";}break;
            case '12':{print "<td>Dezembro</td>";}break;
        
        }

        print "<td>" .$row['nomeEmpresa']. "</td>";



        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=cofre&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados na mercearia!</p>";

}
?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "Valor total: ".$despesaTotal." Mzn"?></strong></h3>

</div><?php
    
}
}
function adicionar(){
    include('db.class.php');
    switch ($_REQUEST["fase"]){
        case 'inicial':{
             ?> <form action="?" class="formAdicionar" method="POST">

    <input type="hidden" name="page" value="cofre">
    <input type="hidden" name="accao" value="adicionar">
    <input type="hidden" name="fase" value="final">

    <h1>Adicionar valor no cofre</h1>



    <div class="mb-3">

        <label>Valor</label>

        <input type="number" name="valorCofre" class="form-control" required>


    </div>

    <div class="mb-3">

        <button type="submit" class="btn btn-primary">Adicionar</button>

    </div>



    <?php
            
        }break;
        case 'final':{
            $valor = addslashes($_POST['valorCofre']);
            $dia  = date('d');
            $mes = date('m');
            $empresa = $_SESSION['codigoEmpresa'];
            $sql = "INSERT INTO cofre(valorCofre, dia, mes, codigoEmpresa) VALUES(?,?,?,?)";
            $sql = $obj->prepare($sql);
            $sql->execute([$valor,$dia,$mes,$empresa]);
            print "<script>location.href='?page=cofre&accao=listar';</script>";
            
            
            
    }break;
}
}

function buscar($dia){
    include('db.class.php')

    ?>



    <form action="?page=cofre&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

        <h1>Cofre</h1>

        <input style="padding-top:0px;" type="number" name="buscar" placeholder="Pesquise pelo dia..." value="<?php echo $dia?>"
            style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

    </form>

    <form action="?page=cofre&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


        <button type="submit" class="fa fa-plus">Adicionar no cofre</button>



    </form>

    <?php

  
$empresa=$_SESSION['codigoEmpresa'];
$mes=date('m');

    $sql = "SELECT * FROM cofre inner join empresas  where cofre.codigoEmpresa=empresas.codigoEmpresa and mes=? and cofre.codigoEmpresa=? and dia=? ORDER BY dia";



$res = $obj->prepare($sql);

$res -> execute([$mes,$empresa,$dia]);

$qtd = $res -> rowCount();


$despesaTotal=0;
if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Valor</th>";

    print "<th>Dia</th>";

    print "<th>Mês</th>";
    
    print "<th>Empresa</th>";

    print "<th>Acções</th>";

    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        $despesaTotal +=$row['valorCofre'];
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['valorCofre']. "</td>";

        print "<td>" .$row['dia']. "</td>";
        switch ($row['mes']){
            case '01':{print "<td>Janeiro</td>";}break;
            case '02':{print "<td>Fevereiro</td>";}break;
            case '03':{print "<td>Março</td>";}break;
            case '04':{print "<td>Abrir</td>";}break;
            case '05':{print "<td>Maio</td>";}break;
            case '06':{print "<td>Junho</td>";}break;
            case '07':{print "<td>Julho</td>";}break;
            case '08':{print "<td>Agosto</td>";}break;
            case '09':{print "<td>Setembro</td>";}break;
            case '10':{print "<td>Outubro</td>";}break;
            case '11':{print "<td>Novembro</td>";}break;
            case '12':{print "<td>Dezembro</td>";}break;
        
        }

        print "<td>" .$row['nomeEmpresa']. "</td>";

        print "<td>

           
            <button onclick=\"if(confirm('Tens certesa que pretende excluir')){location.href='?page=cofre&accao=excluir&id=".$row['codigoCofre']."&dia=".$row['dia']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";
 print "<form action='portal.php?page=cofre&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

} else {

    print "<form action='portal.php?page=cofre&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}

}

function excluir($codigoCofre,$hoje){
    include('db.class.php');
    $diaA=date('d');
    if($diaA==$hoje){
    $sql ="DELETE FROM cofre WHERE codigoCofre=?";
    $sql = $obj->prepare($sql);
    $sql -> execute([$codigoCofre]);
    print "<script> location.href='?page=cofre&accao=listar';</script>";
    }else{
        print "<script> alert('Desculpa, só pode apagar um registo no cofre se for do mesmo dia');</script>";
        print "<script> location.href='?page=cofre&accao=listar';</script>";
    }
    
}

switch ($_REQUEST['accao']){
    case 'listar':{
        listar();
        
    }break;
    case 'adicionar':{
        adicionar();
        
    }break;

    case 'buscar':{
        buscar($_POST['buscar']);
        
    }break;
    case 'excluir':{
        excluir($_REQUEST['id'],$_REQUEST['dia']);
        
    }break;
}
?>