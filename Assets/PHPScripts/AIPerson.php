<?php
//require_once '../../vendor/autoload.php';
include "Person.php";
include "MyFakeInfo.php";

class AIPerson implements IPerson
{
    static int $MaxAge = 100;
    static int $MinAge = 10;
    private array $location;
    private IPerson $person;

    private \Faker\Generator $faker;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $faker = Faker\Factory::create();
        $this->faker = $faker;
        $b_gender = rand(0, 1);
        $sex = $b_gender == 1 ? 'female' : 'male';
        $first_name = MyFakeInfo::GetFirstName($sex);        
        $last_name = MyFakeInfo::GetLastName();
        $date_of_birth= MyFakeInfo::GetRandomDate(self::$MinAge, self::$MaxAge);
        $title = $b_gender == 1 ? $faker->titleFemale() : $faker->titleMale();
        $location = MyFakeInfo::GetRandomLocation();
        $this->location = $location;
        $username = self::GenerateUserName($first_name, $last_name, $date_of_birth, $title, $sex, $location);
        $display_name = $username . rand(0, 100000);
        $email_address = rand(0, 1) == 1 ? $display_name : ($first_name . "." . $last_name);
        $email_address .= MyFakeInfo::GetEmailDomain();
        $email_address = str_replace(" ", rand(0, 1) == 1 ? "" : ".", $email_address);
        $address_number = $faker->buildingNumber();
        $address_street = $faker->streetName();        
        $address_city = $location['town'];
        $address_region = $location['region'];
        $postcode = $location['postcode'];
        $country = $location['country_string'];
        $phone_number = $faker->phoneNumber();
        $this->person = new Person($first_name, $last_name, $date_of_birth,$email_address,$address_number,
            $address_street,$address_city,$address_region,$country,$title,$sex,$username, $postcode, $phone_number);
    }

    /**
     * @param $firstName string
     * @param $LastName string
     * @param $DateOfBirth DateTime
     * @param $title string
     * @param $sex string ('female','male')
     * @param array $location
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
     * @return string
     * string
     * returns a randomly generated username with user details
     */
    static function GenerateUserName(string $firstName, string $LastName, DateTime $DateOfBirth, string $title, 
                                     string $sex, array $location): string
    {
        $validSpaces = ['.','-','_',''];
        $randomSpace = $validSpaces[rand(0,count($validSpaces) -1)];
        $animal = MyFakeInfo::GetRandomAnimal();
        $adjective = MyFakeInfo::GetRandomAdjective();
        $randomNumber = rand(0,1000);

        switch (rand(0,2))
        {
            case 0:
                $randomNumber = $DateOfBirth->format('Y');
                break;
            case 1:
                $randomNumber = $DateOfBirth->format('my');
                break;
            case 2:
                $randomNumber = $DateOfBirth->format('dm');
                break;
            default:

        }
        
        
        switch (rand(0,10))
        {
            case 0:
                $username = $title.' '.$animal.' '.$randomNumber;
                break;
            case 1:
                $username = $title.' '.$firstName.' '.$randomNumber;
                break;
            case 2:
                $username = $title.' '.$LastName.' '.$randomNumber;
                break;
            case 3:
                $username = $adjective.' '.$animal.' '.$randomNumber;
                break;
            case 4:
                $username = $adjective.' '.$firstName.' '.$randomNumber;
                break;
            case 5:
                $username = $adjective.' '.$LastName.' '.$randomNumber;
                break;
            case 6:
                $username = $location['region'].' '.$firstName.' '.$randomNumber;
                break;
            case 7:
                $username = $location['region'].' '.$LastName.' '.$randomNumber;
                break;
            case 8:
                $username = $location['region'].' '.$animal.' '.$randomNumber;
                break;
            case 9:
                $username = $location['region'].' '.$adjective.' '.$animal.' '.$randomNumber;
                break;
            case 10:
                $username = $firstName.' '.$LastName.' '.$randomNumber;
                break;
            default:
                $username = $title.' '.$firstName.' '.$LastName.' '.$randomNumber;
        }
        $validSpaces[] = ' ';
        return self::CleanUpString($validSpaces, $username, $randomSpace);
        
    }
    
    public static function CleanUpString(array $replaceLetters, string $text, string $replaceWith)
    {
        foreach ($replaceLetters as $letter)
        {
            $text = str_replace($letter,$replaceWith,$text);
        }
        return $text;
        
    }

//    /**
//     * @return array
//     */
//    public function CreateDetails(): array
//    {
//        $comment = $this->faker->text(). "\n";
//        $contact_me = rand(0, 1);
//        return array(&$this, $comment, $contact_me);
//    }
    
    public function GetTile(): string
    {
        return $this->person->GetTile();
    }

    public function GetName(): string
    {
        return $this->person->GetName();
    }

    public function GetFirstName(): string
    {
        return $this->person->GetFirstName();
    }

    public function GetLastName(): string
    {
        return $this->person->GetLastName();
    }

    public function GetEmail(): string
    {
        return $this->person->GetEmail();
    }

    public function GetAddressNumber(): string
    {
        return $this->person->GetAddressNumber();
    }

    public function GetAddressStreetName(): string
    {
        return $this->person->GetAddressStreetName();
    }

    public function GetAddressCity(): string
    {
        return $this->person->GetAddressCity();
    }

    public function GetAddressRegion(): string
    {
        return $this->person->GetAddressRegion();
    }

    public function GetAddressCountry(): string
    {
        return $this->person->GetAddressCountry();
    }

    public function GetAge(): int
    {
        return $this->person->GetAge();
    }

    public function GetDateOfBirth(): DateTime
    {
        return $this->person->GetDateOfBirth();
    }

    public function GetGender(): string
    {
        return $this->person->GetGender();
    }

    public function GetUserName(): string
    {
        return $this->person->GetUserName();
    }

    

    public function GetPhoneNumber(): string
    {
        return $this->person->GetPhoneNumber();
    }

    public function GetPostCode(): string
    {
        return $this->person->GetPostCode();
    }

    public function GetDisplayName()
    {
        return self::GenerateUserName($this->GetFirstName(),$this->GetLastName(), $this->GetDateOfBirth(),
            $this->GetTile(), $this->GetGender(),$this->location);
    }

    public function GetComment(): string
    {
        return $this->faker->text(). "\n";
    }

    public function GetContactMe(): string
    {
        return rand(0, 1);
    }
}
