<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 02/07/2016
 * Time: 00:05
 */

namespace Maps_red\TicketingBundle\Utils;

class UrlReplacer
{
    private $rexProtocol = '(https?://)?';
    private $rexDomain = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
    private $rexPort = '(:[0-9]{1,5})?';
    private $rexPath = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
    private $rexQuery = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
    private $rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';

    /**
     * @param $text
     * @return string
     */
    public function replacer($text)
    {
        $regex = $this->regex();

        return preg_replace_callback("&\\b$regex(?=[?.!,;:\"]?(\s|$))&", 'self::callback', htmlspecialchars($text));
    }

    /**
     * @return string
     */
    public function regex()
    {
        return $this->rexProtocol.$this->rexDomain.$this->rexPort.$this->rexPath.$this->rexQuery.$this->rexFragment;
    }

    /**
     * @param $match
     * @return string
     */
    public function callback($match)
    {
        // Prepend http:// if no protocol specified
        $completeUrl = $match[1] ? $match[0] : "http://{$match[0]}";

        return '<a href="'.$completeUrl.'">'.$match[2].$match[3].$match[4].'</a>';
    }
}