<? $class = $this->class; //T_PAAMAYIM_NEKUDOTAYIM bla bla ?>
<? $this->average_score = $this->num_voted ? ceil( ( $this->rating / $this->num_voted) / $class::$step ) * $class::$step : 0; ?>


<? if ( isset( $this->ajax ) ) : ?>
    <link rel="stylesheet" type="text/css" href="<?= Config::$static_url ?>modules/blocks/rating/rating.css"></link>
<? else : ?>
    <? $this->css() ?>
<? endif; ?>
    
<div class="rating_block <?= $this->html_class ?>">
    <? if ( !isset( $this->user_vote ) && Auth::id() ) : ?>
        <? if ( isset( $this->ajax ) ) : ?>
            <script type="text/javascript">
                (function () {            
                    var script = document.createElement( 'script' );
                    script.onload = function () {
                        $(".jrating").jRating({
                            length:5,
                            rateMax: <?= $class::$max_score ?>,
                            phpPath: '<?= $class::$path ?>' ,
                            session_var: '<?= Session::get( 'session_var' )?>' ,
                            session_value: '<?= Session::get( 'session_value' )?>',
                            onSuccess : function( msg ){
                              alert( 'Success' );
                            },
                            onError : function(){
                              alert('Error : please retry');
                            }
                          });
                        document.body.removeChild( script );
                    };
                    script.src = "<?= Config::$static_url ?>modules/blocks/rating/rating.js";
                    document.body.appendChild( script );                       
                })(); 
                        
            </script>
        <? else: ?>
            <?= $this->js() ?>

            <script type="text/javascript">
              $(document).ready(function(){
                $(".jrating").jRating({
                  length:5,
                  rateMax: <?= $class::$max_score ?>,
                  phpPath: '<?= $class::$path ?>' ,
                  session_var: '<?= Session::get( 'session_var' )?>' ,
                  session_value: '<?= Session::get( 'session_value' )?>',
                  onSuccess : function( msg ){
                    alert( 'Success' );
                  },
                  onError : function(){
                    alert('Error : please retry');
                  }
                });
              });
            </script>
        <? endif; ?>
        <div class="jrating <?= $this->html_class ?>" id="<?= $this->average_score ?>_<?= $this->publication_id ?>"></div>
    <? else : ?>
        <div class="jrating" style="margin-bottom:5px;" title="<?= ( Auth::id() ? ( 'Your vote ' . $this->user_vote . ' / ' . $class::$max_score )  : '' )?>">
            <div class="jRatingColor" style="width: <?=(round( 115 * ($this->average_score / $class::$max_score) , 2) )?>px; "></div>
            <div class="jRatingAverage" style="width: 0px; top: -20px; "></div>
            <div class="jStar"></div>
        </div>
    <? endif; ?>
    <div>
        Average <?= 5 * $this->average_score / $class::$max_score ?> (<?= $this->average_score?> / <?= $class::$max_score ?>)<br/>
        Total voted <?= $this->num_voted?>
    </div>
</div>