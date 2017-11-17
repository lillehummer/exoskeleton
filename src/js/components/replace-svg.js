'use strict'

import $ from 'jquery'

const init = () => {
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("button").addEventListener("click", function() {
            ["object", "iframe", "embed", "img"].forEach(function(elmtType) {
                var e, threeElmts = document.querySelectorAll(elmtType);
                e = threeElmts[0];
                if (e.contentDocument) e.parentElement.replaceChild(e.contentDocument.documentElement.cloneNode(true), e);
                e = threeElmts[1];
                if (e.getSVGDocument) e.parentElement.replaceChild(e.getSVGDocument().documentElement.cloneNode(true), e);
                e = threeElmts[2];
                var xhr = new XMLHttpRequest();
                xhr.open("GET", e.getAttribute(e.nodeName === "OBJECT" ? "data" : "src"));
                xhr.send();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) e.outerHTML = xhr.responseText;
                };
            });
        });
    });
}

export default {
    init
}
