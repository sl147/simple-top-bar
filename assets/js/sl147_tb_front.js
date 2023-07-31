$(document).ready(function (){
function setPopUpCookie() {
    //Cookies.set("sl147_tb", "'.$val[$this->tb_text_option].'")
    Cookies.set("sl147_tb", "sl147_tb")
    console.log("sl147_tb")
    return true;
}
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

jQuery(".sl147_notice_dismiss").click(function() {
    jQuery(".sl147_tb_notice").remove();
    setPopUpCookie();
})
})(jQuery);