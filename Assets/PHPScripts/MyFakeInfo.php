<?php
include "ReadTextFiles.php";
include "CSVReader.php";

//Notes:
//Postcode source = https://github.com/radiac/UK-Postcodes/blob/master/postcodes.csv
//                  https://ideal-postcodes.co.uk/guides/uk-postcode-format
//animals source = https://www.kaggle.com/datasets/uciml/zoo-animal-classification?resource=download
//adjectives source = https://gist.github.com/hugsy/8910dc78d208e40de42deb29e62df913
//nouns source = https://www.kaggle.com/datasets/leite0407/list-of-nouns
//pronouns = https://www.wordexample.com/list/pronouns-in-english
//english dictionary source = https://www.bragitoff.com/2016/03/english-dictionary-in-csv-format/
//Parts Of Speech Words Files source = http://www.ashley-bovan.co.uk/words/partsofspeech.html
//prepositions in English source = https://www.wordexample.com/list/prepositions-in-english
// Note to self: excel get dictionary key =LET(start,FIND("(",A2)+1,end,FIND(")",A2),MID(A2,start,end-start))

class MyFakeInfo
{
    
    private static array $emailDomains;
    private static int $countOfEmailDomains;
    private static int $countOfEmailTLDs;
    private static int $countOfFemaleNames;
    private static int $countOfMaleNames;
    private static int $countOfLastNames;
    private static int $countOfLocations;
    private static ?array $emailEmailTLDs;
    private static array $femaleNames;
    private static array $maleNames;
    private static array $lastNames;
    private static array $locations;
    private static ?array $postcodeSectors;
    private static ?array $postCodeUnits;
    private static int $countOfPostCodeUnits;
    /**
     * @var array[]|null
     */
    private static ?array $Animals;
    private static int $countOfAnimals;
    private static ?array $Adjectives;
    private static int $countOfAdjectives;

    /**
     * @return string
     * string
     * @link CSVReader.php
     */
    public static Function GetEmailDomain() : string
    {
        $emailDomains = self::$emailDomains ?? self::GetEmailDomains();
        $emailEmailTLDs = self::$emailEmailTLDs ?? self::GetEmailTLDs();
        return "@".$emailDomains[rand(0, self::$countOfEmailDomains)].
            $emailEmailTLDs[rand(0, self::$countOfEmailTLDs)];
    }

    /**
     * @param $m_f string
     * string ('male','female')
     * @return string
     * string
     * @link ReadTextFiles.php
     */
    public static Function GetFirstName(string $m_f) : string
    {
        switch ($m_f)
        {
            case "male":
                return self::GetMaleName();
            case "female":
                return self::GetFemaleName();
            default:
                die("Not Male Or Female");
        }
    }

    /**
     * @return string
     * string
     * @link ReadTextFiles.php
     */
    public static Function GetFemaleName() : string
    {
        $femaleNames = self::$femaleNames ?? self::GetFemaleNames();
        return $femaleNames[rand(0, self::$countOfFemaleNames)];
    }

    /**
     * @return string
     * string
     * @link ReadTextFiles.php
     */
    public static function GetMaleName() : string
    {
        $maleNames = self::$maleNames ?? self::GetMaleNames();
        return $maleNames[rand(0, self::$countOfMaleNames)];
    }

    /**
     * @return string
     * string
     * @link ReadTextFiles.php
     */
    public static function GetLastName() : string
    {
        $lastNames = self::$lastNames ?? self::GetLastNames();
        return $lastNames[rand(0, self::$countOfLastNames)];
    }


    /**
     * @param $minYearsOld 
     * @param $maxYearsOld
     * @return DateTime
     * DateTime
     * @throws Exception
     */
    public static function GetRandomDate($minYearsOld, $maxYearsOld) : DateTime
    {
        $maxDate = new DateTime("-$maxYearsOld years");
        $minDate = new DateTime("-$minYearsOld years");
        $int = rand($minDate->getTimestamp(), $maxDate->getTimestamp());
        return new DateTime(date('d-m-Y',$int));
    }

    /**
     * @return array
     * random english location (post code may or may not be real by pure chance)
     * -keys-
     * ['postcode'] string,
     * ['eastings'] string,
     * ['northings'] string,
     * ['latitude'] string,
     * ['longitude'] string,
     * ['town'] string,
     * ['region'] string,
     * ['country'] string,
     * ['country_string'] string
     * @link CSVReader.php
     */
    public static function GetRandomLocation() : array
    {
        $locations = self::$locations ?? self::GetLocations();
        $location = $locations[rand(1, self::$countOfLocations)];
        $sectors = self::$postcodeSectors ?? self::GetPostcodeSectors();
        try {
            $postcode = $location['postcode'];            
            $sectors = array_values(preg_grep("/^$postcode/i",$sectors));            
        }
        catch (ErrorException $e)
        {
            echo $e;
        }        
        $units = self::$postCodeUnits ?? self::GetPostcodeUnits();        
        $sector = $sectors[rand(0, count($sectors) - 1)];
        $unit = $units[rand(0, self::$countOfPostCodeUnits)];
        $location['postcode'] = $sector.$unit;        
        return $location;
    }

    /**
     * @return string
     * string
     * random zoo animal name
     * @link CSVReader.php
     */
    public static function GetRandomAnimal() : string
    {
        $animals = $animals ?? self::GetAnimals();
        $i = rand(1, self::$countOfAnimals);
        $animal = $animals[$i];
        return $animal['animal_name'];        
    }


    /**
     * @return string
     */
    public static function GetRandomAdjective(): string
    {
        $Adjectives = self::$Adjectives ?? self::GetAdjectives();
        return $Adjectives[rand(0, self::$countOfAdjectives)];
    }
    
    //static get functions static 

    /**
     * @return array|null
     */
    public static function GetAdjectives(): ?array
    {
        $array = CSVReader::GetAdjectives();
        self::$Adjectives = $array;
        self::$countOfAdjectives = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetAnimals(): ?array
    {
        $array = CSVReader::GetAnimals();
        self::$Animals = $array;
        self::$countOfAnimals = count($array) - 1;
        return $array;
    }
    
    /**
     * @return array|null
     */
    public static function GetPostcodeUnits(): ?array
    {
        $array = CSVReader::GetPostcodeUnits();
        self::$postCodeUnits = $array;
        self::$countOfPostCodeUnits = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetPostcodeSectors(): ?array
    {
        $array = CSVReader::GetPostcodeSectors();
        self::$postcodeSectors = $array;
        return $array;
    }    

    /**
     * @return array|null
     */
    public static function GetEmailDomains(): ?array
    {
        $array = CSVReader::GetEmailDomains();
        self::$emailDomains = $array;
        self::$countOfEmailDomains = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetFemaleNames(): ?array
    {
        $array = ReadTextFiles::GetFemaleNames();
        self::$femaleNames = $array;
        self::$countOfFemaleNames = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetMaleNames(): ?array
    {
        $array = ReadTextFiles::GetMaleNames();
        self::$maleNames = $array;
        self::$countOfMaleNames = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetLastNames(): ?array
    {
        $array = ReadTextFiles::GetLastNames();
        self::$lastNames = $array;
        self::$countOfLastNames = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetLocations(): ?array
    {
        $array = CSVReader::GetLocations();
        self::$locations = $array;
        self::$countOfLocations = count($array) - 1;
        return $array;
    }

    /**
     * @return array|null
     */
    public static function GetEmailTLDs(): ?array
    {
        $array = CSVReader::GetEmailTLDs();
        self::$emailEmailTLDs = $array;
        self::$countOfEmailTLDs = count($array) - 1;
        return $array;
    }

}
