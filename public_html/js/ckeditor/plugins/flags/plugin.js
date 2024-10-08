/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/



CKEDITOR.plugins.add( 'flags',
{
	requires : [ 'dialog' ],
	icons: 'flags',

	init : function( editor )
	{
		editor.config.flags_path = 'http://s.dkphobos.gg/images/flags/';
		editor.addCommand( 'flags', new CKEDITOR.dialogCommand( 'flags' ) );
		editor.ui.addButton( 'Flags',
			{
				label : 'Flags',
				command : 'flags',
                icon : 'http://s.dkphobos.gg/images/flags/ua.png'//Путь к иконке
			});
		CKEDITOR.dialog.add( 'flags', this.path + 'dialogs/flags.js' );
	}
} );


CKEDITOR.config.flags_images = [
	'ua.png' , 'ru.png' , 'by.png' , 'kz.png' , 'pl.png' , 'us.png' , 'World.gif' , 'af.png' , 'al.png' , 'dz.png' , 'as.png' , 'ad.png' , 'ao.png' , 'ai.png' , 'aq.png' , 'ag.png' , 'ar.png' , 'am.png' , 'aw.png' , 'au.png' , 'at.png' , 'az.png' , 'bs.png' , 'bh.png' , 'bd.png' , 'bb.png' , 'be.png' , 'bz.png' , 'bj.png' , 'bm.png' , 'bt.png' , 'bo.png' , 'ba.png' , 'bw.png' , 'bv.png' , 'br.png' , 'io.png' , 'bn.png' , 'bg.png' , 'bf.png' , 'bi.png' , 'kh.png' , 'cm.png' , 'ca.png' , 'cv.png' , 'ky.png' , 'cf.png' , 'td.png' , 'cl.png' , 'cn.png' , 'cx.png' , 'cc.png' , 'co.png' , 'km.png' , 'cg.png' , 'cd.png' , 'ck.png' , 'cr.png' , 'ci.png' , 'hr.png' , 'cu.png' , 'cy.png' , 'cz.png' , 'dk.png' , 'dj.png' , 'dm.png' , 'do.png' , 'ec.png' , 'eg.png' , 'sv.png' , 'england.png' , 'gq.png' , 'er.png' , 'ee.png' , 'et.png' , 'fk.png' , 'fo.png' , 'fj.png' , 'fi.png' , 'fr.png' , 'gf.png' , 'pf.png' , 'tf.png' , 'ga.png' , 'gm.png' , 'ge.png' , 'de.png' , 'gh.png' , 'gi.png' , 'gr.png' , 'gl.png' , 'gd.png' , 'gp.png' , 'gu.png' , 'gt.png' , 'gn.png' , 'gw.png' , 'gy.png' , 'ht.png' , 'hm.png' , 'va.png' , 'hn.png' , 'hk.png' , 'hu.png' , 'is.png' , 'in.png' , 'id.png' , 'ir.png' , 'iq.png' , 'ie.png' , 'il.png' , 'it.png' , 'jm.png' , 'jp.png' , 'jo.png' , 'ke.png' , 'ki.png' , 'kp.png' , 'kr.png' , 'kw.png' , 'kg.png' , 'la.png' , 'lv.png' , 'lb.png' , 'ls.png' , 'lr.png' , 'ly.png' , 'li.png' , 'lt.png' , 'lu.png' , 'mo.png' , 'mk.png' , 'mg.png' , 'mw.png' , 'my.png' , 'mv.png' , 'ml.png' , 'mt.png' , 'mh.png' , 'mq.png' , 'mr.png' , 'mu.png' , 'yt.png' , 'mx.png' , 'fm.png' , 'md.png' , 'mc.png' , 'mn.png' , 'ms.png' , 'ma.png' , 'mz.png' , 'mm.png' , 'na.png' , 'nr.png' , 'np.png' , 'nl.png' , 'an.png' , 'nc.png' , 'nz.png' , 'ni.png' , 'ne.png' , 'ng.png' , 'nu.png' , 'nf.png' , 'mp.png' , 'no.png' , 'om.png' , 'pk.png' , 'pw.png' , 'ps.png' , 'pa.png' , 'pg.png' , 'py.png' , 'pe.png' , 'ph.png' , 'pn.png' , 'pt.png' , 'pr.png' , 'qa.png' , 're.png' , 'ro.png' , 'rw.png' , 'sh.png' , 'kn.png' , 'lc.png' , 'pm.png' , 'vc.png' , 'ws.png' , 'sm.png' , 'st.png' , 'sa.png' , 'scotland.png' , 'sn.png' , 'cs.png' , 'sc.png' , 'sl.png' , 'sg.png' , 'sk.png' , 'si.png' , 'sb.png' , 'so.png' , 'za.png' , 'gs.png' , 'es.png' , 'lk.png' , 'sd.png' , 'sr.png' , 'sj.png' , 'sz.png' , 'se.png' , 'ch.png' , 'sy.png' , 'tw.png' , 'tj.png' , 'tz.png' , 'th.png' , 'tl.png' , 'tg.png' , 'tk.png' , 'to.png' , 'tt.png' , 'tn.png' , 'tr.png' , 'tm.png' , 'tc.png' , 'tv.png' , 'ug.png' , 'ae.png' , 'gb.png' , 'um.png' , 'uy.png' , 'uz.png' , 'vu.png' , 've.png' , 'vn.png' , 'vg.png' , 'vi.png' , 'wales.png' , 'wf.png' , 'eh.png' , 'ye.png' , 'zm.png' , 'zw.png'];

/**
 * The description to be used for each of the smileys defined in the
 * {@link CKEDITOR.config.smiley_images} setting. Each entry in this array list
 * must match its relative pair in the {@link CKEDITOR.config.smiley_images}
 * setting.
 * @type Array
 * @default  The textual descriptions of smiley.
 * @example
 * // Default settings.
 * config.smiley_descriptions =
 *     [
 *         'smiley', 'sad', 'wink', 'laugh', 'frown', 'cheeky', 'blush', 'surprise',
 *         'indecision', 'angry', 'angel', 'cool', 'devil', 'crying', 'enlightened', 'no',
 *         'yes', 'heart', 'broken heart', 'kiss', 'mail'
 *     ];
 * @example
 * // Use textual emoticons as description.
 * config.smiley_descriptions =
 *     [
 *         ':)', ':(', ';)', ':D', ':/', ':P', ':*)', ':-o',
 *         ':|', '>:(', 'o:)', '8-)', '>:-)', ';(', '', '', '',
 *         '', '', ':-*', ''
 *     ];
 */
CKEDITOR.config.flags_descriptions =
	[
		'Ukraine' , 'Russian Federation' , 'Belarus' , 'Kazakhstan' , 'Poland' , 'United States' , 'International', 'Afghanistan' , 'Albania' , 'Algeria' , 'American Samoa' , 'Andorra' , 'Angola' , 'Anguilla' , 'Antarctica' , 'Antigua and Barbuda' , 'Argentina' , 'Armenia' , 'Aruba' , 'Australia' , 'Austria' , 'Azerbaijan' , 'Bahamas' , 'Bahrain' , 'Bangladesh' , 'Barbados' , 'Belgium' , 'Belize' , 'Benin' , 'Bermuda' , 'Bhutan' , 'Bolivia' , 'Bosnia and Herzegovina' , 'Botswana' , 'Bouvet Island' , 'Brazil' , 'British Indian Ocean Territory' , 'Brunei Darussalam' , 'Bulgaria' , 'Burkina Faso' , 'Burundi' , 'Cambodia' , 'Cameroon' , 'Canada' , 'Cape Verde' , 'Cayman Islands' , 'Central African' , 'Chad' , 'Chile' , 'China' , 'Christmas Island' , 'Cocos (Keeling) Islands' , 'Colombia' , 'Comoros' , 'Congo, Republic' , 'Congo' , 'Cook Islands' , 'Costa Rica' , 'CÃ´te d\'Ivoire' , 'Croatia' , 'Cuba' , 'Cyprus' , 'Czech Republic' , 'Denmark' , 'Djibouti' , 'Dominica' , 'Dominican Republic' , 'Ecuador' , 'Egypt' , 'El Salvador' , 'England' , 'Equatorial Guinea' , 'Eritrea' , 'Estonia' , 'Ethiopia' , 'Falkland Islands' , 'Faroe Islands' , 'Fiji' , 'Finland' , 'France' , 'French Guiana' , 'French Polynesia' , 'French Southern Territories' , 'Gabon' , 'Gambia' , 'Georgia' , 'Germany' , 'Ghana' , 'Gibraltar' , 'Greece' , 'Greenland' , 'Grenada' , 'Guadeloupe' , 'Guam' , 'Guatemala' , 'Guinea' , 'Guinea-Bissau' , 'Guyana' , 'Haiti' , 'Heard Island and McDonald Islands' , 'Vatican City State' , 'Honduras' , 'Hong Kong' , 'Hungary' , 'Iceland' , 'India' , 'Indonesia' , 'Iran' , 'Iraq' , 'Ireland' , 'Israel' , 'Italy' , 'Jamaica' , 'Japan' , 'Jordan' , 'Kenya' , 'Kiribati' , 'Korea' , 'Korea, Republic of' , 'Kuwait' , 'Kyrgyzstan' , 'Lao People\'s Democratic Republic' , 'Latvia' , 'Lebanon' , 'Lesotho' , 'Liberia' , 'Libyan Arab Jamahiriya' , 'Liechtenstein' , 'Lithuania' , 'Luxembourg' , 'Macao' , 'Macedonia' , 'Madagascar' , 'Malawi' , 'Malaysia' , 'Maldives' , 'Mali' , 'Malta' , 'Marshall Islands' , 'Martinique' , 'Mauritania' , 'Mauritius' , 'Mayotte' , 'Mexico' , 'Micronesia, Federated States of' , 'Moldova' , 'Monaco' , 'Mongolia' , 'Montserrat' , 'Morocco' , 'Mozambique' , 'Myanmar' , 'Namibia' , 'Nauru' , 'Nepal' , 'Netherlands' , 'Netherlands Antilles' , 'New Caledonia' , 'New Zealand' , 'Nicaragua' , 'Niger' , 'Nigeria' , 'Niue' , 'Norfolk Island' , 'Northern Mariana Islands' , 'Norway' , 'Oman' , 'Pakistan' , 'Palau' , 'Palestinian Territory, Occupied' , 'Panama' , 'Papua New Guinea' , 'Paraguay' , 'Peru' , 'Philippines' , 'Pitcairn' , 'Portugal' , 'Puerto Rico' , 'Qatar' , 'Reunion' , 'Romania' , 'Rwanda' , 'Saint Helena' , 'Saint Kitts and Nevis' , 'Saint Lucia' , 'Saint Pierre and Miquelon' , 'Saint Vincent and the Grenadines' , 'Samoa' , 'San Marino' , 'Sao Tome and Principe' , 'Saudi Arabia' , 'Scotland' , 'Senegal' , 'Serbia and Montenegro' , 'Seychelles' , 'Sierra Leone' , 'Singapore' , 'Slovakia' , 'Slovenia' , 'Solomon Islands' , 'Somalia' , 'South Africa' , 'South Georgia and the South Sandwich Islan' , 'Spain' , 'Sri Lanka' , 'Sudan' , 'Suriname' , 'Svalbard and Jan Mayen' , 'Swaziland' , 'Sweden' , 'Switzerland' , 'Syrian Arab Republic' , 'Taiwan' , 'Tajikistan' , 'Tanzania, United Republic of' , 'Thailand' , 'Timor-Leste' , 'Togo' , 'Tokelau' , 'Tonga' , 'Trinidad and Tobago' , 'Tunisia' , 'Turkey' , 'Turkmenistan' , 'Turks and Caicos Islands' , 'Tuvalu' , 'Uganda' , 'United Arab Emirates' , 'United Kingdom' , 'United States Minor Outlying Islands' , 'Uruguay' , 'Uzbekistan' , 'Vanuatu' , 'Venezuela' , 'Viet Nam' , 'Virgin Islands, British' , 'Virgin Islands, U.S.' , 'Wales' , 'Wallis and Futuna' , 'Western Sahara' , 'Yemen' , 'Zambia' , 'Zimbabwe'
	];

/**
 * The number of columns to be generated by the smilies matrix.
 * @name CKEDITOR.config.smiley_columns
 * @type Number
 * @default 8
 * @since 3.3.2
 * @example
 * config.smiley_columns = 6;
 */
CKEDITOR.config.flags_columns = 25;