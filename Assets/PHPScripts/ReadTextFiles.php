<?php

class ReadTextFiles
{
    /**
     * @param string $fileName
     * @return array
     */
    private static function LinesToArrayFromFile(string $fileName): array
    {
        $myFile = fopen($fileName, 'r') or die ("Unable to read file!");
        //echo fread($myFile, filesize($fileName));
        $lines = [];
        while (!feof($myFile))
        {
            $s = trim(fgets($myFile), $characters = " \n\r\t\v\x00");
            //echo  $s;
            $lines[] = $s;
        }
        fclose($myFile);
        return $lines;
    }
    
    public static function GetLastNames() : array
    {
        return self::LinesToArrayFromFile("Assets/TextFiles/Last_Name.txt");
    }

    public static function GetFemaleNames() : array
    {
        return self::LinesToArrayFromFile("Assets/TextFiles/Female.txt");
    }

    public static function GetMaleNames() : array
    {
        return self::LinesToArrayFromFile("Assets/TextFiles/Male.txt");
    }
}


?>