"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

exports.default = function (string, formatMap) {
	var delimiter = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "%%";

	delimiter = (0, _lodashEs.escapeRegExp)(delimiter);
	var parameterRegex = new RegExp(delimiter + "(.+?)" + delimiter, "g");
	var match = void 0;
	var formattedString = string;

	// Try to match and replace each occurrence of "%%something%%" in the string.
	while ((match = parameterRegex.exec(string)) !== null) {
		var key = match[1];
		// Create regex from parameter (e.g. "%%key%%")
		var replaceRegex = new RegExp("" + delimiter + (0, _lodashEs.escapeRegExp)(key) + delimiter, "g");
		// Replace occurrence (if parameter exists in the format map).
		if (key in formatMap) {
			formattedString = formattedString.replace(replaceRegex, formatMap[key]);
		}
	}

	return formattedString;
};

var _lodashEs = require("lodash-es");
//# sourceMappingURL=formatString.js.map
