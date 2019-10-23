const loginUsernameCookie = "login-username-cookie";
const loginPasswordCookie = "login-password-cookie";
const loginDelayMs = secondMs * 5;
const logoutDelayMs = secondMs * 3;

function sendLoginPacket() {
    var btn = $("#login-btn");
    var username = $("#username").val();
    var password = $("#password").val();

    if (isNullOrEmpty(username)) {
        onLoginInternalError(btn, "<strong>Username</strong> couldn't be empty!");
        return;
    }

    if (isNullOrEmpty(password)) {
        onLoginInternalError(btn, "<strong>Password</strong> couldn't be empty!");
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

            if (!booleanObject.valid)
                onLoginError(btn, "An error occurred while processing your request! Try again later...<hr />" + data);
            else {
                if (booleanObject.value) onLoginSuccess();
                else onLoginError(btn, "<strong>Account</strong> doesn't exist!<hr />" + data);
            }
        }
    });
}

function sendLogoutPacket() {
    var btn = $("#logout-btn");
    var cookies = {
        username: Cookies.get(loginUsernameCookie),
        password: Cookies.get(loginPasswordCookie)
    };

    btn.attr("disabled", true);

    if (isNullOrEmpty(cookies.username) && isNullOrEmpty(cookies.password))
        onLogoutInternalError(btn, "You aren't logged in to perform a logout!<hr />");
    else {
        Cookies.remove(loginUsernameCookie);
        Cookies.remove(loginPasswordCookie);

        onLogoutSuccess();
    }
}

function toggleResult(target) {
    hideOverlay("result-content");
    showOverlay(target);
}

function onLoginSuccess() {
    $("#result").html(
        "<div class='text-center'><img src='../../../media/loading.gif' width='48px' height='48px'><h2>Loading, please wait...</h2><br /></div>" +
        "You have successfully performed a login of your account, please wait while you are being redirected to main page...<hr />"
    );

    window.setTimeout(function () {
        window.location.replace("/");
    }, loginDelayMs);
}

function onLoginInternalError(btn, message) {
    hideOverlay("login");
    showOverlay("result-content");

    onLoginError(btn, message);
}

function onLoginError(btn, message) {
    btn.removeAttr("disabled");

    $("#result").html(
        message +
        "<div class='relative-center'>" +
        "<div style='width: 50%; margin: 5%;'>" +
        "<button style='padding: 2%; width: 100%;' type='button' onclick='toggleResult(\"login\")'>Back</button>" +
        "</div>" +
        "</div>"
    );
}

function onLogoutSuccess() {
    hideOverlay("logout");
    showOverlay("result-content");

    $("#result").html(
        "<div class='text-center'><img src='../../../media/loading.gif' width='48px' height='48px'><h2>Loading, please wait...</h2><br /></div>" +
        "You have successfully performed a logout of your account, please wait while you are being redirected to main page...<hr />"
    );

    window.setTimeout(function () {
        window.location.replace("/");
    }, logoutDelayMs);
}

function onLogoutInternalError(btn, message) {
    hideOverlay("logout");
    showOverlay("result-content");

    btn.removeAttr("disabled");

    $("#result").html(
        message +
        "<div class='relative-center'>" +
        "<div style='width: 50%; margin: 5%;'>" +
        "<button style='padding: 2%; width: 100%;' type='button' onclick='toggleResult(\"logout\")'>Back</button>" +
        "</div>" +
        "</div>"
    );
}