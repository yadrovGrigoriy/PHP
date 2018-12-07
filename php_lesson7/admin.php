<form action="admin.php" enctype="multipart/form-data"  method="POST">
  <p><input type="file" name="userfile"></p>
  <p><input type="submit" value="Отправить" ></p>
</form>


  <?php
  $upload = 'tests/';
  if(!empty($_FILES)) {
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
      move_uploaded_file($_FILES['userfile']['tmp_name'], $upload .
        $_FILES['userfile']['name']);
    echo "Фаил загружен", "<br>", "<br>";
    header('Location: list.php');


    } else {
      echo "Фаил не загружен", "<br>";
    }
  };
  ?>


