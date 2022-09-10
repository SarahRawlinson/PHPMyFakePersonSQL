<?php
include "IPerson.php";

class Person implements IPerson
{
    private string $first_name;
    private string $last_name;
    private DateTime $date_of_birth;
    private string $email;
    private string $address_number;
    private string $address_streetName;
    private string $address_city;
    private string $address_region;
    private string $address_country;
    private string $title;
    private string $gender;
    private string $user_name;
    private string $phone_number;
    private string $postcode;

    public function __construct(string $firstName, string $lastName, DateTime $dateOfBirth, string $email,
                                string $addressNumber,string $addressStreetName, string $addressCity, 
                                string $addressRegion, string $addressCountry, string $title, string $gender, 
                                string $userName, string $postcode, string $phoneNumber)
    {
        $this->first_name=$firstName;
        $this->last_name=$lastName;
        $this->date_of_birth=$dateOfBirth;
        $this->email=$email;
        $this->address_number=$addressNumber;
        $this->address_streetName=$addressStreetName;
        $this->address_city=$addressCity;
        $this->address_region=$addressRegion;
        $this->address_country=$addressCountry;
        $this->title=$title;
        $this->gender = $gender;
        $this->user_name=$userName;
        $this->phone_number=$phoneNumber;
        $this->postcode=$postcode;
    }

    public function GetTile(): string
    {
        return $this->title;
    }

    public function GetName(): string
    {
        return $this->title." ".$this->first_name." ".$this->last_name;
    }

    public function GetFirstName(): string
    {
        return $this->first_name;
    }

    public function GetLastName(): string
    {
        return $this->last_name;
    }

    public function GetEmail(): string
    {
        return $this->email;
    }

    public function GetAddressNumber(): string
    {
        return $this->address_number;
    }

    public function GetAddressStreetName(): string
    {
        return $this->address_streetName;
    }

    public function GetAddressCity(): string
    {
        return $this->address_city;
    }

    public function GetAddressRegion(): string
    {
        return $this->address_region;
    }

    public function GetAddressCountry(): string
    {
        return $this->address_country;
    }

    public function GetAge(): int
    {
        $today = new DateTime('now');
        $dateInterval = ($this->date_of_birth->diff($today));
        return $dateInterval->y;
    }

    public function GetDateOfBirth(): DateTime
    {
        return $this->date_of_birth;
    }


    public function GetGender(): string
    {
        return $this->gender;
    }

    public function GetUserName(): string
    {
        return $this->user_name;
    }

    public function GetPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function GetPostCode(): string
    {
        return $this->postcode;
    }
}