@include('navuser')
<script>
    
</script>
<div class="container mt-5">
        <div class="card shadow-sm">
          <div class="card-header text-white" style="background-color: #f89646">
            <h4 class="mb-0 text-center">Top Up Saldo</h4>
          </div>
          <div class="card-body">
            <form id="topupSaldo" onsubmit="tambahSaldo(event)">
              <div class="row">
                <div class="col-12">
                </div>
                <div class="col-12">
                  <div class="mb-3">
                    <label for="text" class="form-label">Nominal</label>
                    <input
                      type="number"
                      class="form-control"
                      id="nominal"
                    />
                  </div>
                </div>
              </div>
              <div class="text-end d-flex align-items-center justify-content-center">
                <button
                  type="submit"
                  class="btn btn-light text-white mb-5"
                  style="background-color: #f89646"
                  required
                >
                  Topup
                </button>
              </div>
            </form>
          </div>

              
        </form>
          </div>
</div>
</div>
<script>
    async function tambahSaldo(event){
        event.preventDefault();

        const token = localStorage.getItem("token");
        const urlParams = new URLSearchParams(window.location.search);
        const idTopup = urlParams.get("id"); 

            if (!token) {
            alert("Anda harus login terlebih dahulu!");
            return;
            }
            
            const profileEndpoint = "https://backendinfinitywater.hayyalmusafir.com/api/auth/me";
            let pelangganId;

            try {
                const profileResponse =  await fetch(profileEndpoint, {
                    method: "POST",
                    headers: {
                        "Authorization": `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                });

                if (!profileResponse.ok) {
                    throw new Error("Gagal memuat data profil pelanggan.");
                }

                const profileData = await profileResponse.json();
                pelangganId = profileData.id; 
            } catch (error) {
                console.error("Error memuat profil pelanggan:", error);
                alert("Gagal memuat profil. Silakan coba lagi.");
                return;
            }

        const nominal = document.getElementById("nominal").value;
        const endpointSaldo = `https://backendinfinitywater.hayyalmusafir.com/api/addsaldo/${pelangganId}`;

        const bodySaldo = {
            nominal: nominal,
        };

        try {
            const responseSaldo = await fetch(endpointSaldo, {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(bodySaldo),
            });

            if (!responseSaldo.ok) {
                const errorDetails = await responseSaldo.json();
                console.error("Error details (Saldo):", errorDetails);
                Swal.fire({
                    title: "Isi Nominal Saldo yang di Inginkan!",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                });
                return;
            }

            console.log("Saldo berhasil ditambahkan.");
            Swal.fire({
                title: "Berhasil Request Topup!",
                text : "Segera selesaikan Transfer ya :)",
                icon: "success",
                confirmButtonText: "OK",
                allowOutsideClick: false,
            }).then(()=>{
                window.location.href = "/topupuser";
            })
           
        } catch (error) {
            console.error("Terjadi kesalahan saat menambahkan saldo:", error);
            alert("Gagal menambahkan saldo pelanggan.");
        }
    }

</script>
@include('footuser')