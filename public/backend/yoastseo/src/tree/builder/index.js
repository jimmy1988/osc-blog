"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _buildTree = require("./buildTree");

var _buildTree2 = _interopRequireDefault(_buildTree);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * This module contains the main logic to transform a formatted text (for now only HTML is supported)
 * to a tree representation.
 *
 * This tree structure in turn can be used for further textual analysis.
 *
 * @module tree/builder
 *
 * @see module:tree/structure
 */

exports.default = _buildTree2.default;
//# sourceMappingURL=index.js.map
