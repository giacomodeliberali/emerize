function setCookie(cname, cvalue, expire_minutes) {
    var d = new Date();
    d.setTime(d.getTime() + (expire_minutes*1000*60));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function deleteCookie(cname) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;'; // data passata, cookie scaduto
}
