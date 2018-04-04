/**
 * Utility functions
 */
const https = require('https');
const settings = require('./settings');
const egg = require('./egg');

function api(path, token, callback) {
    console.log("API: ", path);

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
            console.log("API: Calling with ", return_data);
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

function stripTags(text) {
    return text.replace(/(<([^>]+)>)/ig, '');
}

function sceneText(scene) {

    let scope = egg.topScope;
    Object.keys(scene.vars).map(name => scope[name] = scene.vars[name]);

    let text = scene.body;

    scene.code.forEach((code, i) => {
        const result = egg.run(code, scope);
        text = text.replace('<code #' + (i+1).toString() + '>', result);
    });

    text = stripTags(text);
    
    if (scene.passages.length == 0) {
        text += '\n\n' + settings.HELP_MESSAGE2;
    }
    else {
        let passages = [];
        scene.passages.forEach((passage, i) => {
            let condition = true;
            if (typeof passage.condition !== 'undefined') {
                condition = egg.run(passage.condition, scope);
            }
            if (condition) {
                passages.push(passage);
            }
        });

        text += '\n\n Sage '
        + conjunct(
            passages.map((passage, i) => { 
                return (i+1).toString() + ' für "' + stripTags(passage.title) + '"'; 
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
    const first = Object.keys(story.scenes)[0];
    const scene = story.scenes[first];
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