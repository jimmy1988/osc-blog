"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.constructReadabilityAssessor = exports.constructSEOAssessor = undefined;

var _assessmentListFactories = require("./assessmentListFactories");

var _assessmentListFactories2 = require("./cornerstone/assessmentListFactories");

var _scoreAggregators = require("./scoreAggregators");

var _TreeAssessor = require("./TreeAssessor");

var _TreeAssessor2 = _interopRequireDefault(_TreeAssessor);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Maps combinations of assessor parameters (if the assessor is for related keyphrases, cornerstone content and/or taxonomy pages)
 * to functions that generate a list of applicable assessments.
 *
 * @const
 * @private
 * @type {Object}
 */


/* Score aggregators */
/* Assessment list factories. */
var SEO_ASSESSMENTS_MAP = {
	Default: _assessmentListFactories.constructSEOAssessments,

	RelatedKeyphrase: _assessmentListFactories.constructRelatedKeyphraseAssessments,
	Taxonomy: _assessmentListFactories.constructTaxonomyAssessments,
	RelatedKeyphraseTaxonomy: _assessmentListFactories.constructRelatedKeyphraseTaxonomyAssessments,

	Cornerstone: _assessmentListFactories2.constructSEOAssessments,
	CornerstoneRelatedKeyphrase: _assessmentListFactories2.constructRelatedKeyphraseAssessments
};

/**
 * Constructs a new SEO assessor.
 *
 * @param {Jed}                                 i18n       The Jed object to use for localization / internalization.
 * @param {module:tree/research.TreeResearcher} researcher The researcher the assessments need to use to get information about the text.
 *
 * @param {Object}                              config                    The assessor configuration.
 * @param {boolean}                             [config.relatedKeyphrase] If this assessor is for a related keyphrase, instead of the main one.
 * @param {boolean}                             [config.taxonomy]         If this assessor is for a taxonomy page, instead of a regular page.
 * @param {boolean}                             [config.cornerstone]      If this assessor is for cornerstone content.
 *
 * @returns {module:tree/assess.TreeAssessor} The created SEO assessor.
 *
 * @throws {Error} An error when no assessor exists for the given combination of configuration options.
 *
 * @memberOf module:tree/assess
 */


/* Base TreeAssessor class */
var constructSEOAssessor = function constructSEOAssessor(i18n, researcher, config) {
	/*
  * Construct the key to retrieve the right assessment list factory.
  * E.g. "RelatedKeyphraseTaxonomy" for related keyphrase + taxonomy;
  */
	var cornerstone = config.cornerstone ? "Cornerstone" : "";
	var relatedKeyphrase = config.relatedKeyphrase ? "RelatedKeyphrase" : "";
	var taxonomy = config.taxonomy ? "Taxonomy" : "";

	// (Empty key defaults to "Default" key)
	var key = [cornerstone, relatedKeyphrase, taxonomy].join("") || "Default";

	// Retrieve the assessment list factory.
	var assessmentFactory = SEO_ASSESSMENTS_MAP[key];

	// This specific combination of cornerstone, taxonomy and related keyphrase does not exist.
	if (!assessmentFactory) {
		throw new Error("Cannot make an assessor based on the provided combination of configuration options");
	}

	// Construct assessor.
	var assessments = assessmentFactory();
	var scoreAggregator = new _scoreAggregators.SEOScoreAggregator();
	return new _TreeAssessor2.default({ i18n: i18n, researcher: researcher, assessments: assessments, scoreAggregator: scoreAggregator });
};

/**
 * Constructs a new readability assessor.
 *
 * @param {Jed}                                 i18n                 The Jed object to use for localization / internalization.
 * @param {module:tree/research.TreeResearcher} researcher           The researcher the assessments need to use to get information about the text.
 * @param {boolean}                             isCornerstoneContent If the to be analyzed content is considered cornerstone content
 * (which uses stricter boundaries).
 *
 * @returns {module:tree/assess.TreeAssessor} The created readability assessor.
 *
 * @memberOf module:tree/assess
 */
var constructReadabilityAssessor = function constructReadabilityAssessor(i18n, researcher) {
	var isCornerstoneContent = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

	var assessments = isCornerstoneContent ? (0, _assessmentListFactories.constructReadabilityAssessments)() : (0, _assessmentListFactories2.constructReadabilityAssessments)();
	var scoreAggregator = new _scoreAggregators.ReadabilityScoreAggregator();
	return new _TreeAssessor2.default({ i18n: i18n, researcher: researcher, assessments: assessments, scoreAggregator: scoreAggregator });
};

exports.constructSEOAssessor = constructSEOAssessor;
exports.constructReadabilityAssessor = constructReadabilityAssessor;
//# sourceMappingURL=assessorFactories.js.map
