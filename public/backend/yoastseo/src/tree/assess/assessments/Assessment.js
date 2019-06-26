"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * An assessment that can be applied to a formatted text and its meta data.
 *
 * @memberOf module:tree/assess
 *
 * @abstract
 */
var Assessment = function () {
	/**
  * Creates a new assessment.
  *
  * @param {string}                              name       The name to give this assessment.
  * @param {module:tree/research.TreeResearcher} researcher The researcher to do researches with.
  *
  * @abstract
  */
	function Assessment(name, researcher) {
		_classCallCheck(this, Assessment);

		/**
   * This assessment's name.
   * @type {string}
   */
		this.name = name;
		/**
   * The researcher to do researches with.
   * @type {module:tree/research.TreeResearcher}
   * @private
   */
		this._researcher = researcher;
	}

	/**
  * Sets a new researcher on this assessment.
  *
  * @param {module:tree/research.TreeResearcher} researcher The researcher to do researches with.
  *
  * @returns {void}
  */


	_createClass(Assessment, [{
		key: "setResearcher",
		value: function setResearcher(researcher) {
			this._researcher = researcher;
		}

		/**
   * Returns the researcher used by this assessment.
   *
   * @returns {module:tree/research.TreeResearcher} The researcher used by this assessment.
   */

	}, {
		key: "getResearcher",
		value: function getResearcher() {
			return this._researcher;
		}

		/**
   * Checks whether this assessment is applicable to the given paper and tree combination.
   *
   * @param {Paper} paper                     The paper to check.
   * @param {module:tree/structure.Node} node The root node of the tree to check.
   *
   * @returns {Promise<boolean>} Whether this assessment is applicable to the given paper and tree combination (wrapped in a promise).
   *
   * @abstract
   */

	}, {
		key: "isApplicable",
		value: async function isApplicable(paper, node) {
			// eslint-disable-line no-unused-vars
			console.warn("`isApplicable` should be implemented by a child class of `Assessment`.");
		}

		/**
   * Applies this assessment to the given combination of paper and tree.
   *
   * @param {Paper} paper                                    The paper to check.
   * @param {module:tree/structure.Node} node                The root node of the tree to check.
   *
   * @returns {Promise<AssessmentResult>} The result of this assessment (wrapped in a promise).
   *
   * @abstract
   */

	}, {
		key: "apply",
		value: async function apply(paper, node) {
			// eslint-disable-line no-unused-vars
			console.warn("`apply` should be implemented by a child class of `Assessment`.");
		}
	}]);

	return Assessment;
}();

exports.default = Assessment;
//# sourceMappingURL=Assessment.js.map