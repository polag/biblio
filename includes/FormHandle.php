<?php

namespace DataHandle;

abstract class FormHandle{
    abstract public static function selectBook($search_type = null, $search_value  = null, $id  = null);//search_type: titolo, autore, isbn, data
    abstract public static function insertBook($form_data);
    abstract public static function updateBook($form_data, $id);
    abstract public static function deleteBook($id);
    abstract public static function changeBookStatus($id, $status, $id_user=null);    
    abstract public static function viewBookHistory($id_libro = null, $id_user = null);
}
