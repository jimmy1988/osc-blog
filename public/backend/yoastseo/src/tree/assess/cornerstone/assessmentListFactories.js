"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
/**
 * Factory functions for creating lists of assessments for cornerstone content.
 *
 * To be used in creating the different kinds of assessors.
 */

/**
 * Creates a new list of SEO assessments.
 *
 * @returns {module:tree/assess.Assessment[]} The list of SEO assessments.
 *
 * @private
 * @memberOf module:tree/assess
 */
var constructSEOAssessments = function constructSEOAssessments() {
  return [
    // Needs to be populated by fancy new assessments that work on the tree representation of the text.
  ];
};

/**
 * Creates a new list of readability assessments.
 *
 * @returns {module:tree/assess.Assessment[]} The list of readability assessments.
 *
 * @private
 * @memberOf module:tree/assess
 */
var constructReadabilityAssessments = function constructReadabilityAssessments() {
  return [
    // Needs to be populated by fancy new assessments that work on the tree representation of the text.
  ];
};

/**
 * Creates a new list of SEO assessments for related keyphrases.
 *
 * @returns {module:tree/assess.Assessment[]} The list of SEO assessments.
 *
 * @private
 * @memberOf module:tree/assess
 */
var constructRelatedKeyphraseAssessments = function constructRelatedKeyphraseAssessments() {
  return [
    // Needs to be populated by fancy new assessments that work on the tree representation of the text.
  ];
};

exports.constructSEOAssessments = constructSEOAssessments;
exports.constructReadabilityAssessments = constructReadabilityAssessments;
exports.constructRelatedKeyphraseAssessments = constructRelatedKeyphraseAssessments;
//# sourceMappingURL=assessmentListFactories.js.map
