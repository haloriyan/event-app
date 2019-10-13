<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Ticket for {{ $ticket->users->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fw/fontawesome-all.min.css') }}">
    <style>
        .container {
            position: absolute;
            top: 80px;left: 30%;
            width: 40%;;
        }
    </style>
</head>
<body>
    
<div class="container bg-putih rounded bayangan-5">
    <div class="wrap">
        <h2>Detail Receipt
            <p class="d-inline-block teks-transparan">for {{ $ticket->users->name }}</p>
        </h2>
        <p>
            to attending <b>{{ $ticket->tickets->events->title }}</b>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <td>Qty</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $ticket->tickets->name }}</td>
                    <td>{{ $ticket->qty }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>