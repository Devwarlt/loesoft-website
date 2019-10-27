function openEditChangeLogGUI(ids) {
    showOverlay("change-log-edit-gui");
    overrideEditChangeLogGUI({
        id: ids.id,
        version: ids.version,
        type: ids.type,
        content: ids.content
    });
}

function overrideEditChangeLogGUI(ids) {
    overrideElementValById("change-log-id-edit", ids.id);
    overrideElementValById("change-log-version-edit", ids.version);
    overrideElementValById("change-log-type-edit", ids.type);
    overrideElementValById("change-log-content-edit", ids.content);

}

function sendEditChangeLogPacket() {
    var btn = $("#edit-btn");
    var credentials = getLoginCredentials();
    var id = $("#change-log-id-edit").val();
    var version = $("#change-log-version-edit").val();
    var type = $("#change-log-type-edit option:selected")[0].getAttribute("value");
    var content = $("#change-log-content-edit").val();
    var target = "change-log-edit-gui";

    if (!isLoggedIn()) {
        onSendPacketError(btn, target, packetsError.userIsNotLoggedIn);
        return;
    }

    if (isNullOrEmpty(id)) {
        onSendPacketError(btn, target, packetsError.idIsEmpty);
        return;
    }

    if (isNullOrEmpty(version)) {
        onSendPacketError(btn, target, packetsError.versionIsEmpty);
        return;
    }

    if (isNullOrEmpty(type)) {
        onSendPacketError(btn, target, packetsError.typeIsEmpty);
        return;
    }

    if (isNullOrEmpty(content)) {
        onSendPacketError(btn, target, packetsError.contentIsEmpty);
        return;
    }

    sendChangeLogPacket({
        target: target,
        btn: btn,
        data: {
            action: changeLogActions.edit,
            username: credentials.username,
            password: credentials.password,
            id: id,
            version: version,
            type: type,
            content: content
        },
        success: function () {
            onSendPacketSuccess("/change-log", delays.changeLogMs, packetsSuccess.editChangeLog);
        },
        error: function () {
            onSendPacketError(btn, target, packetsError.invalidChangeLogResponse);
        },
        internalError: function (data) {
            onSendPacketInternalError(btn, target, data);
        }
    });
}