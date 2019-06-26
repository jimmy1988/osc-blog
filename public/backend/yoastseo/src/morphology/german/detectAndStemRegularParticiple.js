"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.detectAndStemRegularParticiple = detectAndStemRegularParticiple;

var _exceptionsParticiplesActive = require("../../researches/german/passiveVoice/exceptionsParticiplesActive");

var _exceptionsParticiplesActive2 = _interopRequireDefault(_exceptionsParticiplesActive);

var _regex = require("../../researches/german/passiveVoice/regex");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Detects whether a word is a regular participle without a prefix and if so, returns the stem.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  word                The word (not stemmed) to check.
 *
 * @returns {string|null} The stem or null if no participle was matched.
 */
var detectAndStemParticiplesWithoutPrefixes = function detectAndStemParticiplesWithoutPrefixes(morphologyDataVerbs, word) {
	var geStemTParticipleRegex = new RegExp("^" + morphologyDataVerbs.participleStemmingClasses[1].regex);
	var geStemEtParticipleRegex = new RegExp("^" + morphologyDataVerbs.participleStemmingClasses[0].regex);

	/*
  * Check if it's a ge + stem ending in d/t + et participle.
  * As this is the more specific regex, it needs to be checked before the ge + stem + t regex.
  */
	if (geStemEtParticipleRegex.test(word)) {
		// Remove the two-letter prefix and the two-letter suffix.
		return word.slice(2, word.length - 2);
	}

	// Check if it's a ge + stem + t participle.
	if (geStemTParticipleRegex.test(word)) {
		// Remove the two-letter prefix and the one-letter suffix.
		return word.slice(2, word.length - 1);
	}

	return null;
};

/**
 * Determines whether a given participle pattern combined with prefixes from a given class applies to a given word
 * and if so, returns the stem.
 *
 * @param {string}      word        The word (not stemmed) to check.
 * @param {string[]}    prefixes    The prefixes of a certain prefix class.
 * @param {string}      regexPart   The regex part for a given class (completed to a full regex within the function).
 * @param {number}      startStem   Where to start cutting off the de-prefixed word.
 * @param {number}      endStem     Where to end cutting off the de-prefixed word (from the end index).
 *
 * @returns {string|null} The stem or null if no prefixed participle was matched.
 */
var detectAndStemParticiplePerPrefixClass = function detectAndStemParticiplePerPrefixClass(word, prefixes, regexPart, startStem, endStem) {
	var _iteratorNormalCompletion = true;
	var _didIteratorError = false;
	var _iteratorError = undefined;

	try {
		for (var _iterator = prefixes[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
			var currentPrefix = _step.value;

			var participleRegex = new RegExp("^" + currentPrefix + regexPart);

			if (participleRegex.test(word)) {
				var wordWithoutPrefix = word.slice(currentPrefix.length - word.length);
				var wordWithoutParticipleAffixes = wordWithoutPrefix.slice(startStem, wordWithoutPrefix.length - endStem);

				return currentPrefix + wordWithoutParticipleAffixes;
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

	return null;
};

/**
 * Detects whether a word is a regular participle with a prefix and if so, returns the stem.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  word                The word (not stemmed) to check.
 *
 * @returns {string|null} The stem or null if no participle with prefix was matched.
 */
var detectAndStemParticiplesWithPrefixes = function detectAndStemParticiplesWithPrefixes(morphologyDataVerbs, word) {
	var prefixesSeparableOrInseparable = morphologyDataVerbs.verbPrefixesSeparableOrInseparable;

	/*
  * It's important to preserve order here, since the ge + stem ending in d/t + et regex is more specific than
  * the ge + stem + t regex, and therefore must be checked first.
  */
	var _iteratorNormalCompletion2 = true;
	var _didIteratorError2 = false;
	var _iteratorError2 = undefined;

	try {
		for (var _iterator2 = morphologyDataVerbs.participleStemmingClasses[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
			var participleClass = _step2.value;

			var regex = participleClass.regex;
			var startStem = participleClass.startStem;
			var endStem = participleClass.endStem;
			var separable = participleClass.separable;

			var prefixes = separable ? morphologyDataVerbs.verbPrefixesSeparable : morphologyDataVerbs.verbPrefixesInseparable;

			var stem = detectAndStemParticiplePerPrefixClass(word, prefixes, regex, startStem, endStem);

			if (stem) {
				return stem;
			}

			stem = detectAndStemParticiplePerPrefixClass(word, prefixesSeparableOrInseparable, regex, startStem, endStem);

			if (stem) {
				return stem;
			}
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

	return null;
};

/**
 * Detects whether a word is a regular participle and if so, returns the stem.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  word                The word (not stemmed) to check.
 *
 * @returns {string} The participle stem or null if no regular participle was matched.
 */
function detectAndStemRegularParticiple(morphologyDataVerbs, word) {
	if ((0, _regex.exceptions)(word).length > 0 || (0, _exceptionsParticiplesActive2.default)().includes(word)) {
		return "";
	}

	var stem = detectAndStemParticiplesWithoutPrefixes(morphologyDataVerbs, word);

	if (stem) {
		return stem;
	}

	stem = detectAndStemParticiplesWithPrefixes(morphologyDataVerbs, word);

	if (stem) {
		return stem;
	}

	return null;
}
//# sourceMappingURL=detectAndStemRegularParticiple.js.map
