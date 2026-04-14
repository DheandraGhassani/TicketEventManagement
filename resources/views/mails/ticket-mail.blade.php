<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket — {{ $order->event->title ?? 'Event' }}</title>
</head>

<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:24px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.1);">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#4f46e5;padding:24px 32px;">
                            <h1 style="margin:0;color:#fff;font-size:22px;">🎫 E-Ticket Anda</h1>
                            <p style="margin:4px 0 0;color:#c7d2fe;font-size:13px;">Terima kasih telah melakukan
                                pembelian!</p>
                        </td>
                    </tr>

                    {{-- Event Info --}}
                    <tr>
                        <td style="padding:24px 32px;border-bottom:1px solid #e5e7eb;">
                            <h2 style="margin:0 0 12px;font-size:18px;color:#111827;">{{ $order->event->title ?? '-' }}
                            </h2>
                            <table cellpadding="4" cellspacing="0">
                                <tr>
                                    <td style="color:#6b7280;font-size:13px;width:120px;">No. Order</td>
                                    <td style="font-size:13px;font-weight:bold;color:#111827;">
                                        {{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#6b7280;font-size:13px;">Tanggal Event</td>
                                    <td style="font-size:13px;color:#111827;">
                                        {{ $order->event->start_date->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#6b7280;font-size:13px;">Lokasi</td>
                                    <td style="font-size:13px;color:#111827;">{{ $order->event->venue_name }},
                                        {{ $order->event->city }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#6b7280;font-size:13px;">Total Bayar</td>
                                    <td style="font-size:14px;font-weight:bold;color:#4f46e5;">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Tickets --}}
                    <tr>
                        <td style="padding:24px 32px;">
                            <h3 style="margin:0 0 16px;font-size:15px;color:#111827;">Detail Tiket</h3>

                            @foreach ($order->orderItems as $item)
                                @foreach ($item->eTickets as $ticket)
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="border:1px solid #e5e7eb;border-radius:8px;margin-bottom:16px;overflow:hidden;">
                                        <tr>
                                            <td
                                                style="background:#f9fafb;padding:10px 16px;border-bottom:1px solid #e5e7eb;">
                                                <span
                                                    style="font-weight:bold;font-size:14px;color:#111827;">{{ $item->ticketType->name ?? '-' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:16px;text-align:center;">
                                                <p style="margin:0 0 8px;font-size:12px;color:#6b7280;">Kode Tiket</p>
                                                <p
                                                    style="margin:0 0 12px;font-size:22px;font-weight:bold;letter-spacing:4px;color:#111827;">
                                                    {{ $ticket->ticket_code }}
                                                </p>
                                                <div
                                                    style="display:inline-block;background:#fff;padding:8px;border:1px solid #e5e7eb;border-radius:4px;">
                                                    {!! $ticket->qr_code_data !!}
                                                </div>
                                                <p style="margin:10px 0 0;font-size:11px;color:#9ca3af;">
                                                    Tunjukkan QR code ini saat masuk venue
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                @endforeach
                            @endforeach
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="background:#f9fafb;padding:16px 32px;border-top:1px solid #e5e7eb;text-align:center;">
                            <p style="margin:0;font-size:11px;color:#9ca3af;">
                                Email ini dikirim otomatis. Simpan tiket ini untuk keperluan masuk venue.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
