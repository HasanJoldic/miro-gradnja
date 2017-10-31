const constants = {
    BRAND:
    '<form method="POST" enctype="multipart/form-data" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="file" class="form-control-file" name="brandImage">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    FOOTER:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="footerText">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    SETTINGS:
    '<form method="POST" enctype="multipart/form-data" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <div class="form-group row">' +
    '        <label for="favicon" class="col-sm-4 col-form-label">Favicon</label>' +
    '        <div class="col-sm-8">' +
    '            <input type="file" class="form-control-file" id="favicon" name="faviconImage">' +
    '        </div>' +
    '    </div>' +
    '    <div class="form-group row">' +
    '        <label for="title" class="col-sm-4 col-form-label">Naslov stranice</label>' +
    '        <div class="col-sm-8">' +
    '            <input type="text" class="form-control-file" id="webPageTitle" name="pageTitle">' +
    '        </div>' +
    '    </div>' +
    '    <div class="form-group row pull-right">' +
    '        <button type="submit" id="submit" class="btn btn-primary">Zapamti promjene</button>' +
    '    </div>' +
    '</form>',

    CALENDAR:
    '<form method="POST" autocomplete="off" action="/cms/set-cms/">\n' +
    '    <div class="form-group row">' +
    '       <label class="col-sm-4 col-form-label" for="party">Odaberi datum:</label>\n' +
    '        <div class="col-sm-8">' +
    '           <input type="date" name="reset-database-to-date" min="2017-10-01" max="2017-12-31">\n' +
    '        </div>' +
    '    </div>' +
    '    <div class="form-group row pull-right">' +
    '        <button type="submit" id="submit" class="btn btn-primary">Vrati stranicu</button>' +
    '    </div>' +
    '</form>',

    ABOUT_US_TITLE:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="aboutUsTitle">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    ABOUT_US_TEXT:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group" style="width: 100%">\n' +
    '        <textarea type="" class="form-control-file" name="aboutUsText" cols="32"></textarea>' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    CONTACT_COMPANY_TITLE:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="contactCompanyTitle">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    ADDRESS_FIRST_LINE:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="addressFirstLine">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    ADDRESS_SECOND_LINE:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="addressSecondLine">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    ADDRESS_THIRD_LINE:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="addressThirdLine">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    CONTACT_PHONE_NUMBER:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="contactPhoneNumber">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    CONTACT_EMAIL:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="contactEmail">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    CONTACT_COMPANY_DESCRIPTION:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <textarea type="" class="form-control-file" name="contactCompanyDescription" cols="32"></textarea>' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    CONTACT_FACEBOOK_LINK:
    '<form method="POST" autocomplete="off" action="/cms/set-cms-soft/">\n' +
    '    <fieldset class="form-group">\n' +
    '        <input type="text" class="form-control-file" name="contactFacebookLink">' +
    '    </fieldset> <!-- form-group -->\n' +
    '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
    '</form>',

    GALLERY_IMAGE:
    '<form autocomplete="off" onsubmit="onSubmitGalleryImage(event, \'__insertUid__\')">' +
    '    <img id="gallery-image-input-field-image" width="100%"' +
    ' src="http://miro-gradnja.hr/static/images/all/__insertUid__.jpg">' +
    '    <fieldset style="margin-top: 10px" class="form-group">\n' +
    '        <input type="file" class="form-control-file" id="gallery-image-input-field"' +
    ' onchange="onGalleryImageChange(event)">' +
    '    </fieldset> <!-- form-group -->\n' +
    '    <fieldset style="margin-top: 10px" class="form-group">\n' +
    '        <label><input type="text" class="form-control-file" id="gallery-text-input-field"' +
    ' value="__insertImageDescription__">Opis slike</label>' +
    '    </fieldset> <!-- form-group -->\n' +
    '    <div  style="margin-top: 30px"><button type="button" id="delete" class="btn btn-danger' +
    ' pull-left" onclick="removeElementsWithId(\'__insertUid__\')">Izbrisi element</button>' +
    '    <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button></div>' +
    '</form>',

    ADD_IMAGE_BUTTON:
    ' <div class="col-lg-1 add-image-button" id="__insertUid__"> \n' +
    '     <button class="btn btn-primary btn-lg" style="position: absolute; top: 25%; left: 25%;"\n' +
    '    onclick=\'triggerInputFieldClick(event, "__insertUid__")\' >+</button> \n' +
    ' </div> ',

    CAROUSEL_ITEM:
    '<div class="carousel-item" id="__insertUid__">\n' +
    '    <img class="d-block w-100"\n' +
    '         src="__insertCarouselImage__")>\n' +
    '    <div class="carousel-caption d-none d-md-block">\n' +
    '        <p>Tekst opisa</p>\n' +
    '    </div>\n' +
    '</div>',

    GALLERY_THUMBNAIL_CARD:
    '    <div class="cms-element col-lg-2" data-toggle="modal" data-target="cms-modal"' +
    'onClick=\'return selectMe("GALLERY_IMAGE", "Promijeni, izbrisi, ili ubaci novu sliku",' +
    '    "__insertUid__", "Tekst opisa");\' id="__insertUid__">' +
    '    <div data-toggle="modal" data-target="#carouselModal" style="cursor: hand; cursor: pointer;"' +
    ' id="__insertUid__">' +
    '        <div class="carousel-indicator" data-target="#carouselIndicator"' +
    '           data-slide-to="__insertSlideIndex__">\n' +
    '            <img class="card-img-top" src="__insertFileUri__">' +
    '            <div class="card-body">' +
    '            </div>' +
    '            <div class="card-footer" style="background: none; border: none;">' +
    '                <p>Tekst opisa</p>' +
    '            </div>' +
    '        </div>' +
    '    </div>' +
    '</div>',

    JUMBOTRON:
    '<form method="POST" autocomplete="off" action="/cms/usluge">' +
    '    <p>Naslov: __insertTitle__</p>' +
    '    <fieldset style="margin-top: 10px" class="form-group">\n' +
    '        <label><input type="text" value="__insertUrl__" name="url">URL</label>' +
    '    </fieldset> <!-- form-group -->\n' +
    '    <input type="text" value="__insertUrl__" name="original-url" hidden="hidden">' +
    '    <input type="text" value="false" name="delete" id="delete-service" hidden="hidden">' +
    '    <div  style="margin-top: 30px"><button type="submit" id="delete" class="btn btn-danger' +
    ' pull-left" onclick="document.getElementById(\'delete-service\').setAttribute(\'value\', true);">Izbrisi element</button>' +
    '    <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button></div>' +
    '</form>',

    CONFIRM_MODAL:
    '    <p>__insertQuestion__</p>' +
    '    <div  style="margin-top: 30px"><button type="submit" id="delete" class="btn btn-danger' +
    ' pull-left" onclick="removeElementsWithId(\'__insertUid__\')">Izbrisi element</button>' +
    '    <button type="submit" id="submit" onclick="$(\'#modal\').modal(\'hide\')" ' +
    'class="btn btn-primary pull-right">Odustani</button></div>'
};

function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}
