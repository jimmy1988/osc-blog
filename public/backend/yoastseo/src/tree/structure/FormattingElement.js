"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Represents formatting elements (e.g. link, image, bold text) within a document.
 *
 * @memberOf module:tree/structure
 */
var FormattingElement =
/**
 * Represents a formatting element (e.g. link, image, bold text) within a document.
 *
 * @param {string} type              The type of this element ("link", "image", "bold", etc.).
 * @param {Object} [attributes=null] The attributes (as key-value pairs, e.g. `{ href: '...' }` ).
 */
function FormattingElement(type) {
	var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

	_classCallCheck(this, FormattingElement);

	/**
  * Type of formatting element (e.g. "strong", "a").
  * @type {string}
  */
	this.type = type;
	/**
  * Attributes of this element (e.g. "href", "id").
  * @type {?Object}
  */
	this.attributes = attributes;
	/**
  * Start of this element (including tags) within the source text.
  * @type {?number}
  */
	this.sourceStartIndex = null;
	/**
  * End of this element (including tags) within the source text.
  * @type {?number}
  */
	this.sourceEndIndex = null;
	/**
  * Start of this element's content within the parent textContainer's text.
  * @type {?number}
  */
	this.textStartIndex = null;
	/**
  * End of this element's content within the parent textContainer's text.
  * @type {?number}
  */
	this.textEndIndex = null;
};

exports.default = FormattingElement;
//# sourceMappingURL=FormattingElement.js.map
