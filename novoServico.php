<?php


function listarProduto(){

    
if($_SESSION['acessoUsuario']=='A' or $_SESSION['acessoUsuario']=='B'){
     include('db.class.php');


    $sql = "SELECT * FROM estoques inner join produtos WHERE produtos.codigoProduto=estoques.codigoProduto and quantidade<10 and produtos.codigoEmpresa=? ";
    $sql = $obj->prepare($sql);
    $sql->execute([$_SESSION['codigoEmpresa']]);
    $quant = $sql->rowCount();
    if($quant>0 && $_SESSION['estadoServico']=="chegada"){
         $_SESSION['estadoServico']="trabalhando";
    print "<script>
        alert('Bem vindo ".$_SESSION['nomeCompletoUsuario'].", exite ".$quant." produtos que necessitam de abastecimento, por favor verifique o stock!');</script>";
    
    }else if($_SESSION['estadoServico']=="chegada"){
        $_SESSION['estadoServico']="trabalhando";
        
        print "<script>setTimeout(function(){
        alert('Bem vindo ".$_SESSION['nomeCompletoUsuario'].", desejamos um bom trabalho para si!');},3000)
        </script>";
    }

    ?>

<form action="?page=novoServico&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Vender</h1>

    <input style="margin-top:0px;padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>
<Div class="formAdd">
    <form action="?page=novoServico&accao=vendaEspecial" style="width: 90%; margin:auto; margin-right:5%;"
        method="POST">
        <input type="hidden" name="fase" value="inicial">

        <button type="submit" class="fa fa">Venda especial</button>

    </form>

    <form action="?page=divida&accao=listar" style="padding:0px 0px 0px 0px;margin:0px" method="POST">
        <input type="hidden" name="fase" value="1">

        <button type="submit" class="fa fa" id="divida"> Registar divida</button>

    </form>


</Div>



<?php
    
       
    
    
    
            $sql = "SELECT produtos.codigoProduto, nomeProduto,quantidade, valorUnidade, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoEmpresa=? ORDER BY produtos.nomeProduto";
    
    
    
        $res = $obj->prepare($sql);
    
        $res -> execute([$_SESSION['codigoEmpresa']]);
    
        $qtd = $res -> rowCount();
    
    
    
        if($qtd > 0) {
    
            print "<table class='table table-hover table-striped table-bordered formPesquisa'>";
    
    
    
            print "<tr>";
    
            print "<th>#</th>";
          
    
            print "<th>Produto</th>";
    
            print "<th>Stock</th>";
    
            print "<th>Valor venda</th>";
    
        
    
            print "<th>Acções</th>";
    
            print "</tr>";
    
            $count =1;
    
            while($row = $res -> fetch()) {
    
                print "<tr>";
    
                print "<td>" .$count. "</td>";
               
    
                print "<td>" .$row['nomeProduto']. "</td>";
    
                print "<td>" .$row['quantidade']. "</td>";
    
                print "<td>" .$row['valorUnidade']. "</td>";
    
                
    
                print "<td>
    
                    <button onclick=\"location.href='?page=novoServico&accao=vender&fase=inicial&id=".$row['codigoProduto']."';\" class='btn btn-success'>Vender</button>
    
                    
    
                </td>";
    
                print "</tr>";
                $count +=1;
    
            }
    
                print "</table>";
    
        } else {
    
            print "<form action='?page=novoServico&accao=listar' Method='POST'
    
            <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    
            </form>";
    
            print "<p class='alert alert-danger'>Não encontrou resultados!</p>";
    
            
    
        }
    
    }else{
    
        print "<script class='alert alert-danger'> alert('Ola ".$_SESSION['nomeCompletoUsuario'].", por questões de segurança não é permitido efectuar uma venda!')</script>";
        print "<script class='alert alert-danger'> location.href='?page=venda&accao=listar';</script>";
    }  
    
    ?>

<button></button>
<?php
}


function buscarProduto(){
    $nome=$_POST['buscar'];
    
    ?>
<form action="?page=novoServico&accao=buscar" class="formPesquisa" style="width: 90%; margin:auto" method="POST">

    <div class="mb-3">
        <h1>Vender</h1>
        <input type="search" name="buscar" placeholder="Pesquise pelo nome..." value="<?php echo $nome?>"
            style="width: 80%;outline: none; border-radius: 4px; padding-left:2%; margin-left:5%;margin-top:0px;padding-top:0px;"
            autofocus required>
        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    </div>

</form>

<?php
include('db.class.php');
$buscar = addslashes($_POST['buscar']);
$sql = "SELECT produtos.codigoProduto, nomeProduto,quantidade, valorUnidade, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto AND (produtos.nomeProduto like '%$buscar' or produtos.nomeProduto like '%$buscar%' or produtos.nomeProduto like '$buscar%') AND produtos.codigoEmpresa=?";

$res = $obj->prepare($sql);
$res -> execute([$_SESSION['codigoEmpresa']]);
$qtd = $res -> rowCount();

if($qtd > 0) {
    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";

    print "<tr>";
    print "<th>#</th>";
    print "<th>Produto</th>";
    print "<th>Stock</th>";
    print "<th>Valor venda</th>";

    print "<th>Acções</th>";
    print "</tr>";
    $count =1;
    while($row = $res -> fetch()) {
        print "<tr>";
        print "<td>" .$count. "</td>";
        
        print "<td>" .$row['nomeProduto']. "</td>";
        print "<td>" .$row['quantidade']. "</td>";
        print "<td>" .$row['valorUnidade']. "</td>";
   
        print "<td>
            <button onclick=\"location.href='?page=novoServico&accao=vender&fase=inicial&id=".$row['codigoProduto']."';\" class='btn btn-success'>Vender</button>
            
        </td>";
        print "</tr>";
        $count+=1;
    }
        print "</table>";
} else {
    print "<form action='portal.php?page=novoServico&accao=listar' Method='POST'>
    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>
    </form>";
    print "<p class='alert alert-danger'>Não encontrou resultados !</p>";
}
}

function vendaEspecial(){
    include('db.class.php');
    switch ($_REQUEST["fase"]){
        
    
    case 'inicial':{
        
        ?>
<form action="?page=novoServico&accao=vendaEspecial&fase=buscar" class="formPesquisa" style="width: 100%;"
    method="POST">

    <h1><?php echo 'Venda especial';?></h1>

    <input style="padding-top:0px;" type="search" name="procurar" placeholder="Pesquise pelo nome..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" autofocus required>

    <input type="hidden" name="fase" value="buscar">

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>
<?php

                $sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and tipoVenda=1 AND produtos.codigoEmpresa=? ORDER BY produtos.nomeProduto";



                $res = $obj->prepare($sql);

                $res -> execute([$_SESSION['codigoEmpresa']]);

                $qtd = $res -> rowCount();



                if($qtd > 0) {

                    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



                    print "<tr>";

                    print "<th>#</th>";
                    

                    print "<th>Produto</th>";

                    print "<th>Stock</th>";

                    print "<th>Valor venda</th>";
               
                    print "<th>Acções</th>";

                    print "</tr>";


                    $count =1;
                    while($row = $res -> fetch()) {

                        print "<tr>";
                        print "<td>" .$count. "</td>";
                      
                        print "<td>" .$row['nomeProduto']. "</td>";

                        print "<td>" .$row['quantidade']. "</td>";

                        print "<td>" .$row['valorUnidade']. "</td>";

                      

                        print "<td>

                            <button onclick=\"location.href='?page=novoServico&accao=vendaEspecial&fase=segunda&id=".$row['codigoProduto']."';\" class='btn btn-success'>Vender</button>

                            

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
                break;
                case 'segunda':{
                    $sql = "SELECT produtos.codigoProduto, nomeProduto,quantidade, valorUnidade, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoProduto=".$_REQUEST["id"];
                    $res = $obj->prepare($sql);
                    $res ->execute();
                    $row = $res->fetch();
                    $_SESSION['valorUnidade']=$row['valorUnidade'];
                    $_SESSION['nomeProduto']=$row['nomeProduto'];
                ?>

<form action="?page=novoServico&accao=vendaEspecial&fase=final" method="POST" class="form">
    <input type="hidden" name="fase" value="final">
    <input type="hidden" name="id" value="<?php print $row['codigoProduto']; ?>">

    <div class="mb-3">
        <h1 style="text-align: center;"><?php echo 'Venda de produto por preço'?></h1>
    </div>
    <div class="mb-3">
        <label>Produto</label>
        <input type="text" name="produto" value="<?php print $row['nomeProduto']; ?>" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label>Valor </label>
        <input type="number" name="valor" class="form-control" autofocus required>
    </div>
    <div class="mb-3">
        <label>Cliente </label>
        <select name="cliente" class="form-control">
            <option value="Geral">Geral</option>
        </select>
    </div>




    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>

</form>
<?php
                }
                break;
                case 'final':{
                   
                   
                    if(isset($_POST['valor']) && !empty($_POST['valor'])) {

                        require_once('db.class.php');
                        $valorPagar = addslashes($_POST['valor']);
                        $id  = addslashes($_REQUEST['id']);
                        $cliente = 1;
                       
                        
                        $sql ="SELECT  * FROM estoques inner join produtos WHERE produtos.codigoproduto=estoques.codigoProduto and produtos.codigoProduto =?";
                            $sql1 = $obj->prepare($sql);
                            $sql1->execute([$id]);
                            $dado =$sql1->fetch();
                            
                            $Lucro = ($valorPagar *$dado['percentagemLucro'])/100;
                            $Lucro = number_format($Lucro,2,'.','');
                            $hoje = date("Y-m-d");
                            $hora = date('H:i:s');
                            $userId= $_SESSION['codigoUsuario'];
                            $quantidade = $valorPagar/$dado['valorUnidade'];
                            $qtdRestante=$dado['quantidade']-$quantidade;
                            if($qtdRestante>=0){
                                
                                $sql="INSERT INTO vendas(codigoCliente,codigoProduto,quantidade,valorTotalVenda,lucroTotalVenda,dataVenda,horaVenda,codigoUsuario) values(?,?,?,?,?,?,?,?) ";
                                $sql1 = $obj->prepare($sql);
                            if( $sql1->execute([$cliente,$id,$quantidade, $valorPagar,$Lucro, $hoje,$hora, $userId])){
                                    $sql = "UPDATE estoques SET quantidade=? WHERE codigoProduto =?";
                                    $sql1 = $obj->prepare($sql);
                                    $sql1->execute([$qtdRestante,$id]);
                            
                                    print "<script>location.href='?page=novoServico&accao=listar';</script>";
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
                break;
                case 'buscar':{
                    if(isset($_POST['procurar']) && !empty($_POST['procurar'])){?>
<form action="?page=novoServico&accao=vendaEspecial&fase=buscar" class="formPesquisa" style="width: 100%;"
    method="POST">

    <h1><?php echo 'Venda especial';?></h1>

    <input style="padding-top:0px;" type="search" name="procurar" placeholder="Pesquise pelo nome..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required>

    <input type="hidden" name="fase" value="buscar">

    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>
    <p style="margin: 10px 10px 10px 30px; font-size:20px; width:max-content;
                             ">Resultados da busca pelo produto:<strong> <?php echo " ".$_POST['procurar'] ?></strong>
    </p>
    </div>

</form>
<?php
                        $buscar=addslashes($_POST['procurar']);
                         $sql = "SELECT produtos.codigoProduto, nomeProduto,quantidade, valorUnidade, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and (produtos.nomeProduto like '%$buscar' or produtos.nomeProduto like '%$buscar%' or produtos.nomeProduto like '$buscar%') AND tipoVenda=1 and produtos.codigoEmpresa=? ORDER BY produtos.nomeProduto";

                         $res = $obj->prepare($sql);
         
                         $res -> execute([$_SESSION['codigoEmpresa']]);
         
                         $qtd = $res -> rowCount();
         
         
         
                         if($qtd > 0) {
         
                             print "<table class='table table-hover table-striped table-bordered formPesquisa'>";
         
         
         
                             print "<tr>";
         
                             print "<th>#</th>";

         
                             print "<th>Produto</th>";
         
                             print "<th>Stock</th>";
         
                             print "<th>Valor venda</th>";
                  
                             print "<th>Acções</th>";
         
                             print "</tr>";
         
                            $count =1;
         
                             while($row = $res -> fetch()) {
         
                                 print "<tr>";

                                 print "<td>" .$count. "</td>";
                           
         
                                 print "<td>" .$row['nomeProduto']. "</td>";
         
                                 print "<td>" .$row['quantidade']. "</td>";
         
                                 print "<td>" .$row['valorUnidade']. "</td>";
         
         
                                 print "<td>
         
                                     <button onclick=\"location.href='?page=novoServico&accao=vendaEspecial&fase=segunda&id=".$row['codigoProduto']."';\" class='btn btn-success'>Vender</button>
         
                                     
         
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
                }
                break;
                default:
                echo 'erro manipularVenda: Venda especial/venda Preço';
                break;
        }
    
    }


    function vender(){

        switch ($_REQUEST["fase"]){
            case 'inicial':{

                
        include('db.class.php');


        $sql = "SELECT produtos.codigoProduto, nomeProduto,quantidade, valorUnidade, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoEmpresa=? and produtos.codigoProduto=".$_REQUEST["id"];
        $res = $obj->prepare($sql);
        $res ->execute([$_SESSION['codigoEmpresa']]);
        $row = $res->fetch();
        $_SESSION['valorUnidade']=$row['valorUnidade'];
        $_SESSION['nomeProduto']=$row['nomeProduto'];
    ?>

<form action="?page=novoServico" method="POST" class="form">
    <input type="hidden" name="accao" value="vender">
    <input type="hidden" name="fase" value="segunda">
    <input type="hidden" name="id" value="<?php print $row['codigoProduto']; ?>">

    <div class="mb-3">
        <h1>Venda de produto</h1>
    </div>
    <div class="mb-3">
        <label>Produto</label>
        <input type="text" name="produto" value="<?php print $row['nomeProduto']; ?>" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label>Quantidade</label>
        <input type="number" name="quantidade" class="form-control" autofocus required>
    </div>




    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>

</form>
<?php
    

            }
            break;

            case 'segunda':{

                $id  = addslashes($_POST['id']);
if(isset($_POST['quantidade']) && !empty($_POST['quantidade']) ){

    include('db.class.php');
    $quantidade = addslashes($_POST['quantidade']);
    
    $_SESSION['quantidade']=$quantidade;

            $sql ="SELECT * FROM estoques WHERE codigoProduto =?";
            $sql1 = $obj->prepare($sql);
            $sql1->execute([$id,]);
            $dado =$sql1->fetch();

        if($dado){
            $conta= $_SESSION['valorUnidade'] * $quantidade;
           ?>
<form action="?page=novoServico" method="POST" class="form">
    <input type="hidden" name="accao" value="vender">
    <input type="hidden" name="fase" value="final">
    <input type="hidden" name="id" value="<?php print $dado['codigoProduto']; ?>">

    <div class="mb-3">
        <h1>Venda de produto</h1>
    </div>
    <div class="mb-3">
        <label>Produto</label>
        <input type="text" name="produto" value="<?php print $_SESSION['nomeProduto']; ?>" class="form-control"
            readonly>
    </div>

    <div class="mb-3">
        <label>Valor a pagar</label>
        <input type="number" name="valorPagar" class="form-control" value="<?php print $conta; ?>" autoFocus readonly>
    </div>



    <div class="mb-3">
        <label>Cliente </label>
        <select name="cliente" class="form-control">
            <option value="Geral">Geral</option>
            <option value="especial">Nome do Cliente </input></option>
        </select>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Confirmar</button>
    </div>



</form>

<?php
            
        }else{
            print "<script> location.href='?page=novoServico&accao=vender&fase=inicial&id=".$id."';</script>";
            
            
        }
   
}else{
    print "<script> location.href='?page=novoServico&accao=vender&fase=inicial&id=".$id."';</script>";
}

            }
            break;

            case 'final':{

                
if(isset( $_POST['valorPagar']) && !empty($_POST['valorPagar'])) {

    include('db.class.php');
    $cliente =$_POST['cliente'];
    $valorPagar = addslashes($_POST['valorPagar']);
    $id  = addslashes($_POST['id']);
    if($_POST['cliente']=='Geral'){
    

        $sql ="SELECT  * FROM estoques inner join produtos WHERE produtos.codigoproduto=estoques.codigoProduto and produtos.codigoProduto =?";
        $sql1 = $obj->prepare($sql);
        $sql1->execute([$id]);
        $dado =$sql1->fetch();
        $qtdRestante=$dado['quantidade']-$_SESSION['quantidade'];
        $Lucro = ($_SESSION['quantidade'] *$dado['lucroUnidade']);
        $Lucro = number_format($Lucro,2,'.','');
        $hoje = date("Y-m-d");
        $hora = date('H:i:s');
        $userId= $_SESSION['codigoUsuario'];
        $_SESSION['troco']=$troco;
        $cliente='1';
        if($qtdRestante>=0){
            
            $sql="INSERT INTO vendas(codigoCliente,codigoProduto,quantidade,valorTotalVenda,lucroTotalVenda,dataVenda,horaVenda,codigoUsuario) values(?,?,?,?,?,?,?,?) ";
            $sql1 = $obj->prepare($sql);
           if( $sql1->execute([$cliente,$id,$_SESSION['quantidade'], $valorPagar,$Lucro, $hoje,$hora, $userId])){
                $sql = "UPDATE estoques SET quantidade=? WHERE codigoProduto =?";
                $sql1 = $obj->prepare($sql);
                $sql1->execute([$qtdRestante,$id]);
           
                print "<script>location.href='?page=novoServico&accao=listar';</script>";
           }else{
            print "<script>alert('Venda não registada! ');</script>";
            print "<script>location.href='?page=novoServico&accao=listar';</script>";
           }
            
        }else{
            print "<script>alert('Estoque insuficiente!');</script>";
            print "<script>location.href='?page=novoServico&accao=listar';</script>";
        }
        
    }else{

      
        print "<script>location.href='?page=cliente&accao=listar&codigoProduto=".$id."&valorPagar=".$valorPagar."&valorRecebido=".$valorRecebido."';</script>";
    }

}else{
    print "<script>location.href='?page=novoServico&accao=listar';</script>";
}


            }
            break;
        }

        
    }

switch ($_REQUEST["accao"]) {
    case 'listar':{
        listarProduto();
    }
        
    break;
    case 'buscar':{
        if(isset($_POST['buscar']) && !empty($_POST['buscar'])){
            buscarProduto();
        } else {
            
            print "<script> location.href='?page=novoServico&accao=listar'; </script>";
        }
        
    }
        
        break;
    case 'vendaEspecial':{
        vendaEspecial();
    }
        
        break;
    case 'vender':{
        vender();
    }
        
        break;
    
    default:
        # code...
        break;
}

?>