"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _structure = require("../../structure");

var _Ignored = require("../../structure/nodes/Ignored");

var _Ignored2 = _interopRequireDefault(_Ignored);

var _calculateTextIndices = require("./calculateTextIndices");

var _calculateTextIndices2 = _interopRequireDefault(_calculateTextIndices);

var _getElementContent = require("./getElementContent");

var _getElementContent2 = _interopRequireDefault(_getElementContent);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Calculates the start and end index of the given node or formatting element,
 * based on its source code location as parsed by `parse5`.
 *
 * @param {module:tree/structure.Node|module:tree/structure.FormattingElement} element  The element to set the start and end index of
 *
 * @returns {void}
 *
 * @private
 */
var calculateSourceIndices = function calculateSourceIndices(element) {
  if (element.location) {
    element.sourceStartIndex = element.location.startOffset;
    element.sourceEndIndex = element.location.endOffset;
  }
};

/**
 * Deletes parameters from the element that are used during parsing,
 * but are not needed for analysis.
 *
 * @param {Object} element  The element to delete parameters of.
 *
 * @returns {void}
 *
 * @private
 */
var deleteParseParameters = function deleteParseParameters(element) {
  delete element.location;
  delete element.namespace;
  delete element.tagName;
  delete element.documentMode;
};

/**
 * Cleans up a node in the tree.
 *
 * @param {module:tree/structure.Node} node The node that needs to be cleaned.
 * @param {string} html                     The original html source code from which the node has been parsed.
 *
 * @returns {module:tree/structure.Node} The cleaned up node.
 *
 * @private
 */
var cleanUpNode = function cleanUpNode(node, html) {
  // Set content of ignored node, based on original source code.
  if (node instanceof _Ignored2.default) {
    node.content = (0, _getElementContent2.default)(node, html);
  }

  // Clean up formatting elements in headings and paragraphs.
  if (node instanceof _structure.LeafNode) {
    // Start and end position in leaf node's (header's or paragraph's) text without formatting.
    (0, _calculateTextIndices2.default)(node, html);
    node.textContainer.formatting = node.textContainer.formatting.map(function (element) {
      // Start and end position in text **with** formatting.
      calculateSourceIndices(element);
      deleteParseParameters(element);

      return element;
    });
  }

  calculateSourceIndices(node);
  deleteParseParameters(node);

  return node;
};

/**
 * Sets the end index of the root node to the end of the text.
 *
 * @param {module:tree/structure.Node} tree The tree of which to set the root node's end index.
 *
 * @returns {void}
 *
 * @private
 */
var setEndIndexRootNode = function setEndIndexRootNode(tree) {
  var endIndexRootNode = 0;
  tree.forEach(function (node) {
    endIndexRootNode = Math.max(node.sourceEndIndex, endIndexRootNode);
  });
  tree.sourceEndIndex = endIndexRootNode;
};

/**
 * Cleans up the given tree after parsing of the HTML source code.
 *
 * These steps are setting the start and end index of each node and
 * deleting attributes needed for parsing, but not needed for further analysis.
 *
 * @param {module:tree/structure.Node} tree The tree structure to be cleaned.
 * @param {string} html                     The original HTML source code.
 *
 * @returns {module:tree/structure.Node} The cleaned up tree.
 *
 * @private
 */
var cleanUpTree = function cleanUpTree(tree, html) {
  tree.map(function (node) {
    return cleanUpNode(node, html);
  });
  setEndIndexRootNode(tree);
  return tree;
};

exports.default = cleanUpTree;
//# sourceMappingURL=postParsing.js.map
