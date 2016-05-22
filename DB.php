<?php
    //phpinfo();
    
    error_reporting(E_ALL);
    ini_set('display_startup_errors',1);
    ini_set('display_errors',1);
    error_reporting(-1);
    
    echo "Testing database PDO connection...<br>";
    
    $SECRET = "diu7ajksf8sj,vKLDHliewudksfj"; //  place this in WebApp settings
    
    
    $connenv = getenv("SQLAZURECONNSTR_defaultConnection");
    parse_str(str_replace(";", "&", $connenv), $connarray);
    
    $connstring = "sqlsrv:Server=".$connarray["Data_Source"].";Database=".$connarray["Initial_Catalog"];
    $item = $connarray["item_title"];
    $descr = $connarray["item_description"];
	$price = $connarray["item_price"];
    
    function printCollations($conn)
    {
        $sql = "SELECT title, description FROM sys.fn_helpcollations()";
        foreach ($conn->query($sql) as $row)
        {
            print $row['title'] . "\t";
			print $row['description'] . "\t";
            print $row['price'] . "<br>";
        }
    }

    try
    {
        $conn = new PDO( $connstring, $item, $descr, $price );
        
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        
        
        $sqlcreate ="CREATE TABLE items( ID INT NOT NULL IDENTITY(1,1) PRIMARY KEY,".
                 "title         VARCHAR( 250 ) NOT NULL,".
                 "description   VARCHAR( 128 ) NOT NULL,".
                 "price         INT);";
        
        try { $conn->exec($sqlcreate); } catch ( PDOException $e ) { echo "Create table error. May be it exists."; }
        
        print("The table was created.<br><br>");
        
        $sqlinsert = "insert into items (title,description,price) values (?, ?, ?)";
        $insertquery = $conn->prepare($sqlinsert);
      
        // test set of items
        $myitems = array(
            array("Ноутбук Lenovo IdeaPad 100-14", "Екран 14 (1366x768) HD LED, глянцевий / Intel Celeron N2840 (2.16 - 2.58 ГГц) / RAM 2 ГБ / HDD 500 ГБ / Intel HD Graphics / LAN / Wi-Fi / веб-камера / DOS / 1.9 кг / чорний", 5999),
            array("Ноутбук HP 255 G4", "Екран 15.6 (1366x768) HD LED, матовий / AMD Dual-Core E1-6015 (1.4 ГГц) / RAM 2 ГБ / HDD 500 ГБ / AMD Radeon R2 / LAN / Wi-Fi / Bluetooth / веб-камера / Linux / 2.15 кг / чорний", 6099),
            array("Ноутбук Dell Inspiron 3542", "Екран 15.6 (1366x768) WXGA HD LED, глянцевий / Intel Celeron 2957U (1.4 ГГц) / RAM 2 ГБ / HDD 500 ГБ / Intel HD Graphics / DVD Super Multi / LAN / Wi-Fi / Bluetooth 4.0 / веб-камера / Linux / 2.4 кг / чорний", 6777) );
        
        foreach($myitems as $item)
        {
            $title = $item[0];
            $description = $item[1];
            $price = $item[2];
            $insertquery->execute(array($title, $description, $price));
            
            echo "Insert error code = ".$insertquery->errorCode()." "; // Five zeros are good like this 00000 but HY001 is a common error
            echo "Number of rows inserted = ".$insertquery->rowCount()."<br>";
        }
        
        print "<br>Selecting rows from the table...<br>";
        
        $sqlselect = "SELECT * FROM items";
        foreach ($conn->query($sqlselect) as $row)
        {
            print   htmlspecialchars($row['title']).", ".
                    htmlspecialchars($row['description']).", ".
                    "price = ".htmlspecialchars($row['price'])."<br>";
        }
        
        print "<br>Dropping the table...<br>";
        
        $sqldrop ="DROP TABLE items";
        
        $conn->exec($sqldrop);
        
        print "The table was dropped <br>";
    }
    catch ( PDOException $e )
    {
        // TODO: There is a security problem here. Do not do this in production!!!
        print( "PDO Error : " );
        die(print_r($e));
    }

?>
