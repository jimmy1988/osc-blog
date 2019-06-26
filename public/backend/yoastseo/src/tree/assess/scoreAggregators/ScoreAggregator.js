"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Aggregates assessment results into a single score.
 *
 * @memberOf module:tree/assess
 *
 * @abstract
 */
var ScoreAggregator = function () {
	function ScoreAggregator() {
		_classCallCheck(this, ScoreAggregator);
	}

	_createClass(ScoreAggregator, [{
		key: "aggregate",

		/**
   * Aggregates the given assessment results into a single score.
   *
   * @param {AssessmentResult[]} results The assessment results.
   *
   * @returns {number} The aggregated score.
   *
   * @abstract
   */
		value: function aggregate(results) {
			// eslint-disable-line no-unused-vars
			console.warn("'aggregate' must be implemented by a child class of 'ScoreAggregator'");
		}
	}]);

	return ScoreAggregator;
}();

exports.default = ScoreAggregator;
//# sourceMappingURL=ScoreAggregator.js.map
