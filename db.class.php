<?php
     $dsn = 'mysql:host=localhost;dbname=nossomercado';
     $user ='root';
     $pass ='';
   

     global $obj;

     try{
             $obj = new PDO($dsn,$user,$pass);
            
     
     }catch (PDOException $erro){
         echo 'ERRO: '.$erro->getMessage();
     }
     



?>