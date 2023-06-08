<?php 

session_start();

if(isset($_SESSION['nomeUsuario']) && $_SESSION['nomeUsuario']!="" && !empty($_SESSION['nomeUsuario'])){

?>



<!DOCTYPE html>

<html lang="pt-br">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="./assets/img/mercado.png" type="image/png">

    <link rel="stylesheet" href="./assets/icon/font-awesome.css">

    <link rel="stylesheet" href="./assets/css/portal.css">

    <link href="css/style.css" rel="stylesheet">



    <script src="js/bootstrap.bundle.min.js"></script>

    <title>My shop</title>

</head>



<body>



    <header>



        <ul style="padding-bottom:20px ;">

            <li id="close"><span class="fa fa-close" id="close-menu"></span></li>

            <li><a href="?page=novoServico&accao=listar"><span class="fa fa-navicon" id="open-menu"></span></a></li>

            <li><a href="?page=novoServico&accao=listar"><span class="fa fa-shopping-cart"></span> My Shop</a></li>

        </ul>



    </header>

    <div class="menu card-panel" id="menu">



        <ul>

            <li><a href="?page=novoServico&accao=listar"><span class="fa fa-home"
                        style="text-decoration: none;"></span>Home</a></li>

            <li><a href="?page=produto&accao=listar"><span class="fa fa-product-hunt"></span>Produtos</a></li>

            <li><a href="?page=venda&accao=listar"><span class="fa fa-buysellads "></span>Vendas</a></li>

            <li><a href="?page=store&accao=listar"><span class="fa fa-shopping-basket  "></span>Stock</a></li>

            <li><a href="?page=user&accao=listar"><span class="fa fa-users "></span>Usuários</a></li>
            <li><a href="?page=cliente&accao=cliente"><span class="fa fa-shopping-bag "></span>Clientes</a></li>

            <li><a href="?page=cofre&accao=listar"><span class="fa fa-globe "></span>Cofre</a></li>

            <li><a class="btnSair"
                    onclick="if(confirm('Tem certeza que deseja sair?')){location.href='?page=sair';}else{false;}"><span
                        class="fa fa-remove"></span>Sair</a></li>


            <li>
                <h6 style="margin:0px; padding:20px"><strong><?php

             echo "Usuário: ".$_SESSION['nomeCompletoUsuario']?></strong></h6>
            </li>

            <ul>

            </ul>

            <div class="dev">

                <p style="font-size: 10px; text-align: left; margin-top: 20px;">Desenvolvido por:</p>

                <span class="fa fa-code"><a href="#" title="Desenvolvedor de software">Shyaka Filmin</a></span>

            </div>

    </div>



    </ul>

    <div class="dev">

        <p style="font-size: 10px; text-align: left; margin-top: 20px;">Desenvolvido por:</p>

        <span class="fa fa-code"><a href="#" title="Desenvolvedor de software">Shyaka Filmin</a></span>

    </div>

    </div>

    <!-- BUSCA & MENU -->

    <div id="menu-desk" class="menu-desk">

        <ul class="men">

            <li><a href="?page=novoServico&accao=listar"><span class="fa fa-home "></span>Home</a></li>

            <li><a href="?page=produto&accao=listar"><span class="fa fa-product-hunt "></span>Produtos</a></li>

            <li><a href="?page=venda&accao=listar"><span class="fa fa-buysellads "></span>Vendas</a></li>

            <li><a href="?page=store&accao=listar"><span class="fa fa-shopping-basket  "></span>Stock</a></li>

            <li><a href="?page=user&accao=listar"><span class="fa fa-users "></span>Usuários</a></li>
            <li><a href="?page=cliente&accao=cliente"><span class="fa fa-shopping-bag "></span>Clientes</a></li>

            <li><a href="?page=cofre&accao=listar"><span class="fa fa-globe "></span>Cofre</a></li>

            <li><a class="btnSair"
                    onclick="if(confirm('Tem certeza que deseja sair?')){location.href='?page=sair';}else{false;}"><span
                        class="fa fa-remove"></span>Sair</a></li>
            <ul>



            </ul>

    </div>

    <!-- BUSCA & MENU -->

    <!-- CARDS -->



    <main style="margin: 5% 0px 10px 0px;">

        <!-- Pessoas desaparecidas -->

        <section>

            <!-- </div> -->

            </div>

        </section>



    </main>



    <!-- CARDS -->

    <?php

                include("db.class.php");

                    switch(@$_REQUEST["page"]) {

                            case "produto":

                                include("produtos.php");

                                break;
                                case "divida":

                                include("dividas.php");

                                break;

                            case "novoServico":

                                include("novoServico.php");

                                    break;

                            case "venda":

                                include("Vendas.php");

                                break;

                            case "user":

                                include("usuarios.php");

                                break;


                            case "store":

                                include("Stock.php");

                                break;
                            case "cliente":

                                include("clientes.php");

                                break;
                            
                            case "cliente":

                                include("clientes.php");

                                break;
                            case "despesa":

                                include("despesas.php");

                                break;
                                case "cofre":

                                include("cofre.php");

                                break;
                                case "sair":

                                include("sair.php");

                                break;
?>







    <?php

                                print "<br>";

                               

                    }

                ?>



    <script src="./assets/js/menu.js"></script>



</body>

<footer class="rodape">



    <div class="dev">



        <p style="font-size: 10px; text-align: center;">Desenvolvido por:</p>

        <span class="fa fa-code"><a href="#" title="Desenvolvedor Web">Shyaka Filmin</a></span>





    </div>



</footer>



</html>

<?php 

}else{
    

   header('Location:index.php');

}

?>