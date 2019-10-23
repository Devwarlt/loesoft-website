/***
 * @deprecated Use showOverlay | hideOverlay instead.
 * @param target
 */
function toggleOverlay(target) {
    var overlay = document.getElementById(target);
    var display = overlay.style.display;
    overlay.style.display = display === "none" ? "flex" : "none";
}

/***
 * Show element by tag id.
 * @param target
 */
function showOverlay(target) {
    document.getElementById(target).style.display = "flex";
}

/***
 * Hide element by tag id.
 * @param target
 */
function hideOverlay(target) {
    document.getElementById(target).style.display = "none";
}