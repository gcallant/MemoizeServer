!function t(e, n, r) {
    function o(s, a) {
        if (!n[s]) {
            if (!e[s]) {
                var u = "function" == typeof require && require;
                if (!a && u)
                    return u(s, !0);
                if (i)
                    return i(s, !0);
                var f = new Error("Cannot find module '" + s + "'");
                throw f.code = "MODULE_NOT_FOUND",
                    f
            }
            var h = n[s] = {
                exports: {}
            };
            e[s][0].call(h.exports, function(t) {
                var n = e[s][1][t];
                return o(n ? n : t)
            }, h, h.exports, t, e, n, r)
        }
        return n[s].exports
    }
    for (var i = "function" == typeof require && require, s = 0; s < r.length; s++)
        o(r[s]);
    return o
}({
    1: [function(t) {
        (function(e, n) {
                var r = t("common/vendor/detect-zoom");
                polyfills = t("common/polyfills");
                var o = [].slice
                    , i = function(t, e, n) {
                    return t.addEventListener ? t.addEventListener(e, n, !1) : t.attachEvent("on" + e, n)
                }
                    , s = function(t) {
                    var e;
                    return e = document.createElement("a"),
                        e.href = t,
                    "" + e.protocol + "//" + e.hostname
                }
                    , a = function(t, e) {
                    return t.parentNode.insertBefore(e, t)
                }
                    , u = function() {
                    function t(t) {
                        if (this.options = t || {},
                            this.overlayData = {},
                            this.message = this.message.bind(this),
                            this.invoke = this.invoke.bind(this),
                            this.invokeButton = this.invokeButton.bind(this),
                            this.invokeOverlay = this.invokeOverlay.bind(this),
                            this.popupOpen = this.popupOpen.bind(this),
                            this.handleInitiatedPayment = this.handleInitiatedPayment.bind(this),
                            this.overlayOpen = this.overlayOpen.bind(this),
                            this.overlayClose = this.overlayClose.bind(this),
                            this.login = this.login.bind(this),
                            this.info = this.info.bind(this),
                            this.pay = this.pay.bind(this),
                        void 0 !== (el = this.options.el) && !el.hasAttribute(this.initializedAttribute)) {
                            el.setAttribute(this.initializedAttribute, !0),
                                this.options.appID = el.getAttribute("data-app-id"),
                                this.options.redirectURL = e(el.getAttribute("data-redirect-url")),
                                this.options.buttonColor = el.getAttribute("data-color"),
                                this.options.buttonStyle = el.getAttribute("data-style"),
                                this.options.buttonType = el.getAttribute("data-type"),
                                this.options.embed = el.getAttribute("data-embed"),
                                this.options.popup = el.getAttribute("data-popup"),
                                this.custom = el.getAttribute("data-custom");
                            for (var n in this.defaults)
                                this.options[n] || (this.options[n] = this.defaults[n]);
                            for (var o = 0; o < el.attributes.length; o++)
                                attr = el.attributes[o],
                                /^data-/.test(attr.nodeName) && (this.overlayData[attr.nodeName.replace(/^data-/, "").split("-").join("_")] = attr.value || attr.nodeValue);
                            this.overlayData.version = 3,
                                this.overlayData.zoom = r.zoom(),
                                this.overlayIsOpen = !1,
                                i(window, "message", this.message)
                        }
                    }
                    function e(t) {
                        return !t || t.match(/:\/\//) ? t : (t.match(/^\//) || (t = "/" + t),
                        window.location.protocol + "://" + window.location.host + t)
                    }
                    function n(t, e, n) {
                        if (replaceDuplicates = !0,
                        t.indexOf("#") > 0) {
                            var r = t.indexOf("#");
                            urlhash = t.substring(t.indexOf("#"), t.length)
                        } else
                            urlhash = "",
                                r = t.length;
                        sourceUrl = t.substring(0, r);
                        var o = sourceUrl.split("?")
                            , i = "";
                        if (o.length > 1)
                            for (var s = o[1].split("&"), a = 0; a < s.length; a++) {
                                var u = s[a].split("=");
                                replaceDuplicates && u[0] == e || ("" == i ? i = "?" : i += "&",
                                    i += u[0] + "=" + u[1])
                            }
                        return "" == i ? i = "?" : i += "&",
                            i += e + "=" + n,
                        o[0] + i + urlhash
                    }
                    return t.prototype.iframeCSS = "background:transparent;\nborder:0 none transparent;\noverflow:hidden;\ndisplay:block;\nvisibility:visible;\nmargin:0;\npadding:0;",
                        t.prototype.wrapperCSS = "width:220px;\nheight:40px;\ndisplay:block;\nmargin:0;\npadding:0;\nborder:0;\noverflow:visible;",
                        t.prototype.buttonCSS = "height:40px;\nwidth:220px;\nmargin:0;\npadding:0;",
                        t.prototype.overlayCSS = "position:fixed;\nleft:0;\ntop:0;\nwidth:100%;\nheight:100%;\nz-index:9999;\ndisplay:none;",
                        t.prototype.specialCSS = "width:160px;\nheight:160px;\ncursor:pointer;",
                        t.prototype.wrapperClass = "clef-button-wrapper",
                        t.prototype.buttonClass = "clef-button-frame",
                        t.prototype.overlayClass = "clef-overlay-frame",
                        t.prototype.embedWrapperClass = "clef-embed-wrapper",
                        t.prototype.embedClass = "clef-embed",
                        t.prototype.initializedAttribute = "data-button-initialized",
                        t.prototype.id = 0,
                        t.prototype.callbacks = {},
                        t.prototype.defaults = {
                            buttonPath: "/iframes/button",
                            buttonColor: "blue",
                            buttonStyle: "flat",
                            buttonType: "login",
                            embed: !1,
                            overlayPath: "/iframes/qr",
                            host: "localhost",
                            infoURL: "localhost",
                            specialIMG: "localhost/images/logo.svg",
                            pay: !1
                        },
                        t.initialize = function(e) {
                            var n = e.el;
                            if (n && !n.hasAttribute(this.prototype.initializedAttribute)) {
                                var r = new t(e);
                                return r.render(),
                                    r
                            }
                        }
                        ,
                        t.prototype.message = function(t) {
                            var e, n, r, i, a;
                            if (s(t.origin) === s(this.options.host) && (a = !1,
                                e = t.source,
                            e && (this.overlayFrame && (a = a || e == this.overlayFrame.contentWindow),
                                a = a || this.buttonFrame && e == this.buttonFrame.contentWindow,
                                a = a || e == this.popup,
                            a && (n = t.data))))
                                return n = polyfills.parsePostMessageData(n),
                                    i = "function" == typeof this[r = n.method] ? this[r].apply(this, o.call(n.args)) : void 0,
                                    "callback" !== n.method ? this.invoke(t.source, "callback", n.id, i) : void 0
                        }
                        ,
                        t.prototype.callback = function(t, e) {
                            var n;
                            return "function" == typeof (n = this.callbacks)[t] && n[t](e),
                                delete this.callbacks[t]
                        }
                        ,
                        t.prototype.invoke = function() {
                            var t, e, n, r;
                            return e = arguments[0],
                                r = arguments[1],
                                t = 3 <= arguments.length ? o.call(arguments, 2) : [],
                                n = ++this.id,
                            "function" == typeof t[t.length - 1] && (this.callbacks[n] = t.pop()),
                                e ? polyfills.postMessage(e, {
                                    method: r,
                                    args: t,
                                    id: n
                                }, this.options.host) : void 0
                        }
                        ,
                        t.prototype.invokeButton = function() {
                            var t, e;
                            return e = arguments[0],
                                t = 2 <= arguments.length ? o.call(arguments, 1) : [],
                                this.invoke.apply(this, [this.buttonFrame.contentWindow, e].concat(o.call(t)))
                        }
                        ,
                        t.prototype.invokeOverlay = function() {
                            var t, e;
                            return e = arguments[0],
                                t = 2 <= arguments.length ? o.call(arguments, 1) : [],
                                this.invoke.apply(this, [this.overlayFrame.contentWindow, e].concat(o.call(t)))
                        }
                        ,
                        t.prototype.render = function() {
                            if (this.custom)
                                return this.attachButtonHandlers();
                            if (this.el = document.createElement("div"),
                                this.options.embed)
                                this.el.className = this.embedWrapperClass,
                                    this.el.style.cssText = "height:500px;\ndisplay:block;\nmargin:0;\npadding:0;\nborder:0;\noverflow:visible;",
                                    this.el.style.cssText += window.matchMedia && window.matchMedia("max-width:400px") ? "width:100%;" : "width:400px",
                                    this.overlayFrame = this.renderFrame(this.overlayURL({
                                        iframe: !0
                                    })),
                                    this.overlayFrame.style.cssText += "\nwidth:100%;\nheight:100%;",
                                    this.el.appendChild(this.overlayFrame);
                            else {
                                this.el.className = this.wrapperClass,
                                    this.el.style.cssText = this.wrapperCSS;
                                var t = [];
                                t.push("color=" + this.options.buttonColor),
                                    t.push("style=" + this.options.buttonStyle),
                                    t.push("type=" + this.options.buttonType),
                                    t.push("appID=" + this.options.appID),
                                    this.buttonFrame = this.renderFrame(this.options.buttonPath + "?" + t.join("&")),
                                    this.buttonFrame.style.cssText += this.buttonCSS,
                                    this.el.appendChild(this.buttonFrame)
                            }
                            return void 0 !== (el = this.options.el) ? (this.body = null !== el.ownerDocument ? el.ownerDocument.body : this.el,
                                a(el, this.el)) : void 0
                        }
                        ,
                        t.prototype.attachButtonHandlers = function() {
                            var t = this;
                            this.body = this.options.el.ownerDocument.body,
                                i(this.options.el, "click", function(e) {
                                    e.preventDefault(),
                                        t.overlayOpen()
                                })
                        }
                        ,
                        t.prototype.renderFrame = function(t) {
                            var e;
                            return e = document.createElement("iframe"),
                                e.setAttribute("frameBorder", "0"),
                                e.setAttribute("allowtransparency", "true"),
                                i(e, "load", function() {
                                    e.style.visibility = "visible"
                                }),
                                e.style.cssText = this.iframeCSS,
                            t.match("http") || (t = this.options.host + t),
                                e.src = t,
                                e.onload = function() {
                                    e.setAttribute("data-loaded", !0)
                                }
                                ,
                                e
                        }
                        ,
                        t.prototype.handleInitiatedPayment = function(t) {
                            var e = t[0]
                                , n = t[1];
                            e.success && n && (this.paymentRequestID = e.payment_id,
                                this.invokeOverlay("handleInitiatedPayment", this.paymentRequestID))
                        }
                        ,
                        t.prototype.overlayOpen = function() {
                            if (this.options.popup)
                                window.open(this.overlayURL(), "clef", "height=700,width=800,menubar=no,status=no,top=50px,left=50px");
                            else if (!this.overlayIsOpen) {
                                var t = this;
                                this.overlayIsOpen = !0,
                                    t.overlayFrame = t.renderFrame(this.overlayURL({
                                        iframe: !0
                                    })),
                                    t.overlayFrame.style.cssText += t.overlayCSS,
                                    t.overlayFrame.className = t.overlayClass,
                                    t.body.appendChild(t.overlayFrame),
                                    i(t.overlayFrame, "load", function() {
                                        t.overlayFrame.style.display = "block",
                                            t.invokeOverlay("overlayOpen"),
                                        t.custom || t.invokeButton("overlayLoaded")
                                    })
                            }
                        }
                        ,
                        t.prototype.overlayClose = function() {
                            this.overlayIsOpen = !1,
                                this.body.removeChild(this.overlayFrame)
                        }
                        ,
                        t.prototype.popupOpen = function() {
                            this.body.removeChild(this.overlayFrame),
                                window.location = this.overlayURL()
                        }
                        ,
                        t.prototype.login = function(t) {
                            window.location = n(t.redirectURL, "code", t.code)
                        }
                        ,
                        t.prototype.pay = function(t) {
                            var e = n(t.redirectURL, "payment_id", t.token);
                            window.location = e
                        }
                        ,
                        t.prototype.redirect = function(t) {
                            return window.location = t.url,
                                !0
                        }
                        ,
                        t.prototype.info = function() {
                            window.location = this.options.infoURL
                        }
                        ,
                        t.prototype.overlayURL = function(t) {
                            var e = [];
                            for (var n in this.overlayData)
                                e.push(encodeURIComponent(n) + "=" + encodeURIComponent(this.overlayData[n]));
                            for (var n in t)
                                e.push(encodeURIComponent(n) + "=" + encodeURIComponent(t[n]));
                            return this.options.pay && e.push("pay=true"),
                            this.options.embed && e.push("embed=true"),
                            this.options.host + this.options.overlayPath + "?" + e.join("&")
                        }
                        ,
                        t
                }();
                !function() {
                    var t, e, n, r = [], o = [];
                    for (logins = document.querySelectorAll(".clef-button"),
                             n = document.querySelectorAll(".clef-pay"),
                             t = 0; t < logins.length; t++)
                        e = new u({
                            el: logins[t]
                        }),
                            r.push(e),
                            e.render();
                    for (t = 0; t < n.length; t++)
                        pay_button = new u({
                            el: n[t],
                            pay: !0
                        }),
                            o.push(pay_button),
                            pay_button.render()
                }(),
                    n.ClefButton = u
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/basic/static/src/coffee/v3/clef.js", "/basic/static/src/coffee/v3")
    }
        , {
            _process: 9,
            buffer: 6,
            "common/polyfills": 3,
            "common/vendor/detect-zoom": 4
        }],
    2: [function(t, e, n) {
        (function() {
                var e, r, o, i, s, a, u, f, h, l, c, d, p, m;
                s = t("common/vendor/detect-zoom"),
                    e = null,
                    h = function() {
                        return !!a()
                    }
                    ,
                    a = function() {
                        var t, n, r;
                        if (e)
                            return e;
                        for (r = 3,
                                 n = document.createElement("div"),
                                 t = n.getElementsByTagName("i"); ; )
                            if (n.innerHTML = "<!--[if gt IE " + ++r + "]><i></i><![endif]-->",
                                !t[0])
                                break;
                        return e = r > 4 ? r : null
                    }
                    ,
                    d = function() {
                        var t, e;
                        return e = null != (t = navigator.userAgent) ? t.toLowerCase() : void 0,
                        -1 !== (null != e ? e.indexOf("safari") : void 0) && -1 === e.indexOf("chrome")
                    }
                    ,
                    c = function() {
                        var t, e;
                        return e = null != (t = navigator.userAgent) ? t.toLowerCase() : void 0,
                        -1 !== (null != e ? e.indexOf("crios") : void 0)
                    }
                    ,
                    p = function() {
                        return navigator.userAgent.match(/iPhone/i)
                    }
                    ,
                    f = function() {
                        return navigator.userAgent.match(/(?=.*Android)(?=.*mobile)/i)
                    }
                    ,
                    l = function() {
                        return p() || f()
                    }
                    ,
                    o = function() {
                        return top !== self
                    }
                    ,
                    r = function() {
                        var t, e;
                        return e = {},
                            t = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(t, n, r) {
                                return e[n] = decodeURIComponent(r)
                            }),
                            e
                    }
                    ,
                    u = function() {
                        var t;
                        return t = top !== self ? parseFloat(r().zoom) : s.zoom(),
                            t && !isNaN(t) && isFinite(t) && 0 !== t ? t : 1
                    }
                    ,
                    m = function() {
                        var t, e;
                        return e = "testCookies" + Math.random().toString().slice(3),
                            t = e + "=;expires=Thu, 01 Jan 2050 00:00:01 GMT;",
                            document.cookie = t,
                            -1 === document.cookie.indexOf(e) ? !1 : (document.cookie = e + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;",
                                !0)
                    }
                    ,
                    i = function(t) {
                        var e, n, r, o;
                        return r = function() {
                            var t;
                            r = !1;
                            try {
                                r = Boolean(localStorage.getItem("hasApp"))
                            } catch (e) {
                                t = e
                            }
                            return r
                        }
                            ,
                            o = function() {
                                var t;
                                try {
                                    return localStorage.setItem("hasApp", !0)
                                } catch (e) {
                                    t = e
                                }
                            }
                            ,
                            n = function() {
                                return f() ? "https://play.google.com/store/apps/details?id=io.clef" : "itms-apps://itunes.apple.com/us/app/clef/id558706348"
                            }
                            ,
                            r() ? t() : (e = confirm(cts.embed.mobile.confirm),
                                e ? (o(),
                                    t()) : window.open(n()))
                    }
                    ,
                    n.isiPhone = p,
                    n.isAndroid = f,
                    n.isMobile = l,
                    n.isMobileChrome = c,
                    n.getZoom = u,
                    n.getIEVersion = a,
                    n.isIE = h,
                    n.isSafari = d,
                    n.thirdPartyCookiesAllowed = m,
                    n.checkForApp = i
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/common/static/coffee/device.coffee", "/common/static/coffee")
    }
        , {
            _process: 9,
            buffer: 6,
            "common/vendor/detect-zoom": 4
        }],
    3: [function(t, e, n) {
        (function() {
                var e, r, o, i, s, a;
                if (e = t("common/device"),
                    n.postMessage = function(t, n, r) {
                        return e.isIE() && e.getIEVersion() <= 9 && (9 === e.getIEVersion() || 8 === e.getIEVersion() ? "object" == typeof n && (n = JSON.stringify(n)) : console.log("postMessage is not supported in this browser")),
                            t.postMessage(n, r)
                    }
                    ,
                    n.parsePostMessageData = function(t) {
                        var e;
                        if ("string" == typeof t)
                            try {
                                t = JSON.parse(t)
                            } catch (n) {
                                e = n
                            }
                        return t
                    }
                    ,
                    n.addEventListener = function(t, e, n) {
                        return t.addEventListener ? t.addEventListener(e, n) : t.attachEvent("on" + e, function() {
                            return n.call(t)
                        })
                    }
                    ,
                    n.addClass = function(t, e) {
                        return t.classList ? t.classList.add(e) : t.className += " " + e
                    }
                    ,
                    n.removeClass = function(t, e) {
                        return t.classList ? t.classList.remove(e) : t.className = t.className.replace(new RegExp("(^|\\b)" + e.split(" ").join("|") + "(\\b|$)","gi"), " ")
                    }
                    ,
                    !window.requestAnimationFrame) {
                    for (a = ["webkit", "moz"],
                             r = 0,
                             i = a.length; i > r; r++)
                        s = a[r],
                            window.requestAnimationFrame = window[s + "RequestAnimationFrame"],
                            window.cancelAnimationFrame = window[s + "CancelAnimationFrame"] || window[s + "CancelRequestAnimationFrame"];
                    window.requestAnimationFrame || (o = 0,
                            window.requestAnimationFrame = function(t) {
                                var e, n, r;
                                return e = (new Date).getTime(),
                                    r = Math.max(0, 16 - (e - o)),
                                    n = window.setTimeout(function() {
                                        return t(e + r)
                                    }, r),
                                    o = e + r,
                                    n
                            }
                            ,
                            window.cancelAnimationFrame = function(t) {
                                return clearTimeout(t)
                            }
                    )
                }
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/common/static/coffee/polyfills.coffee", "/common/static/coffee")
    }
        , {
            _process: 9,
            buffer: 6,
            "common/device": 2
        }],
    4: [function(t, e) {
        (function(t, n) {
                (function(t, e, n, r, o) {
                        !function(e, n, o) {
                            "use strict";
                            "undefined" != typeof t && t.exports ? t.exports = o(n, e) : "function" == typeof r && r.amd ? r("detect-zoom", function() {
                                return o(n, e)
                            }) : e[n] = o(n, e)
                        }(window, "detectZoom", function() {
                            var t = function() {
                                return window.devicePixelRatio || 1
                            }
                                , e = function() {
                                return {
                                    zoom: 1,
                                    devicePxPerCssPx: 1
                                }
                            }
                                , n = function() {
                                var e = Math.round(screen.deviceXDPI / screen.logicalXDPI * 100) / 100;
                                return {
                                    zoom: e,
                                    devicePxPerCssPx: e * t()
                                }
                            }
                                , r = function() {
                                var e = Math.round(document.documentElement.offsetHeight / window.innerHeight * 100) / 100;
                                return {
                                    zoom: e,
                                    devicePxPerCssPx: e * t()
                                }
                            }
                                , o = function() {
                                var e = Math.round(window.outerWidth / window.innerWidth * 100) / 100;
                                return {
                                    zoom: e,
                                    devicePxPerCssPx: e * t()
                                }
                            }
                                , i = function() {
                                var e = Math.round(window.outerWidth / window.innerWidth * 100) / 100;
                                return {
                                    zoom: e,
                                    devicePxPerCssPx: e * t()
                                }
                            }
                                , s = function() {
                                var e = 90 == Math.abs(window.orientation) ? screen.height : screen.width
                                    , n = e / window.innerWidth;
                                return {
                                    zoom: n,
                                    devicePxPerCssPx: n * t()
                                }
                            }
                                , a = function() {
                                var e = function(t) {
                                    return t.replace(/;/g, " !important;")
                                }
                                    , n = document.createElement("div");
                                n.innerHTML = "1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>0",
                                    n.setAttribute("style", e("font: 100px/1em sans-serif; -webkit-text-size-adjust: none; text-size-adjust: none; height: auto; width: 1em; padding: 0; overflow: visible;"));
                                var r = document.createElement("div");
                                r.setAttribute("style", e("width:0; height:0; overflow:hidden; visibility:hidden; position: absolute;")),
                                    r.appendChild(n),
                                    document.body.appendChild(r);
                                var o = 1e3 / n.clientHeight;
                                return o = Math.round(100 * o) / 100,
                                    document.body.removeChild(r),
                                    {
                                        zoom: o,
                                        devicePxPerCssPx: o * t()
                                    }
                            }
                                , u = function() {
                                try {
                                    var t = l("min--moz-device-pixel-ratio", "", 0, 10, 20, 1e-4);
                                    t = Math.round(100 * t) / 100
                                } catch (e) {
                                    console.log("Error occurred while detecting zoom: " + e),
                                        t = 1
                                }
                                return {
                                    zoom: t,
                                    devicePxPerCssPx: t
                                }
                            }
                                , f = function() {
                                return {
                                    zoom: u().zoom,
                                    devicePxPerCssPx: t()
                                }
                            }
                                , h = function() {
                                var e = window.top.outerWidth / window.top.innerWidth;
                                return e = Math.round(100 * e) / 100,
                                    {
                                        zoom: e,
                                        devicePxPerCssPx: e * t()
                                    }
                            }
                                , l = function(t, e, n, r, o, i) {
                                function s(n, r, o) {
                                    var u = (n + r) / 2;
                                    if (0 >= o || i > r - n)
                                        return u;
                                    var f = "(" + t + ":" + u + e + ")";
                                    return a(f).matches ? s(u, r, o - 1) : s(n, u, o - 1)
                                }
                                var a, u, f, h;
                                window.matchMedia ? a = window.matchMedia : (u = document.getElementsByTagName("head")[0],
                                        f = document.createElement("style"),
                                        u.appendChild(f),
                                        h = document.createElement("div"),
                                        h.className = "mediaQueryBinarySearch",
                                        h.style.display = "none",
                                        document.body.appendChild(h),
                                        a = function(t) {
                                            f.sheet.insertRule("@media " + t + "{.mediaQueryBinarySearch {text-decoration: underline} }", 0);
                                            var e = "underline" == getComputedStyle(h, null).textDecoration;
                                            return f.sheet.deleteRule(0),
                                                {
                                                    matches: e
                                                }
                                        }
                                );
                                var l = s(n, r, o);
                                return h && (u.removeChild(f),
                                    document.body.removeChild(h)),
                                    l
                            }
                                , c = function() {
                                var t = e;
                                return isNaN(screen.logicalXDPI) || isNaN(screen.systemXDPI) ? window.navigator.msMaxTouchPoints ? t = r : window.chrome && !(window.opera || navigator.userAgent.indexOf(" Opera") >= 0) ? t = o : Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor") > 0 ? t = i : "orientation"in window && "webkitRequestAnimationFrame"in window ? t = s : "webkitRequestAnimationFrame"in window ? t = a : navigator.userAgent.indexOf("Opera") >= 0 ? t = h : window.devicePixelRatio ? t = f : u().zoom > .001 && (t = u) : t = n,
                                    t
                            }();
                            return {
                                zoom: function() {
                                    return c().zoom
                                },
                                device: function() {
                                    return c().devicePxPerCssPx
                                }
                            }
                        }),
                            o("undefined" != typeof detectZoom ? detectZoom : window.detectZoom)
                    }
                ).call(n, void 0, void 0, void 0, void 0, function(t) {
                    e.exports = t
                })
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/common/static/coffee/vendor/detect-zoom.js", "/common/static/coffee/vendor")
    }
        , {
            _process: 9,
            buffer: 6
        }],
    5: [function(t, e, n) {
        (function() {
                var t = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
                !function(e) {
                    "use strict";
                    function n(t) {
                        var e = t.charCodeAt(0);
                        return e === s || e === l ? 62 : e === a || e === c ? 63 : u > e ? -1 : u + 10 > e ? e - u + 26 + 26 : h + 26 > e ? e - h : f + 26 > e ? e - f + 26 : void 0
                    }
                    function r(t) {
                        function e(t) {
                            f[l++] = t
                        }
                        var r, o, s, a, u, f;
                        if (t.length % 4 > 0)
                            throw new Error("Invalid string. Length must be a multiple of 4");
                        var h = t.length;
                        u = "=" === t.charAt(h - 2) ? 2 : "=" === t.charAt(h - 1) ? 1 : 0,
                            f = new i(3 * t.length / 4 - u),
                            s = u > 0 ? t.length - 4 : t.length;
                        var l = 0;
                        for (r = 0,
                                 o = 0; s > r; r += 4,
                                 o += 3)
                            a = n(t.charAt(r)) << 18 | n(t.charAt(r + 1)) << 12 | n(t.charAt(r + 2)) << 6 | n(t.charAt(r + 3)),
                                e((16711680 & a) >> 16),
                                e((65280 & a) >> 8),
                                e(255 & a);
                        return 2 === u ? (a = n(t.charAt(r)) << 2 | n(t.charAt(r + 1)) >> 4,
                            e(255 & a)) : 1 === u && (a = n(t.charAt(r)) << 10 | n(t.charAt(r + 1)) << 4 | n(t.charAt(r + 2)) >> 2,
                            e(a >> 8 & 255),
                            e(255 & a)),
                            f
                    }
                    function o(e) {
                        function n(e) {
                            return t.charAt(e)
                        }
                        function r(t) {
                            return n(t >> 18 & 63) + n(t >> 12 & 63) + n(t >> 6 & 63) + n(63 & t)
                        }
                        var o, i, s, a = e.length % 3, u = "";
                        for (o = 0,
                                 s = e.length - a; s > o; o += 3)
                            i = (e[o] << 16) + (e[o + 1] << 8) + e[o + 2],
                                u += r(i);
                        switch (a) {
                            case 1:
                                i = e[e.length - 1],
                                    u += n(i >> 2),
                                    u += n(i << 4 & 63),
                                    u += "==";
                                break;
                            case 2:
                                i = (e[e.length - 2] << 8) + e[e.length - 1],
                                    u += n(i >> 10),
                                    u += n(i >> 4 & 63),
                                    u += n(i << 2 & 63),
                                    u += "="
                        }
                        return u
                    }
                    var i = "undefined" != typeof Uint8Array ? Uint8Array : Array
                        , s = "+".charCodeAt(0)
                        , a = "/".charCodeAt(0)
                        , u = "0".charCodeAt(0)
                        , f = "a".charCodeAt(0)
                        , h = "A".charCodeAt(0)
                        , l = "-".charCodeAt(0)
                        , c = "_".charCodeAt(0);
                    e.toByteArray = r,
                        e.fromByteArray = o
                }("undefined" == typeof n ? this.base64js = {} : n)
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/node_modules/base64-js/lib/b64.js", "/node_modules/base64-js/lib")
    }
        , {
            _process: 9,
            buffer: 6
        }],
    6: [function(t, e, n) {
        (function(e, r, o) {
                "use strict";
                function i() {
                    function t() {}
                    try {
                        var e = new Uint8Array(1);
                        return e.foo = function() {
                            return 42
                        }
                            ,
                            e.constructor = t,
                        42 === e.foo() && e.constructor === t && "function" == typeof e.subarray && 0 === e.subarray(1, 1).byteLength
                    } catch (n) {
                        return !1
                    }
                }
                function s() {
                    return o.TYPED_ARRAY_SUPPORT ? 2147483647 : 1073741823
                }
                function o(t) {
                    return this instanceof o ? (o.TYPED_ARRAY_SUPPORT || (this.length = 0,
                        this.parent = void 0),
                        "number" == typeof t ? a(this, t) : "string" == typeof t ? u(this, t, arguments.length > 1 ? arguments[1] : "utf8") : f(this, t)) : arguments.length > 1 ? new o(t,arguments[1]) : new o(t)
                }
                function a(t, e) {
                    if (t = g(t, 0 > e ? 0 : 0 | y(e)),
                        !o.TYPED_ARRAY_SUPPORT)
                        for (var n = 0; e > n; n++)
                            t[n] = 0;
                    return t
                }
                function u(t, e, n) {
                    ("string" != typeof n || "" === n) && (n = "utf8");
                    var r = 0 | v(e, n);
                    return t = g(t, r),
                        t.write(e, n),
                        t
                }
                function f(t, e) {
                    if (o.isBuffer(e))
                        return h(t, e);
                    if (Q(e))
                        return l(t, e);
                    if (null == e)
                        throw new TypeError("must start with number, buffer, array or string");
                    if ("undefined" != typeof ArrayBuffer) {
                        if (e.buffer instanceof ArrayBuffer)
                            return c(t, e);
                        if (e instanceof ArrayBuffer)
                            return d(t, e)
                    }
                    return e.length ? p(t, e) : m(t, e)
                }
                function h(t, e) {
                    var n = 0 | y(e.length);
                    return t = g(t, n),
                        e.copy(t, 0, 0, n),
                        t
                }
                function l(t, e) {
                    var n = 0 | y(e.length);
                    t = g(t, n);
                    for (var r = 0; n > r; r += 1)
                        t[r] = 255 & e[r];
                    return t
                }
                function c(t, e) {
                    var n = 0 | y(e.length);
                    t = g(t, n);
                    for (var r = 0; n > r; r += 1)
                        t[r] = 255 & e[r];
                    return t
                }
                function d(t, e) {
                    return o.TYPED_ARRAY_SUPPORT ? (e.byteLength,
                        t = o._augment(new Uint8Array(e))) : t = c(t, new Uint8Array(e)),
                        t
                }
                function p(t, e) {
                    var n = 0 | y(e.length);
                    t = g(t, n);
                    for (var r = 0; n > r; r += 1)
                        t[r] = 255 & e[r];
                    return t
                }
                function m(t, e) {
                    var n, r = 0;
                    "Buffer" === e.type && Q(e.data) && (n = e.data,
                        r = 0 | y(n.length)),
                        t = g(t, r);
                    for (var o = 0; r > o; o += 1)
                        t[o] = 255 & n[o];
                    return t
                }
                function g(t, e) {
                    o.TYPED_ARRAY_SUPPORT ? (t = o._augment(new Uint8Array(e)),
                        t.__proto__ = o.prototype) : (t.length = e,
                        t._isBuffer = !0);
                    var n = 0 !== e && e <= o.poolSize >>> 1;
                    return n && (t.parent = $),
                        t
                }
                function y(t) {
                    if (t >= s())
                        throw new RangeError("Attempt to allocate Buffer larger than maximum size: 0x" + s().toString(16) + " bytes");
                    return 0 | t
                }
                function w(t, e) {
                    if (!(this instanceof w))
                        return new w(t,e);
                    var n = new o(t,e);
                    return delete n.parent,
                        n
                }
                function v(t, e) {
                    "string" != typeof t && (t = "" + t);
                    var n = t.length;
                    if (0 === n)
                        return 0;
                    for (var r = !1; ; )
                        switch (e) {
                            case "ascii":
                            case "binary":
                            case "raw":
                            case "raws":
                                return n;
                            case "utf8":
                            case "utf-8":
                                return W(t).length;
                            case "ucs2":
                            case "ucs-2":
                            case "utf16le":
                            case "utf-16le":
                                return 2 * n;
                            case "hex":
                                return n >>> 1;
                            case "base64":
                                return X(t).length;
                            default:
                                if (r)
                                    return W(t).length;
                                e = ("" + e).toLowerCase(),
                                    r = !0
                        }
                }
                function b(t, e, n) {
                    var r = !1;
                    if (e = 0 | e,
                        n = void 0 === n || 1 / 0 === n ? this.length : 0 | n,
                    t || (t = "utf8"),
                    0 > e && (e = 0),
                    n > this.length && (n = this.length),
                    e >= n)
                        return "";
                    for (; ; )
                        switch (t) {
                            case "hex":
                                return L(this, e, n);
                            case "utf8":
                            case "utf-8":
                                return T(this, e, n);
                            case "ascii":
                                return U(this, e, n);
                            case "binary":
                                return C(this, e, n);
                            case "base64":
                                return B(this, e, n);
                            case "ucs2":
                            case "ucs-2":
                            case "utf16le":
                            case "utf-16le":
                                return S(this, e, n);
                            default:
                                if (r)
                                    throw new TypeError("Unknown encoding: " + t);
                                t = (t + "").toLowerCase(),
                                    r = !0
                        }
                }
                function E(t, e, n, r) {
                    n = Number(n) || 0;
                    var o = t.length - n;
                    r ? (r = Number(r),
                    r > o && (r = o)) : r = o;
                    var i = e.length;
                    if (i % 2 !== 0)
                        throw new Error("Invalid hex string");
                    r > i / 2 && (r = i / 2);
                    for (var s = 0; r > s; s++) {
                        var a = parseInt(e.substr(2 * s, 2), 16);
                        if (isNaN(a))
                            throw new Error("Invalid hex string");
                        t[n + s] = a
                    }
                    return s
                }
                function A(t, e, n, r) {
                    return Z(W(e, t.length - n), t, n, r)
                }
                function I(t, e, n, r) {
                    return Z(H(e), t, n, r)
                }
                function P(t, e, n, r) {
                    return I(t, e, n, r)
                }
                function _(t, e, n, r) {
                    return Z(X(e), t, n, r)
                }
                function R(t, e, n, r) {
                    return Z(J(e, t.length - n), t, n, r)
                }
                function B(t, e, n) {
                    return V.fromByteArray(0 === e && n === t.length ? t : t.slice(e, n))
                }
                function T(t, e, n) {
                    n = Math.min(t.length, n);
                    for (var r = [], o = e; n > o; ) {
                        var i = t[o]
                            , s = null
                            , a = i > 239 ? 4 : i > 223 ? 3 : i > 191 ? 2 : 1;
                        if (n >= o + a) {
                            var u, f, h, l;
                            switch (a) {
                                case 1:
                                    128 > i && (s = i);
                                    break;
                                case 2:
                                    u = t[o + 1],
                                    128 === (192 & u) && (l = (31 & i) << 6 | 63 & u,
                                    l > 127 && (s = l));
                                    break;
                                case 3:
                                    u = t[o + 1],
                                        f = t[o + 2],
                                    128 === (192 & u) && 128 === (192 & f) && (l = (15 & i) << 12 | (63 & u) << 6 | 63 & f,
                                    l > 2047 && (55296 > l || l > 57343) && (s = l));
                                    break;
                                case 4:
                                    u = t[o + 1],
                                        f = t[o + 2],
                                        h = t[o + 3],
                                    128 === (192 & u) && 128 === (192 & f) && 128 === (192 & h) && (l = (15 & i) << 18 | (63 & u) << 12 | (63 & f) << 6 | 63 & h,
                                    l > 65535 && 1114112 > l && (s = l))
                            }
                        }
                        null === s ? (s = 65533,
                            a = 1) : s > 65535 && (s -= 65536,
                            r.push(s >>> 10 & 1023 | 55296),
                            s = 56320 | 1023 & s),
                            r.push(s),
                            o += a
                    }
                    return x(r)
                }
                function x(t) {
                    var e = t.length;
                    if (K >= e)
                        return String.fromCharCode.apply(String, t);
                    for (var n = "", r = 0; e > r; )
                        n += String.fromCharCode.apply(String, t.slice(r, r += K));
                    return n
                }
                function U(t, e, n) {
                    var r = "";
                    n = Math.min(t.length, n);
                    for (var o = e; n > o; o++)
                        r += String.fromCharCode(127 & t[o]);
                    return r
                }
                function C(t, e, n) {
                    var r = "";
                    n = Math.min(t.length, n);
                    for (var o = e; n > o; o++)
                        r += String.fromCharCode(t[o]);
                    return r
                }
                function L(t, e, n) {
                    var r = t.length;
                    (!e || 0 > e) && (e = 0),
                    (!n || 0 > n || n > r) && (n = r);
                    for (var o = "", i = e; n > i; i++)
                        o += q(t[i]);
                    return o
                }
                function S(t, e, n) {
                    for (var r = t.slice(e, n), o = "", i = 0; i < r.length; i += 2)
                        o += String.fromCharCode(r[i] + 256 * r[i + 1]);
                    return o
                }
                function O(t, e, n) {
                    if (t % 1 !== 0 || 0 > t)
                        throw new RangeError("offset is not uint");
                    if (t + e > n)
                        throw new RangeError("Trying to access beyond buffer length")
                }
                function D(t, e, n, r, i, s) {
                    if (!o.isBuffer(t))
                        throw new TypeError("buffer must be a Buffer instance");
                    if (e > i || s > e)
                        throw new RangeError("value is out of bounds");
                    if (n + r > t.length)
                        throw new RangeError("index out of range")
                }
                function M(t, e, n, r) {
                    0 > e && (e = 65535 + e + 1);
                    for (var o = 0, i = Math.min(t.length - n, 2); i > o; o++)
                        t[n + o] = (e & 255 << 8 * (r ? o : 1 - o)) >>> 8 * (r ? o : 1 - o)
                }
                function F(t, e, n, r) {
                    0 > e && (e = 4294967295 + e + 1);
                    for (var o = 0, i = Math.min(t.length - n, 4); i > o; o++)
                        t[n + o] = e >>> 8 * (r ? o : 3 - o) & 255
                }
                function k(t, e, n, r, o, i) {
                    if (e > o || i > e)
                        throw new RangeError("value is out of bounds");
                    if (n + r > t.length)
                        throw new RangeError("index out of range");
                    if (0 > n)
                        throw new RangeError("index out of range")
                }
                function Y(t, e, n, r, o) {
                    return o || k(t, e, n, 4, 3.4028234663852886e38, -3.4028234663852886e38),
                        G.write(t, e, n, r, 23, 4),
                    n + 4
                }
                function z(t, e, n, r, o) {
                    return o || k(t, e, n, 8, 1.7976931348623157e308, -1.7976931348623157e308),
                        G.write(t, e, n, r, 52, 8),
                    n + 8
                }
                function N(t) {
                    if (t = j(t).replace(ee, ""),
                    t.length < 2)
                        return "";
                    for (; t.length % 4 !== 0; )
                        t += "=";
                    return t
                }
                function j(t) {
                    return t.trim ? t.trim() : t.replace(/^\s+|\s+$/g, "")
                }
                function q(t) {
                    return 16 > t ? "0" + t.toString(16) : t.toString(16)
                }
                function W(t, e) {
                    e = e || 1 / 0;
                    for (var n, r = t.length, o = null, i = [], s = 0; r > s; s++) {
                        if (n = t.charCodeAt(s),
                        n > 55295 && 57344 > n) {
                            if (!o) {
                                if (n > 56319) {
                                    (e -= 3) > -1 && i.push(239, 191, 189);
                                    continue
                                }
                                if (s + 1 === r) {
                                    (e -= 3) > -1 && i.push(239, 191, 189);
                                    continue
                                }
                                o = n;
                                continue
                            }
                            if (56320 > n) {
                                (e -= 3) > -1 && i.push(239, 191, 189),
                                    o = n;
                                continue
                            }
                            n = (o - 55296 << 10 | n - 56320) + 65536
                        } else
                            o && (e -= 3) > -1 && i.push(239, 191, 189);
                        if (o = null,
                        128 > n) {
                            if ((e -= 1) < 0)
                                break;
                            i.push(n)
                        } else if (2048 > n) {
                            if ((e -= 2) < 0)
                                break;
                            i.push(n >> 6 | 192, 63 & n | 128)
                        } else if (65536 > n) {
                            if ((e -= 3) < 0)
                                break;
                            i.push(n >> 12 | 224, n >> 6 & 63 | 128, 63 & n | 128)
                        } else {
                            if (!(1114112 > n))
                                throw new Error("Invalid code point");
                            if ((e -= 4) < 0)
                                break;
                            i.push(n >> 18 | 240, n >> 12 & 63 | 128, n >> 6 & 63 | 128, 63 & n | 128)
                        }
                    }
                    return i
                }
                function H(t) {
                    for (var e = [], n = 0; n < t.length; n++)
                        e.push(255 & t.charCodeAt(n));
                    return e
                }
                function J(t, e) {
                    for (var n, r, o, i = [], s = 0; s < t.length && !((e -= 2) < 0); s++)
                        n = t.charCodeAt(s),
                            r = n >> 8,
                            o = n % 256,
                            i.push(o),
                            i.push(r);
                    return i
                }
                function X(t) {
                    return V.toByteArray(N(t))
                }
                function Z(t, e, n, r) {
                    for (var o = 0; r > o && !(o + n >= e.length || o >= t.length); o++)
                        e[o + n] = t[o];
                    return o
                }
                var V = t("base64-js")
                    , G = t("ieee754")
                    , Q = t("isarray");
                n.Buffer = o,
                    n.SlowBuffer = w,
                    n.INSPECT_MAX_BYTES = 50,
                    o.poolSize = 8192;
                var $ = {};
                o.TYPED_ARRAY_SUPPORT = void 0 !== r.TYPED_ARRAY_SUPPORT ? r.TYPED_ARRAY_SUPPORT : i(),
                    o.TYPED_ARRAY_SUPPORT ? (o.prototype.__proto__ = Uint8Array.prototype,
                        o.__proto__ = Uint8Array) : (o.prototype.length = void 0,
                        o.prototype.parent = void 0),
                    o.isBuffer = function(t) {
                        return !(null == t || !t._isBuffer)
                    }
                    ,
                    o.compare = function(t, e) {
                        if (!o.isBuffer(t) || !o.isBuffer(e))
                            throw new TypeError("Arguments must be Buffers");
                        if (t === e)
                            return 0;
                        for (var n = t.length, r = e.length, i = 0, s = Math.min(n, r); s > i && t[i] === e[i]; )
                            ++i;
                        return i !== s && (n = t[i],
                            r = e[i]),
                            r > n ? -1 : n > r ? 1 : 0
                    }
                    ,
                    o.isEncoding = function(t) {
                        switch (String(t).toLowerCase()) {
                            case "hex":
                            case "utf8":
                            case "utf-8":
                            case "ascii":
                            case "binary":
                            case "base64":
                            case "raw":
                            case "ucs2":
                            case "ucs-2":
                            case "utf16le":
                            case "utf-16le":
                                return !0;
                            default:
                                return !1
                        }
                    }
                    ,
                    o.concat = function(t, e) {
                        if (!Q(t))
                            throw new TypeError("list argument must be an Array of Buffers.");
                        if (0 === t.length)
                            return new o(0);
                        var n;
                        if (void 0 === e)
                            for (e = 0,
                                     n = 0; n < t.length; n++)
                                e += t[n].length;
                        var r = new o(e)
                            , i = 0;
                        for (n = 0; n < t.length; n++) {
                            var s = t[n];
                            s.copy(r, i),
                                i += s.length
                        }
                        return r
                    }
                    ,
                    o.byteLength = v,
                    o.prototype.toString = function() {
                        var t = 0 | this.length;
                        return 0 === t ? "" : 0 === arguments.length ? T(this, 0, t) : b.apply(this, arguments)
                    }
                    ,
                    o.prototype.equals = function(t) {
                        if (!o.isBuffer(t))
                            throw new TypeError("Argument must be a Buffer");
                        return this === t ? !0 : 0 === o.compare(this, t)
                    }
                    ,
                    o.prototype.inspect = function() {
                        var t = ""
                            , e = n.INSPECT_MAX_BYTES;
                        return this.length > 0 && (t = this.toString("hex", 0, e).match(/.{2}/g).join(" "),
                        this.length > e && (t += " ... ")),
                        "<Buffer " + t + ">"
                    }
                    ,
                    o.prototype.compare = function(t) {
                        if (!o.isBuffer(t))
                            throw new TypeError("Argument must be a Buffer");
                        return this === t ? 0 : o.compare(this, t)
                    }
                    ,
                    o.prototype.indexOf = function(t, e) {
                        function n(t, e, n) {
                            for (var r = -1, o = 0; n + o < t.length; o++)
                                if (t[n + o] === e[-1 === r ? 0 : o - r]) {
                                    if (-1 === r && (r = o),
                                    o - r + 1 === e.length)
                                        return n + r
                                } else
                                    r = -1;
                            return -1
                        }
                        if (e > 2147483647 ? e = 2147483647 : -2147483648 > e && (e = -2147483648),
                            e >>= 0,
                        0 === this.length)
                            return -1;
                        if (e >= this.length)
                            return -1;
                        if (0 > e && (e = Math.max(this.length + e, 0)),
                        "string" == typeof t)
                            return 0 === t.length ? -1 : String.prototype.indexOf.call(this, t, e);
                        if (o.isBuffer(t))
                            return n(this, t, e);
                        if ("number" == typeof t)
                            return o.TYPED_ARRAY_SUPPORT && "function" === Uint8Array.prototype.indexOf ? Uint8Array.prototype.indexOf.call(this, t, e) : n(this, [t], e);
                        throw new TypeError("val must be string, number or Buffer")
                    }
                    ,
                    o.prototype.get = function(t) {
                        return console.log(".get() is deprecated. Access using array indexes instead."),
                            this.readUInt8(t)
                    }
                    ,
                    o.prototype.set = function(t, e) {
                        return console.log(".set() is deprecated. Access using array indexes instead."),
                            this.writeUInt8(t, e)
                    }
                    ,
                    o.prototype.write = function(t, e, n, r) {
                        if (void 0 === e)
                            r = "utf8",
                                n = this.length,
                                e = 0;
                        else if (void 0 === n && "string" == typeof e)
                            r = e,
                                n = this.length,
                                e = 0;
                        else if (isFinite(e))
                            e = 0 | e,
                                isFinite(n) ? (n = 0 | n,
                                void 0 === r && (r = "utf8")) : (r = n,
                                    n = void 0);
                        else {
                            var o = r;
                            r = e,
                                e = 0 | n,
                                n = o
                        }
                        var i = this.length - e;
                        if ((void 0 === n || n > i) && (n = i),
                        t.length > 0 && (0 > n || 0 > e) || e > this.length)
                            throw new RangeError("attempt to write outside buffer bounds");
                        r || (r = "utf8");
                        for (var s = !1; ; )
                            switch (r) {
                                case "hex":
                                    return E(this, t, e, n);
                                case "utf8":
                                case "utf-8":
                                    return A(this, t, e, n);
                                case "ascii":
                                    return I(this, t, e, n);
                                case "binary":
                                    return P(this, t, e, n);
                                case "base64":
                                    return _(this, t, e, n);
                                case "ucs2":
                                case "ucs-2":
                                case "utf16le":
                                case "utf-16le":
                                    return R(this, t, e, n);
                                default:
                                    if (s)
                                        throw new TypeError("Unknown encoding: " + r);
                                    r = ("" + r).toLowerCase(),
                                        s = !0
                            }
                    }
                    ,
                    o.prototype.toJSON = function() {
                        return {
                            type: "Buffer",
                            data: Array.prototype.slice.call(this._arr || this, 0)
                        }
                    }
                ;
                var K = 4096;
                o.prototype.slice = function(t, e) {
                    var n = this.length;
                    t = ~~t,
                        e = void 0 === e ? n : ~~e,
                        0 > t ? (t += n,
                        0 > t && (t = 0)) : t > n && (t = n),
                        0 > e ? (e += n,
                        0 > e && (e = 0)) : e > n && (e = n),
                    t > e && (e = t);
                    var r;
                    if (o.TYPED_ARRAY_SUPPORT)
                        r = o._augment(this.subarray(t, e));
                    else {
                        var i = e - t;
                        r = new o(i,void 0);
                        for (var s = 0; i > s; s++)
                            r[s] = this[s + t]
                    }
                    return r.length && (r.parent = this.parent || this),
                        r
                }
                    ,
                    o.prototype.readUIntLE = function(t, e, n) {
                        t = 0 | t,
                            e = 0 | e,
                        n || O(t, e, this.length);
                        for (var r = this[t], o = 1, i = 0; ++i < e && (o *= 256); )
                            r += this[t + i] * o;
                        return r
                    }
                    ,
                    o.prototype.readUIntBE = function(t, e, n) {
                        t = 0 | t,
                            e = 0 | e,
                        n || O(t, e, this.length);
                        for (var r = this[t + --e], o = 1; e > 0 && (o *= 256); )
                            r += this[t + --e] * o;
                        return r
                    }
                    ,
                    o.prototype.readUInt8 = function(t, e) {
                        return e || O(t, 1, this.length),
                            this[t]
                    }
                    ,
                    o.prototype.readUInt16LE = function(t, e) {
                        return e || O(t, 2, this.length),
                        this[t] | this[t + 1] << 8
                    }
                    ,
                    o.prototype.readUInt16BE = function(t, e) {
                        return e || O(t, 2, this.length),
                        this[t] << 8 | this[t + 1]
                    }
                    ,
                    o.prototype.readUInt32LE = function(t, e) {
                        return e || O(t, 4, this.length),
                        (this[t] | this[t + 1] << 8 | this[t + 2] << 16) + 16777216 * this[t + 3]
                    }
                    ,
                    o.prototype.readUInt32BE = function(t, e) {
                        return e || O(t, 4, this.length),
                        16777216 * this[t] + (this[t + 1] << 16 | this[t + 2] << 8 | this[t + 3])
                    }
                    ,
                    o.prototype.readIntLE = function(t, e, n) {
                        t = 0 | t,
                            e = 0 | e,
                        n || O(t, e, this.length);
                        for (var r = this[t], o = 1, i = 0; ++i < e && (o *= 256); )
                            r += this[t + i] * o;
                        return o *= 128,
                        r >= o && (r -= Math.pow(2, 8 * e)),
                            r
                    }
                    ,
                    o.prototype.readIntBE = function(t, e, n) {
                        t = 0 | t,
                            e = 0 | e,
                        n || O(t, e, this.length);
                        for (var r = e, o = 1, i = this[t + --r]; r > 0 && (o *= 256); )
                            i += this[t + --r] * o;
                        return o *= 128,
                        i >= o && (i -= Math.pow(2, 8 * e)),
                            i
                    }
                    ,
                    o.prototype.readInt8 = function(t, e) {
                        return e || O(t, 1, this.length),
                            128 & this[t] ? -1 * (255 - this[t] + 1) : this[t]
                    }
                    ,
                    o.prototype.readInt16LE = function(t, e) {
                        e || O(t, 2, this.length);
                        var n = this[t] | this[t + 1] << 8;
                        return 32768 & n ? 4294901760 | n : n
                    }
                    ,
                    o.prototype.readInt16BE = function(t, e) {
                        e || O(t, 2, this.length);
                        var n = this[t + 1] | this[t] << 8;
                        return 32768 & n ? 4294901760 | n : n
                    }
                    ,
                    o.prototype.readInt32LE = function(t, e) {
                        return e || O(t, 4, this.length),
                        this[t] | this[t + 1] << 8 | this[t + 2] << 16 | this[t + 3] << 24
                    }
                    ,
                    o.prototype.readInt32BE = function(t, e) {
                        return e || O(t, 4, this.length),
                        this[t] << 24 | this[t + 1] << 16 | this[t + 2] << 8 | this[t + 3]
                    }
                    ,
                    o.prototype.readFloatLE = function(t, e) {
                        return e || O(t, 4, this.length),
                            G.read(this, t, !0, 23, 4)
                    }
                    ,
                    o.prototype.readFloatBE = function(t, e) {
                        return e || O(t, 4, this.length),
                            G.read(this, t, !1, 23, 4)
                    }
                    ,
                    o.prototype.readDoubleLE = function(t, e) {
                        return e || O(t, 8, this.length),
                            G.read(this, t, !0, 52, 8)
                    }
                    ,
                    o.prototype.readDoubleBE = function(t, e) {
                        return e || O(t, 8, this.length),
                            G.read(this, t, !1, 52, 8)
                    }
                    ,
                    o.prototype.writeUIntLE = function(t, e, n, r) {
                        t = +t,
                            e = 0 | e,
                            n = 0 | n,
                        r || D(this, t, e, n, Math.pow(2, 8 * n), 0);
                        var o = 1
                            , i = 0;
                        for (this[e] = 255 & t; ++i < n && (o *= 256); )
                            this[e + i] = t / o & 255;
                        return e + n
                    }
                    ,
                    o.prototype.writeUIntBE = function(t, e, n, r) {
                        t = +t,
                            e = 0 | e,
                            n = 0 | n,
                        r || D(this, t, e, n, Math.pow(2, 8 * n), 0);
                        var o = n - 1
                            , i = 1;
                        for (this[e + o] = 255 & t; --o >= 0 && (i *= 256); )
                            this[e + o] = t / i & 255;
                        return e + n
                    }
                    ,
                    o.prototype.writeUInt8 = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 1, 255, 0),
                        o.TYPED_ARRAY_SUPPORT || (t = Math.floor(t)),
                            this[e] = 255 & t,
                        e + 1
                    }
                    ,
                    o.prototype.writeUInt16LE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 2, 65535, 0),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = 255 & t,
                                this[e + 1] = t >>> 8) : M(this, t, e, !0),
                        e + 2
                    }
                    ,
                    o.prototype.writeUInt16BE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 2, 65535, 0),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = t >>> 8,
                                this[e + 1] = 255 & t) : M(this, t, e, !1),
                        e + 2
                    }
                    ,
                    o.prototype.writeUInt32LE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 4, 4294967295, 0),
                            o.TYPED_ARRAY_SUPPORT ? (this[e + 3] = t >>> 24,
                                this[e + 2] = t >>> 16,
                                this[e + 1] = t >>> 8,
                                this[e] = 255 & t) : F(this, t, e, !0),
                        e + 4
                    }
                    ,
                    o.prototype.writeUInt32BE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 4, 4294967295, 0),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = t >>> 24,
                                this[e + 1] = t >>> 16,
                                this[e + 2] = t >>> 8,
                                this[e + 3] = 255 & t) : F(this, t, e, !1),
                        e + 4
                    }
                    ,
                    o.prototype.writeIntLE = function(t, e, n, r) {
                        if (t = +t,
                            e = 0 | e,
                            !r) {
                            var o = Math.pow(2, 8 * n - 1);
                            D(this, t, e, n, o - 1, -o)
                        }
                        var i = 0
                            , s = 1
                            , a = 0 > t ? 1 : 0;
                        for (this[e] = 255 & t; ++i < n && (s *= 256); )
                            this[e + i] = (t / s >> 0) - a & 255;
                        return e + n
                    }
                    ,
                    o.prototype.writeIntBE = function(t, e, n, r) {
                        if (t = +t,
                            e = 0 | e,
                            !r) {
                            var o = Math.pow(2, 8 * n - 1);
                            D(this, t, e, n, o - 1, -o)
                        }
                        var i = n - 1
                            , s = 1
                            , a = 0 > t ? 1 : 0;
                        for (this[e + i] = 255 & t; --i >= 0 && (s *= 256); )
                            this[e + i] = (t / s >> 0) - a & 255;
                        return e + n
                    }
                    ,
                    o.prototype.writeInt8 = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 1, 127, -128),
                        o.TYPED_ARRAY_SUPPORT || (t = Math.floor(t)),
                        0 > t && (t = 255 + t + 1),
                            this[e] = 255 & t,
                        e + 1
                    }
                    ,
                    o.prototype.writeInt16LE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 2, 32767, -32768),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = 255 & t,
                                this[e + 1] = t >>> 8) : M(this, t, e, !0),
                        e + 2
                    }
                    ,
                    o.prototype.writeInt16BE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 2, 32767, -32768),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = t >>> 8,
                                this[e + 1] = 255 & t) : M(this, t, e, !1),
                        e + 2
                    }
                    ,
                    o.prototype.writeInt32LE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 4, 2147483647, -2147483648),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = 255 & t,
                                this[e + 1] = t >>> 8,
                                this[e + 2] = t >>> 16,
                                this[e + 3] = t >>> 24) : F(this, t, e, !0),
                        e + 4
                    }
                    ,
                    o.prototype.writeInt32BE = function(t, e, n) {
                        return t = +t,
                            e = 0 | e,
                        n || D(this, t, e, 4, 2147483647, -2147483648),
                        0 > t && (t = 4294967295 + t + 1),
                            o.TYPED_ARRAY_SUPPORT ? (this[e] = t >>> 24,
                                this[e + 1] = t >>> 16,
                                this[e + 2] = t >>> 8,
                                this[e + 3] = 255 & t) : F(this, t, e, !1),
                        e + 4
                    }
                    ,
                    o.prototype.writeFloatLE = function(t, e, n) {
                        return Y(this, t, e, !0, n)
                    }
                    ,
                    o.prototype.writeFloatBE = function(t, e, n) {
                        return Y(this, t, e, !1, n)
                    }
                    ,
                    o.prototype.writeDoubleLE = function(t, e, n) {
                        return z(this, t, e, !0, n)
                    }
                    ,
                    o.prototype.writeDoubleBE = function(t, e, n) {
                        return z(this, t, e, !1, n)
                    }
                    ,
                    o.prototype.copy = function(t, e, n, r) {
                        if (n || (n = 0),
                        r || 0 === r || (r = this.length),
                        e >= t.length && (e = t.length),
                        e || (e = 0),
                        r > 0 && n > r && (r = n),
                        r === n)
                            return 0;
                        if (0 === t.length || 0 === this.length)
                            return 0;
                        if (0 > e)
                            throw new RangeError("targetStart out of bounds");
                        if (0 > n || n >= this.length)
                            throw new RangeError("sourceStart out of bounds");
                        if (0 > r)
                            throw new RangeError("sourceEnd out of bounds");
                        r > this.length && (r = this.length),
                        t.length - e < r - n && (r = t.length - e + n);
                        var i, s = r - n;
                        if (this === t && e > n && r > e)
                            for (i = s - 1; i >= 0; i--)
                                t[i + e] = this[i + n];
                        else if (1e3 > s || !o.TYPED_ARRAY_SUPPORT)
                            for (i = 0; s > i; i++)
                                t[i + e] = this[i + n];
                        else
                            t._set(this.subarray(n, n + s), e);
                        return s
                    }
                    ,
                    o.prototype.fill = function(t, e, n) {
                        if (t || (t = 0),
                        e || (e = 0),
                        n || (n = this.length),
                        e > n)
                            throw new RangeError("end < start");
                        if (n !== e && 0 !== this.length) {
                            if (0 > e || e >= this.length)
                                throw new RangeError("start out of bounds");
                            if (0 > n || n > this.length)
                                throw new RangeError("end out of bounds");
                            var r;
                            if ("number" == typeof t)
                                for (r = e; n > r; r++)
                                    this[r] = t;
                            else {
                                var o = W(t.toString())
                                    , i = o.length;
                                for (r = e; n > r; r++)
                                    this[r] = o[r % i]
                            }
                            return this
                        }
                    }
                    ,
                    o.prototype.toArrayBuffer = function() {
                        if ("undefined" != typeof Uint8Array) {
                            if (o.TYPED_ARRAY_SUPPORT)
                                return new o(this).buffer;
                            for (var t = new Uint8Array(this.length), e = 0, n = t.length; n > e; e += 1)
                                t[e] = this[e];
                            return t.buffer
                        }
                        throw new TypeError("Buffer.toArrayBuffer not supported in this browser")
                    }
                ;
                var te = o.prototype;
                o._augment = function(t) {
                    return t.constructor = o,
                        t._isBuffer = !0,
                        t._set = t.set,
                        t.get = te.get,
                        t.set = te.set,
                        t.write = te.write,
                        t.toString = te.toString,
                        t.toLocaleString = te.toString,
                        t.toJSON = te.toJSON,
                        t.equals = te.equals,
                        t.compare = te.compare,
                        t.indexOf = te.indexOf,
                        t.copy = te.copy,
                        t.slice = te.slice,
                        t.readUIntLE = te.readUIntLE,
                        t.readUIntBE = te.readUIntBE,
                        t.readUInt8 = te.readUInt8,
                        t.readUInt16LE = te.readUInt16LE,
                        t.readUInt16BE = te.readUInt16BE,
                        t.readUInt32LE = te.readUInt32LE,
                        t.readUInt32BE = te.readUInt32BE,
                        t.readIntLE = te.readIntLE,
                        t.readIntBE = te.readIntBE,
                        t.readInt8 = te.readInt8,
                        t.readInt16LE = te.readInt16LE,
                        t.readInt16BE = te.readInt16BE,
                        t.readInt32LE = te.readInt32LE,
                        t.readInt32BE = te.readInt32BE,
                        t.readFloatLE = te.readFloatLE,
                        t.readFloatBE = te.readFloatBE,
                        t.readDoubleLE = te.readDoubleLE,
                        t.readDoubleBE = te.readDoubleBE,
                        t.writeUInt8 = te.writeUInt8,
                        t.writeUIntLE = te.writeUIntLE,
                        t.writeUIntBE = te.writeUIntBE,
                        t.writeUInt16LE = te.writeUInt16LE,
                        t.writeUInt16BE = te.writeUInt16BE,
                        t.writeUInt32LE = te.writeUInt32LE,
                        t.writeUInt32BE = te.writeUInt32BE,
                        t.writeIntLE = te.writeIntLE,
                        t.writeIntBE = te.writeIntBE,
                        t.writeInt8 = te.writeInt8,
                        t.writeInt16LE = te.writeInt16LE,
                        t.writeInt16BE = te.writeInt16BE,
                        t.writeInt32LE = te.writeInt32LE,
                        t.writeInt32BE = te.writeInt32BE,
                        t.writeFloatLE = te.writeFloatLE,
                        t.writeFloatBE = te.writeFloatBE,
                        t.writeDoubleLE = te.writeDoubleLE,
                        t.writeDoubleBE = te.writeDoubleBE,
                        t.fill = te.fill,
                        t.inspect = te.inspect,
                        t.toArrayBuffer = te.toArrayBuffer,
                        t
                }
                ;
                var ee = /[^+\/0-9A-Za-z-_]/g
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/node_modules/buffer/index.js", "/node_modules/buffer")
    }
        , {
            _process: 9,
            "base64-js": 5,
            buffer: 6,
            ieee754: 8,
            isarray: 7
        }],
    7: [function(t, e) {
        (function() {
                var t = {}.toString;
                e.exports = Array.isArray || function(e) {
                    return "[object Array]" == t.call(e)
                }
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/node_modules/buffer/node_modules/isarray/index.js", "/node_modules/buffer/node_modules/isarray")
    }
        , {
            _process: 9,
            buffer: 6
        }],
    8: [function(t, e, n) {
        (function() {
                n.read = function(t, e, n, r, o) {
                    var i, s, a = 8 * o - r - 1, u = (1 << a) - 1, f = u >> 1, h = -7, l = n ? o - 1 : 0, c = n ? -1 : 1, d = t[e + l];
                    for (l += c,
                             i = d & (1 << -h) - 1,
                             d >>= -h,
                             h += a; h > 0; i = 256 * i + t[e + l],
                             l += c,
                             h -= 8)
                        ;
                    for (s = i & (1 << -h) - 1,
                             i >>= -h,
                             h += r; h > 0; s = 256 * s + t[e + l],
                             l += c,
                             h -= 8)
                        ;
                    if (0 === i)
                        i = 1 - f;
                    else {
                        if (i === u)
                            return s ? 0 / 0 : 1 / 0 * (d ? -1 : 1);
                        s += Math.pow(2, r),
                            i -= f
                    }
                    return (d ? -1 : 1) * s * Math.pow(2, i - r)
                }
                    ,
                    n.write = function(t, e, n, r, o, i) {
                        var s, a, u, f = 8 * i - o - 1, h = (1 << f) - 1, l = h >> 1, c = 23 === o ? Math.pow(2, -24) - Math.pow(2, -77) : 0, d = r ? 0 : i - 1, p = r ? 1 : -1, m = 0 > e || 0 === e && 0 > 1 / e ? 1 : 0;
                        for (e = Math.abs(e),
                                 isNaN(e) || 1 / 0 === e ? (a = isNaN(e) ? 1 : 0,
                                     s = h) : (s = Math.floor(Math.log(e) / Math.LN2),
                                 e * (u = Math.pow(2, -s)) < 1 && (s--,
                                     u *= 2),
                                     e += s + l >= 1 ? c / u : c * Math.pow(2, 1 - l),
                                 e * u >= 2 && (s++,
                                     u /= 2),
                                     s + l >= h ? (a = 0,
                                         s = h) : s + l >= 1 ? (a = (e * u - 1) * Math.pow(2, o),
                                         s += l) : (a = e * Math.pow(2, l - 1) * Math.pow(2, o),
                                         s = 0)); o >= 8; t[n + d] = 255 & a,
                                 d += p,
                                 a /= 256,
                                 o -= 8)
                            ;
                        for (s = s << o | a,
                                 f += o; f > 0; t[n + d] = 255 & s,
                                 d += p,
                                 s /= 256,
                                 f -= 8)
                            ;
                        t[n + d - p] |= 128 * m
                    }
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/node_modules/ieee754/index.js", "/node_modules/ieee754")
    }
        , {
            _process: 9,
            buffer: 6
        }],
    9: [function(t, e) {
        (function(t) {
                function n() {
                    throw new Error("setTimeout has not been defined")
                }
                function r() {
                    throw new Error("clearTimeout has not been defined")
                }
                function o(t) {
                    if (h === setTimeout)
                        return setTimeout(t, 0);
                    if ((h === n || !h) && setTimeout)
                        return h = setTimeout,
                            setTimeout(t, 0);
                    try {
                        return h(t, 0)
                    } catch (e) {
                        try {
                            return h.call(null, t, 0)
                        } catch (e) {
                            return h.call(this, t, 0)
                        }
                    }
                }
                function i(t) {
                    if (l === clearTimeout)
                        return clearTimeout(t);
                    if ((l === r || !l) && clearTimeout)
                        return l = clearTimeout,
                            clearTimeout(t);
                    try {
                        return l(t)
                    } catch (e) {
                        try {
                            return l.call(null, t)
                        } catch (e) {
                            return l.call(this, t)
                        }
                    }
                }
                function s() {
                    p && c && (p = !1,
                        c.length ? d = c.concat(d) : m = -1,
                    d.length && a())
                }
                function a() {
                    if (!p) {
                        var t = o(s);
                        p = !0;
                        for (var e = d.length; e; ) {
                            for (c = d,
                                     d = []; ++m < e; )
                                c && c[m].run();
                            m = -1,
                                e = d.length
                        }
                        c = null,
                            p = !1,
                            i(t)
                    }
                }
                function u(t, e) {
                    this.fun = t,
                        this.array = e
                }
                function f() {}
                var h, l, t = e.exports = {};
                !function() {
                    try {
                        h = "function" == typeof setTimeout ? setTimeout : n
                    } catch (t) {
                        h = n
                    }
                    try {
                        l = "function" == typeof clearTimeout ? clearTimeout : r
                    } catch (t) {
                        l = r
                    }
                }();
                var c, d = [], p = !1, m = -1;
                t.nextTick = function(t) {
                    var e = new Array(arguments.length - 1);
                    if (arguments.length > 1)
                        for (var n = 1; n < arguments.length; n++)
                            e[n - 1] = arguments[n];
                    d.push(new u(t,e)),
                    1 !== d.length || p || o(a)
                }
                    ,
                    u.prototype.run = function() {
                        this.fun.apply(null, this.array)
                    }
                    ,
                    t.title = "browser",
                    t.browser = !0,
                    t.env = {},
                    t.argv = [],
                    t.version = "",
                    t.versions = {},
                    t.on = f,
                    t.addListener = f,
                    t.once = f,
                    t.off = f,
                    t.removeListener = f,
                    t.removeAllListeners = f,
                    t.emit = f,
                    t.prependListener = f,
                    t.prependOnceListener = f,
                    t.listeners = function() {
                        return []
                    }
                    ,
                    t.binding = function() {
                        throw new Error("process.binding is not supported")
                    }
                    ,
                    t.cwd = function() {
                        return "/"
                    }
                    ,
                    t.chdir = function() {
                        throw new Error("process.chdir is not supported")
                    }
                    ,
                    t.umask = function() {
                        return 0
                    }
            }
        ).call(this, t("_process"), "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {}, t("buffer").Buffer, arguments[3], arguments[4], arguments[5], arguments[6], "/node_modules/process/browser.js", "/node_modules/process")
    }
        , {
            _process: 9,
            buffer: 6
        }]
}, {}, [1]);
//# sourceMappingURL=../v3/clef.js.map