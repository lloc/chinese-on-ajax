<?php

include_once ('vocabulary.php');

$lang = 'de';
if (isset ($_REQUEST['lang']) && $_REQUEST['lang'] == 'it') {
    $lang = 'it';
}
include_once ($lang . '.php');

$v = new Word ();
$vocab = $v->rand ();

include ('header.php');

?>
        <div id="preamble" class="active">
<?php include ('preamble_' . $lang . '.php'); ?>
            <div class="hide"><img id="hidep" src="del.png" alt="-" title="-" width="16" height="16" /></div>
        </div>
        <div id="preamble_h" class="inactive" style="display:none;">
            <p><?php echo STR_SHOWPREAMBLE; ?></p>    
            <div class="hide"><img id="showp" src="add.png" alt="+" title="+" width="16" height="16" /></div>
        </div>
        <div id="editor" class="active">
            <h2><?php echo STR_WRITEINPINYIN; ?></h2>
            <p class="zh" id="zh"><?php echo $vocab->zh; ?> <span id="control"><?php echo $vocab->py . ' : ' . $vocab->$lang; ?></span></p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset>
                    <input type="hidden" id="lang" name="lang" value="<?php echo $lang; ?>" />
                    <input type="hidden" id="solution" name="solution" value="<?php echo $vocab->py; ?>" />
                    <input type="hidden" id="right_count" name="right_count" value="0" />
                    <input type="hidden" id="all_count" name="all_count" value="0" />
                    <input type="hidden" id="mode" name="mode" value="Word" />
                    <textarea name="text" id="text" class="atext" cols="80" rows="5"><?php echo $text; ?></textarea>
                    <div id="tones">
                        <input type="button" id="a1" value="ā" />
                        <input type="button" id="a2" value="á" />
                        <input type="button" id="a3" value="ǎ" />
                        <input type="button" id="a4" value="à" />
                        <input type="button" id="o1" value="ō" />
                        <input type="button" id="o2" value="ó" />
                        <input type="button" id="o3" value="ǒ" />
                        <input type="button" id="o4" value="ò" />
                        <input type="button" id="e1" value="ē" />
                        <input type="button" id="e2" value="é" />
                        <input type="button" id="e3" value="ě" />
                        <input type="button" id="e4" value="è" />
                        <input type="button" id="i1" value="ī" />
                        <input type="button" id="i2" value="í" />
                        <input type="button" id="i3" value="ǐ" />
                        <input type="button" id="i4" value="ì" />
                        <input type="button" id="u1" value="ū" />
                        <input type="button" id="u2" value="ú" />
                        <input type="button" id="u3" value="ǔ" />
                        <input type="button" id="u4" value="ù" />
                        <input type="button" id="v0" value="ü" />
                        <input type="button" id="v1" value="ǖ" />
                        <input type="button" id="v2" value="ǘ" />
                        <input type="button" id="v3" value="ǚ" />
                        <input type="button" id="v4" value="ǜ" />
                    </div>
                </fieldset>
            </form>
	    <div id="start" title="Restart"><img src="start.png" alt="Restart" /></div>
	    <div id="smode" title="[ESC]"><img src="word.png" alt="[ESC]" /></div>
	    <div id="next" title="[TAB]"><img src="next.png" alt="[TAB]" /></div>
	    <div id="state" title="[RETURN]"><img src="active.png" alt="[RETURN]" /></div>
	    <div id="loader" style="display:none;"><img src="ajax-loader.gif" alt="Loading" /></div>
            <div id="points">0/0</div>
        </div>
        <div id="help" class="active">
<?php include ('help_' . $lang . '.php'); ?>
            <div class="hide"><img id="hideh" src="del.png" alt="-" title="-" width="16" height="16" /></div>
        </div>
        <div id="help_h" class="inactive" style="display:none;">
            <p><?php echo STR_SHOWHELP; ?></p>    
            <div class="hide"><img id="showh" src="add.png" alt="+" title="+" width="16" height="16" /></div>
        </div>
        <script type="text/javascript" src="pinyin.js"></script>
<?php

include ('footer.php');

?>
