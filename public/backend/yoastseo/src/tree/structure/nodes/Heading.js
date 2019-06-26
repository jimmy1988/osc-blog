"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _LeafNode2 = require("./LeafNode");

var _LeafNode3 = _interopRequireDefault(_LeafNode2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * A header in a document.
 *
 * @extends module:tree/structure.LeafNode
 *
 * @memberOf module:tree/structure
 */
var Heading = function (_LeafNode) {
	_inherits(Heading, _LeafNode);

	/**
  * Makes a new header object.
  *
  * @param {number} level The header level (e.g. 1 for main heading, 2 for subheading lvl 2, etc.)
  */
	function Heading(level) {
		_classCallCheck(this, Heading);

		/**
   * Heading's level (e.g. 1 for "h1", 2 for "h2", ... ).
   * @type {number}
   */
		var _this = _possibleConstructorReturn(this, (Heading.__proto__ || Object.getPrototypeOf(Heading)).call(this, "Heading"));

		_this.level = level;
		return _this;
	}

	return Heading;
}(_LeafNode3.default);

exports.default = Heading;
//# sourceMappingURL=Heading.js.map
