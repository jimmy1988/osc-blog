"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

exports.generateNounExceptionForms = generateNounExceptionForms;
/**
 * Checks whether a stemmed word is on the exception list for which we have full forms.
 *
 * @param {Array} exceptionStems        The exception stems to check against.
 * @param {string} stemmedWordToCheck   The stem to check.
 *
 * @returns {string[]} The created word forms.
 */
var checkStemsFromExceptionList = function checkStemsFromExceptionList(exceptionStems, stemmedWordToCheck) {
	for (var i = 0; i < exceptionStems.length; i++) {
		var currentStemDataSet = exceptionStems[i];

		var stemPairToCheck = currentStemDataSet[0];

		for (var j = 0; j < stemPairToCheck.length; j++) {
			var exceptionStemMatched = stemmedWordToCheck.endsWith(stemPairToCheck[j]);

			// Check if the stemmed word ends in one of the stems of the exception list.
			if (exceptionStemMatched === true) {
				var _ret = function () {
					// "Haupt".length = "Hauptstadt".length - "stadt".length
					var precedingLength = stemmedWordToCheck.length - stemPairToCheck[j].length;
					var precedingLexicalMaterial = stemmedWordToCheck.slice(0, precedingLength);
					/*
     	 * If the word is a compound, removing the final stem will result in some lexical material to
     	 * be left over at the beginning of the word. For example, removing "stadt" from "Hauptstadt"
     	 * leaves "Haupt". This lexical material is the base for the word forms that need to be created
     	 * (e.g., "Hauptstädte").
     	 */
					if (precedingLexicalMaterial.length > 0) {
						var stemsToReturn = currentStemDataSet[1];
						return {
							v: stemsToReturn.map(function (currentStem) {
								return precedingLexicalMaterial.concat(currentStem);
							})
						};
					}
					/*
      * Return all possible stems since apparently the word that's being checked is equal to the stem on the
      * exception list that's being checked.
      */
					return {
						v: currentStemDataSet[1]
					};
				}();

				if ((typeof _ret === "undefined" ? "undefined" : _typeof(_ret)) === "object") return _ret.v;
			}
		}
	}

	return [];
};

/**
 * Checks whether a stemmed word has an ending for which we can predict possible suffix forms.
 *
 * @param {array} exceptionCategory     The exception category to check.
 * @param {string} stemmedWordToCheck   The stem to check.
 *
 * @returns {string[]} The created word forms.
 */
var checkStemsWithPredictableSuffixes = function checkStemsWithPredictableSuffixes(exceptionCategory, stemmedWordToCheck) {
	// There are some exceptions to this rule. If the current stem falls into this category, the rule doesn't apply.
	var exceptionsToTheException = exceptionCategory[2];

	if (exceptionsToTheException.some(function (ending) {
		return stemmedWordToCheck.endsWith(ending);
	})) {
		return [];
	}

	var exceptionStems = exceptionCategory[0];

	// Return forms of stemmed word with appended suffixes.
	if (exceptionStems.some(function (ending) {
		return stemmedWordToCheck.endsWith(ending);
	})) {
		var suffixes = exceptionCategory[1];

		return suffixes.map(function (suffix) {
			return stemmedWordToCheck.concat(suffix);
		});
	}

	return [];
};

/**
 * Checks whether a give stem stem falls into any of the noun exception categories and creates the
 * correct forms if that is the case.
 *
 * @param {Object}  morphologyDataNouns The German morphology data for nouns.
 * @param {string}  stemmedWordToCheck  The stem to check.
 *
 * @returns {string[]} The created word forms.
 */
function generateNounExceptionForms(morphologyDataNouns, stemmedWordToCheck) {
	// Check exceptions with full forms.
	var exceptions = checkStemsFromExceptionList(morphologyDataNouns.exceptionStemsWithFullForms, stemmedWordToCheck);

	if (exceptions.length > 0) {
		return exceptions;
	}

	// Check exceptions with predictable suffixes.
	var exceptionsStemsPredictableSuffixes = morphologyDataNouns.exceptionsStemsPredictableSuffixes;

	var _iteratorNormalCompletion = true;
	var _didIteratorError = false;
	var _iteratorError = undefined;

	try {
		for (var _iterator = Object.keys(exceptionsStemsPredictableSuffixes)[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
			var key = _step.value;

			exceptions = checkStemsWithPredictableSuffixes(exceptionsStemsPredictableSuffixes[key], stemmedWordToCheck);
			if (exceptions.length > 0) {
				// For this class of words, the stemmed word is the singular form and therefore needs to be added.
				exceptions.push(stemmedWordToCheck);
				return exceptions;
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

	return exceptions;
}
//# sourceMappingURL=generateNounExceptionForms.js.map
