<?php




function listar(){
    include('db.class.php');
    ?>



<form action="portal.php?page=divida&fase=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Dividas</h1>

    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>


</form>
<Div class="formAdd">
    <form action="?page=divida&fase=filtrar" method="POST" style="width: 90%; margin:auto; margin-bottom:20px;">

        <input type="hidden" name="accao" value="inicial">

        <button class="btnFiltrar" type="submit">Filtrar</button>

    </form>
</Div>


<?php

  



    $sql = "SELECT * FROM dividas inner join usuarios inner join produtos inner join clientes WHERE dividas.codigoCliente=clientes.codigoCliente AND dividas.codigoProduto=produtos.codigoProduto AND dividas.codigoUsuario=usuarios.codigoUsuario ORDER BY dataDivida ";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();


$dividaTotal=0;
if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do cliente</th>";
    print "<th>Nome do produto</th>";
    print "<th>Quantidade</th>";
    print "<th>Valor </th>";
    print "<th>Data </th>";
    print "<th>Descrição </th>";
    print "<th>Usuário </th>";
    print "<th>Estado </th>";
    print "<th>Acção </th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$row['codigoDivida']. "</td>";
        print "<td>" .$row['nomeCliente']. "</td>";
        print "<td>" .$row['nomeProduto']. "</td>";
        print "<td>" .$row['quantidadeDivida']. "</td>";
        print "<td>" .$row['valorDivida']. "</td>";
        print "<td>" .$row['dataDivida']. "</td>";
        print "<td>" .$row['descricao']. "</td>";
        print "<td>" .$row['nomeUsuario']. "</td>";
        if($row['estado']==0){
            $dividaTotal += $row['valorDivida'];
            print "<td style='color:red'><strong>Não paga</strong></td>";
        }else{
            print "<td style='color:green'><strong>Paga</strong></td>";
        }
        

        print "<td>
        <form action='?page=divida&fase=pagar' method='POST'>
            <input type='hidden' name='codigoCliente' value='".$row['codigoCliente']."'>
            <input type='hidden' name='codigoProduto' value='".$row['codigoProduto']."'>
            <input type='hidden' name='valorPagar' value='".$row['valorDivida']."'>
            <input type='hidden' name='quantidade' value='".$row['quantidadeDivida']."'>
            <input type='hidden' name='lucroUnidade' value='".$row['lucroUnidade']."'>
            <input type='hidden' name='codigoUsuario' value='".$row['codigoUsuario']."'>
            <input type='hidden' name='codigoDivida' value='".$row['codigoDivida']."'>
            <button type='submit' class='btn btn-primary'>Pagar</button>

        </form>
        <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=divida&fase=excluir&id=".$row['codigoDivida']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
        

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=divida&fase=listar' method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}

?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "     Divida total: ".$dividaTotal." Mzn"?></strong></h3>

</div><?php
}


function buscar($nome){
    include('db.class.php');
    ?>



<form action="portal.php?page=divida&fase=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Dividas</h1>
    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..." value="<?php echo $nome?>"
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>


</form>


<?php

  



    $sql = "SELECT * FROM dividas inner join usuarios inner join produtos inner join clientes WHERE dividas.codigoCliente=clientes.codigoCliente AND dividas.codigoProduto=produtos.codigoProduto AND dividas.codigoUsuario=usuarios.codigoUsuario AND (nomeCliente like '%$nome' or nomeCliente like '%$nome%' or nomeCliente like '$nome%' ) ORDER BY dataDivida ";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();


$dividaTotal=0;
if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do cliente</th>";
    print "<th>Nome do produto</th>";
    print "<th>Quantidade</th>";
    print "<th>Valor </th>";
    print "<th>Data </th>";
    print "<th>Descrição </th>";
    print "<th>Usuário </th>";
    print "<th>Estado </th>";
    print "<th>Acção </th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$row['codigoDivida']. "</td>";
        print "<td>" .$row['nomeCliente']. "</td>";
        print "<td>" .$row['nomeProduto']. "</td>";
        print "<td>" .$row['quantidadeDivida']. "</td>";
        print "<td>" .$row['valorDivida']. "</td>";
        print "<td>" .$row['dataDivida']. "</td>";
        print "<td>" .$row['descricao']. "</td>";
        print "<td>" .$row['nomeUsuario']. "</td>";
        if($row['estado']==0){
            $dividaTotal += $row['valorDivida'];
            print "<td style='color:red'><strong>Não paga</strong></td>";
        }else{
            print "<td style='color:green'><strong>Paga</strong></td>";
        }
        

        print "<td>
        <form action='?page=divida&fase=pagar' method='POST'>
            <input type='hidden' name='codigoCliente' value='".$row['codigoCliente']."'>
            <input type='hidden' name='codigoProduto' value='".$row['codigoProduto']."'>
            <input type='hidden' name='valorPagar' value='".$row['valorDivida']."'>
            <input type='hidden' name='quantidade' value='".$row['quantidadeDivida']."'>
            <input type='hidden' name='lucroUnidade' value='".$row['lucroUnidade']."'>
            <input type='hidden' name='codigoUsuario' value='".$row['codigoUsuario']."'>
            <input type='hidden' name='codigoDivida' value='".$row['codigoDivida']."'>
            <button type='submit' class='btn btn-primary'>Pagar</button>

        </form>
        <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=divida&fase=excluir&id=".$row['codigoDivida']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
        

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=divida&fase=listar' method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados</p>";

}

?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "     Divida total: ".$dividaTotal." Mzn"?></strong></h3>

</div><?php
}
function fase1(){
    include('db.class.php');
    switch($_REQUEST['accao']){
        case 'listar':{
            ?>



<form action="?page=divida&accao=buscar&fase=1" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Clientes</h1>
    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>



</form>


<?php

  



    $sql = "SELECT * FROM clientes WHERE codigoCliente>1 order by nomeCliente";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();



if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do cliente</th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>
            
            <button onclick=\"location.href='?page=divida&accao=listar&fase=2&idCliente=".$row['codigoCliente']."'\" class='btn btn-primary'>".$row['nomeCliente']."</button>

            

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal?page=divida&fase=1'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}
            
        }break;
        case 'buscar':{
             $buscar=addslashes($_POST['buscar']);
            ?>



<form action="?page=divida&accao=buscar&fase=1" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Clientes</h1>
    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>



</form>
<p
    style="margin: 10px 10px 10px 30px; font-size:20px; width:max-content; background-color:rgba(0, 0, 0, 0.184);padding:10px">
    Resultados da busca pelo nome:<strong>
        <?php echo " ".$buscar ?></strong></p>

<?php

  

   

    $sql = "SELECT * FROM clientes WHERE codigoCliente>1 and (nomeCliente like'%$buscar' or nomeCliente like'%$buscar%' or nomeCliente like'$buscar%') order by nomeCliente";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();



if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do cliente</th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>
            
            <button onclick=\"location.href='?page=divida&accao=listar&fase=2&idCliente=".$row['codigoCliente']."'\" class='btn btn-primary'>".$row['nomeCliente']."</button>

            

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=divida&fase=1&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados !</p>";

}
            
        }break;
    
}
    
}




function fase2(){
    include('db.class.php');
    switch ($_REQUEST['accao']){
        case 'listar':{
             ?>
<form action="?page=divida&accao=buscar&fase=2" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Produtos</h1>
    <input type="hidden" name="idCliente" value="<?php print $_REQUEST['idCliente']?>">
    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>


</form>


<?php

  



    $sql = "SELECT * FROM produtos order by nomeProduto";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();



if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do produto</th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$count. "</td>";

        
        print "<td>
        <form action='?page=divida&fase=3' method='POST'>
        <input type='hidden' name='idCliente' value='".$_REQUEST['idCliente']."'>
        <input type='hidden' name='nomeProduto' value='".$row['nomeProduto']."'>
        <input type='hidden' name='idProduto' value='".$row['codigoProduto']."'>
        <input type='hidden' name='valorUnidade' value='".$row['valorUnidade']."'>

            <button type='submit' class='btn btn-primary'>".$row['nomeProduto']."</button>

        </form>

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=divida&fase=2&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}
            
        }break;
        case 'buscar':{
            
$buscar=addslashes($_POST['buscar']);
             ?>
<form action=" ?page=divida&accao=buscar&fase=2" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Produtos</h1>
    <input type="hidden" name="idCliente" value="<?php print $_REQUEST['idCliente']?>">
    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>


</form>
<p
    style="margin: 10px 10px 10px 30px; font-size:20px; width:max-content; background-color:rgba(0, 0, 0, 0.184);padding:10px">
    Resultados da busca pelo nome:<strong>
        <?php echo " ".$buscar ?></strong></p>

<?php

  


    $sql = "SELECT * FROM produtos WHERE (nomeProduto like'%$buscar' or nomeProduto like'%$buscar%' or nomeProduto like'$buscar%') order by nomeProduto";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();



if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do produto</th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$count. "</td>";

        
        print "<td>
        <form action='?page=divida&fase=3' method='POST'>
        <input type='hidden' name='idCliente' value='".$_REQUEST['idCliente']."'>
        <input type='hidden' name='nomeProduto' value='".$row['nomeProduto']."'>
        <input type='hidden' name='idProduto' value='".$row['codigoProduto']."'>
        <input type='hidden' name='valorUnidade' value='".$row['valorUnidade']."'>

            <button type='submit' class='btn btn-primary'>".$row['nomeProduto']."</button>

        </form>

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=divida&fase=2&accao=listar' Method='POST'>
    <input type='hidden' name='idCliente' value='".$_REQUEST['idCliente']."'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}
            
        }break;
   


}
}

function fase3(){


include('db.class.php');
?>

<form action="?page=divida" method="POST" class="form">
    <input type="hidden" name="fase" value="4">
    <input type="hidden" name="idCliente" value=" <?php print $_REQUEST['idCliente'] ?> ">
    <input type="hidden" name="nomeProduto" value=" <?php print $_REQUEST['nomeProduto'] ?> ">
    <input type="hidden" name="idProduto" value=" <?php print $_REQUEST['idProduto'] ?> ">
    <input type="hidden" name="valorUnidade" value=" <?php print $_REQUEST['valorUnidade'] ?> ">


    <div class=" mb-3">
        <label>Produto</label>
        <input type="text" name="produto" value="<?php print $_REQUEST['nomeProduto']; ?>" class="form-control"
            readonly>
    </div>

    <div class="mb-3">
        <label>Quantidade </label>
        <input type="number" name="qtd" class="form-control" autofocus required>
    </div>
    <div class="mb-3">
        <label>Descrição </label>
        <input type="text" name="desc" class="form-control" required>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>

</form>
<?php 
    
}

function fase4(){
include('db.class.php');
    
    if(isset($_POST['qtd']) && !empty($_POST['qtd'])){
        
        $quantidade=addslashes($_POST['qtd']);
        $idCliente= $_REQUEST['idCliente'] ;
        $idProduto= $_REQUEST['idProduto'] ;
        $valorUnidade =$_REQUEST['valorUnidade'];
        $descricao =$_POST['desc'];
        $valorPagar = $valorUnidade*$quantidade;
        $hoje = date("Y-m-d");
        $hora = date('H:i:s');
        $userId= $_SESSION['codigoUsuario'];
        $estado =0;

        $sql ="SELECT * FROM  estoques WHERE codigoProduto=?";
        $sql= $obj->prepare($sql);
        $sql->execute([$idProduto]);
        $dado = $sql->fetch();
        
        $novaQtd=$dado['quantidade']-$quantidade;
        if($novaQtd>=0){
            $sql ="UPDATE estoques SET quantidade=? WHERE codigoProduto=?";
            $sql= $obj->prepare($sql);
            if($sql->execute([$novaQtd,$idProduto])){

                $sql ="INSERT INTO dividas (codigoProduto, quantidadeDivida, valorDivida, codigoCliente, descricao, dataDivida, horaDivida, codigoUsuario, estado) Values(?,?,?,?,?,?,?,?,?)";
                $sql= $obj->prepare($sql);
                if($sql->execute([$idProduto,$quantidade,$valorPagar,$idCliente,$descricao,$hoje,$hora,$userId,$estado])){
                    print "<script>location.href='?page=novoServico&accao=listar'</script>";
                    
                }else{

            print "<script>alert('Erro ao registar a divida!')</script>";
            print "<script>location.href='?page=novoServico&accao=listar'</script>";
        }
           } else{

            print "<script>alert('Erro ao actualizar o stock!')</script>";
            print "<script>location.href='?page=novoServico&accao=listar'</script>";
        }
            
            
        
        
        
    }else{

            print "<script>alert('Stock insuficiente!')</script>";
            print "<script>location.href='?page=novoServico&accao=listar'</script>";
        }
    
    }
    
}

function pagar(){

    include('db.class.php');
    $cliente =$_REQUEST['codigoCliente'];
    $codigoDivida = addslashes($_REQUEST['codigoDivida']);
   
    $valorPagar = addslashes($_REQUEST['valorPagar']);
    
    $id  = addslashes($_REQUEST['codigoProduto']);
    
    $quantidade = addslashes($_REQUEST['quantidade']);
    
    $lucroUnidade = addslashes($_REQUEST['lucroUnidade']);

        $Lucro = $quantidade *$lucroUnidade;
        $Lucro = number_format($Lucro,2,'.','');
        $hoje = date("Y-m-d");
        $hora = date('H:i:s');
        $userId= $_REQUEST['codigoUsuario'];
            
            $sql="INSERT INTO vendas(codigoCliente,codigoProduto,quantidade,valorTotalVenda,lucroTotalVenda,dataVenda,horaVenda,codigoUsuario) values(?,?,?,?,?,?,?,?) ";
            $sql1 = $obj->prepare($sql);
           if( $sql1->execute([$cliente,$id,$quantidade , $valorPagar,$Lucro, $hoje,$hora, $userId])){
                $sql = "UPDATE dividas SET estado=1 WHERE codigoDivida =?";
                $sql1 = $obj->prepare($sql);
                $sql1->execute([$codigoDivida]);
                print "<script>location.href='?page=divida&fase=listar';</script>";
           }else{
            print "<script>alert('Pagamento não feito! ');</script>";
            print "<script>location.href='?page=novoServico&accao=listar';</script>";
           }
            
        
}

function excluir(){

    include('db.class.php');

    $codigoDivida = addslashes($_REQUEST['id']);

            
            $sql="DELETE FROM dividas WHERE codigoDivida=?";
            $sql1 = $obj->prepare($sql);
            $sql1->execute([$codigoDivida]);

                print "<script>location.href='?page=divida&fase=listar';</script>";
            
        
}

function filtro(){
    
    include('db.class.php');
    switch ($_REQUEST['accao']){
        case 'inicial':?>
    <form class="filtroForm" action="?page=divida&fase=filtrar" method="POST">
        <h1>Filtros</h1>
        <input type="hidden" name="accao" value="segunda">
        <div class="mb-3">
            <label for="">Data</label>
            <input name="data" type="date">
    
        </div>

        <label for="">Cliente: </label>
        <input type="text" name="cliente" placeholder="Nome do cliente">
        </div>
        <div class="mb-3">
            <button type="submit" class="fa fa-search"
                style="border-color:white ;background-color:transparent;padding:10px;width:max-content;margin-top:10px">Filtrar</button>
        </div>
    
    </form><?php
            break;
        case 'segunda':
            ?>
    
<form action="portal.php?page=divida&fase=buscar" class="formPesquisa" style="width: 100%;" method="POST">

<h1>Dividas</h1>

<input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
    style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

<button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>


</form>
<Div class="formAdd">
<form action="?page=divida&fase=filtrar" method="POST" style="width: 90%; margin:auto; margin-bottom:20px;">

    <input type="hidden" name="accao" value="inicial">

    <button class="btnFiltrar" type="submit">Filtrar</button>

</form>
</Div>

    
    <?php
            $data = addslashes($_POST['data']);
            $cliente = addslashes($_POST['cliente']);
            if(!empty($data) && !empty($cliente)){
                echo "======Filtro: ";
                echo "Dia:  ".$data.", ";
                echo "Codigo do usuário: ".$cliente;
    
                $sql = "SELECT * FROM dividas inner join usuarios inner join produtos inner join clientes WHERE dividas.codigoCliente=clientes.codigoCliente AND dividas.codigoProduto=produtos.codigoProduto AND dividas.codigoUsuario=usuarios.codigoUsuario AND (nomeCliente like '%$cliente' or nomeCliente like '%$cliente%' or nomeCliente like '$cliente%' ) and dataDivida=? order by horaDivida";
    
        $res = $obj->prepare($sql);
        $res -> execute([$data]);
        $qtd = $res -> rowCount();
       
        $dividaTotal=0;
    
        if($qtd > 0) {
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";
    
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



            print "<tr>";
        
            print "<th>#</th>";
        
            print "<th>Nome do cliente</th>";
            print "<th>Nome do produto</th>";
            print "<th>Quantidade</th>";
            print "<th>Valor </th>";
            print "<th>Data </th>";
            print "<th>Descrição </th>";
            print "<th>Usuário </th>";
            print "<th>Estado </th>";
            print "<th>Acção </th>";
        
        
            print "</tr>";
        
        
            $count=1;
            while($row = $res -> fetch()) {
                
                print "<tr>";
                print "<td>" .$row['codigoDivida']. "</td>";
                print "<td>" .$row['nomeCliente']. "</td>";
                print "<td>" .$row['nomeProduto']. "</td>";
                print "<td>" .$row['quantidadeDivida']. "</td>";
                print "<td>" .$row['valorDivida']. "</td>";
                print "<td>" .$row['dataDivida']. "</td>";
                print "<td>" .$row['descricao']. "</td>";
                print "<td>" .$row['nomeUsuario']. "</td>";
                if($row['estado']==0){
                    $dividaTotal += $row['valorDivida'];
                    print "<td style='color:red'><strong>Não paga</strong></td>";
                }else{
                    print "<td style='color:green'><strong>Paga</strong></td>";
                }
                
        
                print "<td>
                <form action='?page=divida&fase=pagar' method='POST'>
                    <input type='hidden' name='codigoCliente' value='".$row['codigoCliente']."'>
                    <input type='hidden' name='codigoProduto' value='".$row['codigoProduto']."'>
                    <input type='hidden' name='valorPagar' value='".$row['valorDivida']."'>
                    <input type='hidden' name='quantidade' value='".$row['quantidadeDivida']."'>
                    <input type='hidden' name='lucroUnidade' value='".$row['lucroUnidade']."'>
                    <input type='hidden' name='codigoUsuario' value='".$row['codigoUsuario']."'>
                    <input type='hidden' name='codigoDivida' value='".$row['codigoDivida']."'>
                    <button type='submit' class='btn btn-primary'>Pagar</button>
        
                </form>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=divida&fase=excluir&id=".$row['codigoDivida']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
                
        
                </td>";
        
                print "</tr>";
                $count+=1;
            }
        
                print "</table>";
        
        } else {
        
            print "<form action='portal.php?page=divida&fase=listar' method='POST'>
        
            <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
        
            </form>";
        
            print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
        
        }
        
        ?>
        
        <br>
        
        <div class="resultados">
        
            <h3 style="margin-left:20px ;"><strong><?php echo "     Divida total: ".$dividaTotal." Mzn"?></strong></h3>
        
        </div><?php  
    
            }else if(empty($data) &&  !empty($cliente)){
                echo "======Filtro: ";
                echo "Nome do usuário: ".$cliente;
    
                $sql = "SELECT * FROM dividas inner join usuarios inner join produtos inner join clientes WHERE dividas.codigoCliente=clientes.codigoCliente AND dividas.codigoProduto=produtos.codigoProduto AND dividas.codigoUsuario=usuarios.codigoUsuario AND (nomeCliente like '%$cliente' or nomeCliente like '%$cliente%' or nomeCliente like '$cliente%' ) order by horaDivida";
    
        $res = $obj->prepare($sql);
        $res -> execute();
        $qtd = $res -> rowCount();
   
        $dividaTotal=0;
    
        if($qtd > 0) {
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";
    
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



            print "<tr>";
        
            print "<th>#</th>";
        
            print "<th>Nome do cliente</th>";
            print "<th>Nome do produto</th>";
            print "<th>Quantidade</th>";
            print "<th>Valor </th>";
            print "<th>Data </th>";
            print "<th>Descrição </th>";
            print "<th>Usuário </th>";
            print "<th>Estado </th>";
            print "<th>Acção </th>";
        
        
            print "</tr>";
        
        
            $count=1;
            while($row = $res -> fetch()) {
                
                print "<tr>";
                print "<td>" .$row['codigoDivida']. "</td>";
                print "<td>" .$row['nomeCliente']. "</td>";
                print "<td>" .$row['nomeProduto']. "</td>";
                print "<td>" .$row['quantidadeDivida']. "</td>";
                print "<td>" .$row['valorDivida']. "</td>";
                print "<td>" .$row['dataDivida']. "</td>";
                print "<td>" .$row['descricao']. "</td>";
                print "<td>" .$row['nomeUsuario']. "</td>";
                if($row['estado']==0){
                    $dividaTotal += $row['valorDivida'];
                    print "<td style='color:red'><strong>Não paga</strong></td>";
                }else{
                    print "<td style='color:green'><strong>Paga</strong></td>";
                }
                
        
                print "<td>
                <form action='?page=divida&fase=pagar' method='POST'>
                    <input type='hidden' name='codigoCliente' value='".$row['codigoCliente']."'>
                    <input type='hidden' name='codigoProduto' value='".$row['codigoProduto']."'>
                    <input type='hidden' name='valorPagar' value='".$row['valorDivida']."'>
                    <input type='hidden' name='quantidade' value='".$row['quantidadeDivida']."'>
                    <input type='hidden' name='lucroUnidade' value='".$row['lucroUnidade']."'>
                    <input type='hidden' name='codigoUsuario' value='".$row['codigoUsuario']."'>
                    <input type='hidden' name='codigoDivida' value='".$row['codigoDivida']."'>
                    <button type='submit' class='btn btn-primary'>Pagar</button>
        
                </form>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=divida&fase=excluir&id=".$row['codigoDivida']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
                
        
                </td>";
        
                print "</tr>";
                $count+=1;
            }
        
                print "</table>";
        
        } else {
        
            print "<form action='portal.php?page=divida&fase=listar' method='POST'>
        
            <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
        
            </form>";
        
            print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
        
        }
        
        ?>
        
        <br>
        
        <div class="resultados">
        
            <h3 style="margin-left:20px ;"><strong><?php echo "     Divida total: ".$dividaTotal." Mzn"?></strong></h3>
        
        </div><?php
            }else if(!empty($data) &&  empty($usuario)){
                echo "======Filtro: ";
                echo "Dia:  ".$data.", ";
    
                $sql = "SELECT * FROM dividas inner join usuarios inner join produtos inner join clientes WHERE dividas.codigoCliente=clientes.codigoCliente AND dividas.codigoProduto=produtos.codigoProduto AND dividas.codigoUsuario=usuarios.codigoUsuario and dataDivida=? order by horaDivida";
    
        $res = $obj->prepare($sql);
        $res -> execute([$data]);
        $qtd = $res -> rowCount();
      $dividaTotal=0;
    
        if($qtd > 0) {
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";
    
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome do cliente</th>";
    print "<th>Nome do produto</th>";
    print "<th>Quantidade</th>";
    print "<th>Valor </th>";
    print "<th>Data </th>";
    print "<th>Descrição </th>";
    print "<th>Usuário </th>";
    print "<th>Estado </th>";
    print "<th>Acção </th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$row['codigoDivida']. "</td>";
        print "<td>" .$row['nomeCliente']. "</td>";
        print "<td>" .$row['nomeProduto']. "</td>";
        print "<td>" .$row['quantidadeDivida']. "</td>";
        print "<td>" .$row['valorDivida']. "</td>";
        print "<td>" .$row['dataDivida']. "</td>";
        print "<td>" .$row['descricao']. "</td>";
        print "<td>" .$row['nomeUsuario']. "</td>";
        if($row['estado']==0){
            $dividaTotal += $row['valorDivida'];
            print "<td style='color:red'><strong>Não paga</strong></td>";
        }else{
            print "<td style='color:green'><strong>Paga</strong></td>";
        }
        

        print "<td>
        <form action='?page=divida&fase=pagar' method='POST'>
            <input type='hidden' name='codigoCliente' value='".$row['codigoCliente']."'>
            <input type='hidden' name='codigoProduto' value='".$row['codigoProduto']."'>
            <input type='hidden' name='valorPagar' value='".$row['valorDivida']."'>
            <input type='hidden' name='quantidade' value='".$row['quantidadeDivida']."'>
            <input type='hidden' name='lucroUnidade' value='".$row['lucroUnidade']."'>
            <input type='hidden' name='codigoUsuario' value='".$row['codigoUsuario']."'>
            <input type='hidden' name='codigoDivida' value='".$row['codigoDivida']."'>
            <button type='submit' class='btn btn-primary'>Pagar</button>

        </form>
        <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=divida&fase=excluir&id=".$row['codigoDivida']."';}else{false;}\"  class='btn btn-danger'>Excluir</button>
        

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=divida&fase=listar' method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

} ?>

<br>

<div class="resultados">

    <h3 style="margin-left:20px ;"><strong><?php echo "     Divida total: ".$dividaTotal." Mzn"?></strong></h3>

</div><?php
            
            }
            break;
        default:
        echo "ERRO";
        break;
    
    }
    }


switch ($_REQUEST["fase"]){
    
    case 1 :{
        fase1();

    }break;
    case 2 :{
        fase2(); 

    }break;
    case 3 :{
        fase3();
}break;
 case 4 :{ 
    fase4();

}break; 
case 'listar':{

    listar();
    
}break;

case 'pagar':{

    pagar();
    
}break;
case 'filtrar':{

    filtro();
    
}break;

case 'excluir':{

    excluir();
    
}break;

case 'buscar':{

buscar($_POST['buscar']);
    
}break;
} 



?>