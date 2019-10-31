<div class="atas bg-biru">
    <h1 class="title">Event Kota</h1>
    @php
        $filterJson = json_decode($filter, true);
    @endphp
    <form action="{{ route('user.index') }}" class="pencarian ke-kanan bag bag-5" method="GET" id="formCari">
        <input type="text" class="box" name="q" id="q" value="{{ $filterJson['q'] }}">
        <button id="cari"><i class="fas fa-search"></i></button>
    </form>
</div>

<script>
    document.querySelector('#formCari').onsubmit = (e) => {
        let q = document.querySelector('#q').value
        changeFilter({
            type: 'q',
            value: q,
        })
        e.preventDefault()
    }
</script>