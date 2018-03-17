/**
 * Get a story with its scenes and passages
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {
    let text;

    const story = this.request.attributes.story;
    const passage = this.response.slots.passage;

    const i = story.scenes.findIndex(scene => {
        return scene.id == passage.target_id;
    });

    let text = 'Ziel nicht gefunden';
    if (i >= 0) {
        let text = utils.sceneText(story.scenes[i]);
    }

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, 'Bitte sage, wie es weiter gehen soll.');
};
