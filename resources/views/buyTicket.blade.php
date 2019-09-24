<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buy Ticket for {{ $event->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fw/fontawesome-all.min.css') }}">
</head>
<body>
    
<div class="rata-tengah mt-2">
    <div class="d-inline-block lebar-70 rata-kiri mt-5">
        <h2>Buy Ticket for {{ $event->title }}</h2>
        <form class="bg-putih rounded bayangan-5 p-3" action="{{ route('event.book', $event->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="eventId" value="{{ $event->id }}">
            <table>
                <thead>
                    <tr>
                        <th>Ticket Name</th>
                        <th>Price</th>
                        <th style="width: 10%;">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        function toIdr($angka) {
                            return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
                        }
                    @endphp
                    @foreach ($tickets as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ toIdr($item->price) }}</td>
                            <td>
                                <input type="number" name="{{ $item->id }}" min="0" class="box border" value="0">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="biru lebar-100 mt-2">Buy</button>
        </form>
    </div>
</div>

</body>
</html>