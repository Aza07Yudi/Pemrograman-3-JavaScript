@include ('navadmin')
<script>
    async function ambilProduk() {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get("id");
        const token = localStorage.getItem("token");

        if (!productId) {
            console.error("ID produk tidak ditemukan di URL");
            return;
        }

        const response = await fetch(
            `https://backendinfinitywater.hayyalmusafir.com/api/showproduk`,
            {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`, 
                },
            }
        );

        if (!response.ok) {
            console.error("Gagal mengambil data produk");
            return;
        }

        const result = await response.json();
        console.log("Respons Produk:", result);

       
        const produk = result.produk.find(item => item.id == productId);

        if (!produk) {
            console.error("Produk tidak ditemukan dengan ID:", productId);
            return;
        }

        document.getElementById("produkid").value = produk.id;
        document.getElementById("namaproduk").value = produk.namaproduk;
        document.getElementById("harga").value = produk.harga;
    }

    window.onload = ambilProduk;
</script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col">
                <div class="card">
                  <div class="header">
                    <h4 class="title">Edit Produk</h4>
                  </div>
                  <div class="content">
                    <form id="editprodukForm" onsubmit="editproduct(event)">
                      <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" id="produkid">
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
                            <input type="number" class="form-control" id="harga">
                          </div>
                        </div>
                      </div>

                      <button
                        type="submit"
                        class="btn btn-primary btn-fill pull-right"
                      >
                        Edit
                      </button>
                      <button type="reset" class="btn btn-danger btn-fill">Batal</button>
                      <div class="clearfix"></div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
<script>
    async function editproduct(event){
        event.preventDefault();
        const produkid = document.getElementById("produkid").value;
        const token = localStorage.getItem("token");
        const kontenproduk = {
            namaproduk : document.getElementById("namaproduk").value,
            harga :document.getElementById("harga").value,
        };

        const response = await fetch(
            `https://backendinfinitywater.hayyalmusafir.com/api/editproduk/${produkid}`,{
                method : "POST",
                headers : {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`, 
                },
                body : JSON.stringify(kontenproduk),
            }
        );

        if(response.ok){
            Swal.fire ({
                title : `Product dengan ID ${produkid} diupdate!`,
                icon : "success",
                confirmButtonText : "OK",
                allowOutsideClick: false,
            }).then(()=>{
                window.location.href = "{{route('produkadmin')}}";
            })
        }
        else {
            alert("Produk gagal diupdate!");
        }
    }
</script>
@include ('footadmin')