"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _AssessmentResult = require("../../values/AssessmentResult");

var _AssessmentResult2 = _interopRequireDefault(_AssessmentResult);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Analyzes a paper by doing a list of assessments on a tree representation of a text and its metadata.
 * Aggregates the scores on each individual assessment into an overall score.
 *
 * This score can represent anything from the readability to the SEO of the given text and metadata.
 *
 * @memberOf module:tree/assess
 */
var TreeAssessor = function () {
	/**
  * Creates a new assessor.
  *
  * @param {Object}                              options                 Assessor options.
  * @param {Jed}                                 options.i18n            A Jed object to use for translations.
  * @param {module:tree/research.TreeResearcher} options.researcher      Supplies the assessments with researches and their (cached) results.
  * @param {module:tree/assess.ScoreAggregator}  options.scoreAggregator Aggregates the scores on the individual assessments into one.
  * @param {module:tree/assess.Assessment[]}     [options.assessments]   The list of assessments to apply.
  */
	function TreeAssessor(options) {
		var _this = this;

		_classCallCheck(this, TreeAssessor);

		/**
   * A Jed object to use for translations.
   * @type {Jed}
   */
		this.i18n = options.i18n;
		/**
   * Supplies the assessments with researches and their (cached) results.
   * @type {module:tree/research.TreeResearcher}
   */
		this.researcher = options.researcher;
		/**
   * Aggregates the scores on the individual assessments into one overall score.
   * @type {module:tree/assess.ScoreAggregator}
   */
		this.scoreAggregator = options.scoreAggregator;
		/**
   * The list of assessments to apply.
   * @type {module:tree/assess.Assessment[]}
   */
		this._assessments = options.assessments || [];
		// Make sure that all of the assessments have the researcher.
		this._assessments.forEach(function (assessment) {
			return assessment.setResearcher(_this.researcher);
		});
	}

	/**
  * Returns the list of available assessments.
  *
  * @returns {module:tree/assess.Assessment[]} The list of all available assessments.
  */


	_createClass(TreeAssessor, [{
		key: "getAssessments",
		value: function getAssessments() {
			return this._assessments;
		}

		/**
   * Assesses the given text by applying all the assessments to it
   * and aggregating the resulting scores.
   *
   * @param {Paper}                      paper The paper to assess. This contains metadata about the text.
   * @param {module:tree/structure.Node} node  The root node of the tree to check.
   *
   * @returns {Promise<{results: AssessmentResult[], score: number}>} The assessment results and the overall score.
   */

	}, {
		key: "assess",
		value: async function assess(paper, node) {
			var _this2 = this;

			var applicableAssessments = await this.getApplicableAssessments(paper, node);
			/*
     Apply every applicable assessment on the document.
     Wait before they are done before aggregating the results
     and returning the results and final score.
    */
			var results = await Promise.all(applicableAssessments.map(function (assessment) {
				return _this2.applyAssessment(assessment, paper, node);
			}));
			// Filter out errored assessments.
			var validResults = results.filter(function (result) {
				return result.getScore() !== -1;
			});
			// Compute overall score.
			var score = this.scoreAggregator.aggregate(validResults);

			return { results: results, score: score };
		}

		/**
   * Applies the given assessment to the paper-node combination.
   *
   * @param {module:tree/assess.Assessment} assessment The assessment to apply.
   * @param {Paper}                         paper      The paper to apply the assessment to.
   * @param {module:tree/structure.Node}    node       The root node of the tree to apply the assessment to.
   *
   * @returns {Promise<AssessmentResult>} The result of the assessment.
   */

	}, {
		key: "applyAssessment",
		value: async function applyAssessment(assessment, paper, node) {
			var _this3 = this;

			return assessment.apply(paper, node).catch(function () {
				return new _AssessmentResult2.default({
					text: _this3.i18n.sprintf(
					/* Translators: %1$s expands to the name of the assessment. */
					_this3.i18n.dgettext("js-text-analysis", "An error occurred in the '%1$s' assessment"), assessment.name),
					score: -1
				});
			});
		}

		/**
   * Adds the assessment to the list of assessments to apply.
   *
   * @param {string}                        name       The name to register the assessment under.
   * @param {module:tree/assess.Assessment} assessment The assessment to add.
   *
   * @returns {void}
   */

	}, {
		key: "registerAssessment",
		value: function registerAssessment(name, assessment) {
			assessment.name = name;
			assessment.setResearcher(this.researcher);
			this._assessments.push(assessment);
		}

		/**
   * Removes the assessment registered under the given name, if it exists.
   *
   * @param {string} name The name of the assessment to remove.
   *
   * @returns {module:tree/assess.Assessment|null} The deleted assessment, or null if no assessment has been deleted.
   */

	}, {
		key: "removeAssessment",
		value: function removeAssessment(name) {
			var index = this._assessments.findIndex(function (assessment) {
				return assessment.name === name;
			});
			if (index > -1) {
				var deleted = this._assessments.splice(index, 1);
				return deleted[0];
			}
			return null;
		}

		/**
   * Returns the assessment registered under the given name.
   * Returns `null` if no assessment is registered under the given name.
   *
   * @param {string} name The name of the assessment to get.
   *
   * @returns {Assessment|null} The assessment.
   */

	}, {
		key: "getAssessment",
		value: function getAssessment(name) {
			var assessmentToReturn = this._assessments.find(function (assessment) {
				return assessment.name === name;
			});
			return assessmentToReturn ? assessmentToReturn : null;
		}

		/**
   * Sets the assessments that this assessor needs to apply.
   *
   * @param {module:tree/assess.Assessment[]} assessments The assessments to set.
   *
   * @returns {void}
   */

	}, {
		key: "setAssessments",
		value: function setAssessments(assessments) {
			this._assessments = assessments;
		}

		/**
   * Returns the list of applicable assessments.
   *
   * @param {Paper}                      paper The paper to check.
   * @param {module:tree/structure.Node} node  The tree to check.
   *
   * @returns {Promise<Array>} The list of applicable assessments.
   */

	}, {
		key: "getApplicableAssessments",
		value: async function getApplicableAssessments(paper, node) {
			// List to store the applicable assessments in (empty for now).
			var applicableAssessments = [];

			// Asynchronously add each assessment to the list if they are applicable.
			var promises = this._assessments.map(function (assessment) {
				return assessment.isApplicable(paper, node).then(function (applicable) {
					if (applicable) {
						applicableAssessments.push(assessment);
					}
				});
			});

			// Wait before all the applicable assessments have been added before returning them.
			return Promise.all(promises).then(function () {
				return applicableAssessments;
			});
		}
	}]);

	return TreeAssessor;
}();

exports.default = TreeAssessor;
//# sourceMappingURL=TreeAssessor.js.map
