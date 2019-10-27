function sendLogoutPacket() {
    var btn = $("#logout-btn");
    var target = "logout";

    btn.attr("disabled", true);

    if (!isLoggedIn())
        onSendPacketError(btn, target, packetsError.userIsNotLoggedIn);
    else {
        hideOverlay(target);
        showOverlay("result-content");
        wipeLoginCredentials();
        onSendPacketSuccess("/", delays.logoutMs, packetsSuccess.performLogOut);
    }
}