const secondMs = 1000;
const packetManagerDir = "../php/handlers/PacketHandler";

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
        $.post(packetManagerDir, packet).done(function (data) {
            if (params.handler !== null) params.handler(data);

            $("#loading").height("0%");
        });
    }, secondMs / 3);
}