@include('navadmin')
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Produk Infinity Water</h4>
                                <p class="category">Berikut adalah produk-produk Infinity Water</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Nama Produk</th>
                                    	<th>Harga</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody id="tampil-produk"></tbody>
                                </table>
                            </div>
                        </div>
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
            <td>
                <div class="d-inline">
                    <a href="/editproduk?id=${produk.id}" class="btn btn-primary mr-2">Edit</a>
                            <form onsubmit="hapusproduk(event)" style="display: inline;">
                                <input type="hidden" value="${produk.id}">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                </div>
            </td>
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

<!--FIXME: Hapus Produk-->
<script>
    async function hapusproduk(event) {
    event.preventDefault();  

   
    const productId = event.target.querySelector("input").value;
    const token = localStorage.getItem("token"); 

    if (!productId) {
        console.error("ID produk tidak ditemukan.");
        return;
    }


    if (!confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
        return;
    }

    console.log("Menghapus produk dengan ID:", productId);

    try {
      
        const response = await fetch(
            `https://backendinfinitywater.hayyalmusafir.com/api/deleteproduk/${productId}`,
            {
                method: "GET",  
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`,  
                },
            }
        );

        if (!response.ok) {
            throw new Error("Gagal menghapus produk");
        }

        const result = await response.json();
        console.log("Produk berhasil dihapus:", result);

        Swal.fire({
            title : "Produk Berhasil di Hapus!",
            icon : "success",
            confirmButtonText: "OK",
            allowOutsideClick: false,
        })

        // Menghapus baris produk dari tabel tanpa reload halaman
        const row = event.target.closest("tr");
        row.remove();
    } catch (error) {
        console.error("Terjadi kesalahan saat menghapus produk:", error);
        alert("Terjadi kesalahan saat menghapus produk");
    }
}

</script>
@include('footadmin')