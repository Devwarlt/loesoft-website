const version = "0.1";
const secondMs = 1000;
const delays = {
    loginMs: secondMs * 3,
    logoutMs: secondMs * 2,
    changeLogMs: secondMs * 2,
    packetMs: secondMs / 4
};
const trueString = "true";
const falseString = "false";
const trueBinaryString = "1";
const falseBinaryString = "0";

function isNullOrEmpty(value) {
    return value === null || value === undefined || value === "";
}

function showOverlay(target) {
    document.getElementById(target).style.display = "flex";
}

function hideOverlay(target) {
    $("#" + target).fadeOut("slow", function () {
        document.getElementById(target).style.display = "none";
    });
}

function isValidBoolean(value) {
    return isValidTrueBoolean(value) || isValidFalseBoolean(value);
}

function isValidTrueBoolean(value) {
    return value === trueString || value === trueBinaryString;
}

function isValidFalseBoolean(value) {
    return value === falseString || value === falseBinaryString;
}

function stringToBooleanObject(value) {
    var booleanObject = {
        valid: false
    };

    if (isValidBoolean(value)) {
        booleanObject.valid = true;

        if (isValidTrueBoolean(value)) booleanObject.value = true;
        if (isValidFalseBoolean(value)) booleanObject.value = false;
    }

    return booleanObject;
}

function isLoggedIn() {
    var credentials = getLoginCredentials();

    return !(isNullOrEmpty(credentials.username) && isNullOrEmpty(credentials.password));
}

function getLoginCredentials() {
    return {
        username: Cookies.get(loginUsernameCookie),
        password: Cookies.get(loginPasswordCookie),
        accessLevel: Cookies.get(loginAccessLevelCookie)
    };
}

function wipeLoginCredentials() {
    Cookies.remove(loginUsernameCookie);
    Cookies.remove(loginPasswordCookie);
    Cookies.remove(loginAccessLevelCookie);
}

function toggleResult(target) {
    hideOverlay("result-content");
    showOverlay(target);
}

function handleRestrictionByAccessLevel() {
    var restrictions = document.getElementsByTagName("restrict");
    var accessLevel = getLoginCredentials().accessLevel;

    if (isNullOrEmpty(accessLevel)) accessLevel = accessLevels.regular;

    for (var i = 0; i < restrictions.length; i++) {
        var requiredLevel = parseInt(restrictions[i].dataset.level);
        if (accessLevel < requiredLevel) restrictions[i].outerHTML = "";
        else restrictions[i].style.display = "contents";
    }
}

function overrideElementValById(targetId, value) {
    $("#" + targetId).val(value);
}

function toJSONFormat(data) {
    var result = "";

    if (data.length === 0) return "{}";

    Object.keys(data).forEach(function (key) {
        result += "['" + key + "']: " + data[key] + "\n";
    });

    return result;
}