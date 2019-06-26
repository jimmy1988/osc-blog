"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.cornerstoneAssessmentListFactories = exports.cornerstoneAssessorFactories = exports.assessorFactories = exports.Assessments = exports.ScoreAggregators = exports.TreeAssessor = undefined;

var _TreeAssessor = require("./TreeAssessor");

var _TreeAssessor2 = _interopRequireDefault(_TreeAssessor);

var _scoreAggregators = require("./scoreAggregators");

var ScoreAggregators = _interopRequireWildcard(_scoreAggregators);

var _assessments = require("./assessments");

var Assessments = _interopRequireWildcard(_assessments);

var _assessorFactories = require("./assessorFactories");

var assessorFactories = _interopRequireWildcard(_assessorFactories);

var _cornerstone = require("./cornerstone");

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj.default = obj; return newObj; } }

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Contains the logic to assess a tree representation of a text.
 *
 * @module tree/assess
 *
 * @see module:tree/structure
 */
exports.TreeAssessor = _TreeAssessor2.default;
exports.ScoreAggregators = ScoreAggregators;
exports.Assessments = Assessments;
exports.assessorFactories = assessorFactories;
exports.cornerstoneAssessorFactories = _cornerstone.cornerstoneAssessorFactories;
exports.cornerstoneAssessmentListFactories = _cornerstone.cornerstoneAssessmentListFactories;
//# sourceMappingURL=index.js.map
