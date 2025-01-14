@include('navadmin')
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Data Akun Pelanggan Infinity Water</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>Username</th>
                                    	<th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody id="tampil-user"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  const endpoint = "https://backendinfinitywater.hayyalmusafir.com/api/showallpelanggan";
  const token = localStorage.getItem("token"); 

 
  if (!token) {
    alert("Anda harus login terlebih dahulu.");
    window.location.href = "{{route('login')}}"; 
    return;
  }

 
  fetch(endpoint, {
    method: "GET",
    headers: {
      "Authorization": `Bearer ${token}`,
      "Content-Type": "application/json",
    },
  })
    .then(response => response.json()) 
    .then(data => {
      const tampilPel = document.getElementById("tampil-user");

      if (data && Array.isArray(data.pelanggan)) {
        tampilPel.innerHTML = "";

        data.pelanggan.forEach(pelanggan => {
            const teksstatus = pelanggan.status !== 1 ? "Aktif" : "Tidak Aktif";
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${pelanggan.id}</td>
            <td>${pelanggan.username}</td>
            <td>${pelanggan.name}</td>
            <td>${pelanggan.email}</td>
            <td>${teksstatus}</td>
          `;
          tampilPel.appendChild(row);
        });
      } else {
        tampilPel.innerHTML = `<tr><td colspan="5">Tidak ada pelanggan ditemukan.</td></tr>`;
      }
    })
    .catch(error => {
      console.error("Terjadi kesalahan saat mengambil data pelanggan:", error);
      const tampilPel = document.getElementById("tampil-user");
      tampilPel.innerHTML = `<tr><td colspan="5">Gagal mengambil data pelanggan.</td></tr>`;
    });
});

</script>
@include('footadmin')