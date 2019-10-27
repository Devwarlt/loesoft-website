function sendLoginPacket() {
    var btn = $("#login-btn");
    var username = $("#username").val();
    var password = $("#password").val();
    var target = "login";

    if (isNullOrEmpty(username)) {
        onSendPacketError(btn, target, packetsError.usernameIsEmpty);
        return;
    }

    if (isNullOrEmpty(password)) {
        onSendPacketError(btn, target, packetsError.passwordIsEmpty);
        return;
    }

    sendPacketAsync({
        id: packetsId.login,
        data: {
            username: username,
            password: password
        },
        preHandler: function () {
            btn.attr("disabled", true);
        },
        handler: function (data) {
            hideOverlay("login");
            showOverlay("result-content");

            var booleanObject = stringToBooleanObject(data);

            if (!booleanObject.valid) onSendPacketInternalError(btn, target, data);
            else {
                if (booleanObject.value) onSendPacketSuccess("/", delays.loginMs, packetsSuccess.performLogIn);
                else onSendPacketError(btn, target, packetsError.accountNotFound);
            }
        }
    });
}