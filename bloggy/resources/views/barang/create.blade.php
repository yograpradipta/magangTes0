<html>

<head>
  <meta charset="utf-8">
  <title> tambah barang</title>
</head>
<body>
  <form method="post" action="{{url('barang')}}" enctype="multipart/form-data">
  <table>
    <tr>
      <td>nama barang</td>
      <td><input type="text" name="nama"></td>
    </tr>
    <tr>
      <td>jumlah</td>
      <td><input type="text" name="jumlah"></td>
    </tr>
    <tr>
      <td></td>
      <td><button type="submit">submit</button></td>
    </tr>
  </table>
</form>
</body>

</html>
