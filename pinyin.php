<?php

function findChar ($str, $tone = 0) {
    $arr =
        array (
            'a' => array ('ā', 'á', 'ǎ', 'à', 'a'),
            'o' => array ('ō', 'ó', 'ǒ', 'ò', 'o'),
            'e' => array ('ē', 'é', 'ě', 'è', 'e'),
            'i' => array ('ī', 'í', 'ǐ', 'ì', 'i'),
            'u' => array ('ū', 'ú', 'ǔ', 'ù', 'u'),
            'ü' => array ('ǖ', 'ǘ', 'ǚ', 'ǜ', 'ü'),
        );
    if (!ctype_digit ($tone) || $tone == 0) {
        $tone = 5;
    }
    $tone -= 1;
    $retval = array ($str, $str);
    if (strlen ($str) == 1) {
        $retval[1] = $arr[$str][$tone];
    }
    elseif ($str == 'iu') {
        $retval = array ('u', $arr['u'][$tone]);
    }
    else {
        foreach ($arr as $key => $value) {
            if (preg_match ("/" . $key . "/", $str)) {
                $retval = array ($key, $value[$tone]);
                break;
            } 
        }
    }
    return $retval;
}

class PinYin {

    var $str;
    var $patterns;

    function __construct ($str = '') {
        $this->str = preg_replace ("/v/", "ü", $str);
        $this->patterns = array ();
    }

    function generate () {
        preg_match_all ("/([bpmfdtnlrjqxgkhywzcs]?|[zcs](h)?)(?P<vowel>(?<![āáǎàōóǒòēéěèīíǐìūúǔùǖǘǚǜ])[aoeiuü]+)((<?=e)r?|[ng]*)(?P<tone>[0-5])/i", $this->str, $arr, PREG_SET_ORDER);
        foreach ($arr as $val) {
            if (!isset ($this->pattern["/" . $val[0] . "/"])) {
                $replace = findChar ($val['vowel'], $val['tone']);
                $this->patterns["/" . $val[0] . "/"] = (!empty ($replace) ? substr (preg_replace ("/" . $replace[0] . "/", $replace[1], $val[0]), 0, -1) : $val[0]);
            }
        }
        $str = preg_replace (array_keys ($this->patterns), array_values ($this->patterns), $this->str);
        return $str;
    }

}

?>
