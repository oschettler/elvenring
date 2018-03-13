'use strict';
var Alexa = require("alexa-sdk");

var samples = [
    "Welche Geschichten gibt es",
    "Spiele {name}"
];

exports.handler = function(event, context) {
    var alexa = Alexa.handler(event, context);
    alexa.registerHandlers(handlers);
    alexa.execute();
};

var handlers = {
    'LaunchRequest': function () {
        this.emit('Welcome');
    },
    'Welcome': function () {
        this.response.speak('Willkommen im Erzählkreis!')
                     .cardRenderer('hello world', 'hello world');
        this.emit(':responseReady');
    },
    'ListStoriesIntent': function () {
        var stories = [
            'Abenteuer im Abteil',
            'Plom und das Heilkraut'
        ];

        this.response.speak('Ich habe ' + stories.length + ' Geschichten für dich: '
            + stories.join(', ')
        )
            .cardRenderer('hello world', 'hello world');
        this.emit(':responseReady');
    },
    'StoryIntent': function () {
        var name = this.event.request.intent.slots.name.value;
        this.response.speak('OK, hier kommt ' + name)
            .cardRenderer('hello world', 'hello ' + name);
        this.emit(':responseReady');
    },
    'SessionEndedRequest' : function() {
        console.log('Session ended with reason: ' + this.event.request.reason);
    },
    'AMAZON.StopIntent' : function() {
        this.response.speak('Bye');
        this.emit(':responseReady');
    },
    'AMAZON.HelpIntent' : function() {
        this.response.speak("Du kannst sagen: '"
            + samples.join("' oder '") + "'"
        );
        this.emit(':responseReady');
    },
    'AMAZON.CancelIntent' : function() {
        this.response.speak('Tschüß');
        this.emit(':responseReady');
    },
    'Unhandled' : function() {
        this.response.speak("Das habe ich leider nicht verstanden. Du kannst sagen: '"
            + samples.join("' oder '") + "'"
        );
    }
};
