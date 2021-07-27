<?php
include_once __DIR__ . '/includes/globals.php';
if($_SESSION['is_impiegato']==false){
  header('Location: https://localhost/biblio/index.php');
  exit;
}
$id_libro = $_GET['id'];
$history = \DataHandle\Libro::viewBookHistory($id_libro);

?>
<div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Libro</th>
      <th scope="col">Associato</th>
      <th scope="col">Data Ritiro</th>
      <th scope="col">Data Restituzione</th>
    </tr>
  </thead>
  <tbody>
    
      <?php 
foreach($history as $record):
    $user = \DataHandle\Utente::selectUser($record['id_associato']);
    $libro = \DataHandle\Libro::selectBook($search_type =null, $search_value =null, $id_libro);?>
    <tr>
      <td><?php echo $libro['titolo'];?></td>
      <td><?php echo $user['nome'].' '.$user['cognome'];?> </td>
      <td><?php echo $record['data_ritiro'];?></td>
      <td><?php echo $record['data_restituzione'];?></td>
      </tr>
      <?php endforeach;?>
    
  </tbody>
</table>

</div>
