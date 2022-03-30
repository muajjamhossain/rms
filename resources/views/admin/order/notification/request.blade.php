
<a href="{{url('admin/order-request')}}" class="waves-effect"><i class="fa fa-shopping-cart"></i><span> Order </span><order-request :userid="{{ Auth::user()->id }}"  :unreads="{{ auth()->user()->unreadNotifications }}"></order-request>
    <audio id="orderRequestNoty" muted>
        <source src="{{ asset('sounds/orderRequest/orderRequest.mp3') }}">
        <source src="{{ asset('sounds/orderRequest/orderRequest.wav') }}">
    </audio>
</a>
