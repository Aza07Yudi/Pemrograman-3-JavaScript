<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('assets/auth/img/favicon.ico')}}" />
    <title>Infinity Water</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      
      if (!localStorage.getItem("isloggedin")|| !localStorage.getItem("token") || localStorage.getItem("role") !== "2") {
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
    <link rel="stylesheet" type="text/css" href="{{asset('assets/auth/css/bootstrap.css')}}" />

    <link
    href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap"
    rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{asset('assets/auth/css/font-awesome.min.css')}}" rel="stylesheet" />
    
    <link href="{{asset('assets/auth/css/style_user.css')}}" rel="stylesheet" />
      
    <link href="{{asset('assets/auth/css/responsive.css')}}" rel="stylesheet" />
</head>
<body>
<div class="hero_area">
    <header class="header_section long_section px-0">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="index.html">
          <span>
            Infinity Water
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""> </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="{{route('index')}}">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('produkuser')}}">Produk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('tambahsaldo')}}">Topup</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('topupuser')}}"> Riwayat Topup</a>
              </li>
              
            </ul>
          </div>
          <div class="quote_btn-container">
             
            <b><a href="{{route('profiluser')}}"><i class="fa fa-user"></i> <span id="display"></span></a></b>
              
            <a href="">
              <span>
              <a href="#" class="nav-link" style="background-color:#dc3545; color:white;" onclick="logout()">Log Out</a>
              </span>
            </a>
          </div>
        </div>
      </nav>
    </header>