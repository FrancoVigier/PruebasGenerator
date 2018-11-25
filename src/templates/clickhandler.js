function onBackClick() {
    const temaIndex = getTemaIndex();

    window.location.href = updateURLParameter(window.location.href, 'temaIndex', (temaIndex-1).toString());
}

function onFowardClick() {
    const temaIndex = getTemaIndex();

    window.location.href = updateURLParameter(window.location.href, 'temaIndex', (temaIndex+1).toString());
}

function onDownloadClick() {
    const keyUrl = window.location.href + "&isDownload=true";
    window.open(keyUrl, '_blank', '');

    const notKeyUrl = updateURLParameter(window.location.href, 'key', "0")  + "&isDownload=true";
    window.open(notKeyUrl, '_blank', '');
}

function getTemaIndex() {
    const urlParams = new URLSearchParams(window.location.search);
    return parseInt(urlParams.get('temaIndex'));
}

/**
 * https://stackoverflow.com/a/10997390/3124150
 */
function updateURLParameter(url, param, paramVal) {
    var TheAnchor = null;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";

    if (additionalURL) {
        var tmpAnchor = additionalURL.split("#");
        var TheParams = tmpAnchor[0];
        TheAnchor = tmpAnchor[1];
        if (TheAnchor)
            additionalURL = TheParams;

        tempArray = additionalURL.split("&");

        for (var i = 0; i < tempArray.length; i++) {
            if (tempArray[i].split('=')[0] != param) {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }
    else {
        var tmpAnchor = baseURL.split("#");
        var TheParams = tmpAnchor[0];
        TheAnchor = tmpAnchor[1];

        if (TheParams)
            baseURL = TheParams;
    }

    if (TheAnchor)
        paramVal += "#" + TheAnchor;

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}