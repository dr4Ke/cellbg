/* JavaScript function to create cellbg toolbar in DokuwKki */
/* see https://www.dokuwiki.org/devel:toolbar for more info */

function createCellbgPicker(id, props, edid) {
    // create the wrapping div
    var $picker = jQuery(document.createElement('div'));

    $picker.addClass('picker a11y');

    $picker.attr('id', id).css('position', 'absolute');

    function $makebutton(title, colorValue) {
        var $btn = jQuery(document.createElement('button'))
            .addClass('pickerbutton cellbg').attr('title', title)
            .attr('aria-controls', edid);

        if (colorValue == 'RGB')
        {
            $btn.text(colorValue)
                .addClass('custom')
                .bind('click', bind(tb_format, $btn[0], props, edid));
        }
        else
        {
            var insertColorValue = "@" + colorValue + ":";
            $btn.css('backgroundColor', colorValue)
                .bind('click', bind(pickerInsert, insertColorValue, edid));
        }
        $btn.appendTo($picker);
        return $btn;
    }

    $makebutton('custom', 'RGB');
    jQuery.each(props.colorlist, function (key, item) {
        if (!props.colorlist.hasOwnProperty(key)) {
            return;
        }
        $makebutton(key, item);
    });
    jQuery('body').append($picker);

    // we have to return a DOM object (for compatibility reasons)
    return $picker[0];
}

/**
 * Add button action for color picker buttons and create color picker element
 *
 * @param  jQuery     btn   Button element to add the action to
 * @param  array      props Associative array of button properties
 * @param  string     edid  ID of the editor textarea
 * @return boolean    If button should be appended
 * @author Pavel Kochman <kochi@centrum.cz>
 */
function addBtnActionCellbgPicker($btn, props, edid) {
    var pickerid = 'picker_plugin_cellbg'; // picker id that we're creating
    var picker = createCellbgPicker(pickerid, props, edid);

    $btn.click(
        function(e) {
            pickerToggle(pickerid, $btn);
            e.preventDefault();
            return '';
        }
    );
    $btn.attr('aria-haspopup', 'true');

    return pickerid;
}

//Setup VIM: ex: et ts=2 sw=2 enc=utf-8 :
