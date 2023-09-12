<body class="antialiased">
    @foreach($td as $item)
        IDX : {{ $item->ProductIdx }} <br>
        NAME : {{  $item->ProductName }} <br>
    @endforeach
</body>
