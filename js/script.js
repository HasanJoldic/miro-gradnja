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

(function() {
   var pathname = window.location.pathname;
    $(".nav-link").removeClass("active");
    var navLinks = $(".nav-link");
    if (pathname === "/") {
        $(navLinks[0]).addClass("active");
    } else if (pathname.indexOf("/usluge") !== -1) {
        $(navLinks[1]).addClass("active");
    } else if (pathname.indexOf("/galerija") !== -1) {
        $(navLinks[2]).addClass("active");
    } else if (pathname.indexOf("/kontakt") !== -1) {
        $(navLinks[3]).addClass("active");
    } else if (pathname.indexOf("/o-nama") !== -1) {
        $(navLinks[4]).addClass("active");
    }
})();
