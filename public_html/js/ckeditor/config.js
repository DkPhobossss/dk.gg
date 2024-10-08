/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
//http://www.developer.goliberty.ru/page.php?al=buttom_ckeditor_more&PHPSESSID=707e07bcfac2f393b10f1a3ab990a62b

CKEDITOR.editorConfig = function( config )
{
	// http://cyberchamp.ru/2010/05/29/%D1%82%D0%B5%D0%BA%D1%81%D1%82%D0%BE%D0%B2%D1%8B%D0%B9-%D1%80%D0%B5%D0%B4%D0%B0%D0%BA%D1%82%D0%BE%D1%80-ckeditor/
	config.uiColor = '#A1BED2';
	//config.removePlugins = 'elementspath';
	//config.entities = false;

	config.resize_minWidth = '100%';
	config.resize_maxWidth = '100%';
	config.height = 600;
	//config.startupOutlineBlocks = true;

	config.extraPlugins = 'flags,dota_2_heroes,dota_2_skills,dota_2_items';
	config.indentOffset = 15;

	config.toolbar = [
		{ name: 'document', items : [ 'ShowBlocks' , 'Source','-','DocProps','-','Maximize','Indent' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','-','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image', 'Youtube', 'lightbox'] },
		{ name: 'insert', items : [ 'Table' ] },
		{ name: 'plugins', items: ['Flags', 'Dota_2_heroes', 'Dota_2_skills', 'Dota_2_items' ] },
		{ name: 'styles', items : [ 'Format', 'Scayt'] }
	];

	CKEDITOR.config.extraAllowedContent = 'a[data-lightbox,data-title,data-lightbox-saved]';

	config.format_h2 = { element : 'h2'};


	config.format_h3 = { element : 'h3'};
    config.format_h4 = { element : 'h4'};

    /*
    config.format_quote = { element : 'span' , attributes : {'class' : 'quote'} } ;

    config.format_quote_on_bg = { element : 'span' , attributes : {'class' : 'quote_on_bg'} } ;

    config.format_attention = { element : 'span' , attributes : {'class' : 'attention'} };
    config.format_question = { element : 'span' , attributes : {'class' : 'question'} };

    //black
    config.format_black = { element : 'span' , attributes : {'class' : 'black'} };
    config.format_question_body = { element : 'span' , attributes : {'class' : 'question_body'} };

    config.format_answer = { element : 'span' , attributes : {'class' : 'answer'} };
    config.format_blue = { element : 'span' , attributes : {'class' : 'blue'} };*/


	config.format_tags = 'h2;h3;h4';//;quote_on_bg;question;question_body;answer;attention;black;blue
};

