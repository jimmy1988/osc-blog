"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _lodashEs = require("lodash-es");

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Abstract class representing a node in the structured tree.
 * @abstract
 *
 * @memberOf module:tree/structure
 */
var Node = function () {
	/**
  * Makes a new Node.
  *
  * @param {string} type The type of Node (should be unique for each child class of Node).
  *
  * @abstract
  */
	function Node(type) {
		_classCallCheck(this, Node);

		/**
   * Type of node (unique for each child class of Node).
   * @type {string}
   */
		this.type = type;
		/**
   * Start of this element (including tags) within the source text.
   * @type {?number}
   */
		this.sourceStartIndex = 0;
		/**
   * End of this element (including tags) within the source text.
   * @type {?number}
   */
		this.sourceEndIndex = 0;
		/**
   * Cache for the research results.
   * @type {Object}
   * @private
   */
		this._researchResult = {};
	}

	/**
  * Stores the research result on this node.
  *
  * @param {string} researchName   The name of the research of which to store the results.
  * @param {Object} researchResult The results to store.
  *
  * @returns {void}
  */


	_createClass(Node, [{
		key: "setResearchResult",
		value: function setResearchResult(researchName, researchResult) {
			this._researchResult[researchName] = researchResult;
		}

		/**
   * Returns the research result for the research with the given name.
   *
   * @param {string} researchName The name of the research of which to return the stored results.
   *
   * @returns {Object|null} The stored results, or null if not found.
   */

	}, {
		key: "getResearchResult",
		value: function getResearchResult(researchName) {
			return (0, _lodashEs.get)(this._researchResult, researchName, null);
		}

		/**
   * Checks whether results exist for the research with the given name.
   *
   * @param {string} researchName The name of the research to check.
   *
   * @returns {boolean} Whether results exists for the research with the given name.
   */

	}, {
		key: "hasResearchResult",
		value: function hasResearchResult(researchName) {
			return (0, _lodashEs.has)(this._researchResult, researchName);
		}

		/**
   * Maps the given function to each Node in this tree.
   *
   * @param {module:tree/structure.Node.mapFunction} mapFunction The function that should be mapped to each Node in the tree.
   *
   * @returns {module:tree/structure.Node} A new tree, after the given function has been mapped on each Node.
   */

	}, {
		key: "map",
		value: function map(mapFunction) {
			// Map function over contents of this node.
			var node = mapFunction(this);
			if (node.children && node.children.length > 0) {
				// Map function over node's children (if it has any).
				node.children = node.children.map(function (child) {
					return child.map(mapFunction);
				});
			}
			return node;
		}

		/**
   * Callback function for the Node's map-function.
   *
   * @callback module:tree/structure.Node.mapFunction
   *
   * @param {module:tree/structure.Node} currentValue The current Node being processed.
   *
   * @returns {module:tree/structure.Node} The current Node after being processed by this function.
   */

		/**
   * Executes the given function on each node in this tree.
   *
   * @param{function} fun The function to apply to each node in the tree.
   *
   * @returns {void}
   */

	}, {
		key: "forEach",
		value: function forEach(fun) {
			fun(this);
			if (this.children && this.children.length > 0) {
				this.children.forEach(fun);
			}
		}

		/**
   * Custom replacer function for replacing 'parent' with nothing.
   * This is done to remove cycles from the tree.
   *
   * @param {string} key   The key.
   * @param {Object} value The value.
   *
   * @returns {Object} The (optionally replaced) value.
   *
   * @private
   */

	}, {
		key: "toString",


		/**
   * Transforms this tree to a string representation.
   * For use in e.g. logging to the console or to a text file.
   *
   * @param {number|string} [indentation = 2] The space with which to indent each successive level in the JSON tree.
   *
   * @returns {string} This tree, transformed to a string.
   */
		value: function toString() {
			var indentation = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 2;

			return JSON.stringify(this, Node._removeParent, indentation);
		}
	}], [{
		key: "_removeParent",
		value: function _removeParent(key, value) {
			if (key === "parent") {
				return;
			}
			return value;
		}
	}]);

	return Node;
}();

exports.default = Node;
//# sourceMappingURL=Node.js.map