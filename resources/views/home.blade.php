@extends('layouts.lbd')

@section('content')
    <div class="container-fluid">
        <h1>Willkommen im Erzählkreis</h1>

        <p>Hier kannst du mit Freunden eigene, interaktive Geschichten schreiben. Die Geschichten kannst du hier im Web ausprobieren
            - hier ist <a href="{{ route('first') }}">ein Beispiel</a>.</p>
        <p>Noch cooler: Du kannst den Sprachassistenten Alexa von Amazon, nutzen und deine Geschichten nur per Sprache durchspielen.
            Aktiviere dazu unseren Skill <strong>Erzählkreis</strong> und folge den Anweisungen.</p>
    </div>
@endsection
