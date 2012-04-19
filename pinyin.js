//+ Jonas Raoni Soares Silva
//@ http://jsfromhell.com/forms/selection [v1.0]

Selection = function(input){
    this.isTA = (this.input = input).nodeName.toLowerCase() == "textarea";
};
with({o: Selection.prototype}){
    o.setCaret = function(start, end){
        var o = this.input;
        if(Selection.isStandard)
            o.setSelectionRange(start, end);
        else if(Selection.isSupported){
            var t = this.input.createTextRange();
            end -= start + o.value.slice(start + 1, end).split("\n").length - 1;
            start -= o.value.slice(0, start).split("\n").length - 1;
            t.move("character", start), t.moveEnd("character", end), t.select();
        }
    };
    o.getCaret = function(){
        var o = this.input, d = document;
        if(Selection.isStandard)
            return {start: o.selectionStart, end: o.selectionEnd};
        else if(Selection.isSupported){
            var s = (this.input.focus(), d.selection.createRange()), r, start, end, value;
            if(s.parentElement() != o)
                return {start: 0, end: 0};
            if(this.isTA ? (r = s.duplicate()).moveToElementText(o) : r = o.createTextRange(), !this.isTA)
                return r.setEndPoint("EndToStart", s), {start: r.text.length, end: r.text.length + s.text.length};
            for(var $ = "[###]"; (value = o.value).indexOf($) + 1; $ += $);
            r.setEndPoint("StartToEnd", s), r.text = $ + r.text, end = o.value.indexOf($);
            s.text = $, start = o.value.indexOf($);
            if(d.execCommand && d.queryCommandSupported("Undo"))
                for(r = 3; --r; d.execCommand("Undo"));
            return o.value = value, this.setCaret(start, end), {start: start, end: end};
        }
        return {start: 0, end: 0};
    };
    o.getText = function(){
        var o = this.getCaret();
        return this.input.value.slice(o.start, o.end);
    };
    o.setText = function(text){
        var o = this.getCaret(), i = this.input, s = i.value;
        i.value = s.slice(0, o.start) + text + s.slice(o.end);
        this.setCaret(o.start += text.length, o.start);
    };
    new function(){
        var d = document, o = d.createElement("input"), s = Selection;
        s.isStandard = "selectionStart" in o;
        s.isSupported = s.isStandard || (o = d.selection) && !!o.createRange();
    };
}

function insert(evt){
    var e = Event.element(evt);
    window.slctn.setText(e.value);
    $('text').focus();
}

var manager = new CookieManager();

function parseText(){
    new Ajax.Request('generate.php', { parameters: {text: $F('text')}, onCreate: showAjaxLoader, onComplete: getParseResponse});
}

function getNext(){
    new Ajax.Request('generate.php', { parameters: {next: 1, mode: $F('mode'), lang: $F('lang')}, onCreate: showAjaxLoader, onComplete: getNextResponse});
}

function getParseResponse(oReq){
    var json = oReq.responseText.evalJSON();
    $('text').value = json.text;
    var rc = parseInt($F('right_count'));
    if($F('text').toLowerCase() == $F('solution').toLowerCase()) {
        rc += 1;
        changeStyles(1);
    }
    else {
        changeStyles(2);
    }
    var ac = parseInt($F('all_count')) + 1;
    $('control').show();
    $('text').focus();
    setPoints(rc, ac)
}

function getNextResponse(oReq){
    var json = oReq.responseText.evalJSON();
    var ctrl = new Element('span', { 'id': 'control'}).update(json.solution + ' : ' + json.means).hide();
    $('zh').update(json.zh + ' ').appendChild(ctrl);
    $('solution').value = json.solution;
    changeStyles(0);
    $('text').value = '';
    $('text').focus();
}

function setPoints(rc, ac){
    $('points').update(rc + '/' + ac);
    $('right_count').value = rc;
    $('all_count').value = ac;
    manager.setCookie('ac_cookie', $F('all_count'));
    manager.setCookie('rc_cookie', $F('right_count'));
}

function changeStyles(state){
    $('loader').hide();
    if(state == 1){
        $('editor').className = 'right';
        $('text').className = 'rtext';
        var i = new Element('img', { 'src' : 'ajax-loader-r.gif', 'alt' : '' });
        var j = new Element('img', { 'src' : 'right.png', 'alt' : '' });
    }
    else if(state == 2){
        $('editor').className = 'wrong';
        $('text').className = 'wtext';
        var i = new Element('img', { 'src' : 'ajax-loader-w.gif', 'alt' : '' });
        var j = new Element('img', { 'src' : 'wrong.png', 'alt' : '' });
    }
    else {
        $('editor').className = 'active';
        $('text').className = 'atext';
        var i = new Element('img', { 'src' : 'ajax-loader.gif', 'alt' : '' });
        var j = new Element('img', { 'src' : 'active.png', 'alt' : '[RETURN]' });
    }
    $('loader').update('').appendChild(i);
    $('state').update('').appendChild(j);
}

function showAjaxLoader(){
    $('loader').show();
}

function changeMode(){
    if($F('mode') == 'Sentence'){
        $('mode').value = 'Word';
        var i = new Element('img', { 'src' : 'word.png', 'alt' : '[ESC]' });
    }
    else {
        $('mode').value = 'Sentence';
        var i = new Element('img', { 'src' : 'sentence.png', 'alt' : '[ESC]' });
    }
    $('smode').update('').appendChild(i);
    manager.setCookie('mode_cookie', $F('mode'));
    getNext ();
    $('text').focus();
}

function initVars(){
    var cookieVar = manager.getCookie('rc_cookie');
    var rc = cookieVar ? parseInt(cookieVar) : 0;
    cookieVar = manager.getCookie('ac_cookie');
    var ac = cookieVar ? parseInt(cookieVar) : 0;
    setPoints(rc, ac);
    if(manager.getCookie('hidep_cookie') == 1){
        $('preamble').hide();
        $('preamble_h').show();
    }
    if(manager.getCookie('hideh_cookie') == 1){
        $('help').hide();
        $('help_h').show();
    }
    if(manager.getCookie('mode_cookie') == 'Sentence'){
        changeMode();
    }
}

$('hidep').observe('click', function(e){
    $('preamble').hide();
    $('preamble_h').show();
    manager.setCookie('hidep_cookie', 1);
});
$('showp').observe('click', function(e){
    $('preamble').show();
    $('preamble_h').hide();
    manager.setCookie('hidep_cookie', 0);
});

$('hideh').observe('click', function(e){
    $('help').hide();
    $('help_h').show();
    manager.setCookie('hideh_cookie', 1);
});
$('showh').observe('click', function(e){
    $('help').show();
    $('help_h').hide();
    manager.setCookie('hideh_cookie', 0);
});

$('control').hide();
window.slctn = new Selection($('text'));
var f = $$('div#tones input');
for(var i=0; i<f.length; i++){
    $(f[i]).observe('click', insert);
    $(f[i]).observe('mouseover', function() { this.style.cursor = 'pointer' });
}
$('text').observe('keydown', function(e){
    switch (e.keyCode) {
        case Event.KEY_RETURN:
            parseText();
            break;
        case Event.KEY_TAB:
            getNext();
            break;
        case Event.KEY_ESC:
            changeMode();
            break;
    }
})

$('start').observe('click', function(e){ setPoints(0, 0); })
$('next').observe('click', function(){ getNext(); });
$('state').observe('click', function(){ parseText(); });
$('smode').observe('click', function(){ changeMode(); });

['hidep', 'showp', 'hideh', 'showh', 'start', 'next', 'state', 'smode'].each(
    function(item){
        $(item).observe('mouseover', function() { this.style.cursor = 'pointer' })
    }
);

initVars();
Event.observe(window, 'unload', Event.unloadCache, false);
