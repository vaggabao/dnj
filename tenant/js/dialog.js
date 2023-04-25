$(function() {
	$(document).on('click', '.billing-row', function() {
		var id = $(this).data('id');
		var data = "billing_id=" + id;
		$.ajax({
			data: data,
			type: 'POST',
			url: '../includes/getBillingDetails.php',
			async: false,
			success: function(result) {
				$( '#btn-pay' ).attr('value', id);
				$( '#price-summary-table' ).html(result);
				$( '#billing-summary-modal' ).modal({
					show: true
				});
			}
		});
	});
});