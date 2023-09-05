@extends("emails.layouts.email")
@section("title",'Verify email')
@section("content")
   <p> Hello, {{$name}}! </p>
   <p> your bill|</p>
   <table>
      <thead>
         <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Cost</th>
            <th>Price</th>
         </tr>
      </thead>
      <tbody>
         @foreach($items as $item)
         <tr>
            <td>{{++$loop->index }}</td>
            <td>{{$item['name']}}</td>
            
      </tbody>
   </table>
   <p>  Click the button below to verify your email address: </p>

   <a class="button" href="{{$detail_bill}}">Detail</a>

   <p> If you did not create an account, no further action is required.</p>

@endsection
@section("footer")
<p>  Contact us at Bookinghotel@example.com </p>
<p> Thanks, {{$name}}</p>
@endsection