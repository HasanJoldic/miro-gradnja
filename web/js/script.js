$("#contactForm").submit(function(e) {
    if (!$("#contactForm").find("#tel")[0].value && !$("#contactForm").find("#email")[0].value) {
        e.preventDefault();
        $("#contactForm").find(".optionalInput").addClass("is-invalid");
    }
});

$('body').scrollspy({ target: '#sidebar' });

$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.listElementsParent'),
            currentEntry = $(this).parents('.listElements:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.listElements:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<i class="fa fa-minus-square" aria-hidden="true"></i>\n');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.listElements:first').remove();

        e.preventDefault();
        return false;
    });


});