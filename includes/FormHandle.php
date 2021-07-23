<?php

namespace DataHandle;

abstract class FormHandle{
    abstract public static function selectBook($search_type, $search_value);//search_type: titolo, autore, isbn, data
    abstract public static function insertBook($form_data);
    abstract public static function updateBook($form_data, $id);
    abstract public static function deleteBook($form_data, $id);
    abstract public static function changeBookStatus($id, $status, $id_user = null);    

}
