<!doctype html>
<html lang="en">
    <head>
        <title>Login | Infinity Water</title>
       
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />
        <link rel="icon" type="image/png" href="{{asset('assets/auth/img/favicon.ico')}}" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="{{asset('assets/auth/css/style.css')}}">
        
    </head>
    <body>

    <div
      class="container d-flex justify-content-center align-items-center min-vh-100"
    >
      
      <div class="row border rounded-5 p-3 bg-white shadow box-area">
        
        <div
          class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
          style="background:rgb(29, 74, 207);"
        >
          <div class="featured-image mb-3">
            <img src="{{asset('assets/auth/img/wo.png')}}" class="img-fluid" style="width: 250px" />
          </div>
          <p
            class="text-white fs-2"
            style="
              font-family: 'Courier New', Courier, monospace;
              font-weight: 600; text-align:center;
            "
          >
            Infinity Water
          </p>
          <small
            class="text-white text-wrap text-center"
            style="width: 17rem; font-family: 'Courier New', Courier, monospace"
            >Join experienced Designers on this platform.</small
          >
        </div>
        

        <div class="col-md-6 right-box">
          <div class="row align-items-center">
            <div class="header-text mb-4">
              <h2>Yuk, login dulu!</h2>
              <p>Silahkan isi data dibawah ini.</p>
            </div>

            <form action="" id="loginSite">
                <div class="input-group mb-3">
                <input
                    id="username"
                    type="text"
                    class="form-control form-control-lg bg-light fs-6"
                    placeholder="Username"
                />
                </div>
                <div class="input-group mb-1">
                <input
                    id="password"
                    type="password"
                    class="form-control form-control-lg bg-light fs-6"
                    placeholder="Password"
                />
                </div>
                <div class="input-group mb-5 d-flex justify-content-between">
                <div class="form-check">
                    <input
                    type="checkbox"
                    class="form-check-input"
                    id="formCheck"
                    />
                    <label for="formCheck" class="form-check-label text-secondary"
                    ><small>Remember Me</small></label
                    >
                </div>
                <div class="forgot">
                    <small><a href="#">Forgot Password?</a></small>
                </div>
                </div>
                <div class="input-group mb-3">
                <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                </div>
            </form>
            
            <div class="row">
              <small>Don't have account? <a href="#">Sign Up</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
      
                <script
                    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                    crossorigin="anonymous"
                ></script>

                <script
                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
                    crossorigin="anonymous"
                ></script>
    </body>
    <script>
      document
        .getElementById("loginSite")
        .addEventListener("submit", function (event) {
          event.preventDefault();

          const username = document.getElementById("username").value;
          const password = document.getElementById("password").value;

          const xhr = new XMLHttpRequest();

          const url = "https://backendinfinitywater.hayyalmusafir.com/api/auth/login";

          xhr.open("POST", url, true);
          xhr.setRequestHeader(
            "Content-Type",
            "application/x-www-form-urlencoded"
          );

          const data = `username=${encodeURIComponent(
            username
          )}&password=${encodeURIComponent(password)}`;
          xhr.send(data);
          xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
              const response = JSON.parse(xhr.responseText);
              const token = response.access_token; //TODO: Ambil Token

              localStorage.setItem("token", token);
              const expiryTime = new Date().getTime() + 120 * 60 * 1000;
              localStorage.setItem("tokenExpiry", expiryTime);
              localStorage.setItem("isloggedin", "true");
              localStorage.setItem("username", username);
              localStorage.setItem("countRefresh", "0");

            ambilRole(token);
            } else {
              Swal.fire({
                title: "Gagal Sign In!",
                text: "Username atau Password Salah :(",
                icon: "error",
              });
            }
          };
        });

        function ambilRole(token){
          const xhr = new XMLHttpRequest();
          const url = "https://backendinfinitywater.hayyalmusafir.com/api/auth/me";

          xhr.open("POST", url, true);
          xhr.setRequestHeader("Authorization", "Bearer " + token);
          xhr.onload = function () {
              if(xhr.status >= 200 && xhr.status < 300){
                const userData = JSON.parse(xhr.responseText);
                const userRole = userData.role; //TODO: Ambil Role

                if(userRole === "1"){
                  
                  localStorage.setItem("role", userRole);
                  window.location.href = "{{route('dashboard')}}";
                }

                else if(userRole === "2"){
                  
                  localStorage.setItem("role", userRole);
                  window.location.href = "{{route('index')}}";
                }

                else{
                  Swal.fire({
                  title: "Role Tidak Dikenali",
                  text: "Silahkan coba lagi!",
                  icon: "error",
                    });
                }
              }
              else {
                Swal.fire({
                title: "Gagal Mengambil Data Role",
                text: "Silakan coba lagi!",
                icon: "error",
                  });
              }
          }
          xhr.send();
        }
    </script>
</html>
