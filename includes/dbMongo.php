<?php
require_once __DIR__.'/../vendor/autoload.php';

function connect(){
    $client = new MongoDB\Client(
   
        //"mongodb://127.0.0.1:27017/?compressors=disabled&gssapiServiceName=mongodb"
       "mongodb+srv://paula:luna12182@cluster0.bsigg.mongodb.net/biblioteca?retryWrites=true&w=majority"
       
    );
    
    $db = $client->biblioteca;
    $listaCollezioni = iterator_to_array($db->listCollectionNames());
    if(!in_array('libro', $listaCollezioni)){
        $db->createCollection("libro",[
            'validator'=>[
                '$jsonSchema' =>[
                    'bsonType' =>'object',
                    'required' => ["titolo", "ISBN", "autore","stato"],
                    'properties' =>[
                        'titolo' => [
                            'bsonType' => "string",
                            'description' => 'Deve essere una stringa ed è obligatorio'
                        ],
                        'ISBN' => [
                            'bsonType' => "string",
                            'description' => 'Deve essere una stringa ed è obligatorio'
                        ],
                        'autore' => [
                            'bsonType' => 'string',
                            'description' => 'Deve essere una stringa ed è obligatorio'
                        ],
                        'stato' => [
                            'bsonType' => 'string',
                            'description' => 'Deve essere una stringa ed è obligatorio'
                        ],
                        'copertina' => [
                            'bsonType' => 'string',
                            'description' => 'Deve essere una stringa e non è obligatorio'
                        ],
                        'data_pubblicazione' => [
                            'bsonType' => 'date',
                            'description' => 'Deve essere una date e non è obligatoria'
                        ],
                    ]
                ]
            ]
                        ]);
    }
    if(!in_array('tasks', $listaCollezioni)){
        $db->createCollection("tasks",[
            'validator'=>[
                '$jsonSchema' =>[
                    'bsonType' =>'object',
                    'required' => ["description", "status", "date"],
                    'properties' =>[
                        'description' => [
                            'bsonType' => "string",
                            'description' => 'Deve essere una stringa ed è obligatorio'
                        ],
                        'status' => [
                            'bsonType' => "bool",
                            'description' => 'Deve essere un booleano ed è obligatorio'
                        ],
                        'date' => [
                            'bsonType' => 'date',
                            'description' => 'Deve essere una data valida ed è obligatoria'
                        ]
                    ]
                ]
            ]
                        ]);
    }
    if(!in_array('tasks', $listaCollezioni)){
        $db->createCollection("tasks",[
            'validator'=>[
                '$jsonSchema' =>[
                    'bsonType' =>'object',
                    'required' => ["description", "status", "date"],
                    'properties' =>[
                        'description' => [
                            'bsonType' => "string",
                            'description' => 'Deve essere una stringa ed è obligatorio'
                        ],
                        'status' => [
                            'bsonType' => "bool",
                            'description' => 'Deve essere un booleano ed è obligatorio'
                        ],
                        'date' => [
                            'bsonType' => 'date',
                            'description' => 'Deve essere una data valida ed è obligatoria'
                        ]
                    ]
                ]
            ]
                        ]);
    }
    return $db;

}
