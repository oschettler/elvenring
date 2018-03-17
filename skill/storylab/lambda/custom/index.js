/* eslint-disable  func-names */
/* eslint quote-props: ["error", "consistent"]*/

'use strict';
const Alexa = require('alexa-sdk');
const settings = require('./settings');

exports.handler = function(event, context, callback) {
    var alexa = Alexa.handler(event, context);
    alexa.appId = settings.APP_ID;
    alexa.registerHandlers(handlers);
    alexa.execute();
};

const handlers = {
    'LaunchRequest': function () {
        this.emit('ListStoriesIntent');
    },
    'ListStoriesIntent': require('./list-stories-intent'),
    'StoryIntent': require('./story-intent'),
    'PassageIntent': require('./passage-intent'),
    'AMAZON.HelpIntent': function () {
        const speechOutput = settings.HELP_MESSAGE;
        const reprompt = settings.HELP_REPROMPT;

        this.response.speak(speechOutput).listen(reprompt);
        this.emit(':responseReady');
    },
    'AMAZON.CancelIntent': function () {
        this.response.speak(settings.STOP_MESSAGE);
        this.emit(':responseReady');
    },
    'AMAZON.StopIntent': function () {
        this.response.speak(settings.STOP_MESSAGE);
        this.emit(':responseReady');
    },
};

