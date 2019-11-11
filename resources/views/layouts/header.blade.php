<div class="atas bg-biru">
    <h1 class="title">Event Kota</h1>
    @php
        $filterJson = json_decode($filter, true);
    @endphp
    <div id="toggleSearch" onclick="toggleSearch()" class="mobile ke-kanan"><i class="fas fa-search"></i></div>
    <form action="{{ route('user.index') }}" class="pencarian ke-kanan bag bag-5" method="GET" id="formCari">
        <div class="mobile-inline-block">Pencarian</div>
        <div onclick="closeSearch()" class="mobile-inline-block ke-kanan"><i class="fas fa-times"></i></div>
        <input type="text" class="box" name="q" id="q" value="{{ $filterJson['q'] }}">
        <button id="cari"><i class="fas fa-search"></i></button>
    </form>
</div>

<script>
    let isSearchOpened = false

    const closeSearch = () => {
        document.querySelector("#formCari").style.top = "-100%"
        isSearchOpened = false
    }
    const openSearch = () => {
        document.querySelector("#formCari").style.top = "65px"
        isSearchOpened = true
    }
    const toggleSearch = () => {
        if(isSearchOpened) {
            closeSearch()
        }else {
            openSearch()
        }
    }

    document.querySelector('#formCari').onsubmit = (e) => {
        let q = document.querySelector('#q').value
        changeFilter({
            type: 'q',
            value: q,
        })
        e.preventDefault()
    }
</script>