@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <h1>Unsere Nutzungsbedingungen</h1>

                <p>
                    <em>storylab.schettler.net</em> und der Alexa-Skill <em>Erzählkreis</em> können kostenlos genutzt werden.
                    Alle Rechte und Pflichten verbleiben beim Ersteller der Inhalte. Der Entwickler ist nicht für die
                    Inhalte verantwortlich und ist auch nicht dafür haftbar zu machen. Er stellt lediglich den technischen
                    Rahmen zur Wiedergabe bereit.
                </p>

                <p>Bitte informiere dich auch über <a href="{{ route('privacy') }}">unsere Datenschutzbestimmungen</a>.</p>


                <p>
                    <em>storylab.schettler.net</em> und der Alexa-Skill <em>Erzählkreis</em> werden betrieben von
                </p>

                <p>
                    <a href="https://schettler.net/imprint/">Dr. Olav Schettler</a><br>
                    Pipinstr. 14<br>
                    53111 Bonn
                </p>
            </div>
        </div>
    </div>
@endsection
