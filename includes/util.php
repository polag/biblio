<?php
namespace DataHandle\Utils;


function show_alert($action_type, $state)
{
    if ($state === 'ko') {
      echo '<div class="alert alert-danger" role="alert">Please try again later.</div>';
      return false;
    }

    if ($state === "errore") {
      echo '<div class="alert alert-danger" role="alert"><ul>';
      $error_messages = explode('|', $_GET['messages']);
      foreach ($error_messages as $error) {
          echo "<li>$error</li>";
      }
      echo '</ul></div>';
    }

    if($state === 'ok'){
      if(($action_type == 'registrazione')||($action_type == 'login')) {
        echo '<div class="alert alert-success" role="alert">'.ucfirst($action_type).' succesfull!</div>';
      }
     else{
        echo '<div class="alert alert-success" role="alert">Libro '.strtolower($action_type).' con successo</div>';

      }
    }

    
}

trait InputSanitize
{
    public static function cleanInput($data)
    {
        $data = trim($data);
        $data = filter_var($data, FILTER_SANITIZE_ADD_SLASHES);
        $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
        return $data;
    }
    public static function isPhoneNumberValid($telefono)
    {
         return preg_match('/^([\+][0-9]{2,3})?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $telefono);
    }
    public static function isEmailAddressValid($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public static function isCodiceFiscaleValid($codice_fiscale)
    {
        return preg_match('/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/i', $codice_fiscale);
       
    }


}
