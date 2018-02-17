function onUploadThumbnail(event) {
    if ($("#file-input")[0].files.length > 0) {
        var thumbnailContainer = $("#thumbnail-container");
        var fr = new FileReader();
        fr.onload = function () {
            if ($("#main-image").attr("src") === "/static/images/placeholder/grey.png") {
                $("#main-image").attr("src", fr.result);
                $(".file-container").find(".onClickDiv").attr("onClick",
                    'return changeMainImage("main-image");');
                var newInputField = $("#file-input").clone();
                newInputField.attr("id", "main-image-file-input");
                newInputField.css("display", "none").attr("name", "main-image");
                newInputField.appendTo($(".file-container"));

            } else {
                var num = 2000;
                var uuid = "img" + num;
                while ($("#" + uuid).length < 1 && num >= 1000) {
                    uuid = "img" + --num;
                }
                uuid = "img" + ++num;
                var thumbnail = thumbnailContainer.find("#thumbnail-image").clone();
                thumbnail.attr("id", "").css("display", "").find("img").attr("src", fr.result)
                    .attr("id", uuid);
                thumbnail.find(".onClickDiv").attr("onClick",
                    'return changeThumbnail("' + uuid + '");');
                thumbnail.prependTo(thumbnailContainer);
                var newInputField = $("#file-input").clone();
                newInputField.attr("id", uuid + "-input").css("display", "none").attr("name", uuid);
                newInputField.appendTo($(".file-container"));
                var imageTextInputField = $("#file-input").clone();
                imageTextInputField.attr("type", "text").attr("onchange", "").attr("accept", "")
                    .attr("id", uuid + "-text-input").css("display", "none")
                    .attr("name", uuid + "-text").attr("value", "Text opisa");
                imageTextInputField.appendTo($(".file-container"));
            }
        }
        fr.readAsDataURL($("#file-input")[0].files[0]);
    }
}

function formElementMainImage(imgUid) {
    return '<form autocomplete="off" onsubmit="onSubmitMainImage(event,' +
        imgUid +
        ')">\n' +
        '    <fieldset class="form-group">\n' +
        '        <input type="file" class="form-control-file" ' +
        ' id="change-thumbnail-image-input-field">' +
        '    </fieldset> <!-- form-group -->\n' +
        '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
        '</form>';
}
function onSubmitMainImage(event, imgUid) {
    event.preventDefault();
    if ($("#change-thumbnail-image-input-field")[0].files.length > 0) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#" + imgUid).attr("src", fr.result);
        }
        $("#cms-modal").modal("hide");
    }
    fr.readAsDataURL($("#change-thumbnail-image-input-field")[0].files[0]);
}

function changeMainImage(imgUid) {
    var toReturn = true;
    if (cntrlIsPressed) {
        $("#cms-modal").find(".modal-title").html("Promijeniti sliku");
        $("#cms-modal").find(".modal-body").html(formElementMainImage("'" + imgUid + "'"));
        //$("#cms-modal").find("#type").attr("value", imgUid);
        //$("#cms-modal").find("#subtype").attr("value", subtype);
        $("#cms-modal").modal("show");
        toReturn = false;
    }
    cntrlIsPressed = false;
    return toReturn;
}

function formElementThumbnail(imgUid) {
    return '<form autocomplete="off" onsubmit="onSubmitThumbnail(event,' +
        imgUid +
        ')">\n' +
        '    <fieldset class="form-group">\n' +
        '        <input type="file" class="form-control-file" ' +
        ' id="change-thumbnail-image-input-field">' +
        '    </fieldset> <!-- form-group -->\n' +
        '    <fieldset class="form-group">\n' +
        '        <input type="text" class="form-control-file" ' +
        ' id="change-thumbnail-text-input-field">' +
        '    </fieldset> <!-- form-group -->\n' +
        '        <button type="submit" id="submit" class="btn btn-primary pull-right">Zapamti promjene</button>' +
        '</form>';
}
function onSubmitThumbnail(event, imgUid) {
    event.preventDefault();
    if ($("#change-thumbnail-image-input-field")[0].files.length > 0) {
        var fr = new FileReader();
        fr.onload = function () {
            var s = $("#" + imgUid);
            $("#" + imgUid).attr("src", fr.result);
        }
        $("#cms-modal").modal("hide");
    }
    fr.readAsDataURL($("#change-thumbnail-image-input-field")[0].files[0]);
    var value = $("#change-thumbnail-text-input-field")[0].value;
    if (value) {
        $("#" + imgUid).siblings(".card-footer").find("p").html(value);
        $("#" + imgUid + "-text-input").attr("value", value);
    }
}

function changeThumbnail(imgUid) {
    var toReturn = true;
    if (cntrlIsPressed) {
        $("#cms-modal").find(".modal-title").html("Promijeniti sliku");
        $("#cms-modal").find(".modal-body").html(formElementThumbnail("'" + imgUid + "'"));
        //$("#cms-modal").find("#type").attr("value", imgUid);
        //$("#cms-modal").find("#subtype").attr("value", subtype);
        $("#cms-modal").modal("show");
        toReturn = false;
    }
    cntrlIsPressed = false;
    return toReturn;
}

function isMainImageUploaded(event) {
    var s = $("#main-image-file-input");
    if ($("#main-image-file-input").val()) {
        if ($("#alert-no-main-image").length > 0) {
            $("#alert-no-main-image").remove();
        }
        return true;
    } else {
        if ($("#alert-no-main-image").length < 1) {
            var alert = $("<div>");
            alert.attr("class", "alert alert-danger").attr("role", "alert").attr("id", "alert-no-main-image");
            alert.html("Molimo dodati glavnu sliku");
            alert.insertBefore($("form"));
        }
        event.preventDefault();
        return false;
    }
}