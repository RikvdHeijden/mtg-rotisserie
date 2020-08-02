<h1>{{ $draft->set->name }}</h1>

<ul>
    @foreach($draft->players as $player)
        <li>{{ $player->name }}</li>
    @endforeach
</ul>

<div style="display: flex; flex-wrap: wrap">
    @foreach($draft->set->cards as $card)
        <div style="width: 200px; height: 300px; background-color: brown; margin: 5px">
            <div>{{ $card->name }}</div>
            <p>{{ $card->text }}</p>
        </div>
    @endforeach
</div>
