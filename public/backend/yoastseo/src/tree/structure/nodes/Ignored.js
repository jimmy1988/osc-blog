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
 * Represents a piece of structured data that is ignored in further analysis.
 *
 * Examples from HTML include content within `<script>` and `<style>` elements.
 *
 * @extends module:tree/structure.Node
 *
 * @memberOf module:tree/structure
 */
var Ignored = function (_Node) {
	_inherits(Ignored, _Node);

	/**
  * Makes a new `Ignored` element, representing content that is ignored in further analysis.
  *
  * Examples from HTML include content within `<script>` and `<style>` elements.
  *
  * @param {string} tag The element tag.
  *
  * @returns {void}
  */
	function Ignored(tag) {
		_classCallCheck(this, Ignored);

		/**
   * Type of content (e.g. "script", "code" etc.).
   * @type {string}
   */
		var _this = _possibleConstructorReturn(this, (Ignored.__proto__ || Object.getPrototypeOf(Ignored)).call(this, "StructuredIrrelevant"));

		_this.tag = tag;
		/**
   * Element's content (without opening and closing tags).
   * @type {string}
   */
		_this.content = "";
		return _this;
	}

	return Ignored;
}(_Node3.default);

exports.default = Ignored;
//# sourceMappingURL=Ignored.js.map
