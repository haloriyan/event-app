@extends('layouts.dashboard')

@section('additional.dependencies')
<style>
    #formCreateContact { display: none; }
</style>
@endsection

@section('content')
<h1>Data Information</h1>
<div class="bg-putih rounded bayangan-5 p-3 mb-5">
    <div>Personal / Company / Group Name :</div>
    <input type="text" class="box" value="{{ $myData->name }}">
</div>

<h1>Contact Information</h1>
<div class="bg-putih rounded bayangan-5 p-3 mb-5">
    @if ($myContact->count() == 0)
        <h3>No any contact information</h3>
        <button class="tbl biru" onclick="showFormCreateContact()">Add One</button>
    @else
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Link to account</th>
                    <th style="width: 25%;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myContact as $item)
                    <tr>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->value }}</td>
                        <td>
                            <form action="{{ route('contact.delete', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button class="tbl merah p-1 pl-2 pr-2"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="tbl biru mt-2" onclick="showFormCreateContact()">Add One</button>
    @endif
    <form action="{{ route('contact.store') }}" id="formCreateContact" method="POST" class="mt-4">
        <h3>Add new contact</h3>
        {{ csrf_field() }}
        <div class="bag bag-2">
            <select name="type" class="box" onchange="checkSocial(this.value)">
                @foreach ($socials as $item)
                    <option>{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="bag bag-6 ml-2">
            <input type="text" class="box" name="value" placeholder="Link to account">
        </div>
        <div class="bag bag-1 ml-2">
            <button class="tbl biru">Add</button>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script>
function showFormCreateContact() {
    $("#formCreateContact").muncul()
}
</script>
@endsection