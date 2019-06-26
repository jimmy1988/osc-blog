"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _lodashEs = require("lodash-es");

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * This contains all possible, default researches
 * and logic to apply these researches to a formatted text,
 * represented as a tree structure.
 *
 * @memberOf module:tree/research
 */
var TreeResearcher = function () {
	/**
  * Makes a new TreeResearcher.
  */
	function TreeResearcher() {
		_classCallCheck(this, TreeResearcher);

		this._researches = {};
		this._data = {};
	}

	/**
  * Adds or overwrites a research to the list of available researches.
  *
  * **Note**: When a research is already known under the given name,
  * the previous research with this name gets overwritten!
  *
  * @param {string} name       The ID to which to map the research to.
  * @param {Research} research The research to add.
  *
  * @returns {void}
  */


	_createClass(TreeResearcher, [{
		key: "addResearch",
		value: function addResearch(name, research) {
			this._researches[name] = research;
		}

		/**
   * Returns all available researches.
   *
   * @returns {Object} An object containing all available researches.
   */

	}, {
		key: "getResearches",
		value: function getResearches() {
			return this._researches;
		}

		/**
   * Returns whether a research is known under this name.
   *
   * @param {string} name The name to get the research from.
   *
   * @returns {boolean} If a research is known under this name.
   */

	}, {
		key: "hasResearch",
		value: function hasResearch(name) {
			return (0, _lodashEs.has)(this._researches, name);
		}

		/**
   * Gets the research with the given name.
   * If a research is not known under this name, false is returned instead.
   *
   * @throws {Error} When a research is not known under the given name.
   *
   * @param {string} name The name of the research to get.
   *
   * @returns {Research} The research stored under the given name.
   */

	}, {
		key: "getResearch",
		value: function getResearch(name) {
			if (this.hasResearch(name)) {
				return this._researches[name];
			}
			throw new Error("'" + name + "' research does not exist.");
		}

		/**
   * Applies the research with the given name to the node and its descendants.
   *
   * @param {string} name                     The name of the research to apply to the node.
   * @param {module:tree/structure.Node} node The node to compute the research of.
   * @param {boolean} [bustCache=false]       If we should force the results, as cached on each node, to be recomputed.
   *
   * @returns {Promise<*>} A promising research result.
   */

	}, {
		key: "doResearch",
		value: async function doResearch(name, node) {
			var _this = this;

			var bustCache = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

			var research = this.getResearch(name);
			var researchResult = Promise.resolve();

			if (research.isLeafNode(node)) {
				/*
      Compute research results for this node, or use the cached results when available.
      Always compute it when we need to bust the cache.
     */
				if (!node.hasResearchResult(name) || bustCache) {
					node.setResearchResult(name, (await research.calculateFor(node)));
				}
				researchResult = node.getResearchResult(name);
			} else {
				var children = node.children;

				// Heading and paragraph nodes do not have children.
				if (children) {
					var resultsForChildren = await Promise.all(children.map(function (child) {
						return _this.doResearch(name, child);
					}));

					researchResult = research.mergeChildrenResults(resultsForChildren);
				}
			}

			return researchResult;
		}

		/**
   * Add research data to the researcher by the research name.
   *
   * @param {string} researchName The identifier of the research.
   * @param {Object} data         The data object.
   *
   * @returns {void}.
   */

	}, {
		key: "addResearchData",
		value: function addResearchData(researchName, data) {
			this._data[researchName] = data;
		}

		/**
   * Return the research data from a research data provider by research name.
   *
   * @param {string} researchName The identifier of the research.
   *
   * @returns {Object|boolean} The data provided by the provider, false if the data do not exist
   */

	}, {
		key: "getData",
		value: function getData(researchName) {
			return (0, _lodashEs.get)(this._data, researchName, false);
		}
	}]);

	return TreeResearcher;
}();

exports.default = TreeResearcher;
//# sourceMappingURL=TreeResearcher.js.map
