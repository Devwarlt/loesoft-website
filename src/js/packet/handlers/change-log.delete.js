function openDeleteChangeLogGUI(ids) {
    showOverlay("change-log-delete-gui");
    overrideDeleteChangeLogGUI({
        id: ids.id
    });
}

function overrideDeleteChangeLogGUI(ids) {
    overrideElementValById("change-log-id-delete", ids.id);

}

function sendDeleteChangeLogPacket() {
    var btn = $("#edit-btn");
    var credentials = getLoginCredentials();
    var id = $("#change-log-id-delete").val();
    var target = "change-log-delete-gui";

    if (!isLoggedIn()) {
        onSendPacketError(btn, target, packetsError.userIsNotLoggedIn);
        return;
    }

    if (isNullOrEmpty(id)) {
        onSendPacketError(btn, target, packetsError.idIsEmpty);
        return;
    }

    sendChangeLogPacket({
        target: target,
        btn: btn,
        data: {
            action: changeLogActions.delete,
            username: credentials.username,
            password: credentials.password,
            id: id
        },
        success: function () {
            onSendPacketSuccess("/", delays.changeLogMs, packetsSuccess.deleteChangeLog);
        },
        error: function () {
            onSendPacketError(btn, target, packetsError.invalidChangeLogResponse);
        },
        internalError: function (data) {
            onSendPacketInternalError(btn, target, data);
        }
    });
}