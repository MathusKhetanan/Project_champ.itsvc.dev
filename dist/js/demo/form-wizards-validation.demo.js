/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 4.6.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin/admin/
*/

var handleBootstrapWizardsValidation = function() {
	"use strict";
	$('#wizard').smartWizard({ 
		selected: 0, 
		theme: 'default',
		transitionEffect:'',
		transitionSpeed: 0,
		useURLhash: false,
		showStepURLhash: false,
		enableFinishButton: true,
		toolbarSettings: {
			toolbarPosition: 'bottom'
		},
		lang: { // Language variables for button
      next: 'ถัดไป',
      previous: 'ย้อนกลับ'
  }
	});
	$('#wizard').on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
		var res = $('form[name="form-wizard"]').parsley().validate('step-' + (stepNumber + 1));
		return res;
	});
	
	$('#wizard').keypress(function( event ) {
		if (event.which == 13 ) {
			$('#wizard').smartWizard('next');
		}
	});

	$("#wizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
		$('button.sw-btn-prev').show();	
		$('button.sw-btn-next').show();		
		$('button.sw-btn-submit').hide();	
		if($('button.sw-btn-next').hasClass('disabled')){
			$('button.sw-btn-next').hide();	
			$(".sw-btn-group").append('<button type="submit" class="btn btn-secondary sw-btn-submit sw-btn-next">ยืนยันข้อมูล</button>');	
		}
	});
};

var FormWizardValidation = function () {
	"use strict";
	return {
		//main function
		init: function () {
			handleBootstrapWizardsValidation();
		}
	};
}();

$(document).ready(function() {
	FormWizardValidation.init();
});