"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

exports.default = function (i18n) {
	return {
		feedback: {
			className: "na",
			screenReaderText: i18n.dgettext("js-text-analysis", "Feedback"),
			fullText: i18n.dgettext("js-text-analysis", "Content optimization: Has feedback"),
			screenReaderReadabilityText: ""
		},
		bad: {
			className: "bad",
			screenReaderText: i18n.dgettext("js-text-analysis", "Needs improvement"),
			fullText: i18n.dgettext("js-text-analysis", "Content optimization: Needs improvement"),
			screenReaderReadabilityText: i18n.dgettext("js-text-analysis", "Needs improvement")
		},
		ok: {
			className: "ok",
			screenReaderText: i18n.dgettext("js-text-analysis", "OK SEO score"),
			fullText: i18n.dgettext("js-text-analysis", "Content optimization: OK SEO score"),
			screenReaderReadabilityText: i18n.dgettext("js-text-analysis", "OK")
		},
		good: {
			className: "good",
			screenReaderText: i18n.dgettext("js-text-analysis", "Good SEO score"),
			fullText: i18n.dgettext("js-text-analysis", "Content optimization: Good SEO score"),
			screenReaderReadabilityText: i18n.dgettext("js-text-analysis", "Good")
		}
	};
};
//# sourceMappingURL=presenter.js.map
