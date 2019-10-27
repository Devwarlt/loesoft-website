/**
 * @params's format:
 *
 * data: object
 * btn: button
 * internalError: function(string)
 * error: function(void)
 * @param params
 */
function sendChangeLogPacket(params) {
    sendPacketAsync({
        id: packetsId.changelog,
        data: params.data,
        preHandler: function () {
            params.btn.attr("disabled", true);
        },
        handler: function (data) {
            hideOverlay(params.target);
            showOverlay("result-content");

            var booleanObject = stringToBooleanObject(data);

            if (!booleanObject.valid) params.internalError(data);
            else {
                if (booleanObject.value) params.success();
                else params.error();
            }
        }
    });
}