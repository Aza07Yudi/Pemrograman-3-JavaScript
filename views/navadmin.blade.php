<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{asset('assets/auth/img/favicon.ico')}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Infinity Water | Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      
      if (!localStorage.getItem("isloggedin")|| !localStorage.getItem("token") || localStorage.getItem("role") !== "1") {
        window.location.href = "{{route('login')}}";
      }

      setInterval(function () {
        const expiryTime = parseInt(localStorage.getItem("tokenExpiry"),10);
        const countRefresh = parseInt(localStorage.getItem("countRefresh")||"0",10);
        const currentTime = new Date().getTime();

        if (expiryTime && currentTime > expiryTime) {
          if (countRefresh < 3) {
            refreshToken();
            }

        else{
             loggingout();
            }
              
        }
      }, 1000);

      //TODO: Refresh Token
      function refreshToken(){
        const token =localStorage.getItem("token");
        
        if(!token){
          loggingout();
          return;
        }

        const xhr = new XMLHttpRequest();
        const url = "https://backendinfinitywater.hayyalmusafir.com/api/auth/refresh";
        xhr.open("POST",url,true);
        xhr.setRequestHeader("Authorization", "Bearer " + token);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) {
            const response = JSON.parse(xhr.responseText);
            const newToken = response.access_token;

            
            localStorage.setItem("token", newToken);
            const newExpiryTime = new Date().getTime() + 120 * 60 * 1000;
            localStorage.setItem("tokenExpiry", newExpiryTime);

            
            const countRefresh = parseInt(localStorage.getItem("countRefresh")||"0",10);
            localStorage.setItem("countRefresh", countRefresh + 1);

          } else {
           loggingout();
          }
        };

        xhr.send();
      }
        function loggingout(){
            localStorage.removeItem("token");
            localStorage.removeItem("tokenExpiry");
            localStorage.removeItem("isloggedin");
            localStorage.removeItem("username");
            localStorage.removeItem("countRefresh");
            localStorage.removeItem("role");

            Swal.fire({
              title: "Durasi Login Sudah Habis",
              text: "Silahkan Login Kembali!",
              icon: "info",
              confirmButtonText: "OK",
              allowOutsideClick: false,
            }).then(() => {
              window.location.href = "{{route('login')}}";
            });
    }
  
    </script>
    <meta
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"
      name="viewport"
    />
    <meta name="viewport" content="width=device-width" />

    <link href="{{asset('assets/auth/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/auth/css/animate.min.css')}}" rel="stylesheet" />
    <link
      href="{{asset('assets/auth/css/light-bootstrap-dashboard.css?v=1.4.0')}}"
      rel="stylesheet"
    />
    <link href="{{asset('assets/auth/css/demo.css')}}" rel="stylesheet" />

    <link
      href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="http://fonts.googleapis.com/css?family=Roboto:400,700,300"
      rel="stylesheet"
      type="text/css"
    />
    <link href="{{asset('assets/auth/css/pe-icon-7-stroke.css')}}" rel="stylesheet" />
   
  </head>
  <body>
  <div class="wrapper">
  <div
          class="sidebar"
          data-color="blue"
          data-image="{{asset('assets/auth/img/theside.png')}}"
        >

          <div class="sidebar-wrapper">
            <div class="logo">
              <a href="" class="simple-text">
                Infinity Water
              </a>
            </div>

            <ul class="nav">
              <li class="nav-link">
                <a href="{{route('dashboard')}}">
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-link">
                <a href="{{route('profiladmin')}}">
                  <p>Profil</p>
                </a>
              </li>
              <li class="nav-link">
                <a href="{{route('namauser')}}">
                  <p>List Pelanggan</p>
                </a>
              </li>
              <li class="nav-link">
                <a href="{{route('produkadmin')}}">
                  <p>List Produk</p>
                </a>
              </li>
              <li class="nav-link">
                <a href="{{route('tambahproduk')}}">
                  <p>Tambah Produk</p>
                </a>
              </li>
              <li class="nav-link">
                <a href="{{route('topupadmin')}}">
                  <p>Data Topup</p>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="main-panel">
          <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
              <div class="navbar-header">
                <button
                  type="button"
                  class="navbar-toggle"
                  data-toggle="collapse"
                  data-target="#navigation-example-2"
                >
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Dashboard Admin</a>
              </div>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav navbar-right ml-auto"">
                  <li class="nav-item"> 
                      <a href="{{route('profiladmin')}}" 
                      style="display: flex; align-items: center;">
                          <img src="{{asset('assets/auth/img/face-2.jpg')}}" 
                              style="height:20px;width: 20px;border-radius:50%;margin-right:10px;">
                              <span id="display"></span>
                      </a>
                  </li>
                
                  <li class="nav-item dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" class="nav-link">
                      <p>
                        Menu
                        <b class="caret"></b>
                      </p>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="nav-item"><a href="{{route('profiladmin')}}" class="nav-link">Profil</a></li>
                      <li class="nav-item"><a href="#" class="nav-link" style="background-color:#dc3545; color:white;" onclick="logout()">Log Out</a></li>
                    </ul>
                  </li>
                  
                  <li class="separator hidden-lg"></li>
                </ul>
              </div>
            </div>
          </nav>
        