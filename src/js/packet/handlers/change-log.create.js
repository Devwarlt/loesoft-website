function sendCreateChangeLogPacket() {
    var btn = $("#publish-btn");
    var credentials = getLoginCredentials();
    var version = $("#change-log-version").val();
    var type = $("#change-log-type option:selected")[0].getAttribute("value");
    var content = $("#change-log-content").val();
    var target = "change-log-create-gui";

    if (!isLoggedIn()) {
        onSendPacketError(btn, target, packetsError.userIsNotLoggedIn);
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
            action: changeLogActions.publish,
            username: credentials.username,
            password: credentials.password,
            version: version,
            type: type,
            content: content
        },
        success: function () {
            onSendPacketSuccess("/", delays.changeLogMs, packetsSuccess.publishChangeLog);
        },
        error: function () {
            onSendPacketError(btn, target, packetsError.invalidChangeLogResponse);
        },
        internalError: function (data) {
            onSendPacketInternalError(btn, target, data);
        }
    });
}