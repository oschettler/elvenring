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

    if (!this.event.session.user.accessToken) {
        this.emit(':tellWithLinkAccountCard', 'Für den Zugang zu Geschichten musst du dich mit deinem Konto auf ' 
            + settings.API_HOST + ' verbinden. Gehe dazu in deine Alexa App.');
        return;
    }

    let url = '/api/stories';
    let query;
    
    if (this.event.request.intent && this.event.request.intent.hasOwnProperty('slots')
        && this.event.request.intent.slots.hasOwnProperty('query')) {
        query = this.event.request.intent.slots.query.value;
        url += '?q=' + encodeURIComponent(query);
    }

    utils.api(url, this.event.session.user.accessToken, data => {
        const stories = data.data;

        this.attributes.stories = stories;

        text += 'Ich habe ' + utils.plural(stories.length, ['eine Geschichte', 'Geschichten']) + ' für dich. Sage '
            + utils.conjunct(stories.map((story, i) => {
                return 'Geschichte ' + (i+1).toString() + ' für ' + story.title; 
            }), 'oder') + '. ';

        console.log("ListStoriesIntent: ", text);

        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.emit(':ask', text, 'Bitte wähle eine Geschichte.');
    });
};