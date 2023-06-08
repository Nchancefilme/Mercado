<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/mercado.png" type="image/png">
    <link rel="stylesheet" href="./assets/icon/font-awesome.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <title>Login</title>
</head>

<body class="container">

    <section class="login" id="login">
        <form action="validar.php" method="POST">
            <h2>Login</h2>
            <input type="text" name="nome" id="nome" placeholder="Nome de usuário" required>
            <input type="password" name="senha" id="senha" placeholder="Senha do usuário" required>
            <div class="btn">
                <button type="submit" class="btn-login">Entrar</button>
               
            </div>
   
        </form>

    </section>

</body>

</html>