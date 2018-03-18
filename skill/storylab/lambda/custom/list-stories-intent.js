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

        this.attributes.stories = stories;

        text += 'Ich habe ' + utils.plural(stories.length, ['eine Geschichte', 'Geschichten']) + ' für dich. Sage '
            + utils.conjunct(stories.map((story, i) => {
                return 'Geschichte ' + (i+1).toString() + ' für ' + story.title; 
            }), 'oder') + '. ';

        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.emit(':ask', text, 'Bitte wähle eine Geschichte.');
    });
};