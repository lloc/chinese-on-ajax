<?php header('Content-type: application/x-json');

$retval = '';
if (isset ($_POST['text'])) {
    include_once ('pinyin.php');

    $py = new PinYin ($_POST['text']);
    $text = $py->generate ();
    $retval = array ('text' => trim ($text));
}
elseif (isset ($_POST['next'])) {
    include_once ('vocabulary.php');
    $vocabulary = Vocabulary::factory ($_POST['mode']);
    $vocab = $vocabulary->rand ();
    $retval = array ('zh' => $vocab->zh, 'solution' => $vocab->py, 'means' => $vocab->$_POST['lang']);
}
echo json_encode ($retval);

?>
