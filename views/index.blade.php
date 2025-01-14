@include ('navuser')

    <section class="slider_section long_section">
    <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-5">
                  <div class="detail-box">
                    <h1>
                      Air Yang Bersih <br>
                      Itu Penting, loh!
                    </h1>
                    <p>
                      Air bersih berasal dari mata air yang berada di gunung.
                      Mata air ini kaya akan mineral dan diolah, disterilkan,
                      dan dikemas dengan rapi dan bersih untuk mencegah kontaminasi bakteri.
                    </p>
                    <div class="btn-box">
                      <a href="{{route('tambahsaldo')}}" class="btn2">
                        Topup Sekarang
                      </a>
                    </div>
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="img-box">
                    <img src="{{asset('assets/auth/img/drink.png')}}" alt="">
                  </div>
                </div>
              </div>
            </div>
    </div>
    </section>
</div>

 
@include ('footuser')
