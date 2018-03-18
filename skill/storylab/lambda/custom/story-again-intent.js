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
    const prompt = utils.scenePrompt(story.scenes[0]);

    this.attributes.sceneIndex = 0;

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, prompt);
};
