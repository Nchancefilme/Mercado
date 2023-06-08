<?php



function listarTodos(){
    $valorTotaldeTudo =0;

    if($_SESSION['nomeUsuario']=="Mama" || $_SESSION['nomeUsuario']=="Ana"){
            
    ?>


    <form action="?page=store" class="formPesquisa" style="width: 100%;" method="POST">
        <h1>Stock de produtos da Mercearia</h1>
       
    </form>
    
    <?php     
    include('db.class.php')  ;
$sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto And produtos.codigoEmpresa=? ORDER BY nomeProduto";

$res = $obj->prepare($sql);
$res -> execute(['2']);
$qtd = $res -> rowCount();

if($qtd > 0) {
print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

print "<tr>";
print "<th>#</th>";
print "<th>Produto</th>";
print "<th>Stock</th>";
print "<th>Valor</th>";
print "</tr>";
$count=1;
$ValorTotal=0;
while($row = $res -> fetch()) {
    $valor =$row['quantidade']*$row['valorUnidade'];
    $ValorTotal+=$valor;
    print "<tr>";
    print "<td>" .$count. "</td>";
    print "<td>" .$row['nomeProduto']. "</td>";
    print "<td>" .$row['quantidade']. "</td>";
    print "<td>" .$valor. "</td>";
    print "</tr>";
    $count+=1;
}
    print "</table>";
    ?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Valor total mercearia: ".$ValorTotal." Mzn"?></strong></h3>
    
</div>
<?php 
} else {
print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

    }

    $valorTotaldeTudo +=$ValorTotal;
    ?>


    <form action="?page=store" class="formPesquisa" style="width: 100%;" method="POST">
        <h1>Stock de produtos do Bar</h1>
       
    </form>
    
    <?php     
    include('db.class.php')  ;
$sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto And produtos.codigoEmpresa=? ORDER BY nomeProduto";

$res = $obj->prepare($sql);
$res -> execute(['1']);
$qtd = $res -> rowCount();

if($qtd > 0) {
print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

print "<tr>";
print "<th>#</th>";
print "<th>Produto</th>";
print "<th>Stock</th>";
print "<th>Valor</th>";
print "</tr>";
$count=1;
$ValorTotal=0;
while($row = $res -> fetch()) {
    $valor =$row['quantidade']*$row['valorUnidade'];
    $ValorTotal+=$valor;
    print "<tr>";
    print "<td>" .$count. "</td>";
    print "<td>" .$row['nomeProduto']. "</td>";
    print "<td>" .$row['quantidade']. "</td>";
    print "<td>" .$valor. "</td>";
    print "</tr>";
    $count+=1;
}
    print "</table>";
    $valorTotaldeTudo +=$ValorTotal;
    ?>
    
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Valor total bar: ".$ValorTotal." Mzn"?></strong></h3>
    
</div>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Valor total geral: ".$valorTotaldeTudo." Mzn"?></strong></h3>
    
</div>
<?php 
} else {
print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

    }

    }else{
    
        
    ?>


    <form action="?page=store" class="formPesquisa" style="width: 100%;" method="POST">
        <h1>Stock de produtos</h1>
        <input type="search" name="nome" placeholder="Pesquise pelo nome..."
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>
        <input type="hidden" name="accao" value="buscar">
        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    </form>
    <form action="?page=store" class="formAdd" style="width: 100%;" method="POST">
    <input type="hidden" name="accao" value="listarTodos">
    
    <button type="submit" class="resultados" style="background-color:blueviolet;">Todos produtos</button>
    </form>
    
    <?php     
    include('db.class.php')  ;
$sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto And produtos.codigoEmpresa=? ORDER BY nomeProduto";

$res = $obj->prepare($sql);
$res -> execute([$_SESSION['codigoEmpresa']]);
$qtd = $res -> rowCount();

if($qtd > 0) {
print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

print "<tr>";
print "<th>#</th>";
print "<th>Produto</th>";
print "<th>Stock</th>";
print "<th>Valor</th>";
print "<th>Acções</th>";
print "</tr>";
$count=1;
$ValorTotal=0;
while($row = $res -> fetch()) {
    $valor =$row['quantidade']*$row['valorUnidade'];
    $ValorTotal+=$valor;
    print "<tr>";
    print "<td>" .$count. "</td>";
    print "<td>" .$row['nomeProduto']. "</td>";
    print "<td>" .$row['quantidade']. "</td>";
    print "<td>" .$valor. "</td>";
    print "<td>
        <button onclick=\"location.href='?page=store&accao=abastecer&fase=inicial&id=".$row['codigoProduto']."&nomeProduto=".$row['nomeProduto']."&quantidade=".$row['quantidade']."';\" class='btn btn-success'>Abastecer</button>
         <button onclick=\"location.href='?page=store&accao=editar&fase=inicial&id=".$row['codigoProduto']."&nomeProduto=".$row['nomeProduto']."&quantidade=".$row['quantidade']."';\" class='btn btn-primary'>Editar</button>
    </td>";
    print "</tr>";
    $count+=1;
}
    print "</table>";
    ?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Valor Total: ".$ValorTotal." Mzn"?></strong></h3>
    
</div>
<?php 
} else {
print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

    }
}
}

function listarStock(){
    

    ?>


<form action="?page=store" class="formPesquisa" style="width: 100%;" method="POST">
  <h1>Stock de produtos</h1>
  <input type="search" name="nome" placeholder="Pesquise pelo nome..." 
      style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>
  <input type="hidden" name="accao" value="buscar">
  <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
</form>
<form action="?page=store" class="formAdd" style="width: 100%;" method="POST">
<input type="hidden" name="accao" value="listarTodos">
  
  <button type="submit" class="resultados" style="background-color:blueviolet;">Todos produtos</button>
</form>

<?php
  include('db.class.php');
  $sql = "SELECT * FROM estoques WHERE quantidade<=10";
  $sql = $obj->prepare($sql);
  $sql->execute();
  $quant = $sql->rowCount();
  if($quant>0){
      


$sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoEmpresa=? and quantidade<=10 ORDER BY nomeProduto";

$res = $obj->prepare($sql);
$res -> execute([$_SESSION['codigoEmpresa']]);
print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

print "<tr>";
print "<th>#</th>";
print "<th>Produto</th>";
print "<th>Stock</th>";
print "<th>Valor</th>";
print "<th>Acções</th>";
print "</tr>";
$count=1;
$ValorTotal=0;
while($row = $res -> fetch()) {
  $valor =$row['quantidade']*$row['valorUnidade'];
  $ValorTotal+=$valor;
  print "<tr>";
  print "<td>" .$count. "</td>";
  print "<td>" .$row['nomeProduto']. "</td>";
  print "<td>" .$row['quantidade']. "</td>";
  print "<td>" .$valor. "</td>";
  print "<td>
      <button onclick=\"location.href='?page=store&accao=abastecer&fase=inicial&id=".$row['codigoProduto']."&nomeProduto=".$row['nomeProduto']."&quantidade=".$row['quantidade']."';\" class='btn btn-success'>Abastecer</button>
       <button onclick=\"location.href='?page=store&accao=editar&fase=inicial&id=".$row['codigoProduto']."&nomeProduto=".$row['nomeProduto']."&quantidade=".$row['quantidade']."';\" class='btn btn-primary'>Editar</button>
  </td>";
  print "</tr>";
  $count+=1;
}
  print "</table>";
  ?>
<br>
<div class="resultados">
  <h3 style="margin-left:20px ;"><strong><?php echo "     Valor Total: ".$ValorTotal." Mzn"?></strong></h3>
  
</div>
<?php 
  
  }else{listarTodos();}




}
function buscarStock(){

    include('db.class.php');
    $nome= addslashes($_POST['nome']);
        ?>

<form action="?page=store" class="formPesquisa" style="width: 100%;" method="POST">
    <h1>Estoque do produtos</h1>
    <input type="search" name="nome" placeholder="Pesquise pelo nome..." value="<?php echo $nome?>"
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>
    <input type="hidden" name="accao" value="buscar">
    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
</form>
<form action="?page=store" class="formAdd" style="width: 100%;" method="POST">
<input type="hidden" name="accao" value="listarTodos">
  
  <button type="submit" class="resultados" style="background-color:blueviolet;">Todos produtos</button>
</form>

<?php

    
    $sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and (nomeProduto like '%$nome' or nomeProduto like '%$nome%' or nomeProduto like '$nome%' ) and produtos.codigoEmpresa=? ORDER BY nomeProduto";

$res = $obj->prepare($sql);
$res -> execute([$_SESSION['codigoEmpresa']]);
$qtd = $res -> rowCount();

if($qtd > 0) {
    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

  
print "<tr>";
print "<th>#</th>";
print "<th>Produto</th>";
print "<th>Stock</th>";
print "<th>Valor</th>";
print "<th>Acções</th>";
print "</tr>";
$count=1;
$ValorTotal=0;
while($row = $res -> fetch()) {
    $valor =$row['quantidade']*$row['valorUnidade'];
    $ValorTotal+=$valor;
    print "<tr>";
    print "<td>" .$count. "</td>";
    print "<td>" .$row['nomeProduto']. "</td>";
    print "<td>" .$row['quantidade']. "</td>";
    print "<td>" .$valor. "</td>";
    print "<td>
        <button onclick=\"location.href='?page=store&accao=abastecer&fase=inicial&id=".$row['codigoProduto']."&nomeProduto=".$row['nomeProduto']."&quantidade=".$row['quantidade']."';\" class='btn btn-success'>Abastecer</button>
         <button onclick=\"location.href='?page=store&accao=editar&fase=inicial&id=".$row['codigoProduto']."&nomeProduto=".$row['nomeProduto']."&quantidade=".$row['quantidade']."';\" class='btn btn-primary'>Editar</button>
    </td>";
    print "</tr>";
    $count+=1;
}
    print "</table>";
    ?>
<br>
<div class="resultados">
    <h3 style="margin-left:20px ;"><strong><?php echo "     Valor Total: ".$ValorTotal." Mzn"?></strong></h3>
    
</div>
<?php 
} else {
    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
}
}



function abastecer(){
    include('db.class.php');
    switch ($_REQUEST['fase']){
        case 'inicial':
            ?>
<form class="filtroForm" action="?page=store&accao=abastecer" method="POST">
    <h1>ABASTECER</h1>
    <input type="hidden" name="fase" value="final">
    <input type="hidden" name="codigoProduto" value="<?php echo $_REQUEST['id']?>">
    <input type="hidden" name="quantidade" value="<?php echo $_REQUEST['quantidade']?>">

    <div class="mb-3">
        <label for="">Produto</label>
        <input name="nome" type="text" value="<?php echo $_REQUEST['nomeProduto'] ?>">

    </div>

    <div class="mb-3">
        <label for="">Quantidade actual</label>
        <input type="text" name="quantidade" value="<?php echo $_REQUEST['quantidade']?>">
    </div>
    <div class="mb-3">
        <label for="">Quantidade: </label>
        <input style="height: 50px;" type="number" name="qtdAbastecer" value="" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="fa"
            style="border-color:white ;background-color:transparent;padding:10px;width:max-content;margin-top:10px">Abastecer</button>
    </div>

</form>

<?php
            
            case 'final':
                if(isset($_POST['qtdAbastecer']) && !empty($_POST['qtdAbastecer'])){
                   $quantidade = addslashes($_POST['qtdAbastecer']);
                   $codigoProduto = $_REQUEST['codigoProduto'];
                   $resto=$_REQUEST['quantidade'];
                    $qtd=$resto+$quantidade;
                   $sql = "UPDATE estoques set quantidade=? WHERE codigoProduto=?";
                    $sql1= $obj ->prepare($sql);
                    if($sql1->execute([$qtd,$codigoProduto])){
                        print "<script>location.href='?page=store&accao=listar';</script>";
                        
    
                    }else{
                        print "<script>location.href='?page=store&accao=listar';</script>";
                    }
    
                }
                break;
                default:
            echo 'Erro no estoque';
            break;
    }
}



function Editar(){
    include('db.class.php');
    switch ($_REQUEST['fase']){
        case 'inicial':
            ?>
<form class="filtroForm" action="?page=store&accao=editar" method="POST">
    <h1>EDITAR</h1>
    <input type="hidden" name="fase" value="final">
    <input type="hidden" name="codigoProduto" value="<?php echo $_REQUEST['id']?>">
    <input type="hidden" name="quantidade" value="<?php echo $_REQUEST['quantidade']?>">

    <div class="mb-3">
        <label for="">Produto</label>
        <input name="nome" type="text" value="<?php echo $_REQUEST['nomeProduto'] ?>" readonly>

    </div>

    <div class="mb-3">
        <label for="">Quantidade actual</label>
        <input style="height:50px; font-size: 30px;" type="number" name="quantidade" value="" required>
    </div>

    <div class="mb-3">
        <button type="submit" class="fa"
            style="border-color:white ;background-color:transparent;padding:10px;width:max-content;margin-top:10px">SALVAR</button>
    </div>

</form>

<?php
            
            case 'final':
                if(isset($_POST['quantidade']) && !empty($_POST['quantidade'])){
                   $quantidade = addslashes($_POST['quantidade']);
                   $codigoProduto = $_REQUEST['codigoProduto'];
                    $qtd=$quantidade;
                   $sql = "UPDATE estoques set quantidade=? WHERE codigoProduto=?";
                    $sql1= $obj ->prepare($sql);
                    if($sql1->execute([$qtd,$codigoProduto])){
                        print "<script>location.href='?page=store&accao=listar';</script>";
                        
    
                    }else{
                        print "<script>location.href='?page=store&accao=listar';</script>";
                    }
    
                }
                break;
                default:
            echo 'Erro no estoque';
            break;
    }
}

switch ($_REQUEST['accao']){
    case 'listar':{
        listarStock();

    }
    break;
    case 'buscar':{
        if(isset($_POST['nome']) && !empty(['nome'])){
        buscarStock();

        }else{
           
            print "<script>location.href='?page=store&accao=listar';</script>";
        }

    }
    break;

    case 'abastecer':{
        abastecer();

    }break;
    case 'listarTodos':{
        listarTodos();

    }break;
    case 'editar':{
        Editar();
    }break;
}


?>