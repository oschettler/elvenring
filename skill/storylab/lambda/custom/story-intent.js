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

    const story_index = this.event.request.intent.slots.story.value;
    const prompt = 'Bitte sage "Geschichte", gefolgt von einer Zahl zwischen 1 und ' 
    + stories.length.toString() + '.';

    if (story_index < 1 || story_index > stories.length) {
        this.emit(':ask', prompt);
        return;
    }

    const listed_story = stories[story_index - 1];

    utils.api('/api/story/' + listed_story.id, story => {
        const text = utils.startStory(story);
        const prompt = utils.scenePrompt(story.scenes[0]);

        this.attributes.story = story;
        this.attributes.sceneIndex = 0;
    
        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.emit(':ask', text, prompt);
    });
};
