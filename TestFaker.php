<?php
include "Assets/PHPScripts/Include.php";
require 'Assets/Database/DatabaseConnection.php';
include "Assets/PHPScripts/FakePersonGenerator.php";
require_once 'vendor/autoload.php';


$dbConnect = DatabaseConnection::GetInstance();
$time_start = microtime(true);
for ($i = 0; $i < 100; $i++) 
{
//0 male, 1 female
    $rows = [[]];
    try 
    {
        $row = [];
        list($sex, $first_name, $last_name, $display_name, $email_address, $address1, $address2, $address3, $title, 
            $postcode, $country, $phone_number, $comment, $contact_me) = FakePersonGenerator::GenerateCommentRecord();
        $row['sex'] = $sex;
        $row['firstname'] = $first_name;
        $row['last_name'] = $last_name;
        $row['display_name'] = $display_name;
        $row['email_address'] = $email_address;
        $row['address1'] = $address1;
        $row['address2'] = $address2;
        $row['address3'] = $address3;
        $row['title'] = $title;
        $row['postcode'] = $postcode;
        $row['country'] = $country;
        $row['phone_number'] = $phone_number;
        $row['comment'] = $comment;
        $row['contact_me'] = $contact_me;
        $rows[] = $row;
        
        //print_r($l);
//        $dbConnect->AddComment
//        (
//            $title,
//            $gender = $sex,
//            $display_name,
//            $first_name,
//            $last_name,
//            $address1,
//            $address2,
//            $address3,
//            $postcode,
//            $country,
//            $email_address,
//            $phone_number,
//            $comment,
//            $contact_me
//        );
    }
    catch(PDOException $e) 
    {
        echo "Error (iteration $i): " . $e->getMessage();
    }
}
$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60;
echo 'Total Execution Time:'.$execution_time.' mins';

?>