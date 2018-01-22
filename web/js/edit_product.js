/**
 * Suppression de l'image dans la base et dans le dossier
 */
function deleteImages(imageId, $this){
    bootbox.confirm(
            "Etes vous sur de vouloir supprimer cette image?", 
            function(result){
                if(result){
                    $.ajax({
                        type: "POST",
                        url: Routing.generate('products_delete_image_ajax'),
                        data: {'id': imageId },
                        cache: false,
                        success: function(response){
                            if(response.success) {
                                $this.parents('.blc-image').remove();
                                bootbox.alert("Suppression success");
                            } else {
                                if(response.message){
                                    bootbox.alert(response.message);
                                }
                            }
                        }
                    });
                }
    });
}

$(function () {
    $(".datepicker").datepicker({
        language: 'fr',
        dateFormat: 'dd/mm/yy',
    });
    $(".datetimepicker").datetimepicker({
        locale: 'fr',
        format: 'DD/MM/YYYY HH:mm'
    });

    // control status like radios
    $("input[name='aes_bundle_productbundle_products[status][]']").change(function() {
        $("input[name='aes_bundle_productbundle_products[status][]']").prop('checked', false);
        $(this).prop('checked', true);
    });
    
    // validation date
    $('#aes_bundle_productbundle_products_preopeningDuration').change(function () {
        var startPreopeningDate = moment($('#aes_bundle_productbundle_products_startPreopeningDate').val(), 'DD/MM/YYYY HH:mm');
        var minStartBideDate = startPreopeningDate.add($(this).val(), 'hours');
        $('#aes_bundle_productbundle_products_startBideDate').data("DateTimePicker").minDate(minStartBideDate);
    });
    
    // Afficher/cacher formulaire vente privée
    $('#aes_bundle_productbundle_products_enabledPrivateDeal').change(function() {
        if ($(this).is(":checked")) {
            $('#form-private-deal').css('display', 'block');
        } else {
            $('#form-private-deal').css('display', 'none');
        }
     });
});

var collectionDisponibility = $('div#disponibility-fields-list');
var $addDisponibilityLink = $('<a href="#" class="btn_ajout" id="add-another-disponibility"><span><i class="fa fa-plus" aria-hidden="true"></i></span></a>');
var $newLinkDisponibility = $('<div></div>').append($addDisponibilityLink);

$(document).ready(function () {

    collectionDisponibility.find('div:nth-child(n+2)').each(function () {
        addDisponibilityFormDeleteLink($(this));
    });
    collectionDisponibility.append($newLinkDisponibility);
    collectionDisponibility.data('index', collectionDisponibility.find(':input').length);

    $addDisponibilityLink.on('click', function (e) {
        e.preventDefault();
        addDisponibilityForm(collectionDisponibility, $newLinkDisponibility, true);
    });
    if (disponibilityCount == 0) {
        addDisponibilityForm(collectionDisponibility, $newLinkDisponibility, false);
    }
    function addDisponibilityForm(collectionDisponibility, $newLinkDisponibility, addLinkDelete) {

        var prototype = collectionDisponibility.data('prototype');
        var index = collectionDisponibility.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        collectionDisponibility.data('index', index + 1);
        var $newFormLi = $('<div></div>').append(newForm);
        $newLinkDisponibility.before($newFormLi);
        if (addLinkDelete) {
            addDisponibilityFormDeleteLink($newFormLi);
        }
        $(".datepicker").datepicker({
            language: 'fr',
            dateFormat: 'dd/mm/yy'
        });
        $("input").focus(function () {
            $(this).parents('.form-group').removeClass('has-error');
        });
    }

    function addDisponibilityFormDeleteLink($tagFormLi) {
        var $removeFormA = $('<a href="#" class="btn_efface"><span><i class="fa fa-times" aria-hidden="true"></i></span></a>');
        $tagFormLi.append($removeFormA);

        $removeFormA.on('click', function (e) {
            e.preventDefault();
            $tagFormLi.remove();
        });
    }

});