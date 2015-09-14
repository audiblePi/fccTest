jQuery(function() {

	var option = [];
	var price = [];

	tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
		editor.addButton( 'my_mce_button', {
			icon: false,
			type: 'button',
			text: 'Enter an Option',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Add an Installed Option',
					body: [
					{
						type: 'textbox',
						name: 'option_name',
						label: 'Option Name',
						value: 'e.g. Instrument Panel',
						onclick: function(e){
							jQuery('input[value="e.g. Instrument Panel"').val('');
						}
					},
					{
						type: 'textbox',
						name: 'option_price',
						label: 'Price',
						value: 'e.g. $129.99',
						role: 'price',
						onclick: function(){
							jQuery('input[value="e.g. $129.99"]').val('');
						}
					},
					{
						type: 'button',
						text: 'Add Additional Option',
						name: 'add_option',
						onclick: function(e){
							editor.insertContent( '[standard_option option_name="' + jQuery('input[value="e.g. Instrument Panel"').val() + '" option_price="' + jQuery('input[value="e.g. $129.99"]').val() + '"]');
							jQuery('div[aria-label="Add an Installed Option"] input').val('');

						}
					}
					],
					onsubmit: function( e ) {
						if (e.data.option_name != '') {
							editor.insertContent( '[standard_option option_name="' + e.data.option_name + '" option_price="' + e.data.price + ']');
						};
					}
				});
			}

		});
});

function stuff(){

}


})