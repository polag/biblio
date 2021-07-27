<?php

namespace DataHandle;

require_once __DIR__ . '/db.php';


use \DataHandle\Utils\InputSanitize;
use Mysqli;
use Exception;

class Utente
{
    use \DataHandle\Utils\InputSanitize;
    public static function sanitize($fields)
    {
        $errors        = array();
        // Sanificare codice fiscale e verificarne la validità
        $fields['codice_fiscale'] = self::cleanInput($fields['codice_fiscale']);
        if (self::isCodiceFiscaleValid($fields['codice_fiscale']) === 0) {
            $errors[] = new Exception('Codice fiscale non valido.');
        }
        
        $fields['nome'] = self::cleanInput($fields['nome']);
        $fields['cognome'] = self::cleanInput($fields['cognome']);

        // Sanificare numero di telefono e verificarne la validità
        $fields['telefono'] = self::cleanInput($fields['telefono']);
        if (self::isPhoneNumberValid($fields['telefono']) === 0) {
            $errors[] = new Exception('Numero di telefono non valido.');
        }


        // Sanificare email e verificarne la validità
        if (isset($fields['email']) && $fields['email'] !== '') {
            $fields['email'] = self::cleanInput($fields['email']);
            if (!self::isEmailAddressValid($fields['email'])) {
                $errors[] = new Exception('E-mail non valido.');
            }
        }



        if (count($errors) > 0) {
            return $errors;
        }

        return $fields;
    }

    public static function isImpiegato($codice_fiscale){
        global $mysqli;
        $query = $mysqli->query("SELECT ruolo FROM persona WHERE codice_fiscale = '".$codice_fiscale."'");
      
        $ruolo = $query->fetch_assoc();

        if($ruolo['ruolo'] == "impiegato"){
            return true;
        }else{
            return false;
        }

    }

    public static function registerUser($form_data)
    {

        $fields = array(
            'codice_fiscale'        => $form_data['codice_fiscale'],
            'password'        => $form_data['password'],
            'password-check'  => $form_data['password-check'],
            'nome'        => $form_data['nome'],
            'cognome'        => $form_data['cognome'],
            'telefono'        => $form_data['telefono'],
            'email'        => $form_data['email'],
            'ruolo'        => $form_data['ruolo']
        );

        $fields = self::sanitize($fields);
         var_dump($fields);
        if ($fields[0] instanceof Exception) {
            $error_messages = '';
            foreach ($fields as $key => $error) {
                $error_messages .= $error->getMessage();
                if ($key < count($fields) - 1) {
                    $error_messages .= '|';
                }
            }
            header('Location: https://localhost/biblio/registration.php?stato=errore&messages='
                . $error_messages);
            exit;
        }
        if ($fields['password'] !== $fields['password-check']) {
            header('Location: https://localhost/biblio/registration?stato=errore&messages=I Password non corrispondono');
            exit;
        }

        global $mysqli;
        //check if codice_fiscale already exists
        $query_user = $mysqli->query("SELECT codice_fiscale FROM persona WHERE codice_fiscale = '" . $fields['codice_fiscale'] . "'");

        if ($query_user->num_rows > 0) {
            header('Location: https://localhost/biblio/registration.php?stato=errore&messages=Utente già registrato.');
            exit;
        }
        $query_user->close();

        //check if email already registered
        $query_email = $mysqli->query("SELECT email FROM persona WHERE email = '" . $fields['email'] . "'");

        if ($query_email->num_rows > 0) {
            header('Location: https://localhost/biblio/registration.php?stato=errore&messages=Email già registrato.');
            exit;
        }

        $query_email->close();

        $query = $mysqli->prepare('INSERT INTO persona(codice_fiscale, nome, cognome, email, telefono, password, ruolo) VALUES (?, ?,?,?,?,MD5(?),?)');
        $query->bind_param('sssssss', $fields['codice_fiscale'], $fields['nome'], $fields['cognome'], $fields['email'], $fields['telefono'], $fields['password'],$fields['ruolo']);
        $query->execute();

        if ($query->affected_rows === 0) {
            error_log('Error MySQL: ' . $query->error_list[0]['error']);
            header('Location: https://localhost/biblio/registration.php?stato=ko');
            exit;
        }

        header('Location: https://localhost/biblio/registration.php?stato=ok');
        exit;
    }

    public static function loginUser($form_data)
    {

        $fields = array(
            'codice_fiscale'  => $form_data['codice_fiscale'],
            'password'  => $form_data['password']
        );



        global $mysqli;

        $query_user = $mysqli->query("SELECT * FROM persona WHERE codice_fiscale = '" . $fields['codice_fiscale'] . "'");
        if ($query_user->num_rows === 0) {
            header("Location: https://localhost/biblio/login.php?statologin=errore&messages=Utente non registrato.");
            exit;
        }

        $user = $query_user->fetch_assoc();

        if ($user['password'] !== md5($fields['password'])) {
            header('Location: https://localhost/biblio/login.php?statologin=errore&messages=Password errata.');
            exit;
        }

        return array(
            'codice_fiscale'  => $user['codice_fiscale'],
            'nome' => $user['nome']
        );
    }

    public static function deleteUser($codice_fiscale)
    {
        global $mysqli;
        
        $query = $mysqli->prepare('DELETE FROM persona WHERE codice_fiscale = ?');
        $query->bind_param('s', $codice_fiscale);
        $query->execute();

        if ($query->affected_rows > 0) {
            
            header('Location: https://localhost/biblio/manage-user.php?stato=ok&action=Eliminato');
            exit;
        } else {
            //var_dump($query);
            header('Location: https://localhost/biblio/manage-user.php&stato=ko');
            exit;
        }
    }

     public static function selectUser($userId)
    {
        global $mysqli;

        $query_user = $mysqli->query("SELECT * FROM persona WHERE codice_fiscale = '" . $userId."'");
        $user = $query_user->fetch_assoc();
        return $user;
    } 
    public static function updateUser($form_data, $codice_fiscale)
    {

        $fields = array(
            'nome'        => $form_data['nome'],
            'cognome'        => $form_data['cognome'],
            'telefono'        => $form_data['telefono'],
            'email'        => $form_data['email'],
            'ruolo'        => $form_data['ruolo']
            
        );

        if ($fields) {
            global $mysqli;
            $query = $mysqli->prepare('UPDATE persona SET nome = ?, cognome = ?, telefono = ?, email = ?, ruolo = ? WHERE codice_fiscale = ? ');

            $query->bind_param('ssssss', $fields['nome'], $fields['cognome'], $fields['telefono'], $fields['email'], $fields['ruolo'], $codice_fiscale);
            $query->execute();


            if ($query->affected_rows > 0) {
                header('Location: https://localhost/biblio/manage-user.php?id=' . $codice_fiscale . '&stato=ok&action=Modificato');
                exit;
            } else {
                header('Location: https://localhost/biblio/manage-user.php?id=' . $codice_fiscale . '&stato=ko');
                exit;
            }
        }
    }
    public static function updatePassword($password, $newPassword, $codice_fiscale){
        global $mysqli;
            $query = $mysqli->prepare('UPDATE persona SET password = ? WHERE codice_fiscale = ? AND password = ?');

            $query->bind_param('sss', md5($newPassword), $codice_fiscale, md5($password));
            $query->execute();


            if ($query->affected_rows > 0) {
                header('Location: https://localhost/biblio/index.php?stato=ok&action=Modificato');
                exit;
            } else {
                header('Location: https://localhost/biblio/index.php?id=' . $codice_fiscale . '&stato=ko&message=Incorrect Password');
                exit;
            }
    }
}
