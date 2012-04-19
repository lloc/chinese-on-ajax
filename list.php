<?php

include_once ('vocabulary.php');

$lang = 'de';
if (isset ($_REQUEST['lang']) && $_REQUEST['lang'] == 'it') {
    $lang = 'it';
}
include_once ($lang . '.php');

class VocabularyDecorator {

    var $obj;

    function __construct ($obj) {
        $this->obj = $obj;
    }

    function get () {
        global $lang;
        $arr = array ();
        foreach ($this->obj->get () as $item) {
            if ($lang == 'it') {
                unset ($item['de']);
            }
            else {
                unset ($item['it']);
            }
            $arr[] = $item;
        }
        return $arr;
    }

    function out () {
        $items = $this->get ();
        if (!empty ($items)) {
            $retval = array (
                '<th>' . implode ('</th><th>', array_keys ($items[0])) . '</th>'
            );
            foreach ($items as $item) {
                $retval[] = '<td>' . implode ('</td><td>', $item) . '</td>';
            }
            echo '<table><tr>' . implode ('</tr><tr>', $retval) . '</tr></table>';
        }
        return count ($items);
    }

}

$v = new Word ();
$o = new VocabularyDecorator ($v);

include ('header.php');

?>
        <div id="vocabels">
            <h2><?php echo STR_WORDS; ?></h2>
<?php

$counter = $o->out ();

?>
            <p><b><?php echo $counter; ?></b> <?php echo STR_WORDS; ?>.</p>
            <p><?php $v->checkUnique (); ?></p>
<?php

$v = new Sentence ();
$o = new VocabularyDecorator ($v);

?>
            <h2><?php echo STR_SENTENCES; ?></h2>
<?php

$counter = $o->out ();

?>
            <p><b><?php echo $counter; ?></b> <?php echo STR_SENTENCES; ?>.</p>
            <p><?php $v->checkUnique (); ?></p>
        </div>
<?php

include ('footer.php');

?>
