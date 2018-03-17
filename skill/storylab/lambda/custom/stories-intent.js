/**
 * List all the stories available
 */
const utils = require('./utils');
const settings = require('./settings');

let welcome_seen = false;

module.exports = function () {
    let text;
    
    if (!welcome_seen) {
        text = 'Willkommen im Erzählkreis! ';
        welcome_seen = true;
    }
    else {
        text = '';
    }

    utils.api('/api/stories/2', data => {
        const stories = data.data;

        text += 'Ich habe ' + utils.plural(stories.length, ['eine Geschichte', 'Geschichten']) + ' für dich: "'
            + utils.conjunct(stories.map(story => { return story.title; })) + '"';

        console.log(text);

        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.response.speak(text);
        this.emit(':responseReady');
    });
};