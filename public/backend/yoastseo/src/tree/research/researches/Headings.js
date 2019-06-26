"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _lodashEs = require("lodash-es");

var _structure = require("../../structure");

var _LeafNode = require("../../structure/nodes/LeafNode");

var _LeafNode2 = _interopRequireDefault(_LeafNode);

var _Research2 = require("./Research");

var _Research3 = _interopRequireDefault(_Research2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/* Internal dependencies */


/**
 * A research giving back the headings located in a text.
 */
var Headings = function (_Research) {
	_inherits(Headings, _Research);

	function Headings() {
		_classCallCheck(this, Headings);

		return _possibleConstructorReturn(this, (Headings.__proto__ || Object.getPrototypeOf(Headings)).apply(this, arguments));
	}

	_createClass(Headings, [{
		key: "calculateFor",

		/**
   * Calculates the result of the research for the given Node.
   *
   * @param {module:tree/structure.Node} node The node to do the research on.
   *
   * @returns {Promise<module:tree/structure.Heading[]|[]>} The result of the research.
   */
		value: function calculateFor(node) {
			return node instanceof _structure.Heading ? Promise.resolve([node]) : Promise.resolve([]);
		}

		/**
   * Checks if the given node is a leaf node for this research.
   *
   * @param {module:tree/structure.Node} node The node to check.
   *
   * @returns {boolean} If the given node is considered a leaf node for this research.
   */

	}, {
		key: "isLeafNode",
		value: function isLeafNode(node) {
			return node instanceof _LeafNode2.default;
		}

		/**
   * Merges results of this research according to a predefined strategy.
   *
   * @param {Array<module:tree/structure.Heading[]>} results The results of this research to merge.
   *
   * @returns {module:tree/structure.Heading[]} The merged results.
   */

	}, {
		key: "mergeChildrenResults",
		value: function mergeChildrenResults(results) {
			return (0, _lodashEs.flatten)(results);
		}
	}]);

	return Headings;
}(_Research3.default);

exports.default = Headings;
//# sourceMappingURL=Headings.js.map
