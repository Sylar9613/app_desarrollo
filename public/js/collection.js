/**
 * Created by Arian-PC on 22/03/2020.
 */
var $collectionHolderAccion;
var $collectionHolderLinea;

// setup an "add a tag" link
var $addAccionButton = $('<button type="button" class="add_tag_link btn bg-primary-angular"><i class="fa fa-fw fa-file-o"></i>&nbsp;Agregar un elemento</button>');
var $newLinkAccionLi = $('<li style="list-style-type:none;"></li>').append($addAccionButton);

var $addLineaButton = $('<button type="button" class="add_tag_link btn bg-primary-angular"><i class="fa fa-fw fa-file-o"></i>&nbsp;Agregar una l&iacute;nea estrat&eacute;gica</button>');
var $newLinkLineaLi = $('<li style="list-style-type:none;"></li>').append($addLineaButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolderLinea = $('ul.lineas');
    $collectionHolderAccion = $('ul.acciones');

    // add a delete link to all of the existing tag form li elements
    $collectionHolderAccion.find('li').each(function() {
        addAccionFormDeleteLink($(this));
    });
    $collectionHolderLinea.find('li').each(function() {
        addLineaFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolderAccion.append($newLinkAccionLi);
    $collectionHolderLinea.append($newLinkLineaLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolderAccion.data('index', $collectionHolderAccion.find(':input').length);
    $collectionHolderLinea.data('index', $collectionHolderLinea.find(':input').length);

    $addLineaButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addLineaForm($collectionHolderLinea, $newLinkLineaLi);
    });
    $addAccionButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addAccionForm($collectionHolderAccion, $newLinkAccionLi);
    });
});

function addLineaForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li style="border-top: 1px solid #3B5998; padding-top: 20px; list-style-type:none;"></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addLineaFormDeleteLink($newFormLi);
}

function addAccionForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li style="border-top: 1px solid #3B5998; padding-top: 20px; list-style-type:none;"></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    // add a delete link to the new form
    addAccionFormDeleteLink($newFormLi);
}

function addAccionFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button class="btn btn-danger w3-margin-bottom w3-margin-top" type="button"><i class="fa fa-fw fa-trash-o"></i>&nbsp;Eliminar este elemento</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

function addLineaFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button class="btn btn-danger w3-margin-bottom w3-margin-top" type="button"><i class="fa fa-fw fa-trash-o"></i>&nbsp;Eliminar esta l&iacute;nea estrat&eacute;gica</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}