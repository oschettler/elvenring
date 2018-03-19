/**
 * Get a story with its scenes and passages
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {

    const stories = this.attributes.stories;
    if (typeof stories === 'undefined') {
        this.emit('ListStoriesIntent');
        return;
    }

    const story_index = this.event.request.intent.slots.hasOwnProperty('story') 
        ? parseInt(this.event.request.intent.slots.story.value) : 0;

    const prompt = 'Bitte sage "Geschichte", gefolgt von einer Zahl zwischen 1 und ' 
    + stories.length.toString() + '.';

    if (story_index < 1 || story_index > stories.length) {
        this.emit(':ask', prompt);
        return;
    }

    const listed_story = stories[story_index - 1];

    console.log("Endpoint: " + JSON.stringify(this.event));

    if (!this.event.session.user.accessToken) {
        this.emit(':tellWithLinkAccountCard', 'Für den Zugang zu Geschichten musst du dich mit deinem Konto auf ' 
            + settings.API_HOST + ' verbinden. Gehe dazu in deine Alexa App.');
        return;
    }

    utils.api('/api/story/' + listed_story.id, this.event.session.user.accessToken, story => {
        const text = utils.startStory(story);
        const prompt = utils.scenePrompt(story.scenes[0]);

        this.attributes.story = story;
        this.attributes.sceneIndex = 0;
    
        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.emit(':ask', text, prompt);
    });
};
