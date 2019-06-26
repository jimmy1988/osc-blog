"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.getSuffixesComparative = getSuffixesComparative;
exports.getSuffixesSuperlative = getSuffixesSuperlative;
exports.addRegularSuffixes = addRegularSuffixes;
exports.addComparativeSuffixes = addComparativeSuffixes;
exports.addSuperlativeSuffixes = addSuperlativeSuffixes;
exports.addAllAdjectiveSuffixes = addAllAdjectiveSuffixes;

var _lodashEs = require("lodash-es");

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

/**
 * Returns a set of comparative suffixes depending on the ending of the stem.
 *
 * @param {Object}  morphologyDataAdjectives    The German morphology data for adjectives.
 * @param {string}  stemmedWord                 The stemmed word for which to get suffixes.
 *
 * @returns {string[]} The correct comparative suffixes for the given stem.
 */
function getSuffixesComparative(morphologyDataAdjectives, stemmedWord) {
  var takesREnding = morphologyDataAdjectives.takesComparativeREnding.slice();

  if (takesREnding.some(function (ending) {
    return stemmedWord.endsWith(ending);
  })) {
    return morphologyDataAdjectives.comparativeSuffixesR;
  }

  return morphologyDataAdjectives.comparativeSuffixesEr;
}

/**
 * Returns a set of superlative suffixes depending on the ending of the stem.
 *
 * @param {Object}  morphologyDataAdjectives    The German morphology data for adjectives.
 * @param {string}  stemmedWord                 The stemmed word for which to get suffixes.
 *
 * @returns {string[]} The correct superlative suffixes for the given stem.
 */
function getSuffixesSuperlative(morphologyDataAdjectives, stemmedWord) {
  var takesEstEnding = morphologyDataAdjectives.takesSuperlativeEstEnding.slice();

  if (takesEstEnding.some(function (ending) {
    return stemmedWord.endsWith(ending);
  })) {
    return morphologyDataAdjectives.superlativeSuffixesEst;
  }

  return morphologyDataAdjectives.superlativeSuffixesSt;
}

/**
 * Adds all regular declension suffixes to a stem.
 *
 * @param {Object}      morphologyDataAdjectives    The German morphology data for adjectives.
 * @param {string}      stemmedWord                 The stemmed word for which to get suffixes.
 *
 * @returns {string[]} The suffixed adjective forms.
 */
function addRegularSuffixes(morphologyDataAdjectives, stemmedWord) {
  var regularSuffixes = morphologyDataAdjectives.regularSuffixes.slice();

  return (0, _lodashEs.uniq)(regularSuffixes.map(function (suffix) {
    return stemmedWord.concat(suffix);
  }));
}

/**
 * Adds suffixes for comparative forms to a stem.
 *
 * @param {Object}      morphologyDataAdjectives    The German morphology data for adjectives.
 * @param {string}      stemmedWord                 The stemmed word for which to get suffixes.
 *
 * @returns {string[]} The suffixed adjective forms.
 */
function addComparativeSuffixes(morphologyDataAdjectives, stemmedWord) {
  var comparativeSuffixes = getSuffixesComparative(morphologyDataAdjectives, stemmedWord);

  return comparativeSuffixes.map(function (suffix) {
    return stemmedWord.concat(suffix);
  });
}

/**
 * Adds suffixes for comparative and superlative forms to a stem.
 *
 * @param {Object}      morphologyDataAdjectives    The German morphology data for adjectives.
 * @param {string}      stemmedWord                 The stemmed word for which to get suffixes.
 *
 * @returns {string[]} The suffixed adjective forms.
 */
function addSuperlativeSuffixes(morphologyDataAdjectives, stemmedWord) {
  var superlativeSuffixes = getSuffixesSuperlative(morphologyDataAdjectives, stemmedWord);

  return superlativeSuffixes.map(function (suffix) {
    return stemmedWord.concat(suffix);
  });
}

/**
 * Adds regular declension suffixes as well as suffixes for comparative and superlative forms to a stem.
 *
 * @param {Object}      morphologyDataAdjectives    The German morphology data for adjectives.
 * @param {string}      stemmedWord                 The stemmed word for which to get suffixes.
 *
 * @returns {string[]} The suffixed adjective forms.
 */
function addAllAdjectiveSuffixes(morphologyDataAdjectives, stemmedWord) {
  var regularSuffixes = morphologyDataAdjectives.regularSuffixes.slice();
  var comparativeSuffixes = getSuffixesComparative(morphologyDataAdjectives, stemmedWord);
  var superlativeSuffixes = getSuffixesSuperlative(morphologyDataAdjectives, stemmedWord);
  var suffixesToAdd = [].concat(_toConsumableArray(regularSuffixes), _toConsumableArray(comparativeSuffixes), _toConsumableArray(superlativeSuffixes));

  return (0, _lodashEs.uniq)(suffixesToAdd.map(function (suffix) {
    return stemmedWord.concat(suffix);
  }));
}
//# sourceMappingURL=addAdjectiveSuffixes.js.map
