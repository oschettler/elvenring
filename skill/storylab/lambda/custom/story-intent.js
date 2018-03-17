/**
 * Get a story with its scenes and passages
 */
const utils = require('./utils');
const settings = require('./settings');

module.exports = function () {
    let text;
    
    utils.api('/api/story/2', story => {
        let text = 'Dies ist die Geschichte "' + story.title + '". ';

        text += sceneText(story.scenes[0]);

        this.response.cardRenderer(settings.SKILL_NAME, text);
        this.emit(':ask', text, 'Bitte sage, wie es weiter gehen soll.');
    });
};

function sceneText(scene) {
    return scene.text + ' Sage '
        + utils.conjunct(scene.passages.map((passage, i) => { 
            return i.toString() + ' für ' + passage.title; }), 'oder') + '. ';
}
