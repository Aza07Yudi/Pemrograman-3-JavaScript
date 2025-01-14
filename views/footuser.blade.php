</body>
<script src="{{asset('assets/auth/js/jquery-3.4.1.min.js')}}"></script>
  
<script src="{{asset('assets/auth/js/bootstrap.js')}}"></script>
   
<script src="{{asset('assets/auth/js/custom.js')}}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>

<script>
      function logout() {
            localStorage.removeItem("token");
            localStorage.removeItem("tokenExpiry");
            localStorage.removeItem("isloggedin");
            localStorage.removeItem("username");
            localStorage.removeItem("countRefresh");
            localStorage.removeItem("role");
        window.location.href = "{{route('login')}}";
      }
    
    </script>
    <script>
      //TODO: Tampilkan Username
        document.addEventListener("DOMContentLoaded", function () {
            const username = localStorage.getItem("username");

            if (username) {
                const displayElement = document.getElementById("display");
                displayElement.textContent = username;
            } else {
                window.location.href = "{{route('login')}}";
            }
        });
    </script>
</html>