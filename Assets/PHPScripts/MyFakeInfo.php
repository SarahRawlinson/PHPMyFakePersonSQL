<?php
include "ReadTextFiles.php";
include "CSVReader.php";

//Notes:
//Postcode source = https://github.com/radiac/UK-Postcodes/blob/master/postcodes.csv
//animals source = https://www.kaggle.com/datasets/uciml/zoo-animal-classification?resource=download

class MyFakeInfo
{

    public static Function GetEmailDomain() : string
    {
        $domains = CSVReader::GetEmailDomain();
        $TLDs = CSVReader::GetEmailTLD();
        return "@".$domains[rand(0, count($domains) - 1)].$TLDs[rand(0, count($TLDs) - 1)];
    }
    
    public static Function GetFirstName($m_f) : string
    {
        switch ($m_f)
        {
            case "male":
                return self::GetMaleName();
                break;
            case "female":
                return self::GetFemaleName();
                break;
            default:
                die("Not Male Or Female");
                break;
        }
    }
    
    public static Function GetFemaleName() : string
    {
        $femaleNames = ReadTextFiles::GetFemaleNames();
        return $femaleNames[rand(0, count($femaleNames) - 1)];
    }
    
    public static function GetMaleName() : string
    {
        $maleNames = ReadTextFiles::GetMaleNames();
        return $maleNames[rand(0, count($maleNames) - 1)];
    }
    
    public static function GetLastName() : string
    {
        $lastNames = ReadTextFiles::GetLastNames();
        return $lastNames[rand(0, count($lastNames) - 1)];
    }

    /**
     * @throws Exception
     */
    public static function GetRandomDate($mn,$mx) : DateTime
    {
        $maxDate = new DateTime("-{$mx} years");
        $minDate = new DateTime("-{$mn} years");
        $int = rand($minDate->getTimestamp(), $maxDate->getTimestamp());
        return new DateTime(date('d-m-Y',$int));
    }
    
    public static function GetRandomLocation() : array
    {
        $locations = CSVReader::GetLocations();
        $location = $locations[rand(0, count($locations) - 1)];
        $sectors = CSVReader::GetPostcodeSectors();
        try {
            $postcode = $location['postcode'];            
            $sectors = array_values(preg_grep("/^$postcode/i",$sectors));            
        }
        catch (ErrorException $e)
        {
            echo $e;
        }        
        $units = CSVReader::GetPostcodeUnits();        
        $sector = $sectors[rand(0, count($sectors) - 1)];
        $unit = $units[rand(0, count($units) - 1)];
        $location['postcode'] = $sector.$unit;
        
        return $location;
    }
    
}

//echo "\n\n";
//echo print_r(MyFakeInfo::GetRandomLocation());