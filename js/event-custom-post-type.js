jQuery
(
	function( $ )
	{
		$( document ).ready
		(
			function()
			{
				increment = 1 / 12;
				$( '#startdate' ).datepicker
				(
					{
						dateFormat				: 'yy-mm-dd',
						showButtonPanel		: true,
						changeMonth				: true,
						changeYear				: true,
						showAnim					: 'slideDown',
						onSelect					: function( selectedDate )
						{
							$( "#enddate" ).datepicker( "option", "minDate", selectedDate );
						}
					}
				);
				$( '#enddate' ).datepicker
				(
					{
						dateFormat				: 'yy-mm-dd',
						showButtonPanel		: true,
						changeMonth				: true,
						changeYear				: true,
						showAnim					: 'slideDown',
						onSelect					: function( selectedDate )
						{
							$( "#startdate" ).datepicker( "option", "maxDate", selectedDate );
						}
					}
				);
				$( '#starttimeslider' ).slider
				(
					{
						min				: 0,
						max				: 24 - increment,
						step			: increment,
						slide			: function( event, ui )
						{
							starthour = Math.floor( ui.value );
							startminute = Math.round( ( ui.value - starthour ) * 60 );
							startminute = startminute < 10 ? '0' + startminute : startminute;
							startampm = 'am';
							if( starthour > 11 )
							{
								starthour = starthour - 12;
								startampm = 'pm';
							}
							starthour = starthour == 0 ? 12 : starthour;
							$( '#starttimehour' ).val( starthour );
							$( '#starttimeminute' ).val( startminute );
							$( '#starttimeampm' ).val( startampm );
						}
					}
				);
				$( '#endtimeslider' ).slider
				(
					{
						min				: 0,
						max				: 24 - increment,
						step			: increment,
						slide			: function( event, ui )
						{
							starthour = Math.floor( ui.value );
							startminute = Math.round( ( ui.value - starthour ) * 60 );
							startminute = startminute < 10 ? '0' + startminute : startminute;
							startampm = 'am';
							if( starthour > 11 )
							{
								starthour = starthour - 12;
								startampm = 'pm';
							}
							starthour = starthour == 0 ? 12 : starthour;
							$( '#endtimehour' ).val( starthour );
							$( '#endtimeminute' ).val( startminute );
							$( '#endtimeampm' ).val( startampm );
						}
					}
				);
				$( '#starttimehour,#starttimeminute,#starttimeampm').change
				(
					function()
					{
						starthour = parseInt( $( '#starttimehour' ).val() );
						startminute = parseInt( $( '#starttimeminute' ).val() );
						startampm = $( '#starttimeampm' ).val();
						if( startampm == 'pm' && starthour != 12 )
							starthour = starthour + 12;
						if( startampm == 'am' && starthour == 12 )
							starthour = 0;
						slidervalue = starthour + ( startminute / 60 );
						$( '#starttimeslider' ).slider( 'value', slidervalue );
					}
				);
				$( '#endtimehour,#endtimeminute,#endtimeampm').change
				(
					function()
					{
						endhour = parseInt( $( '#endtimehour' ).val() );
						endminute = parseInt( $( '#endtimeminute' ).val() );
						endampm = $( '#endtimeampm' ).val();
						if( endampm == 'pm' && endhour != 12 )
							endhour = endhour + 12;
						if( endampm == 'am' && endhour == 12 )
							endhour = 0;
						slidervalue = endhour + ( endminute / 60 );
						$( '#endtimeslider' ).slider( 'value', slidervalue );
					}
				);
				starthour = parseInt( $( '#starttimehour' ).val() );
				startminute = parseInt( $( '#starttimeminute' ).val() );
				startampm = $( '#starttimeampm' ).val();
				if( startampm == 'pm' && starthour != 12 )
					starthour = starthour + 12;
				if( startampm == 'am' && starthour == 12 )
					starthour = 0;
				slidervalue = starthour + ( startminute / 60 );
				$( '#starttimeslider' ).slider( 'value', slidervalue );
				endhour = parseInt( $( '#endtimehour' ).val() );
				endminute = parseInt( $( '#endtimeminute' ).val() );
				endampm = $( '#endtimeampm' ).val();
				if( endampm == 'pm' && endhour != 12 )
					endhour = endhour + 12;
				if( endampm == 'am' && endhour == 12 )
					endhour = 0;
				slidervalue = endhour + ( endminute / 60 );
				$( '#endtimeslider' ).slider( 'value', slidervalue );
				
				$( '#allday' ).change
				(
					function()
					{
						if( $( this ).is( ':checked' ) )
							$( '.eventtime' ).hide();
						else
							$( '.eventtime' ).show();
					}
				);
			}
		);
	}
);