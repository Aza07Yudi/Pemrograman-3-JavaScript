    </div>
    </div>
        
    </body>
    <script src="{{asset('assets/auth/js/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/auth/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/auth/js/chartist.min.js')}}"></script>
    <script src="{{asset('assets/auth/js/bootstrap-notify.js')}}"></script>
    <script
        type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"
    ></script>
    <script src="{{asset('assets/auth/js/light-bootstrap-dashboard.js?v=1.4.0')}}"></script>
    <script src="{{asset('assets/auth/js/demo.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
        demo.initChartist();

       
        });
    </script>
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
            const an_display =localStorage.getItem("username");

            if (username) {
                const displayElement = document.getElementById("display");
                const tampil = document.getElementById("an_display");
                displayElement.textContent = username;
                tampil.textContent = an_display;
                
            } else {
                window.location.href = "{{route('login')}}";
            }
        });
    </script>
</html>