(function() {
	tinymce.PluginManager.add( 'symple_shortcodes_mce_button', function( editor, url ) {
		editor.addButton( 'symple_shortcodes_mce_button', {
			title: 'Shortcodes',
			type: 'menubutton',
			icon: 'icon symple-shortcodes-icon',
			menu: [


						/* Columns */
						{
							text: 'Columns',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Shortcodes - Insert Column',
									body: [

									// Column Size
									{
										type: 'listbox',
										name: 'columnSize',
										label: 'Size',
										'values': [
											{text: '1/2', value: 'one_half'},
											{text: '1/2 Last', value: 'one_half_last'},
											{text: '1/3', value: 'one_third'},
											{text: '1/3 Last', value: 'one_third_last'},
											{text: '1/4', value: 'one_fourth'},
											{text: '1/4 Last', value: 'one_fourth_last'}
										]
									},

									// Column Content
									{
										type: 'textbox',
										name: 'columnContent',
										label: 'Content:',
										value: 'Your content here, lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vel mauris sit amet erat ultrices mattis fringilla eget justo.',
										multiline: true,
										minWidth: 300,
										minHeight: 100
									} ],
									onsubmit: function( e ) {
										editor.insertContent( '[symple_column size="' + e.data.columnSize + '"]<br />' + e.data.columnContent + '<br />[/symple_column]');
									}
								});
							}
						}, // End columns


				/** Elements **/
				{
					text: 'Elements',
					menu: [

						/* Buttons */
						{
							text: 'Buttons',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Shortcodes - Insert Button',
									body: [

									// Button Text
									{
										type: 'textbox',
										name: 'buttonText',
										label: 'Button: Text',
										value: 'Download'
									},

									// Button URL
									{
										type: 'textbox',
										name: 'buttonUrl',
										label: 'Button: URL',
										value: 'http://www.yoursite.com/'
									},

									// Button Color
									{
										type: 'listbox',
										name: 'buttonColor',
										label: 'Button: Color',
										'values': [
											{text: 'Black', value: 'black'},
											{text: 'Blue', value: 'blue'},
											{text: 'Green', value: 'green'},
											{text: 'Green 2', value: 'green2'},
											{text: 'Gold', value: 'gold'},
											{text: 'Orange', value: 'orange'},
											{text: 'Pink', value: 'pink'},
											{text: 'Red', value: 'red'}
										]
									},


									// Button Link Target
									{
										type: 'listbox',
										name: 'buttonLinkTarget',
										label: 'Button: Link Target',
										'values': [
											{text: 'Self', value: '_self'},
											{text: 'Blank', value: '_blank'}
										]
									}],
									onsubmit: function( e ) {
										editor.insertContent( '[symple_button url="' + e.data.buttonUrl + '" color="' + e.data.buttonColor + '"  button_target="' + e.data.buttonLinkTarget + '"]' + e.data.buttonText + '[/symple_button]');
									}
								});
							}
						}, // End button

					

						/* Boxes */
						{
							text: 'Boxes',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Shortcodes - Insert Box',
									body: [

									// Box Color
									{
										type: 'listbox',
										name: 'boxColor',
										label: 'Style:',
										'values': [
											{text: 'Info Box', value: 'boxinfo'},
											{text: 'Success Box', value: 'boxsucces'},
											{text: 'Warning Box', value: 'boxerror'},
											{text: 'Notice Box', value: 'boxnotice'}
										]
									}, 

									// Box Content
									{
										type: 'textbox',
										name: 'boxContent',
										label: 'Content:',
										value: 'Your content here, lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vel mauris sit amet erat ultrices mattis fringilla eget justo.',
										multiline: true,
										minWidth: 300,
										minHeight: 100
									}],
									onsubmit: function( e ) {
										editor.insertContent( '[symple_box style="' + e.data.boxColor + '"]<br />' + e.data.boxContent + '<br />[/symple_box]' );
									}
								});
							}
						}, // End boxes



						/* Lists */
						{
							text: 'Lists',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Shortcodes - Insert List',
									body: [

									// Box Color
									{
										type: 'listbox',
										name: 'listColor',
										label: 'Style:',
										'values': [
											{text: 'Simple List', value: 'simplelist'},
											{text: 'Blue List', value: 'minus-blue-list'},
											{text: 'Green List', value: 'minus-green-list'},
											{text: 'Orange List', value: 'minus-orange-list'},
											{text: 'Gold List', value: 'minus-gold-list'},
											{text: 'Black List', value: 'minus-black-list'}
										]
									}, 

									// li Content
									{
										type: 'textbox',
										name: 'liContent',
										label: '<li> content:',
										value: 'Your content here ...'
									},

									// li Content
									{
										type: 'textbox',
										name: 'liContent2',
										label: '<li> content:',
										value: 'Your content here ...'
									}],
									onsubmit: function( e ) {
										editor.insertContent( '[symple_ul style="' + e.data.listColor + '"]<br />[symple_li]' + e.data.liContent + '[/symple_li]<br />[symple_li]' + e.data.liContent2 + '[/symple_li]<br />[/symple_ul]' );
									}
								});
							}
						}, // End boxes


					]
				}, // End Elements Section




				/** More Start **/
				{
				text: 'More',
				menu: [

						/* Accordion */
						{
							text: 'Accordion',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Shortcodes - Insert Accordion',
									body: [


									// li Content
									{
										type: 'textbox',
										name: 'accTitle',
										label: 'Title:',
										value: 'Accordion Title'
									},

									// li Content
									{
										type: 'textbox',
										name: 'accContent',
										label: 'Content:',
										value: 'Your content here, lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vel mauris sit amet erat ultrices mattis fringilla eget justo.',
										multiline: true,
										minWidth: 300,
										minHeight: 100
									}],
									onsubmit: function( e ) {
										editor.insertContent( '[symple_accordion title="' + e.data.accTitle + '"]<br />[symple_accordion_section]<br />' + e.data.accContent + '<br />[/symple_accordion_section]' );
									}
								});
							}
						}, // End Accordion 


						/* Clear Floats */
						{
							text: 'Clear Floats',
							onclick: function() {
								editor.insertContent( '[symple_clear]');
							}
						}, // End accordion

					]
				} // End More section

			]
		});
	});
})();