"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _lodashEs = require("lodash-es");

var _assessment = require("../../assessment");

var _assessment2 = _interopRequireDefault(_assessment);

var _shortlinker = require("../../helpers/shortlinker");

var _AssessmentResult = require("../../values/AssessmentResult");

var _AssessmentResult2 = _interopRequireDefault(_AssessmentResult);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Assessment to check whether the text has internal links and whether they are followed or no-followed.
 */
var InternalLinksAssessment = function (_Assessment) {
	_inherits(InternalLinksAssessment, _Assessment);

	/**
  * Sets the identifier and the config.
  *
  * @param {Object} [config] The configuration to use.
  * @param {number} [config.parameters.recommendedMinimum] The recommended minimum number of internal links in the text.
  * @param {number} [config.scores.allInternalFollow] The score to return if all internal links are do-follow.
  * @param {number} [config.scores.someInternalFollow] The score to return if some but not all internal links are do-follow.
  * @param {number} [config.scores.noneInternalFollow] The score to return if all internal links are no-follow.
  * @param {number} [config.scores.noInternal] The score to return if there are no internal links.
  * @param {string} [config.url] The URL to the relevant KB article.
  *
  * @returns {void}
  */
	function InternalLinksAssessment() {
		var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

		_classCallCheck(this, InternalLinksAssessment);

		var _this = _possibleConstructorReturn(this, (InternalLinksAssessment.__proto__ || Object.getPrototypeOf(InternalLinksAssessment)).call(this));

		var defaultConfig = {
			parameters: {
				recommendedMinimum: 1
			},
			scores: {
				allInternalFollow: 9,
				someInternalFollow: 8,
				noneInternalFollow: 7,
				noInternal: 3
			},
			urlTitle: (0, _shortlinker.createAnchorOpeningTag)("https://yoa.st/33z"),
			urlCallToAction: (0, _shortlinker.createAnchorOpeningTag)("https://yoa.st/34a")
		};

		_this.identifier = "internalLinks";
		_this._config = (0, _lodashEs.merge)(defaultConfig, config);
		return _this;
	}

	/**
  * Runs the getLinkStatistics module, based on this returns an assessment result with score.
  *
  * @param {Paper} paper The paper to use for the assessment.
  * @param {Researcher} researcher The researcher used for calling research.
  * @param {Jed} i18n The object used for translations.
  *
  * @returns {AssessmentResult} The result of the assessment.
  */


	_createClass(InternalLinksAssessment, [{
		key: "getResult",
		value: function getResult(paper, researcher, i18n) {
			this.linkStatistics = researcher.getResearch("getLinkStatistics");
			var assessmentResult = new _AssessmentResult2.default();

			var calculatedResult = this.calculateResult(i18n);
			assessmentResult.setScore(calculatedResult.score);
			assessmentResult.setText(calculatedResult.resultText);

			return assessmentResult;
		}

		/**
   * Checks if assessment is applicable to the paper.
   *
   * @param {Paper} paper The paper to be analyzed.
   *
   * @returns {boolean} Whether the paper has text.
   */

	}, {
		key: "isApplicable",
		value: function isApplicable(paper) {
			return paper.hasText();
		}

		/**
   * Returns a score and text based on the linkStatistics object.
   *
   * @param {Jed} i18n The object used for translations.
   *
   * @returns {Object} ResultObject with score and text
   */

	}, {
		key: "calculateResult",
		value: function calculateResult(i18n) {
			if (this.linkStatistics.internalTotal === 0) {
				return {
					score: this._config.scores.noInternal,
					resultText: i18n.sprintf(
					/* Translators: %1$s and %2$s expand to links on yoast.com, %3$s expands to the anchor end tag */
					i18n.dgettext("js-text-analysis", "%1$sInternal links%3$s: " + "No internal links appear in this page, %2$smake sure to add some%3$s!"), this._config.urlTitle, this._config.urlCallToAction, "</a>")
				};
			}

			if (this.linkStatistics.internalNofollow === this.linkStatistics.internalTotal) {
				return {
					score: this._config.scores.noneInternalFollow,
					resultText: i18n.sprintf(
					/* Translators: %1$s and %2$s expand to links on yoast.com, %3$s expands to the anchor end tag */
					i18n.dgettext("js-text-analysis", "%1$sInternal links%3$s: " + "The internal links in this page are all nofollowed. %2$sAdd some good internal links%3$s."), this._config.urlTitle, this._config.urlCallToAction, "</a>")
				};
			}

			if (this.linkStatistics.internalDofollow === this.linkStatistics.internalTotal) {
				return {
					score: this._config.scores.allInternalFollow,
					resultText: i18n.sprintf(
					/* Translators: %1$s expands to a link on yoast.com, %2$s expands to the anchor end tag */
					i18n.dgettext("js-text-analysis", "%1$sInternal links%2$s: You have enough internal links. Good job!"), this._config.urlTitle, "</a>")
				};
			}
			return {
				score: this._config.scores.someInternalFollow,
				resultText: i18n.sprintf(
				/* Translators: %1$s expands to a link on yoast.com, %2$s expands to the anchor end tag */
				i18n.dgettext("js-text-analysis", "%1$sInternal links%2$s: There are both nofollowed and normal internal links on this page. Good job!"), this._config.urlTitle, "</a>")
			};
		}
	}]);

	return InternalLinksAssessment;
}(_assessment2.default);

exports.default = InternalLinksAssessment;
//# sourceMappingURL=InternalLinksAssessment.js.map