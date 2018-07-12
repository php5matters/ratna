<?php
include("../api/classes/DBClass.php");
try 
{
  $dbclass = new DBClass(); 
  $connection = $dbclass->getConnection();
  $sql = file_get_contents("data/db.sql"); 
  $connection->exec($sql);
  echo "Database and tables created successfully!";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}