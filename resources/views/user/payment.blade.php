@extends('layouts.dashboard')

@section('content')
<h1>Payment Method</h1>
<div class="bg-putih rounded bayangan-5 p-3">
    <p class="teks-kecil">
        * Payment method used for receiving payment when you have paid events
    </p>
    @if ($payment->count() == 0)
        <h3>You don't have any payment method</h3>
        <a href="{{ route('payment.create') }}">
            <button class="biru mt-2">Create One</button>
        </a>
    @else
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>ID</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payment as $item)
                    <tr>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->account_name }}</td>
                        <td>{{ $item->account_id }}</td>
                        <td>
                            <form action="{{ route('payment.delete', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button class="merah"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('payment.create') }}">
            <button class="biru mt-2">Create Another</button>
        </a>
    @endif
</div>
@endsection