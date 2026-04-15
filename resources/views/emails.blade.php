<h2>E-Ticket</h2>
<p>Jenis: {{ $order->ticket->name }}</p>
<p>Email: {{ $order->email }}</p>

<p>QR Code:</p>

<img src="{{ asset('storage/'.$order->qr_code) }}" width="200">