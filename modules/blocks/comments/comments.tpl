<? if ( $this->ajax !== true ) : ?>
    <?= $this->css () ?>
    <?= $this->js () ?>
    <? $Comment_class = $this->class; ?>

    <script type="text/javascript">
        var comments_url = '/<?= Localka::$lang_url ?><?= $Comment_class::$path; ?>';
        var news_url = '<?= $this->url ?>';
        var news_id = '<?= $this->id ?>';
    </script>

    <a name="comments"></a>
    <div class="comment_block <?= $this->html_class ?>">
    <? endif; ?>
    <div class="gray big left"><?= _ ( 'Comments' ) ?> (<?= $this->total; ?>)</div>

    <?= $this->pagination_html ?>

    <? if ( $this->sortable === true ) : ?>
        <div class="right_text">
            <? foreach ( $this->fields as $key => $row ) : ?>
                <? if ( isset ( $row[ 'selected' ] ) ) : ?>
                    <a class="order" order_type="<?= $row[ 'order' ] ?>" href="<?= $this->url . '?field=' . $key . '&order=' . ( $row[ 'order' ] == 'ASC' ? 'DESC' : 'ASC' ) ?>#comments"><?= $row[ 'text' ] ?></a>
                <? else : ?>
                    <a class="order" href="<?= $this->url . '?field=' . $key . '&order=' . $row[ 'order' ] ?>#comments"><?= $row[ 'text' ] ?></a>
                <? endif; ?>
            <? endforeach; ?>
            <img title="refresh" src="<?= Config::$static_url ?>images/system/refresh.png" class="refresh clickable text_bottom" />
        </div>
    <? endif; ?>

    <div class="clear"></div>

    <? if ( !empty ( $this->comments ) ) : ?>
        <? $i = 1; ?>
        <? foreach ( $this->comments as $row ) : ?>
            <div id="c_<?= $row[ 'id' ] ?>">
                <div class="user left" id="u_<?= $row[ 'user_id' ] ?>">
                    <? if ( is_null ( $row[ 'member_name' ] ) ) : ?>
                        <div class="avatar_block">
                            <img src="<?= Config::default_avatar ?>" alt="User Deleted" title="User Deleted" />
                        </div>
                    <? else : ?>
                        <div class="avatar_block <?= $row[ 'online_val' ] ?>line" alt="<?= $row[ 'online_val' ] ?>line" title="<?= $row[ 'online_val' ] ?>line">
                            <?= Output::profile ( $row[ 'member_name' ], '<img class="avatar" src="' . $row[ 'avatar' ] . '" alt="' . $row[ 'member_name' ] . '" title="' . $row[ 'member_name' ] . '"/>' ) ?>
                        </div>

                        <div class="stats">
                            <table>
                                <tr>
                                    <th>
                                        <img src="<?= Config::$static_url ?>images/system/gold_14.png" alt="Gold" title="Gold" />
                                    </th>

                                    <td>
                                        <?= $row[ 'gold' ] ?>
                                    </td>

                                    <th>
                                        <img src="http://forum.navi-gaming.com/Themes/default/images/<?= ( $row[ 'karma_bad' ] > $row[ 'karma_good' ] ? 'un' : '' ) ?>respect.png" alt="<?= ( $row[ 'karma_bad' ] > $row[ 'karma_good' ] ? 'Dis' : '' ) ?>Respect" title="Respects : <?= $row[ 'karma_good' ] ?>, DisRespects : <?= $row[ 'karma_bad' ] ?>" />
                                    </th>

                                    <td>
                                        <?= abs ( $row[ 'karma_good' ] - $row[ 'karma_bad' ] ) ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <? if ( !empty ( $row[ 'game' ] ) || !empty ( $row[ 'awards' ] ) ) : ?>
                            <div class="awards">
                                <? if ( !isset ( $this->user_games[ $row[ 'game' ] ] ) ) : ?>
                                    <? $j = 0; ?>
                                <? else : ?>
                                    <? $j = 1 ?>
                                    <img src="http://forum.navi-gaming.com/Themes/default/images/games/<?= $row[ 'game' ] ?>.png" alt="<?= $this->user_games[ $row[ 'game' ] ] ?>" title="<?= $this->user_games[ $row[ 'game' ] ] ?>" />
                                <? endif; ?>

                                <? if ( !empty ( $row[ 'awards' ] ) ): ?>
                                    <? foreach ( explode ( ',', $row[ 'awards' ] ) as $award ) : ?>
                                        <? if ( $j++ == 5 ) : ?>
                                            <? break; ?>
                                        <? endif; ?>
                                        <img src="http://forum.navi-gaming.com/awards/<?= $award ?>-mini.png" alt="<?= $this->awards[ $award ] ?>" title="<?= $this->awards[ $award ] ?>" />
                                    <? endforeach; ?>
                                <? endif; ?>
                            </div>
                        <? endif; ?>
                    <? endif; ?>
                </div>

                <div class="comment" <?= (!empty ( $row[ 'background-color' ] ) ? 'style="border : 1px solid #' . $row[ 'background-color' ] . ';background-color : #' . $row[ 'background-color' ] . ';"' : '') ?>>
                    <div class="head" <?= (!empty ( $row[ 'background-header-color' ] ) ? 'style="background-color : #' . $row[ 'background-header-color' ] . ';" title="' . $row[ 'group_name' ] . '"' : '' ) ?>>
                        <a class="link_to_post right" t_c="t1" url="http://<?= $_SERVER[ 'HTTP_HOST' ] ?>/<?= Localka::$lang_url ?><?= $this->url ?><?= ( $this->page == 1 ? '' : ( '?page=' . $this->page ) ) ?>#c_<?= ( ( $t = $i + $this->offset ) ) ?>" name="c_<?= $t ?>" >#<?= $t ?></a>

                        <div class="right">
                            <? if ( Auth::rule ( DB\Rules::COMMENTS_GOLD ) ) : ?>
                                <img src="<?= Config::$static_url ?>images/system/gold_14.png" title="<?= _ ( 'Give GOLD' ) ?>" alt="<?= _ ( 'Give GOLD' ) ?>" class="give_gold" />
                            <? endif; ?>
                            <? if ( Auth::rule ( DB\Rules::BAN_USER ) && ( $row[ 'group_id' ] != DB\Group::PHOBOS && $row[ 'group_id' ] != DB\Group::NAVI ) ) : ?>
                                <a href="http://forum.navi-gaming.com/admin/?area=ban;sa=add;u=<?= $row[ 'user_id' ] ?>">
                                    <img src="<?= Config::$static_url ?>images/system/hammer.png" title="Ban" alt="Ban" />
                                </a>
                            <? endif; ?>
                            <? if ( Auth::rule ( DB\Rules::COMMENTS_DELETE ) ) : ?>
                                <img src="http://forum.navi-gaming.com/Themes/default/images/delete_theme.png" title="<?= _ ( 'Delete' ) ?>" alt="<?= _ ( 'Delete' ) ?>" class="delete" />
                            <? endif; ?>
                        </div>

                        <? if ( !is_null ( $row[ 'member_name' ] ) ) : ?>
                            <img class="vertical_middle" src="<?= Config::$static_url ?>images/flags/<?= $row[ 'country_flag' ] ?>.png" alt="<?= $row[ 'country_flag' ] ?>" title="<?= $row[ 'country_flag' ] ?>" />
                            <?= Output::profile ( $row[ 'member_name' ], '<b' . ( empty ( $row[ 'color' ] ) ? '' : ( ' style="color:#' . $row[ 'color' ] . '"' ) ) . '>' . $row[ 'member_name' ] . '</b>' ) ?>
                        <? endif; ?>


                        <span class="date_info"><?= Output::date_format ( $row[ 'comment_date_ins' ], true ) ?> <?= ( Auth::rule ( DB\Rules::COMMENTS_DELETE ) ? ( '( ' . $row[ 'ip' ] . ' )' ) : '' ) ?></span>
                    </div>

                    <div class="hovered round">
                        <div class="body">
                            <? $rating = $row[ 'like' ] - $row[ 'dislike' ] ?>
                            <? if ( !$row[ 'deleted' ] ) : ?>
                                <? if ( $rating > -25 ) : ?>
                                    <?= DB\Abstr\Comments::replace_quotes ( $row[ 'content' ] ); ?>
                                <? else : ?>
                                    <?= _ ( 'This comment has received too many disrespects' ) ?>.
                                    <a class="show"><?= _ ( 'Show' ) ?>.</a>
                                    <div class="none">
                                        <?= DB\Abstr\Comments::replace_quotes ( $row[ 'content' ] ); ?>
                                    </div>
                                <? endif; ?>
                            <? else : ?>
                                <?= _ ( 'This comment was deleted' ) ?>.
                                <? if ( Auth::rule ( DB\Rules::COMMENTS_DELETE ) ) : ?>
                                    <a class="show"><?= _ ( 'Show' ) ?>.</a>
                                    <div class="none">
                                        <?= DB\Abstr\Comments::replace_quotes ( $row[ 'content' ] ); ?>
                                        <br/>
                                        <a class="restore"><?= _ ( 'Restore' ) ?>.</a>
                                    </div>
                                <? endif; ?>
                            <? endif; ?>
                        </div>

                        <div class="bottom">
                            <? if ( Auth::id () && !$row[ 'deleted' ] ) : ?>
                                <a class="comment_button"><?= _ ( 'Reply' ) ?></a>
                            <? endif; ?>

                            <div class="right">
                                <? if ( $rating ) : ?>
                                    <span title="Respects : <?= $row[ 'like' ] ?> DisRespects : <?= $row[ 'dislike' ] ?>" class="<?= ($rating > 0 ? 'positive' : 'negative' ) ?>"><?= sprintf ( "%+d", $rating ) ?></span> 
                                <? else : ?>
                                    <span title="Respects : <?= $row[ 'like' ] ?> DisRespects : <?= $row[ 'dislike' ] ?>">0</span> 
                                <? endif; ?>

                                <? if ( Auth::id () && Auth::id () != $row[ 'user_id' ] ) : ?>
                                    <span class="respect" title="Respect"></span>
                                    <span class="disrespect" title="DisRespect"></span>
                                <? endif; ?>
                            </div>
                            <? if ( $row[ 'comment_gold' ] ) : ?>
                                <span class="gold_info right">
                                    <span class="date_info"><?= _ ( 'For this comment' ) ?> <?= $row[ 'member_name' ] ?> <?= _ ( 'has received' ) ?></span>
                                    <span><?= $row[ 'comment_gold' ] ?> <img src="<?= Config::$static_url ?>images/system/gold_14.png" title="GOLD" alt="GOLD" /></span>
                                </span>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <? $i++; ?>
        <? endforeach; ?>
    <? endif; ?>

    <? if ( !Auth::id () ) : ?>
        <div class="auth_info left">
            <?= _ ( 'Only auth users can left comments' ) ?>.
            <x-button type="trigger" event="click" selector="x-popup.enter"><a class="black_button" href="<?= $this->url ?>#header"><?= _ ( 'Login' ) ?></a></x-button>
        </div>
        <?= $this->pagination_html ?>
        <div class="clear"></div>
    <? else : ?>
        <div class="auth_info left">
            <?= _ ( 'Leave comment' ) ?>
        </div>
        <?= $this->pagination_html ?>
        <div class="clear"></div>

        <div class="post">
            <div class="left">
                <img src="<?= Auth::user ( 'avatar' ) ?>" alt="<?= Auth::user ( 'member_name' ) ?>" title="<?= Auth::user ( 'member_name' ) ?>"/>
            </div>

            <div class="comment">
                <? $ban_message = DB\Forum\Ban::check_restriction ( 'cannot_post', FALSE ); ?>
                <? if ( $ban_message ) : ?>
                    <h2><?=_ ('Error') ?></h2>
                    <div class="error">
                        <?= $ban_message ?>
                    </div>
                <? else : ?>
                    <form method="POST">
                        <img src="<?= Config::$static_url ?>/images/system/close_11.png" class="close right" alt="Close" title="Close"  />
                        <?= _ ( 'Your comment' ) ?>

                        <textarea name="comment" placeholder="<?= _ ( 'Comment rules' ) ?>"></textarea>

                        <? if ( Session::get ( 'social' ) ) : ?>
                            <div class="left">
                                <input type="checkbox" name="share" id="share" />
                                <label for="share">Share in <?= Session::get ( 'social' ) ?></label>
                            </div>
                        <? endif; ?>

                        <div class="right_text">
                            <a class="black_button leave_comment">
                                <?= _ ( 'Leave comment' ) ?>
                            </a>
                        </div>

                        <div class="gray italic">
                            <?= _ ( 'Comment rules' ) ?>
                        </div>
                        <input type="hidden" name="id" value="<?= $this->id ?>" />
                        <?= Output::input_session () ?>
                    </form>
                <? endif; ?>
            </div>
        </div>
    <? endif; ?>
    <? if ( $this->ajax !== true ) : ?>
    </div>

    <div class="tooltip t1"><input type="text" value=""></div>
<? endif; ?>