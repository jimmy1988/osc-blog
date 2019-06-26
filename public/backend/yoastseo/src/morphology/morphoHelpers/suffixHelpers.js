"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.applySuffixesToStem = applySuffixesToStem;
exports.applySuffixesToStems = applySuffixesToStems;
/**
 * Creates word forms from a list of given suffixes and a stem.
 *
 * @param {string}      stem                The stem on which to apply the suffixes.
 * @param {string[]}    suffixes            The suffixes to apply.
 * @param {string}      [appendToStem=""]   Optional material to append between the stem and the suffixes.
 *
 * @returns {string[]} The suffixed verb forms.
 */
function applySuffixesToStem(stem, suffixes) {
  var appendToStem = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";

  return suffixes.map(function (suffix) {
    return stem + appendToStem + suffix;
  });
}

/**
 * Creates word forms by appending all given suffixes on each of the given stems.
 *
 * @param {string[]}    stems               The stems on which to apply the suffixes.
 * @param {string[]}    suffixes            The suffixes to apply.
 * @param {string}      [appendToStem=""]   Optional material to append between the stem and the suffixes.
 *
 * @returns {string[]} The suffixed verb forms.
 */
function applySuffixesToStems(stems, suffixes) {
  var appendToStem = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";

  return stems.reduce(function (list, stem) {
    var stemWithSuffixes = applySuffixesToStem(stem, suffixes, appendToStem);
    return list.concat(stemWithSuffixes);
  }, []);
}
//# sourceMappingURL=suffixHelpers.js.map
