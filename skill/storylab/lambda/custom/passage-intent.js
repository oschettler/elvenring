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
    const scene = story.scenes[this.attributes.sceneIndex];
    const prompt = 'Bitte nenne eine Zahl zwischen 1 und ' 
        + scene.passages.length.toString() + '.';

    const passage_index = this.event.request.intent.slots.passage.value;
    if (passage_index < 1 || passage_index > scene.passages.length) {
        this.emit(':ask', prompt);
        return;
    }

    const passage = scene.passages[passage_index - 1];

    const i = story.scenes.findIndex(scene => {
        return scene.id == passage.target_id;
    });

    text = 'Szene nicht gefunden';
    if (i >= 0) {
        this.attributes.sceneIndex = i;
        text = utils.sceneText(story.scenes[i]);
    }

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, prompt);
};
