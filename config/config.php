<?php

    try {
        //host
        define("HOST", "localhost");

        //dbname
        define("DBNAME", "anxiety-coffee");

        //user
        define("USER", "root");

        //pass
        define("PASS", "");

        $host = 'localhost'; // on cPanel, this is usually still 'localhost'
        $dbname = 'anxiety_db'; // like 'anxiety_db'
        $user = 'anxiety_user';   // like 'anxiety_user'
        $pass = 'H#K7bkh2*gq='; // the password you created in cPanel

        $conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME."", USER, PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $Exception ) { 

        echo $Exception->getMessage();
    }
   
