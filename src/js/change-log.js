function sendCreateChangeLogPacket() {
    var btn = $("#publish-btn");
    var credentials = getLoginCredentials();
    var version = $("#change-log-version");
    var type = $("#change-log-type");
    var content = $("#change-log-content");

    bt.attr("disabled", true);

    if (!isLoggedIn())
        onChangeLogInternalError(btn, "You aren't logged in to perform this action!<hr/>");
}

function onChangeLogInternalError(btn, message) {
    hideOverlay("change-log-create-gui");
    showOverlay("result-content");

    btn.removeAttr("disabled");

    $("#result").html(
        message +
        "<div class='relative-center'>" +
        "<div style='width: 50%; margin: 5%;'>" +
        "<button style='padding: 2%; width: 100%;' type='button' onclick='toggleResult(\"change-log-create-gui\")'>Back</button>" +
        "</div>" +
        "</div>"
    );
}