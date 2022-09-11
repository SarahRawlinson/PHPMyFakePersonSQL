<?php

class CSVReader
{
    
    private static array $locations;
    private static array $Animals;
    private static array $Adjectives;
    private static array $Interjections;
    private static array $Conjunctions;
    private static array $Nouns;
    private static array $Prepositions;
    private static array $Pronouns;
    private static array $PostcodeSectors;
    private static array $PostcodeUnits;
    private static array $EmailDomains;
    private static array $GetEmailTLDs;
    
    /**
     * @param $fileName
     * @return array[]|void
     */
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

    /**
     * @param $fileName
     * @return array|void
     */
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

    /**
     * @return array[]|null
     * ['postcode'] string
     * ['eastings'] string
     * ['northings'] string
     * ['latitude'] string
     * ['longitude'] string
     * ['town'] string
     * ['region'] string
     * ['country'] string
     * ['country_string'] string
     */
    public static function GetLocations(): ?array
    {
        return self::$locations = self::$locations ?? self::GetCSVDataCells("Assets/CSVFiles/Locations/UKPostcodes.csv");
    }

    /**
     * @return array[]|null
     * ['animal_name'] string
     * ['hair'] bool (0/1)
     * ['feathers'] bool (0/1)
     * ['eggs'] bool (0/1)
     * ['milk'] bool (0/1)
     * ['airborne'] bool (0/1)
     * ['aquatic'] bool (0/1)
     * ['predator'] bool (0/1)
     * ['toothed'] bool (0/1)
     * ['backbone'] bool (0/1)
     * ['breathes'] bool (0/1)
     * ['venomous'] bool (0/1)
     * ['fins'] bool (0/1)
     * ['legs'] bool (0/1)
     * ['tail'] bool (0/1)
     * ['domestic'] bool (0/1)
     * ['catsize'] bool (0/1)
     * ['class_type'] 1-7 (1-Mammal, 2-Bird, 3-Reptile, 4-Fish, 5-Amphibian, 6-Bug, 7-Invertebrate)
     */
    public static function GetAnimals(): ?array
    {
        return self::$Animals = self::$Animals ??  self::GetCSVDataCells("Assets/CSVFiles/Animals/zoo.csv");
    }


    /**
     * @return array|null
     * string
     */
    public static function GetAdjectives(): ?array
    {
        return self::$Adjectives = self::$Adjectives ?? self::GetCSVDataColumn("Assets/CSVFiles/Words/AdjectiveWords.csv");
    }

    /**
     * @return array[]|null
     * ['Word'] string
     * ['Meaning'] string
     */
    public static function GetInterjections(): ?array
    {
        return self::$Interjections = self::$Interjections ?? self::GetCSVDataCells("Assets/CSVFiles/Words/interjections-in-english.csv");
    }

    /**
     * @return array|null
     * string
     */
    public static function GetConjunctions(): ?array
    {
        return self::$Conjunctions = self::$Conjunctions ?? self::GetCSVDataColumn("Assets/CSVFiles/Words/Conjunctions.csv");
    }

    /**
     * @return array|null
     * string
     */
    public static function GetNouns(): ?array
    {
        return self::$Nouns = self::$Nouns ??  self::GetCSVDataColumn("Assets/CSVFiles/Words/NounList.csv");
    }

    /**
     * @return array[]|null
     * ['Word'] string
     * ['Meaning'] string
     */
    public static function GetPrepositions(): ?array
    {
        return self::$Prepositions = self::$Prepositions ??  self::GetCSVDataCells("Assets/CSVFiles/Words/prepositions-in-english.csv");
    }

    /**
     * @return array[]|null
     * ['Word'] string
     * ['Meaning'] string
     * ['obsolete'] bool (0/1)
     */
    public static function GetPronouns(): ?array
    {
        return self::$Pronouns = self::$Pronouns ??  self::GetCSVDataCells("Assets/CSVFiles/Words/pronouns-in-english.csv");
    }


    /**
     * @return array|null
     * string 
     */
    public static function GetPostcodeSectors(): ?array
    {
        return self::$PostcodeSectors = self::$PostcodeSectors ??  self::GetCSVDataColumn("Assets/CSVFiles/Locations/UKPostcodeSectors.csv");
    }

    /**
     * @return array|null
     * string
     */
    public static function GetPostcodeUnits(): ?array
    {
        return self::$PostcodeUnits = self::$PostcodeUnits ??  self::GetCSVDataColumn("Assets/CSVFiles/Locations/UKPostcodeUnits.csv");
    }

    /**
     * @return array|null
     * string
     */
    public static function GetEmailDomains(): ?array
    {
        return self::$EmailDomains = self::$EmailDomains ??  self::GetCSVDataColumn("Assets/CSVFiles/Email/EmailDomains.csv");
    }

    /**
     * @return array|null
     * string
     */
    public static function GetEmailTLDs(): ?array
    {
        return self::$GetEmailTLDs = self::$GetEmailTLDs ??  self::GetCSVDataColumn("Assets/CSVFiles/Email/EmailTopLevelDomain.csv");
    }
}

//$data = CSVReader::GetLocations();
