function showOverlay(target) {
    document.getElementById(target).style.display = "flex";
}

function hideOverlay(target) {
    $("#" + target).fadeOut("slow", function () {
        document.getElementById(target).style.display = "none";
    });
}