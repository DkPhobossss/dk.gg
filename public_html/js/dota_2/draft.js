const   Role_Carry = 1,
    Role_Mid = 2,
    Role_Offlane = 3,
    Role_Soft_support = 4,
    Role_Hard_support = 5;

class Hero
{
    static data = {

    };

    static addData( _data, $element_id ) {
        Hero.data = _data;
        $element_id.find('.hero').each( function() {
            Hero.data[$(this).attr('id')].data = {
                'hero_name' : $(this).find('span.hero_name').text(),
                'hero_system_url' : $(this).attr('system_url'),
            };
        });
    }


    static pick( hero_id ){
        Hero.data[hero_id].picked = 1;
    }

    static unpick( hero_id ){
        delete Hero.data[hero_id].picked
    }
};



class Team
{
    heroes = {

    };

    constructor( name, carry = null, mid = null, offlane = null , soft_support = null, hard_support = null ) {
        this.name = name;

        var _data = [];

        if ( carry !== null ){
            _data[Role_Carry] =  carry;
        }

        if ( mid !== null ){
            _data[Role_Mid] =  mid;
        }

        if ( offlane !== null ){
            _data[Role_Offlane] =  offlane;
        }

        if ( soft_support !== null ){
            _data[Role_Soft_support] =  soft_support;
        }

        if ( hard_support !== null ){
            _data[Role_Hard_support] =  hard_support;
        }

        for ( var role in _data ){
            if ( Array.isArray(_data[ role ]) ){
                this.pickHero( role, _data[ role ][ 0 ], _data[ role ][ 1 ] );
            } else {
                this.pickHero( role, _data[ role ] );
            }
        }

    }

    nextRole( pointer = null ){
        if ( pointer === null ) {

            for ( var i = 1; i <= 5; i++ ) {
                if ( typeof this.heroes[ i ] === 'undefined' ) {
                    return i.toString();
                }
            }
        } else {
            for ( var i = pointer; i <= 5 ; i++ ) {
                if ( typeof this.heroes[ i ] === 'undefined' ) {
                    return i.toString();
                }
            }
            for ( var i = 1; i < pointer; i++ ) {
                if ( typeof this.heroes[ i ] === 'undefined' ) {
                    return i.toString();
                }
            }
        }
    }

    setColor( color ){
        this.color = color;
    }

    pickHero( role, hero_id, type = null ){
        if ( role === null ) {
            return false;
        }

        if ( this.heroes[ role ] !== undefined ) {
            Hero.unpick( this.heroes[ role ].hero_id );
        }

        var role_id = null;
        for ( var i in Hero.data[hero_id][role] ){
            if ( Hero.data[hero_id][role][i].type == type  ) {
                role_id = Hero.data[hero_id][role][i].id;
            }
        }



        this.heroes[ role ] = {
            role_id : role_id ,
            hero_id : hero_id,
            hero_name : Hero.data[hero_id]['data'].hero_name,
            hero_system_url : Hero.data[hero_id]['data'].hero_system_url,
            type : type
        };

        Hero.pick( hero_id );
    }

    unPickHero( role ){
        Hero.unpick( this.heroes[ role ].hero_id );

        delete this.heroes[ role ];
    }
}