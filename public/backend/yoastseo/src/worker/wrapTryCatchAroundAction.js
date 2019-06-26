"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.default = wrapTryCatchAroundAction;

var _formatString = require("../helpers/formatString");

var _formatString2 = _interopRequireDefault(_formatString);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * Logs and formats the error message to send back to the plugin
 * when an analysis web worker action fails.
 *
 * @param {Logger}	logger					The logger instance to log with.
 * @param {Error} 	error					The error to log.
 * @param {Object}	payload					The action payload.
 * @param {string} 	[errorMessagePrefix=""]	The prefix of the error message.
 *
 * @returns {string} the error message to send back.
 */
var handleError = function handleError(logger, error, payload) {
	var errorMessagePrefix = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "";

	// Try to format the string with payload parameters, if there are any.
	if (payload) {
		errorMessagePrefix = (0, _formatString2.default)(errorMessagePrefix, payload);
	}

	var errorMessage = errorMessagePrefix ? [errorMessagePrefix] : [];

	if (error.name && error.message) {
		if (error.stack) {
			logger.debug(error.stack);
		}
		// Standard JavaScript error (e.g. when calling `throw new Error( message )`).
		errorMessage.push(error.name + ": " + error.message);
	}

	errorMessage = errorMessage.join("\n\t");
	logger.error(errorMessage);
	return errorMessage;
};

/**
 * Wraps the given action in a try-catch that logs the error message.
 *
 * @param {Logger}   logger                  The logger instance to log with.
 * @param {Function} action                  The action to safely run.
 * @param {string}   [errorMessagePrefix=""] The prefix of the error message.
 *
 * @returns {Function} The wrapped action.
 */
function wrapTryCatchAroundAction(logger, action) {
	var errorMessagePrefix = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";

	return function () {
		try {
			return action.apply(undefined, arguments);
		} catch (error) {
			var errorMessage = handleError(logger, error, arguments.length <= 1 ? undefined : arguments[1], errorMessagePrefix);
			return { error: errorMessage };
		}
	};
}
//# sourceMappingURL=wrapTryCatchAroundAction.js.map
