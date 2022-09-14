<?php
include "ReadTextFiles.php";
include "CSVReader.php";
require "DictionaryKeys.php";

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
    private static ?array $animals;
    private static int $countOfAnimals;
    private static ?array $Adjectives;
    private static int $countOfAdjectives;
    private static array $dictionary;
    private static array $dictionaryKeys = [];

    
    private static array $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 
        'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    
    
    private static function CreateDictionary()
    {
        foreach (self::$alphabet as $a)
        {
            $letterDictionary = CSVReader::GetWordsByLetter($a);
            
           // self::$dictionaryKeys[] = $a;
            
            foreach ($letterDictionary as $word)
            {
                $openBracket = strpos($word, '(', 0);
                $closeBracket = strpos($word, ')', 0);
                $justWord = substr($word,0,$openBracket-1);
                $key = substr($word, $openBracket + 1, ($closeBracket - $openBracket) - 1);                
                if (!empty($key)) 
                {
                    $split = explode(" ",$key);
                    foreach ($split as $k)
                    {
                        $k = trim($k,' ,/,\,\',(,),-,.,&,;');
                        $k = str_replace([',' ,'/','',"'",'(',')','-','.','&',';'],'', $k);
                        if (!in_array($k,self::$dictionaryKeys) && !empty($k))
                        {
                            self::$dictionaryKeys[] = $k;
                        }
                        if (!empty($k)) self::$dictionary['key'][$k][] = $justWord;
                    }
                }
                
                self::$dictionary['start_letter'][$a][] = $justWord;
            }           
        }

        //echo "letters loaded";
        self::$dictionary['key'][DictionaryKeys::subj] = CSVReader::GetAnimalNames();
        self::$dictionary['key'][DictionaryKeys::subj] = CSVReader::GetPronouns();
        self::$dictionary['key'][DictionaryKeys::subj] = self::GetFemaleNames();
        self::$dictionary['key'][DictionaryKeys::subj] = self::GetMaleNames();
        //echo "subjects loaded";
        self::$dictionary['key'][DictionaryKeys::noun] = CSVReader::GetNouns();
        //echo "noun loaded";
        self::$dictionary['key'][DictionaryKeys::interj] = CSVReader::GetInterjections();
        //echo "interjections loaded";
        self::$dictionary['key'][DictionaryKeys::conj] = CSVReader::GetConjunctions();
        //echo "conjunctions loaded";
        self::$dictionary['key'][DictionaryKeys::adj] = CSVReader::GetAdjectives();
        //echo "adjectives loaded";
        self::$dictionary['key'][DictionaryKeys::prep] = CSVReader::GetPrepositions();
        //echo "prepositions loaded";
//        foreach (self::$dictionaryKeys as $v)
//        {
//            echo "key ".$v." - ".count(self::$dictionary['key'][$v])."\n";
//        }
        //print_r(self::$dictionaryKeys);
        //print_r(self::$dictionary['a.']);
    }
    
    public static function GetWordPattern(string $pattern)
    {
        $letters = explode(', ',$pattern);
        $newString = "";
        foreach ($letters as $letter)
        {
            if (in_array($letter, self::$dictionaryKeys))
            {
                if (empty($letter) || is_null($letter))
                {
                    continue;
                }
                $arr = self::$dictionary['key'][$letter];
                //
                //echo count($arr)."\n";
                $newString .= $arr[rand(0, count($arr)-1)]." ";
                if (!isset($newString) || is_null($newString))
                {
                    $newString .= $letter;
                }
            }
            else
            {
                $newString .= $letter;
            }
        }
        
        return trim($newString, " ");
    }
    
    public static function GetRandomSentence(): string
    {
        $sentence = "";
        $val = rand(5, 15);
        for ($i = 0; $i < $val; $i++)
        {
            $conjs = self::$dictionary['key'][DictionaryKeys::conj];
            $conj = rand(0,1)==0?".":", ".$conjs[rand(0, count($conjs)-1)];
            $pattern = self::getPattern();
            $sentence .= self::GetWordPattern($pattern)."$conj ";
        }
        
        echo $sentence."\n";
        return $sentence;
    }
    
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
        $animals = self::$animals ?? self::GetAnimals();
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
        if (isset(self::$Adjectives))
        {
            return self::$Adjectives;
        }
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
        if (isset(self::$animals))
        {
            return self::$animals;
        }
        $array = CSVReader::GetAnimals();
        self::$animals = $array;
        self::$countOfAnimals = count($array) - 1;
        return $array;
    }
    
    /**
     * @return array|null
     */
    public static function GetPostcodeUnits(): ?array
    {
        if (isset(self::$postCodeUnits))
        {
            return self::$postCodeUnits;
        }
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
        if (isset(self::$postcodeSectors))
        {
            return self::$postcodeSectors;
        }
        $array = CSVReader::GetPostcodeSectors();
        self::$postcodeSectors = $array;
        return $array;
    }    

    /**
     * @return array|null
     */
    public static function GetEmailDomains(): ?array
    {
        if (isset(self::$emailDomains))
        {
            return self::$emailDomains;
        }
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
        if (isset(self::$femaleNames))
        {
            return self::$femaleNames;
        }
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
        if (isset(self::$maleNames))
        {
            return self::$maleNames;
        }
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
        if (isset(self::$lastNames))
        {
            return self::$lastNames;
        }
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
        if (isset(self::$locations))
        {
            return self::$locations;
        }
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
        if (isset(self::$emailEmailTLDs))
        {
            return self::$emailEmailTLDs;
        }
        self::CreateDictionary();
        $array = CSVReader::GetEmailTLDs();
        self::$emailEmailTLDs = $array;
        self::$countOfEmailTLDs = count($array) - 1;
        return $array;
    }

    /**
     * @param string $pattern
     * @return string
     */
    public static function getPattern(): string
    {
        $pattern = "";
        switch (rand(1, 8)) {
            case 1:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                break;
            case 2:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::obj . ", ";
                break;
            case 3:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::adj . ", ";
                break;
            case 4:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::adv . ", ";
                break;
            case 5:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::noun . ", ";
                break;
            case 6:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::super . ", ";
                break;
            case 7:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::interj . ", ";
                break;
            case 8:
                $pattern .= DictionaryKeys::subj . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::pr . ", ";
                $pattern .= DictionaryKeys::obj . ", ";
                break;
            case 9:
                $pattern .= DictionaryKeys::prep . ", ";
                $pattern .= DictionaryKeys::vb . ", ";
                $pattern .= DictionaryKeys::interj . ", ";
                break;
            default:
                break;
        }
        return $pattern;
    }

}
