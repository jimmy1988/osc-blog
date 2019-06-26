"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.READABILITY_SCORES = undefined;

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _interpreters = require("../../../interpreters");

var _ScoreAggregator2 = require("./ScoreAggregator");

var _ScoreAggregator3 = _interopRequireDefault(_ScoreAggregator2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/* Internal dependencies */


/**
 * Total number of available readability assessments.
 *
 * @type {number}
 * @const
 *
 * @memberOf module:tree/assess
 */
var TOTAL_NR_OF_ASSESSMENTS = 8;

/**
 * Penalties that can be given on each assessment
 * when all assessments are currently supported
 * for the user's language.
 *
 * @type {{ok: number, bad: number, good: number}}
 * @const
 *
 * @memberOf module:tree/assess
 */
var PENALTY_MAPPING_FULL_SUPPORT = {
	bad: 3,
	ok: 2,
	good: 0
};

/**
 * Penalties that can be given on each assessment
 * when only a part of the assessments are currently supported
 * for the user's language.
 *
 * @type {{ok: number, bad: number, good: number}}
 * @const
 *
 * @memberOf module:tree/assess
 */
var PENALTY_MAPPING_PARTIAL_SUPPORT = {
	bad: 4,
	ok: 2,
	good: 0
};

/**
 * The scores that can be given on the readability analysis.
 *
 * @type {{GOOD: number, OKAY: number, NEEDS_IMPROVEMENT: number}}
 * @const
 *
 * @memberOf module:tree/assess
 */
var READABILITY_SCORES = exports.READABILITY_SCORES = {
	GOOD: 90,
	OKAY: 60,
	NEEDS_IMPROVEMENT: 30
};

/**
 * Aggregates the results of the readability analysis into a single score.
 *
 * @memberOf module:tree/assess
 */

var ReadabilityScoreAggregator = function (_ScoreAggregator) {
	_inherits(ReadabilityScoreAggregator, _ScoreAggregator);

	function ReadabilityScoreAggregator() {
		_classCallCheck(this, ReadabilityScoreAggregator);

		return _possibleConstructorReturn(this, (ReadabilityScoreAggregator.__proto__ || Object.getPrototypeOf(ReadabilityScoreAggregator)).apply(this, arguments));
	}

	_createClass(ReadabilityScoreAggregator, [{
		key: "isFullySupported",

		/**
   * Determines whether a language is fully supported. If a language supports 8 content assessments
   * it is fully supported.
   *
   * @param {AssessmentResult[]} results The list of results.
   *
   * @returns {boolean} True if fully supported.
   */
		value: function isFullySupported(results) {
			/*
    * Apparently, we check whether an assessment is applicable
    * as a way to check if it is supported for the current language.
    *
    * Although we do check whether a language is supported in some readability assessments,
    * we also check whether papers have text to analyze among other things.
    *
    * Since only applicable assessments are applied, we only get the results
    * of applicable assessments either way. So this check suffices.
    */
			return results.length === TOTAL_NR_OF_ASSESSMENTS;
		}

		/**
   * Calculates the overall score (GOOD, OKAY or NEEDS IMPROVEMENT)
   * based on the penalty.
   *
   * @param {boolean} isFullySupported Whether this language is fully supported.
   * @param {number}  penalty          The total penalty.
   *
   * @returns {number} The overall score.
   */

	}, {
		key: "calculateScore",
		value: function calculateScore(isFullySupported, penalty) {
			if (isFullySupported) {
				/*
     * If the language is fully supported, we are more lenient.
     * A higher penalty is needed to get lower scores.
     */
				if (penalty > 6) {
					return READABILITY_SCORES.NEEDS_IMPROVEMENT;
				}

				if (penalty > 4) {
					/*
      * A penalty between 4 and 6 means either:
      *  - One "ok" and one "bad" result (5).
      *  - Two "bad" results of 3 points each (6).
      *  - Three "ok" results of 2 points each (6).
      */
					return READABILITY_SCORES.OKAY;
				}
			} else {
				/*
     * If the language is NOT fully supported, we are more stringent.
     * The penalty threshold for getting lower scores is set lower.
     */
				if (penalty > 4) {
					return READABILITY_SCORES.NEEDS_IMPROVEMENT;
				}

				if (penalty > 2) {
					/*
      * A penalty of 3 or 4 means:
      *  - Two "ok" results of 2 points each (4).
      *  - One "bad" result of 4 points (4).
      */
					return READABILITY_SCORES.OKAY;
				}
			}
			return READABILITY_SCORES.GOOD;
		}

		/**
   * Calculates the total penalty based on the given assessment results.
   *
   * @param {AssessmentResult[]} results The valid results from which to calculate the total penalty.
   *
   * @returns {number} The total penalty for the results.
   */

	}, {
		key: "calculatePenalty",
		value: function calculatePenalty(results) {
			var _this2 = this;

			return results.reduce(function (sum, result) {
				// Compute the rating ("error", "feedback", "bad", "ok" or "good").
				var rating = (0, _interpreters.scoreToRating)(result.getScore());

				var penalty = _this2.isFullySupported(results) ? PENALTY_MAPPING_FULL_SUPPORT[rating] : PENALTY_MAPPING_PARTIAL_SUPPORT[rating];

				// Add penalty when available.
				return penalty ? sum + penalty : sum;
			}, 0);
		}

		/**
   * Returns the list of valid results.
   * Valid results are all results that have a score and a text.
   *
   * @param {AssessmentResult[]} results The results to filter the valid results from.
   *
   * @returns {AssessmentResult[]} The list of valid results.
   */

	}, {
		key: "getValidResults",
		value: function getValidResults(results) {
			return results.filter(function (result) {
				return result.hasScore() && result.hasText();
			});
		}

		/**
   * Aggregates the given assessment results into a single analysis score.
   *
   * @param {AssessmentResult[]} results The assessment results.
   *
   * @returns {number} The aggregated score.
   */

	}, {
		key: "aggregate",
		value: function aggregate(results) {
			var validResults = this.getValidResults(results);

			/*
    * If you have no content, you have a red indicator.
    * (Assume that one result always means the 'no content' assessment result).
    */
			if (validResults.length <= 1) {
				return READABILITY_SCORES.NEEDS_IMPROVEMENT;
			}

			var penalty = this.calculatePenalty(validResults);
			var isFullySupported = this.isFullySupported(results);
			return this.calculateScore(isFullySupported, penalty);
		}
	}]);

	return ReadabilityScoreAggregator;
}(_ScoreAggregator3.default);

exports.default = ReadabilityScoreAggregator;
//# sourceMappingURL=ReadabilityScoreAggregator.js.map
