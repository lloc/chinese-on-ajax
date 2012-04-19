<?php

class Vocabulary {

    public $xml;
    public $items = array (); 

    function __construct () {
        if (isset ($this->file) && is_file ($this->file)) {
            $xml = file_get_contents ($this->file);
            $this->xml = new SimpleXMLElement ($xml);
            foreach ($this->xml as $obj) {
                $this->items[] = new Item ($obj);
            }
        }
    }

    function rand () {
        if (!empty ($this->items)) {
            $random = rand (0, count ($this->items) - 1);
            return $this->items[$random];
        }
        return new Item ();
    }

    function get () {
        $retval = array ();
        foreach ($this->items as $item) {
            $retval[] = get_object_vars ($item);
        }
        return $retval;
    }

    function checkUnique () {
        $arr = array ();
        foreach ($this->items as $item) {
            if (in_array ($item->zh, $arr)) {
                echo print_r ($item, TRUE) . " ist mehrfach vorhanden!<br>";
            }
            else {
                $arr[] = $item->zh;
            }
        }
    }

    function factory ($type = 'Word') {
        if ($type == 'Sentence') {
            return new Sentence ();
        }
        return new Word ();
    }

}

class Word extends Vocabulary {

    public $file = 'Word.xml';
    
}

class Sentence extends Vocabulary {

    public $file = 'Sentence.xml';

}

class Item {

    function __construct ($obj = null) {
        foreach (get_object_vars ($obj) as $key => $value) {
            if (!is_array ($value)) {
                $this->$key = $value;
            }
        }
    }

}

?>
