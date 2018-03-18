/**
 * List all the stories available
 */
const utils = require('./utils');
const settings = require('./settings');

let welcome_seen = false;

module.exports = function () {
    let text;
    const response = this.response;
    const attributes = this.attributes;
    const emit = this.emit;
    
    if (!welcome_seen) {
        text = 'Willkommen im Erzählkreis! ';
        welcome_seen = true;
    }
    else {
        text = '';
    }

    utils.api('/api/stories/2', data => {
        const stories = data.data;

        attributes.stories = stories;

        text += 'Ich habe ' + utils.plural(stories.length, ['eine Geschichte', 'Geschichten']) + ' für dich. Sage '
            + utils.conjunct(stories.map((story, i) => {
                return 'Geschichte ' + (i+1).toString() + ' für ' + story.title; 
            }), 'oder') + '. ';

        console.log(text);

        response.cardRenderer(settings.SKILL_NAME, text);
        emit(':ask', text, 'Bitte wähle eine Geschichte.');
    });
};