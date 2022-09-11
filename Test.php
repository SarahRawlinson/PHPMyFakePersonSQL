<?php
require 'Assets\PHPScripts\MyFakeInfo.php';

for ($i = 0; $i < 10000; $i++)
{
    echo MyFakeInfo::GetRandomAnimal()."\n";
}
