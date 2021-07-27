<?php

namespace DataHandle;

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/util.php';

use \DataHandle\Utils\InputSanitize;
use Mysqli;
use Exception;

class Libro extends FormHandle
{
    use \DataHandle\Utils\InputSanitize;

    public static function sanitize($fields)
    {
        $errors        = array();

        $fields['ISBN'] = self::cleanInput($fields['ISBN']);
        if (self::isISBNValid($fields['ISBN']) === 0) {
            $errors[] = new Exception('ISBN non valido.');
        }
        $fields['data_pubblicazione'] = self::cleanInput($fields['data_pubblicazione']);

        $fields['autore'] = self::cleanInput($fields['autore']);



        if (count($errors) > 0) {
            return $errors;
        }

        return $fields;
    }

    public static function selectBook($search_type = null, $search_value  = null, $id  = null)
    {
        global $mysqli;
        if (isset($search_type)) {
            $query = $mysqli->query('SELECT * FROM libro WHERE ' . $search_type . ' LIKE "%' . $search_value . '%"');
            $results = array();

            while ($row = $query->fetch_assoc()) {
                $results[] = $row;
            }
        } else {
            $query = $mysqli->query('SELECT * FROM libro WHERE id = ' . $id);
            $results = $query->fetch_assoc();
        }

        return $results;
    }

    public static function insertBook($form_data)
    {
        $fields = array(
            'titolo'          => $form_data['titolo'],
            'ISBN'       => $form_data['ISBN'],
            'copertina'       => $form_data['copertina'],
            'data_pubblicazione'          => $form_data['data_pubblicazione'],
            'autore' => $form_data['autore'],
            'stato' => 'disponibile'


        );
        $fields = self::sanitize($fields);

        if ($fields[0] instanceof Exception) {
            $error_messages = '';
            foreach ($fields as $key => $error) {
                $error_messages .= $error->getMessage();
                if ($key < count($fields) - 1) {
                    $error_messages .= '|';
                }
            }
            header('Location: https://localhost/biblio/insert-book.php?stato=errore&messages='
                . $error_messages);
            exit;
        }
        global $mysqli;
        $query = $mysqli->prepare('INSERT INTO libro(titolo, ISBN, copertina, data_pubblicazione, autore, stato) VALUES (?, ?,?,?,?, ?)');
        $query->bind_param('ssssss', $fields['titolo'], $fields['ISBN'], $fields['copertina'], $fields['data_pubblicazione'], $fields['autore'], $fields['stato']);
        $query->execute();

        if ($query->affected_rows === 0) {
            header('Location: https://localhost/biblio/insert-book.php?stato=ko');
            exit;
        }

        header('Location: https://localhost/biblio/insert-book.php?stato=ok');
        exit;
    }

    public static function updateBook($form_data, $id)
    {
        $fields = array(
            'titolo'          => $form_data['titolo'],
            'ISBN'       => $form_data['ISBN'],
            'copertina'       => $form_data['copertina'],
            'data_pubblicazione'          => $form_data['data_pubblicazione'],
            'autore' => $form_data['autore'],


        );
        $fields = self::sanitize($fields);

        global $mysqli;
        

        $id = intval($id);

        $query = $mysqli->prepare('UPDATE libro SET titolo = ?, ISBN = ?, copertina = ?, data_pubblicazione = ?, autore = ? WHERE id= ?');


        $query->bind_param('sssssi', $fields['titolo'], $fields['ISBN'], $fields['copertina'], $fields['data_pubblicazione'], $fields['autore'], $id);
        $query->execute();


        if ($query->affected_rows === 0) {
            error_log('Error MySQL: ' . $query->error_list[0]['error']);
            header('Location: https://localhost/biblio/index.php?stato=ko&action=Modificato');
            exit;
        }

        header('Location: https://localhost/biblio/index.php?stato=ok&action=Modificato');
        exit;
    }

    public static function deleteBook($id)
    {
        global $mysqli;


        $id = intval($id);

        $query = $mysqli->prepare('DELETE FROM libro WHERE id = ?');


        $query->bind_param('i', $id);
        $query->execute();


        if ($query->affected_rows === 0) {
            header('Location: https://localhost/biblio/index.php?stato=ko');
            exit;
        }

        header('Location: https://localhost/biblio/index.php?stato=ok&action=Eliminato');
        exit;
    }

    public static function changeBookStatus($id_libro, $status, $id_user = null)
    {
        global $mysqli;
        
        $id_libro = intval($id_libro);
        if($status == 'In prestito'){ 
            $query_user = $mysqli->query("SELECT codice_fiscale FROM persona WHERE codice_fiscale = '" . $id_user . "'");

            if ($query_user->num_rows == 0) {
                header('Location: https://localhost/biblio/index.php?stato=errore&action=prestito&messages=Utente non registrato.');
                exit;
            }
            $query_user->close();
    

            $query = $mysqli->prepare('INSERT INTO ritiro_libro(id_associato, id_libro) VALUES(?,?)');
            $query->bind_param('si', $id_user,$id_libro);
            $query->execute();
       }
        elseif($status == 'Disponibile'){ 
            $query = $mysqli->prepare('UPDATE ritiro_libro SET data_restituzione = NOW() WHERE id_libro = ?');
            $query->bind_param('i', $id_libro);
            $query->execute();
        }
            if ($query->affected_rows > 0) {
                $query_libro = $mysqli->prepare('UPDATE libro SET stato= ? WHERE id = ?');
                $query_libro->bind_param('si', $status,$id_libro);
                $query_libro->execute();
                if ($query_libro->affected_rows === 0) {
                    header('Location: https://localhost/biblio/index.php?stato=ko');
                    exit;
                }
            }else{
                header('Location: https://localhost/biblio/index.php?stato=ko');
                exit;
            }
            header('Location: https://localhost/biblio/index.php?stato=ok&action=Stato Aggiornato');
            exit;
  
    }    
        
    public static function viewBookHistory($id_libro = null, $id_user = null){
            global $mysqli;
        
            if($id_libro){
                $id_libro = intval($id_libro);
                $query = $mysqli->query("SELECT * FROM ritiro_libro WHERE id_libro = " . $id_libro);
            }elseif($id_user){
                
                $query = $mysqli->query("SELECT * FROM ritiro_libro WHERE id_associato = '". $id_user."'");
            }
            
            
            $results = array();

            while ($row = $query->fetch_assoc()) {
                $results[] = $row;
            }
            return $results;
    }

}
