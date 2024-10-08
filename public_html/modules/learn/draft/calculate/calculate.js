$(document).ready( function() {
     function Category ( name, cats, color ) {
          this.name = name;
          this.cats = cats;
          this.color = color;
          this.visible = true;
     }

     function Point ( category, y ) {
          this.y = y;
          this.category = category;
     }


     var Charts = {
          tempo : {
               id : 'highcharts_tempo',
               chart : null,
               create : function(  data  ){
                    return Highcharts.chart( this.id  , {
                         chart: {
                              backgroundColor : $('#' + this.id).css('background-color'),
                              type : 'spline',
                              borderWidth:0,
                              borderColor : '#555',
                              spacing:[10,40,15,10],
                         },
                         title: {
                              text: null,
                              margin : 10,
                         },
                         xAxis: {
                              crosshair: {
                                   width : 1
                              },
                              lineWidth:1,
                              labels: {
                                   useHTML : true,
                              },
                              lineColor: '#555',
                              categories: ['<a target="_blank" href="learn/glossarij/laning_stage">' + __('Laning_stage') + '</a></br> (0-10 ' + __('min') + ')',
                                   '<a target="_blank" href="learn/glossarij/early_game">' + __('Early_game') + '</a></br> (10-20 ' + __('min') + ')',
                                   '<a target="_blank" href="learn/glossarij/mid_game">' + __('Mid_game') + '</a></br> (20-45 ' + __('min') + ')',
                                   '<a target="_blank" href="learn/glossarij/late_game">' + __('Late_game') + '</a></br> (45+ ' + __('min') + ')']
                         },
                         yAxis: {
                              title: {
                                   text: null
                              },
                              labels: {
                                   style : {  "fontSize": "10px" },
                                   formatter: function () {
                                        var t = Math.floor( this.value / 14.3 );
                                        return __('Macrotask_description_' + t);
                                   }
                              },
                              tickAmount : 3,

                              lineWidth:1,
                              lineColor: '#555',
                              gridLineWidth: 0,
                              gridLineColor: '#555',
                              min: 0,
                              max: 100,
                              plotLines: [{
                                   color: '#aaa',
                                   width: 1,
                                   value: 50,
                                   dashStyle: 'LongDashDotDot',
                              }]
                         },
                         tooltip: {
                              useHTML: true,
                              backgroundColor : '#151515',
                              borderColor: '#999',
                              headerFormat: '<div style="text-align:center;font-size: 12px;color:#666;margin-bottom:10px;">{point.key}</div>',
                              pointFormatter: function () {
                                   var t = Math.floor( this.y / 14.3 );

                                   return  '<div style="color: #ccc;"><span style="color:' + this.series.color + '">●</span> ' + this.series.name + ' : <b>' + __('Macrotask_description_' + t) + ' (' + this.y + ')</b></div>';
                              },
                              crosshairs: false,
                              shared: true
                         },
                         credits: {
                              enabled: false
                         },
                         legend:{
                              backgroundColor: '#333',
                              itemStyle: {
                                   color: '#ccc',
                                   fontWeight: "default"

                              },
                              enabled: true
                         },
                         series:  data
                    });
               },
          },
          macrotask : {
               id : 'highcharts_macrotask',
               chart : null,
               create : function(  data_radiant, data_dire  ){
                    var macrotasks = {};
                    macrotasks.keys = [];
                    macrotasks.radiant_values = [];
                    macrotasks.dire_values = [];

                    for ( var i in data_radiant ){
                         macrotasks.keys.push( i );
                         macrotasks.radiant_values.push( data_radiant[i] )
                    }

                    for ( var i in data_dire ){
                         macrotasks.dire_values.push( data_dire[i] * -1 )
                    }

                    return Highcharts.chart( this.id  , {
                         chart: {
                              events : {
                                   load : function() {
                                        //offset from 0 to 7
                                        $('#' + Charts.macrotask.id + ' .circle_text').each(function() {
                                             var radius = 260 - parseInt( $(this).attr('offset') ) * 30;

                                             $(this).arctext({radius:  radius, dir: -1});
                                        });
                                   }
                              },
                              backgroundColor : $('#' + this.id).css('background-color'),
                              type: 'column',
                              inverted: true,
                              polar: true,
                         },
                         title: {
                              text: null
                         },
                         tooltip: {
                              enabled: false,
                              useHTML: true,
                              headerFormat: null,
                              pointFormatter: function () {
                                   var t = Math.floor( this.y / 14.3 );
                                   return  '<span style="text-align:center;font-size: 12px;">' + macrotasks.data[this.category].text + '</span> : ' +
                                       '<b style="font-size: 12px;">' + __('Macrotask_description_' + t) + '</b><div style="white-space:normal; width:200px;font-size:12px;color:#888;margin-top:5px;">' + macrotasks.data[this.category].description + '</div>';
                              },
                              crosshairs: false,
                              shared: true
                         },
                         pane: {
                              size: '95%',
                              innerSize: '20%',
                              endAngle: 360,
                              startAngle: 0
                         },
                         xAxis: {
                              categories:  macrotasks.keys,
                              tickInterval: 1,

                              labels: {
                                   align: 'center',
                                   useHTML: true,
                                   x : -2,
                                   allowOverlap: true,
                                   step: 1,
                                   y: 0,

                                   style: {
                                        fontSize: '10px'
                                   },
                                   formatter: function () {
                                        if ( typeof CACHE['macrotask'][ this.value ] === 'undefined' )
                                             return this.value;
                                        var offset = 56 + (8 - this.pos) * 35.5;

                                        return '<div class="circle_text" offset="' + this.pos + '" style="position:absolute;left:0;color:#000;transform:translateX(-50%);top:' + offset + 'px;">' + CACHE['macrotask'][ this.value ].text + '</div>';
                                   }
                              },
                              lineWidth: 0,
                              lineColor: '#333',

                              gridLineWidth: 1,
                              gridLineColor: '#333',
                         },
                         legend:{
                              align: 'right',
                              verticalAlign: 'middle',
                              layout: 'vertical',
                              backgroundColor: '#333',
                              itemStyle: {
                                   color: '#ccc',
                                   fontWeight: "default"
                              },
                              enabled: true
                         },
                         yAxis: {
                              tickAmount : 9,

                              lineColor: '#333',
                              gridLineWidth: 1,
                              gridLineColor: '#333',


                              max : 100,
                              min : -100,
                              lineWidth: 0,

                              reversedStacks: false,
                              endOnTick: true,
                              showLastLabel: true,

                              labels: {
                                   style : {  "fontSize": "10px" },
                                   formatter: function () {
                                        var t = this.value >= 0 ? Math.floor( this.value / 14.3 ) : Math.abs( Math.ceil( this.value / 14.3 ) );
                                        return __('Macrotask_description_' + t);
                                   }
                              },
                         },
                         plotOptions: {
                              column: {
                                   stacking: 'normal',
                                   borderWidth: 0,
                                   pointPadding: 0,
                                   groupPadding: 0.15
                              }
                         },
                         credits: {
                              enabled: false
                         },
                         series: [{
                              name: __('radiant'),
                              color : Radiant.color,
                              data: macrotasks.radiant_values
                         }, {
                              name: __('dire'),
                              color : Dire.color,
                              data: macrotasks.dire_values
                         }]
                    });
               },
          },
          macrotask_detailed : {
               id : 'highcharts_macrotask_detailed',
               chart : null,
               cat_form : '#chart_check-boxes',
               Series : [],
               filterSeries : function(){
                    var filteredSeries = [];
                    var categories = this.categories;

                    $.each( this.Series, function(i, serie) {
                         // serie options are merged during update,
                         // so it's enough to initialize serie object only with data property
                         var newSerie = {
                              name : serie.name,
                              color: serie.color,
                              data: []
                         };
                         $.each(serie.data, function(i, point) {
                              for ( j in categories ){
                                   for ( k in categories[j].cats ){
                                        if ( categories[j].cats[k] == point.category ){
                                             if (categories[j].visible) {
                                                  newSerie.data.push(point);
                                                  break;
                                             }
                                        }
                                   }
                              }
                         });
                         filteredSeries.push(newSerie);
                    });

                    return filteredSeries;
               },
               filterCategories : function( filter = false ) {
                    var filteredCategories = [];
                    $.each( this.categories, function(i, category ) {
                         if ( !filter || category.visible) {
                              // push name only - chart.xAxis.categories requires array of String objects
                              for ( j in category.cats){
                                   filteredCategories.push(category.cats[j]);
                              }
                         }
                    });



                    return filteredCategories;
               },
               filterPlotBands : function(){
                    var filteredPlotBands = [];
                    var start = -0.5;
                    $.each( this.categories, function(i, category ) {
                         var length = Object.keys( category.cats ).length;
                         if ( category.visible) {
                              filteredPlotBands.push({
                                   from: start,
                                   to: (start += length),
                                   color: category.color,
                                   zIndex: 20,
                                   label: {
                                        useHTML: true,
                                        text: '<span style="color : #999; padding:5px;background:rgba(21,21,21,0.3);">' + category.name + '</span>',
                                        y: 20
                                   }
                              });
                         }
                    });

                    return filteredPlotBands;
               },
               categories : [new Category( __('Mactotask_main') , ['teamfight', 'push'], 'rgba(108 ,210, 255, .2)' ),
                              new Category(__('Mactotask_agro') , ['siege', 'attack', 'roshan'], 'rgba(78, 170, 213, .2)' ),
                              new Category( __('Mactotask_stable') , ['protect', 'defend'], 'rgba(48, 130, 173, .2)'  ),
                              new Category( __('Mactotask_greed') , ['farm'], 'rgba(18, 90, 143, .2)'  )
                         ].map(function(cat, i) {
                              cat.index = i;
                              return cat;
               }),
               rebuildData : function() {
                    var categories = this.categories;
                    $.each( $(this.cat_form + ' input' ), function(i, box) {
                         var checkbox = this;

                         var category = categories.find((category) => category.name === checkbox.name);
                         category.visible = checkbox.checked;
                    });


                    this.chart.update({
                         series: this.filterSeries(),
                         xAxis: {
                              categories: this.filterCategories( true ),
                              plotBands : this.filterPlotBands( )
                         }
                    });
               },
               buildCheckBoxes: function() {
                    var form = Charts.macrotask_detailed.cat_form;
                    $.each( this.categories, function(i, cat) {
                         var box = '<label><input type="checkbox"  name="' + cat.name + '" val="' + i + '" checked="checked" />' + cat.name + '</label>';
                         $( form ).append(box);
                    });
               },
               create : function(  data_radiant, data_dire  ){
                    var data = [],
                         keys = this.filterCategories();


                    this.Series = [];

                    data[ Radiant.name ] = [];
                    data[ Dire.name ] = [];
                    for ( var i in keys ){
                         data[ Radiant.name ][ i ] = data_radiant[ keys[i] ];
                         data[ Dire.name ][ i ] = data_dire[ keys[i] ];
                    }

                    data[ Radiant.name ] = data[ Radiant.name ].map((y, i) => new Point( keys[i], y));
                    data[ Dire.name ] = data[ Dire.name ].map((y, i) => new Point(keys[i], y));

                    this.Series.push( {
                         name : __('radiant'),
                         color: Radiant.color,
                         data : data[ Radiant.name ]
                    } );

                    this.Series.push( {
                         name : __('dire'),
                         color: Dire.color,
                         data : data[ Dire.name ]
                    } );

                    if ( this.chart === null)
                         this.buildCheckBoxes();



                    return Highcharts.chart( this.id  , {
                         chart: {
                              backgroundColor : $('#' + this.id ).css('background-color'),
                              type : 'column',
                              spacing:[10,100,15,10],
                         },
                         title: {
                              text: null,
                              margin : 10,
                         },
                         xAxis: {
                              type: 'category',
                              labels: {
                                   useHTML : true,
                                   autoRotation: false,
                                   style : {fontSize:'9px'},
                                   formatter: function () {
                                        return '<a href="learn/glossarij/' + CACHE['macrotask'][ this.value ].url + '" target="_blank">' + CACHE['macrotask'][ this.value ].text + '</a>';
                                   }
                              },
                              lineColor: '#555',
                              categories:  keys,
                              plotBands: this.filterPlotBands()
                         },
                         yAxis: {
                              title: {
                                   text: null
                              },
                              labels: {
                                   style : {  "fontSize": "10px" },
                                   formatter: function () {
                                        var t = Math.floor( this.value / 14.3 );
                                        return __('Macrotask_description_' + t);
                                   }
                              },
                              tickAmount : 5,

                              lineWidth:1,
                              lineColor: '#555',
                              gridLineWidth: 0,
                              gridLineColor: '#555',
                              min: 0,
                              max: 100,
                         },
                         legend:{

                              backgroundColor: '#333',
                              itemStyle: {
                                   color: '#ccc',
                                   fontWeight: "default"
                              },
                              enabled: true
                         },
                         plotOptions: {

                         },
                         tooltip: {
                              useHTML: true,
                              backgroundColor: '#ccc',
                              formatter: function () {
                                   var s = '<div style="text-align:center;font-size: 14px; margin-bottom : 5px;">' + CACHE['macrotask'][ this.x ].text + '</div>';

                                   for( var i in this.points ) {
                                        var t = Math.floor( this.points[ i ].y / 14.3 )
                                        s = s +  '<div style=""><span style="color:' + this.points[ i ].color + '">●</span> ' + this.points[ i ].series.name + ' : <b>' + __('Macrotask_description_' + t) + ' (' + this.points[ i ].y + ')</b></div>';
                                   }

                                   s = s + '<div style="white-space:normal; width:200px;font-size:12px;color:#888;margin-top:5px;">' + CACHE['macrotask'][ this.x ].description + '</div>';

                                   return  s;

                              },
                              crosshairs: false,
                              shared: true
                         },
                         credits: {
                              enabled: false
                         },
                         series: this.filterSeries()
                    });
               }
          }
     };

     var Draft = {
          $heroes_list : $('#heroes_list'),
          $roles_title : $('#roles_title'),
          $charts_conainter : $('#charts_container'),
          $pick_container : $('#pick_container'),
          teams : {
               'Radiant' : {
                    $draft : $('#radiant')
               },
               'Dire' : {
                    $draft : $('#dire')
               }
          },
          selection : null,
          $team_selection : null,
          update_selection : function () {
               if ( this.$team_selection !== null ){
                    this.$team_selection.removeClass('selected');
                    this.$roles_title.html('');
               }

               this.$team_selection = this.teams[ this.selection.team.name ].$draft.find('[role="' + this.selection.role + '"]');

               this.$team_selection.addClass('selected');
               this.$roles_title.html( this.$team_selection.find('.description').html() );

               var selected_role = this.selection.role;
               this.$heroes_list.find('.hero').each( function() {
                    var id = $(this).attr('id');
                    var possible_heroes =  Hero.data[ id ][ selected_role ];

                    if ( possible_heroes.length == 1 ){
                         $(this).removeAttr( 'type_data' );

                         if ( possible_heroes[0].disabled == 1 ) {
                              $(this).addClass('disabled');
                         } else {
                              $(this).removeClass('disabled');
                         }
                    } else {
                         $(this).removeClass('disabled');
                         $(this).attr('type_data', JSON.stringify( possible_heroes )  );
                    }
               });
          },
          select_role : function( _Team, Role ) {

               this.selection = {
                    'team' : _Team,
                    'role' : Role
               };

               this.update_selection();
          },
          update_heroes_tables : function(){
               this.$heroes_list.find('a.hero').each( function() {
                    var hero_id = $(this).attr('id');

                    if ( typeof Hero.data[hero_id].picked !== 'undefined' ) {
                         $(this).addClass('selected');
                    } else {
                         $(this).removeClass('selected');
                    }
               });
          },
          update_team_hero : function( _Team, _Role, hero_id ) {
             var $role = this.teams[ _Team.name ].$draft.find( 'div[role="' + _Role + '"]'),
               $delete = $role.find('.delete'),
               $hero = $role.find('.hero');

             if ( hero_id === null ){
                  $role.find('.hero img.avatar').attr({
                       'title' : '',
                       'alt' : '',
                       'src' : static_url + 'images/dota_2/unknown_hero.png'
                  });

                  $role.removeClass('picked');
                  $delete.addClass('none');
                  $hero.removeAttr('hero_name');
             } else {
                  $role.find('.hero img.avatar').attr({
                    'title' : _Team.heroes[ _Role ].hero_name,
                    'alt' : _Team.heroes[ _Role ].hero_name,
                    'src' : 'https://cdn.cloudflare.steamstatic.com/apps/dota2/images/heroes/' + _Team.heroes[ _Role ].hero_system_url +'_vert.jpg'
                  });

                  $role.addClass('picked');

                  $delete.removeClass('none');
                  $hero.attr('hero_name' , _Team.heroes[ _Role ].hero_name );
             }
          },
          select_next : function( _Team = null, _Role = null) {
               var radiant_hero_count = Object.keys( Radiant.heroes ).length,
                   dire_hero_count = Object.keys( Dire.heroes ).length;

               if ( radiant_hero_count == 5 && dire_hero_count == 5  ){
                    this.remove_selection();

                    this.calculate();

                    return;
               }

               var new_team, new_role;


               if ( _Team !== null && _Role !== null) {
                    new_team = _Team;
                    new_role = _Role;
               }
               else if ( this.selection === null ) {
                    new_team = Object.keys( Radiant.heroes ).length != 5 ? Radiant : Dire;
                    new_role = new_team.nextRole( );
               }
               else if ( Object.keys( this.selection.team.heroes ).length == 5 ) {

                    new_team = this.selection.team.name == 'Radiant' ? Dire : Radiant;
                    new_role = new_team.nextRole( );
               } else {
                    new_team = this.selection.team;
                    new_role = new_team.nextRole( parseInt( this.selection.role ) );
               }

               this.select_role( new_team, new_role );
          },
          remove_selection : function() {
               if ( this.$team_selection !== null ){
                    this.$team_selection.removeClass('selected');
                    this.$roles_title.html('');
               }
          },
          select_hero : function( $hero ){
               var hero_id = $hero.attr('id');

               this.selection.team.pickHero( this.selection.role, hero_id,  null  );

               this.update_heroes_tables();

               this.update_team_hero( this.selection.team, this.selection.role, hero_id );

               this.select_next();
          },
          pick_hero : function( _Team , _Role, _Hero ){
               _Team.pickHero( _Role, _Hero.hero_id, _Hero.type  );

               this.update_heroes_tables();

               this.update_team_hero( _Team, _Role, _Hero.hero_id );
          },
          remove_hero : function( _Team , _Role, update = true ){
               _Team.unPickHero( _Role  );

               this.update_team_hero( _Team , _Role, null );

               if ( update ){
                    this.update_heroes_tables();
                    this.hide_calculation();
                    this.select_next();
               }
          },
          remove_heroes_from_team : function( _Team ){
               var heroes_count = Object.keys( _Team.heroes ).length;
               if ( heroes_count == 0 ){
                    return;
               }

               for ( var i in _Team.heroes ){
                    this.remove_hero( _Team, i, false );
               }

               this.update_heroes_tables();
               this.hide_calculation();

               this.select_next();
          },
          calculate : function(){
               this.$pick_container.addClass('none');
               this.$charts_conainter.removeClass('none');

               f.ajax({type: 'post', url: 'ajax/json/learn/draft/calculate', data: { 'radiant' : Radiant.heroes, 'dire' : Dire.heroes}},
                    $('#versus'),
               function( response ){
                         var data = [];
                         if ( typeof response.data.radiant !== 'undefined'  ) {
                              data.push({
                                   name : __('radiant'),
                                   pointPlacement : 'on',
                                   type: 'spline',
                                   animation: {
                                        duration: 1000
                                   },
                                   color: Radiant.color,
                                   marker: {
                                        radius: 3,
                                        lineWidth: 2,
                                        lineColor: null,
                                        symbol: 'circle'
                                   },

                                   data : [
                                        response.data.radiant.battle_tempo.laning,
                                        response.data.radiant.battle_tempo.carry_early_tempo,
                                        response.data.radiant.battle_tempo.carry_mid_tempo,
                                        response.data.radiant.battle_tempo.carry_late_tempo,
                                   ]
                              });
                         }

                         if ( typeof response.data.dire !== 'undefined'  ) {
                              data.push({
                                   name : __('dire'),
                                   pointPlacement : 'on',
                                   type: 'spline',
                                   animation: {
                                        duration: 1000
                                   },
                                   color: Dire.color,
                                   marker: {
                                        radius: 3,
                                        lineWidth: 2,
                                        lineColor: null,
                                        symbol: 'square'
                                   },

                                   data : [
                                        response.data.dire.battle_tempo.laning,
                                        response.data.dire.battle_tempo.carry_early_tempo,
                                        response.data.dire.battle_tempo.carry_mid_tempo,
                                        response.data.dire.battle_tempo.carry_late_tempo,
                                   ]
                              });
                         }

                         Charts.tempo.chart = Charts.tempo.create( data );

                         Charts.macrotask.chart = Charts.macrotask.create( response.data.radiant.macrotasks, response.data.dire.macrotasks );

                         Charts.macrotask_detailed.chart = Charts.macrotask_detailed.create( response.data.radiant.macrotasks, response.data.dire.macrotasks );
                   });
               return;
          },
          hide_calculation : function(){
               this.$pick_container.removeClass('none');
               this.$charts_conainter.addClass('none');

          },
          swap : function( from_team_name, from_role, to_team_name, to_role ) {
               var
                   From_TEAM,
                   To_TEAM,
                   Temp_Team_1_hero = null,
                   Temp_Team_2_hero = null
                    select_next = false;

               From_TEAM = ( from_team_name == Radiant.name ? Radiant : Dire );
               To_TEAM = ( to_team_name == Radiant.name ? Radiant : Dire );


               if ( typeof From_TEAM.heroes[ from_role ] !== 'undefined') {
                    Temp_Team_1_hero = From_TEAM.heroes[ from_role ];
                    this.remove_hero( From_TEAM , from_role, false );
               }

               if ( typeof To_TEAM.heroes[ to_role ] !== 'undefined') {
                    Temp_Team_2_hero = To_TEAM.heroes[ to_role ];
                    this.remove_hero( To_TEAM, to_role, false );
               }


               if ( Temp_Team_1_hero !== null ) {
                    this.pick_hero( To_TEAM, to_role, Temp_Team_1_hero );
                    select_next = true;
               }

               if ( Temp_Team_2_hero !== null ) {
                    this.pick_hero( From_TEAM, from_role, Temp_Team_2_hero );
                    select_next = true;
               }

               if ( select_next )
                    this.select_next( To_TEAM, to_role);
          },
          start : function () {
               for ( var i in Radiant.heroes ) {
                    this.update_team_hero( Radiant, i.toString(), Radiant.heroes[i].role_id );
               }

               for ( var i in Dire.heroes ) {
                    this.update_team_hero( Dire, i.toString(), Dire.heroes[i].role_id );
               }


               this.update_heroes_tables();
               this.select_next();
          }
     };


     Hero.addData( CACHE.roles, Draft.$heroes_list );

     //Radiant = new Team( 'Radiant', 1, 2, 3,  4,  5),
     //Dire = new Team( 'Dire', 6,  7, 8, 9, 10),

     Radiant = new Team( 'Radiant' ),
     Dire = new Team( 'Dire');

     //Draft.start();

     Draft.select_role( Radiant, Role_Carry );

     Radiant.setColor('#393');
     Dire.setColor('#FFD700');

     function swap($a, $b) {
          var tmp = $('<span>').hide();
          $a.before(tmp);
          $b.before($a);
          tmp.replaceWith($b);
     };


     var drag_n_drop = {
          draggable_options : {
               revert: true,
               helper: "original",
               disabled : false,
               zIndex : 10,
               scroll: false,
               revertDuration: 200
          },
          dropabble_options : {
               accept: ".hero",
               activeClass: "ui-state-hover",
               hoverClass: "ui-state-active",
               drop: function( event, ui ) {
                    var draggable = ui.draggable, droppable = $(this),
                        dragPos = draggable.offset(),
                        dropPos = droppable.offset(),
                        dragPosRelative = draggable.position(),
                        $from_role = draggable.closest('.role'),
                        $to_role = droppable.closest('.role'),
                        from_team = $from_role.parent().parent().attr('team'),
                        to_team = $to_role.parent().parent().attr('team');

                    swap( draggable, droppable );

                    draggable.css({
                         left: (  dragPos.left - dropPos.left )  + "px",
                         top: dragPosRelative.top + "px",
                    });

                    Draft.swap( from_team, $from_role.attr('role'), to_team, $to_role.attr('role') );
               }
          }
     }

     Draft.teams['Radiant'].$draft.on('click' , 'div.role .hero' , function() {
          var $parent = $(this).closest('div.role');
          if ( $parent.hasClass('selected')) {
               return;
          }
          Draft.select_role( Radiant, $parent.attr('role') );

     });
     Draft.teams['Radiant'].$draft.find('div.role .hero').draggable( drag_n_drop.draggable_options ).droppable( drag_n_drop.dropabble_options );


     Draft.teams['Dire'].$draft.on('click' , 'div.role .hero' , function() {
          var $parent = $(this).closest('div.role');
          if ( $parent.hasClass('selected')) {
               return;
          }
          Draft.select_role( Dire, $parent.attr('role') );
     });
     Draft.teams['Dire'].$draft.find('div.role .hero').draggable( drag_n_drop.draggable_options ).droppable( drag_n_drop.dropabble_options );



     Draft.teams['Radiant'].$draft.on('click' , 'img.delete' , function() {
          var $parent = $(this).closest('div.role');
          Draft.remove_hero( Radiant, $parent.attr('role')  );
     });

     Draft.teams['Dire'].$draft.on('click' , 'img.delete' , function() {
          var $parent = $(this).closest('div.role');
          Draft.remove_hero( Dire, $parent.attr('role') );
     });

     $('#refresh_radiant').click( function() {
          Draft.remove_heroes_from_team( Radiant );
     });

     $('#refresh_dire').click( function() {
          Draft.remove_heroes_from_team( Dire );
     });

     $(Charts.macrotask_detailed.cat_form).on('click',  'input', function(e) {
          Charts.macrotask_detailed.rebuildData();
     });


     Draft.$heroes_list.find('a.hero').click(function() {
          if ( $(this).hasClass('selected') ) {
               return;
          }
          Draft.select_hero( $(this) );
     })

     $(Charts.macrotask_detailed.cat_form).on('click',  'input', function(e) {
          Charts.macrotask_detailed.rebuildData();
     });

})