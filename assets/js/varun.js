( function( $ ) {
	$( function() {
        $( ".reset-btn" ).on( 'click', function() {
            var element = document.querySelector('.varun_miusage_container');
            element.innerHTML = 'Loading .....';
            $.ajax({
                type : "GET",
                url : varun.ajax_url,
                data : {action: "varun_content"},
                success: function( response ) {
                    element.innerHTML = response;
                }
           });
        })
	} );
} )( jQuery );
