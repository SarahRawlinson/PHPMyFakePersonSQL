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
    /**
     * @return string
     * string
     * @link CSVReader.php
     */
    public static Function GetEmailDomain() : string
    {
        $domains = CSVReader::GetEmailDomains();
        $TLDs = CSVReader::GetEmailTLDs();
        return "@".$domains[rand(0, count($domains) - 1)].$TLDs[rand(0, count($TLDs) - 1)];
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
        $femaleNames = ReadTextFiles::GetFemaleNames();
        return $femaleNames[rand(0, count($femaleNames) - 1)];
    }

    /**
     * @return string
     * string
     * @link ReadTextFiles.php
     */
    public static function GetMaleName() : string
    {
        $maleNames = ReadTextFiles::GetMaleNames();
        return $maleNames[rand(0, count($maleNames) - 1)];
    }

    /**
     * @return string
     * string
     * @link ReadTextFiles.php
     */
    public static function GetLastName() : string
    {
        $lastNames = ReadTextFiles::GetLastNames();
        return $lastNames[rand(0, count($lastNames) - 1)];
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
        $locations = CSVReader::GetLocations();
        $location = $locations[rand(1, count($locations) - 1)];
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

    /**
     * @return string
     * string
     * random zoo animal name
     * @link CSVReader.php
     */
    public static function GetRandomAnimal() : string
    {
        $animals = CSVReader::GetAnimals();
        $i = rand(1, count($animals) - 1);
        $animal = $animals[$i];
        return $animal['animal_name'];        
    }


    /**
     * @return string
     */
    public static function GetRandomAdjective(): string
    {
        $Adjectives = CSVReader::GetAdjectives();
        return $Adjectives[rand(0, count($Adjectives) - 1)];
    }

}

//echo "\n\n";
//echo print_r(MyFakeInfo::GetRandomLocation());