"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.addVerbSuffixes = addVerbSuffixes;

var _suffixHelpers = require("../morphoHelpers/suffixHelpers");

var endsInDT = /[dt]$/;
var endsInConsMN = /[tkbdgzfv][mn]$/;
var endsInChMN = /ch[mn]$/;
var endsInSZT = /[szßt]$/;
var endsInNonVerbEnding = /[aoycjw]$/;

/**
 * Adds verb suffixes to a stem. Depending on the ending of the stem, the list of suffixes might be modified.
 *
 * @param {Object}  morphologyDataVerbs     The German morphology data for verbs.
 * @param {string}  stemmedWord             The stemmed word on which to apply the suffixes.
 *
 * @returns {string[]} The suffixed verb forms.
 */
function addVerbSuffixes(morphologyDataVerbs, stemmedWord) {
	var allVerbSuffixes = morphologyDataVerbs.verbSuffixes.slice();

	// Check whether the stem has an ending that only takes suffixes starting in e-.
	if (endsInDT.test(stemmedWord) || endsInConsMN.test(stemmedWord) || endsInChMN.test(stemmedWord)) {
		allVerbSuffixes = allVerbSuffixes.filter(function (suffix) {
			return suffix.startsWith("e");
		});

		return (0, _suffixHelpers.applySuffixesToStem)(stemmedWord, allVerbSuffixes);
	}

	// Check whether the stem has an ending that doesn't take the suffix -st.
	if (endsInSZT.test(stemmedWord)) {
		allVerbSuffixes = allVerbSuffixes.filter(function (suffix) {
			return suffix !== "st";
		});

		return (0, _suffixHelpers.applySuffixesToStem)(stemmedWord, allVerbSuffixes);
	}

	// Check whether the stem has an ending that marks it as a non-verbal stem.
	if (endsInNonVerbEnding.test(stemmedWord)) {
		return [];
	}

	return (0, _suffixHelpers.applySuffixesToStem)(stemmedWord, allVerbSuffixes);
}
//# sourceMappingURL=addVerbSuffixes.js.map
