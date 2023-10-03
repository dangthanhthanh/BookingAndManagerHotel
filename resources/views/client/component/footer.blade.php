<footer class="footer">
   <div class="footer_content">
      <div class="container">
         <div class="row">
            <div class="col">
               <div class="footer_logo_container text-center">
                  <div class="footer_logo">
                     <a href="{{route('home')}}"></a>
                     <div>The River</div>
                     <div>since 1945</div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row footer_row text-xl-left text-lg-left text-md-center text-sm-center">
            
            <!-- Address -->
            <div class="col-lg-3">
               <div class="footer_title">Our Address</div>
               <div class="footer_list">
                  <ul>
                     <li>Beach Str. 345</li>
                     <li>67559 Miami</li>
                     <li>USA</li>
                  </ul>
               </div>
            </div>

            <!-- Reservations -->
            <div class="col-lg-3">
               <div class="footer_title">Reservations</div>
               <div class="footer_list">
                  <ul>
                     <li>Tel: 345 5667 889</li>
                     <li>Fax; 6783 4567 889</li>
                     <li>reservations@hotelriver.com</li>
                  </ul>
               </div>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3">
               <div class="footer_title">Newsletter</div>
               <div class="newsletter_container">
                  <form action="{{route('client.newsemail.store')}}" class="newsletter_form" id="newsletter_form" method="POST">
                     @csrf
                     <input type="email" class="newsletter_input" name="email" placeholder="Your email address" autocomplete="email">
                     @error('email')
                        <span class="text-danger">{{ $message }}</span>
                     @enderror
                     <button class="newsletter_button" type="submit" onclick="Swal.showLoading()">Subscribe</button>
                  </form>
               </div>
            </div>

            <!-- Footer images -->
            <div class="col-lg-3">
               <div class="certificates d-flex flex-row align-items-start justify-content-lg-between justify-content-start flex-lg-nowrap flex-wrap">
                  <div class="cert"><img src="{{asset('client/images/cert_1.png')}}" alt=""></div>
                  <div class="cert"><img src="{{asset('client/images/cert_2.png')}}" alt=""></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="copyright">
     <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
     Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
     <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
     </div>
</footer>