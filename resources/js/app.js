import "./bootstrap";

function cetakStruk(url) {
    const showprint = window.open(url, "_blank", "width=650, height=800");
    showprint.addEventListener("load", function () {
        showprint.print();
        showprint.addEventListener("afterprint", function () {
            showprint.close();
        });
    });
    return false;
}

window.cetakStruk = cetakStruk;
