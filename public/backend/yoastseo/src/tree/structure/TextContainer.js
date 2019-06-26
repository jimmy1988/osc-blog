"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Represents a text (with optional formatting element(s)) within a document that can be read by a reader.
 *
 * Example (in the case of HTML):
 * ```html
 * This text is <strong id="elem-id">very strong</strong>.
 * ```
 * is transformed to:
 * ```js
 * TextContainer {
 *     text: "This text is very strong".
 *     formatting: [
 *         FormattingElement {
 *             type: "strong",
 *             startIndex: 13, // "This text is ".length
 *             endIndex: 54,   // "This text is <strong id="elem-id">very strong</strong>".length
 *             startText: 13,  // "This text is ".length
 *             endText: 24,    // "This text is very strong".length
 *             attributes: {
 *                 id: "elem-id"
 *             }
 *         }
 *     ]
 * }
 * ```
 *
 * @memberOf module:tree/structure
 */
var TextContainer = function () {
  /**
   * Represents a text (with optional formatting element(s)) within a document that can be read by a reader.
   */
  function TextContainer() {
    _classCallCheck(this, TextContainer);

    /**
     * Clean, analyzable text, without formatting.
     * @type {string}
     */
    this.text = "";
    /**
     * This text's formatting (e.g. bold text, links, etc.).
     * @type {module:tree/structure.FormattingElement[]}
     */
    this.formatting = [];
  }

  /**
   * Adds a text string to this container's text.
   *
   * @param {string} text The text to be added to the TextContainer.
   *
   * @returns {void}
   */


  _createClass(TextContainer, [{
    key: "appendText",
    value: function appendText(text) {
      this.text += text;
    }
  }]);

  return TextContainer;
}();

exports.default = TextContainer;
//# sourceMappingURL=TextContainer.js.map
