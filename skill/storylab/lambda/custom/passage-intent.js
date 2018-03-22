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
    let scene = story.scenes[this.attributes.sceneIndex];
    const prompt = utils.scenePrompt(scene);

    const passage_index = this.event.request.intent.slots.hasOwnProperty('passage')
        ? parseInt(this.event.request.intent.slots.passage.value) : 0;

    if (passage_index < 1 || passage_index > scene.passages.length) {
        this.emit(':ask', 'Das habe ich nicht verstanden. ' + prompt);
        return;
    }

    const passage = scene.passages[passage_index - 1];
    if (story.scenes.hasOwnProperty(passage.target)) {
        scene = story.scenes[passage.target]
        text = utils.sceneText(scene);

        this.attributes.sceneIndex = passage.target;
    }
    else {
        text = 'Szene nicht gefunden';
    }

    this.response.cardRenderer(settings.SKILL_NAME, text);
    this.emit(':ask', text, prompt);
};
