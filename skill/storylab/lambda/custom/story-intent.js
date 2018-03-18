/**
 * Get a story with its scenes and passages
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {

    const attributes = this.attributes;
    const response = this.response;
    const emit = this.emit;

    const stories = this.attributes.stories;
    if (typeof stories === 'undefined') {
        this.emit('ListStoriesIntent');
        return;
    }

    const listed_story = stories[this.event.request.intent.slots.story.value];

    utils.api('/api/story/' + listed_story.id, story => {
        let text = 'Dies ist die Geschichte "' + story.title + '". ';

        text += utils.sceneText(story.scenes[0]);

        attributes.story = story;
        attributes.sceneIndex = 0;

        response.cardRenderer(settings.SKILL_NAME, text);
        emit(':ask', text, 'Bitte sage, wie es weiter gehen soll.');
    });
};
