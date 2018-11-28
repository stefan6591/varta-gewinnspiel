var $collectionHolder;
var $addButton = $('<button type="button" class="btn btn-sm btn-primary add_answer">Antwort hinzufügen</button>');
var $newLinkLi = $('<li></li>').append($addButton);

$(document).ready(function () {

    $('#contest_admin_type_startDate').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#contest_admin_type_endDate').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#contest_admin_type_type').on('change', function (e) {
        console.log('foo');
        $('#question-form-container').toggle();
    });

    $collectionHolder = $('ul.answers');
    $collectionHolder.append($newLinkLi);
    console.log($collectionHolder.find(':input').length);
    $collectionHolder.data('index', $collectionHolder.find('input.form-control').length);
    $addButton.on('click', function(e) {
        addForm($collectionHolder, $newLinkLi);
    });
});

function addForm($collectionHolder, $newLinkLi) {

    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    newForm = newForm.replace(/__name2__/g, index + 1);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}