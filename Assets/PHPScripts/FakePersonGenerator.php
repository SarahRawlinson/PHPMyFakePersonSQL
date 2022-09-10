<?php
include "Assets/PHPScripts/AIPerson.php";
class FakePersonGenerator
{
    public static function GenerateCommentRecord(): array
    {
        $person = new AIPerson();
        return $person->CreateDetails();
    }

}

?>