<?php 

function listarVenda(){

    if($_SESSION['acessoUsuario']=="A" or $_SESSION['acessoUsuario']=="B"){
        ?>

<form action="?page=venda&accao=buscar" class="formPesquisa" style="width: 90%; margin:auto" method="POST">

    <div class="mb-3">

        <h1 style="padding-top:0px;">Vendas</h1>

        <input type="date" name="buscar" placeholder="Pesquise pela data no formato YYYY-MM-DD"
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>

        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

    </div>



</form>
<Div class="formAdd">
    <form action="?page=venda&accao=filtrar" method="POST" style="width: 90%; margin:auto; margin-right:10%;">

        <input type="hidden" name="fase" value="inicial">

        <button class="btnFiltrar" type="submit">Filtrar</button>

    </form>




    <?php
  if($_SESSION['acessoUsuario']=="A" or $_SESSION['acessoUsuario']=="B"){
    ?>
    <form action="?page=divida&fase=listar" method="POST"
        style="width: 90%; margin:auto; margin-bottom:20px; margin-right:10%;">

        <input type="hidden" name="fase" value="listar">

        <button id="divida" type="submit">Dividas?</button>

    </form>

    <form action="?page=despesa" method="POST" style="width: 90%; margin:auto; margin-bottom:20px;">

        <input type="hidden" name="accao" value="listar">

        <button id="divida" type="submit">Despesas</button>

    </form>

</Div>
<?php

}
include('db.class.php');


$data = date("Y-m-d");
$sql = "SELECT * FROM produtos inner join vendas inner join empresas inner join usuarios inner join clientes where
empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and
vendas.codigoUsuario=usuarios.codigoUsuario and vendas.codigoCliente=clientes.codigoCliente and produtos.codigoEmpresa=? and dataVenda='$data' ORDER BY codigoVenda DESC";



$res = $obj->prepare($sql);

$res -> execute([$_SESSION['codigoEmpresa']]);

$qtd = $res -> rowCount();

$VendaTotal = 0;

$LucroTotal = 0;



if($qtd > 0) {

print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

        print "<th>#</th>";

        print "<th>Produto</th>";

        print "<th>Qtd.</th>";

        print "<th>Val. venda</th>";

        print "<th>Hora</th>";

        print "<th>Acção</th>";

        print "</tr>";

    $count = 1;

    while($row = $res -> fetch()) {

    $VendaTotal = $VendaTotal+$row['valorTotalVenda'];

    $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];

    print "<tr>";

        print "<td>" .$count. "</td>";


        print "<td>" .$row['nomeProduto']. "</td>";

        print "<td>" .$row['quantidade']. "</td>";

        print "<td>" .$row['valorTotalVenda']. "</td>";

        print "<td>" .$row['horaVenda']. "</td>";

        print "<td>


            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class=' btn btn-danger'>Excluir</button>

        </td>";

        print "</tr>";

    $count+=1;

    }

    print "</table>";

} else {
    print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";

print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}





?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>

    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>

</div><?php
        
    }else{
  
    ?>

<form action="?page=venda&accao=buscar" class="formPesquisa" style="width: 90%; margin:auto" method="POST">

    <div class="mb-3">

        <h1 style="padding-top:0px;">Vendas</h1>

        <input type="date" name="buscar" placeholder="Pesquise pela data no formato YYYY-MM-DD"
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>

        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

    </div>



</form>
<Div class="formAdd">
    <form action="?page=venda&accao=filtrar" method="POST" style="width: 90%; margin:auto; margin-right:50%;">

        <input type="hidden" name="fase" value="inicial">

        <button class="btnFiltrar" type="submit">Filtrar</button>

    </form>




    <?php
  if($_SESSION['acessoUsuario']=="A" or $_SESSION['acessoUsuario']=="B"){
    ?>
    <form action="?page=divida&fase=listar" method="POST" style="width: 90%; margin:auto; margin-bottom:20px;">

        <input type="hidden" name="fase" value="listar">

        <button id="divida" type="submit">Dividas?</button>

    </form>
</Div>
<?php

}
include('db.class.php');


$data = date("Y-m-d");
$sql = "SELECT * FROM produtos inner join vendas inner join empresas inner join usuarios inner join clientes where
empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and
vendas.codigoUsuario=usuarios.codigoUsuario and vendas.codigoCliente=clientes.codigoCliente and dataVenda='$data' ORDER
BY codigoVenda DESC";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();

$VendaTotal = 0;

$LucroTotal = 0;



if($qtd > 0) {

print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

        print "<th>#</th>";


        print "<th>Produto</th>";

        print "<th>Qtd.</th>";

        print "<th>Val. venda</th>";

        print "<th>Hora</th>";

        print "<th>Acção</th>";

        print "</tr>";

    $count = 1;

    while($row = $res -> fetch()) {

    $VendaTotal = $VendaTotal+$row['valorTotalVenda'];

    $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];

    print "<tr>";

        print "<td>" .$count. "</td>";

        print "<td>" .$row['nomeProduto']. "</td>";

        print "<td>" .$row['quantidade']. "</td>";

        print "<td>" .$row['valorTotalVenda']. "</td>";

        print "<td>" .$row['horaVenda']. "</td>";


        print "<td>


            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class=' btn btn-danger'>Excluir</button>

        </td>";

        print "</tr>";

    $count+=1;

    }

    print "</table>";

} else {
    print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";

print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}





?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>

    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>

</div><?php
    }
}

function filtro(){
    
include('db.class.php');
switch ($_REQUEST['fase']){
    case 'inicial':?>
<form class="filtroForm" action="?page=venda&accao=filtrar" method="POST">
    <h1>Filtros</h1>
    <input type="hidden" name="fase" value="segunda">
    <div class="mb-3">
        <label for="">Data da venda</label>
        <input name="data" type="date">

    </div>
    <div class="mb-3">
        <label for="">Empresa</label>
        <select name="empresa">
            <option>Todas</option>
            <option>Mercearia</option>
            <option>Bar</option>
        </select>
    </div class="mb-3">
    <label for="">Usuário: </label>
    <input type="text" name="user" placeholder="Código usuário">
    </div>
    <div class="mb-3">
        <button type="submit" class="fa fa-search"
            style="border-color:white ;background-color:transparent;padding:10px;width:max-content;margin-top:10px">Filtrar</button>
    </div>

</form><?php
        break;
    case 'segunda':
        ?>

<form action="?page=#" style="width: 90%; margin:auto" method="POST">

    <div class="mb-3">
        <h1>Vendas</h1>
        <input type="date" name="buscar" placeholder="Pesquise pela data no formato YYYY-MM-DD"
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>
        <input type="hidden" name="accao" value="buscar">
        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    </div>

</form>
<form action="?page=venda&accao=filtrar" method="POST" style="width: 90%; margin:auto; margin-bottom:20px;">
    <input type="hidden" name="fase" value="inicial" style="border: none;">
    <button style="border-color:blue;background-color:transparent;color:blue; font-weight:bold; padding:10px"
        type="submit">Filtrar</button>
</form>

<?php
        $data = addslashes($_POST['data']);
        $empresa = addslashes($_POST['empresa']);
        $usuario = addslashes($_POST['user']);
        if(!empty($data) && ($empresa=="Todas") && !empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND dataVenda=? And vendas.codigoUsuario=? ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$data,$usuario]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
             
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php    

        }else if(empty($data) && ($empresa=="Todas") && !empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND vendas.codigoUsuario=? ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$usuario]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
  
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(!empty($data) && ($empresa=="Todas") && empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND dataVenda=? ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$data]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>

                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(!empty($data) && ($empresa=="Mercearia") && !empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND dataVenda=? And vendas.codigoUsuario=? AND produtos.codigoEmpresa='2' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$data,$usuario]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>

                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(empty($data) && ($empresa=="Mercearia") && !empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario  And vendas.codigoUsuario=? AND produtos.codigoEmpresa='2' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$usuario]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
               
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(!empty($data) && ($empresa=="Mercearia") && empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND dataVenda=? AND produtos.codigoEmpresa='2' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$data]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 

        }else if(!empty($data) && ($empresa=="Bar") && !empty($usuario)){
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND dataVenda=? And vendas.codigoUsuario=? AND produtos.codigoEmpresa='1' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$data,$usuario]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(empty($data) && ($empresa=="Bar") && !empty($usuario)){
            
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario  And vendas.codigoUsuario=? AND produtos.codigoEmpresa='1' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$usuario]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(!empty($data) && ($empresa=="Bar") && empty($usuario)){
           
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario AND dataVenda=? AND produtos.codigoEmpresa='1' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute([$data]);
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>

                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(empty($data) && ($empresa=="Todas") && empty($usuario)){
            //echo "Filtro com empresa so: todas";
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario  ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute();
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
                
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(empty($data) && ($empresa=="Mercearia") && empty($usuario)){
           // echo "Filtro com empresa so: mercaria";
           echo "======Filtro: ";
           echo "Empresa : ".$empresa.", ";
           echo "Dia:  ".$data.", ";
           echo "Codigo do usuário: ".$usuario;

       $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario  AND produtos.codigoEmpresa='2' ORDER BY codigoVenda DESC";

   $res = $obj->prepare($sql);
   $res -> execute();
   $qtd = $res -> rowCount();
   $VendaTotal = 0;
   $LucroTotal = 0;

   if($qtd > 0) {
       print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

       print "<tr>";
       print "<th>#</th>";
       print "<th>Produto</th>";
       print "<th>Qtd.</th>";
       print "<th>Val. venda</th>";
       print "<th>Hora</th>";
       print "<th>Acção</th>";
       print "</tr>";
       $count=1;
       while($row = $res -> fetch()) {
           $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
           $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
           print "<tr>";
           print "<td>" .$count. "</td>";
           print "<td>" .$row['nomeProduto']. "</td>";
           print "<td>" .$row['quantidade']. "</td>";
           print "<td>" .$row['valorTotalVenda']. "</td>";
           print "<td>" .$row['horaVenda']. "</td>";
           print "<td>
            
               <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
           </td>";
           print "</tr>";
           $count+=1;
       }
           print "</table>";
   } else {
    print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
       print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
   }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div>
<?php 
        }else if(empty($data) && ($empresa=="Bar") && empty($usuario)){
           // echo "Filtro com empresa so: bar";
            echo "======Filtro: ";
            echo "Empresa : ".$empresa.", ";
            echo "Dia:  ".$data.", ";
            echo "Codigo do usuário: ".$usuario;

        $sql = "SELECT codigoVenda, nomeProduto,quantidade, vendas.valorTotalVenda,lucroTotalVenda, dataVenda,horaVenda, nomeUsuario FROM produtos inner join vendas inner join empresas inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario  AND produtos.codigoEmpresa='1' ORDER BY codigoVenda DESC";

    $res = $obj->prepare($sql);
    $res -> execute();
    $qtd = $res -> rowCount();
    $VendaTotal = 0;
    $LucroTotal = 0;

    if($qtd > 0) {
        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

        print "<tr>";
        print "<th>#</th>";
        print "<th>Produto</th>";
        print "<th>Qtd.</th>";
        print "<th>Val. venda</th>";
        print "<th>Hora</th>";
        print "<th>Acção</th>";
        print "</tr>";
        $count=1;
        while($row = $res -> fetch()) {
            $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
            $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
            print "<tr>";
            print "<td>" .$count. "</td>";
            print "<td>" .$row['nomeProduto']. "</td>";
            print "<td>" .$row['quantidade']. "</td>";
            print "<td>" .$row['valorTotalVenda']. "</td>";
            print "<td>" .$row['horaVenda']. "</td>";
            print "<td>
          
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
            </td>";
            print "</tr>";
            $count+=1;
        }
            print "</table>";
    } else {
        print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    }?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div><?php
        }
        break;
    default:
    echo "ERRO";
    break;

}
}


function excluirVenda($id,$nome){
    include('db.class.php');
    if($_SESSION['acessoUsuario']=="A" or $_SESSION['acessoUsuario']=="B"){
        
        print "<br>"; 

        $sql ="SELECT codigoEmpresa FROM produtos where nomeProduto='$nome' ";

        $busca = $obj->prepare($sql);
        $busca->execute();

        $dado = $busca->fetch();
       

       if($_SESSION['codigoEmpresa']==$dado['codigoEmpresa']){
            $sql ="DELETE FROM vendas where codigoVenda='$id' ";

            $busca = $obj->prepare($sql);
            if($busca->execute()){
                print "<script>location.href='?page=venda&accao=listar';</script>";

            }else{
                print "<script>alert('Erro ao apagar a venda')</script>";
            print "<script>location.href='?page=venda&accao=listar';</script>";
            }
        }else{
            print "<script>alert('Desculpa, não pode apagar uma venda que não é da sua empresa')</script>";
            print "<script>location.href='?page=venda&accao=listar';</script>";
        }
            
        }else{
    
            print "<script>alert('Desculpa, não tens acesso a está acção!')</script>";
            print "<script>location.href='?page=venda&accao=listar';</script>";
        }

}

function buscarVenda($data){

    if($_SESSION['acessoUsuario'] == "A" or $_SESSION['acessoUsuario'] == "B"){
    
    ?>

<form action="?page=venda" style="width: 90%; margin:auto" method="POST">

    <div class="mb-3">
        <h1>Vendas</h1>
        <input type="date" name="buscar" placeholder="Pesquise pela data no formato YYYY-MM-DD" value="<?php echo $data?>"
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>
        <input type="hidden" name="accao" value="buscar">
        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    </div>

</form>

<?php
include('db.class.php');

    $sql = "SELECT * FROM produtos inner join vendas inner join empresas inner join clientes inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario and vendas.codigoCliente=clientes.codigoCliente AND produtos.codigoEmpresa=? AND dataVenda=? ORDER BY codigoVenda DESC";

$res = $obj->prepare($sql);
$res -> execute([$_SESSION['codigoEmpresa'],$data]);
$qtd = $res -> rowCount();
$VendaTotal = 0;
$LucroTotal = 0;

if($qtd > 0) {
    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

    print "<tr>";
    print "<th>#</th>";
    print "<th>Produto</th>";
    print "<th>Qtd.</th>";
    print "<th>Val. venda</th>";
    print "<th>Hora</th>";
    print "<th>Acção</th>";
    print "</tr>";
    $count=1;
    while($row = $res -> fetch()) {
        $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
        $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['nomeProduto']. "</td>";
        print "<td>" .$row['quantidade']. "</td>";
        print "<td>" .$row['valorTotalVenda']. "</td>";
    
        print "<td>" .$row['horaVenda']. "</td>";
        print "<td>
           
            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
        </td>";
        print "</tr>";
        $count+=1;
    }
        print "</table>";
} else {
    print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
}
?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div><?php
    
    }else{
    
    ?>

<form action="?page=venda" style="width: 90%; margin:auto" method="POST">

    <div class="mb-3">
        <h1>Vendas</h1>
        <input type="date" name="buscar" placeholder="Pesquise pela data no formato YYYY-MM-DD" value="<?php echo $data?>"
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>
        <input type="hidden" name="accao" value="buscar">
        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    </div>

</form>

<?php
include('db.class.php');

    $sql = "SELECT * FROM produtos inner join vendas inner join empresas inner join clientes inner join usuarios where empresas.codigoEmpresa=produtos.codigoEmpresa and vendas.codigoProduto=produtos.codigoProduto and vendas.codigoUsuario=usuarios.codigoUsuario and vendas.codigoCliente=clientes.codigoCliente AND dataVenda=? ORDER BY codigoVenda DESC";

$res = $obj->prepare($sql);
$res -> execute([$data]);
$qtd = $res -> rowCount();
$VendaTotal = 0;
$LucroTotal = 0;

if($qtd > 0) {
    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

    print "<tr>";
    print "<th>#</th>";
    print "<th>Produto</th>";
    print "<th>Qtd.</th>";
    print "<th>Val. venda</th>";
    print "<th>Hora</th>";
    print "<th>Acção</th>";
    print "</tr>";
    $count=1;
    while($row = $res -> fetch()) {
        $VendaTotal = $VendaTotal+$row['valorTotalVenda'];
        $LucroTotal = $LucroTotal+$row['lucroTotalVenda'];
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['nomeProduto']. "</td>";
        print "<td>" .$row['quantidade']. "</td>";
        print "<td>" .$row['valorTotalVenda']. "</td>";
    
        print "<td>" .$row['horaVenda']. "</td>";
        print "<td>
           
            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=venda&accao=excluir&id=".$row['codigoVenda']."&nomeProd=".$row['nomeProduto']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
        </td>";
        print "</tr>";
        $count+=1;
    }
        print "</table>";
} else {
    print "<form action='portal.php?page=venda&accao=listar'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
}
?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Venda Total: ".$VendaTotal." Mzn"?></strong></h3>
    <h3 style="margin-left:20px ;"><strong><?php echo "     Lucro Total: ".$LucroTotal." Mzn"?></strong></h3>
</div><?php

    }
}

switch ($_REQUEST['accao']) {
    case 'listar':{
        listarVenda();
    }
        
        break;
    case 'filtrar':{
        filtro();
    }
        
        break;

    case 'buscar':{
        if(isset($_POST['buscar']) &&  !empty($_POST['buscar'])){
            $dataBusca = addslashes($_POST['buscar']);
        buscarVenda($dataBusca);
    }else{
        print "<script>location.href='?page=venda&accao=listar';</script>";
        }
    }
        
        break;

        case 'excluir':{

            excluirVenda($_REQUEST['id'],$_REQUEST['nomeProd']);
        }
            
            break;
        
    
    default:
        # code...
        break;
}


?>