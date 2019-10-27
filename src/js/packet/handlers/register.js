function sendRegisterPacket() {
    var btn = $("#register-btn");
    var username = $("#registration-username").val();
    var password = $("#registration-password").val();
    var passwordRepeat = $("#registration-password-repeat").val();
    var target = "register";

    if (isNullOrEmpty(username)) {
        onSendPacketError(btn, target, packetsError.usernameIsEmpty);
        return;
    }

    if (isNullOrEmpty(password)) {
        onSendPacketError(btn, target, packetsError.passwordIsEmpty);
        return;
    }

    if (isNullOrEmpty(passwordRepeat)) {
        onSendPacketError(btn, target, packetsError.passwordRepeatIsEmpty);
        return;
    }

    if (password !== passwordRepeat) {
        onSendPacketError(btn, target, packetsError.passwordNotMatch);
        return;
    }

    sendPacketAsync({
        id: packetsId.register,
        data: {
            username: username,
            password: password
        },
        preHandler: function () {
            btn.attr("disabled", true);
        },
        handler: function (data) {
            hideOverlay(target);
            showOverlay("result-content");

            var booleanObject = stringToBooleanObject(data);

            if (!booleanObject.valid) onSendPacketInternalError(btn, target, data);
            else {
                if (booleanObject.value) onSendPacketSuccess("/", delays.registerMs, packetsSuccess.performRegistration);
                else onSendPacketError(btn, target, packetsError.duplicatedUsername);
            }
        }
    });
}