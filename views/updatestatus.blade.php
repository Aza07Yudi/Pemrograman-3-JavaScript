@include ('navuser')
<script>
    async function ambilTop(){
        const token = localStorage.getItem("token");
        const urlParams = new URLSearchParams(window.location.search);
        const idTopup = urlParams.get("id"); 
            
            
            const profileEndpoint = "https://backendinfinitywater.hayyalmusafir.com/api/auth/me";
            let pelangganId;

            try {
                const profileResponse = await fetch(profileEndpoint, {
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

            const topupEndpoint = `https://backendinfinitywater.hayyalmusafir.com/api/showsaldo/${pelangganId}`;
            try{
                const topupResponse = await fetch(topupEndpoint, {
                    method: "GET",
                    headers: {
                        "Authorization": `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                });

                if (!topupResponse.ok) {
                    throw new Error("Gagal memuat data top-up.");
                }

                const dat = await topupResponse.json();

                const topup = dat.saldopelanggan.find(topup => topup.id ==idTopup);

                if (topup){
                    document.getElementById("id").value = topup.id;
                    document.getElementById("nominal").value = topup.nominal;

                    const statusSelect = document.getElementById("status");
                    const statusOptions = [
                        "Sudah Transfer/Menunggu Konfirmasi Admin",
                    ];

                    statusSelect.innerHTML = statusOptions.map(status => {
                    return `<option value="${status}" ${status === topup.status ? 'selected' : ''}>${status}</option>`;
                    }).join('');
                    
                    const updateButton = document.querySelector("form #updateButton");
                    if (
                        topup.status === "Sudah Transfer/Menunggu Konfirmasi Admin" ||
                        topup.status === "Berhasil" ||
                        topup.status === "Ditolak"
                    ) {
                        updateButton.disabled = true;
                    } else {
                        updateButton.disabled = false;
                    }
                }
                else {
                    alert("Data top-up tidak ditemukan.");
                }
            }
            catch (error) {
                console.error("Terjadi kesalahan saat mengambil data top-up:", error);
                alert("Gagal memuat data top-up.");
            }

            
            
    }

    ambilTop();
</script>


<div class="container mt-5">
        <div class="card shadow-sm">
          <div class="card-header text-white" style="background-color: #f89646">
            <h4 class="mb-0 text-center">Update Status</h4>
          </div>
          <div class="card-body">
            <form id="updatestatus" onsubmit="updateStatus(event)">
              <div class="row">
                <div class="col-12">
                  <div class="mb-3">
                    <label for="text" class="form-label">ID Topup</label>
                    <input type="text" class="form-control" id="id" disabled />
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-3">
                    <label for="text" class="form-label">Nominal</label>
                    <input
                      type="number"
                      class="form-control"
                      id="nominal"
                      disabled
                    />
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-3">
                    <label for="text" class="form-label">Status</label>
                    <select id="status" class="form-control">
                                <option value="Menunggu Transfer">Menunggu Transfer</option>
                                <option value="Sudah Transfer/Menunggu Konfirmasi Admin">Sudah Transfer/Menunggu Konfirmasi Admin</option>
                                <option value="Berhasil">Berhasil</option>
                                <option value="Ditolak">Ditolak</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="text-end d-flex align-items-center justify-content-center">
                <button
                    id="updateButton"
                  type="submit"
                  class="btn btn-light text-white mb-5"
                  style="background-color: #f89646"
                >
                  Update
                </button>
              </div>
            </form>
          </div>

              
            </form>
          </div>
</div>
</div>
<script>
    async function updateStatus(event) {
        event.preventDefault();

        const token = localStorage.getItem("token");
        const idTopup = document.getElementById("id").value;
        const statusText = document.getElementById("status").value;

       
        let statusNumber;
        switch (statusText) {
            case "Menunggu Transfer":
                statusNumber = "1";
                break;
            case "Sudah Transfer/Menunggu Konfirmasi Admin":
                statusNumber = "2";
                break;
            case "Berhasil":
                statusNumber = "3";
                break;
            case "Ditolak":
                statusNumber = "4";
                break;
            default:
                alert("Status tidak valid.");
                return;
        }

      
        const endpoint = `https://backendinfinitywater.hayyalmusafir.com/api/statustransfer/${idTopup}?status=${statusNumber}`;

        try {
            console.log("Mengirim permintaan ke API:", endpoint); // Debug endpoint
            const response = await fetch(endpoint, {
                method: "GET", // Gunakan metode sesuai API
                headers: {
                    "Authorization": `Bearer ${token}`,
                },
            });

            if (!response.ok) {
                let errorDetails = {};
                try {
                    errorDetails = await response.json();
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
                alert(`Gagal mengubah status: ${errorDetails.message || 'Unknown error'}`);
                return;
            }

           
            Swal.fire({
                title: "Status berhasil diupdate!",
                text : "Menunggu Konfirmasi Admin!",
                icon: "success",
                confirmButtonText: "OK",
                allowOutsideClick: false,
            }).then(() => {
                window.location.href = "/topupuser"; 
            });

        } catch (error) {
            console.error("Terjadi kesalahan:", error);
            alert("Gagal mengupdate status. Silakan coba lagi.");
        }

    }

</script>


@include ('footuser')