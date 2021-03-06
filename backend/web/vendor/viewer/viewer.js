/*!
 * Viewer.js v0.7.1
 * https://github.com/fengyuanchen/viewerjs
 *
 * Copyright (c) 2017 Fengyuan Chen
 * Released under the MIT license
 *
 * Date: 2017-05-14T07:05:32.049Z
 */

!function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : e.Viewer = t()
}(this, function () {
    "use strict";

    function e(e) {
        return U.call(e).slice(8, -1).toLowerCase()
    }

    function t(e) {
        return "string" == typeof e
    }

    function i(e) {
        return "number" == typeof e && !isNaN(e)
    }

    function n(e) {
        return void 0 === e
    }

    function r(e) {
        return "object" === (void 0 === e ? "undefined" : V(e)) && null !== e
    }

    function o(e) {
        if (!r(e)) return !1;
        try {
            var t = e.constructor, i = t.prototype;
            return t && i && _.call(i, "isPrototypeOf")
        } catch (e) {
            return !1
        }
    }

    function a(t) {
        return "function" === e(t)
    }

    function l(t) {
        return Array.isArray ? Array.isArray(t) : "array" === e(t)
    }

    function s(e, t) {
        return t = t >= 0 ? t : 0, Array.from ? Array.from(e).slice(t) : G.call(e, t)
    }

    function c(e, t) {
        var i = -1;
        return t.indexOf ? t.indexOf(e) : (t.forEach(function (t, n) {
            t === e && (i = n)
        }), i)
    }

    function u(e) {
        return t(e) && (e = e.trim ? e.trim() : e.replace(/^\s+(.*)\s+$/, "1")), e
    }

    function d(e, t) {
        if (e && a(t)) {
            var n = void 0;
            if (l(e) || i(e.length)) {
                var o = e.length;
                for (n = 0; n < o && t.call(e, e[n], n, e) !== !1; n++) ;
            } else r(e) && Object.keys(e).forEach(function (i) {
                t.call(e, e[i], i, e)
            })
        }
        return e
    }

    function v(e) {
        for (var t = arguments.length, i = Array(t > 1 ? t - 1 : 0), n = 1; n < t; n++) i[n - 1] = arguments[n];
        if (r(e) && i.length > 0) {
            if (Object.assign) return Object.assign.apply(Object, [e].concat(i));
            i.forEach(function (t) {
                r(t) && Object.keys(t).forEach(function (i) {
                    e[i] = t[i]
                })
            })
        }
        return e
    }

    function f(e, t) {
        for (var i = arguments.length, n = Array(i > 2 ? i - 2 : 0), r = 2; r < i; r++) n[r - 2] = arguments[r];
        return function () {
            for (var i = arguments.length, r = Array(i), o = 0; o < i; o++) r[o] = arguments[o];
            return e.apply(t, n.concat(r))
        }
    }

    function m(e, t) {
        var n = e.style;
        d(t, function (e, t) {
            Z.test(t) && i(e) && (e += "px"), n[t] = e
        })
    }

    function h(e) {
        return window.getComputedStyle ? window.getComputedStyle(e, null) : e.currentStyle
    }

    function w(e, t) {
        return e.classList ? e.classList.contains(t) : e.className.indexOf(t) > -1
    }

    function p(e, t) {
        if (t) {
            if (i(e.length)) return void d(e, function (e) {
                p(e, t)
            });
            if (e.classList) return void e.classList.add(t);
            var n = u(e.className);
            n ? n.indexOf(t) < 0 && (e.className = n + " " + t) : e.className = t
        }
    }

    function g(e, t) {
        if (t) return i(e.length) ? void d(e, function (e) {
            g(e, t)
        }) : e.classList ? void e.classList.remove(t) : void(e.className.indexOf(t) >= 0 && (e.className = e.className.replace(t, "")))
    }

    function b(e, t, n) {
        if (t) return i(e.length) ? void d(e, function (e) {
            b(e, t, n)
        }) : void(n ? p(e, t) : g(e, t))
    }

    function y(e) {
        return e.replace(/([a-z\d])([A-Z])/g, "$1-$2").toLowerCase()
    }

    function x(e, t) {
        return r(e[t]) ? e[t] : e.dataset ? e.dataset[t] : e.getAttribute("data-" + y(t))
    }

    function k(e, t, i) {
        r(i) ? e[t] = i : e.dataset ? e.dataset[t] = i : e.setAttribute("data-" + y(t), i)
    }

    function z(e, t) {
        if (r(e[t])) delete e[t]; else if (e.dataset) try {
            delete e.dataset[t]
        } catch (i) {
            e.dataset[t] = null
        } else e.removeAttribute("data-" + y(t))
    }

    function D(e, t, i) {
        var n = u(t).split(/\s+/);
        if (n.length > 1) return void d(n, function (t) {
            D(e, t, i)
        });
        e.removeEventListener ? e.removeEventListener(t, i, !1) : e.detachEvent && e.detachEvent("on" + t, i)
    }

    function E(e, t, i, n) {
        var r = u(t).split(/\s+/), o = i;
        if (r.length > 1) return void d(r, function (t) {
            E(e, t, i)
        });
        n && (i = function () {
            for (var n = arguments.length, r = Array(n), a = 0; a < n; a++) r[a] = arguments[a];
            return D(e, t, i), o.apply(e, r)
        }), e.addEventListener ? e.addEventListener(t, i, !1) : e.attachEvent && e.attachEvent("on" + t, i)
    }

    function I(e, t, i) {
        if (e.dispatchEvent) {
            var r = void 0;
            return a(Event) && a(CustomEvent) ? r = n(i) ? new Event(t, {
                bubbles: !0,
                cancelable: !0
            }) : new CustomEvent(t, {
                detail: i,
                bubbles: !0,
                cancelable: !0
            }) : n(i) ? (r = document.createEvent("Event"), r.initEvent(t, !0, !0)) : (r = document.createEvent("CustomEvent"), r.initCustomEvent(t, !0, !0, i)), e.dispatchEvent(r)
        }
        return !e.fireEvent || e.fireEvent("on" + t)
    }

    function T(e) {
        var t = e || window.event;
        if (t.target || (t.target = t.srcElement || document), !i(t.pageX) && i(t.clientX)) {
            var n = e.target.ownerDocument || document, r = n.documentElement, o = n.body;
            t.pageX = t.clientX + ((r && r.scrollLeft || o && o.scrollLeft || 0) - (r && r.clientLeft || o && o.clientLeft || 0)), t.pageY = t.clientY + ((r && r.scrollTop || o && o.scrollTop || 0) - (r && r.clientTop || o && o.clientTop || 0))
        }
        return t
    }

    function L(e) {
        var t = document.documentElement, i = e.getBoundingClientRect();
        return {
            left: i.left + ((window.scrollX || t && t.scrollLeft || 0) - (t && t.clientLeft || 0)),
            top: i.top + ((window.scrollY || t && t.scrollTop || 0) - (t && t.clientTop || 0))
        }
    }

    function C(e, t) {
        return e.getElementsByTagName(t)
    }

    function Y(e, t) {
        return e.getElementsByClassName ? e.getElementsByClassName(t) : e.querySelectorAll("." + t)
    }

    function N(e, t) {
        if (t.length) return void d(t, function (t) {
            N(e, t)
        });
        e.appendChild(t)
    }

    function X(e) {
        e.parentNode && e.parentNode.removeChild(e)
    }

    function M(e) {
        for (; e.firstChild;) e.removeChild(e.firstChild)
    }

    function S(e, t) {
        n(e.textContent) ? e.innerText = t : e.textContent = t
    }

    function A(e) {
        return e.offsetWidth
    }

    function F(e) {
        return t(e) ? e.replace(/^.*\//, "").replace(/[?&#].*$/, "") : ""
    }

    function O(e, t) {
        if (e.naturalWidth) return void t(e.naturalWidth, e.naturalHeight);
        var i = document.createElement("img");
        i.onload = function () {
            t(this.width, this.height)
        }, i.src = e.src
    }

    function R(e) {
        var t = [], n = e.rotate, r = e.scaleX, o = e.scaleY;
        return i(n) && 0 !== n && t.push("rotate(" + n + "deg)"), i(r) && 1 !== r && t.push("scaleX(" + r + ")"), i(o) && 1 !== o && t.push("scaleY(" + o + ")"), t.length ? t.join(" ") : "none"
    }

    function W(e) {
        switch (e) {
            case 2:
                return "viewer-hide-xs-down";
            case 3:
                return "viewer-hide-sm-down";
            case 4:
                return "viewer-hide-md-down"
        }
        return ""
    }

    function q(e, t) {
        var i = {endX: e.pageX, endY: e.pageY};
        return t ? i : v({startX: e.pageX, startY: e.pageY}, i)
    }

    function j(e) {
        var t = v({}, e), i = [];
        return d(e, function (e, n) {
            delete t[n], d(t, function (t) {
                var n = Math.abs(e.startX - t.startX), r = Math.abs(e.startY - t.startY), o = Math.abs(e.endX - t.endX),
                    a = Math.abs(e.endY - t.endY), l = Math.sqrt(n * n + r * r), s = Math.sqrt(o * o + a * a),
                    c = (s - l) / l;
                i.push(c)
            })
        }), i.sort(function (e, t) {
            return Math.abs(e) < Math.abs(t)
        }), i[0]
    }

    function H(e) {
        var t = 0, i = 0, n = 0;
        return d(e, function (e) {
            t += e.startX, i += e.startY, n += 1
        }), t /= n, i /= n, {pageX: t, pageY: i}
    }

    var P = {
            inline: !1,
            button: !0,
            navbar: !0,
            title: !0,
            toolbar: !0,
            tooltip: !0,
            movable: !0,
            zoomable: !0,
            rotatable: !0,
            scalable: !0,
            transition: !0,
            fullscreen: !0,
            keyboard: !0,
            interval: 5e3,
            minWidth: 200,
            minHeight: 100,
            zoomRatio: .1,
            minZoomRatio: .01,
            maxZoomRatio: 100,
            zIndex: 2015,
            zIndexInline: 0,
            url: "src",
            ready: null,
            show: null,
            shown: null,
            hide: null,
            hidden: null,
            view: null,
            viewed: null
        }, V = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        }, B = function (e, t) {
            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }, K = function () {
            function e(e, t) {
                for (var i = 0; i < t.length; i++) {
                    var n = t[i];
                    n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n)
                }
            }

            return function (t, i, n) {
                return i && e(t.prototype, i), n && e(t, n), t
            }
        }(), Z = /^(width|height|left|top|marginLeft|marginTop)$/, $ = Object.prototype, U = $.toString,
        _ = $.hasOwnProperty, G = Array.prototype.slice, J = {
            render: function () {
                var e = this;
                e.initContainer(), e.initViewer(), e.initList(), e.renderViewer()
            }, initContainer: function () {
                this.containerData = {width: window.innerWidth, height: window.innerHeight}
            }, initViewer: function () {
                var e = this, t = e.options, i = e.parent, n = void 0;
                t.inline && (e.parentData = n = {
                    width: Math.max(i.offsetWidth, t.minWidth),
                    height: Math.max(i.offsetHeight, t.minHeight)
                }), !e.fulled && n || (n = e.containerData), e.viewerData = v({}, n)
            }, renderViewer: function () {
                var e = this;
                e.options.inline && !e.fulled && m(e.viewer, e.viewerData)
            }, initList: function () {
                var e = this, i = e.options, n = e.element, r = e.list, o = [];
                d(e.images, function (e, n) {
                    var r = e.src, l = e.alt || F(r), s = i.url;
                    r && (t(s) ? s = e.getAttribute(s) : a(s) && (s = s.call(e, e)), o.push('<li><img src="' + r + '" role="button" data-action="view" data-index="' + n + '" data-original-url="' + (s || r) + '" alt="' + l + '"></li>'))
                }), r.innerHTML = o.join(""), d(C(r, "img"), function (t) {
                    k(t, "filled", !0), E(t, "load", f(e.loadImage, e), !0)
                }), e.items = C(r, "li"), i.transition && E(n, "viewed", function () {
                    p(r, "viewer-transition")
                }, !0)
            }, renderList: function (e) {
                var t = this, i = e || t.index, n = t.items[i].offsetWidth || 30, r = n + 1;
                m(t.list, {width: r * t.length, marginLeft: (t.viewerData.width - n) / 2 - r * i})
            }, resetList: function () {
                var e = this;
                M(e.list), g(e.list, "viewer-transition"), m({marginLeft: 0})
            }, initImage: function (e) {
                var t = this, i = t.options, n = t.image, r = t.viewerData, o = t.footer.offsetHeight, l = r.width,
                    s = Math.max(r.height - o, o), c = t.imageData || {};
                O(n, function (n, r) {
                    var o = n / r, u = l, d = s;
                    s * o > l ? d = l / o : u = s * o, u = Math.min(.9 * u, n), d = Math.min(.9 * d, r);
                    var f = {
                        naturalWidth: n,
                        naturalHeight: r,
                        aspectRatio: o,
                        ratio: u / n,
                        width: u,
                        height: d,
                        left: (l - u) / 2,
                        top: (s - d) / 2
                    }, m = v({}, f);
                    i.rotatable && (f.rotate = c.rotate || 0, m.rotate = 0), i.scalable && (f.scaleX = c.scaleX || 1, f.scaleY = c.scaleY || 1, m.scaleX = 1, m.scaleY = 1), t.imageData = f, t.initialImageData = m, a(e) && e()
                })
            }, renderImage: function (e) {
                var t = this, i = t.image, n = t.imageData, r = R(n);
                m(i, {
                    width: n.width,
                    height: n.height,
                    marginLeft: n.left,
                    marginTop: n.top,
                    WebkitTransform: r,
                    msTransform: r,
                    transform: r
                }), a(e) && (t.transitioning ? E(i, "transitionend", e, !0) : e())
            }, resetImage: function () {
                var e = this;
                e.image && (X(e.image), e.image = null)
            }
        }, Q = "undefined" != typeof window ? window.PointerEvent : null, ee = Q ? "pointerdown" : "touchstart mousedown",
        te = Q ? "pointermove" : "mousemove touchmove",
        ie = Q ? "pointerup pointercancel" : "touchend touchcancel mouseup", ne = {
            bind: function () {
                var e = this, t = e.options, i = e.element, n = e.viewer;
                a(t.view) && E(i, "view", t.view), a(t.viewed) && E(i, "viewed", t.viewed), E(n, "click", e.onClick = f(e.click, e)), E(n, "wheel mousewheel DOMMouseScroll", e.onWheel = f(e.wheel, e)), E(n, "dragstart", e.onDragstart = f(e.dragstart, e)), E(e.canvas, ee, e.onPointerdown = f(e.pointerdown, e)), E(document, te, e.onPointermove = f(e.pointermove, e)), E(document, ie, e.onPointerup = f(e.pointerup, e)), E(document, "keydown", e.onKeydown = f(e.keydown, e)), E(window, "resize", e.onResize = f(e.resize, e))
            }, unbind: function () {
                var e = this, t = e.options, i = e.element, n = e.viewer;
                a(t.view) && D(i, "view", t.view), a(t.viewed) && D(i, "viewed", t.viewed), D(n, "click", e.onClick), D(n, "wheel mousewheel DOMMouseScroll", e.onWheel), D(n, "dragstart", e.onDragstart), D(e.canvas, ee, e.onPointerdown), D(document, te, e.onPointermove), D(document, ie, e.onPointerup), D(document, "keydown", e.onKeydown), D(window, "resize", e.onResize)
            }
        }, re = {
            start: function (e) {
                var t = this, i = T(e), n = i.target;
                "img" === n.tagName.toLowerCase() && (t.target = n, t.show())
            }, click: function (e) {
                var t = this, i = T(e), n = i.target, r = x(n, "action"), o = t.imageData;
                switch (r) {
                    case"mix":
                        t.played ? t.stop() : t.options.inline ? t.fulled ? t.exit() : t.full() : t.hide();
                        break;
                    case"view":
                        t.view(x(n, "index"));
                        break;
                    case"zoom-in":
                        t.zoom(.1, !0);
                        break;
                    case"zoom-out":
                        t.zoom(-.1, !0);
                        break;
                    case"one-to-one":
                        t.toggle();
                        break;
                    case"reset":
                        t.reset();
                        break;
                    case"prev":
                        t.prev();
                        break;
                    case"play":
                        t.play();
                        break;
                    case"next":
                        t.next();
                        break;
                    case"rotate-left":
                        t.rotate(-90);
                        break;
                    case"rotate-right":
                        t.rotate(90);
                        break;
                    case"flip-horizontal":
                        t.scaleX(-o.scaleX || -1);
                        break;
                    case"flip-vertical":
                        t.scaleY(-o.scaleY || -1);
                        break;
                    default:
                        t.played && t.stop()
                }
            }, load: function () {
                var e = this, t = e.options, i = e.image, n = e.index, r = e.viewerData;
                e.timeout && (clearTimeout(e.timeout), e.timeout = !1), g(i, "viewer-invisible"), i.style.cssText = "width:0;height:0;margin-left:" + r.width / 2 + "px;margin-top:" + r.height / 2 + "px;max-width:none!important;visibility:visible;", e.initImage(function () {
                    b(i, "viewer-transition", t.transition), b(i, "viewer-move", t.movable), e.renderImage(function () {
                        e.viewed = !0, I(e.element, "viewed", {originalImage: e.images[n], index: n, image: i})
                    })
                })
            }, loadImage: function (e) {
                var t = T(e), i = t.target, n = i.parentNode, r = n.offsetWidth || 30, o = n.offsetHeight || 50,
                    a = !!x(i, "filled");
                O(i, function (e, t) {
                    var n = e / t, l = r, s = o;
                    o * n > r ? a ? l = o * n : s = r / n : a ? s = r / n : l = o * n, m(i, {
                        width: l,
                        height: s,
                        marginLeft: (r - l) / 2,
                        marginTop: (o - s) / 2
                    })
                })
            }, resize: function () {
                var e = this;
                e.initContainer(), e.initViewer(), e.renderViewer(), e.renderList(), e.viewed && e.initImage(function () {
                    e.renderImage()
                }), e.played && d(C(e.player, "img"), function (t) {
                    E(t, "load", f(e.loadImage, e), !0), I(t, "load")
                })
            }, wheel: function (e) {
                var t = this, i = T(e);
                if (t.viewed && (i.preventDefault(), !t.wheeling)) {
                    t.wheeling = !0, setTimeout(function () {
                        t.wheeling = !1
                    }, 50);
                    var n = Number(t.options.zoomRatio) || .1, r = 1;
                    i.deltaY ? r = i.deltaY > 0 ? 1 : -1 : i.wheelDelta ? r = -i.wheelDelta / 120 : i.detail && (r = i.detail > 0 ? 1 : -1), t.zoom(-r * n, !0, i)
                }
            }, keydown: function (e) {
                var t = this, i = T(e), n = t.options, r = i.keyCode || i.which || i.charCode;
                if (t.fulled && n.keyboard) switch (r) {
                    case 27:
                        t.played ? t.stop() : n.inline ? t.fulled && t.exit() : t.hide();
                        break;
                    case 32:
                        t.played && t.stop();
                        break;
                    case 37:
                        t.prev();
                        break;
                    case 38:
                        i.preventDefault(), t.zoom(n.zoomRatio, !0);
                        break;
                    case 39:
                        t.next();
                        break;
                    case 40:
                        i.preventDefault(), t.zoom(-n.zoomRatio, !0);
                        break;
                    case 48:
                    case 49:
                        (i.ctrlKey || i.shiftKey) && (i.preventDefault(), t.toggle())
                }
            }, dragstart: function (e) {
                "img" === e.target.tagName.toLowerCase() && e.preventDefault()
            }, pointerdown: function (e) {
                var t = this, i = t.options, n = t.pointers, r = T(e);
                if (t.viewed) {
                    r.changedTouches ? d(r.changedTouches, function (e) {
                        n[e.identifier] = q(e)
                    }) : n[r.pointerId || 0] = q(r);
                    var o = !!i.movable && "move";
                    Object.keys(n).length > 1 ? o = "zoom" : "touch" !== r.pointerType && "touchmove" !== r.type || !t.isSwitchable() || (o = "switch"), t.action = o
                }
            }, pointermove: function (e) {
                var t = this, i = t.options, n = t.pointers, r = T(e), o = t.action, a = t.image;
                t.viewed && o && (r.preventDefault(), r.changedTouches ? d(r.changedTouches, function (e) {
                    v(n[e.identifier], q(e, !0))
                }) : v(n[r.pointerId || 0], q(r, !0)), "move" === o && i.transition && w(a, "viewer-transition") && g(a, "viewer-transition"), t.change(r))
            }, pointerup: function (e) {
                var t = this, i = t.pointers, n = T(e), r = t.action;
                t.viewed && (n.changedTouches ? d(n.changedTouches, function (e) {
                    delete i[e.identifier]
                }) : delete i[n.pointerId || 0], r && ("move" === r && t.options.transition && p(t.image, "viewer-transition"), t.action = !1))
            }
        }, oe = {
            show: function () {
                var e = this, t = e.options, i = e.element;
                if (t.inline || e.transitioning) return e;
                if (e.ready || e.build(), a(t.show) && E(i, "show", t.show, !0), I(i, "show") === !1) return e;
                e.open();
                var n = e.viewer;
                return g(n, "viewer-hide"), E(i, "shown", function () {
                    e.view(e.target ? c(e.target, s(e.images)) : e.index), e.target = !1
                }, !0), t.transition ? (e.transitioning = !0, p(n, "viewer-transition"), A(n), E(n, "transitionend", f(e.shown, e), !0), p(n, "viewer-in")) : (p(n, "viewer-in"), e.shown()), e
            }, hide: function () {
                var e = this, t = e.options, i = e.element, n = e.viewer;
                return t.inline || e.transitioning || !e.visible ? e : (a(t.hide) && E(i, "hide", t.hide, !0), I(i, "hide") === !1 ? e : (e.viewed && t.transition ? (e.transitioning = !0, E(e.image, "transitionend", function () {
                    E(n, "transitionend", f(e.hidden, e), !0), g(n, "viewer-in")
                }, !0), e.zoomTo(0, !1, !1, !0)) : (g(n, "viewer-in"), e.hidden()), e))
            }, view: function (e) {
                var t = this, i = t.element, n = t.title, r = t.canvas;
                if (e = Number(e) || 0, !t.ready || !t.visible || t.played || e < 0 || e >= t.length || t.viewed && e === t.index) return t;
                var o = t.items[e], a = C(o, "img")[0], l = x(a, "originalUrl"), s = a.getAttribute("alt"),
                    c = document.createElement("img");
                return c.src = l, c.alt = s, I(i, "view", {
                    originalImage: t.images[e],
                    index: e,
                    image: c
                }) === !1 ? t : (t.image = c, t.viewed && g(t.items[t.index], "viewer-active"), p(o, "viewer-active"), t.viewed = !1, t.index = e, t.imageData = null, p(c, "viewer-invisible"), M(r), N(r, c), t.renderList(), M(n), E(i, "viewed", function () {
                    var e = t.imageData;
                    S(n, s + " (" + e.naturalWidth + " × " + e.naturalHeight + ")")
                }, !0), c.complete ? t.load() : (E(c, "load", f(t.load, t), !0), t.timeout && clearTimeout(t.timeout), t.timeout = setTimeout(function () {
                    g(c, "viewer-invisible"), t.timeout = !1
                }, 1e3)), t)
            }, prev: function () {
                var e = this;
                return e.view(Math.max(e.index - 1, 0)), e
            }, next: function () {
                var e = this;
                return e.view(Math.min(e.index + 1, e.length - 1)), e
            }, move: function (e, t) {
                var i = this, r = i.imageData;
                return i.moveTo(n(e) ? e : r.left + Number(e), n(t) ? t : r.top + Number(t)), i
            }, moveTo: function (e, t) {
                var r = this, o = r.imageData;
                if (n(t) && (t = e), e = Number(e), t = Number(t), r.viewed && !r.played && r.options.movable) {
                    var a = !1;
                    i(e) && (o.left = e, a = !0), i(t) && (o.top = t, a = !0), a && r.renderImage()
                }
                return r
            }, zoom: function (e, t, i) {
                var n = this, r = n.imageData;
                return e = Number(e), e = e < 0 ? 1 / (1 - e) : 1 + e, n.zoomTo(r.width * e / r.naturalWidth, t, i), n
            }, zoomTo: function (e, t, n, r) {
                var o = this, a = o.options, l = o.pointers, s = o.imageData;
                if (e = Math.max(0, e), i(e) && o.viewed && !o.played && (r || a.zoomable)) {
                    if (!r) {
                        var c = Math.max(.01, a.minZoomRatio), u = Math.min(100, a.maxZoomRatio);
                        e = Math.min(Math.max(e, c), u)
                    }
                    e > .95 && e < 1.05 && (e = 1);
                    var d = s.naturalWidth * e, v = s.naturalHeight * e;
                    if (n) {
                        var f = L(o.viewer), m = l && Object.keys(l).length ? H(l) : {pageX: n.pageX, pageY: n.pageY};
                        s.left -= (d - s.width) * ((m.pageX - f.left - s.left) / s.width), s.top -= (v - s.height) * ((m.pageY - f.top - s.top) / s.height)
                    } else s.left -= (d - s.width) / 2, s.top -= (v - s.height) / 2;
                    s.width = d, s.height = v, s.ratio = e, o.renderImage(), t && o.tooltip()
                }
                return o
            }, rotate: function (e) {
                var t = this;
                return t.rotateTo((t.imageData.rotate || 0) + Number(e)), t
            }, rotateTo: function (e) {
                var t = this, n = t.imageData;
                return e = Number(e), i(e) && t.viewed && !t.played && t.options.rotatable && (n.rotate = e, t.renderImage()), t
            }, scale: function (e, t) {
                var r = this, o = r.imageData;
                if (n(t) && (t = e), e = Number(e), t = Number(t), r.viewed && !r.played && r.options.scalable) {
                    var a = !1;
                    i(e) && (o.scaleX = e, a = !0), i(t) && (o.scaleY = t, a = !0), a && r.renderImage()
                }
                return r
            }, scaleX: function (e) {
                var t = this;
                return t.scale(e, t.imageData.scaleY), t
            }, scaleY: function (e) {
                var t = this;
                return t.scale(t.imageData.scaleX, e), t
            }, play: function () {
                var e = this, t = e.options, n = e.player, r = f(e.loadImage, e), o = [], a = 0, l = 0;
                return !e.visible || e.played ? e : (t.fullscreen && e.requestFullscreen(), e.played = !0, p(n, "viewer-show"), d(e.items, function (e, i) {
                    var s = C(e, "img")[0], c = document.createElement("img");
                    c.src = x(s, "originalUrl"), c.alt = s.getAttribute("alt"), a++, p(c, "viewer-fade"), b(c, "viewer-transition", t.transition), w(e, "viewer-active") && (p(c, "viewer-in"), l = i), o.push(c), E(c, "load", r, !0), N(n, c)
                }), i(t.interval) && t.interval > 0 && function () {
                    var i = function i() {
                        e.playing = setTimeout(function () {
                            g(o[l], "viewer-in"), l++, l = l < a ? l : 0, p(o[l], "viewer-in"), i()
                        }, t.interval)
                    };
                    a > 1 && i()
                }(), e)
            }, stop: function () {
                var e = this, t = e.player;
                return e.played ? (e.options.fullscreen && e.exitFullscreen(), e.played = !1, clearTimeout(e.playing), g(t, "viewer-show"), M(t), e) : e
            }, full: function () {
                var e = this, t = e.options, i = e.viewer, n = e.image, r = e.list;
                return !e.visible || e.played || e.fulled || !t.inline ? e : (e.fulled = !0, e.open(), p(e.button, "viewer-fullscreen-exit"), t.transition && (g(n, "viewer-transition"), g(r, "viewer-transition")), p(i, "viewer-fixed"), i.setAttribute("style", ""), m(i, {zIndex: t.zIndex}), e.initContainer(), e.viewerData = v({}, e.containerData), e.renderList(), e.initImage(function () {
                    e.renderImage(function () {
                        t.transition && setTimeout(function () {
                            p(n, "viewer-transition"), p(r, "viewer-transition")
                        }, 0)
                    })
                }), e)
            }, exit: function () {
                var e = this, t = e.options, i = e.viewer, n = e.image, r = e.list;
                return e.fulled ? (e.fulled = !1, e.close(), g(e.button, "viewer-fullscreen-exit"), t.transition && (g(n, "viewer-transition"), g(r, "viewer-transition")), g(i, "viewer-fixed"), m(i, {zIndex: t.zIndexInline}), e.viewerData = v({}, e.parentData), e.renderViewer(), e.renderList(), e.initImage(function () {
                    e.renderImage(function () {
                        t.transition && setTimeout(function () {
                            p(n, "viewer-transition"), p(r, "viewer-transition")
                        }, 0)
                    })
                }), e) : e
            }, tooltip: function () {
                var e = this, t = e.options, i = e.tooltipBox, n = e.imageData;
                return e.viewed && !e.played && t.tooltip ? (S(i, Math.round(100 * n.ratio) + "%"), e.tooltiping ? clearTimeout(e.tooltiping) : t.transition ? (e.fading && I(i, "transitionend"), p(i, "viewer-show"), p(i, "viewer-fade"), p(i, "viewer-transition"), A(i), p(i, "viewer-in")) : p(i, "viewer-show"), e.tooltiping = setTimeout(function () {
                    t.transition ? (E(i, "transitionend", function () {
                        g(i, "viewer-show"), g(i, "viewer-fade"), g(i, "viewer-transition"), e.fading = !1
                    }, !0), g(i, "viewer-in"), e.fading = !0) : g(i, "viewer-show"), e.tooltiping = !1
                }, 1e3), e) : e
            }, toggle: function () {
                var e = this;
                return 1 === e.imageData.ratio ? e.zoomTo(e.initialImageData.ratio, !0) : e.zoomTo(1, !0), e
            }, reset: function () {
                var e = this;
                return e.viewed && !e.played && (e.imageData = v({}, e.initialImageData), e.renderImage()), e
            }, update: function () {
                var e = this, t = [];
                if (e.isImg && !e.element.parentNode) return e.destroy();
                if (e.length = e.images.length, e.ready && (d(e.items, function (i, n) {
                    var r = C(i, "img")[0], o = e.images[n];
                    o ? o.src !== r.src && t.push(n) : t.push(n)
                }), m(e.list, {width: "auto"}), e.initList(), e.visible)) if (e.length) {
                    if (e.viewed) {
                        var i = c(e.index, t);
                        i >= 0 ? (e.viewed = !1, e.view(Math.max(e.index - (i + 1), 0))) : p(e.items[e.index], "viewer-active")
                    }
                } else e.image = null, e.viewed = !1, e.index = 0, e.imageData = null, M(e.canvas), M(e.title);
                return e
            }, destroy: function () {
                var e = this, t = e.element;
                return e.options.inline ? e.unbind() : (e.visible && e.unbind(), D(t, "click", e.onStart)), e.unbuild(), z(t, "viewer"), e
            }
        }, ae = {
            open: function () {
                var e = this.body;
                p(e, "viewer-open"), e.style.paddingRight = this.scrollbarWidth + "px"
            }, close: function () {
                var e = this.body;
                g(e, "viewer-open"), e.style.paddingRight = 0
            }, shown: function () {
                var e = this, t = e.options, i = e.element;
                e.transitioning = !1, e.fulled = !0, e.visible = !0, e.render(), e.bind(), a(t.shown) && E(i, "shown", t.shown, !0), I(i, "shown")
            }, hidden: function () {
                var e = this, t = e.options, i = e.element;
                e.transitioning = !1, e.viewed = !1, e.fulled = !1, e.visible = !1, e.unbind(), e.close(), p(e.viewer, "viewer-hide"), e.resetList(), e.resetImage(), a(t.hidden) && E(i, "hidden", t.hidden, !0), I(i, "hidden")
            }, requestFullscreen: function () {
                var e = this, t = document.documentElement;
                !e.fulled || document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement || (t.requestFullscreen ? t.requestFullscreen() : t.msRequestFullscreen ? t.msRequestFullscreen() : t.mozRequestFullScreen ? t.mozRequestFullScreen() : t.webkitRequestFullscreen && t.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT))
            }, exitFullscreen: function () {
                this.fulled && (document.exitFullscreen ? document.exitFullscreen() : document.msExitFullscreen ? document.msExitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitExitFullscreen && document.webkitExitFullscreen())
            }, change: function (e) {
                var t = this, i = t.pointers, n = i[Object.keys(i)[0]], r = n.endX - n.startX, o = n.endY - n.startY;
                switch (t.action) {
                    case"move":
                        t.move(r, o);
                        break;
                    case"zoom":
                        t.zoom(j(i), !1, e);
                        break;
                    case"switch":
                        t.action = "switched", Math.abs(r) > Math.abs(o) && (r > 1 ? t.prev() : r < -1 && t.next())
                }
                d(i, function (e) {
                    e.startX = e.endX, e.startY = e.endY
                })
            }, isSwitchable: function () {
                var e = this, t = e.imageData, i = e.viewerData;
                return e.length > 1 && t.left >= 0 && t.top >= 0 && t.width <= i.width && t.height <= i.height
            }
        }, le = void 0 !== document.createElement("viewer").style.transition, se = void 0, ce = function () {
            function e(t, i) {
                B(this, e);
                var n = this;
                n.element = t, n.options = v({}, P, o(i) && i), n.isImg = !1, n.ready = !1, n.visible = !1, n.viewed = !1, n.fulled = !1, n.played = !1, n.wheeling = !1, n.playing = !1, n.fading = !1, n.tooltiping = !1, n.transitioning = !1, n.action = !1, n.target = !1, n.timeout = !1, n.index = 0, n.length = 0, n.pointers = {}, n.init()
            }

            return K(e, [{
                key: "init", value: function () {
                    var e = this, t = e.options, i = e.element;
                    if (!x(i, "viewer")) {
                        k(i, "viewer", e);
                        var n = "img" === i.tagName.toLowerCase(), r = n ? [i] : C(i, "img"), o = r.length;
                        o && (a(t.ready) && E(i, "ready", t.ready, !0), le || (t.transition = !1), e.isImg = n, e.length = o, e.count = 0, e.images = r, e.body = document.body, e.scrollbarWidth = window.innerWidth - document.body.clientWidth, t.inline ? function () {
                            var t = f(e.progress, e);
                            E(i, "ready", function () {
                                e.view()
                            }, !0), d(r, function (e) {
                                e.complete ? t() : E(e, "load", t, !0)
                            })
                        }() : E(i, "click", e.onStart = f(e.start, e)))
                    }
                }
            }, {
                key: "progress", value: function () {
                    var e = this;
                    e.count++, e.count === e.length && e.build()
                }
            }, {
                key: "build", value: function () {
                    var e = this, t = e.options, i = e.element;
                    if (!e.ready) {
                        var n = document.createElement("div"), r = void 0, o = void 0, a = void 0, l = void 0, s = void 0,
                            c = void 0;
                        if (n.innerHTML = '<div class="viewer-container"><div class="viewer-canvas"></div><div class="viewer-footer"><div class="viewer-title"></div><ul class="viewer-toolbar"><li role="button" class="viewer-zoom-in" data-action="zoom-in"></li><li role="button" class="viewer-zoom-out" data-action="zoom-out"></li><li role="button" class="viewer-one-to-one" data-action="one-to-one"></li><li role="button" class="viewer-reset" data-action="reset"></li><li role="button" class="viewer-prev" data-action="prev"></li><li role="button" class="viewer-play" data-action="play"></li><li role="button" class="viewer-next" data-action="next"></li><li role="button" class="viewer-rotate-left" data-action="rotate-left"></li><li role="button" class="viewer-rotate-right" data-action="rotate-right"></li><li role="button" class="viewer-flip-horizontal" data-action="flip-horizontal"></li><li role="button" class="viewer-flip-vertical" data-action="flip-vertical"></li></ul><div class="viewer-navbar"><ul class="viewer-list"></ul></div></div><div class="viewer-tooltip"></div><div role="button" class="viewer-button" data-action="mix"></div><div class="viewer-player"></div></div>', e.parent = r = i.parentNode, e.viewer = o = Y(n, "viewer-container")[0], e.canvas = Y(o, "viewer-canvas")[0], e.footer = Y(o, "viewer-footer")[0], e.title = c = Y(o, "viewer-title")[0], e.toolbar = l = Y(o, "viewer-toolbar")[0], e.navbar = s = Y(o, "viewer-navbar")[0], e.button = a = Y(o, "viewer-button")[0], e.tooltipBox = Y(o, "viewer-tooltip")[0], e.player = Y(o, "viewer-player")[0], e.list = Y(o, "viewer-list")[0], p(c, t.title ? W(t.title) : "viewer-hide"), p(l, t.toolbar ? W(t.toolbar) : "viewer-hide"), p(s, t.navbar ? W(t.navbar) : "viewer-hide"), b(a, "viewer-hide", !t.button), b(l.querySelector(".viewer-one-to-one"), "viewer-invisible", !t.zoomable), b(l.querySelectorAll('li[class*="zoom"]'), "viewer-invisible", !t.zoomable), b(l.querySelectorAll('li[class*="flip"]'), "viewer-invisible", !t.scalable), !t.rotatable) {
                            var u = l.querySelectorAll('li[class*="rotate"]');
                            p(u, "viewer-invisible"), N(l, u)
                        }
                        t.inline ? (p(a, "viewer-fullscreen"), m(o, {zIndex: t.zIndexInline}), "static" === h(r).position && m(r, {position: "relative"}), r.insertBefore(o, i.nextSibling)) : (p(a, "viewer-close"), p(o, "viewer-fixed"), p(o, "viewer-fade"), p(o, "viewer-hide"), m(o, {zIndex: t.zIndex}), document.body.appendChild(o)), t.inline && (e.render(), e.bind(), e.visible = !0), e.ready = !0, I(i, "ready")
                    }
                }
            }, {
                key: "unbuild", value: function () {
                    var e = this;
                    e.ready && (e.ready = !1, X(e.viewer))
                }
            }], [{
                key: "noConflict", value: function () {
                    return window.Viewer = se, e
                }
            }, {
                key: "setDefaults", value: function (e) {
                    v(P, o(e) && e)
                }
            }]), e
        }();
    return v(ce.prototype, J), v(ce.prototype, ne), v(ce.prototype, re), v(ce.prototype, oe), v(ce.prototype, ae), "undefined" != typeof window && (se = window.Viewer, window.Viewer = ce), ce
});


(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery'), require('viewerjs')) :
        typeof define === 'function' && define.amd ? define(['jquery', 'viewerjs'], factory) :
            (factory(global.jQuery, global.Viewer));
}(this, (function ($, Viewer) {
    'use strict';

    $ = $ && $.hasOwnProperty('default') ? $['default'] : $;
    Viewer = Viewer && Viewer.hasOwnProperty('default') ? Viewer['default'] : Viewer;

    if ($.fn) {
        var AnotherViewer = $.fn.viewer;
        var NAMESPACE = 'viewer';

        $.fn.viewer = function jQueryViewer(option) {
            for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                args[_key - 1] = arguments[_key];
            }

            var result = void 0;

            this.each(function (i, element) {
                var $element = $(element);
                var isDestroy = option === 'destroy';
                var viewer = $element.data(NAMESPACE);

                if (!viewer) {
                    if (isDestroy) {
                        return;
                    }

                    var options = $.extend({}, $element.data(), $.isPlainObject(option) && option);

                    viewer = new Viewer(element, options);
                    $element.data(NAMESPACE, viewer);
                }

                if (typeof option === 'string') {
                    var fn = viewer[option];

                    if ($.isFunction(fn)) {
                        result = fn.apply(viewer, args);

                        if (result === viewer) {
                            result = undefined;
                        }

                        if (isDestroy) {
                            $element.removeData(NAMESPACE);
                        }
                    }
                }
            });

            return result !== undefined ? result : this;
        };

        $.fn.viewer.Constructor = Viewer;
        $.fn.viewer.setDefaults = Viewer.setDefaults;
        $.fn.viewer.noConflict = function noConflict() {
            $.fn.viewer = AnotherViewer;
            return this;
        };
    }

})));
