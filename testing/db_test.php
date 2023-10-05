<?php
require_once(__DIR__ . '/../vendor/autoload.php');

CFW\System\ENV::load(__DIR__ . "/.env");
$db = new CFW\Network\CRUD();

// $db->create('test', [
// 'one' => 'foo1',
// 'two' => 'bar1',
// 'three' => 'test1'
// ]);

// $data = $db->read('test');
// pr($data);

// $db->update(
//     'test',
//     [
//         'one' => 'stoppit',
//         'two' => 'nooo'
//     ],
//     [
//         'keyID' => 1,
//         'three' => 'test'
//     ]
// );

// $db->delete(
//     'test',
//     [
//         'keyID' => 2
//     ]
// );
