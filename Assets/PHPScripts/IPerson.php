<?php

interface IPerson
{
    public function GetTile() : string;
    public function GetName(): string;
    public function GetFirstName() : string;
    public function GetLastName() : string;
    public function GetEmail() : string;
    public function GetAddressNumber() : string;
    public function GetAddressStreetName() : string;
    public function GetAddressCity() : string;
    public function GetAddressRegion() : string;
    public function GetAddressCountry() : string;
    public function GetAge() : int;
    public function GetDateOfBirth() : DateTime;
    public function GetGender() : string;
    public function GetUserName() : string;
    public function GetPhoneNumber() : string;
    public function GetPostCode() : string;
}