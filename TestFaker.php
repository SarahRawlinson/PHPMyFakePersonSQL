<?php
include "Assets/PHPScripts/Include.php";
require 'Assets/Database/DatabaseConnection.php';
include "Assets/PHPScripts/FakePersonGenerator.php";
require_once 'vendor/autoload.php';


function time_elapsed()
{
    static $last = null;

    $now = microtime(true);
    $length = 0;
    if ($last != null) {
        $length = ($now - $last);
    }

    $last = $now;
    return $length;
}


$dbConnect = DatabaseConnection::GetInstance();
time_elapsed();
$rows = [];
for ($i = 0; $i < 10000; $i++) 
{
//0 male, 1 female
    
    try 
    {
        $rows[] = FakePersonGenerator::GenerateFakePeople();
    }
    catch(PDOException $e) 
    {
        echo "Error (iteration $i): " . $e->getMessage();
    }
}
$dbConnect->AddComments($rows);
echo 'Total Execution Time:'.time_elapsed().' seconds';

?>