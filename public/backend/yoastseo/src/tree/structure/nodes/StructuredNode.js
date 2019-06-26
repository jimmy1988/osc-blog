"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _Node2 = require("./Node");

var _Node3 = _interopRequireDefault(_Node2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Represents a piece of structure that is present in the original text, but is not relevant for the further analysis
 * of the text.
 *
 * Talking about HTML, this would encompass thing like `<div>`, `<section>`, `<aside>`, `<fieldset>`
 * and other HTML block elements.
 *
 * @extends module:tree/structure.Node
 *
 * @memberOf module:tree/structure
 */
var StructuredNode = function (_Node) {
	_inherits(StructuredNode, _Node);

	/**
  * Represents a piece of structure that is present in the original text, but is not relevant for the further
  * analysis of the text.
  *
  * Talking about HTML, this would encompass thing like `<div>`, `<section>`, `<aside>`, `<fieldset>`
  * and other HTML block elements.
  *
  * @param {string} tag The tag used in the node.
  *
  * @returns {void}
  */
	function StructuredNode(tag) {
		_classCallCheck(this, StructuredNode);

		/**
   * Type of structured node (e.g. "div", "section" etc.).
   * @type {string}
   */
		var _this = _possibleConstructorReturn(this, (StructuredNode.__proto__ || Object.getPrototypeOf(StructuredNode)).call(this, "StructuredNode"));

		_this.tag = tag;
		/**
   * This node's child nodes.
   * @type {Node[]}
   */
		_this.children = [];
		return _this;
	}

	return StructuredNode;
}(_Node3.default);

exports.default = StructuredNode;
//# sourceMappingURL=StructuredNode.js.map
