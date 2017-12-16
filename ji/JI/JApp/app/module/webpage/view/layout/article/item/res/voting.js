

function add( id )
{


	var action = $(id).children().attr('action');
	var item_key = $(id).attr('item_key');

	var old_button_content = $(id).html();

	$(id).html('<i class="icon-spin animate-spin"></i><span>?</span>');

	var data =
	{
		'vote' : { 'action' : action , 'item_key' : item_key  }
	};

	//console.log( JSON.stringify(data));


	$.ajax
	(
		{
			type: 'POST',
			url: voteURL,
			cache:false,
			data: data,
			success: function(response)
			{

				console.log( JSON.stringify(response) );

				if( response.plus_id )
				{
					$('#'+response.plus_id).html(response.plus_content);
					$('#'+response.minus_id).html(response.minus_content);
				}
				else
				{

					$(id).html(old_button_content);
				}
			}
		}
	);
}



//use button instead of link, because button will not redirect

$('button').click
(

	function(e)
	{

		var id = '#' + $(e.target).attr('link_key');


		//var alink = $(id).prop('nodeName');

		var action = $(id).children().attr('action');


		if( 'add_plus' == action || 'remove_plus' == action || 'add_minus' == action || 'remove_minus' == action )
		{

			//console.log('detecting');
			add( id );
		}
	}
);
