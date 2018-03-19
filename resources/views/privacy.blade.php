@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <h1>Deine Privatsphäre</h1>

                <p>Für die Anmeldung auf der Website <em>storylab.schettler.net</em> musst du dir ein Nutzerkonto anlegen. Dazu
                    fragen wir nach einem Namen und einer E-Mail-Adresse. Nach der Registrierung bist du gleich angemeldet und
                    kannst loslegen.</p>
                <p>Für das Nachhalten deiner Anmeldeinformationen benutzen wir ein Cookie. Cookies sind kleine Dateien, die dein
                    Browser verwaltet. Darin ist lediglich eine anonyme, eindeutige Kennung enthalten, anhand derer wir dich
                    deinem Nutzerkonto zuordnen können.</p>

                <p>Wenn du dich einmal ausgeloggt hast und dich erneut anmelden willst, fragen wir nach deiner E-Mail-Adresse.
                    Da wir eine Anmeldung kein Kennwort nutzen, schicken wir dir zur Anmeldung einen Link an diese Adresse.
                    Mit dem Klick auf diesen Link loggst du dich erneut ein.</p>

                <p>Wir speichern deine Geschichten in einer Datenbank auf unseren Servern. Diese Geschichten sind nur angemeldet
                    und nur von dir sichtbar. Geschichten sind einen Kreis und in dem Kreis Autoren zugeordnet. Kreise und Autoren
                    bilden aber keinen gesonderten Zugriffsschutz, sondern bilden lediglich ein Ordnungssystem.<p>

                <p>Für die Nutzung unseres Alexa-Skills musst du dein Amazon-Konto mit deinem Konto auf <em>storylab.schettler.net</em>
                    verbinden. Dein Echo-Gerät kann dadurch auf die Geschichten in deinen Kreisen und deiner Autoren zugreifen.
                    Umgekehrt erhalten wir keinen Zugriff auf dein Amazon-Konto.</p>

                <p>Bitte informiere dich auch über <a href="{{ route('terms') }}">unsere Nutzungsbedingungen</a>.</p>
            </div>
        </div>
    </div>
@endsection
