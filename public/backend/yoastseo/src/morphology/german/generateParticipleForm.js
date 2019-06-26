"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.generateParticipleForm = generateParticipleForm;
/**
 * Adds a prefix and a suffix to a stem in order to create a past participle form
 *
 * @param {string}  stemmedWord             The stemmed word for which to create the past participle form.
 * @param {Object}  affixes                 The suffix and prefix data.
 * @param {string}  [additionalPrefix = ""] An additional prefix to attach to the beginning of the participle.
 *
 * @returns {string} The participle form.
 */
var addParticipleAffixes = function addParticipleAffixes(stemmedWord, affixes) {
	var additionalPrefix = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";

	return additionalPrefix + affixes.prefix + stemmedWord + affixes.suffix;
};

/**
 * Generates past participle forms.
 *
 * @param {Object}  morphologyDataVerbs     The German morphology data for verbs.
 * @param {string}  stemmedWord             The stemmed word for which to generate the participle.
 *
 * @returns {string} A past participle form.
 */
var generateRegularParticipleForm = function generateRegularParticipleForm(morphologyDataVerbs, stemmedWord) {
	if (stemmedWord.endsWith("d") || stemmedWord.endsWith("t")) {
		return addParticipleAffixes(stemmedWord, morphologyDataVerbs.participleAffixes.stemEndsInDOrT);
	}

	return addParticipleAffixes(stemmedWord, morphologyDataVerbs.participleAffixes.regular);
};

/**
 * Generates participle forms with separable or separable/inseparable prefixes.
 *
 * @param {Object}      morphologyDataVerbs The German morphology data for verbs.
 * @param {string}      stemmedWord         The stem to check.
 * @param {string[]}    prefixes            The prefixes to check.
 *
 * @returns {string|null} The created participle form or null if the stem doesn't start with a prefix.
 */
var generateParticipleFormWithSeparablePrefix = function generateParticipleFormWithSeparablePrefix(morphologyDataVerbs, stemmedWord, prefixes) {
	var _iteratorNormalCompletion = true;
	var _didIteratorError = false;
	var _iteratorError = undefined;

	try {
		for (var _iterator = prefixes[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
			var currentPrefix = _step.value;

			if (stemmedWord.startsWith(currentPrefix)) {
				var stemmedWordWithoutPrefix = stemmedWord.slice(currentPrefix.length, stemmedWord.length);

				if (stemmedWord.endsWith("d") || stemmedWord.endsWith("t")) {
					return addParticipleAffixes(stemmedWordWithoutPrefix, morphologyDataVerbs.participleAffixes.stemEndsInDOrT, currentPrefix);
				}

				return addParticipleAffixes(stemmedWordWithoutPrefix, morphologyDataVerbs.participleAffixes.regular, currentPrefix);
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
 * Generates participle forms for a given stem.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  stemmedWord         The stem to check.
 *
 * @returns {string} The created participle form.
 */
function generateParticipleForm(morphologyDataVerbs, stemmedWord) {
	var participleFormWithPrefix = generateParticipleFormWithSeparablePrefix(morphologyDataVerbs, stemmedWord, morphologyDataVerbs.verbPrefixesSeparable);

	if (participleFormWithPrefix) {
		return participleFormWithPrefix;
	}

	/*
  * Check forms with a separable/non-separable prefix used in its separable form, e.g. ("überkochen" - "übergekocht")
  * For its these prefixes used in the inseparable form, the resulting participle would be the same as
  * the 3rd person singular, so we don't need to create a separate form here (e.g., "überführen" - "überführt").
  */
	participleFormWithPrefix = generateParticipleFormWithSeparablePrefix(morphologyDataVerbs, stemmedWord, morphologyDataVerbs.verbPrefixesSeparableOrInseparable);

	if (participleFormWithPrefix) {
		return participleFormWithPrefix;
	}

	return generateRegularParticipleForm(morphologyDataVerbs, stemmedWord);
}
//# sourceMappingURL=generateParticipleForm.js.map
