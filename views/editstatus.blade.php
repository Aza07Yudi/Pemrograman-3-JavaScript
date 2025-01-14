@include('navadmin')
<script>
    async function fetchData() {
    const token = localStorage.getItem("token"); 
    const urlParams = new URLSearchParams(window.location.search);
    const idTopup = urlParams.get("id"); 

   
    if (!idTopup) {
        alert("ID top-up tidak ditemukan.");
        return;
    }

    const endpoint1 = "https://backendinfinitywater.hayyalmusafir.com/api/showsaldo/10"; 
    const endpoint2 = "https://backendinfinitywater.hayyalmusafir.com/api/showsaldo/14"; 

    try {
        // Fetch data dari kedua endpoint
        const response1 = await fetch(endpoint1, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json",
            },
        });
        const response2 = await fetch(endpoint2, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json",
            },
        });

       
        if (!response1.ok || !response2.ok) {
            alert("Gagal memuat data top-up.");
            return;
        }

       
        const data1 = await response1.json();
        const data2 = await response2.json();

       
        const combinedTopups = [...data1.saldopelanggan, ...data2.saldopelanggan];

       
        const topup = combinedTopups.find(topup => topup.id == idTopup);

        if (topup) {
          
            document.getElementById("id").value = topup.id;
            document.getElementById("user").value = topup.user;
            document.getElementById("nominal").value = topup.nominal;

           
            const statusSelect = document.getElementById("status");
            const statusOptions = [
                
                "Berhasil",
                "Ditolak"
            ];

            statusSelect.innerHTML = statusOptions.map(status => {
                return `<option value="${status}" ${status === topup.status ? 'selected' : ''}>${status}</option>`;
            }).join('');

            const updateButton = document.querySelector("form #updateButton");
                    if (
                        topup.status == "Menunggu Transfer" ||
                        topup.status === "Berhasil" ||
                        topup.status === "Ditolak"
                    ) {
                        updateButton.disabled = true;
                    } else {
                        updateButton.disabled = false;
                    }
        } else {
            alert("Data top-up tidak ditemukan.");
        }
    } catch (error) {
        console.error("Terjadi kesalahan saat mengambil data top-up:", error);
        alert("Gagal memuat data top-up.");
    }
}


fetchData();

</script>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col">
                <div class="card">
                  <div class="header">
                    <h4 class="title">Edit Status</h4>
                  </div>
                  <div class="content">
                    <form id="editstatus" onsubmit="updateStatus(event)">
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>ID Topup</label>
                            <input type="text" class="form-control" id="id" disabled>
                          </div>
                        </div>
                      </div>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>User</label>
                            <input type="text" class="form-control" id="user" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Nominal</label>
                            <input type="number" class="form-control" id="nominal" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <option value="Menunggu Transfer">Menunggu Transfer</option>
                                <option value="Sudah Transfer/Menunggu Konfirmasi Admin">Sudah Transfer/Menunggu Konfirmasi Admin</option>
                                <option value="Berhasil">Berhasil</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <button
                      id="updateButton"
                        type="submit"
                        class="btn btn-primary btn-fill pull-right"
                      >
                        Update
                      </button>
                      <a href="/topupadmin" class="btn btn-danger btn-fill">Batal</a>
                      <div class="clearfix"></div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
<script>
    async function updateStatus(event) {
        event.preventDefault(); 
        const token = localStorage.getItem("token");
        const idTopup = document.getElementById("id").value;
        const pelanggan = document.getElementById("user").value; 
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

        
        const bodyData = {
            pelanggan: pelanggan,
            status: statusNumber,
        };

        const endpoint = `https://backendinfinitywater.hayyalmusafir.com/api/statustransferbyadmin/${idTopup}`;

      try {
         
          const response = await fetch(endpoint, {
              method: "POST",
              headers: {
                  "Authorization": `Bearer ${token}`,
                  "Content-Type": "application/json",
              },
              body: JSON.stringify(bodyData), 
          });

          if (!response.ok) {
              const errorDetails = await response.json();
              console.error("Error details:", errorDetails);
              alert(`Gagal mengubah status: ${errorDetails.message || 'Unknown error'}`);
              return;
          }

          
          Swal.fire({
              title : `Status di update!`,
              icon : "success",
              confirmButtonText : "OK",
              allowOutsideClick: false,
          }).then(()=>{
              window.location.href = "/topupadmin"; 
          })

      } catch (error) {
          console.error("Terjadi kesalahan:", error);
          alert("Gagal mengupdate status. Silakan coba lagi.");
      }

    }

    
</script>
@include('footadmin')