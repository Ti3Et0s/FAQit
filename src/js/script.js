
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
