<?php
include("konek.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
  .debut{
    background: rgb(221, 160, 221);
    color:white;
  }

  .debut:hover{
    background: rgb(200, 160, 221);
    box-shadow: 0px 0px 7px rgb(173, 216, 230);
    transition: ease 0.3s;
  }
</style>
<body>
    <br/>

    <div class="container mt-5">
      <div class="row gy-4 gx-5 justify-content-center">
        <div class="col-md-8">
          <form method="GET" action="">
            <div class="input-group mb-3">
              <input class="form-control" 
              type="text" 
              placeholder="Cari Pesanan"  
              name="order" 
              value="<?php if(isset($_GET['order'])){
                echo $_GET['order'];
              } ?>"
              />
              <button class="btn debut" type="submit">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <br/>
  <div class="card p-5">
    <div class="card-title">
      <h4 class="text-center">Data Pesanan</h4>
    </div>
    <div class="card-body p-5">
    <table class="table table-bordered text-center">
      <tr>
        <th>Nama</th>
        <th>Nomor HP</th>
        <th>Kelas</th>
        <th>Durasi [Hari]</th>
        <th>Total</th>
      </tr>
      <?php
        if(isset($_GET['order'])){

          $cari_value = $_GET['order'];
          $cari_data = "SELECT * FROM tb_book WHERE CONCAT(id,nam,email,hp_user,class,har,tanggal,hari) LIKE '%$cari_value%'";
          $cari_data_run = mysqli_query($kon, $cari_data);
          if(mysqli_num_rows($cari_data_run) > 0){
            foreach($cari_data_run as $row){
      ?>
      <tr>
        <td><?php echo $row['nam']; ?></td>
        <td><?php echo $row['hp_user']; ?></td>
        <td><?php echo $row['class']; ?></td>
        <td><?php echo $row['hari']; ?></td>
        <td><?php echo $row['har']; ?></td>
      </tr>
      <?php
            }
          }

          else {
            $kata = "Data tidak ditemukan";
            echo '<tr><td colspan="5"><h4>'.$kata.'</h4></td></tr>';
          }
        }
      ?>
  </table>
    </div>
  </div>
</body>
</html>