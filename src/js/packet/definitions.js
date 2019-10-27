const packetsDir = "../php/packet/handler";
const packetsId = {
    login: 1,
    register: 2,
    changelog: 3
};
const packetsError = {
    usernameIsEmpty: "<strong>Username</strong> couldn't be empty!",
    passwordIsEmpty: "<strong>Password</strong> couldn't be empty!",
    versionIsEmpty: "<strong>Version</strong> couldn't be empty!",
    typeIsEmpty: "<strong>Type</strong> couldn't be empty!",
    contentIsEmpty: "<strong>Content</strong> couldn't be empty!",
    accountNotFound: "<strong>Account</strong> not found!",
    invalidPacketResponse: "An error occurred while processing your request! Try again later...",
    invalidChangeLogResponse: "Couldn't be possible to process your request!",
    userIsNotLoggedIn: "You aren't logged in to perform this action!"
};
const packetsSuccess = {
    publishChangeLog: "You have successfully created a new change log entry, please wait while this page refresh...",
    performLogIn: "You have successfully performed a login of your account, please wait while you are being redirected to main page...",
    performLogOut: "You have successfully performed a logout of your account, please wait while you are being redirected to main page..."
};

/* packets defs */
const loginUsernameCookie = "login-username-cookie";
const loginPasswordCookie = "login-password-cookie";
const loginAccessLevelCookie = "login-access-level-cookie";
const accessLevels = {
    regular: 0,
    moderator: 1,
    admin: 2,
    master: 3
};
const changeLogActions = {
    publish: 1,
    edit: 2,
    delete: 3
};

/**
 * @params's format:
 *
 * id: int
 * data: object
 * preHandler: function(void)
 * handler: function(string)
 * @param params
 */
function sendPacketAsync(params) {
    if (params.preHandler !== null) params.preHandler();

    $("#loading").height("100%");

    var packet = {
        packetId: params.id
    };

    Object.keys(params.data).forEach(function (key) {
        packet[key] = params.data[key];
    });

    window.setTimeout(function () {
        $.post(packetsDir, packet).done(function (data) {
            if (params.handler !== null) params.handler(data);

            $("#loading").height("0%");
        });
    }, delays.packetMs);
}

function onSendPacketError(btn, target, message) {
    hideOverlay(target);
    showOverlay("result-content");

    $("#result").html(
        message +
        "<br /><br /><hr />" +
        "<div class='relative-center'>" +
        "<div style='width: 50%; margin: 5%;'>" +
        "<button style='padding: 2%; width: 100%;' type='button' onclick='toggleResult(\"" + target + "\")'>Back</button>" +
        "</div>" +
        "</div>"
    );
}

function onSendPacketInternalError(btn, target, data) {
    btn.removeAttr("disabled");

    $("#result").html(
        packetsError.invalidPacketResponse +
        "<br /><br /><hr /><br />" +
        (data === null ? "" : data) +
        "<div class='relative-center'>" +
        "<div style='width: 50%; margin: 5%;'>" +
        "<button style='padding: 2%; width: 100%;' type='button' onclick='toggleResult(\"" + target + "\")'>Back</button>" +
        "</div>" +
        "</div>"
    );
}

function onSendPacketSuccess(redirect, delay, message) {
    $("#result").html(
        "<div class='text-center'><img src='../../../media/loading.gif' width='48px' height='48px'/><h2>Loading, please wait...</h2><br /></div>" +
        message +
        "<br /><br /><hr />"
    );

    window.setTimeout(function () {
        window.location.replace(redirect);
    }, delay);
}