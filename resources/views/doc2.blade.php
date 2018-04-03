@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <h1>Fortgeschrittene Merkmale</h1>

                <p><strong>Achtung:</strong> Die hier beschriebenen Merkmale werden im Augenblick noch nicht vom Alexa-Skill unterstützt.</p>

                <p>
                    Zusätzlich zu <a href="{{ route('doc') }}">einfachen Szenen</a> können Geschichten im Erzählkreis auch bebilderte Szenen, Daten und Logik enthalten. Dieses Dinge erklären wir auf dieser Seite.
                </p>

                <h2>Daten</h2>

                <p>
                    Ein erstes Merkmal sind Daten an Szenen. Daten können direkt unter den Titel einer Szene eingefügt werden. Zur Kennzeichnung werden Daten zwischen zwei Zeilen geschrieben, die nur jeweils drei Punkte enthalten. Daten sind im sogenannten <a href="https://de.wikipedia.org/wiki/YAML">YAML-Format</a> angelegt. Grundsätzlich können so beliebige Daten angelegt und später in der Anwendungslogik genutzt werden (s.u.). Es gibt aber zwei besondere Eigenschaften: <em>image</em> für Bilder und <em>show_title</em> zum Anzeigen bzw. Unterdrücken von Szenetiteln.
                </p>

                <h2>Bebilderte Szenen</h2>

                <p>
                    Du kannst zu jeder Geschichte mehrere Bilder hochladen und diese dann in den Szenen der Geschichte anzeigen. Hier ist der Geschichteneditor mit drei Bildern:
                </p>

                <img class="img-fluid" src="/img/images.jpg">

                <p>
                    In dem Screenshot ist auch schon gleich gezeigt, wie du mit der rechten Maustaste die Adresse eines Bildes kopierst. Dieses Menü gilt für Firefox. In anderen Browsern sieht das Menü wahrscheinlich ein wenig anders aus.
                </p>

                <p>
                    Hier ist eine kleine Geschichte mit drei Szenen, die alle fortgeschrittenen Merkmale nutzt:
                </p>

                <div class="card">

                    <pre class="card-body">Der Anfang
...
image: /storage/31/conversions/anfang-preview.jpg
...
{- # Setze Zähler auf Anfang
local(count, 0)
}
Das hier ist der Anfang

[- Mittendrin]

---
Mittendrin
...
show_title: false
image: /storage/32/conversions/mitte-preview.jpg
gerade: >
  Das ist der gerade Text
ungerade: >
  Das ist der UNGERADE Text
wetter:
 - Es schneit
 - Die Sonne scheint
 - Es hagelt
 - Es ist dicht bewölkt und nieselt leicht
 - Der Himmel ist grau
 - Der Himmel ist strahlend blau, aber es ist eiskalt
...
Du warst schon { incr(count) } Mal hier.

{ # Zeige den einen oder anderen Text
if(even(count), gerade, ungerade)
}
{ local(welches, random(length(wetter))) }: { element(wetter, welches) }

[- Zum Anfang -> Der Anfang]
[- Bleiben { print(count) } -> Mittendrin]
[-{ # Bedingter Ausgang
>(count, 9)
} Geschafft! -> Das Ende]

---
Das Ende
...
image: /storage/30/conversions/ende-preview.jpg
...
Das Ende :)

[- Zum Anfang -> Der Anfang]
</pre>
                </div>

                <p>
                    In dieser Geschichte hat jede Szene ein eigenes Bild hinter <em>image</em>. Bei der mittleren Szene wird der Titel nicht angezeigt.
                </p>

                <h2>Logik</h2>

                <p>
                    In den Daten, Texten und den Ausgängen kann Anwendungslogik in einer <a href="https://eloquentjavascript.net/12_language.html">einfachen Programmiersprache namens <em>Egg</em></a> aufgeschrieben werden. Egg-Logik wird in einfache geschweifte Klammern geschrieben. Im Beispiel ist <code>{- local(count, 0) }</code> ein einfaches Stück Egg-Logik (welches wegen des Minuszeichens keine Ausgabe erzeugt) und setzt einen Zähler auf 0. Dieser Zähler wird in der zweiten Szene mit <code>{ incr(count) }</code> erhöht und angezeigt.
                </p>

                <p>
                    In dieser Szene sind noch ein paar weitere Beispiele von Egg-Logik enthalten:
                </p>

                <ul>
                    <li><code>{ if(even(count), gerade, ungerade) }</code> zeigt bei geraden Werten von <em>count</em> den einen, bei ungeraden Werten den anderen Text aus den Daten an.</li>
                    <li>In den Daten ist ein Array <em>wetter</em> mit zehn Einträgen angelegt. Der Code <code>{ local(welches, random(length(wetter))) }</code> speichert eine Zufallszahl zwischen 0 und 5 in der Variable <em>welches</em>. Über diese wird mit dem weiteren Code-Block <code>{ element(wetter, welches) }</code> ein Eintrag aus dem <em>wetter</em>-Array ausgewählt und angezeigt.</li>
                    <li>Jeder Ausgang kann zwei Logik-Blöcke enthalten. Der erste Block muss direkt ohne Leerraum auf die öffnende, eckige Klammer folgen und enthält die <em>Bedingung</em>, unter der der Ausgang angezeigt wird. Im Beispiel ist <code>{ >(count, 9) }</code> eine Bedingung. Der Ausgang wird erst angezeigt, wenn <em>count</em> größer als 9 ist. Ein weiterer Code-Block irgendwo im Text des Ausganges stellt eine <em>Aktion</em> dar, die bei Klick auf den Ausgang ausgeführt wird. Die Ausgabe der Aktion geht verloren. Im Beispiel ist <code>{ print(count) }</code> eine Aktion.</li>
                </ul>

                <p>
                    Hier ist das Beispiel im Web-Player:
                </p>

                <video style="max-width:100%" src="/img/storylab.mp4" controls></video>

                <p>
                    ... und hier <a href="https://storylab.neocities.org/">als statische Seite bei Neocities</a>.
                </p>
            </div>
        </div>
    </div>
@endsection
