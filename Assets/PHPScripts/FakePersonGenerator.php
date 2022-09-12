<?php
include "Assets/PHPScripts/AIPerson.php";
class FakePersonGenerator
{
    public static function GenerateFakePeople(): AIPerson
    {
        return new AIPerson();
    }

}

?>