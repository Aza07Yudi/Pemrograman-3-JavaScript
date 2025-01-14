@include ('navadmin')
<div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-4">
                <div class="card card-user">
                  <div class="image">
                    <img
                      src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400"
                      alt="foto-admin"
                    />
                  </div>
                  <div class="content">
                    <div class="author">
                      <a href="{{route('profiladmin')}}">
                        <img
                          class="avatar border-gray"
                          src="{{asset('assets/auth/img/face-2.jpg')}}"
                          alt="foto-admin"
                        />

                        <h4 class="title">
                         <span>&#64;</span><span id="an_display"></span>
                         <br/>
                         <small>Quote :</small>
                        </h4>
                      </a>
                    </div>
                    <p class="description text-center">
                      "Akhir akan tiba, <br />
                      Jangan sia-siakan hidup mu, <br />
                      Agar pergi dengan makna"
                    </p>
                  </div>
                  <hr />
                  <div class="text-center">
                    <button href="#" class="btn btn-simple">
                      <i class="fa fa-facebook-square"></i>
                    </button>
                    <button href="#" class="btn btn-simple">
                      <i class="fa fa-twitter"></i>
                    </button>
                    <button href="#" class="btn btn-simple">
                      <i class="fa fa-google-plus-square"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card">
                  <div class="header">
                    <h4 class="title">Profil Admin</h4>
                  </div>
                  <div class="content">
                    <form>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" id="id" disabled />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Username</label>
                            <input
                              type="text"
                              class="form-control"
                              id="username"
                              disabled
                            />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="name" disabled />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Email</label>
                            <input
                              type="email"
                              class="form-control"
                              id="email"
                              disabled
                            />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" id="role" disabled />
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <input
                              type="text"
                              class="form-control"
                              id="status"
                              disabled
                            />
                          </div>
                        </div>
                      </div>

                      <button
                        type=""
                        class="btn btn-primary btn-fill pull-right"
                      >
                        Edit
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
            roleElement.value = data.role === 2 ? 'Pelanggan' : 'Admin';
        } catch (error){
            console.error('Kesalahan Terjadi!', error.message);
        }

    }

    document.addEventListener('DOMContentLoaded', panggilData);
</script>
@include ('footadmin')