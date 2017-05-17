# Export anonymized data

Working with third parties sometimes require to deliver example data, to debug bug for example.
These data should in no way contain confidential data. To ensure this, this export uses
arrilot/data-anonymization and fzaninotto/Faker.

The first delivers an convinient api to define what tables/fields should get anonymized. The later
then delivers the values to be as replacement of the real data.

## Installation

* make sure that php PDO is available

* either install via

  * git clone https://github.com/evoWeb/anonymized-export.git && cd anonymized-export && composer install

  * mkdir anonymized-export && cd anonymized-export && composer require evoweb/anonymized-export

## Usage

Workflow:

1. Copy the vendor/evoweb/anonymized-export/example.phpsh to the current folder

2. Create a folder for the database dumps and configure by utilizing the $anonymizer->setExportPath()
   **If the folder is not set the dumps are going to be stored in ./vendor/evoweb/anonymized-export/dump/**

3. Insert your database login data

4. If you want to limit the export to only certain tables add those with $anonymizer->addTablesToExport().  
   **If no tables are added all tables are included.**

4. Define how you want to anonymize your data in this file using fluent api. All unconfigured but added tables
   wont get anonymized.

5. Make sure it is not accessible throw the web and etc.

6. Run it every time you want.

The minimum needed information in the export are:

```php

#!/usr/bin/env php
<?php

use Evoweb\AnonymizedExport\Blueprint;

require __DIR__ . '/vendor/autoload.php';

// Database connection information
$dsn = 'mysql:dbname=databasename;host=127.0.0.1';
$user = '';
$password = '';

$database = new \Evoweb\AnonymizedExport\Database\SqlDatabase($dsn, $user, $password);
$anonymizer = new \Evoweb\AnonymizedExport\Anonymizer($database);

// if the folder is not set the files are stored in ./vendor/evoweb/anonymized-export/dump/
//$anonymizer->setExportPath(__DIR__ . '/dump/');

// Define tables to export. (Default is to include all tables)
// $anonymizer->addTablesToExport(['table_a']);

$anonymizer->table('table_a', function (Blueprint $table) {
    // default is 'id'
    $table->primary('uid');

    $table->column('title')->replaceWith(function ($generator) {
        /** @var \Faker\Generator $generator */
        return $generator->text(255);
    });
});

$anonymizer->run();

echo 'Anonymization has been completed!';

```