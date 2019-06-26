"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * A research that can be applied to the tree.
 *
 * @memberOf module:tree/research
 *
 * @abstract
 */
var Research = function () {
	function Research() {
		_classCallCheck(this, Research);
	}

	_createClass(Research, [{
		key: "isLeafNode",

		/**
   * Checks if the given node is a leaf node for this research.
   *
   * @param {module:tree/structure.Node} node The node to check.
   *
   * @returns {boolean} If the given node is considered a leaf node for this research.
   *
   * @abstract
   */
		value: function isLeafNode(node) {
			// eslint-disable-line no-unused-vars
			console.warn("isLeafNode should be implemented by a child class of Researcher.");
		}

		/**
   * Calculates the result of the research for the given Node.
   *
   * @param {module:tree/structure.Node} node The node to calculate the research for.
   *
   * @returns {Promise<*>} The result of the research.
   *
   * @abstract
   */

	}, {
		key: "calculateFor",
		value: function calculateFor(node) {
			// eslint-disable-line no-unused-vars
			console.warn("calculateFor should be implemented by a child class of Researcher.");
		}

		/**
   * Merges results of this research according to a predefined strategy.
   *
   * @param {Array<*>} results The results of this research to merge.
   *
   * @returns {*} The merged results.
   *
   * @abstract
   */

	}, {
		key: "mergeChildrenResults",
		value: function mergeChildrenResults(results) {
			// eslint-disable-line no-unused-vars
			console.warn("mergeChildrenResults should be implemented by a child class of Researcher.");
		}
	}]);

	return Research;
}();

exports.default = Research;
//# sourceMappingURL=Research.js.map
