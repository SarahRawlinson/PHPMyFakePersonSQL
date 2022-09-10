<?php

class CSVReader
{
    private static function GetCSVDataCells($fileName)
    {
        $myFile = fopen($fileName, 'r') or die ("Unable to read file!");
        $row = 1;
        $rows = [[]];
        $headers = fgetcsv($myFile);
        while (($data = fgetcsv($myFile)) !== false)
        {
            
            $num = count($data);
            $row++;            
            $cells = [];
            for ($c=0;$c < $num; $c++)
            {
                $cells[$headers[$c]] = $data[$c];
            }
            $rows[] = $cells;
            //print_r($cells);
        }
        fclose($myFile);   
        return $rows;
    }
    private static function GetCSVDataColumn($fileName)
    {
        $myFile = fopen($fileName, 'r') or die ("Unable to read file!");
        $rows = [];
        $headers = fgetcsv($myFile);
        while (($data = fgetcsv($myFile)) !== false)
        {
            $rows[] = $data[0];
            //print_r($cells);
        }
        fclose($myFile);
        return $rows;
    }
    
    public static function GetLocations()
    {
        return self::GetCSVDataCells("Assets/CSVFiles/UKPostcodes.csv");
    }

    public static function GetPostcodeSectors()
    {
        return self::GetCSVDataColumn("Assets/CSVFiles/UKPostcodeSectors.csv");
    }

    public static function GetPostcodeUnits()
    {
        return self::GetCSVDataColumn("Assets/CSVFiles/UKPostcodeUnits.csv");
    }

    public static function GetEmailDomain()
    {
        return self::GetCSVDataColumn("Assets/CSVFiles/EmailDomains.csv");
    }

    public static function GetEmailTLD()
    {
        return self::GetCSVDataColumn("Assets/CSVFiles/EmailTopLevelDomain.csv");
    }
}

//$data = CSVReader::GetLocations();
