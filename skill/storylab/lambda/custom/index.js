/* eslint-disable  func-names */
/* eslint quote-props: ["error", "consistent"]*/

'use strict';
const Alexa = require('alexa-sdk');

const APP_ID = 'amzn1.ask.skill.c925a17b-b3cc-46e7-91e4-f6317c8e88e1';

const SKILL_NAME = 'Erzählkreis';
const GET_FACT_MESSAGE = "Ich habe diese Gschichten für dich: ";
const HELP_MESSAGE = 'Starte, indem du "Geschichten" sagst. Wähle eine der Geschichten aus und sage "Erste Geschichte". Folgen dann den Anweisungen';
const HELP_REPROMPT = 'Wie kann ich dir weiterhelfen?';
const STOP_MESSAGE = 'Tschüss!';

const data = [
    'Plom vom Planeten Gurgius',
    'Abenteuer im Abteil'
];

let welcomed = false;

exports.handler = function(event, context, callback) {
    var alexa = Alexa.handler(event, context);
    alexa.appId = APP_ID;
    alexa.registerHandlers(handlers);
    alexa.execute();
};

const handlers = {
    'LaunchRequest': function () {
        this.emit('ListStoriesIntent');
    },
    'ListStoriesIntent': function () {
        let text;
        
        if (!welcomed) {
            text = 'Willkommen im Erzählkreis! ';
            welcomed = true;
        }
        else {
            text = '';
        }

        text += 'Ich habe diese ' + data.length + ' Geschichten für dich: "'
            + data.join(', ') + '"';

        this.response.cardRenderer(SKILL_NAME, text);
        this.response.speak(text);
        this.emit(':responseReady');
    },
    'AMAZON.HelpIntent': function () {
        const speechOutput = HELP_MESSAGE;
        const reprompt = HELP_REPROMPT;

        this.response.speak(speechOutput).listen(reprompt);
        this.emit(':responseReady');
    },
    'AMAZON.CancelIntent': function () {
        this.response.speak(STOP_MESSAGE);
        this.emit(':responseReady');
    },
    'AMAZON.StopIntent': function () {
        this.response.speak(STOP_MESSAGE);
        this.emit(':responseReady');
    },
};
