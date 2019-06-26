"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _ScoreAggregator2 = require("./ScoreAggregator");

var _ScoreAggregator3 = _interopRequireDefault(_ScoreAggregator2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * The number to scale the score to.
 *
 * Individual scores are from 1 to 9.
 * The total score should be multiplied by this number to scale up.
 *
 * @type {number}
 * @const
 *
 * @memberOf module:tree/assess
 */
var ScoreScale = 100;

/**
 * The factor to multiply the amount of results with.
 *
 * Individual scores are from 1 to 9.
 * The make the total score work in the 100 scale, the amount of results needs to get multiplied by this factor.
 *
 * @type {number}
 * @const
 *
 * @memberOf module:tree/assess
 */
var ScoreFactor = 9;

/**
 * Aggregates SEO assessment results into a single score.
 *
 * @memberOf module:tree/assess
 */

var SEOScoreAggregator = function (_ScoreAggregator) {
  _inherits(SEOScoreAggregator, _ScoreAggregator);

  function SEOScoreAggregator() {
    _classCallCheck(this, SEOScoreAggregator);

    return _possibleConstructorReturn(this, (SEOScoreAggregator.__proto__ || Object.getPrototypeOf(SEOScoreAggregator)).apply(this, arguments));
  }

  _createClass(SEOScoreAggregator, [{
    key: "aggregate",

    /**
     * Aggregates the given assessment results into a single score.
     *
     * @param {AssessmentResult[]} results The assessment results.
     *
     * @returns {number} The aggregated score.
     */
    value: function aggregate(results) {
      var score = results.reduce(function (sum, result) {
        return sum + result.getScore();
      }, 0);

      /*
       * Whenever the divide by part is 0 this can result in a `NaN` value. Then 0 should be returned as fallback.
       * This seemed better than the if check `results.length === 0`,
       * because it also protects against ScoreFactor being 0.
       */
      return Math.round(score * ScoreScale / (results.length * ScoreFactor)) || 0;
    }
  }]);

  return SEOScoreAggregator;
}(_ScoreAggregator3.default);

exports.default = SEOScoreAggregator;
//# sourceMappingURL=SEOScoreAggregator.js.map
