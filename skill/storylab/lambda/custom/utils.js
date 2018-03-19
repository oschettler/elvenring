/**
 * Utility functions
 */
const https = require('https');
const settings = require('./settings');

function api(path, token, callback) {
    let options = {
        timeout: 2000,
        host: settings.API_HOST,
        port: settings.API_PORT,
        path,
        method: 'GET'
    };

    if (token !== null) {
        options.headers = {
            'Authorization': 'Bearer ' + token
        };
    }

    let req = https.request(options, res => {
        res.setEncoding('utf8');
        let return_data = '';

        res.on('data', chunk => {
            return_data += chunk;
        });

        res.on('end', () => {
            //console.log(JSON.stringify(return_data));
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

    let text = scene.body;
    
    if (scene.passages.length == 0) {
        text += '\n\n' + settings.HELP_MESSAGE2;
    }
    else {
        text += '\n\n Sage '
            + conjunct(
                scene.passages.map((passage, i) => { 
                    return (i+1).toString() + ' für "' + passage.title + '"'; 
                }), ' <break time="500ms" />oder');
    }

    return text;
}

function scenePrompt(scene) {
    if (scene.passages.length == 1) {
        return 'Bitte sage 1 zur Auswahl des einzigen Ausgangs.';
    }
    else {
        return 'Bitte nenne eine Zahl zwischen 1 und ' 
        + scene.passages.length.toString() + '.';
    }
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