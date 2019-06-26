"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.generateAdjectiveExceptionForms = generateAdjectiveExceptionForms;

var _addAdjectiveSuffixes = require("./addAdjectiveSuffixes");

var _lodashEs = require("lodash-es");

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

/**
 *  Returns forms for adjectives ending in -el that get superlative suffixes on first stem (e.g., flexibel-st)
 *  and regular and comparative suffixes on the second stem (e.g., flexibl-e, flexibl-er).
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var elStemChange = function elStemChange(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.elStemChange;

	for (var i = 0; i < exceptionStems.length; i++) {
		var stemPairToCheck = exceptionStems[i];

		if (stemPairToCheck.includes(stemmedWordToCheck)) {
			return [stemPairToCheck[0]].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addSuperlativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[0])), _toConsumableArray((0, _addAdjectiveSuffixes.addRegularSuffixes)(morphologyDataAdjectives, stemPairToCheck[1])), _toConsumableArray((0, _addAdjectiveSuffixes.addComparativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1])));
		}
	}

	return [];
};

/**
 * Returns forms for adjectives ending in -er. These get the -er re-attached after the stemmer has deleted it and
 * subsequently get all suffixes attached.
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var erOnlyRestoreEr = function erOnlyRestoreEr(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.erOnlyRestoreEr;

	if (exceptionStems.includes(stemmedWordToCheck)) {
		/*
   * Since the stemmer incorrectly removes -er, we need to add it again here. Subsequently we add
   * all adjective endings to the stem with the restored -er.
   */
		return [stemmedWordToCheck.concat("er")].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addAllAdjectiveSuffixes)(morphologyDataAdjectives, stemmedWordToCheck.concat("er"))));
	}

	return [];
};

/**
 * Returns forms for adjectives ending in -er that have two stems: the -er stem gets restored and receives
 * regular and superlative endings (e.g., makaber-e, makaber-ste ); the -r stem receives comparative endings (e.g., makabr-er).
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var erStemChangeClass1 = function erStemChangeClass1(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.erStemChangeClass1;

	for (var i = 0; i < exceptionStems.length; i++) {
		var stemPairToCheck = exceptionStems[i];

		if (stemPairToCheck.includes(stemmedWordToCheck)) {
			return (0, _lodashEs.uniq)([stemPairToCheck[0].concat("er")].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addRegularSuffixes)(morphologyDataAdjectives, stemPairToCheck[0].concat("er"))), _toConsumableArray((0, _addAdjectiveSuffixes.addSuperlativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[0].concat("er"))), _toConsumableArray((0, _addAdjectiveSuffixes.addComparativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1]))));
		}
	}

	return [];
};

/**
 * Returns forms for adjectives ending in -er that have two stems: the -er stem gets restored and
 * receives superlative endings (e.g., sauer-ste) the -r stem receives regular and comparative endings
 * (e.g., saur-e, saur-er).
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var erStemChangeClass2 = function erStemChangeClass2(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.erStemChangeClass2;

	for (var i = 0; i < exceptionStems.length; i++) {
		var stemPairToCheck = exceptionStems[i];

		if (stemPairToCheck.includes(stemmedWordToCheck)) {
			return (0, _lodashEs.uniq)([stemPairToCheck[0].concat("er")].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addSuperlativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[0].concat("er"))), _toConsumableArray((0, _addAdjectiveSuffixes.addRegularSuffixes)(morphologyDataAdjectives, stemPairToCheck[1])), _toConsumableArray((0, _addAdjectiveSuffixes.addComparativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1]))));
		}
	}

	return [];
};

/**
 * Returns forms for adjectives ending in -er that have two stems: the -er stem gets restored and receives regular,
 * comparative and superlative endings (e.g., finster-e, finster-er, finster-ste); the -r stem receives comparative endings
 * (e.g., finstr-er).
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var erStemChangeClass3 = function erStemChangeClass3(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.erStemChangeClass3;

	for (var i = 0; i < exceptionStems.length; i++) {
		var stemPairToCheck = exceptionStems[i];

		if (stemPairToCheck.includes(stemmedWordToCheck)) {
			return (0, _lodashEs.uniq)([stemPairToCheck[0].concat("er")].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addAllAdjectiveSuffixes)(morphologyDataAdjectives, stemPairToCheck[0].concat("er"))), _toConsumableArray((0, _addAdjectiveSuffixes.addComparativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1]))));
		}
	}

	return [];
};

/**
 * Returns forms for adjectives that get the regular suffixes on their first stem (e.g., gesund-e) and the comparative and
 * superlative suffixes on their second stem (e.g., gesünd-er, gesünd-est).
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var secondStemCompSup = function secondStemCompSup(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.secondStemCompSup;

	for (var i = 0; i < exceptionStems.length; i++) {
		var stemPairToCheck = exceptionStems[i];

		if (stemPairToCheck.includes(stemmedWordToCheck)) {
			return (0, _lodashEs.uniq)([].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addRegularSuffixes)(morphologyDataAdjectives, stemPairToCheck[0])), _toConsumableArray((0, _addAdjectiveSuffixes.addComparativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1])), _toConsumableArray((0, _addAdjectiveSuffixes.addSuperlativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1]))));
		}
	}

	return [];
};

/**
 * Returns forms for adjectives that get all suffixes on the first stem (e.g., blass-e, blass-er, blass-est)
 * and only the comparative and superlative suffixes on the second (bläss-er, bläss-est).
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
var bothStemsComSup = function bothStemsComSup(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionStems = morphologyDataAdjectives.bothStemsCompSup;

	for (var i = 0; i < exceptionStems.length; i++) {
		var stemPairToCheck = exceptionStems[i];

		if (stemPairToCheck.includes(stemmedWordToCheck)) {
			return (0, _lodashEs.uniq)([].concat(_toConsumableArray((0, _addAdjectiveSuffixes.addAllAdjectiveSuffixes)(morphologyDataAdjectives, stemPairToCheck[0])), _toConsumableArray((0, _addAdjectiveSuffixes.addComparativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1])), _toConsumableArray((0, _addAdjectiveSuffixes.addSuperlativeSuffixes)(morphologyDataAdjectives, stemPairToCheck[1]))));
		}
	}

	return [];
};

/**
 * Checks whether a give stem stem falls into any of the adjective exception categories and creates the
 * correct forms if that is the case.
 *
 * @param {Object}  morphologyDataAdjectives The German morphology data for adjectives.
 * @param {string}  stemmedWordToCheck       The stem to check.
 *
 * @returns {string[]} The created adjective forms.
 */
function generateAdjectiveExceptionForms(morphologyDataAdjectives, stemmedWordToCheck) {
	var exceptionChecks = [elStemChange, erOnlyRestoreEr,
	/*
  * Within the group of adjectives ending in -er with two stems, there are different classes
  * of adjectives with regards to what endings they get on which stem.
  */
	erStemChangeClass1, erStemChangeClass2, erStemChangeClass3, secondStemCompSup, bothStemsComSup];

	for (var i = 0; i < exceptionChecks.length; i++) {
		var exceptions = exceptionChecks[i](morphologyDataAdjectives, stemmedWordToCheck);
		if (exceptions.length > 0) {
			return exceptions;
		}
	}

	return [];
}
//# sourceMappingURL=generateAdjectiveExceptionForms.js.map
