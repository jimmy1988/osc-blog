"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
/**
 * Gets the content of an element (the part _between_ the opening and closing tag) from the HTML source code.
 *
 * @param {module:tree/structure.Node|module:tree/structure.FormattingElement} element The element to parse the contents of
 * @param {string} html                                                                The source code to parse the contents from
 *
 * @returns {string} The element's contents.
 *
 * @private
 */
var getElementContent = function getElementContent(element, html) {
  var location = element.location;
  if (location) {
    var start = location.startTag ? location.startTag.endOffset : location.startOffset;
    var end = location.endTag ? location.endTag.startOffset : location.endOffset;
    return html.slice(start, end);
  }
  return "";
};

exports.default = getElementContent;
//# sourceMappingURL=getElementContent.js.map
