To Install:
composer require jpgerber/c-frame

To Initialize:
On your index.php file (located from root/public/):

`
require_once(__DIR__ . '/../vendor/autoload.php'); // Replace with the autoload.php location for your project.

use ChaosWD\System\ENV;
use ChaosWD\Network\CRUD;

ENV::load(__DIR__ . "/../private/config/.env"); // Replace with your .env file location or omit if not applicable.

// INSERT
$db = new CRUD();
$db->create(
    $tableName, [
        'column1' => 'column1Value'
        'column2'=> 'column2Value'
        ]
    );

// SELECT
$db = new CRUD();
$db->read(
    $tableName,
    $columns, // defaults to "*"
    $conditional, // Associative array of ['where'=> [], 'params'=>[]]
    $order, // optional ('ORDER BY `column` ASC')
    $limit // optional integer ('LIMIT 5')
);
`