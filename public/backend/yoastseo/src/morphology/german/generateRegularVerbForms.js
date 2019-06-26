"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.generateRegularVerbForms = generateRegularVerbForms;

var _addVerbSuffixes = require("./addVerbSuffixes");

var _generateParticipleForm = require("./generateParticipleForm");

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

/**
 * Generates regular verb forms.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  stemmedWord         The stemmed word for which to create the past participle form.
 *
 * @returns {string[]} The created verb forms.
 */
function generateRegularVerbForms(morphologyDataVerbs, stemmedWord) {
  return [].concat(_toConsumableArray((0, _addVerbSuffixes.addVerbSuffixes)(morphologyDataVerbs, stemmedWord)), [(0, _generateParticipleForm.generateParticipleForm)(morphologyDataVerbs, stemmedWord)]);
}
//# sourceMappingURL=generateRegularVerbForms.js.map
