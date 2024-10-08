/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dialog.add( 'dota_2_heroes', function( editor )
{
	var config = editor.config,
		images = config.dota_2_heroes_images,
		columns = config.dota_2_heroes_columns || 8,
		i;


	/**
	 * Simulate "this" of a dialog for non-dialog events.
	 * @type {CKEDITOR.dialog}
	 */
	var dialog;
	var onClick = function( evt )
	{
		var target = evt.data.getTarget(),
			targetName = target.getName();

		if ( targetName == 'a' )
			target = target.getChild( 0 );
		else if ( targetName != 'img' )
			return;

		var src = target.getAttribute( 'cke_src' ),
			title = target.getAttribute( 'title' );

		var img = editor.document.createElement( 'img',
			{
				attributes :
				{
					src : src,
					title : title,
					alt : title,
					class : 'hero_icon'
				}
			});

		editor.insertElement( img );
		editor.insertText( title + ' ');

		dialog.hide();
		evt.data.preventDefault();
	};

	var onKeydown = CKEDITOR.tools.addFunction( function( ev, element )
	{
		ev = new CKEDITOR.dom.event( ev );
		element = new CKEDITOR.dom.element( element );
		var relative, nodeToMove;

		var keystroke = ev.getKeystroke(),
			rtl = editor.lang.dir == 'rtl';
		switch ( keystroke )
		{
			// UP-ARROW
			case 38 :
				// relative is TR
				if ( ( relative = element.getParent().getParent().getPrevious() ) )
				{
					nodeToMove = relative.getChild( [element.getParent().getIndex(), 0] );
					nodeToMove.focus();
				}
				ev.preventDefault();
				break;
			// DOWN-ARROW
			case 40 :
				// relative is TR
				if ( ( relative = element.getParent().getParent().getNext() ) )
				{
					nodeToMove = relative.getChild( [element.getParent().getIndex(), 0] );
					if ( nodeToMove )
						nodeToMove.focus();
				}
				ev.preventDefault();
				break;
			// ENTER
			// SPACE
			case 32 :
				onClick( { data: ev } );
				ev.preventDefault();
				break;

			// RIGHT-ARROW
			case rtl ? 37 : 39 :
			// TAB
			case 9 :
				// relative is TD
				if ( ( relative = element.getParent().getNext() ) )
				{
					nodeToMove = relative.getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault(true);
				}
				// relative is TR
				else if ( ( relative = element.getParent().getParent().getNext() ) )
				{
					nodeToMove = relative.getChild( [0, 0] );
					if ( nodeToMove )
						nodeToMove.focus();
					ev.preventDefault(true);
				}
				break;

			// LEFT-ARROW
			case rtl ? 39 : 37 :
			// SHIFT + TAB
			case CKEDITOR.SHIFT + 9 :
				// relative is TD
				if ( ( relative = element.getParent().getPrevious() ) )
				{
					nodeToMove = relative.getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault(true);
				}
				// relative is TR
				else if ( ( relative = element.getParent().getParent().getPrevious() ) )
				{
					nodeToMove = relative.getLast().getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault(true);
				}
				break;
			default :
				// Do not stop not handled events.
				return;
		}
	});

	// Build the HTML for the flags images table.
	var labelId = CKEDITOR.tools.getNextId() + '_dota_2_heroes_emtions_label';
	var html =
	[
		'<div>' +
		'<span id="' + labelId + '" class="cke_voice_label"></span>',
		'<table role="listbox"  aria-labelledby="' + labelId + '" style="width:100%;height:100%" cellspacing="2" cellpadding="2"',
		CKEDITOR.env.ie && CKEDITOR.env.quirks ? ' style="position:absolute;"' : '',
		'><tbody>'
	];

	var size = images.length;
	for ( i = 0 ; i < size ; i++ )
	{
		if ( i % columns === 0 )
			html.push( '<tr>' );

		var dota_2_heroesLabelId = 'cke_smile_label_' + i + '_' + CKEDITOR.tools.getNextNumber();
		html.push(
			'<td class="cke_dark_background cke_centered" style="vertical-align: middle;">' +
				'<a style="width:50px;" href="javascript:void(0)" role="option"',
					' aria-posinset="' + ( i +1 ) + '"',
					' aria-setsize="' + size + '"',
					' aria-labelledby="' + dota_2_heroesLabelId + '"',
					' class="cke_smile cke_hand" tabindex="-1" onkeydown="CKEDITOR.tools.callFunction( ', onKeydown, ', event, this );">',
					'<img style="margin:3px;" class="cke_hand" title="', config.dota_2_heroes_descriptions[i], '"' +
						' cke_src="', CKEDITOR.tools.htmlEncode(  images[ i ] ), '" alt="', config.dota_2_heroes_descriptions[i], '"',
						' src="', CKEDITOR.tools.htmlEncode( images[ i ] ), '"',
						// IE BUG: Below is a workaround to an IE image loading bug to ensure the image sizes are correct.
						( CKEDITOR.env.ie ? ' onload="this.setAttribute(\'width\', 2); this.removeAttribute(\'width\');" ' : '' ),
					'>' +
					'<span style="display: block;font-size:10px;text-align: center;color:#444;" id="' + dota_2_heroesLabelId + '">' +config.dota_2_heroes_descriptions[ i ]  + '</span>' +
				'</a>',
 			'</td>' );

		if ( i % columns == columns - 1 )
			html.push( '</tr>' );
	}

	if ( i < columns - 1 )
	{
		for ( ; i < columns - 1 ; i++ )
			html.push( '<td></td>' );
		html.push( '</tr>' );
	}

	html.push( '</tbody></table></div>' );

	var dota_2_heroesSelector =
	{
		type : 'html',
		id : 'dota_2_heroesSelector',
		html : html.join( '' ),
		onLoad : function( event )
		{
			dialog = event.sender;
		},
		focus : function()
		{
			var self = this;
			// IE need a while to move the focus (#6539).
			setTimeout( function ()
			{
				var firstSmile = self.getElement().getElementsByTag( 'a' ).getItem( 0 );
				firstSmile.focus();
			}, 0 );
		},
		onClick : onClick,
		style : 'width: 100%; border-collapse: separate;'
	};

	return {
		title : 'Dota_2_heroes',
		minWidth : 700,
		minHeight : 400,
		contents : [
			{
				id : 'foba_tab',
				label : '',
				title : '',
				expand : true,
				padding : 2,
				elements : [
					dota_2_heroesSelector
					]
			}
		],
		buttons : [ CKEDITOR.dialog.cancelButton ]
	};
} );
