@php
   $max_date = date('Y-m-d\TH:i', strtotime('+1 year'));
   $min_date = date('Y-m-d\TH:i', strtotime('+1 hour'));
@endphp
<div class="booking_form_container">
   <form action="{{route("client.booking.room.index")}}" class="booking_form" method="GET">
      <div class="d-block">
         <div class="booking_input_container d-flex flex-lg-row flex-column align-items-center justify-content-center">
            <div>
               <input name="check_in" 
               type="datetime-local" 
               class="booking_input booking_input_a booking_in" 
               min="{{$min_date}}"
               max="{{$max_date}}"
               placeholder="Check in" 
               required="required">
            </div>
            <div>
               <input name="check_out" 
               type="datetime-local" 
               class="booking_input booking_input_a booking_out" 
               min="{{date('Y-m-d\TH:i', strtotime('+1 day'))}}"
               max="{{$max_date}}"
               placeholder="Check out" 
               required="required">
            </div>
         </div>
         <div class="booking_input_container my-2 d-flex flex-lg-row flex-column align-items-center justify-content-center">
            <div>
               <select name="room_type" id="" class="booking_input booking_input_b" style="min-width: 200px;">
                     <option style="color: black">Room Type</option>
                     @foreach ($category as $item)
                        <option value="{{$item->slug}}" style="color: black">{{$item->name}}</option>
                     @endforeach
               </select>
            </div>
            <div><input name="room" type="number" class="booking_input booking_input_b" placeholder="Number Room"></div>
            <div><input name="person" type="number" class="booking_input booking_input_b" placeholder="Person" required="required"></div>
         </div>
         <div class="booking_input_container d-flex my-2 align-items-center justify-content-center">
            <button class="booking_button" name="online" value="0" type="submit">Book - Counselors</button> 
            <button class="booking_button mx-2" name="online" value="1" type="submit">Book - Online</button>
         </div>
         </div>
   </form>
</div>