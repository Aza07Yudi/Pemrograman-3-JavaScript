@include('navadmin')
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Data Topup Pelanggan</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                    	<th>User</th>
                                    	<th>Nominal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody id="tabel-topup"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>
<script>
    const token = localStorage.getItem("token"); // Pastikan token tersimpan di localStorage

async function fetchTopUpData() {
    const endpoint1 = "https://backendinfinitywater.hayyalmusafir.com/api/showsaldo/10"; // Endpoint 1
    const endpoint2 = "https://backendinfinitywater.hayyalmusafir.com/api/showsaldo/14"; // Endpoint 2
    
    try {
        // Mengambil data dari kedua endpoint secara paralel
        const [response1, response2] = await Promise.all([
            fetch(endpoint1, {
                method: "GET",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            }),
            fetch(endpoint2, {
                method: "GET",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json",
                },
            })
        ]);

        // Mengecek jika salah satu response gagal
        if (!response1.ok || !response2.ok) {
            alert("Gagal memuat data top-up pelanggan.");
            return;
        }

        // Mengonversi response ke JSON
        const data1 = await response1.json();
        const data2 = await response2.json();

        // Menggabungkan kedua array data
        const allTopUps = [...data1.saldopelanggan, ...data2.saldopelanggan];

        renderTopUpTable(allTopUps); // Menampilkan semua data top-up dalam satu tabel
    } catch (error) {
        console.error("Terjadi kesalahan:", error);
    }
}

// Fungsi untuk menampilkan data dalam tabel
function renderTopUpTable(saldopelanggan) {
    const tabelTopup = document.getElementById("tabel-topup");
    tabelTopup.innerHTML = ""; // Kosongkan tabel sebelumnya

    if (saldopelanggan.length === 0) {
        tabelTopup.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada data top-up tersedia.</td></tr>`;
        return;
    }

    saldopelanggan.forEach((topup) => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${topup.id}</td>
            <td>${topup.user}</td>
            <td>Rp. ${parseInt(topup.nominal).toLocaleString()}</td>
            <td>${topup.status}</td>
            <td><a href="/editstatus?id=${topup.id}" class="btn btn-primary">Update</a></td>
        `;

        tabelTopup.appendChild(row);
    });
}

// Memanggil fungsi fetchTopUpData saat halaman dimuat
document.addEventListener("DOMContentLoaded", fetchTopUpData);

</script>





@include('footadmin')