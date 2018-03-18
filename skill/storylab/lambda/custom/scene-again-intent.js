/**
 * Restart story
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {
    let text;

    const story = this.attributes.story;
    const scene_index = this.attributes.sceneIndex;
    if (typeof story === 'undefined') {
        this.emit('ListStoriesIntent');
        return;
    }
    const scene = story.scenes[this.attributes.sceneIndex];
    const text = utils.sceneText(scene);
    const prompt = utils.scenePrompt(scene);

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, prompt);
};
