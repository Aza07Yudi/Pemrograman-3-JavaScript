@include ('navuser')
<div class="card p-0 mt-3 shadow-box-soft">
        <div class="card-head p-2 mt-3">
            <h2 class="text-center">Data Topup Saya</h2>
        </div>
        <div class="card-body p-4">
        <div class="row p-3">
        <table class="table table-striped table-responsive-md">
            <thead style="background-color:#f89646; color:white;">
                <tr>
                    <th colspan="4"><h3 id="saldoAkhir">Loading...</h3></th>
                </tr>
            </thead>
            <thead style="background-color:#f89646; color:white;">
                <tr>
                <th scope="col">ID Topup</th>
                <th scope="col">Nominal</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="topupTable"></tbody>
        </table>
        </div>
        </div>
    </div>
</div>
<script>
        async function loadTopupData() {
            const token = localStorage.getItem("token"); 
            
            
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
                pelangganId = profileData.id; // Ambil ID pelanggan dari respons
            } catch (error) {
                console.error("Error memuat profil pelanggan:", error);
                alert("Gagal memuat profil. Silakan coba lagi.");
                return;
            }

           
            const topupEndpoint = `https://backendinfinitywater.hayyalmusafir.com/api/showsaldo/${pelangganId}`;
            try {
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

                const topupData = await topupResponse.json();

             
                const tableBody = document.getElementById("topupTable");
                tableBody.innerHTML = ""; 

                topupData.saldopelanggan.forEach((topup) => {
                    const row = `
                        <tr>
                            <td>${topup.id}</td>
                            <td>Rp. ${parseInt(topup.nominal).toLocaleString('id-ID')}</td>
                            <td>${topup.status}</td>
                            <td><a href="/updatestatus?id=${topup.id}" class="btn btn-primary">Update</a></td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML("beforeend", row);
                });
            } catch (error) {
                console.error("Error memuat data top-up:", error);
                alert("Gagal memuat data top-up. Silakan coba lagi.");
            }

            const saldoEndpoint = `https://backendinfinitywater.hayyalmusafir.com/api/showsaldoakhir/${pelangganId}`;
            try {
            const saldoResponse = await fetch(saldoEndpoint, {
                method: "GET",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            });

            if (!saldoResponse.ok) {
                throw new Error("Gagal memuat saldo akhir.");
            }

            const saldoData = await saldoResponse.json();

            const saldoAkhir = saldoData.saldoakhir[0]?.nominalakhir;

            if (saldoAkhir) {
                document.getElementById("saldoAkhir").innerText = `Saldo Saya: Rp ${parseInt(saldoAkhir).toLocaleString('id-ID')}`;
            } else {
                document.getElementById("saldoAkhir").innerText = "Saldo tidak tersedia.";
            }
        } catch (error) {
            console.error("Error memuat saldo akhir:", error);
            document.getElementById("saldoAkhir").innerText = "Gagal memuat saldo.";
        }
        }

        loadTopupData();
</script>
@include ('footuser')