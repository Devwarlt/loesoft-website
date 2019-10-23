const trueString = "true";
const falseString = "false";
const trueBinaryString = "1";
const falseBinaryString = "0";

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