@include('navuser')
    <div class="card p-0 mt-3 shadow-box-soft">
        <div class="card-head p-2 mt-3">
            <h2 class="text-center">Produk di Infinity Water</h2>
            <br>
            <h5 class="text-center">Kami menawarkan beberapa produk yang 
                sangat berkualitas buat Anda! <br/>
                Yang mana pastinya juga sehat.
            </h5>
        </div>
        <div class="card-body p-4">
        <div class="row p-3">
        <table class="table table-striped table-responsive-md">
            <thead style="background-color:#f89646; color:white;">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Harga</th>
                </tr>
            </thead>
            <tbody id="tampil-produk"></tbody>
        </table>
        </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  const endpoint = "https://backendinfinitywater.hayyalmusafir.com/api/showproduk";
  const token = localStorage.getItem("token"); 

  // Pastikan token tersedia
  if (!token) {
    alert("Anda harus login terlebih dahulu.");
    window.location.href = "{{route('login')}}"; 
    return;
  }

  // Fetch data dari endpoint
  fetch(endpoint, {
    method: "GET",
    headers: {
      "Authorization": `Bearer ${token}`,
      "Content-Type": "application/json",
    },
  })
    .then(response => response.json()) 
    .then(data => {
      const tampilProduk = document.getElementById("tampil-produk");

      if (data && Array.isArray(data.produk)) {
        tampilProduk.innerHTML = "";

        data.produk.forEach(produk => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${produk.id}</td>
            <td>${produk.namaproduk}</td>
            <td>Rp. ${parseInt(produk.harga).toLocaleString('id-ID')}</td>
          `;
          tampilProduk.appendChild(row);
        });
      } else {
        tampilProduk.innerHTML = `<tr><td colspan="3">Tidak ada produk ditemukan.</td></tr>`;
      }
    })
    .catch(error => {
      console.error("Terjadi kesalahan saat mengambil data produk:", error);
      const tampilProduk = document.getElementById("tampil-produk");
      tampilProduk.innerHTML = `<tr><td colspan="3">Gagal mengambil data produk.</td></tr>`;
    });
});

</script>
@include('footuser')