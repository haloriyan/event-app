@extends('layouts.dashboard')

@section('content')
<div id="app">
    <h1>{{ $event->title }} Guests</h1>
    <div class="bg-putih rounded bayangan-5 p-2">
        <input type="text" v-model="search" class="box mb-2" placeholder="Search name...">
    </div>
    <div v-for="ticket in filteredList">
        <h2>@{{ ticket.name }}</h2>
        <div class="bg-putih rounded bayangan-5 p-3 mt-4">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th class="lebar-25"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in ticket.guestSearch">
                        <td>@{{ item.users.name }}</td>
                        <td>@{{ item.qty }}</td>
                        <td>
                            <div v-if="item.status == 1">
                                <button class="hijau-alt p-1" :idBook="item.id" @click="hadir">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                            <div v-else>
                                <span class="teks-transparan">Checked</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            datas: [],
            search: '',
        },
        computed: {
            filteredList() {
                let ret = []
                this.datas.forEach(res => {
                    let guests = res.guest
                    let filt = guests.filter(g => {
                        return g.users.name.toLowerCase().includes(this.search.toLowerCase())
                    })
                    res.guestSearch = filt
                })
                return this.datas
            },
        },
        methods: {
            post(endpoint, data) {
                axios.post(endpoint, data)
                .then(res => {
                    // 
                })
            },
            getTicketsData() {
                console.log('getting data')
                axios.get('{{ route("event.guestsData", $event->id) }}', {
                    ret: 'api'
                })
                .then(res => {
                    const data = res.data
                    this.datas = data
                })
            },
            hadir(e) {
                let target = e.currentTarget
                // act
                let id = target.getAttribute('idBook')
                this.post('{{ route("event.attend") }}', {
                    id: id,
                })
                // ganti view
                let parent = target.parentNode
                parent.innerHTML = "<span class='teks-transparan'>Checked</span>"
            }
        },
        created() {
            this.getTicketsData()
        }
    })
</script>
@endsection