/**
 * Restart story
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {
    const story = this.attributes.story;
    if (typeof story === 'undefined') {
        this.emit('ListStoriesIntent');
        return;
    }
    const text = utils.startStory(story);

    const first = Object.keys(story.scenes)[0];
    const scene = story.scenes[first];    

    const prompt = utils.scenePrompt(story.scenes[first]);

    this.attributes.sceneIndex = first;

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, prompt);
};
