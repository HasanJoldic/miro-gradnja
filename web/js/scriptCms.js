$(document).keydown(function(event){
    if(event.which=="17")
        cntrlIsPressed = true;
});

$(document).keyup(function(){
    cntrlIsPressed = false;
});

var cntrlIsPressed = false;

function selectMe(type, title, uid, imageText, jumbotron) {
    var toReturn = true;
    if (cntrlIsPressed || type === "SETTINGS" || type === "CALENDAR") {
        $("#cms-modal").find(".modal-title").html(title);
        var form = constants[type];
        if (jumbotron) {
            form = form.replace(/__insertUrl__/g, uid);
            form = form.replace("__insertTitle__", imageText);
            $("#cms-modal").find(".modal-body").html(form)
            $("#cms-modal").find("#type").attr("value", type);
            $("#cms-modal").find("#subtype").attr("value");
            $("#cms-modal").modal("show");
            $("#carouselModal").attr("id", "carouselModalDisabled");
            toReturn = false;
        } else {
            if (uid) {
                form = form.replace(/__insertUid__/g, uid);
            }
            if (uid && uid.indexOf("-") === -1) {
                var file = $("input").filter("#" + uid)[0].files[0];
                var fr = new FileReader();
                fr.onload = function () {
                    form = form.replace(/http:\/\/.*\.jpg/g, fr.result);
                    if (imageText) {
                        form = form.replace("__insertImageDescription__", imageText);
                    }
                    $("#cms-modal").find(".modal-body").html(form)
                    $("#cms-modal").find("#type").attr("value", type);
                    $("#cms-modal").find("#subtype").attr("value");
                    $("#cms-modal").modal("show");
                    $("#carouselModal").attr("id", "carouselModalDisabled");
                    toReturn = false;
                }
                fr.readAsDataURL(file);
            } else {
                if (imageText) {
                    form = form.replace("__insertImageDescription__", imageText);
                }
                $("#cms-modal").find(".modal-body").html(form)
                $("#cms-modal").find("#type").attr("value", type);
                $("#cms-modal").find("#subtype").attr("value");
                $("#cms-modal").modal("show");
                $("#carouselModal").attr("id", "carouselModalDisabled");
                toReturn = false;
            }
        }
        if (type === "CALENDAR") {
            $("#cms-modal").find("input").attr("min", uid).attr("max", imageText);
        }
    } else {
        $("#carouselModalDisabled").attr("id", "carouselModal");
    }
    cntrlIsPressed = false;
    return toReturn;
}

function onSubmitGalleryImage(event, id) {
    event.preventDefault();
    var inputField = null;
    if ($("#gallery-image-input-field")[0].files.length > 0) {
        inputField = $("#gallery-image-input-field").clone();
        inputField.attr("class", "file-input");
    }
    __changeThumbnail(id, inputField, $("#gallery-text-input-field")[0].value);
    $("#cms-modal").modal("hide");
}

function onGalleryImageChange(event) {
    event.preventDefault();
    if (event.currentTarget.files.length > 0) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#gallery-image-input-field-image").attr("src", fr.result);
        }
        fr.readAsDataURL(event.currentTarget.files[0]);
    }
}

function onSubmitAllGalleryImages(event) {
    var allInputFields = $("input").filter(".file-input");
    for (var i = 0; i < allInputFields.length; i++) {
        allInputFields.filter("#" + allInputFields[i].id).attr("name", "galleryImageFile" + (i));
    }
    var i = 0;
    var galleryImagesTextInput = $("#" + "gallery-images-text-input");
    $(".card-footer").each(function () {
        var galleryImagesTextInputClone = galleryImagesTextInput.clone();
        galleryImagesTextInputClone.attr("value", $(this).find("p").html())
            .attr("name", "galleryImageText" + i);
        galleryImagesTextInputClone.insertAfter(galleryImagesTextInput);
        i++;
    });
}

function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}
var currentButton;

function triggerInputFieldClick(event, buttonUid) {
    event.preventDefault();
    var galleryImagesInputField = $("#galleryImagesInputField");
    currentButton = buttonUid;
    galleryImagesInputField.trigger("click");
}

function onSubmitGalleryImageAndCreateThumbnail(event) {
    event.preventDefault();
    var galleryImagesInputField = $("#galleryImagesInputField")[0];
    if (galleryImagesInputField.files.length > 0) {
        var fr = new FileReader();
        fr.onload = function () {
            var uid = generateUid();
            while($("#" + uid).length > 0) {
                uid = generateUid();
            }

            $(".carousel-indicators").append($("<li id=" + uid +"></li>"));
            $(".carousel-inner").append(constants.CAROUSEL_ITEM.replace("__insertCarouselImage__", fr.result)
                .replace("__insertUid__", uid));

            var cmsElement = constants.GALLERY_THUMBNAIL_CARD;
            cmsElement = cmsElement.replace(/__insertFileUri__/g, fr.result);
            cmsElement = cmsElement.replace(/__insertUid__/g, uid);
            cmsElement = $(cmsElement);
            cmsElement.insertAfter($(".add-image-button").filter("#" + currentButton));
            var galleryImagesInputFieldClone = $("#galleryImagesInputField").clone();
            galleryImagesInputFieldClone.attr("id", uid).attr("class", "file-input");
            galleryImagesInputFieldClone.insertAfter(cmsElement);
            var addImageButton = constants.ADD_IMAGE_BUTTON.replace(/__insertUid__/g, uid);
            var newElement = $(addImageButton);
            newElement.insertAfter(galleryImagesInputFieldClone);

            fixCarouselOrder();
        }
    }
    fr.readAsDataURL(galleryImagesInputField.files[0]);
}

function generateUid() {
    return Math.floor(Math.random() * 1000000000000);
}

function removeElementsWithId(id) {
    while ($("#" + id).length>0) {
        $("#" + id).remove();
    };
    $(".modal").modal("hide");
}

function fixCarouselOrder() {
    var idOrder = [];
    $(".cms-element.col-lg-2").each(function (element) {
        idOrder.push(this.id);
    });

    var carouselItems = $(".carousel-item");
    var carouselIndicators = $(".carousel-indicator");
    var carouselInner = $(".carousel-inner").html("");
    for (var i = 0; i < idOrder.length; i++) {
        carouselItems.each(function () {
            if (this.id === idOrder[i]) {
                carouselInner.append(this);
            }
        });
        carouselIndicators.each(function () {
            if (this.parentElement.id === idOrder[i]) {
                $(this).attr("data-slide-to", i);
            }
        })
    }

    $(".carousel-indicators ol:first-child").attr("class", "active");
    $(".carousel-inner:first-child").attr("class", "carousel-item active");
}

function __changeThumbnail(id, inputField, text) {
    if (inputField) {
        updateInputField(id, inputField);
        updateThumbnailImage(id, inputField);
    }
    if (text) {
        updateThumbnailText(id, text);
    }
}

function updateInputField(id, inputField) {
    inputField.attr("id", id);
    inputField.attr("hidden", "hidden");
    var oldInputField = $("input").filter("#" + id);
    oldInputField.attr("id", id + "OLD")
    inputField.insertAfter($("input").filter("#" + id + "OLD"));
    $("input").filter("#" + id + "OLD").remove();
}

function updateThumbnailImage(id, inputField) {
    var cmsElement = $(".cms-element.col-lg-2").filter("#" + id);
    var fr = new FileReader();
    fr.onload = function () {
        cmsElement.find("img").attr("src", fr.result);
    }
    fr.readAsDataURL(inputField[0].files[0]);
}

function updateThumbnailText(id, text) {
    var pElement = $(".cms-element.col-lg-2").filter("#" + id).find(".card-footer").find("p");
    pElement.html(text);
}

function confirmModal(title, question, callback, url) {
    var form = constants["CONFIRM_MODAL"];
    var f = 'post("izbrisi", "' + url + '")';
    form = form.replace(/__insertQuestion__/g, question);
    $("#confirm-modal").find("modal-title").html(title);
    $("#confirm-modal").find(".modal-body").html(form);
    $("#confirm-modal").find(".btn-danger").attr("onclick", f);
    $("#confirm-modal").modal("show");
}


function removeServiceItem(args) {
    var url = args[0];
    post("/cms/izbrisi-uslugu", url);
}