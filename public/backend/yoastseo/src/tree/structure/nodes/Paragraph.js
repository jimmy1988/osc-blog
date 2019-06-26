"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _LeafNode2 = require("./LeafNode");

var _LeafNode3 = _interopRequireDefault(_LeafNode2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Represents a paragraph with text within a document.
 *
 * @extends module:tree/structure.LeafNode
 *
 * @memberOf module:tree/structure
 */
var Paragraph = function (_LeafNode) {
	_inherits(Paragraph, _LeafNode);

	/**
  * A paragraph within a document.
  *
  * @param {string} [tag=""] Optional tag to use for opening / closing this paragraph.
  */
	function Paragraph() {
		var tag = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";

		_classCallCheck(this, Paragraph);

		/**
   * Tag used to open or close this paragraph.
   * @type {string}
   */
		var _this = _possibleConstructorReturn(this, (Paragraph.__proto__ || Object.getPrototypeOf(Paragraph)).call(this, "Paragraph"));

		_this.tag = tag;
		return _this;
	}

	/**
  * If this paragraph is an explicit paragraph (with an explicit tag).
  *
  * @returns {boolean} If this paragraph is explicit.
  */


	_createClass(Paragraph, [{
		key: "isExplicit",
		value: function isExplicit() {
			return this.tag && this.tag.length > 0;
		}
	}]);

	return Paragraph;
}(_LeafNode3.default);

exports.default = Paragraph;
//# sourceMappingURL=Paragraph.js.map
