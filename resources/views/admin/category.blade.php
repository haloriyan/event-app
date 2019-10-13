@extends('layouts.dashboardAdmin')
@section('head.dependencies')
<style>
    .cats {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 90px;
        cursor: pointer;
    }
    .cats form { display: none; }
    .cats:hover form { display: inline-block; }
    .btn {
        padding: 0px;
        height: 10px;
        margin-left: 5px;
    }
</style>
@endsection

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
        @foreach ($categories as $cat)
            <div class="cats bg-biru-transparan">
                {{ $cat->category }}
                <form action="{{ route('category.delete', $cat->id) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn teks-merah"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        @endforeach
        <br />
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