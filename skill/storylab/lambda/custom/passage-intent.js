/**
 * Get a story with its scenes and passages
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {
    let text;

    const story = this.attributes.story;
    if (typeof story === 'undefined') {
        this.emit('ListStoriesIntent');
        return;
    }
    const scene = story[this.attributes.sceneIndex];
    const passage = scene.passages[this.event.request.intent.slots.passage.value];

    const i = story.scenes.findIndex(scene => {
        return scene.id == passage.target_id;
    });

    text = 'Ziel nicht gefunden';
    if (i >= 0) {
        this.attributes.sceneIndex = i;
        text = utils.sceneText(story.scenes[i]);
    }

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, 'Bitte sage, wie es weiter gehen soll.');
};
