<?php

namespace DOTA_2;

//Full description: https://github.com/odota/dotaconstants/blob/master/build/items.json
class Item
{
    public static function image( $name, $system_name )
    {
        return '<img class="dota_2_item" src="' . self::icon( $system_name ) .'" alt="' . $name . '" title="' . $name . '"  />';
    }

    public static function icon( $system_name )
    {
        return 'http://cdn.dota2.com/apps/dota2/images/items/' . $system_name .'_lg.png';
    }

    public static function synchronize()
    {
        $data = API::get_items();

        try
        {
            \DB::transaction();
            \DB\DOTA_2\Item::truncate(true);

            foreach ( $data as $row )
            {
                $row['name'] = str_replace( 'item_' , '' , $row['name'] );

                if ( empty( $row['recipe' ] ) && \CURL::remote_file_exists( 'http://cdn.dota2.com/apps/dota2/images/items/' . $row['name'] .'_lg.png' ) )
                {
                    \DB\DOTA_2\Item::insert(
                        array(
                            'id' => $row['id'],
                            'system_name' => $row['name'] ,
                            'cost' => $row['cost'] ,
                            'secret_shop' => intval( $row['secret_shop'] ),
                            'side_shop' => intval( $row['side_shop'] ),
                            'recipe' => intval( $row['recipe' ] ),
                            'name' => $row['localized_name']
                        )
                    );
                }
            }
            \DB::commit();
        }
        catch ( \Exception $e )
        {
            \DB::rollback();
            throw new \Exception\Fatal( $e->getMessage() );
        }

        return true;
    }
}