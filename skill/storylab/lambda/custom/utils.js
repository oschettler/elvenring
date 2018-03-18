/**
 * Utility functions
 */
const https = require('https');
const settings = require('./settings');

function api(path, callback) {
    let req = https.request({
        timeout: 2000,
        host: settings.API_HOST,
        port: settings.API_PORT,
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

function conjunct(ary, conjunction) {
    conjunction = conjunction || 'und';

    if (ary.length == 0) {
        return 'keine';
    }
    else
    if (ary.length == 1) {
        return ary[0];
    }
    else {
        return ary.slice(0, -1).join(', ') + ' ' + conjunction + ' ' + ary[ary.length - 1];
    }
}

function sceneText(scene) {

    let text = scene.body + ' Sage '
    + conjunct(
        scene.passages.map((passage, i) => { 
            return (i+1).toString() + ' für ' + passage.title; 
        }), 'oder');

    text += ' oder sage "noch mal" zum Wiederholen oder "anfang", um die Geschichte noch einmal von vorne zu hören.';

    return text;
}

function scenePrompt(scene) {
    return 'Bitte nenne eine Zahl zwischen 1 und ' 
        + scene.passages.length.toString() + '.';
}

function startStory(story) {
    let text = 'Dies ist die Geschichte "' + story.title + '". ';
    const scene = story.scenes[0];
    const prompt = scenePrompt(scene);

    text += sceneText(scene);

    return text;
}

module.exports = {
    api,
    conjunct,
    plural,
    sceneText,
    scenePrompt,
    startStory
};