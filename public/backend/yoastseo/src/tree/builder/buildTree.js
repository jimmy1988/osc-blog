"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _parse = require("parse5");

var _TreeAdapter = require("./TreeAdapter");

var _TreeAdapter2 = _interopRequireDefault(_TreeAdapter);

var _postParsing = require("./cleanup/postParsing");

var _postParsing2 = _interopRequireDefault(_postParsing);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Parses the given html-string to a tree, to be used in further analysis.
 *
 * @param {string} html The html-string that should be parsed.
 *
 * @returns {module:tree/structure.Node} The build tree.
 *
 * @memberOf module:tree/builder
 */
var buildTree = function buildTree(html) {
	var treeAdapter = new _TreeAdapter2.default();
	/*
   Parsing of a HTML article takes on average 19ms
   (based on the fullTexts in the specs (n=24), measured using `console.time`).
  */
	var tree = (0, _parse.parseFragment)(html, { treeAdapter: treeAdapter, sourceCodeLocationInfo: true });
	// Cleanup takes < 2ms.
	tree = (0, _postParsing2.default)(tree, html);
	return tree;
};

exports.default = buildTree;
//# sourceMappingURL=buildTree.js.map
