@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <h1>Anleitung</h1>

                <p>
                    Im <a href="http://erzählkreis.de">Erzählkreis</a> kannst du gemeinsam mit deinen Freunden interaktive Geschichten schreiben. Fertige Geschichten kannst du auf unserer Website oder über unseren <a href="https://skills-store.amazon.de/deeplink/dp/B07BKR4J8F?deviceType=app&share&refSuffix=ss_copy">Alexa Skill</a> spielen. Die Idee für den Erzählkreis war übrigens <a href="https://barcampbonn.de/sessions/sessions-2018-freitag/">in einer Session beim vierten Bonner Barcamp</a> entstanden.
                </p>
                <p>
                    Was unterscheidet eigentlich <em>interaktive</em> Geschichten von normalen Geschichten? Interaktive Geschichten sind nicht linear, d.h. sie haben nicht einen einzelnen Handlungsstrang, sondern können sich verzweigen und vielleicht sogar unterschiedliche Enden haben. Diese Art von Geschichten nennt man im Englischen <a href="https://de.wikipedia.org/wiki/Interactive_Fiction">Interactive Fiction</a> (kurz "IF"), oder - wenn das Spielen und weniger die Handlung im Fordergrund steht - <a href="https://de.wikipedia.org/wiki/Adventure">Text Adventures</a>. Die bekannte IF-Autorin Emily Short pflegt <a href="https://emshort.blog/how-to-play/teaching-if/">eine lange Liste mit Workshops und Lehrveranstaltungen</a> und zeigt damit, dass Interactive Fiction ein sehr modernes und lebendiges Medium ist. Wer sich noch gründlicher einlesen möchte, dem sei das <a href="http://bdesilets.com/if/TLIF.pdf">kostenlose EBook <em>Teaching and Learning With Interactive Fiction</em> von Brendan Desilets</a> empfohlen.
                </p>
                <p>
                    Interaktive Geschichten machen deshalb viel Spass, weil man als Leser oder Zuhörer den Lauf der Geschichte beeinflussen kann. Im Erzählkreis sind Geschichten dazu in Szenen aufgeteilt. Jede Szene hat einen oder mehrere Ausgänge. Der Leser wählt am Ende der Szene einen der Ausgänge und bestimmt so, wie es weitergeht.
                </p>
                <p>
                    Wenn du dir im Erzählkreis ein Nutzerkonto anlegst, legen wir  gleich eine einfache Geschichte <em>Der Irrgarten</em> an. Hier ist die Struktur des Irrgartens:
                </p>

                <img class="img-fluid" title="Struktur des Beispiel-Irrgartens" src="/img/irrgarten.png">

                <p>
                    Die Geschichte besteht aus vier Szenen. Jede Szene (bis auf die Letzte) hat einen oder zwei Ausgänge. Im Editor sieht die Geschichte so aus:
                </p>

                <div class="card">

                    <pre class="card-body">
Eingang

Du stehst am Eingang eines Irrgartens.

[- Betrete den Irrgarten -> Ein enger Gang]

---
Ein enger Gang

Du befindest dich in einem Gang.

[- Folge dem Gang -> Eine Kammer]

---
Eine Kammer

Du betrittst eine Kammer. Die Kammer hat links und gegenüber zwei Türen.

[- Gehe durch die linke Tür -> Ein enger Gang]
[- Gehe durch die gegenüberliegende Tür -> Im Garten]

---
Im Garten

Du stehst in einem Garten. Ein kleines Tor führt auf die Strasse. Du hast es geschafft!</pre>
                </div>

                <p>
                    Der Titel einer Szene ist ihre erste Zeile. Danach folgt der Text der Szene. Im Text oder als Liste unter dem Text können Ausgänge benannt werden. Ausgänge werden in eckige Klammern geschrieben. Hierbei gibt es einige Möglichkeiten.
                </p>

                <ul>
                    <li>Ein Stück Text, in eckige Klammern geschrieben, legt einen Ausgang fest. Beispiel: <code>Du stehst am [Eingang] zu einer Höhle.</code> Dieser Ausgang verweist auf eine Szene mit dem Titel <em>Eingang</em>.</li>
                    <li>Soll der Titel der Zielszene anders sein als der dargestellte Text, kannst du beides, durch einen Pfeil getrennt, unterschiedlich nennen, z.B. <code>Du siehst einen [schmalen Spalt -> Eingang] in der Felswand.</code> Hier wird <em>schmalen Spalt</em> angezeigt, das Ziel ist aber die Szene <em>Eingang</em>.</li>
                    <li>Wenn das erste Zeichen nach der öffnenen, eckigen Klammer ein Minuszeichen ist, ist der Ausgang nicht Teil des Szenentextes und wird beim Spielen oder Vorlesen nicht mit angezeigt, wohl aber in der Liste der Ausgänge am Ende der Szene aufgezählt. In unserem Beispiel oben sind alle Ausgänge so markiert.</li>
                </ul>

                <p>
                    Jetzt musst du nur noch wissen, dass einzelne Szenen durch drei Minuszeichen allein in einer Zeile getrennt werden. Und schon weisst du alles, um deine erste, eigene Geschichte zu schreiben.
                </p>
                <p>
                    Im Editor gibt es an Geschichten noch zwei Eingabemöglichkeiten:
                </p>

                <img class="img-fluid" src="/img/head.jpg">

                <p>Markierst du eine Geschichte als <em>öffentlich</em>, ist sie für alle Besucher der Seite <em>Erzählkreis</em> sichtbar. Markiere also nur solche Geschichten als öffentlich, die fertig sind und die - besonders wichtig - nichts Privates über dich und auch nichts Rechtswidriges oder Obszönes enthalten. Nur Geschichten, die als <em>complete</em> markiert sind, werden von Alexa zum Spielen angeboten. Sobald du eine Geschichte als <em>complete</em> markiert hast, kannst du sie auf der Website ausprobieren - klicke dazu in der Geschichtenliste auf den Titel - oder über <a href="https://skills-store.amazon.de/deeplink/dp/B07BKR4J8F?deviceType=app&share&refSuffix=ss_copy">unseren Alexa-Skill</a> von deinem Echo-Gerät vorlesen lassen.
                </p>
                <p>
                    Und jetzt viel Spass beim Schreiben deiner eigenen Geschichten!
                </p>
                <p>
                    <em>Olav, Autor des Erzählkreises</em>
                </p>
            </div>
        </div>
    </div>
@endsection
