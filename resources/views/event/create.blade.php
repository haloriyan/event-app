@extends('layouts.eventForm')

@section('title', 'Create Event | Event Kota')
@section('additional.dependencies')
<link rel="stylesheet" href="{{ asset('plugins/flatpickr/dist/flatpickr.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/flatpickr/dist/themes/material_red.css') }}">
<style>
    .bagError {
        position: fixed;
        top: 120px;left: 2.5%;
        width: 20%;
    }
</style>
@endsection

<div class="bagError">
    @if ($errors->any())
        @foreach ($errors->all() as $item)
            <div class="bg-merah-transparan p-2 mb-2">
                {{ $item }}
            </div>
        @endforeach
    @endif
</div>

<form class="rata-tengah mt-4" action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="lebar-40 rata-kiri d-inline-block">
        <h2>Basic Information</h2>
        <div class="bg-putih rounded bayangan-5 p-3 mb-4">
            <div>Event name :</div>
            <input type="text" class="box" name="title" required>
            <div class="mt-2">Description :</div>
            <textarea name="description" class="box" required></textarea>
            <div id="app">
                <div class="mt-2">Category :</div>
                <div class="p-1 pl-3 pr-3 bg-hijau-transparan pointer d-inline-block rounded-circle mt-2" v-for="cat in categories" @click="chooseCat">@{{ cat.category }}</div>
                <input type="text" class="box" name="category" @input="searchCat" id="category" v-model="category" required>
            </div>
            <div class="bag bag-4">
                <div class="mt-2">City :</div>
                <select name="city" id="city" class="box mt-1">
                    @foreach ($cities as $city)
                        <option>{{ $city->city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="bag bag-6">
                <div class="mt-2">Location :</div>
                <input type="text" class="box" name="address" placeholder="Address name...">    
            </div>
        </div>
        
        <h2>Time Information</h2>
        <div class="bg-putih rounded bayangan-5 p-3 mb-4">
            <div class="bag bag-5">
                Date Start :
                <input type="text" class="box" id="dateStart" name="dateStart" placeholder="Select date start" onchange="chooseDate(this.value)" required>
            </div>
            <div class="bag bag-5">
                Date End :
                <input type="text" class="box" id="dateEnd" name="dateEnd" readonly placeholder="Pick start date first" required>
            </div>
            <div class="bag bag-5">
                Time Start :
                <input type="text" class="box" id="timeStart" name="timeStart" onchange="chooseTime(this.value)" required>
            </div>
            <div class="bag bag-5">
                Time End :
                <input type="text" class="box" id="timeEnd" name="timeEnd" readonly required>
            </div>
        </div>

        <h2>Image Cover</h2>
        <div class="bg-putih rounded bayangan-5 p-3 mb-4">
            <input type="file" name="cover" class="box" required>
        </div>
        
        <button class="lebar-100 biru mb-5">Create Event</button>
    </div>
</form>

@section('javascript')
<script src="{{ asset('plugins/flatpickr/dist/flatpickr.js') }}"></script>
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
flatpickr("#dateStart", {
    dateFormat: 'Y-m-d'
})
flatpickr("#timeStart", {
    dateFormat: 'H:i',
    noCalendar: true,
    enableTime: true,
})

function chooseDate(value) {
    flatpickr("#dateEnd", {
        dateFormat: 'Y-m-d',
        minDate: value
    })
}
function chooseTime(value) {
    flatpickr("#timeEnd", {
        dateFormat: 'H:i',
        noCalendar: true,
        enableTime: true,
        minDate: value
    })
}

let app = new Vue({
    el: '#app',
    data: {
        categories: [],
        category: '',
        selectedCategory: '',
        endpointSearchCat: "{{ route('api.searchCat') }}"
    },
    methods: {
        searchCat(e) {
            let val = e.currentTarget.value
            let typed = val.split(',')
            val = typed[typed.length - 1]
            if(val == "") {
                this.categories = []
                return false
            }
            axios.post(this.endpointSearchCat, {
                q: val
            })
            .then(res => {
                const data = res.data
                this.categories = data
            })
        },
        chooseCat(e) {
            let val = e.currentTarget.innerHTML
            if(this.selectedCategory == "") {
                this.category = val + ","
                this.selectedCategory = val + ","
            }else {
                this.category = this.selectedCategory + val + ","
                this.selectedCategory += "," + val + ","
            }
            this.categories = []
            document.querySelector("#category").focus()
        }
    },
    computed() {
        // 
    }
})
</script>
@endsection