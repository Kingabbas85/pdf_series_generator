/**
 * !
 *
 *  =========================================================
 * Material Bootstrap Wizard - v1.0.2
 *  =========================================================
 *
 * Product Page: https://www.creative-tim.com/product/material-bootstrap-wizard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/material-bootstrap-wizard/blob/master/LICENSE.md)
 *
 *  =========================================================
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * @format
 */

// Material Bootstrap Wizard Functions

var searchVisible = 0
var transparent = true
var mobile_device = false

$(document).ready(function () {
	$.material.init()

	/*  Activate the tooltips      */
	$('[rel="tooltip"]').tooltip()

	// Code for the Validator
	var $validator = $(".wizard-card form").validate({
		rules: {
			estimate_from: {
				required: true,
			},
			ship_from: {
				required: true,
			},
			ship_to: {
				required: true,
			},
			customer: {
				required: true,
			},
			cargo_value: {
				required: true,
			},
			customer: {
				required: true,
			},
			customer: {
				required: true,
			},
		},

		errorPlacement: function (error, element) {
			$(element).parent("div").addClass("has-error")
		},
	})

	// Wizard Initialization
	$(".wizard-card").bootstrapWizard({
		tabClass: "nav nav-pills",
		nextSelector: ".btn-next",
		previousSelector: ".btn-previous",

		onNext: function (tab, navigation, index) {
			var $valid = $(".wizard-card form").valid()
			if (!$valid) {
				$validator.focusInvalid()
				return false
			}
		},

		onInit: function (tab, navigation, index) {
			//check number of tabs and fill the entire row
			var $total = navigation.find("li").length
			var $wizard = navigation.closest(".wizard-card")

			$first_li = navigation.find("li:first-child a").html()
			$moving_div = $('<div class="moving-tab">' + $first_li + "</div>")
			$(".wizard-card .wizard-navigation").append($moving_div)

			refreshAnimation($wizard, index)

			$(".moving-tab").css("transition", "transform 0s")
		},

		onTabClick: function (tab, navigation, index) {
			var $valid = $(".wizard-card form").valid()

			if (!$valid) {
				return false
			} else {
				return true
			}
		},

		onTabShow: function (tab, navigation, index) {
			var $total = navigation.find("li").length
			var $current = index + 1

			var $wizard = navigation.closest(".wizard-card")

			// If it's the last tab then hide the last button and show the finish instead
			if ($current >= $total) {
				$($wizard).find(".btn-next").hide()
				$($wizard).find(".btn-finish").show()
			} else {
				$($wizard).find(".btn-next").show()
				$($wizard).find(".btn-finish").hide()
			}

			button_text = navigation
				.find("li:nth-child(" + $current + ") a")
				.html()

			setTimeout(function () {
				$(".moving-tab").text(button_text)
			}, 150)

			var checkbox = $(".footer-checkbox")

			if (!index == 0) {
				$(checkbox).css({
					opacity: "0",
					visibility: "hidden",
					position: "absolute",
				})
			} else {
				$(checkbox).css({
					opacity: "1",
					visibility: "visible",
				})
			}

			refreshAnimation($wizard, index)
		},
	})

	// Prepare the preview for profile picture
	$("#wizard-picture").change(function () {
		readURL(this)
	})

	$('[data-toggle="wizard-radio"]').click(function () {
		wizard = $(this).closest(".wizard-card")
		wizard.find('[data-toggle="wizard-radio"]').removeClass("active")
		$(this).addClass("active")
		$(wizard).find('[type="radio"]').removeAttr("checked")
		$(this).find('[type="radio"]').attr("checked", "true")
	})

	$('[data-toggle="wizard-checkbox"]').click(function () {
		if ($(this).hasClass("active")) {
			$(this).removeClass("active")
			$(this).find('[type="checkbox"]').removeAttr("checked")
		} else {
			$(this).addClass("active")
			$(this).find('[type="checkbox"]').attr("checked", "true")
		}
	})

	$(".set-full-height").css("height", "auto")

	// custom code
	$("#shipping_details #ship_to").change(function () {
		var ship_to = $(this).val()
		console.log(ship_to)
		$.ajax({
			url: Domain + "ajaxcallforcalculation.php",
			method: "POST",
			data: {
				getDutyTaxes: 1,
				ship_to: ship_to,
			},
			success: function (response) {
				// console.log(response);
				response = JSON.parse(response)
				console.log(response.message)
				var duty_tax = response.message.duty_tax
				var customs_brokerage = response.message.customs_brokerage
				var handling = response.message.handling
				var ior = response.message.ior
				var admin_bank_charges = response.message.admin_bank_charges

				$("#duty_tax_value").val(duty_tax)
				$("#customs_brokerage_value").val(customs_brokerage)
				$("#handling_value").val(handling)
				$("#ior_value").val(ior)
				$("#admin_bank_charges_value").val(admin_bank_charges)

				Calculate()
			},
		})
	})

	function Calculate() {
		var duty_tax = $("#duty_tax_value").val()
		var customs_brokerage = $("#customs_brokerage_value").val()
		var handling = $("#handling_value").val()
		var ior = $("#ior_value").val()
		var admin_bank_charges = $("#admin_bank_charges_value").val()

		var cargo_value = $("#cargo_value").val()
		cargo_value = cargo_value * 1

		if (cargo_value == 0) {
			$("#ior").val(0)
			$("#duty_tax").val(0)
			$(".ior_label_class").removeClass("is-empty")
			$(".dusty_tax_label_class").addClass("is-empty")
			$(".estimated_vat_label_class").addClass("is-empty")
		} else {
			if (cargo_value * 0.05 > ior) {
				$(".ior_label").hide()
				$("#ior").val((cargo_value * 0.05).toFixed(2))
			} else {
				$(".ior_label").hide()
				$("#ior").val(ior)
			}
			$(".ior_label_class").removeClass("is-empty")
			$(".dusty_tax_label_class").removeClass("is-empty")
			$(".estimated_vat_label_class").removeClass("is-empty")
		}
		if (cargo_value == "") {
			$("#ior").val("")
			$("#duty_tax").val("")

			$(".ior_label_class").addClass("is-empty")
			$(".dusty_tax_label_class").addClass("is-empty")
			$(".estimated_vat_label_class").addClass("is-empty")
		}
		//DutyTax
		if (cargo_value) {
			var duty_tax_percentage = duty_tax / 100 //country wise from rates table
			$("#duty_tax").val((cargo_value * duty_tax_percentage).toFixed(2))
		}

		// Custom brokerage
		if (customs_brokerage) {
			$(".customs_brokerage_label").removeClass("is-empty")
			$("#customs_brokerage").val(customs_brokerage) //country wise from rates table
		}

		// if (custom_field_name) {
		// 	$(".custom_field_name_label").removeClass("is-empty")
		// 	$("#custom_field_name").val(custom_field_name) //country wise from rates table
		// }

		// Handling charges
		var package_gross_weight = parseFloat($("#package_gross_weight").val())
		var volumetric_weight = parseFloat($("#volumetric_weight").val())
		console.log(package_gross_weight, volumetric_weight)
		// Calculate the three values
		if (volumetric_weight && package_gross_weight) {
			var flat_fee = handling
			var gross_weight_fee = package_gross_weight * 0.75
			var volumetric_weight_fee = volumetric_weight * 0.75
			// Get the maximum value among the three
			var max_value = Math.max(
				flat_fee,
				gross_weight_fee,
				volumetric_weight_fee
			)
			if (max_value) {
				$("#handling_charges").val(max_value.toFixed(2))
				$(".handling_charges_span").text(max_value.toFixed(2))
			}
		}

		//Admin Bank Charges
		if (admin_bank_charges) {
			$(".admin_bank_charges_label").removeClass("is-empty")
			$("#admin_bank_charges").val(admin_bank_charges) //country wise from rates table
		}
		// Display the result (e.g., in an element with id 'max_value')

		//Last Time delivery
		var last_mile_delivery_fee = $("#last_mile_delivery").val()

		if (
			volumetric_weight &&
			package_gross_weight &&
			last_mile_delivery_fee
		) {
			var last_fee = last_mile_delivery_fee
			var gross_weight_fee = package_gross_weight * 1
			var volumetric_weight_fee = volumetric_weight * 1

			// Get the maximum value among the three
			var last_mile_delivery_charge = Math.max(
				last_fee,
				gross_weight_fee,
				volumetric_weight_fee
			)

			// Display the result (e.g., in an element with id 'last_mile_delivery')
			$("#last_mile_delivery").val(last_mile_delivery_charge.toFixed(2))
		}
		//Call
		calculateGrandTotal()
	}

	$("#charges #cargo_value").keyup(function () {
		Calculate()
		calculateGrandTotal()
		calculateEstimatedVAT()
	})

	$("#package_gross_weight").keyup(function () {
		Calculate()
		calculateGrandTotal()
	})

	//////////////////For last time
	//setup before functions
	var typingTimer //timer identifier
	var doneTypingInterval = 1500 //time in ms, 5 seconds for example
	var $input = $("#last_mile_delivery")

	//on keyup, start the countdown
	$input.on("keyup", function () {
		clearTimeout(typingTimer)
		typingTimer = setTimeout(doneTyping, doneTypingInterval)
	})

	//on keydown, clear the countdown
	$input.on("keydown", function () {
		clearTimeout(typingTimer)
	})

	//user is "finished typing," do something
	function doneTyping() {
		Calculate()
		calculateGrandTotal()
	}
	//////////////////For last time

	$("#length, #width, #height").keyup(function () {
		// Get the values from the length, width, and height fields
		var length = $("#length").val() * 1
		var width = $("#width").val() * 1
		var height = $("#height").val() * 1

		// Calculate the package dimension (volume)
		var packageDimension = length * width * height

		// Set the package dimension value in the disabled input
		$("#package_dimension").val(packageDimension.toFixed(2))

		// Calculate the volumetric weight (package dimension divided by 5000)
		var volumetricWeight = packageDimension / 5000

		// Set the volumetric weight value in the disabled input
		$("#volumetric_weight").val(volumetricWeight.toFixed(2))
		if (length || width || height) {
			$(".package_dimension_label_class").removeClass("is-empty")
			$(".volumetric_weight_label_class").removeClass("is-empty")
		}
		if (length == "" && width == "" && height == "") {
			$("#package_dimension").val("")
			$("#volumetric_weight").val("")
			$(".package_dimension_label_class").addClass("is-empty")
			$(".volumetric_weight_label_class").addClass("is-empty")
		}

		Calculate()
		calculateGrandTotal()

		// // Calculate the handling charges or any other values here
		// var handlingValue = volumetricWeight * /* your rate or calculation here */;

		// // Display the handling value in the span with class handling_value
		// $(".handling_value").text(handlingValue);
	})

	$(
		"#ior, #duty_tax, #freight, #estimated_vat, #customs_brokerage, #import_permit_approval, #handling_charges, #admin_bank_charges, #compliance_certification, #storage, #last_mile_delivery"
	).on("input", calculateGrandTotal)
	function calculateGrandTotal() {
		// Initialize total
		var total = 0

		// Sum the values of the input fields
		total += parseFloat($("#ior").val()) || 0
		total += parseFloat($("#duty_tax").val()) || 0
		total += parseFloat($("#estimated_vat").val()) || 0
		total += parseFloat($("#freight").val()) || 0
		total += parseFloat($("#customs_brokerage").val()) || 0
		total += parseFloat($("#import_permit_approval").val()) || 0
		total += parseFloat($("#handling_charges").val()) || 0
		total += parseFloat($("#admin_bank_charges").val()) || 0
		total += parseFloat($("#compliance_certification").val()) || 0
		total += parseFloat($("#storage").val()) || 0
		total += parseFloat($("#last_mile_delivery").val()) || 0

		// Update the grand_total field
		$("#grand_total").val(total.toFixed(2))
		$(".grand_total_label").removeClass("is-empty")
	}

	function calculateEstimatedVAT() {
		// Retrieve values
		const cargoValue = parseFloat($("#cargo_value").val()) || 0
		const dutyTax = parseFloat($("#duty_tax").val()) || 0
		const freight = parseFloat($("#freight").val()) || 0

		// Calculate Estimated VAT
		const estimatedVAT = (cargoValue + dutyTax + freight) * 0.2

		// Set the value of the estimated_vat field
		$("#estimated_vat").val(estimatedVAT.toFixed(2))
	}

	$('input[name="get_estimate"]').on("click", function () {
		$("#estimateForm").find(":disabled").prop("disabled", false)
		var formData = $("#estimateForm").serialize()

		// Make the AJAX call to load the modal content
		$.ajax({
			url: Domain + "/ajaxcallforloadestimate.php", // The URL to the PHP file that returns the modal content
			type: "POST",
			data: formData + "&getEstimateModalContent=1",
			success: function (response) {
				// Load the response into the modal body
				$("#estimateModal .modal-body").html(response)
				// Show the modal
				// $("#estimateModal").modal("show")
				$("#estimateModal").modal(
					{ backdrop: "static", keyboard: false },
					"show"
				)
				$(".wizard-container").hide()
				// Re-disable the fields that were disabled
				$("#estimateForm").find(":disabled").prop("disabled", true)
			},
			error: function () {
				alert("Failed to load the estimate. Please try again.")
			},
		})
	})
	$("#estimateModal").on("hidden.bs.modal", function () {
		$(".wizard-container").show()
		$("#estimateForm").find(":disabled").prop("disabled", true)
	})
})

//Function to show image before upload

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader()

		reader.onload = function (e) {
			$("#wizardPicturePreview")
				.attr("src", e.target.result)
				.fadeIn("slow")
		}
		reader.readAsDataURL(input.files[0])
	}
}

$(window).resize(function () {
	$(".wizard-card").each(function () {
		$wizard = $(this)

		index = $wizard.bootstrapWizard("currentIndex")
		refreshAnimation($wizard, index)

		$(".moving-tab").css({
			transition: "transform 0s",
		})
	})
})

function refreshAnimation($wizard, index) {
	$total = $wizard.find(".nav li").length
	$li_width = 100 / $total

	total_steps = $wizard.find(".nav li").length
	move_distance = $wizard.width() / total_steps
	index_temp = index
	vertical_level = 0

	mobile_device = $(document).width() < 600 && $total > 3

	if (mobile_device) {
		move_distance = $wizard.width() / 2
		index_temp = index % 2
		$li_width = 50
	}

	$wizard.find(".nav li").css("width", $li_width + "%")

	step_width = move_distance
	move_distance = move_distance * index_temp

	$current = index + 1

	if ($current == 1 || (mobile_device == true && index % 2 == 0)) {
		move_distance -= 8
	} else if (
		$current == total_steps ||
		(mobile_device == true && index % 2 == 1)
	) {
		move_distance += 8
	}

	if (mobile_device) {
		vertical_level = parseInt(index / 2)
		vertical_level = vertical_level * 38
	}

	$wizard.find(".moving-tab").css("width", step_width)
	$(".moving-tab").css({
		transform:
			"translate3d(" + move_distance + "px, " + vertical_level + "px, 0)",
		transition: "all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)",
	})
}

materialDesign = {
	checkScrollForTransparentNavbar: debounce(function () {
		if ($(document).scrollTop() > 260) {
			if (transparent) {
				transparent = false
				$(".navbar-color-on-scroll").removeClass("navbar-transparent")
			}
		} else {
			if (!transparent) {
				transparent = true
				$(".navbar-color-on-scroll").addClass("navbar-transparent")
			}
		}
	}, 17),
}

function debounce(func, wait, immediate) {
	var timeout
	return function () {
		var context = this,
			args = arguments
		clearTimeout(timeout)
		timeout = setTimeout(function () {
			timeout = null
			if (!immediate) func.apply(context, args)
		}, wait)
		if (immediate && !timeout) func.apply(context, args)
	}
}
