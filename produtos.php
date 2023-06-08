<?php


function listarProduto(){
    include('db.class.php');
    

    ?>



<form action="?page=produto&accao=buscar" class="formPesquisa" style="width: 100%;" method="POST">

    <h1>Produtos</h1>

    <input style="padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..."
        style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>


    <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

</form>

<form action="?page=produto&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">


    <button type="submit" class="fa fa-plus">Adicionar Produto</button>



</form>

<?php

  



    $sql = "SELECT produtos.codigoProduto, nomeProduto,quantidadeProduto, valorUnidade,percentagemLucro, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoEmpresa=? ORDER BY nomeProduto";



$res = $obj->prepare($sql);

$res -> execute([$_SESSION['codigoEmpresa']]);

$qtd = $res -> rowCount();



if($qtd > 0) {

    print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



    print "<tr>";

    print "<th>#</th>";

    print "<th>Produto</th>";

    print "<th>Qtd.</th>";

    print "<th>Valor venda</th>";
print "<th>Perc. lucro </th>";

    print "<th>Acções</th>";

    print "</tr>";


    $count=1;
    while($row = $res -> fetch()) {
        
        print "<tr>";
        print "<td>" .$row['codigoProduto']. "</td>";

        print "<td>" .$row['nomeProduto']. "</td>";

        print "<td>" .$row['quantidadeProduto']. "</td>";

        print "<td>" .$row['valorUnidade']. "</td>";
        print "<td>" .$row['percentagemLucro']."%". "</td>";

        print "<td>

            <button onclick=\"location.href='?page=produto&accao=editar&id=".$row['codigoProduto']."';\" class='btn btn-success'>Editar</button>

            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=produto&accao=excluir&id=".$row['codigoProduto']."&permicao=pedido';}else{false;}\"  class='btn btn-danger'>Excluir</button>

        </td>";

        print "</tr>";
        $count+=1;
    }

        print "</table>";

} else {

    print "<form action='portal.php?page=produto&accao=listar' Method='POST'>

    <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

    </form>";

    print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

}

}


function edital()
{
    include('db.class.php');
    $sql = "SELECT * FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoProduto=? ORDER BY nomeProduto";



    $res = $obj->prepare($sql);

    $res -> execute([$_REQUEST['id']]);

   if($dado = $res->fetch()){

    $nomeProduto=$dado['nomeProduto'];

    $valorLevantameto=$dado['valorLevantamento'];

    $valorVenda=$dado['valorUnidade'];

    $codigoProduto= $dado['codigoProduto'] ;

    $quantidade = $dado['quantidadeProduto'];

    ?>

<form class="EditarForm" action="?page=produto&accao=actualizar" method="POST">

    <h1>Edição do produto: <?php echo $nomeProduto ?></h1>

    <input type="hidden" name="accao" value="actualizar">

    <input type="hidden" name="quantidade" value="<?php echo $quantidade?>">

    <input type="hidden" name="id" value="<?php echo $codigoProduto?>">

    <div class="mb-3">

        <label>Nome do produto</label>

        <input type="text" name="nome" class="form-control" value="<?php echo $nomeProduto ?>" required>

    </div>



    <div class="mb-3">

        <label>Valor de levantamento</label>

        <input type="number" name="valorLevantamento" class="form-control" value="<?php echo $valorLevantameto ?>"
            required>

    </div>



    <div class="mb-3">

        <label>Valor por unidade</label>

        <input type="number" name="valorUnidade" class="form-control" value="<?php echo $valorVenda ?>" required>

    </div>



    </div>

    <div class="mb-3">
        <h3 for="" style="display: block; margin-left:5%;text-decoration:underline">SALVAR</h3>
        <button name="tipo" value="simples" type="submit" class="fa" id="salvar"
            style="padding:10px;width:max-content;margin-top:10px;display:inline">Simples</button>
        <button name="tipo" value="avancada" type="submit" class="fa" id="salvar"
            style="padding:10px;width:max-content;margin-top:10px">Avançada</button>

    </div>



</form>



<?php

}
}
function actualizar(){
    include('db.class.php');
    switch ($_REQUEST["tipo"]){
        case 'simples':{
            
                        
            $nomeProduto = addslashes($_POST['nome']) ;

            $valorLevantamento = addslashes($_POST['valorLevantamento']);

            $valorUnidade = addslashes($_POST['valorUnidade']);

            $codigoEmpresa = addslashes($_SESSION['codigoEmpresa']);

            $quantidade = addslashes($_POST['quantidade']);

                        $valorTotalVenda = $valorUnidade*$quantidade;
                        
                        $valorLevantamentoUnidade=ceil($valorLevantamento/$quantidade);
                        $lucroTotal = $valorTotalVenda-$valorLevantamento;
                         $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);
                         $percentagemLucro = ($lucroUnidade*100)/$valorUnidade;
                        $percentagemLucro = number_format($percentagemLucro,2,'.','');

            

                $sql = "UPDATE produtos set nomeProduto=?,valorLevantamento=?,valorLevantamentoUnidade=?,valorUnidade=?,lucroUnidade=?,valorTotalVenda=?,lucroTotal=?,percentagemLucro=?,codigoEmpresa=? WHERE codigoProduto=?";

                $sql1 = $obj->prepare($sql);

                if($sql1->execute([$nomeProduto,$valorLevantamento,$valorLevantamentoUnidade,$valorUnidade,$lucroUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$_REQUEST['id']])){


                print "<script>location.href='portal.php?page=produto&accao=listar';</script>";



            }else{

                print "<script>alert('Falha ao actualizar o produto! ');</script>";

                print "<script>location.href='portal.php?page=produto&accao=listar';</script>";

            }
            
        }
            break;
        case 'avancada':{

            $nomeProduto = addslashes($_POST['nome']) ;

            $valorLevantamento = addslashes($_POST['valorLevantamento']);

            $valorUnidade = addslashes($_POST['valorUnidade']);

            $codigoEmpresa = addslashes($_SESSION['codigoEmpresa']);

            $quantidade = addslashes($_POST['quantidade']);

            $valorTotalVenda = $valorUnidade*$quantidade;

            $lucroTotal = $valorTotalVenda-$valorLevantamento;

            $percentagemLucro = ($lucroTotal*100)/$valorLevantamento;
            $valorLevantamentoUnidade=ceil($valorLevantamento/$quantidade);
            $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);

            $percentagemLucro = number_format($percentagemLucro,2,'.','');
            if($percentagemLucro<25){


                $lucroTotal = ($valorLevantamento*25)/100;
        
                $valorUnidade=($valorLevantamento+$lucroTotal)/$quantidade;
                $percentagemLucro = ($lucroTotal*100)/$valorLevantamento;
                $percentagemLucro = number_format($percentagemLucro,2,'.','');

                 

                 if(($valorUnidade*10) % 10 !=0 ){

                $valorUnidade=ceil($valorUnidade/5)*5;

                    $valorTotalVenda = $valorUnidade*$quantidade;
                    

                    $lucroTotal = $valorTotalVenda-$valorLevantamento;
                    $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);

                    $percentagemLucro = ($lucroTotal*100)/$valorLevantamento;
                    $percentagemLucro = number_format($percentagemLucro,2,'.','');
            

                    $sql = "UPDATE produtos set nomeProduto=?,valorLevantamento=?,valorLevantamentoUnidade=?,valorUnidade=?,lucroUnidade=?,valorTotalVenda=?,lucroTotal=?,percentagemLucro=?,codigoEmpresa=? WHERE codigoProduto=?";

                    $sql1 = $obj->prepare($sql);
    
                    if($sql1->execute([$nomeProduto,$valorLevantamento,$valorLevantamentoUnidade,$valorUnidade,$lucroUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$_REQUEST['id']])){

                print "<script>location.href='portal.php?page=produto&accao=listar';</script>";



            }else{

                print "<script>alert('Falha ao actualizar o produto! ');</script>";

                print "<script>location.href='portal.php?page=produto&accao=listar';</script>";

            }

        }else{
            $valorUnidade=ceil($valorUnidade/5)*5;
            $valorTotalVenda = $valorUnidade*$quantidade;
            $valorTotalVenda = $valorUnidade*$quantidade;
            $valorLevantamentoUnidade=ceil($valorLevantamento/$quantidade);

            $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);

            

            $sql = "UPDATE produtos set nomeProduto=?,valorLevantamento=?,valorUnidade=?,valorTotalVenda=?,lucroTotal=?,percentagemLucro=?,codigoEmpresa=? WHERE codigoProduto=?";

                $sql1 = $obj->prepare($sql);

                if($sql1->execute([$nomeProduto,$valorLevantamento,$valorUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$_REQUEST['id']])){



                print "<script>location.href='portal.php?page=produto&accao=listar';</script>";



            }else{

                print "<script>alert('Falha ao actualizar o produto! ');</script>";

                print "<script>location.href='portal.php?page=produto&accao=listar';</script>";

            }

        }

        }else{

            $sql = "UPDATE produtos set nomeProduto=?,valorLevantamento=?,valorLevantamentoUnidade=?,valorUnidade=?,lucroUnidade=?,valorTotalVenda=?,lucroTotal=?,percentagemLucro=?,codigoEmpresa=? WHERE codigoProduto=?";

                $sql1 = $obj->prepare($sql);

                if($sql1->execute([$nomeProduto,$valorLevantamento,$valorLevantamentoUnidade,$valorUnidade,$lucroUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$_REQUEST['id']])){


            print "<script>location.href='portal.php?page=produto&accao=listar';</script>";



        }else{

            print "<script>alert('Falha ao actualizar o produto! ');</script>";

            print "<script>location.href='portal.php?page=produto&accao=listar';</script>";

        }



    }
            
        }
        break;
    }
}



function excluir(){
    include('db.class.php');

if($_SESSION['acessoUsuario']=='A' or $_SESSION['acessoUsuario']=='B'){
    $sql ="DELETE FROM vendas WHERE codigoProduto=".$_REQUEST['id'];

        $sql1= $obj->prepare($sql);
    
        if($sql1->execute()){
    
            $sql ="DELETE FROM estoques WHERE codigoProduto=".$_REQUEST['id'];
    
            $sql1= $obj->prepare($sql);
    
            if($sql1->execute()){
    
                $sql ="DELETE FROM produtos WHERE codigoProduto=".$_REQUEST['id'];
    
                $sql1= $obj->prepare($sql);
    
                if($sql1->execute()){

    
                    print "<script>location.href='?page=produto&accao=listar'</script>";
    
                }else{
    
                    print "<script>alert('Erro ao apagar o produto!')</script>";
    
            print "<script>location.href='?page=produto&accao=listar'</script>";
    
                }
    
            }else{
    
                print "<script>alert('Erro ao apagar o estoque relacionado ao produto!')</script>";
    
            print "<script>location.href='?page=produto&accao=listar'</script>";
    
            }
    
        }else{
    
            print "<script>alert('Erro ao apagar as venda relacionadas ao produto!')</script>";
    
            print "<script>location.href='?page=produto&accao=listar'</script>";
    
        }
}else{
    print "<script>alert('Desculpa, por questões de segurança não tens acesso a esta acção!')</script>";
    
    print "<script>location.href='?page=produto&accao=listar'</script>";
}

}

function adicionar(){


    switch ($_REQUEST["fase"]){
        case 'inicial':{
            ?> <form action="?page=produto&accao=adicionar&fase=final" class="formAdicionar" method="POST">

    <input type="hidden" name="accao" value="adicionar">

    <h1>Adicionar Produto</h1>



    <div class="mb-3">

        <label>Nome do produto</label>

        <input type="text" name="nome" class="form-control" required>

    </div>



    <div class="mb-3">

        <label>Valor de levantamento</label>

        <input type="number" name="valorLevantamento" class="form-control" required>

    </div>



    <div class="mb-3">

        <label>Quantidade</label>

        <input type="number" name="quantidade" class="form-control" required>



        </input>

    </div>

    <div class="mb-3">

        <label>Valor por unidade</label>

        <input type="number" name="valorUnidade" class="form-control" required>

    </div>
    <div class="mb-3">

    <label>Tem venda especial?</label>

    <select name="tipoVenda" class="form-control">
        <option value="0">0</option>
        <option value="1">1</option>
    </select>

    </div>




    <div class="mb-3">

        <button type="submit" class="btn btn-primary">GUARDAR</button>

    </div>



    <?php

        }
        break;
        case 'final':{
            
        include("db.class.php");

        $nomeProduto = addslashes($_POST['nome']) ;
        
        $sql ="SELECT * FROM produtos where (produtos.nomeProduto like '%$nomeProduto' or produtos.nomeProduto like '%$nomeProduto%' or produtos.nomeProduto like '$nomeProduto%' )";
        
            $sql1 = $obj->prepare($sql);
        
            $sql1->execute();
        
            $qtd = $sql1 -> rowCount();
        
                if($qtd<=0){
        
                    
        
                    if(isset($_POST['nome']) && !empty($_POST['nome']) or 
        
                    isset($_POST['valorLevantamento']) && !empty($_POST['valorLevantamento']) or 
        
                    isset($_POST['valorUnidade']) && !empty($_POST['valorUnidade']) or 
        
                    isset($_POST['quantidade']) && !empty($_POST['quantidade']) ){
        
                       
        
                       $nomeProduto = addslashes($_POST['nome']) ;
                        
        
                         $valorLevantamento = addslashes($_POST['valorLevantamento']);
                        
        
                         $valorUnidade = addslashes($_POST['valorUnidade']);
                        
        
                        $codigoEmpresa = addslashes($_SESSION['codigoEmpresa']);
                        
        
                        $quantidade = addslashes($_POST['quantidade']);
                        $tipoVenda = addslashes($_POST['tipoVenda']);
                        
        
                         $valorTotalVenda = $valorUnidade*$quantidade;
                        
                        $valorLevantamentoUnidade=ceil($valorLevantamento/$quantidade);
                        
                        $lucroTotal = $valorTotalVenda-$valorLevantamento;
                        
                         $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);
                        
                         $percentagemLucro = ($lucroUnidade*100)/$valorUnidade;
                        
                        $percentagemLucro = number_format($percentagemLucro,2,'.','');
        
                        if($percentagemLucro<25){
        
        
                             $lucroTotal = ($valorLevantamento*25)/100;
        
                             $valorUnidade=($valorLevantamento+$lucroTotal)/$quantidade;
                             $percentagemLucro = ($lucroUnidade*100)/$valorUnidade;
                        
                            $percentagemLucro = number_format($percentagemLucro,2,'.','');
                            if(($valorUnidade*10) % 10 !=0 ){
                                

                                
        
                                $valorUnidade=ceil($valorUnidade/5)*5;
                                
        
                                $valorTotalVenda = $valorUnidade*$quantidade;
                            $valorLevantamentoUnidade=ceil($valorLevantamento/$quantidade);
            
                            $lucroTotal = $valorTotalVenda-$valorLevantamento;
                            $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);
                            $percentagemLucro = ($lucroUnidade*100)/$valorUnidade;   
                            $percentagemLucro = number_format($percentagemLucro,2,'.','');
            
                                $sql = "SELECT * FROM empresas WHERE codigoEmpresa=?";
        
                        $sql1 = $obj->prepare($sql);
        
                        $sql1->execute([$codigoEmpresa]);
        
                        $dado =$sql1->rowCount();
        
                        if($dado>0){
        
                            $sql = "INSERT INTO produtos(nomeProduto,quantidadeProduto,valorLevantamento,valorLevantamentoUnidade,valorUnidade,lucroUnidade,valorTotalVenda,lucroTotal,percentagemLucro,codigoEmpresa,tipoVenda)values(?,?,?,?,?,?,?,?,?,?,?)";
        
                            $sql1 = $obj->prepare($sql);
        
                            if($sql1->execute([$nomeProduto,$quantidade,$valorLevantamento,$valorLevantamentoUnidade,$valorUnidade,$lucroUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$tipoVenda])){
        
                                $sql ="SELECT codigoProduto FROM produtos WHERE nomeProduto=?";
        
                                $sql1 = $obj->prepare($sql);
        
                                $sql1->execute([$nomeProduto]);
        
                                $dado =$sql1->fetch();
        
        
        
                                $sql= "INSERT INTO estoques(codigoProduto,quantidade)Values(?,?)";
        
                                $sql1 = $obj->prepare($sql);
        
                            if( $sql1->execute([$dado['codigoProduto'],$quantidade])){
        
        
                                print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
        
        
                            }
        
                                
        
        
        
                            }else{
                                
        
                                print "<script>alert('Erro ao inserir o produto! ');</script>";
                    print "<script>location.href='portal.php?page=produto&accao=adicionar&fase=inicial';</script>";
        
                            }
        
        
        
                        }else{
        
                            print "<script>alert('Empresa ão encontrada! ');</script>";
        
                            print "<script>location.href='portal.php?page=produto&accao=adicionar&fase=inicial';</script>";
        
                        }
        
                            }else{
                             $valorUnidade=ceil($valorUnidade/5)*5;
                             $percentagemLucro = ($lucroUnidade*100)/$valorUnidade;
                        
                             $percentagemLucro = number_format($percentagemLucro,2,'.',''); 
        
                             $valorTotalVenda = $valorUnidade*$quantidade;
                            $valorLevantamentoUnidade=ceil($valorLevantamento/$quantidade);
            
                            $lucroTotal = $valorTotalVenda-$valorLevantamento;
                            $lucroUnidade = floor($valorUnidade-$valorLevantamentoUnidade);
        
                                $sql = "SELECT * FROM empresas WHERE codigoEmpresa=?";
        
                        $sql1 = $obj->prepare($sql);
        
                        $sql1->execute([$codigoEmpresa]);
        
                        $dado =$sql1->rowCount();
        
                        if($dado>0){
        
                            $sql = "INSERT INTO produtos(nomeProduto,quantidadeProduto,valorLevantamento,valorLevantamentoUnidade,valorUnidade,lucroUnidade,valorTotalVenda,lucroTotal,percentagemLucro,codigoEmpresa,tipoVenda)values(?,?,?,?,?,?,?,?,?,?,?)";
        
                            $sql1 = $obj->prepare($sql);
        
                            if($sql1->execute([$nomeProduto,$quantidade,$valorLevantamento,$valorLevantamentoUnidade,$valorUnidade,$lucroUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$tipoVenda])){
        
                                $sql ="SELECT codigoProduto FROM produtos WHERE nomeProduto=?";
        
                                $sql1 = $obj->prepare($sql);
        
                                $sql1->execute([$nomeProduto]);
        
                                $dado =$sql1->fetch();
        
        
        
                                $sql= "INSERT INTO estoques(codigoProduto,quantidade)Values(?,?)";
        
                                $sql1 = $obj->prepare($sql);
        
                            if( $sql1->execute([$dado['codigoProduto'],$quantidade])){
        
                                
                                print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
        
        
                            }
        
                                
        
        
        
                            }else{
        
                                print "<script>alert('Erro ao inserir o produto referido! ');</script>";
                    print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
        
                            }
        
        
        
                        }else{
        
                            print "<script>alert('Empresa ão encontrada! ');</script>";
        
                            print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
                        }
        
                            }
        
                            
        
                        
        
                        }else{
        
                        $sql = "SELECT * FROM empresas WHERE codigoEmpresa=?";
        
                        $sql1 = $obj->prepare($sql);
        
                        $sql1->execute([$codigoEmpresa]);
        
                        $dado =$sql1->rowCount();
        
                        if($dado>0){
        
                            $sql = "INSERT INTO produtos(nomeProduto,quantidadeProduto,valorLevantamento,valorLevantamentoUnidade,valorUnidade,lucroUnidade,valorTotalVenda,lucroTotal,percentagemLucro,codigoEmpresa,tipoVenda)values(?,?,?,?,?,?,?,?,?,?,?)";
        
                            $sql1 = $obj->prepare($sql);
        
                            if($sql1->execute([$nomeProduto,$quantidade,$valorLevantamento,$valorLevantamentoUnidade,$valorUnidade,$lucroUnidade, $valorTotalVenda,$lucroTotal,$percentagemLucro,$codigoEmpresa,$tipoVenda])){
        
                                $sql ="SELECT codigoProduto FROM produtos WHERE nomeProduto=?";
        
                                $sql1 = $obj->prepare($sql);
        
                                $sql1->execute([$nomeProduto]);
        
                                $dado =$sql1->fetch();
        
        
        
                                $sql= "INSERT INTO estoques(codigoProduto,quantidade)Values(?,?)";
        
                                $sql1 = $obj->prepare($sql);
        
                            if( $sql1->execute([$dado['codigoProduto'],$quantidade])){
                  
                            print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
                            }
                            }else{
        
                                print "<script>alert('Erro ao inserir o produto! ');</script>";
                    print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
                            }
        
        
        
                        }else{
        
                            print "<script>alert('Empresa ão encontrada! ');</script>";
        
                            print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
                        }
        
        
        
                    }
        
        
        
                    }else{
        
                        print "<script>location.href='?page=produto&accao=adicionar&fase=inicial';</script>";
        
                    }
        
                }else{
        
                    print "<script>alert('Já existe um produto com esse nome!');</script>";
        
                     print "<script>location.href='portal.php?page=produto&accao=adicionar&fase=inicial';</script>";
        
                }
        
                    
        }break;
    }
    
}

function buscar($nome){


    include('db.class.php');
    

    $sql ="SELECT DISTINCT produtos.codigoProduto, nomeProduto,quantidadeProduto, valorUnidade,percentagemLucro, nomeEmpresa FROM produtos inner join estoques inner join empresas where empresas.codigoEmpresa=produtos.codigoEmpresa and estoques.codigoProduto=produtos.codigoProduto and produtos.codigoEmpresa=? and (produtos.nomeProduto like '%$nome' or produtos.nomeProduto like '%$nome%' or produtos.nomeProduto like '$nome%' )";

    $sql1 = $obj->prepare($sql);

    $sql1->execute([$_SESSION['codigoEmpresa']]);

    $qtd = $sql1 -> rowCount();



    ?>



    <form action="?page=produto" class="formPesquisa" style="width: 100%;" method="POST">

        <h1>Produtos</h1>

        <input style="padding-top:0px;" type="search" name="buscar" placeholder="Pesquise pelo nome..." value="<?php echo $nome?>"
            style="width: 80%; outline: none; border-radius: 4px; padding-left:2%; margin-left:5%" required autofocus>

        <input type="hidden" name="accao" value="buscar">

        <button type="submit" class="fa fa-search" style="border: none;background-color:transparent"></button>

    </form>

    <form action="?page=produto&accao=adicionar&fase=inicial" class="formAdd" style="width: 100%;" method="POST">

        <input type="hidden" name="accao" value="adicionar">

        <button type="submit" class="fa fa-plus">Adicionar Produto</button>



    </form>

    <?php

    if($qtd > 0) {

        print "<table class='table table-hover table-striped table-bordered formPesquisa'>";



        print "<tr>";

        print "<th>#</th>";

        print "<th>Produto</th>";

        print "<th>Qtd.</th>";

        print "<th>Valor venda</th>";
	print "<th>Perc. lucro</th>";


        print "<th>Acções</th>";

        print "</tr>";

        $count = 1;

        while($row = $sql1 -> fetch()) {

            print "<tr>";

            print "<td>" .$row['codigoProduto']. "</td>";

            print "<td>" .$row['nomeProduto']. "</td>";

            print "<td>" .$row['quantidadeProduto']. "</td>";

            print "<td>" .$row['valorUnidade']. "</td>";
	    print "<td>" .$row['percentagemLucro']."%". "</td>";


            print "<td>

           <button onclick=\"location.href='?page=produto&accao=editar&id=".$row['codigoProduto']."';\" class='btn btn-success'>Editar</button>

                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=produto&accao=excluir&id=".$row['codigoProduto']."&permicao=sim';}else{false;}\"  class='btn btn-danger'>Excluir</button>


            </td>";

            print "</tr>";
            $count+=1;
        }

            print "</table>";

    } else {

        print "<form action='portal.php?page=produto&accao=listar' Method='POST'>

        <button class='fa fa-step-backward' type='submit' style='border:none;margin-left:20px;background-color:transparent' >"." "."Voltar</button>

        </form>";

        print "<p class='alert alert-danger'>Não encontrou resultados!</p>";

    }

}

switch ($_REQUEST["accao"]){
    case 'listar':
        listarProduto();
        break;
    case 'editar':
        edital();
        break;

    case 'actualizar':
        if(isset($_POST['nome']) && !empty($_POST['nome']) or 

                isset($_POST['valorLevantamento']) && !empty($_POST['valorLevantamento']) or 

                isset($_POST['valorUnidade']) && !empty($_POST['valorUnidade']) or 

                isset($_POST['codigoEmpresa']) && !empty($_POST['codigoEmpresa'])){
                actualizar();
        }
        break;
    case 'buscar':
        if(isset($_POST['buscar']) && !empty($_POST['buscar'])){
            $nome = addslashes($_POST['buscar']);
            buscar($nome);
        }
        break;

    case 'adicionar':
        adicionar();
        break;
    case 'excluir':

        
        switch ($_REQUEST["permicao"]){

            case 'pedido':
                $id = $_REQUEST['id'];
                print "<script>if(confirm('Este processo apagará todas venda registadas desse produto! Deseja continuar?')){location.href='?page=produto&accao=excluir&permicao=sim&id=".$id."';}else{location.href='?page=produto&accao=excluir&permicao=nao';}</script>";
                break;
            case 'sim':
                excluir();
                break;
            case 'nao':
                print "<script> location.href='?page=produto&accao=listar';</script>";
                break;
        }
        
        break;
        default:
        break;
}



?>