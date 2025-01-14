@include ('navadmin')
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col">
                <div class="card">
                  <div class="header">
                    <h4 class="title">Tambahkan Produk</h4>
                  </div>
                  <div class="content">
                    <form id="addproduk">
                      <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input
                                type="text"
                                class="form-control"
                                id="namaproduk"
                                />
                            </div>
                            </div>
                        </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control" id="harga" />
                          </div>
                        </div>
                      </div>

                      <button
                        type="submit"
                        class="btn btn-primary btn-fill pull-right"
                      >
                        Tambah
                      </button>
                      <div class="clearfix"></div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
<script>
  document.getElementById("addproduk").addEventListener("submit", async function (event) {
    event.preventDefault();

    
    const namaproduk = document.getElementById("namaproduk").value;
    const harga = document.getElementById("harga").value;


    const endpoint = "https://backendinfinitywater.hayyalmusafir.com/api/addproduk";

    
    const token = localStorage.getItem("token");

    if (!namaproduk || !harga) {
      alert("Nama produk dan harga harus diisi!");
      return;
    }

    // Kirim data ke server
    fetch(endpoint, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${token}`, 
      },
      body: JSON.stringify({
        namaproduk: namaproduk,
        harga: harga,
      }),
    })
      .then(response => {
        if (!response.ok) {
          throw new Error("Gagal menambahkan produk. Periksa kembali input Anda.");
        }
        return response.json();
      })
      .then(data => {
        
        console.log("Produk berhasil ditambahkan:", data);
        Swal.fire({
              title: "Berhasil Tambah Produk!",
              icon: "success",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            }).then(() => {
              window.location.href = "{{route('produkadmin')}}";
            });
      })
      .catch(error => {
       
        console.error("Error:", error);
        alert("Terjadi kesalahan: " + error.message);
      });
  });
</script>

@include ('footadmin')