<?php
 
 class Database {

    public static function open_connection(){

        try{
            $host='mariadb';
            $dbname='Productos';
            $user='admin';
            $pass='changepassword';

            $dsn = "mysql:host=$host;dbname=$dbname";
            $dbh = new PDO($dsn, $user, $pass);

            return $dbh;

        }catch(PDOException $e){
            echo $e->getMessage();
            
        }
    }
 }

?>