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
 * Assessment that will test if the text is long enough.
 */
var TextLengthAssessment = function (_Assessment) {
	_inherits(TextLengthAssessment, _Assessment);

	/**
  * Sets the identifier and the config.
  *
  * @param {Object} [config] The configuration to use.
  *
  * @returns {void}
  */
	function TextLengthAssessment() {
		var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

		_classCallCheck(this, TextLengthAssessment);

		var _this = _possibleConstructorReturn(this, (TextLengthAssessment.__proto__ || Object.getPrototypeOf(TextLengthAssessment)).call(this));

		var defaultConfig = {
			recommendedMinimum: 300,
			slightlyBelowMinimum: 250,
			belowMinimum: 200,
			veryFarBelowMinimum: 100,

			scores: {
				recommendedMinimum: 9,
				slightlyBelowMinimum: 6,
				belowMinimum: 3,
				farBelowMinimum: -10,
				veryFarBelowMinimum: -20
			},
			urlTitle: (0, _shortlinker.createAnchorOpeningTag)("https://yoa.st/34n"),
			urlCallToAction: (0, _shortlinker.createAnchorOpeningTag)("https://yoa.st/34o"),

			cornerstoneContent: false
		};

		_this.identifier = "textLength";
		_this._config = (0, _lodashEs.merge)(defaultConfig, config);
		return _this;
	}

	/**
  * Execute the Assessment and return a result.
  *
  * @param {Paper} paper The Paper object to assess.
  * @param {Researcher} researcher The Researcher object containing all available researches.
  * @param {Jed} i18n The locale object.
  *
  * @returns {AssessmentResult} The result of the assessment, containing both a score and a descriptive text.
  */


	_createClass(TextLengthAssessment, [{
		key: "getResult",
		value: function getResult(paper, researcher, i18n) {
			var wordCount = researcher.getResearch("wordCountInText");
			var assessmentResult = new _AssessmentResult2.default();
			var calculatedResult = this.calculateResult(wordCount, i18n);

			assessmentResult.setScore(calculatedResult.score);
			assessmentResult.setText(calculatedResult.resultText);

			return assessmentResult;
		}

		/**
   * Returns the score and the appropriate feedback string based on the current word count.
   *
   * @param {number} wordCount The amount of words to be checked against.
   * @param {Jed} i18n The locale object.
   *
   * @returns {Object} The score and the feedback string.
   */

	}, {
		key: "calculateResult",
		value: function calculateResult(wordCount, i18n) {
			if (wordCount >= this._config.recommendedMinimum) {
				return {
					score: this._config.scores.recommendedMinimum,
					resultText: i18n.sprintf(i18n.dngettext("js-text-analysis",
					/* Translators: %1$d expands to the number of words in the text,
     %2$s expands to a link on yoast.com, %3$s expands to the anchor end tag */
					"%2$sText length%3$s: The text contains %1$d word. Good job!", "%2$sText length%3$s: The text contains %1$d words. Good job!", wordCount), wordCount, this._config.urlTitle, "</a>")
				};
			}

			if ((0, _lodashEs.inRange)(wordCount, 0, this._config.belowMinimum)) {
				var badScore = this._config.scores.farBelowMinimum;

				if ((0, _lodashEs.inRange)(wordCount, 0, this._config.veryFarBelowMinimum)) {
					badScore = this._config.scores.veryFarBelowMinimum;
				}

				return {
					score: badScore,
					resultText: i18n.sprintf(i18n.dngettext("js-text-analysis",
					/* Translators: %1$d expands to the number of words in the text,
     %2$s expands to a link on yoast.com, %4$s expands to the anchor end tag. */
					"%2$sText length%4$s: The text contains %1$d word.", "%2$sText length%4$s: The text contains %1$d words.", wordCount) + " " + i18n.dngettext("js-text-analysis",
					/* Translators: The preceding sentence is "Text length: The text contains x words.",
     %3$s expands to a link on yoast.com,
     %4$s expands to the anchor end tag,
     %5$d expands to the recommended minimum of words. */
					"This is far below the recommended minimum of %5$d word. %3$sAdd more content%4$s.", "This is far below the recommended minimum of %5$d words. %3$sAdd more content%4$s.", this._config.recommendedMinimum), wordCount, this._config.urlTitle, this._config.urlCallToAction, "</a>", this._config.recommendedMinimum)
				};
			}

			if ((0, _lodashEs.inRange)(wordCount, this._config.slightlyBelowMinimum, this._config.recommendedMinimum)) {
				if (this._config.cornerstoneContent === false) {
					return {
						score: this._config.scores.slightlyBelowMinimum,
						resultText: i18n.sprintf(i18n.dngettext("js-text-analysis",
						/* Translators: %1$d expands to the number of words in the text,
      %2$s expands to a link on yoast.com, %4$s expands to the anchor end tag. */
						"%2$sText length%4$s: The text contains %1$d word.", "%2$sText length%4$s: The text contains %1$d words.", wordCount) + " " + i18n.dngettext("js-text-analysis",
						/* Translators: The preceding sentence is "Text length: The text contains x words.",
      %3$s expands to a link on yoast.com,
      %4$s expands to the anchor end tag,
      %5$d expands to the recommended minimum of words. */
						"This is slightly below the recommended minimum of %5$d word. %3$sAdd a bit more copy%4$s.", "This is slightly below the recommended minimum of %5$d words. %3$sAdd a bit more copy%4$s.", this._config.recommendedMinimum), wordCount, this._config.urlTitle, this._config.urlCallToAction, "</a>", this._config.recommendedMinimum)
					};
				}

				return {
					score: this._config.scores.slightlyBelowMinimum,
					resultText: i18n.sprintf(i18n.dngettext("js-text-analysis",
					/* Translators: %1$d expands to the number of words in the text,
     %2$s expands to a link on yoast.com, %4$s expands to the anchor end tag. */
					"%2$sText length%4$s: The text contains %1$d word.", "%2$sText length%4$s: The text contains %1$d words.", wordCount) + " " + i18n.dngettext("js-text-analysis",
					/* Translators: The preceding sentence is "Text length: The text contains x words.",
     %3$s expands to a link on yoast.com,
     %4$s expands to the anchor end tag,
     %5$d expands to the recommended minimum of words. */
					"This is below the recommended minimum of %5$d word. %3$sAdd more content%4$s.", "This is below the recommended minimum of %5$d words. %3$sAdd more content%4$s.", this._config.recommendedMinimum), wordCount, this._config.urlTitle, this._config.urlCallToAction, "</a>", this._config.recommendedMinimum)
				};
			}

			return {
				score: this._config.scores.belowMinimum,
				resultText: i18n.sprintf(i18n.dngettext("js-text-analysis",
				/* Translators: %1$d expands to the number of words in the text,
    %2$s expands to a link on yoast.com, %4$s expands to the anchor end tag. */
				"%2$sText length%4$s: The text contains %1$d word.", "%2$sText length%4$s: The text contains %1$d words.", wordCount) + " " + i18n.dngettext("js-text-analysis",
				/* Translators: The preceding sentence is "Text length: The text contains x words.",
    %3$s expands to a link on yoast.com,
    %4$s expands to the anchor end tag,
    %5$d expands to the recommended minimum of words. */
				"This is below the recommended minimum of %5$d word. %3$sAdd more content%4$s.", "This is below the recommended minimum of %5$d words. %3$sAdd more content%4$s.", this._config.recommendedMinimum), wordCount, this._config.urlTitle, this._config.urlCallToAction, "</a>", this._config.recommendedMinimum)
			};
		}
	}]);

	return TextLengthAssessment;
}(_assessment2.default);

exports.default = TextLengthAssessment;
//# sourceMappingURL=TextLengthAssessment.js.map
