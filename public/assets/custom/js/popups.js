function createPopup(pageURL, pageTitle, popupWinWidth, popupWinHeight) {
    var left = (screen.width - popupWinWidth) / 2;
    var top = (screen.height - popupWinHeight) / 4;
    var popname = window.open(pageURL, pageTitle,
        'resizable=yes, width=' + popupWinWidth
        + ', height=' + popupWinHeight + ', top='
        + top + ', left=' + left);
    popname.window.focus()
}