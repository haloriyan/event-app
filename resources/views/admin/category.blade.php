@extends('layouts.dashboardAdmin')

@section('content')
<h1>Categories</h1>
<div class="bg-putih rounded bayangan-5 p-3">
    <form action="{{ route('category.store') }}" method="POST" class="d-none" id="formCreateCat">
        {{ csrf_field() }}
        <h3>New category</h3>
        <div class="bag bag-9">
            <div>Category name :</div>
            <input type="text" class="box" name="category">
        </div>
        <div class="bag bag-1 ml-1">
            &nbsp;<br />
            <button class="biru">Add</button>
        </div>
    </form>
    @if ($categories->count() == 0)
        <h3>No data</h3>
        <button class="biru mt-2" onclick="showFormCreate()">Create One</button>
    @else
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th class="lebar-25"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $item)
                    <tr>
                        <td>{{ $item->category }}</td>
                        <td>
                            <form action="{{ route('category.delete', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button class="merah p-1 pl-2 pr-2"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="biru mt-2" onclick="showFormCreate()">Add One</button>
    @endif
</div>
@endsection

@section('javascript')
<script>
function showFormCreate() {
    $("#formCreateCat").muncul()
    scrollKe("#formCreateCat")
}
</script>
@endsection