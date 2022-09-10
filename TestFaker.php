<?php
include "Assets/PHPScripts/Include.php";
require 'Assets/Database/DatabaseConnection.php';
include "Assets/PHPScripts/FakePersonGenerator.php";
require_once 'vendor/autoload.php';


$dbConnect = DatabaseConnection::GetInstance();

for ($i = 0; $i < 10; $i++) 
{
//0 male, 1 female
    try 
    {
        list($sex, $first_name, $last_name, $display_name, $email_address, $address1, $address2, $address3, $title, $postcode, $country, $phone_number, $comment, $contact_me) = FakePersonGenerator::GenerateCommentRecord();

        $dbConnect->AddComment
        (
            $title,
            $gender = $sex,
            $display_name,
            $first_name,
            $last_name,
            $address1,
            $address2,
            $address3,
            $postcode,
            $country,
            $email_address,
            $phone_number,
            $comment,
            $contact_me
        );
    }
    catch(PDOException $e) 
    {
        echo "Error (iteration $i): " . $e->getMessage();
    }
}

echo "complete";


?>