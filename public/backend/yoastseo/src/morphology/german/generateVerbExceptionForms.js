"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.generateVerbExceptionForms = generateVerbExceptionForms;

var _suffixHelpers = require("../morphoHelpers/suffixHelpers");

var _lodashEs = require("lodash-es");

/**
 * Adds suffixes to a given strong verb paradigm.
 *
 * @param {Object}  dataStrongVerbs The German morphology data for strong verbs.
 * @param {string}  verbClass       The verb class of the paradigm.
 * @param {Object}  stems           The stems of the paradigm.
 *
 * @returns {string[]} The created forms.
 */
var addSuffixesStrongVerbParadigm = function addSuffixesStrongVerbParadigm(dataStrongVerbs, verbClass, stems) {
	// All classes have the same present and participle suffixes.
	var basicSuffixes = {
		present: dataStrongVerbs.suffixes.presentAllClasses.slice(),
		pastParticiple: new Array(dataStrongVerbs.suffixes.pastParticiple)
	};

	// Add class-specific suffixes.
	var additionalSuffixes = dataStrongVerbs.suffixes.classDependent[verbClass];
	var allSuffixes = _extends({}, basicSuffixes, additionalSuffixes);

	// Add the present and the past stem, since these can also be forms on their own.
	var forms = [stems.present, stems.past];

	(0, _lodashEs.forOwn)(stems, function (stem, stemClass) {
		forms.push(Array.isArray(stem) ? (0, _suffixHelpers.applySuffixesToStems)(stem, allSuffixes[stemClass]) : (0, _suffixHelpers.applySuffixesToStem)(stem, allSuffixes[stemClass]));
	});

	return (0, _lodashEs.uniq)((0, _lodashEs.flatten)(forms));
};

/**
 * Checks whether a verb falls into a given strong verb exception paradigm and if so,
 * returns the correct forms.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {Object}  paradigm            The current paradigm to generate forms for.
 * @param {string}  stemmedWordToCheck  The stem to check.
 *
 * @returns {string[]} The created verb forms.
 */
var generateFormsPerParadigm = function generateFormsPerParadigm(morphologyDataVerbs, paradigm, stemmedWordToCheck) {
	var verbClass = paradigm.class;
	var stems = paradigm.stems;

	var stemsFlattened = [];

	(0, _lodashEs.forOwn)(stems, function (stem) {
		return stemsFlattened.push(stem);
	});
	// Some stem types have two forms, which means that a stem type can also contain an array. These get flattened here.
	stemsFlattened = (0, _lodashEs.flatten)(stemsFlattened);

	/*
  * Sort in order to make sure that if the stem to check is e.g. "gehalt", "halt" isn't matched before "gehalt".
  * (Both are part of the same paradigm). Otherwise, if "halt" is matched, the "ge" will be interpreted as preceding
  * lexical material and added to all forms.
  */
	stemsFlattened = stemsFlattened.sort(function (a, b) {
		return b.length - a.length;
	});

	if (stemsFlattened.includes(stemmedWordToCheck)) {
		return addSuffixesStrongVerbParadigm(morphologyDataVerbs.strongVerbs, verbClass, stems);
	}

	return [];
};

/**
 * Checks whether a verb falls into one of the exception classes of strong verbs and if so,
 * returns the correct forms.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  stemmedWordToCheck  The stem to check.
 *
 * @returns {string[]} The created verb forms.
 */
var generateFormsStrongVerbs = function generateFormsStrongVerbs(morphologyDataVerbs, stemmedWordToCheck) {
	var stems = morphologyDataVerbs.strongVerbs.stems;

	var _iteratorNormalCompletion = true;
	var _didIteratorError = false;
	var _iteratorError = undefined;

	try {
		for (var _iterator = stems[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
			var paradigm = _step.value;

			var forms = generateFormsPerParadigm(morphologyDataVerbs, paradigm, stemmedWordToCheck);

			if (forms.length > 0) {
				return forms;
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

	return [];
};

/**
 * Checks whether a give stem stem falls into any of the verb exception categories and creates the
 * correct forms if that is the case.
 *
 * @param {Object}  morphologyDataVerbs The German morphology data for verbs.
 * @param {string}  stemmedWordToCheck  The stem to check.
 *
 * @returns {string[]} The created verb forms.
 */
function generateVerbExceptionForms(morphologyDataVerbs, stemmedWordToCheck) {
	var prefixes = morphologyDataVerbs.verbPrefixes;
	var stemmedWordToCheckWithoutPrefix = "";

	var foundPrefix = prefixes.find(function (prefix) {
		return stemmedWordToCheck.startsWith(prefix);
	});

	if (typeof foundPrefix === "string") {
		stemmedWordToCheckWithoutPrefix = stemmedWordToCheck.slice(foundPrefix.length);
	}

	// At least 3 characters so that e.g. "be" is not found in the stem "berg".
	if (stemmedWordToCheckWithoutPrefix.length > 2 && typeof foundPrefix === "string") {
		stemmedWordToCheck = stemmedWordToCheckWithoutPrefix;
	} else {
		// Reset foundPrefix so that it won't be attached when forms are generated.
		foundPrefix = null;
	}

	// Check exceptions with full forms.
	var exceptions = generateFormsStrongVerbs(morphologyDataVerbs, stemmedWordToCheck);

	// If the original stem had a verb prefix, attach it to the found exception forms.
	if (typeof foundPrefix === "string") {
		exceptions = exceptions.map(function (word) {
			return foundPrefix + word;
		});
	}

	if (exceptions.length > 0) {
		return exceptions;
	}

	return exceptions;
}
//# sourceMappingURL=generateVerbExceptionForms.js.map
