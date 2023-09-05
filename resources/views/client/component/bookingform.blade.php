<div class="booking_form_container">
   <form action="{{route("client.booking.index")}}" class="booking_form" method="POST">
      @csrf
      <div class="d-flex flex-xl-row flex-column align-items-start justify-content-start">
         <div class="booking_input_container d-flex flex-lg-row flex-column align-items-center justify-content-start">
            <div><input name="check_in" type="text" class="datepicker booking_input booking_input_a booking_in" placeholder="Check in" required="required"></div>
            <div><input name="check_out" type="text" class="datepicker booking_input booking_input_a booking_out" placeholder="Check out" required="required"></div>
            <div><input name="person" type="number" class="booking_input booking_input_b" placeholder="Person" required="required"></div>
            <div>
               {{-- <input name="room_type" type="text" class="booking_input booking_input_b" placeholder="Room Type"> --}}
               <select name="room_type" id="" class="booking_input booking_input_b">
                     <option style="color: black">Room Type</option>
                     @foreach ($roomCategory as $type)
                        <option value="{{$type->id}}" style="color: black">{{$type->name}}</option>
                     @endforeach
               </select>
            </div>
         </div>
         <div><button class="booking_button trans_200" type="submit">Book for Group</button></div>
      </div>
   </form>
</div>