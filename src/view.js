/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */

// Get all the clickable-faq elements
var clickableFaqs = document.querySelectorAll('.clickable-faq');

// Loop through each clickable-faq element
clickableFaqs.forEach(function (clickableFaq) {
	// Add click event listener
	clickableFaq.addEventListener('click', function () {
		console.log('clickableFaq');
		// Toggle the class to open/close the description
		var descriptionElement = this.querySelector('.description');
		descriptionElement.classList.toggle('open');

		// Toggle the rotation of the SVG
		var svgElement = this.querySelector('.expand-collapse svg');
		svgElement.classList.toggle('rotated');
	});
});

/* eslint-enable no-console */
