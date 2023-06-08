<?php



function vender(){
    include('db.class.php');
    

    ?>



<form action="?page=cliente&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Clientes</h1>

    <input style="padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


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

            <button onclick=\"location.href='?page=cliente&accao=registar&id=".$row['codigoCliente']."&valorPagar=".$_REQUEST['valorPagar']."&valorRecebido=".$_REQUEST['valorRecebido']."&codigoProduto=".$_REQUEST['codigoProduto']."';\" class='btn btn-primary'>".$row['nomeCliente']."</button>

            

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

function Clientes(){
    
    include('db.class.php');

    ?>



<form action="?page=cliente&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Clientes</h1>

    <input style="padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<form action="?page=cliente&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


    <button type="submit" class="fa fa-plus">Registar cliente</button>





</form>

<?php

  



    $sql = "SELECT * FROM clientes Order BY nomeCliente";



$res = $obj->prepare($sql);

$res -> execute();

$qtd = $res -> rowCount();



if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome</th>";
    print "<th>Contacto</th>";
    print "<th>Email </th>";
    print "<th>Acção</th>";


    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['nomeCliente']. "</td>";
        if($row['contactoCliente']==""){
        print "<td style='color:red'> Null</td>";
        }else{
            print "<td>" .$row['contactoCliente']. "</td>";
        }
        if($row['emailCliente']==""){
        print "<td style='color:red'> Null</td>";
        }else{
            print "<td>" .$row['emailCliente']. "</td>";
        }
        

        print "<td>
        <form action='?page=cliente' method='POST'>
            <input type='hidden' name='id' value='".$row['codigoCliente']."' >
            <input type='hidden' name='accao' value='editar' >
            <input type='hidden' name='fase' value='inicial' >
            <button type='submit' class='btn btn-primary'>Editar</button>
        </form>
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
function registar(){
    include('db.class.php');
    $cliente =$_REQUEST['id'];
    $valorPagar =$_REQUEST['valorPagar'];
    $valorRecebido= $_REQUEST['valorRecebido'] ;
    $id=$_REQUEST['codigoProduto'];
    
    $troco = $valorRecebido-$valorPagar;
    if($troco>=0){

        $sql ="SELECT  * FROM estoques inner join produtos WHERE produtos.codigoproduto=estoques.codigoProduto and produtos.codigoProduto =? order by nomeCliente";
        $sql1 = $obj->prepare($sql);
        $sql1->execute([$id]);
        $dado =$sql1->fetch();
        $qtdRestante=$dado['quantidade']-$_SESSION['quantidade'];
        $Lucro = ($_SESSION['quantidade']*$dado['lucroUnidade']);
        $Lucro = number_format($Lucro,2,'.','');
        $hoje = date("Y-m-d");
        $hora = date('H:i:s');
        $userId= $_SESSION['codigoUsuario'];
        if($qtdRestante>=0){
            
            $sql="INSERT INTO vendas(codigoCliente,codigoProduto,quantidade,valorTotalVenda,lucroTotalVenda,dataVenda,horaVenda,codigoUsuario) values(?,?,?,?,?,?,?,?) ";
            $sql1 = $obj->prepare($sql);
           if( $sql1->execute([$cliente,$id,$_SESSION['quantidade'], $valorPagar,$Lucro, $hoje,$hora, $userId])){
                $sql = "UPDATE estoques SET quantidade=? WHERE codigoProduto =?";
                $sql1 = $obj->prepare($sql);
                $sql1->execute([$qtdRestante,$id]);
                print "<script>location.href='?page=novoServico&accao=vender&fase=troco';</script>";
           }else{
            print "<script>alert('Venda não registada! ');</script>";
            print "<script>location.href='?page=novoServico&accao=listar';</script>";
           }
            
        }else{
            print "<script>alert('Estoque insuficiente!');</script>";
            print "<script>location.href='?page=novoServico&accao=listar';</script>";
        }
        
    }else{
        print "<script>alert('Valor insuficiente!');</script>";
        print "<script>location.href='?page=novoServico&accao=listar';</script>";
       
    }

}


function adicionar(){


    switch ($_REQUEST["fase"]){
        case 'inicial':{
            ?> <form action="?page=cliente" class="formAdicionar" method="POST">

    <input type="hidden" name="accao" value="adicionar">
    <input type="hidden" name="fase" value="final">

    <h1>Adicionar Cliente</h1>



    <div class="mb-3">

        <label>Nome do cliente</label>

        <input type="text" name="nome" class="form-control" required>

    </div>



    <div class="mb-3">

        <label>Contacto do cliente</label>

        <input type="number" name="contactoCliente" class="form-control">

    </div>



    <div class="mb-3">

        <label>E-mail do cliente</label>

        <input type="email" name="emailClicente" class="form-control">



        </input>

    </div>

    <div class="mb-3">

        <label>Localização</label>

        <input type="text" name="localizacaoCliente" class="form-control">

    </div>



    <div class="mb-3">

        <button type="submit" class="btn btn-primary">GUARDAR</button>

    </div>



    <?php

        }
        break;
        case 'final':{
            
        include("db.class.php");

        $nomeCliente = addslashes($_POST['nome']) ;
        
        $sql ="SELECT * FROM produtos where (produtos.nomeProduto like '%$nomeCliente' or produtos.nomeProduto like '%$nomeCliente%' or produtos.nomeProduto like '$nomeCliente%' )";
        
            $sql1 = $obj->prepare($sql);
        
            $sql1->execute();
        
            $qtd = $sql1 -> rowCount();
        
                if($qtd<=0){
        
        
                       
        
                       $nomeCliente = addslashes($_POST['nome']) ;
                       

                        if($_POST['contactoCliente']==""){
                            $contactoCliente = null;
                        }else{
                            $contactoCliente = addslashes($_POST['contactoCliente']);
                        }
                        if(!isset($_POST['emailCliente'])){
                            $emailCliente = null;
                        }else{
                            $emailCliente = addslashes($_POST['emailCliente']);
                        }
                        if(!isset($_POST['LocalizacaoCliente'])){
                            $LocalizacaoCliente = null;
                        }else{
                            $LocalizacaoCliente = addslashes($_POST['LocalizacaoCliente']);
                        }

                        $sql ="INSERT INTO clientes (nomeCliente, contactoCliente, emailCliente, localizacaoCliente) values (?,?,?,?)";
                        $sql1 = $obj->prepare($sql);
                        if($sql1->execute([$nomeCliente,$contactoCliente,$emailCliente,$LocalizacaoCliente])){
                       
                            print "<script>location.href='?page=cliente&accao=cliente';</script>";

                        }else{
                             print "<script>alert('Erro ao registar o cliente');</script>";
                        print "<script>location.href='?page=cliente&accao=adicionar&fase=inicial';</script>";
                        }
                        

        
                    
        }else{
        
                        print "<script>alert('O cliente já está registado');</script>";
                        print "<script>location.href='?page=cliente&accao=adicionar&fase=inicial';</script>";
        
                    }
    }break;

}
}

function editar()
{
    include('db.class.php');

    switch ($_REQUEST['fase']){
        case 'inicial':{
            $sql = "SELECT * FROM clientes  where codigocliente=?";



            $res = $obj->prepare($sql);

            $res -> execute([$_REQUEST['id']]);

        if($dado = $res->fetch()){

            $nomeCliente=$dado['nomeCliente'];

            $contactoCliente=$dado['contactoCliente'];

            $emailCliente=$dado['emailCliente'];

            $LocalizacaoCliente=$dado['localizacaoCliente'];
            $codigoCiente = $dado['codigoCliente'];


            ?>

    <form class="EditarForm" action="?" method="POST">

        <h1>Edição do cliente: <?php echo $nomeCliente ?></h1>
        <input type="hidden" name="page" value="cliente">
        <input type="hidden" name="accao" value="editar">
        <input type="hidden" name="fase" value="final">

        <input type="hidden" name="id" value="<?php echo $codigoCiente?>">

        <div class="mb-3">

            <label>Nome do cliente</label>

            <input type="text" name="nome" class="form-control" value="<?php echo $nomeCliente ?>">

        </div>



        <div class="mb-3">

            <label>Contacto do cliente</label>

            <input type="text" name="contactoCliente" class="form-control" value="<?php echo $contactoCliente ?>">

        </div>



        <div class="mb-3">

            <label>E-mail do cliente</label>

            <input type="email" name="emailCliente" class="form-control" value="<?php echo $emailCliente ?>">

        </div>



        <div class="mb-3">

            <label>Localização do cliente</label>

            <input type="text" name="localizacaoCliente" class="form-control" value="<?php echo $LocalizacaoCliente ?>">

        </div>



        </div>

        <div class="mb-3">
            <h3 for="" style="display: block; margin-left:5%;text-decoration:underline"></h3>
            <button type="submit" class="fa" id="salvar"
                style="padding:10px;width:max-content;margin-top:10px;display:inline">SALVAR</button>

        </div>



    </form>



    <?php

        }
        }break;
        case 'final':{
            $codigoCiente=addslashes($_REQUEST['id']);
        if(isset($_POST['nome']) && !empty($_POST['nome'])){

            
            $nomeCliente=addslashes($_POST['nome']);
            $contactoCliente="";
            $emailCliente="";
            $localizacaoCliente="";
            if(!empty($_POST['contactoCliente'])){
                $contactoCliente=addslashes($_POST['contactoCliente']);
            }else{
                $contactoCliente=NULL;
            }
            if(!empty($_POST['emailCliente'])){
                $emailCliente=addslashes($_POST['emailCliente']);
            }else{
                $emailCliente=NULL;
            }
            if(!empty($_POST['localizacaoCliente'])){
                $localizacaoCliente=addslashes($_POST['localizacaoCliente']);
            }else{
                $localizacaoCliente=NULL;
            }

            $sql ="UPDATE clientes SET nomeCliente=?, contactoCliente=?, emailCliente=?, localizacaoCliente=? WHERE codigoCliente=?";
            $sql = $obj->prepare($sql);
            if($sql->execute([$nomeCliente,$contactoCliente,$emailCliente,$localizacaoCliente,$codigoCiente])){
                
                
                print "<script>location.href='?page=cliente&accao=cliente';</script>";
            }
        }else{
            print "<script>alert('Por favor preencha o campo nome!')</script>";
            print "<script>location.href='?page=cliente&accao=editar&fase=inicial&id=".$codigoCiente."'</script>";
        }

    }
    }

    
}

function buscar($nome){


    include('db.class.php');
    

    $sql ="SELECT * FROM clientes  where (nomeCliente like '%$nome' or nomeCliente like '%$nome%' or nomeCliente like '$nome%' ) order by nomeCliente";

    $sql1 = $obj->prepare($sql);

    $sql1->execute();

    $qtd = $sql1 -> rowCount();



    ?>



    <form action="?page=cliente&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

        <h1>Clientes</h1>

        <input style="padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..." value="<?php echo $nome?>"
            style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>

        <input type="hidden" name="accao" value="buscar">

        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

    </form>

    <form action="?page=cliente&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


        <button type="submit" class="fa fa-plus">Registar cliente</button>


    </form>

    <?php
    if($qtd > 0) {
 print "<table class='table table-hover table-striped table-bordered formPesquisa'>";
    print "<tr>";

    print "<th>#</th>";

    print "<th>Nome</th>";
    print "<th>Contacto</th>";
    print "<th>Email</th>";
    print "<th>Acção</th>";


    print "</tr>";


    $count=1;
    while($row = $sql1 -> fetch()) {
        
        print "<tr>";
        print "<td>" .$count. "</td>";
        print "<td>" .$row['nomeCliente']. "</td>";
        if($row['contactoCliente']==""){
        print "<td style='color:red'> Null</td>";
        }else{
            print "<td>" .$row['contactoCliente']. "</td>";
        }
        if($row['emailCliente']==""){
        print "<td style='color:red'> Null</td>";
        }else{
            print "<td>" .$row['emailCliente']. "</td>";
        }
        

        ?><input type='hidden' name='accao' value='editar'>;
    <input type='hidden' name='fase' value='inicial'>;
    <?php
        print "<td>
            <button onclick=\"location.href='?page=cliente'\" class='btn btn-primary'>Editar</button>

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
switch ($_REQUEST["accao"]){

    case 'listar':{
        Vender();

    }break;

    case 'registar':{
    registar();
    }break;
    case 'cliente':{
        Clientes();

    }break;
    case 'adicionar':{
        adicionar();

    }break;
    case 'buscar':{
        buscar($_POST['buscar']);

    }break;
    case 'editar':{
        editar();

    }break;
    default:{
        echo 'erro';
    }

}

?>