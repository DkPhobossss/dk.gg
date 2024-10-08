<?php
class Email
{
    //const webmaster_email = 'admin@' . Config::SITE_NAME;
    const webmaster_email = 'dkphobos@mail.ru';
    const default_from = Config::SITE_NAME;
    
    static $order_emails = array( \Localka::RU =>  array( 'sale@metsui.ru' ) , 
                                    \Localka::EN => array( 'igor@metsui.ru' ) );

    public static function order( $email , $name , $ip,  $id , $order , $currency )
    {
        $subject = ( 'Заказ' ) . ' #' . $id;
        
        $message = ('Оформлена заявка на покупку следующих товаров на сайте') . ' http://' . $_SERVER['HTTP_HOST'];
        
        $message  .= '</br></br><h1>' . $subject . '</h1>';
        
        $message .= '<table border="1" style="border-collapse:collapse;">
            <tr>
            <th>#</th>
            <th width="270">-</th>
            <th>' . ('Арт.') . '</th>
            <th>' . ('Модель') . '</th>
            <th>' . ('Цена') . '</th>
            <th>' . ('Количество') . '</th>
            <th>' . ('Всего') .'</th>
            </tr>';
        
        $ids = array();
        foreach ( $order as $row )
        {
            $ids[ $row['product_id'] ] = true;
        }
        $product_data = DB\Shop\product::get_order( array_keys( $ids ) );

        $sum = 0;
        $i = 0;
        foreach ( $order as $row )
        {
            $message .= '<tr>
                        <td style="padding:5px;">' . ++$i . '</td>
                
                        <td style="padding:5px;">
                            <a href="http://' . $_SERVER['HTTP_HOST'] . '/' . $product_data[ $row['product_id'] ]['url'] .'" target="_blank">
                                <img width="250" height="80" src="'. $product_data[ $row['product_id'] ]['image'] .'" alt="'. $row['model'] .'" title="'. $row['model'] .'" />
                            </a>
                        </td>
                        
                        <td style="padding:5px;">'. $row['article'] .'</td>
                        
                        <td style="padding:5px;"><b>'. $row['model'] .'</b></td>
                        
                        <td style="padding:5px;">'. $row[ 'price_' . $currency ] .' '. DB\Shop\model::$price[ $currency ]['symbol'] .'</td>
                        
                        <td style="padding:5px;">'. $row['count'] .'</td>
                        
                        <td style="padding:5px;">'. $row[ 'price_' . $currency ] * $row['count'] .' '. DB\Shop\model::$price[ $currency ]['symbol'] .'</td>';
                        
                        
                        $sum += $row[ 'price_' . $currency ] * $row['count']; 
        }
        
        $message .= '<tr>
                        <td colspan="6">
                            '. ('Всего').'
                        </td>
                        
                        <td>
                            '. $sum .' '. DB\Shop\model::$price[ $currency ]['symbol'] .'
                        </td>
                    </tr></table>';
        
        self::sendmail( $email, $subject, $message );
        
        self::sendmail( self::$order_emails[ \Localka::$lang ], $subject, ( $message . 
            '</br>' . 'ip:' . $ip . '</br></br></br>' . 
            '<a href="' . ( $_SERVER['HTTP_HOST'] . '/' . Config::adminKA . '/order?id=' . $id ) . '">http://' . $_SERVER['HTTP_HOST'] . '/' . Config::adminKA . '/order?id=' . $id . '</a>' )
        );
    }
    
   
    public static function sendmail($to, $subject, $message, $from = null )
    {
        if ( empty( $from ) )
        {
            $from = self::webmaster_email;
        }
        if (empty($to))
        {
            return false;
        }
        // Line breaks need to be \r\n only in windows or for SMTP.
        $line_break =  "\n";

        // So far so good.
        $mail_result = true;

        // If the recipient list isn't an array, make it one.
        $to_array = is_array($to) ? $to : array($to);


        // Get rid of entities.
        $subject = htmlspecialchars($subject);
        // Make the message use the proper line breaks.
        $message = str_replace(array("\r", "\n"), array('', $line_break), $message);


        // Construct the mail headers...
        $headers = 'From: "' . self::default_from . '" <' .  $from . '>' . $line_break;
        $headers .= 'Return-Path: ' . $from . $line_break;
        $headers .= 'Date: ' . gmdate('D, d M Y H:i:s') . ' -0000' . $line_break;

        // Save the original message...
        $orig_message = $message;

        list($charset, $html_message, $encoding) = self::mimespecialchars($orig_message, false, null, $line_break);

        // Using mime, as it allows to send a plain unencoded alternative.
        $headers .= 'Mime-Version: 1.0' . $line_break;
        $headers .= 'Content-Type: text/html; charset=' . $charset . $line_break;

        $subject = strtr($subject, array("\r" => '', "\n" => ''));
       
        foreach ($to_array as $to)
        {
            if (!mail(strtr($to, array("\r" => '', "\n" => '')), $subject, $message, $headers))
            {
                $mail_result = false;
            }
        }
 
        // Everything go smoothly?
        return $mail_result;
    }
    
    // Prepare text strings for sending as email body or header.
    private static function mimespecialchars($string, $with_charset = true, $hotmail_fix = false, $line_break = "\r\n", $custom_charset = null)
    {
        $charset = $custom_charset !== null ? $custom_charset : 'UTF-8';

        // This is the fun part....
        if (preg_match_all('~&#(\d{3,8});~', $string, $matches) !== 0 && !$hotmail_fix)
        {
            // Let's, for now, assume there are only &#021;'ish characters.
            $simple = true;

            foreach ($matches[1] as $entity)
                if ($entity > 128)
                    $simple = false;
            unset($matches);

            if ($simple)
                $string = preg_replace('~&#(\d{3,8});~e', 'chr(\'$1\')', $string);
            else
            {
                $fixchar = create_function('$n', '
                    if ($n < 128)
                        return chr($n);
                    elseif ($n < 2048)
                        return chr(192 | $n >> 6) . chr(128 | $n & 63);
                    elseif ($n < 65536)
                        return chr(224 | $n >> 12) . chr(128 | $n >> 6 & 63) . chr(128 | $n & 63);
                    else
                        return chr(240 | $n >> 18) . chr(128 | $n >> 12 & 63) . chr(128 | $n >> 6 & 63) . chr(128 | $n & 63);');

                $string = preg_replace('~&#(\d{3,8});~e', '$fixchar(\'$1\')', $string);

                // Unicode, baby.
                $charset = 'UTF-8';
            }
        }

        // Convert all special characters to HTML entities...just for Hotmail :-\
        if ($hotmail_fix)
        {
            $entityConvert = create_function('$c', '
                if (strlen($c) === 1 && ord($c[0]) <= 0x7F)
                    return $c;
                elseif (strlen($c) === 2 && ord($c[0]) >= 0xC0 && ord($c[0]) <= 0xDF)
                    return "&#" . (((ord($c[0]) ^ 0xC0) << 6) + (ord($c[1]) ^ 0x80)) . ";";
                elseif (strlen($c) === 3 && ord($c[0]) >= 0xE0 && ord($c[0]) <= 0xEF)
                    return "&#" . (((ord($c[0]) ^ 0xE0) << 12) + ((ord($c[1]) ^ 0x80) << 6) + (ord($c[2]) ^ 0x80)) . ";";
                elseif (strlen($c) === 4 && ord($c[0]) >= 0xF0 && ord($c[0]) <= 0xF7)
                    return "&#" . (((ord($c[0]) ^ 0xF0) << 18) + ((ord($c[1]) ^ 0x80) << 12) + ((ord($c[2]) ^ 0x80) << 6) + (ord($c[3]) ^ 0x80)) . ";";
                else
                    return "";');

            // Convert all 'special' characters to HTML entities.
            return array($charset, preg_replace('~([\x80-' .  '\x{10FFFF}' . '])~eu', '$entityConvert(\'\1\')', $string), '7bit');
        }

        // We don't need to mess with the subject line if no special characters were in it..
        elseif (!$hotmail_fix && preg_match('~([^\x09\x0A\x0D\x20-\x7F])~', $string) === 1)
        {
            // Base64 encode.
            $string = base64_encode($string);

            // Show the characterset and the transfer-encoding for header strings.
            if ($with_charset)
                $string = '=?' . $charset . '?B?' . $string . '?=';

            // Break it up in lines (mail body).
            else
                $string = chunk_split($string, 76, $line_break);

            return array($charset, $string, 'base64');
        }

        else
            return array($charset, $string, '7bit');
    }
}