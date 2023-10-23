@php
   $max_date = date('Y-m-d\TH:i', strtotime('+1 year'));
@endphp
<div class="booking_form_container">
   <form action="{{$route}}" class="booking_form" method="GET">
      <div class="d-block">
         <div class="booking_input_container d-flex flex-lg-row flex-column align-items-center justify-content-center">
            <div>
               <input name="check_in" 
               type="datetime-local" 
               class="booking_input booking_input_a booking_in" 
               min="{{now()}}"
               max="{{$max_date}}"
               placeholder="Check in" 
               value="{{$checkin}}"
               required="required">
            </div>
            <button class="booking_button" type="submit">search</button> 
         </div>
         </div>
   </form>
</div>