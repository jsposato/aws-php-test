<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sauron', function () {
    $tableName = 'sauron';

    $dynamo = App::make('aws')->createClient('DynamoDb');

    $request = [
        'TableName' => $tableName,
    ];

    $results = $dynamo->scan($request);

    foreach ($results['Items'] as $key => $value) {
        echo "<pre>";
        echo '<strong><h3>Project: ' . $value['project']['S'] . "</h3></strong>\n";
        echo 'ID: ' . $value['Project_Id']['S'] . "\n";
        echo 'Bug Count: ' . $value['Bug_Count']['S'] . "\n";
        echo 'Miss Count: ' . $value['Miss_Count']['S'] . "\n";
        echo 'Story Count: ' . $value['Story_Count']['S'] . "\n";
        echo 'Improvement Count: ' . $value['Improvement_Count']['S'] . "\n";
        echo 'Unknown Count: ' . $value['Unknown_Count']['S'] . "\n";
        echo "<br />\n";
        echo "</pre>";
    }
});

