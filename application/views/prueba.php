<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="POST" action=<?= base_url('tickets_AT/prueba_post') ?> enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit">
    </form>
  </body>
</html>
