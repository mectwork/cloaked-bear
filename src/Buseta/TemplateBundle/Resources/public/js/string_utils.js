String.format = function() {
    var s = arguments[0];
    for (var i = 0; i < arguments.length - 1; i++) {
        var reg = new RegExp("\\{" + i + "\\}", "gm");
        s = s.replace(reg, arguments[i + 1]);
    }

    return s;
};

String.camelize = function () {
    var s = arguments[0];
    return s.replace(/-+(.)?/g, function(match, chr) {
        return chr ? chr.toUpperCase() : '';
    });
};

String.capitalize = function () {
    var s = arguments[0];
    return s.charAt(0).toUpperCase() + s.substring(1).toLowerCase();
};
