"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.getForms = getForms;

var _addAdjectiveSuffixes = require("./addAdjectiveSuffixes");

var _detectAndStemRegularParticiple = require("./detectAndStemRegularParticiple");

var _generateAdjectiveExceptionForms = require("./generateAdjectiveExceptionForms");

var _generateNounExceptionForms = require("./generateNounExceptionForms");

var _generateRegularVerbForms = require("./generateRegularVerbForms");

var _generateVerbExceptionForms = require("./generateVerbExceptionForms");

var _stem = require("./stem");

var _stem2 = _interopRequireDefault(_stem);

var _lodashEs = require("lodash-es");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

/**
 * Adds suffixes to the list of regular suffixes.
 *
 * @param {Object}          morphologyDataSuffixAdditions   The German data for suffix additions.
 * @param {Array<string>}   regularSuffixes                 All regular suffixes for German.
 * @param {string}          stemmedWordToCheck              The stem to check.
 *
 * @returns {Array<string>} The modified list of regular suffixes.
 */
var addSuffixesToRegulars = function addSuffixesToRegulars(morphologyDataSuffixAdditions, regularSuffixes, stemmedWordToCheck) {
	var _iteratorNormalCompletion = true;
	var _didIteratorError = false;
	var _iteratorError = undefined;

	try {
		for (var _iterator = Object.keys(morphologyDataSuffixAdditions)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
			var key = _step.value;

			var endingsToCheck = morphologyDataSuffixAdditions[key][0];
			var suffixesToAdd = morphologyDataSuffixAdditions[key][1];

			// Append to the regular suffixes if one of the endings match.
			if (endingsToCheck.some(function (ending) {
				return stemmedWordToCheck.endsWith(ending);
			})) {
				regularSuffixes = regularSuffixes.concat(suffixesToAdd);
			}
		}
	} catch (err) {
		_didIteratorError = true;
		_iteratorError = err;
	} finally {
		try {
			if (!_iteratorNormalCompletion && _iterator.return) {
				_iterator.return();
			}
		} finally {
			if (_didIteratorError) {
				throw _iteratorError;
			}
		}
	}

	return regularSuffixes;
};

/**
 * Deletes suffixes from the list of regular suffixes.
 *
 * @param {Object}          morphologyDataSuffixDeletions   The German data for suffix deletions.
 * @param {Array<string>}   regularSuffixes                 All regular suffixes for German.
 * @param {string}          stemmedWordToCheck              The stem to check.
 *
 * @returns {Array<string>} The modified list of regular suffixes.
 */
var removeSuffixesFromRegulars = function removeSuffixesFromRegulars(morphologyDataSuffixDeletions, regularSuffixes, stemmedWordToCheck) {
	var _iteratorNormalCompletion2 = true;
	var _didIteratorError2 = false;
	var _iteratorError2 = undefined;

	try {
		var _loop = function _loop() {
			var key = _step2.value;

			var endingsToCheck = morphologyDataSuffixDeletions[key][0];
			var suffixesToDelete = morphologyDataSuffixDeletions[key][1];

			// Delete from the regular suffixes if one of the endings match.
			if (endingsToCheck.some(function (ending) {
				return stemmedWordToCheck.endsWith(ending);
			})) {
				regularSuffixes = regularSuffixes.filter(function (ending) {
					return !suffixesToDelete.includes(ending);
				});
			}
		};

		for (var _iterator2 = Object.keys(morphologyDataSuffixDeletions)[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
			_loop();
		}
	} catch (err) {
		_didIteratorError2 = true;
		_iteratorError2 = err;
	} finally {
		try {
			if (!_iteratorNormalCompletion2 && _iterator2.return) {
				_iterator2.return();
			}
		} finally {
			if (_didIteratorError2) {
				throw _iteratorError2;
			}
		}
	}

	return regularSuffixes;
};

/**
 * Adds or removes suffixes from the list of regulars depending on the ending of the stem checked.
 *
 * @param {Object}          morphologyDataNouns The German morphology data for nouns.
 * @param {Array<string>}   regularSuffixes     All regular suffixes for German.
 * @param {string}          stemmedWordToCheck  The stem to check.
 *
 * @returns {Array<string>} The modified list of regular suffixes.
 */
var modifyListOfRegularSuffixes = function modifyListOfRegularSuffixes(morphologyDataNouns, regularSuffixes, stemmedWordToCheck) {
	var additions = morphologyDataNouns.regularSuffixAdditions;
	var deletions = morphologyDataNouns.regularSuffixDeletions;

	regularSuffixes = addSuffixesToRegulars(additions, regularSuffixes, stemmedWordToCheck);
	regularSuffixes = removeSuffixesFromRegulars(deletions, regularSuffixes, stemmedWordToCheck);

	return regularSuffixes;
};

/**
 * Add forms based on changes other than simple suffix concatenations.
 *
 * @param {Object}  morphologyDataNouns The German morphology data for nouns.
 * @param {string}  stemmedWordToCheck  The stem to check.
 *
 * @returns {Array<string>} The modified forms.
 */
var addFormsWithRemovedLetters = function addFormsWithRemovedLetters(morphologyDataNouns, stemmedWordToCheck) {
	var forms = [];
	var stemChanges = morphologyDataNouns.changeStem;

	var _iteratorNormalCompletion3 = true;
	var _didIteratorError3 = false;
	var _iteratorError3 = undefined;

	try {
		for (var _iterator3 = Object.keys(stemChanges)[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
			var key = _step3.value;

			var changeCategory = stemChanges[key];
			var endingToCheck = changeCategory[0];

			if (stemmedWordToCheck.endsWith(endingToCheck)) {
				var stemWithoutEnding = stemmedWordToCheck.slice(0, stemmedWordToCheck.length - endingToCheck.length);
				forms.push(stemWithoutEnding.concat(changeCategory[1]));
			}
		}
	} catch (err) {
		_didIteratorError3 = true;
		_iteratorError3 = err;
	} finally {
		try {
			if (!_iteratorNormalCompletion3 && _iterator3.return) {
				_iterator3.return();
			}
		} finally {
			if (_didIteratorError3) {
				throw _iteratorError3;
			}
		}
	}

	return forms;
};

/**
 * Creates morphological forms for a given German word.
 *
 * @param {string} word             The word to create the forms for.
 * @param {Object} morphologyData   The German morphology data (false if unavailable).
 *
 * @returns {{forms: Array<string>, stem: string}} An object with the forms created and the stemmed word.
 */
function getForms(word, morphologyData) {
	var stemmedWord = (0, _stem2.default)(word);
	var forms = [word];

	/*
  * Generate exception forms if the word is on an exception list. Since a given stem might sometimes be
  * on an exception list in different word categories (e.g., "sau-" from the noun "Sau" or the adjective "sauer")
  * we need to do this cumulatively.
  */
	var exceptionsNouns = (0, _generateNounExceptionForms.generateNounExceptionForms)(morphologyData.nouns, stemmedWord);
	var exceptionsAdjectives = (0, _generateAdjectiveExceptionForms.generateAdjectiveExceptionForms)(morphologyData.adjectives, stemmedWord);
	var exceptionsVerbs = (0, _generateVerbExceptionForms.generateVerbExceptionForms)(morphologyData.verbs, stemmedWord);
	var exceptions = [].concat(_toConsumableArray(exceptionsNouns), _toConsumableArray(exceptionsAdjectives), _toConsumableArray(exceptionsVerbs));

	if (exceptions.length > 0) {
		// Add the original word as a safeguard.
		exceptions.push(word);

		return { forms: (0, _lodashEs.uniq)(exceptions), stem: stemmedWord };
	}

	var stemIfWordIsParticiple = (0, _detectAndStemRegularParticiple.detectAndStemRegularParticiple)(morphologyData.verbs, word);

	/*
  * If the original word is a regular participle, it gets stemmed here. We then only create verb forms (assuming
  * that the participle was used verbally, e.g. "er hat sich die Haare gefärbt" - "he dyed his hair") and adjective
  * forms (assuming that the participle was used adjectivally, e.g. "die Haare sind gefärbt" - "the hair is dyed").
  * The adjective forms are based on the stem that has only the suffixes removed, not the prefixes. This is because
  * we want forms such as "die gefärbten Haare" and not (incorrectly) "*die färbten Haare".
  */
	if (stemIfWordIsParticiple) {
		return {
			forms: (0, _lodashEs.uniq)([].concat(forms, _toConsumableArray((0, _generateRegularVerbForms.generateRegularVerbForms)(morphologyData.verbs, stemIfWordIsParticiple)), _toConsumableArray((0, _addAdjectiveSuffixes.addAllAdjectiveSuffixes)(morphologyData.adjectives, stemmedWord)))),
			stem: stemIfWordIsParticiple
		};
	}

	// Modify regular suffixes assuming the word is a noun.
	var regularNounSuffixes = morphologyData.nouns.regularSuffixes.slice();
	// Depending on the specific ending of the stem, we can add/remove some suffixes from the list of regulars.
	regularNounSuffixes = modifyListOfRegularSuffixes(morphologyData.nouns, regularNounSuffixes, stemmedWord);

	// If the stem wasn't found on any exception list, add regular noun suffixes.
	forms.push.apply(forms, _toConsumableArray(regularNounSuffixes.map(function (suffix) {
		return stemmedWord.concat(suffix);
	})));

	// Also add regular adjective suffixes.
	forms.push.apply(forms, _toConsumableArray((0, _addAdjectiveSuffixes.addAllAdjectiveSuffixes)(morphologyData.adjectives, stemmedWord)));

	// Also add regular verb suffixes.
	forms.push.apply(forms, _toConsumableArray((0, _generateRegularVerbForms.generateRegularVerbForms)(morphologyData.verbs, stemmedWord)));

	// Also add the stemmed word, since it might be a valid word form on its own.
	forms.push(stemmedWord);

	/*
  * In some cases, we need make changes to the stem that aren't simply concatenations (e.g. remove n from the stem
  * Ärztinn to obtain Ärztin.
  */
	forms.push.apply(forms, _toConsumableArray(addFormsWithRemovedLetters(morphologyData.nouns, stemmedWord)));

	return { forms: (0, _lodashEs.uniq)(forms), stem: stemmedWord };
}
//# sourceMappingURL=getForms.js.map
