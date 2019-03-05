<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class string
{

    function splitstr( $str )
    {
        $len = strlen( $str );
        $i = 0;
        $chinese = "";
        $english = "";
        while ( $i < $len )
        {
            if ( preg_match( "/^[".chr( 161 )."-".chr( 255 )."]+\$/", $str[$i] ) )
            {
                $chinese .= $str[$i].$str[$i + 1];
                $i += 2;
            }
            else
            {
                $english .= $str[$i];
                $i += 1;
            }
        }
        echo "原字符串为：".$str."<br>";
        if ( $chinese != "" )
        {
            echo "中文部分字符串：".$chinese."<br>";
        }
        if ( $english != "" )
        {
            echo "英文部分字符串：".$english."<br>";
        }
    }

    function islegalname( $str )
    {
        $i = 0;
        for ( ;	$i < strlen( $str );	++$i	)
        {
            $test = ord( substr( $str, $i, 1 ) );
            if ( $test < 45 || !( 45 < $test ) && $test < 48 || !( 57 < $test ) && $test < 65 || !( 90 < $test ) && $test < 95 || !( 95 < $test ) && $test < 97 || 122 < $test && $test < 160 )
            {
                $_obfuscate_RLOz4bq91Vk = 1;
            }
            else
            {
                $_obfuscate_RLOz4bq91Vk = 0;
                ++$i;
            }
        }
        if ( !$_obfuscate_RLOz4bq91Vk )
        {
            return 1;
        }
        return 0;
    }

    function iscn( $str )
    {
        $i = 0;
        for ( ;	$i < strlen( $str );	++$i	)
        {
            if ( !preg_match( "/^[".chr( 161 )."-".chr( 255 )."]+\$/", $str[$i] ) )
            {
                $_obfuscate_iWLevA = 1;
            }
        }
        return $_obfuscate_iWLevA;
    }

    function checkvalid( $type, $value )
    {
        if ( $type == "" )
        {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789_";
        }
        else
        {
            $chars = $type;
        }
        $checkStr = $value;
        $allValid = true;
        $i = 0;
        for ( ;	$i < strlen( $value );	++$i	)
        {
            $_obfuscate_u_c = $value[$i];
            $j = 0;
            for ( ;	$j < strlen( $chars );	++$j	)
            {
                if ( !( $_obfuscate_u_c == $chars[$j] ) )
                {
                    continue;
                }
                break;
            }
            if ( !( $j == strlen( $chars ) ) )
            {
                continue;
            }
            $allValid = false;
            break;
        }
        return $allValid;
    }

    function cut_str( $string, $cut_size, $start = 0, $code = "UTF-8" )
    {
        if ( $code == "UTF-8" )
        {
            $pa= "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            //$pa = "/[\x01-]|[?-?][?-?]|[?-?][?-?]|[?-?][?-?][?-?]|[?-?][?-?][?-?]|[?-?][?-?][?-?][?-?]/";
            //$pa = "/[\x01-]|[?遌[?-縘|郲?縘[?-縘|[?颹[?-縘[?-縘|餥?縘[?-縘[?-縘|[?鱙[?-縘[?-縘[?-縘/";
            preg_match_all( $pa, $string, $matches );
            if ( $cut_size < count( $matches[0] ) - $start )
            {
                return join( "", array_slice( $matches[0], $start, $cut_size ) )."...";
            }
            return join( "", array_slice( $matches[0], $start, $cut_size ) );
        }
        $start *= 2;
        $cut_size *= 2;
        $l = strlen( $string );
        $tmpstr = "";
        $i = 0;
        for ( ;	$i < $l;	++$i	)
        {
            if ( $start <= $i && $i < $start + $cut_size )
            {
                if ( 129 < ord( substr( $string, $i, 1 ) ) )
                {
                    $tmpstr .= substr( $string, $i, 2 );
                }
                else
                {
                    $tmpstr .= substr( $string, $i, 1 );
                }
            }
            if ( 129 < ord( substr( $string, $i, 1 ) ) )
            {
                ++$i;
            }
        }
        if ( strlen( $tmpstr ) < $l )
        {
            $tmpstr .= "...";
        }
        return $tmpstr;
    }

    function chgtitle( $title, $length )
    {
        if ( $length < strlen( $title ) )
        {
            $s = 0;
            $i = 0;
            for ( ;	$i < $length;	++$i	)
            {
                if ( 128 < ord( $title[$i] ) )
                {
                    ++$s;
                }
            }
            if ( $s % 2 == 0 )
            {
                $title = substr( $title, 0, $length )."...";
                return $title;
            }
            $title = substr( $title, 0, $length + 1 )."...";
        }
        return $title;
    }

    function strposhave( $string, $value )
    {
        $pos = strpos( $string, $value );
        if ( $pos === false )
        {
            return 0;
        }
        return 1;
    }

    function qj2bj( $string )
    {
        $qj2bj  = array( "１" => "1", "２" => "2", "３" => "3", "４" => "4", "５" => "5", "６" => "6", "７" => "7", "８" => "8", "９" => "9", "０" => "0", "ａ" => "a", "ｂ" => "b", "ｃ" => "c", "ｄ" => "d", "ｅ" => "e", "ｆ" => "f", "ｇ" => "g", "ｈ" => "h", "ｉ" => "i", "ｊ" => "j", "ｋ" => "k", "ｌ" => "l", "ｍ" => "m", "ｎ" => "n", "ｏ" => "o", "ｐ" => "p", "ｑ" => "q", "ｒ" => "r", "ｓ" => "s", "ｔ" => "t", "ｕ" => "u", "ｖ" => "v", "ｗ" => "w", "ｘ" => "x", "ｙ" => "y", "ｚ" => "z", "Ａ" => "A", "Ｂ" => "B", "Ｃ" => "C", "Ｄ" => "D", "Ｅ" => "E", "Ｆ" => "F", "Ｇ" => "G", "Ｈ" => "H", "Ｉ" => "I", "Ｊ" => "J", "Ｋ" => "K", "Ｌ" => "L", "Ｍ" => "M", "Ｎ" => "N", "Ｏ" => "O", "Ｐ" => "P", "Ｑ" => "Q", "Ｒ" => "R", "Ｓ" => "S", "Ｔ" => "T", "Ｕ" => "U", "Ｖ" => "V", "Ｗ" => "W", "Ｘ" => "X", "Ｙ" => "Y", "Ｚ" => "Z", "　" => " ", "，" => ",", "。" => ".", "？" => "?", "＜" => "<", "＞" => ">", "［" => "[", "］" => "]", "＊" => "*", "＆" => "&", "＾" => "^", "％" => "%", "＃" => "#", "＠" => "@", "！" => "!", "（" => "(", "）" => ")", "＋" => "+", "－" => "-", "｜" => "|", "：" => ":", "；" => ";", "｛" => "{", "｝" => "}", "／" => "/", "＂" => "\"", "～" => "~" );
        return strtr( $string, $qj2bj );
    }
    //Add by lu 2008-08-29
    /**
     * Copyright (c) 2008, David R. Nadeau, NadeauSoftware.com.
     * All rights reserved.
     *
     * Redistribution and use in source and binary forms, with or without
     * modification, are permitted provided that the following conditions
     * are met:
     *
     *	* Redistributions of source code must retain the above copyright
     *	  notice, this list of conditions and the following disclaimer.
     *
     *	* Redistributions in binary form must reproduce the above
     *	  copyright notice, this list of conditions and the following
     *	  disclaimer in the documentation and/or other materials provided
     *	  with the distribution.
     *
     *	* Neither the names of David R. Nadeau or NadeauSoftware.com, nor
     *	  the names of its contributors may be used to endorse or promote
     *	  products derived from this software without specific prior
     *	  written permission.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
     * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
     * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
     * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
     * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
     * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
     * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
     * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
     * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
     * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY
     * WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY
     * OF SUCH DAMAGE.
     */

    /*
     * This is a BSD License approved by the Open Source Initiative (OSI).
     * See:  http://www.opensource.org/licenses/bsd-license.php
     */


    /**
     * Strip out (X)HTML tags and invisible content.  This function
     * is useful as a prelude to tokenizing the visible text of a page
     * for use in a search engine or spam detector/remover.
     *
     * Unlike PHP's built-in strip_tags() function, this function will
     * remove invisible parts of a web page that normally should not be
     * indexed or passed through a spam filter.  This includes style
     * blocks, scripts, applets, embedded objects, and everything in the
     * page header.
     *
     * In anticipation of tokenizing the visible text, this function
     * detects (X)HTML block tags (such as divs, paragraphs, and table
     * cells) and inserts a carriage return before each one.  This
     * insures that after tags are removed, words before and after the
     * tag are not erroneously joined into a single word.
     *
     * Parameters:
     * 	text		the (X)HTML text to strip
     *
     * Return values:
     * 	the stripped text
     *
     * See:
     * 	http://nadeausoftware.com/articles/2007/09/php_tip_how_strip_html_tags_web_page
     */
    function strip_html_tags( $text )
    {
        // PHP's strip_tags() function will remove tags, but it
        // doesn't remove scripts, styles, and other unwanted
        // invisible text between tags.  Also, as a prelude to
        // tokenizing the text, we need to insure that when
        // block-level tags (such as <p> or <div>) are removed,
        // neighboring words aren't joined.

        // 2010.04.28
        if(strlen($text)>16*1024){
            $text = substr($text, 0, 16*1024);
        }
        // 2010.04.28

        $text = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',

                // Add line breaks before & after blocks
                '@<((br)|(hr))@iu',
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text );

        // 20100314, del `
        $text = str_replace("`", "", $text);

        // Remove all remaining tags and comments and return.
        return strip_tags( $text );
    }

    function strip_html_tags32( $text )
    {
        // PHP's strip_tags() function will remove tags, but it
        // doesn't remove scripts, styles, and other unwanted
        // invisible text between tags.  Also, as a prelude to
        // tokenizing the text, we need to insure that when
        // block-level tags (such as <p> or <div>) are removed,
        // neighboring words aren't joined.

        // 2011.9.28
        if(strlen($text)>16384){//16*1024
            $text = Common::cutstr($text, 16384, "utf-8", ".");
        }

        $text = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',

                // Add line breaks before & after blocks
                '@<((br)|(hr))@iu',
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text );

        // 20100314, del `
        $text = str_replace("`", "", $text);

        // Remove all remaining tags and comments and return.
        return strip_tags( $text );
    }

    static function strip_html_tags_new( $text )
    {
        // PHP's strip_tags() function will remove tags, but it
        // doesn't remove scripts, styles, and other unwanted
        // invisible text between tags.  Also, as a prelude to
        // tokenizing the text, we need to insure that when
        // block-level tags (such as <p> or <div>) are removed,
        // neighboring words aren't joined.

        // 2010.04.28
        if(strlen($text)>16*1024){
            //$text = substr($text, 0, 16*1024);
        }
        // 2010.04.28

        // 2011.11.30
        if(strlen($text)>16384){//16*1024
            $text = Common::cutstr($text, 16384, "utf-8", ".");
        }

        $text = preg_replace(
            array(
                // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',

                // Add line breaks before & after blocks
                '@<((br)|(hr))@iu',
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text );

        // 20100314, del `
        $text = str_replace("`", "", $text);
        // 20130707
        $text = str_replace("\"", "", $text);
        $text = str_replace("'", "", $text);

        // Remove all remaining tags and comments and return.
        return strip_tags( $text );
    }

}
