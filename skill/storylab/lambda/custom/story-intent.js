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

    const listed_story = stories[this.event.request.intent.slots.story.value - 1];

    utils.api('/api/story/' + listed_story.id, story => {
        let text = 'Dies ist die Geschichte "' + story.title + '". ';

        text += utils.sceneText(story.scenes[0]);

        this.attributes.story = story;
        this.attributes.sceneIndex = 0;

        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.emit(':ask', text, 'Bitte sage, wie es weiter gehen soll.');
    });
};
