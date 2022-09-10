<?php
//require_once '../../vendor/autoload.php';
include "Person.php";
include "MyFakeInfo.php";

class AIPerson implements IPerson
{
    static int $MaxAge = 100;
    static int $MinAge = 10;
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
        //$company = $faker->company();
        $first_name = MyFakeInfo::GetFirstName($sex);        
        $last_name = MyFakeInfo::GetLastName();
        //$last_name = $faker->lastName();
        $date_of_birth= MyFakeInfo::GetRandomDate(self::$MinAge, self::$MaxAge);
        $title = $b_gender == 1 ? $faker->titleFemale() : $faker->titleMale();
        $username = self::GenerateUserName($first_name, $last_name, $date_of_birth, $title, $sex);
        $display_name = $username . rand(0, 100000);
        $email_address = rand(0, 1) == 1 ? $display_name : ($first_name . "." . $last_name);
        $email_address .= MyFakeInfo::GetEmailDomain();
        $email_address = str_replace(" ", rand(0, 1) == 1 ? "" : ".", $email_address);
        $address_number = $faker->buildingNumber();
        $address_street = $faker->streetName();
        $location = MyFakeInfo::GetRandomLocation();
        $address_city = $location['town'];
        $address_region = $location['region'];
        $postcode = $location['postcode'];
        $country = $location['country_string'];
        //$address_city = $faker->city();
        //$address_region = "";        
        //$postcode = $faker->postcode();
        //$country = $faker->country();
        $phone_number = $faker->phoneNumber();
        $this->person = new Person($first_name, $last_name, $date_of_birth,$email_address,$address_number,
            $address_street,$address_city,$address_region,$country,$title,$sex,$username, $postcode, $phone_number);
    }
    
    static function GenerateUserName($firstName, $LastName, $DateOfBirth, $title, $sex): string
    {
        $validSpaces = ['.','-','_'];
        return $firstName.'.'.$LastName.$DateOfBirth->format('y').'-'.rand(0,10000);
    }

    /**
     * @param \Faker\Generator $faker
     * @return array
     */
    public function CreateDetails(): array
    {
        $comment = $this->faker->text(). "\n";
        $contact_me = rand(0, 1);
        return array($this->person->GetGender(), $this->person->GetFirstName(), $this->person->GetLastName(), 
            $this->person->GetUserName(), $this->person->GetEmail(), 
            $this->person->GetAddressNumber().' '.$this->person->GetAddressStreetName(), $this->person->GetAddressCity(),
            $this->person->GetAddressRegion(), $this->person->GetTile(), $this->person->GetPostCode(),
            $this->person->GetAddressCountry(), $this->person->GetPhoneNumber(), $comment, $contact_me);
    }

    public function GetTile(): string
    {
        return $this->person.$this->GetTile();
    }

    public function GetName(): string
    {
        return $this->person.$this->GetName();
    }

    public function GetFirstName(): string
    {
        return $this->person.$this->GetFirstName();
    }

    public function GetLastName(): string
    {
        return $this->person.$this->GetLastName();
    }

    public function GetEmail(): string
    {
        return $this->person.$this->GetEmail();
    }

    public function GetAddressNumber(): string
    {
        return $this->person.$this->GetAddressNumber();
    }

    public function GetAddressStreetName(): string
    {
        return $this->person.$this->GetAddressStreetName();
    }

    public function GetAddressCity(): string
    {
        return $this->person.$this->GetAddressCity();
    }

    public function GetAddressRegion(): string
    {
        return $this->person.$this->GetAddressRegion();
    }

    public function GetAddressCountry(): string
    {
        return $this->person.$this->GetAddressCountry();
    }

    public function GetAge(): int
    {
        return $this->person.$this->GetAge();
    }

    public function GetDateOfBirth(): DateTime
    {
        return $this->person.$this->GetDateOfBirth();
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
}
