@include ('navuser')
<div class="container mt-5">
        <div class="card shadow-sm">
          <div class="card-header text-white" style="background-color: #f89646">
            <h4 class="mb-0 text-center"><i class="fa fa-user"></i> Profil Pengguna</h4>
          </div>
          <div class="card-body">
            <form id="form-profile">
              <div class="row">
                <div class="col-12 mb-5">
                  <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-center">
                      <img src="{{asset('assets/auth/img/client.jpg')}}" alt="profile-image" style="height: 200px; width: 200px; border-radius: 100%;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="mb-3">
                    <label for="text" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" disabled />
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="text" class="form-label">Username</label>
                    <input
                      type="text"
                      class="form-control"
                      id="username"
                      disabled
                    />
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="text" class="form-label">Nama</label>
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      disabled
                    />
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      disabled
                    />
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="text" class="form-label">Role</label>
                    <input
                      type="text"
                      class="form-control"
                      id="role"
                      disabled
                    />
                  </div>
                </div>
                <div class="col-6">
                  <div class="mb-3">
                    <label for="text" class="form-label">Status</label>
                    <input
                      type="email"
                      class="form-control"
                      id="status"
                      disabled
                    />
                  </div>
                </div>
              </div>
            </form>
          </div>

              <div class="text-end d-flex align-items-center justify-content-center">
                <button
                  type="button"
                  class="btn btn-light text-white mb-5"
                  id="saveProfile"
                  style="background-color: #f89646"
                >
                  Edit
                </button>
              </div>
            </form>
          </div>
</div>
</div>
<script>
    async function panggilData() {
        const token =localStorage.getItem('token');
        if(!token){
            Swal.fire({
              title: "Token Tidak Ditemukan!",
              text: "Ada Kesalahan Terjadi",
              icon: "error",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            });
        }

        try {
            const response = await fetch ('https://backendinfinitywater.hayyalmusafir.com/api/auth/me',{
                method: 'POST', headers: {
                    'Content-Type' : 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if(!response.ok){
                throw new Error ('Profil Gagat Dimuat!');
            }

            const data = await response.json();

            document.getElementById('id').value = data.id || 'ERROR';
            document.getElementById('username').value = data.username || 'ERROR';
            document.getElementById('name').value = data.name || 'ERROR';
            document.getElementById('email').value = data.email || 'ERROR';
            const statusElement = document.getElementById('status');
            statusElement.value = data.status === "1" ? 'Aktif' : 'Tidak Aktif';

            const roleElement = document.getElementById('role');
            roleElement.value = data.role === 1 ? 'Admin' : 'Pelanggan';
        } catch (error){
            console.error('Kesalahan Terjadi!', error.message);
        }

    }

    document.addEventListener('DOMContentLoaded', panggilData);
</script>
@include ('footuser')