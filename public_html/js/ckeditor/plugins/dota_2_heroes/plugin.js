/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/



CKEDITOR.plugins.add( 'dota_2_heroes',
{
	requires : [ 'dialog' ],
	icons: 'dota_2_heroes',

	init : function( editor )
	{
		editor.addCommand( 'dota_2_heroes', new CKEDITOR.dialogCommand( 'dota_2_heroes' ) );
		editor.ui.addButton( 'Dota_2_heroes',
			{
				label : 'Dota_2_heroes',
				command : 'dota_2_heroes'
			});
		CKEDITOR.dialog.add( 'dota_2_heroes', this.path + 'dialogs/dota_2_heroes.js' );
	}
} );


CKEDITOR.config.dota_2_heroes_images = ["http://s.dkphobos.gg/images/dota_2/heroes/Abaddon_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Alchemist_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Ancient_Apparition_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Anti-Mage_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Arc_Warden_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Axe_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Bane_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Batrider_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Beastmaster_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Bloodseeker_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Bounty_Hunter_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Brewmaster_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Bristleback_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Broodmother_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Centaur_Warrunner_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Chaos_Knight_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Chen_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Clinkz_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Clockwerk_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Crystal_Maiden_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Dark_Seer_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Dark_Willow_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Dazzle_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Death_Prophet_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Disruptor_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Doom_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Dragon_Knight_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Drow_Ranger_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Earth_Spirit_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Earthshaker_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Elder_Titan_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Ember_Spirit_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Enchantress_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Enigma_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Faceless_Void_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Grimstroke_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Gyrocopter_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Huskar_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Invoker_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Io_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Jakiro_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Juggernaut_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Keeper_of_the_Light_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Kunkka_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Legion_Commander_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Leshrac_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Lich_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Lifestealer_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Lina_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Lion_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Lone_Druid_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Luna_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Lycan_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Magnus_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Mars_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Medusa_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Meepo_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Mirana_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Monkey_King_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Morphling_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Naga_Siren_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Nature's_Prophet_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Necrophos_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Night_Stalker_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Nyx_Assassin_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Ogre_Magi_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Omniknight_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Oracle_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Outworld_Devourer_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Pangolier_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Phantom_Assassin_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Phantom_Lancer_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Phoenix_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Puck_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Pudge_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Pugna_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Queen_of_Pain_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Razor_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Riki_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Rubick_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Sand_King_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Shadow_Demon_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Shadow_Fiend_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Shadow_Shaman_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Silencer_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Skywrath_Mage_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Slardar_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Slark_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Snapfire_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Sniper_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Spectre_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Spirit_Breaker_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Storm_Spirit_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Sven_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Techies_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Templar_Assassin_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Terrorblade_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Tidehunter_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Timbersaw_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Tinker_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Tiny_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Treant_Protector_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Troll_Warlord_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Tusk_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Underlord_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Undying_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Ursa_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Vengeful_Spirit_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Venomancer_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Viper_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Visage_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Void_Spirit_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Warlock_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Weaver_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Windranger_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Winter_Wyvern_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Witch_Doctor_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Wraith_King_minimap_icon.png" ,"http://s.dkphobos.gg/images/dota_2/heroes/Zeus_minimap_icon.png"];


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
CKEDITOR.config.dota_2_heroes_descriptions = ["Abaddon" ,"Alchemist" ,"Ancient Apparition" ,"Anti-Mage" ,"Arc Warden" ,"Axe" ,"Bane" ,"Batrider" ,"Beastmaster" ,"Bloodseeker" ,"Bounty Hunter" ,"Brewmaster" ,"Bristleback" ,"Broodmother" ,"Centaur Warrunner" ,"Chaos Knight" ,"Chen" ,"Clinkz" ,"Clockwerk" ,"Crystal Maiden" ,"Dark Seer" ,"Dark Willow" ,"Dazzle" ,"Death Prophet" ,"Disruptor" ,"Doom" ,"Dragon Knight" ,"Drow Ranger" ,"Earth Spirit" ,"Earthshaker" ,"Elder Titan" ,"Ember Spirit" ,"Enchantress" ,"Enigma" ,"Faceless Void" ,"Grimstroke" ,"Gyrocopter" ,"Huskar" ,"Invoker" ,"Io" ,"Jakiro" ,"Juggernaut" ,"Keeper of the Light" ,"Kunkka" ,"Legion Commander" ,"Leshrac" ,"Lich" ,"Lifestealer" ,"Lina" ,"Lion" ,"Lone Druid" ,"Luna" ,"Lycan" ,"Magnus" ,"Mars" ,"Medusa" ,"Meepo" ,"Mirana" ,"Monkey King" ,"Morphling" ,"Naga Siren" ,"Nature's Prophet" ,"Necrophos" ,"Night Stalker" ,"Nyx Assassin" ,"Ogre Magi" ,"Omniknight" ,"Oracle" ,"Outworld Devourer" ,"Pangolier" ,"Phantom Assassin" ,"Phantom Lancer" ,"Phoenix" ,"Puck" ,"Pudge" ,"Pugna" ,"Queen of Pain" ,"Razor" ,"Riki" ,"Rubick" ,"Sand King" ,"Shadow Demon" ,"Shadow Fiend" ,"Shadow Shaman" ,"Silencer" ,"Skywrath Mage" ,"Slardar" ,"Slark" ,"Snapfire" ,"Sniper" ,"Spectre" ,"Spirit Breaker" ,"Storm Spirit" ,"Sven" ,"Techies" ,"Templar Assassin" ,"Terrorblade" ,"Tidehunter" ,"Timbersaw" ,"Tinker" ,"Tiny" ,"Treant Protector" ,"Troll Warlord" ,"Tusk" ,"Underlord" ,"Undying" ,"Ursa" ,"Vengeful Spirit" ,"Venomancer" ,"Viper" ,"Visage" ,"Void Spirit" ,"Warlock" ,"Weaver" ,"Windranger" ,"Winter Wyvern" ,"Witch Doctor" ,"Wraith King" ,"Zeus"];


/**
 * The number of columns to be generated by the smilies matrix.
 * @name CKEDITOR.config.smiley_columns
 * @type Number
 * @default 8
 * @since 3.3.2
 * @example
 * config.smiley_columns = 6;
 */
CKEDITOR.config.dota_2_heroes_columns = 25;