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

const API_HOST = 'storylab.schettler.net';
const API_PORT = 443;

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

        api('/api/stories/2', data => {
            const stories = data.data;

            text += 'Ich habe ' + plural(stories.length, ['eine Geschichte', 'Geschichten']) + ' für dich: "'
                + conjunct(stories.map(story => { return story.title; })) + '"';

            console.log(text);

            this.response.cardRenderer(SKILL_NAME, text);
            this.response.speak(text);
            this.emit(':responseReady');
        });
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

const https = require('https');

function api(path, callback) {
    let req = https.request({
        timeout: 2000,
        host: API_HOST,
        port: API_PORT,
        path,
        method: 'GET',
        headers: {
            'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBlMmQ3ZGNlYWQwOGY4ZGQ3N2FiMTMyMWZhZjhjMTc2MGNiNDFjZTUxMGM4N2Q3MGNjM2U2YTk3MDc3ZTIxNDg0MzgzOGVjMTI5YjNlNjQ1In0.eyJhdWQiOiIxIiwianRpIjoiMGUyZDdkY2VhZDA4ZjhkZDc3YWIxMzIxZmFmOGMxNzYwY2I0MWNlNTEwYzg3ZDcwY2MzZTZhOTcwNzdlMjE0ODQzODM4ZWMxMjliM2U2NDUiLCJpYXQiOjE1MjA5NzgzNzksIm5iZiI6MTUyMDk3ODM3OSwiZXhwIjoxNTUyNTE0Mzc5LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.fc4hQ_iUXBfMEIf-OvFLaPkJPuEMkli1Jse5Fbt9uNMPSSeNPKgm-DPKHfQpWO4wryzAujRhn1swdgdt0lBSjAU-et8-BHjF0XisjZqLiehEqz3Nuda7N33JidKF7vj36p4mJEByNbGJUh2A7_v5nvnSaL1IBcxlKP0J94evHAy-21QQMezl8dDP4ONqSsejXO6Vx-e4REK3ij7FoXIkccXMj4T8N2xOoN_jbuB5m6cm5n9vEIL7CpbPbg7AajmSDfuMBI80Z2GKWoEjqqRvzQYMvoUBeX-7lHH0Xegon3szAUfVVrR4K6j1UJEmXMZ482AdAHyfTtVO7-giStGVP71hadrxcdgpFtKvf7g1K7OZbf-38Qo32A8yLtN00WMXH1YWs-NShcFuKDpNARWyz952CVuIT-GVJVO8gPtWGtCwMd0B7nO9L6PD_d-dz8XfSulRjOsGv0f8beFHAA6yGHd9MDm4O4-tBLwMRu5WE4LWS_tMhaXbsmIbeYW46VHjhjlvag7oJT3wruGzEjCZ-r8aDsSfvQHZLUYu0_dxJ-jneBiuLU01o4sJDrxm35M8nIhZfIYsXSAYtu-T6c_Hxq4Izv6y0E280FE_-krLFbC3ovCCSUYdkOnBl9PwzELec6hFQ0Czi4frREkNX6qSYEeEJ0gV8_yvkcNJsN38n5I'
        }
    }, res => {
        res.setEncoding('utf8');
        let return_data = '';

        res.on('data', chunk => {
            return_data += chunk;
        });

        res.on('end', () => {
            console.log(JSON.stringify(return_data));
            callback(JSON.parse(return_data));
        })
    });

    req.on('error', e => {
        console.error('Problem with request: ${e.message}');
    });

    req.end();
}

function plural(count, noun) {
    if (count == 1) {
        return noun[0]; 
    } 
    else
    if (count == 0) { 
        return 'keine ' + noun[1];
    }
    else {
        return count.toString() + ' ' + noun[1];
    }
}

function conjunct(ary) {
    if (ary.length == 0) {
        return 'keine';
    }
    else
    if (ary.length == 1) {
        return ary[0];
    }
    else {
        return ary.slice(0, -1).join(', ') + ' und ' + ary[ary.length - 1];
    }
}