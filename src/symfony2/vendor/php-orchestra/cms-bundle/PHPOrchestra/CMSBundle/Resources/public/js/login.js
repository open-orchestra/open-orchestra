$('head')
	    .append(
	        '<style>html{height: 100%;overflow: hidden!important;}</style>'
)

runAllForms();

$( document ).ready(function() {
  // Handler for .ready() called.
});

$(function() {
	// Validation
	$("#login-form").validate({
		// Rules for form validation
		rules : {
			login : {
				required : true
			},
			password : {
				required : true,
				minlength : 3,
				maxlength : 20
			}
		},

		// Messages for form validation
		messages : {
			login : {
				required : 'Veuillez saisir votre identifiant'
			},
			password : {
				required : 'Veuillez saisir votre mot de passe'
			}
		},

		// Do not change code below
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
	$('#SITE_ID').on('change', function() {
		if ($(this).val()) {
			$("#login-form").submit();
		}
	});

	$('#lang').on('change', function() {
		if ($(this).val()) {
			$("#lang-form [name='lang']").val($(this).val());
			$("#lang-form").submit();
		}
	});
});