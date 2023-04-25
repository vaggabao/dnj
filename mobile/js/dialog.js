$(function() {	
	$( "#btn-map" ).click(function() {
		$( '#map-modal' ).modal( 'show' );
	});
	
	$( "#btn-guide" ).click(function() {
		$( '#travel-modal' ).modal( 'show' );
	});
	
	$( "#btn-promenade" ).click(function() {
		$( '#promenades-modal' ).modal( 'show' );
	});
	
	$( '#btn-gallery' ).click(function() {
		var img_src = $(event.target).attr("src");
		var image_elem = "<img src='" + img_src + "' class='gallery-dialog-image' />";
		$("#image-div").html(image_elem);
		$( '#gallery-image-modal' ).modal( 'show' );
	});
  

	// bootstrap modal
	if ($( '#unavailable-prompt-modal' ).length > 0) {
		$( '#unavailable-prompt-modal' ).modal( 'show' );
	}
	
	if ($( '#exists-prompt-modal' ).length > 0) {
		$( '#exists-prompt-modal' ).modal( 'show' );
	}

    $( '#btnBook' ).click(function() {
        event.preventDefault();

        var sdate = $( '#startDate' ).val();
        var edate = $( '#endDate' ).val();

        $( '#start-date-hidden' ).val(sdate);
        $( '#end-date-hidden' ).val(edate);

        var reservation_fee = 0;
        var reservation_name = "";

        var data = "sdate=" + sdate + "&edate=" + edate;
        $.ajax({
        	type: 'GET',
        	data: data,
			async: false,
        	url: "../includes/getReservationPrice.php",
        	success: function(result) {
        		result = JSON.parse(result);

        		reservation_name = result[0];
        		reservation_fee = result[1];

        		$( '#sp-item-name' ).html(reservation_name);
        		$( '#sp-item-cost' ).html(reservation_fee);
        	},
        });

        $( '#reserv-modal' ).modal({
            show: true
        });
    });
});