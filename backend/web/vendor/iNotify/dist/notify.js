/*! @wcjiang/notify v2.0.12 | MIT (c) 2018 kenny wang | http://jaywcjlove.github.io/iNotify */
!function (t, i) {
  "object" == typeof exports && "undefined" != typeof module ? module.exports = i() : "function" == typeof define && define.amd ? define(i) : t.Notify = i()
}(this, function () {
  "use strict";
  window.Notification && "granted" !== window.Notification.permission && window.Notification.requestPermission();
  var s = "", i = ["flash", "scroll"], r = {title: "iNotify !", body: "You have a new message.", openurl: ""};

  function e(t) {
    var i, e = document.createElement("audio");
    if ("[object Array]" === Object.prototype.toString.call(t) && 0 < t.length) for (var o = 0; o < t.length; o++) (i = document.createElement("source")).src = t[o], i.type = "audio/".concat(t[o].match(/\.([^\\.]+)$/)[1]), e.appendChild(i); else e.src = t;
    return e
  }

  function o(t, i) {
    var e = document.createElement("canvas"), o = document.getElementsByTagName("head")[0],
      n = document.createElement("link"), c = null;
    return e.height = 32, e.width = 32, (c = e.getContext("2d")).fillStyle = i.backgroundColor, c.fillRect(0, 0, 32, 32), c.textAlign = "center", c.font = '22px "helvetica", sans-serif', c.fillStyle = i.textColor, t && c.fillText(t, 16, 24), n.setAttribute("rel", "shortcut icon"), n.setAttribute("type", "image/x-icon"), n.setAttribute("id", "new".concat(i.id)), n.setAttribute("href", e.toDataURL("image/png")), s = e.toDataURL("image/png"), o.appendChild(n)
  }

  function t(t) {
    t && this.init(t)
  }

  return t.prototype = {
    init: function (t) {
      var i, e;
      return t || (t = {}), this.interval = t.interval || 100, this.effect = t.effect || "flash", this.title = t.title || document.title, this.message = t.message || this.title, this.onclick = t.onclick || this.onclick, this.openurl = t.openurl || this.openurl, this.updateFavicon = t.updateFavicon || {
        id: "favicon",
        textColor: "#fff",
        backgroundColor: "#2F9A00"
      }, this.audio = t.audio || "", this.favicon = (i = this.updateFavicon, (e = document.querySelectorAll("link[rel~=shortcut]")[0]) || (e = o("O", i)), e), this.cloneFavicon = this.favicon.cloneNode(!0), r.icon = s = t.notification && t.notification.icon ? t.notification.icon : t.icon ? t.icon : this.favicon.href, this.notification = t.notification || r, this.audio && this.audio.file && this.setURL(this.audio.file), this
    }, render: function () {
      if ("flash" === this.effect) document.title = this.title === document.title ? this.message : this.title; else if ("scroll" === this.effect) {
        var t = this.message || document.title;
        this.scrollTitle && this.scrollTitle.slice(1) ? (this.scrollTitle = this.scrollTitle.slice(1), document.title = this.scrollTitle) : (document.title = t, this.scrollTitle = t)
      }
      return this
    }, setTitle: function (t) {
      if (!0 === t) {
        if (0 <= i.indexOf(this.effect)) return this.addTimer()
      } else t ? (this.message = t, this.scrollTitle = "", this.addTimer()) : this.clearTimer();
      return this
    }, setURL: function (t) {
      return t && (this.audioElm && this.audioElm.remove(), this.audioElm = e(t), document.body.appendChild(this.audioElm)), this
    }, loopPlay: function () {
      return this.setURL(), this.audioElm.loop = !0, this.player(), this
    }, stopPlay: function () {
      return this.audioElm && (this.audioElm.loop = !1, this.audioElm.pause()), this
    }, player: function () {
      if (this.audio && this.audio.file) return this.audioElm || (this.audioElm = e(this.audio.file), document.body.appendChild(this.audioElm)), this.audioElm.play(), this
    }, notify: function (t) {
      var i = this.notification, e = t.openurl ? t.openurl : this.openurl, o = t.onclick ? t.onclick : this.onclick;
      if (window.Notification) {
        i = t ? function (t, i) {
          for (var e in i) t[e] && (i[e] = t[e]);
          return i
        }(t, i) : r;
        var n = {};
        n.icon = t.icon ? t.icon : s, n.body = i.body, t.dir && (n.dir = t.dir);
        var c = new Notification(i.title, n);
        c.onclick = function () {
          o && "function" == typeof o && o(c), e && window.open(e)
        }, c.onshow = function () {
          t.onshow && "function" == typeof t.onshow && t.onshow(c)
        }, c.onclose = function () {
          t.onclose && "function" == typeof t.onclose && t.onclose(c)
        }, c.onerror = function () {
          t.onerror && "function" == typeof t.onerror && t.onerror(c)
        }, this.Notifiy = c
      }
      return this
    }, isPermission: function () {
      return window.Notification && "granted" === Notification.permission
    }, setInterval: function (t) {
      return t && (this.interval = t, this.addTimer()), this
    }, setFavicon: function (t) {
      if (!t && 0 !== t) return this.faviconClear();
      var i = document.getElementById("new".concat(this.updateFavicon.id));
      return this.favicon && this.favicon.remove(), i && i.remove(), o(this.updateFavicon.num = t, this.updateFavicon), this
    }, setFaviconColor: function (t) {
      return t && (this.faviconRemove(), this.updateFavicon.textColor = t, o(this.updateFavicon.num, this.updateFavicon)), this
    }, setFaviconBackgroundColor: function (t) {
      return t && (this.faviconRemove(), this.updateFavicon.backgroundColor = t, o(this.updateFavicon.num, this.updateFavicon)), this
    }, faviconRemove: function () {
      this.faviconClear();
      var t = document.getElementById("new".concat(this.updateFavicon.id));
      this.favicon && this.favicon.remove(), t && t.remove()
    }, addTimer: function () {
      return this.clearTimer(), i.indexOf(this.effect) < 0 || (this.timer = setInterval(this.render.bind(this), this.interval)), this
    }, close: function () {
      this.Notifiy && this.Notifiy.close()
    }, faviconClear: function () {
      var t = document.getElementById("new".concat(this.updateFavicon.id)),
        i = document.getElementsByTagName("head")[0], e = document.querySelectorAll("link[rel~=shortcut]");
      if (t && t.remove(), 0 < e.length) for (var o = 0; o < e.length; o++) e[o].remove();
      return i.appendChild(this.cloneFavicon), s = this.cloneFavicon.href, this.favicon = this.cloneFavicon, this
    }, clearTimer: function () {
      return this.timer && clearInterval(this.timer), document.title = this.title, this
    }
  }, t
});
