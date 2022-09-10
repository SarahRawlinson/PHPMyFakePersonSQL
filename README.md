# PHP-My-Fake-Person-SQL

This project is to create fake data into a SQL database
I originally started working on this in a previous project and have now migrated this to its own repository.
<!-- TOC -->
* The MyFakeInfoClass creates random data from CSV and text files found in the Assets Directory (CSVFiles,TextFiles).
* The AIPerson uses the [fakerphp library](https://fakerphp.github.io/), but I intend to replace functions with my own MyFakeInfo class.
* The DatabaseConnection class takes the information and creates database entries into the database.
* Test Faker takes the fake data and calls on the DatabaseConnection Class
<!-- TOC -->

