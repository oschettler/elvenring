/* eslint-disable  func-names */
/* eslint quote-props: ["error", "consistent"]*/

'use strict';
const Alexa = require('alexa-sdk');
const settings = require('./settings');

//console.log(this.context.logGroupName, this.context.logStreamName);

exports.handler = function(event, context, callback) {
    var alexa = Alexa.handler(event, context);
    alexa.appId = settings.APP_ID;
    alexa.dynamoDBTableName = 'storylab';
    alexa.registerHandlers(handlers);
    alexa.execute();
};

const handlers = {
    'LaunchRequest': function () {
        if (this.attributes.story && this.attributes.sceneIndex) {
            this.emit(':ask', 'Willkommen zurück. Sage "weiter", um die Geschichte '
                + this.attributes.story.title + ' fortzusetzen oder sage "neue Geschichte".'
            );
            return;
        }
        this.emit('ListStoriesIntent');
    },
    'ListStoriesIntent': require('./list-stories-intent'),
    'StoryIntent': require('./story-intent'),
    'PassageIntent': require('./passage-intent'),
    'StoryAgainIntent': require('./story-again-intent'),
    'SceneAgainIntent': require('./scene-again-intent'),
    'AMAZON.HelpIntent': function () {
        const speechOutput = settings.HELP_MESSAGE + settings.HELP_MESSAGE2;
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
    'Unhandled': function() {
        console.log("Unhandled", JSON.stringify(this.attributes));
        
        let handler;
        if (this.attributes.story && this.attributes.sceneIndex) {
            handler = require('./passage-intent');
        }
        else {
            handler = require('./list-stories-intent');
        }
        handler.call(this);
    }
};

