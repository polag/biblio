<?php

namespace DataHandle;

require_once __DIR__ . '/db.php';

use Mysqli;
use Exception;

class Libro extends FormHandle
{
    public static function selectBook($search_type, $search_value)
    { 
        global $mysqli;
        $query = $mysqli->query('SELECT * FROM libro WHERE ' . $search_type . ' LIKE "%' . $search_value . '%"');
        $results = array();

        while ($row = $query->fetch_assoc()) {
            $results[] = $row;
        }
        return $results;
    }

    public static function insertBook($form_data)
    {
        global $mysqli;
        $query = $mysqli->prepare('INSERT INTO user(codice_fiscale, nome, cognome, email, telefono, password, ruolo) VALUES (?, ?,?,?,?,MD5(?),?)');
        $query->bind_param('sssssss', $fields['codice_fiscale'], $fields['nome'], $fields['cognome'], $fields['email'], $fields['telefono'], $fields['password'],$fields['ruolo']);
        $query->execute();
    }

    public static function updateBook($form_data, $id)
    {
    }

    public static function deleteBook($form_data, $id)
    {
    }

    public static function changeBookStatus($id, $status, $id_user = null)
    {
    }
}
