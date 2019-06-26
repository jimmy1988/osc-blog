"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _lodashEs = require("lodash-es");

var _assessment = require("../../assessment");

var _assessment2 = _interopRequireDefault(_assessment);

var _getLanguageAvailability = require("../../helpers/getLanguageAvailability");

var _getLanguageAvailability2 = _interopRequireDefault(_getLanguageAvailability);

var _shortlinker = require("../../helpers/shortlinker");

var _AssessmentResult = require("../../values/AssessmentResult");

var _AssessmentResult2 = _interopRequireDefault(_AssessmentResult);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var availableLanguages = ["en", "nl", "de", "it", "ru", "fr", "es"];

/**
 * Assessment to check how readable the text is, based on the Flesch reading ease test.
 */

var FleschReadingEaseAssessment = function (_Assessment) {
	_inherits(FleschReadingEaseAssessment, _Assessment);

	/**
  * Sets the identifier and the config.
  *
  * @param {Object} config The configuration to use.
  * @returns {void}
  */
	function FleschReadingEaseAssessment(config) {
		_classCallCheck(this, FleschReadingEaseAssessment);

		var _this = _possibleConstructorReturn(this, (FleschReadingEaseAssessment.__proto__ || Object.getPrototypeOf(FleschReadingEaseAssessment)).call(this));

		var defaultConfig = {
			urlTitle: (0, _shortlinker.createAnchorOpeningTag)("https://yoa.st/34r"),
			urlCallToAction: (0, _shortlinker.createAnchorOpeningTag)("https://yoa.st/34s")
		};

		_this.identifier = "fleschReadingEase";
		_this._config = (0, _lodashEs.merge)(defaultConfig, config);
		return _this;
	}

	/**
  * The assessment that runs the FleschReading on the paper.
  *
  * @param {Object} paper The paper to run this assessment on.
  * @param {Object} researcher The researcher used for the assessment.
  * @param {Object} i18n The i18n-object used for parsing translations.
  *
  * @returns {Object} An assessmentResult with the score and formatted text.
  */


	_createClass(FleschReadingEaseAssessment, [{
		key: "getResult",
		value: function getResult(paper, researcher, i18n) {
			this.fleschReadingResult = researcher.getResearch("calculateFleschReading");
			if (this.isApplicable(paper)) {
				var assessmentResult = new _AssessmentResult2.default(i18n);
				var calculatedResult = this.calculateResult(i18n);
				assessmentResult.setScore(calculatedResult.score);
				assessmentResult.setText(calculatedResult.resultText);

				return assessmentResult;
			}
			return null;
		}

		/**
   * Calculates the assessment result based on the fleschReadingScore.
   *
   * @param {Object} i18n The i18n-object used for parsing translations.
   *
   * @returns {Object} Object with score and resultText.
   */

	}, {
		key: "calculateResult",
		value: function calculateResult(i18n) {
			// Results must be between 0 and 100;
			if (this.fleschReadingResult < 0) {
				this.fleschReadingResult = 0;
			}

			if (this.fleschReadingResult > 100) {
				this.fleschReadingResult = 100;
			}

			var score = 0;
			var feedback = "";
			var note = i18n.dgettext("js-text-analysis", "Good job!");

			if (this.fleschReadingResult >= this._config.borders.veryEasy) {
				score = this._config.scores.veryEasy;
				feedback = i18n.dgettext("js-text-analysis", "very easy");
			} else if ((0, _lodashEs.inRange)(this.fleschReadingResult, this._config.borders.easy, this._config.borders.veryEasy)) {
				score = this._config.scores.easy;
				feedback = i18n.dgettext("js-text-analysis", "easy");
			} else if ((0, _lodashEs.inRange)(this.fleschReadingResult, this._config.borders.fairlyEasy, this._config.borders.easy)) {
				score = this._config.scores.fairlyEasy;
				feedback = i18n.dgettext("js-text-analysis", "fairly easy");
			} else if ((0, _lodashEs.inRange)(this.fleschReadingResult, this._config.borders.okay, this._config.borders.fairlyEasy)) {
				score = this._config.scores.okay;
				feedback = i18n.dgettext("js-text-analysis", "ok");
			} else if ((0, _lodashEs.inRange)(this.fleschReadingResult, this._config.borders.fairlyDifficult, this._config.borders.okay)) {
				score = this._config.scores.fairlyDifficult;
				feedback = i18n.dgettext("js-text-analysis", "fairly difficult");
				note = i18n.dgettext("js-text-analysis", "Try to make shorter sentences to improve readability");
			} else if ((0, _lodashEs.inRange)(this.fleschReadingResult, this._config.borders.difficult, this._config.borders.fairlyDifficult)) {
				score = this._config.scores.difficult;
				feedback = i18n.dgettext("js-text-analysis", "difficult");
				note = i18n.dgettext("js-text-analysis", "Try to make shorter sentences, using less difficult words to improve readability");
			} else {
				score = this._config.scores.veryDifficult;
				feedback = i18n.dgettext("js-text-analysis", "very difficult");
				note = i18n.dgettext("js-text-analysis", "Try to make shorter sentences, using less difficult words to improve readability");
			}

			// If the score is good, add a "Good job" message without a link to the Call-to-action article.
			if (score >= this._config.scores.okay) {
				return {
					score: score,
					resultText: i18n.sprintf(
					/* Translators: %1$s expands to a link on yoast.com,
     	%2$s to the anchor end tag,
     	%3$s expands to the numeric Flesch reading ease score,
     	%4$s to the easiness of reading,
     	%5$s expands to a call to action based on the score */
					i18n.dgettext("js-text-analysis", "%1$sFlesch Reading Ease%2$s: The copy scores %3$s in the test, which is considered %4$s to read. %5$s"), this._config.urlTitle, "</a>", this.fleschReadingResult, feedback, note)
				};
			}
			// If the score is not good, add a Call-to-action message with a link to the Call-to-action article.
			return {
				score: score,
				resultText: i18n.sprintf(
				/* Translators: %1$s and %5$s expand to a link on yoast.com,
    	%2$s to the anchor end tag,
    	%7$s expands to the anchor end tag and a full stop,
    	%3$s expands to the numeric Flesch reading ease score,
    	%4$s to the easiness of reading,
    	%6$s expands to a call to action based on the score */
				i18n.dgettext("js-text-analysis", "%1$sFlesch Reading Ease%2$s: The copy scores %3$s in the test, which is considered %4$s to read. %5$s%6$s%7$s"), this._config.urlTitle, "</a>", this.fleschReadingResult, feedback, this._config.urlCallToAction, note, "</a>.")
			};
		}

		/**
   * Checks if Flesch reading analysis is available for the language of the paper.
   *
   * @param {Object} paper The paper to have the Flesch score to be calculated for.
   * @returns {boolean} Returns true if the language is available and the paper is not empty.
   */

	}, {
		key: "isApplicable",
		value: function isApplicable(paper) {
			var isLanguageAvailable = (0, _getLanguageAvailability2.default)(paper.getLocale(), availableLanguages);
			return isLanguageAvailable && paper.hasText();
		}
	}]);

	return FleschReadingEaseAssessment;
}(_assessment2.default);

exports.default = FleschReadingEaseAssessment;
//# sourceMappingURL=fleschReadingEaseAssessment.js.map
