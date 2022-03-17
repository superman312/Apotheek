<?php

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'apotheek';
    $con = mysqli_connect($servername,$username, $password, $dbname);
    //check that connection happend
    if(mysqli_connect_errno())
    {
        echo "1: Connection Failed"; //error code #1 - connection failed
        exit();
    }

    $username = $_POST["username"];
    $password = $_POST["pwd"];

    //check if name exists
    $namecheckquery = "SELECT name, hash FROM users WHERE name='" . $username . "';";   
    $namecheck = mysqli_query($con, $namecheckquery) or die("2: Name check query failed"); //error code #2 - namecheckquery failed
    if (mysqli_num_rows($namecheck) != 1)
    {
        echo "5: Either no user with name, or more than one"; //error code #5 - number of names matching !=1
        exit();
    }

    //get login info from query
    $existinginfo = mysqli_fetch_assoc($namecheck);
    $hash = $existinginfo["hash"];

    // echo "$username, $password\t";
    
    $loginhash = crypt($password, $salt);
    if ($hash != $loginhash)
    {
        echo "\t6: Incorrect password"; //error code #6 - password does not match hash
        exit();
    }
    header("Location: /");