"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _TextContainer = require("../TextContainer");

var _TextContainer2 = _interopRequireDefault(_TextContainer);

var _Node2 = require("./Node");

var _Node3 = _interopRequireDefault(_Node2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * A node at the end of the tree that may only contain formatting elements,
 * these include headings and paragraphs.
 *
 * @extends module:tree/structure.Node
 *
 * @memberOf module:tree/structure
 *
 * @abstract
 */
var LeafNode = function (_Node) {
	_inherits(LeafNode, _Node);

	/**
  * Creates a new leaf node.
  *
  * @param {string} type The type of Node (should be unique for each child class of Node).
  *
  * @returns {void}
  */
	function LeafNode(type) {
		_classCallCheck(this, LeafNode);

		/**
   * A container for keeping this leaf node's text.
   * @type {module:tree/structure.TextContainer}
   */
		var _this = _possibleConstructorReturn(this, (LeafNode.__proto__ || Object.getPrototypeOf(LeafNode)).call(this, type));

		_this.textContainer = new _TextContainer2.default();
		return _this;
	}

	/**
  * Retrieves the heading text (from the TextContainer).
  *
  * @returns {string} The text of the heading.
  */


	_createClass(LeafNode, [{
		key: "text",
		get: function get() {
			return this.textContainer.text;
		}

		/**
   * Sets the heading text (via the TextContainer).
   *
   * @param {string} text The text to assign as the heading text.
   *
   * @returns {void}
   */
		,
		set: function set(text) {
			this.textContainer.text = text;
		}
	}]);

	return LeafNode;
}(_Node3.default);

exports.default = LeafNode;
//# sourceMappingURL=LeafNode.js.map
