/*! jQuery v3.4.1 | (c) JS Foundation and other contributors | jquery.org/license */ ! function(e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function(C, e) {
    "use strict";
    var t = [],
        E = C.document,
        r = Object.getPrototypeOf,
        s = t.slice,
        g = t.concat,
        u = t.push,
        i = t.indexOf,
        n = {},
        o = n.toString,
        v = n.hasOwnProperty,
        a = v.toString,
        l = a.call(Object),
        y = {},
        m = function(e) {
            return "function" == typeof e && "number" != typeof e.nodeType
        },
        x = function(e) {
            return null != e && e === e.window
        },
        c = {
            type: !0,
            src: !0,
            nonce: !0,
            noModule: !0
        };

    function b(e, t, n) {
        var r, i, o = (n = n || E).createElement("script");
        if (o.text = e, t)
            for (r in c)(i = t[r] || t.getAttribute && t.getAttribute(r)) && o.setAttribute(r, i);
        n.head.appendChild(o).parentNode.removeChild(o)
    }

    function w(e) {
        return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? n[o.call(e)] || "object" : typeof e
    }
    var f = "3.4.1",
        k = function(e, t) {
            return new k.fn.init(e, t)
        },
        p = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;

    function d(e) {
        var t = !!e && "length" in e && e.length,
            n = w(e);
        return !m(e) && !x(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }
    k.fn = k.prototype = {
        jquery: f,
        constructor: k,
        length: 0,
        toArray: function() {
            return s.call(this)
        },
        get: function(e) {
            return null == e ? s.call(this) : e < 0 ? this[e + this.length] : this[e]
        },
        pushStack: function(e) {
            var t = k.merge(this.constructor(), e);
            return t.prevObject = this, t
        },
        each: function(e) {
            return k.each(this, e)
        },
        map: function(n) {
            return this.pushStack(k.map(this, function(e, t) {
                return n.call(e, t, e)
            }))
        },
        slice: function() {
            return this.pushStack(s.apply(this, arguments))
        },
        first: function() {
            return this.eq(0)
        },
        last: function() {
            return this.eq(-1)
        },
        eq: function(e) {
            var t = this.length,
                n = +e + (e < 0 ? t : 0);
            return this.pushStack(0 <= n && n < t ? [this[n]] : [])
        },
        end: function() {
            return this.prevObject || this.constructor()
        },
        push: u,
        sort: t.sort,
        splice: t.splice
    }, k.extend = k.fn.extend = function() {
        var e, t, n, r, i, o, a = arguments[0] || {},
            s = 1,
            u = arguments.length,
            l = !1;
        for ("boolean" == typeof a && (l = a, a = arguments[s] || {}, s++), "object" == typeof a || m(a) || (a = {}), s === u && (a = this, s--); s < u; s++)
            if (null != (e = arguments[s]))
                for (t in e) r = e[t], "__proto__" !== t && a !== r && (l && r && (k.isPlainObject(r) || (i = Array.isArray(r))) ? (n = a[t], o = i && !Array.isArray(n) ? [] : i || k.isPlainObject(n) ? n : {}, i = !1, a[t] = k.extend(l, o, r)) : void 0 !== r && (a[t] = r));
        return a
    }, k.extend({
        expando: "jQuery" + (f + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(e) {
            throw new Error(e)
        },
        noop: function() {},
        isPlainObject: function(e) {
            var t, n;
            return !(!e || "[object Object]" !== o.call(e)) && (!(t = r(e)) || "function" == typeof(n = v.call(t, "constructor") && t.constructor) && a.call(n) === l)
        },
        isEmptyObject: function(e) {
            var t;
            for (t in e) return !1;
            return !0
        },
        globalEval: function(e, t) {
            b(e, {
                nonce: t && t.nonce
            })
        },
        each: function(e, t) {
            var n, r = 0;
            if (d(e)) {
                for (n = e.length; r < n; r++)
                    if (!1 === t.call(e[r], r, e[r])) break
            } else
                for (r in e)
                    if (!1 === t.call(e[r], r, e[r])) break;
            return e
        },
        trim: function(e) {
            return null == e ? "" : (e + "").replace(p, "")
        },
        makeArray: function(e, t) {
            var n = t || [];
            return null != e && (d(Object(e)) ? k.merge(n, "string" == typeof e ? [e] : e) : u.call(n, e)), n
        },
        inArray: function(e, t, n) {
            return null == t ? -1 : i.call(t, e, n)
        },
        merge: function(e, t) {
            for (var n = +t.length, r = 0, i = e.length; r < n; r++) e[i++] = t[r];
            return e.length = i, e
        },
        grep: function(e, t, n) {
            for (var r = [], i = 0, o = e.length, a = !n; i < o; i++) !t(e[i], i) !== a && r.push(e[i]);
            return r
        },
        map: function(e, t, n) {
            var r, i, o = 0,
                a = [];
            if (d(e))
                for (r = e.length; o < r; o++) null != (i = t(e[o], o, n)) && a.push(i);
            else
                for (o in e) null != (i = t(e[o], o, n)) && a.push(i);
            return g.apply([], a)
        },
        guid: 1,
        support: y
    }), "function" == typeof Symbol && (k.fn[Symbol.iterator] = t[Symbol.iterator]), k.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(e, t) {
        n["[object " + t + "]"] = t.toLowerCase()
    });
    var h = function(n) {
        var e, d, b, o, i, h, f, g, w, u, l, T, C, a, E, v, s, c, y, k = "sizzle" + 1 * new Date,
            m = n.document,
            S = 0,
            r = 0,
            p = ue(),
            x = ue(),
            N = ue(),
            A = ue(),
            D = function(e, t) {
                return e === t && (l = !0), 0
            },
            j = {}.hasOwnProperty,
            t = [],
            q = t.pop,
            L = t.push,
            H = t.push,
            O = t.slice,
            P = function(e, t) {
                for (var n = 0, r = e.length; n < r; n++)
                    if (e[n] === t) return n;
                return -1
            },
            R = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            M = "[\\x20\\t\\r\\n\\f]",
            I = "(?:\\\\.|[\\w-]|[^\0-\\xa0])+",
            W = "\\[" + M + "*(" + I + ")(?:" + M + "*([*^$|!~]?=)" + M + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + I + "))|)" + M + "*\\]",
            $ = ":(" + I + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + W + ")*)|.*)\\)|)",
            F = new RegExp(M + "+", "g"),
            B = new RegExp("^" + M + "+|((?:^|[^\\\\])(?:\\\\.)*)" + M + "+$", "g"),
            _ = new RegExp("^" + M + "*," + M + "*"),
            z = new RegExp("^" + M + "*([>+~]|" + M + ")" + M + "*"),
            U = new RegExp(M + "|>"),
            X = new RegExp($),
            V = new RegExp("^" + I + "$"),
            G = {
                ID: new RegExp("^#(" + I + ")"),
                CLASS: new RegExp("^\\.(" + I + ")"),
                TAG: new RegExp("^(" + I + "|[*])"),
                ATTR: new RegExp("^" + W),
                PSEUDO: new RegExp("^" + $),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + M + "*(even|odd|(([+-]|)(\\d*)n|)" + M + "*(?:([+-]|)" + M + "*(\\d+)|))" + M + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + R + ")$", "i"),
                needsContext: new RegExp("^" + M + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + M + "*((?:-\\d)?\\d*)" + M + "*\\)|)(?=[^-]|$)", "i")
            },
            Y = /HTML$/i,
            Q = /^(?:input|select|textarea|button)$/i,
            J = /^h\d$/i,
            K = /^[^{]+\{\s*\[native \w/,
            Z = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            ee = /[+~]/,
            te = new RegExp("\\\\([\\da-f]{1,6}" + M + "?|(" + M + ")|.)", "ig"),
            ne = function(e, t, n) {
                var r = "0x" + t - 65536;
                return r != r || n ? t : r < 0 ? String.fromCharCode(r + 65536) : String.fromCharCode(r >> 10 | 55296, 1023 & r | 56320)
            },
            re = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            ie = function(e, t) {
                return t ? "\0" === e ? "\ufffd" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
            },
            oe = function() {
                T()
            },
            ae = be(function(e) {
                return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
            }, {
                dir: "parentNode",
                next: "legend"
            });
        try {
            H.apply(t = O.call(m.childNodes), m.childNodes), t[m.childNodes.length].nodeType
        } catch (e) {
            H = {
                apply: t.length ? function(e, t) {
                    L.apply(e, O.call(t))
                } : function(e, t) {
                    var n = e.length,
                        r = 0;
                    while (e[n++] = t[r++]);
                    e.length = n - 1
                }
            }
        }

        function se(t, e, n, r) {
            var i, o, a, s, u, l, c, f = e && e.ownerDocument,
                p = e ? e.nodeType : 9;
            if (n = n || [], "string" != typeof t || !t || 1 !== p && 9 !== p && 11 !== p) return n;
            if (!r && ((e ? e.ownerDocument || e : m) !== C && T(e), e = e || C, E)) {
                if (11 !== p && (u = Z.exec(t)))
                    if (i = u[1]) {
                        if (9 === p) {
                            if (!(a = e.getElementById(i))) return n;
                            if (a.id === i) return n.push(a), n
                        } else if (f && (a = f.getElementById(i)) && y(e, a) && a.id === i) return n.push(a), n
                    } else {
                        if (u[2]) return H.apply(n, e.getElementsByTagName(t)), n;
                        if ((i = u[3]) && d.getElementsByClassName && e.getElementsByClassName) return H.apply(n, e.getElementsByClassName(i)), n
                    }
                if (d.qsa && !A[t + " "] && (!v || !v.test(t)) && (1 !== p || "object" !== e.nodeName.toLowerCase())) {
                    if (c = t, f = e, 1 === p && U.test(t)) {
                        (s = e.getAttribute("id")) ? s = s.replace(re, ie): e.setAttribute("id", s = k), o = (l = h(t)).length;
                        while (o--) l[o] = "#" + s + " " + xe(l[o]);
                        c = l.join(","), f = ee.test(t) && ye(e.parentNode) || e
                    }
                    try {
                        return H.apply(n, f.querySelectorAll(c)), n
                    } catch (e) {
                        A(t, !0)
                    } finally {
                        s === k && e.removeAttribute("id")
                    }
                }
            }
            return g(t.replace(B, "$1"), e, n, r)
        }

        function ue() {
            var r = [];
            return function e(t, n) {
                return r.push(t + " ") > b.cacheLength && delete e[r.shift()], e[t + " "] = n
            }
        }

        function le(e) {
            return e[k] = !0, e
        }

        function ce(e) {
            var t = C.createElement("fieldset");
            try {
                return !!e(t)
            } catch (e) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function fe(e, t) {
            var n = e.split("|"),
                r = n.length;
            while (r--) b.attrHandle[n[r]] = t
        }

        function pe(e, t) {
            var n = t && e,
                r = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex - t.sourceIndex;
            if (r) return r;
            if (n)
                while (n = n.nextSibling)
                    if (n === t) return -1;
            return e ? 1 : -1
        }

        function de(t) {
            return function(e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t
            }
        }

        function he(n) {
            return function(e) {
                var t = e.nodeName.toLowerCase();
                return ("input" === t || "button" === t) && e.type === n
            }
        }

        function ge(t) {
            return function(e) {
                return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && ae(e) === t : e.disabled === t : "label" in e && e.disabled === t
            }
        }

        function ve(a) {
            return le(function(o) {
                return o = +o, le(function(e, t) {
                    var n, r = a([], e.length, o),
                        i = r.length;
                    while (i--) e[n = r[i]] && (e[n] = !(t[n] = e[n]))
                })
            })
        }

        function ye(e) {
            return e && "undefined" != typeof e.getElementsByTagName && e
        }
        for (e in d = se.support = {}, i = se.isXML = function(e) {
                var t = e.namespaceURI,
                    n = (e.ownerDocument || e).documentElement;
                return !Y.test(t || n && n.nodeName || "HTML")
            }, T = se.setDocument = function(e) {
                var t, n, r = e ? e.ownerDocument || e : m;
                return r !== C && 9 === r.nodeType && r.documentElement && (a = (C = r).documentElement, E = !i(C), m !== C && (n = C.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", oe, !1) : n.attachEvent && n.attachEvent("onunload", oe)), d.attributes = ce(function(e) {
                    return e.className = "i", !e.getAttribute("className")
                }), d.getElementsByTagName = ce(function(e) {
                    return e.appendChild(C.createComment("")), !e.getElementsByTagName("*").length
                }), d.getElementsByClassName = K.test(C.getElementsByClassName), d.getById = ce(function(e) {
                    return a.appendChild(e).id = k, !C.getElementsByName || !C.getElementsByName(k).length
                }), d.getById ? (b.filter.ID = function(e) {
                    var t = e.replace(te, ne);
                    return function(e) {
                        return e.getAttribute("id") === t
                    }
                }, b.find.ID = function(e, t) {
                    if ("undefined" != typeof t.getElementById && E) {
                        var n = t.getElementById(e);
                        return n ? [n] : []
                    }
                }) : (b.filter.ID = function(e) {
                    var n = e.replace(te, ne);
                    return function(e) {
                        var t = "undefined" != typeof e.getAttributeNode && e.getAttributeNode("id");
                        return t && t.value === n
                    }
                }, b.find.ID = function(e, t) {
                    if ("undefined" != typeof t.getElementById && E) {
                        var n, r, i, o = t.getElementById(e);
                        if (o) {
                            if ((n = o.getAttributeNode("id")) && n.value === e) return [o];
                            i = t.getElementsByName(e), r = 0;
                            while (o = i[r++])
                                if ((n = o.getAttributeNode("id")) && n.value === e) return [o]
                        }
                        return []
                    }
                }), b.find.TAG = d.getElementsByTagName ? function(e, t) {
                    return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(e) : d.qsa ? t.querySelectorAll(e) : void 0
                } : function(e, t) {
                    var n, r = [],
                        i = 0,
                        o = t.getElementsByTagName(e);
                    if ("*" === e) {
                        while (n = o[i++]) 1 === n.nodeType && r.push(n);
                        return r
                    }
                    return o
                }, b.find.CLASS = d.getElementsByClassName && function(e, t) {
                    if ("undefined" != typeof t.getElementsByClassName && E) return t.getElementsByClassName(e)
                }, s = [], v = [], (d.qsa = K.test(C.querySelectorAll)) && (ce(function(e) {
                    a.appendChild(e).innerHTML = "<a id='" + k + "'></a><select id='" + k + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && v.push("[*^$]=" + M + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || v.push("\\[" + M + "*(?:value|" + R + ")"), e.querySelectorAll("[id~=" + k + "-]").length || v.push("~="), e.querySelectorAll(":checked").length || v.push(":checked"), e.querySelectorAll("a#" + k + "+*").length || v.push(".#.+[+~]")
                }), ce(function(e) {
                    e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                    var t = C.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && v.push("name" + M + "*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && v.push(":enabled", ":disabled"), a.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && v.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), v.push(",.*:")
                })), (d.matchesSelector = K.test(c = a.matches || a.webkitMatchesSelector || a.mozMatchesSelector || a.oMatchesSelector || a.msMatchesSelector)) && ce(function(e) {
                    d.disconnectedMatch = c.call(e, "*"), c.call(e, "[s!='']:x"), s.push("!=", $)
                }), v = v.length && new RegExp(v.join("|")), s = s.length && new RegExp(s.join("|")), t = K.test(a.compareDocumentPosition), y = t || K.test(a.contains) ? function(e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                        r = t && t.parentNode;
                    return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
                } : function(e, t) {
                    if (t)
                        while (t = t.parentNode)
                            if (t === e) return !0;
                    return !1
                }, D = t ? function(e, t) {
                    if (e === t) return l = !0, 0;
                    var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
                    return n || (1 & (n = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !d.sortDetached && t.compareDocumentPosition(e) === n ? e === C || e.ownerDocument === m && y(m, e) ? -1 : t === C || t.ownerDocument === m && y(m, t) ? 1 : u ? P(u, e) - P(u, t) : 0 : 4 & n ? -1 : 1)
                } : function(e, t) {
                    if (e === t) return l = !0, 0;
                    var n, r = 0,
                        i = e.parentNode,
                        o = t.parentNode,
                        a = [e],
                        s = [t];
                    if (!i || !o) return e === C ? -1 : t === C ? 1 : i ? -1 : o ? 1 : u ? P(u, e) - P(u, t) : 0;
                    if (i === o) return pe(e, t);
                    n = e;
                    while (n = n.parentNode) a.unshift(n);
                    n = t;
                    while (n = n.parentNode) s.unshift(n);
                    while (a[r] === s[r]) r++;
                    return r ? pe(a[r], s[r]) : a[r] === m ? -1 : s[r] === m ? 1 : 0
                }), C
            }, se.matches = function(e, t) {
                return se(e, null, null, t)
            }, se.matchesSelector = function(e, t) {
                if ((e.ownerDocument || e) !== C && T(e), d.matchesSelector && E && !A[t + " "] && (!s || !s.test(t)) && (!v || !v.test(t))) try {
                    var n = c.call(e, t);
                    if (n || d.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
                } catch (e) {
                    A(t, !0)
                }
                return 0 < se(t, C, null, [e]).length
            }, se.contains = function(e, t) {
                return (e.ownerDocument || e) !== C && T(e), y(e, t)
            }, se.attr = function(e, t) {
                (e.ownerDocument || e) !== C && T(e);
                var n = b.attrHandle[t.toLowerCase()],
                    r = n && j.call(b.attrHandle, t.toLowerCase()) ? n(e, t, !E) : void 0;
                return void 0 !== r ? r : d.attributes || !E ? e.getAttribute(t) : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
            }, se.escape = function(e) {
                return (e + "").replace(re, ie)
            }, se.error = function(e) {
                throw new Error("Syntax error, unrecognized expression: " + e)
            }, se.uniqueSort = function(e) {
                var t, n = [],
                    r = 0,
                    i = 0;
                if (l = !d.detectDuplicates, u = !d.sortStable && e.slice(0), e.sort(D), l) {
                    while (t = e[i++]) t === e[i] && (r = n.push(i));
                    while (r--) e.splice(n[r], 1)
                }
                return u = null, e
            }, o = se.getText = function(e) {
                var t, n = "",
                    r = 0,
                    i = e.nodeType;
                if (i) {
                    if (1 === i || 9 === i || 11 === i) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += o(e)
                    } else if (3 === i || 4 === i) return e.nodeValue
                } else
                    while (t = e[r++]) n += o(t);
                return n
            }, (b = se.selectors = {
                cacheLength: 50,
                createPseudo: le,
                match: G,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function(e) {
                        return e[1] = e[1].replace(te, ne), e[3] = (e[3] || e[4] || e[5] || "").replace(te, ne), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    },
                    CHILD: function(e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || se.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && se.error(e[0]), e
                    },
                    PSEUDO: function(e) {
                        var t, n = !e[6] && e[2];
                        return G.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && X.test(n) && (t = h(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function(e) {
                        var t = e.replace(te, ne).toLowerCase();
                        return "*" === e ? function() {
                            return !0
                        } : function(e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    },
                    CLASS: function(e) {
                        var t = p[e + " "];
                        return t || (t = new RegExp("(^|" + M + ")" + e + "(" + M + "|$)")) && p(e, function(e) {
                            return t.test("string" == typeof e.className && e.className || "undefined" != typeof e.getAttribute && e.getAttribute("class") || "")
                        })
                    },
                    ATTR: function(n, r, i) {
                        return function(e) {
                            var t = se.attr(e, n);
                            return null == t ? "!=" === r : !r || (t += "", "=" === r ? t === i : "!=" === r ? t !== i : "^=" === r ? i && 0 === t.indexOf(i) : "*=" === r ? i && -1 < t.indexOf(i) : "$=" === r ? i && t.slice(-i.length) === i : "~=" === r ? -1 < (" " + t.replace(F, " ") + " ").indexOf(i) : "|=" === r && (t === i || t.slice(0, i.length + 1) === i + "-"))
                        }
                    },
                    CHILD: function(h, e, t, g, v) {
                        var y = "nth" !== h.slice(0, 3),
                            m = "last" !== h.slice(-4),
                            x = "of-type" === e;
                        return 1 === g && 0 === v ? function(e) {
                            return !!e.parentNode
                        } : function(e, t, n) {
                            var r, i, o, a, s, u, l = y !== m ? "nextSibling" : "previousSibling",
                                c = e.parentNode,
                                f = x && e.nodeName.toLowerCase(),
                                p = !n && !x,
                                d = !1;
                            if (c) {
                                if (y) {
                                    while (l) {
                                        a = e;
                                        while (a = a[l])
                                            if (x ? a.nodeName.toLowerCase() === f : 1 === a.nodeType) return !1;
                                        u = l = "only" === h && !u && "nextSibling"
                                    }
                                    return !0
                                }
                                if (u = [m ? c.firstChild : c.lastChild], m && p) {
                                    d = (s = (r = (i = (o = (a = c)[k] || (a[k] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] || [])[0] === S && r[1]) && r[2], a = s && c.childNodes[s];
                                    while (a = ++s && a && a[l] || (d = s = 0) || u.pop())
                                        if (1 === a.nodeType && ++d && a === e) {
                                            i[h] = [S, s, d];
                                            break
                                        }
                                } else if (p && (d = s = (r = (i = (o = (a = e)[k] || (a[k] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] || [])[0] === S && r[1]), !1 === d)
                                    while (a = ++s && a && a[l] || (d = s = 0) || u.pop())
                                        if ((x ? a.nodeName.toLowerCase() === f : 1 === a.nodeType) && ++d && (p && ((i = (o = a[k] || (a[k] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] = [S, d]), a === e)) break;
                                return (d -= v) === g || d % g == 0 && 0 <= d / g
                            }
                        }
                    },
                    PSEUDO: function(e, o) {
                        var t, a = b.pseudos[e] || b.setFilters[e.toLowerCase()] || se.error("unsupported pseudo: " + e);
                        return a[k] ? a(o) : 1 < a.length ? (t = [e, e, "", o], b.setFilters.hasOwnProperty(e.toLowerCase()) ? le(function(e, t) {
                            var n, r = a(e, o),
                                i = r.length;
                            while (i--) e[n = P(e, r[i])] = !(t[n] = r[i])
                        }) : function(e) {
                            return a(e, 0, t)
                        }) : a
                    }
                },
                pseudos: {
                    not: le(function(e) {
                        var r = [],
                            i = [],
                            s = f(e.replace(B, "$1"));
                        return s[k] ? le(function(e, t, n, r) {
                            var i, o = s(e, null, r, []),
                                a = e.length;
                            while (a--)(i = o[a]) && (e[a] = !(t[a] = i))
                        }) : function(e, t, n) {
                            return r[0] = e, s(r, null, n, i), r[0] = null, !i.pop()
                        }
                    }),
                    has: le(function(t) {
                        return function(e) {
                            return 0 < se(t, e).length
                        }
                    }),
                    contains: le(function(t) {
                        return t = t.replace(te, ne),
                            function(e) {
                                return -1 < (e.textContent || o(e)).indexOf(t)
                            }
                    }),
                    lang: le(function(n) {
                        return V.test(n || "") || se.error("unsupported lang: " + n), n = n.replace(te, ne).toLowerCase(),
                            function(e) {
                                var t;
                                do {
                                    if (t = E ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n + "-")
                                } while ((e = e.parentNode) && 1 === e.nodeType);
                                return !1
                            }
                    }),
                    target: function(e) {
                        var t = n.location && n.location.hash;
                        return t && t.slice(1) === e.id
                    },
                    root: function(e) {
                        return e === a
                    },
                    focus: function(e) {
                        return e === C.activeElement && (!C.hasFocus || C.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    },
                    enabled: ge(!1),
                    disabled: ge(!0),
                    checked: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    },
                    selected: function(e) {
                        return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                    },
                    empty: function(e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeType < 6) return !1;
                        return !0
                    },
                    parent: function(e) {
                        return !b.pseudos.empty(e)
                    },
                    header: function(e) {
                        return J.test(e.nodeName)
                    },
                    input: function(e) {
                        return Q.test(e.nodeName)
                    },
                    button: function(e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    },
                    text: function(e) {
                        var t;
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                    },
                    first: ve(function() {
                        return [0]
                    }),
                    last: ve(function(e, t) {
                        return [t - 1]
                    }),
                    eq: ve(function(e, t, n) {
                        return [n < 0 ? n + t : n]
                    }),
                    even: ve(function(e, t) {
                        for (var n = 0; n < t; n += 2) e.push(n);
                        return e
                    }),
                    odd: ve(function(e, t) {
                        for (var n = 1; n < t; n += 2) e.push(n);
                        return e
                    }),
                    lt: ve(function(e, t, n) {
                        for (var r = n < 0 ? n + t : t < n ? t : n; 0 <= --r;) e.push(r);
                        return e
                    }),
                    gt: ve(function(e, t, n) {
                        for (var r = n < 0 ? n + t : n; ++r < t;) e.push(r);
                        return e
                    })
                }
            }).pseudos.nth = b.pseudos.eq, {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) b.pseudos[e] = de(e);
        for (e in {
                submit: !0,
                reset: !0
            }) b.pseudos[e] = he(e);

        function me() {}

        function xe(e) {
            for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
            return r
        }

        function be(s, e, t) {
            var u = e.dir,
                l = e.next,
                c = l || u,
                f = t && "parentNode" === c,
                p = r++;
            return e.first ? function(e, t, n) {
                while (e = e[u])
                    if (1 === e.nodeType || f) return s(e, t, n);
                return !1
            } : function(e, t, n) {
                var r, i, o, a = [S, p];
                if (n) {
                    while (e = e[u])
                        if ((1 === e.nodeType || f) && s(e, t, n)) return !0
                } else
                    while (e = e[u])
                        if (1 === e.nodeType || f)
                            if (i = (o = e[k] || (e[k] = {}))[e.uniqueID] || (o[e.uniqueID] = {}), l && l === e.nodeName.toLowerCase()) e = e[u] || e;
                            else {
                                if ((r = i[c]) && r[0] === S && r[1] === p) return a[2] = r[2];
                                if ((i[c] = a)[2] = s(e, t, n)) return !0
                            } return !1
            }
        }

        function we(i) {
            return 1 < i.length ? function(e, t, n) {
                var r = i.length;
                while (r--)
                    if (!i[r](e, t, n)) return !1;
                return !0
            } : i[0]
        }

        function Te(e, t, n, r, i) {
            for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++)(o = e[s]) && (n && !n(o, r, i) || (a.push(o), l && t.push(s)));
            return a
        }

        function Ce(d, h, g, v, y, e) {
            return v && !v[k] && (v = Ce(v)), y && !y[k] && (y = Ce(y, e)), le(function(e, t, n, r) {
                var i, o, a, s = [],
                    u = [],
                    l = t.length,
                    c = e || function(e, t, n) {
                        for (var r = 0, i = t.length; r < i; r++) se(e, t[r], n);
                        return n
                    }(h || "*", n.nodeType ? [n] : n, []),
                    f = !d || !e && h ? c : Te(c, s, d, n, r),
                    p = g ? y || (e ? d : l || v) ? [] : t : f;
                if (g && g(f, p, n, r), v) {
                    i = Te(p, u), v(i, [], n, r), o = i.length;
                    while (o--)(a = i[o]) && (p[u[o]] = !(f[u[o]] = a))
                }
                if (e) {
                    if (y || d) {
                        if (y) {
                            i = [], o = p.length;
                            while (o--)(a = p[o]) && i.push(f[o] = a);
                            y(null, p = [], i, r)
                        }
                        o = p.length;
                        while (o--)(a = p[o]) && -1 < (i = y ? P(e, a) : s[o]) && (e[i] = !(t[i] = a))
                    }
                } else p = Te(p === t ? p.splice(l, p.length) : p), y ? y(null, t, p, r) : H.apply(t, p)
            })
        }

        function Ee(e) {
            for (var i, t, n, r = e.length, o = b.relative[e[0].type], a = o || b.relative[" "], s = o ? 1 : 0, u = be(function(e) {
                    return e === i
                }, a, !0), l = be(function(e) {
                    return -1 < P(i, e)
                }, a, !0), c = [function(e, t, n) {
                    var r = !o && (n || t !== w) || ((i = t).nodeType ? u(e, t, n) : l(e, t, n));
                    return i = null, r
                }]; s < r; s++)
                if (t = b.relative[e[s].type]) c = [be(we(c), t)];
                else {
                    if ((t = b.filter[e[s].type].apply(null, e[s].matches))[k]) {
                        for (n = ++s; n < r; n++)
                            if (b.relative[e[n].type]) break;
                        return Ce(1 < s && we(c), 1 < s && xe(e.slice(0, s - 1).concat({
                            value: " " === e[s - 2].type ? "*" : ""
                        })).replace(B, "$1"), t, s < n && Ee(e.slice(s, n)), n < r && Ee(e = e.slice(n)), n < r && xe(e))
                    }
                    c.push(t)
                }
            return we(c)
        }
        return me.prototype = b.filters = b.pseudos, b.setFilters = new me, h = se.tokenize = function(e, t) {
            var n, r, i, o, a, s, u, l = x[e + " "];
            if (l) return t ? 0 : l.slice(0);
            a = e, s = [], u = b.preFilter;
            while (a) {
                for (o in n && !(r = _.exec(a)) || (r && (a = a.slice(r[0].length) || a), s.push(i = [])), n = !1, (r = z.exec(a)) && (n = r.shift(), i.push({
                        value: n,
                        type: r[0].replace(B, " ")
                    }), a = a.slice(n.length)), b.filter) !(r = G[o].exec(a)) || u[o] && !(r = u[o](r)) || (n = r.shift(), i.push({
                    value: n,
                    type: o,
                    matches: r
                }), a = a.slice(n.length));
                if (!n) break
            }
            return t ? a.length : a ? se.error(e) : x(e, s).slice(0)
        }, f = se.compile = function(e, t) {
            var n, v, y, m, x, r, i = [],
                o = [],
                a = N[e + " "];
            if (!a) {
                t || (t = h(e)), n = t.length;
                while (n--)(a = Ee(t[n]))[k] ? i.push(a) : o.push(a);
                (a = N(e, (v = o, m = 0 < (y = i).length, x = 0 < v.length, r = function(e, t, n, r, i) {
                    var o, a, s, u = 0,
                        l = "0",
                        c = e && [],
                        f = [],
                        p = w,
                        d = e || x && b.find.TAG("*", i),
                        h = S += null == p ? 1 : Math.random() || .1,
                        g = d.length;
                    for (i && (w = t === C || t || i); l !== g && null != (o = d[l]); l++) {
                        if (x && o) {
                            a = 0, t || o.ownerDocument === C || (T(o), n = !E);
                            while (s = v[a++])
                                if (s(o, t || C, n)) {
                                    r.push(o);
                                    break
                                }
                            i && (S = h)
                        }
                        m && ((o = !s && o) && u--, e && c.push(o))
                    }
                    if (u += l, m && l !== u) {
                        a = 0;
                        while (s = y[a++]) s(c, f, t, n);
                        if (e) {
                            if (0 < u)
                                while (l--) c[l] || f[l] || (f[l] = q.call(r));
                            f = Te(f)
                        }
                        H.apply(r, f), i && !e && 0 < f.length && 1 < u + y.length && se.uniqueSort(r)
                    }
                    return i && (S = h, w = p), c
                }, m ? le(r) : r))).selector = e
            }
            return a
        }, g = se.select = function(e, t, n, r) {
            var i, o, a, s, u, l = "function" == typeof e && e,
                c = !r && h(e = l.selector || e);
            if (n = n || [], 1 === c.length) {
                if (2 < (o = c[0] = c[0].slice(0)).length && "ID" === (a = o[0]).type && 9 === t.nodeType && E && b.relative[o[1].type]) {
                    if (!(t = (b.find.ID(a.matches[0].replace(te, ne), t) || [])[0])) return n;
                    l && (t = t.parentNode), e = e.slice(o.shift().value.length)
                }
                i = G.needsContext.test(e) ? 0 : o.length;
                while (i--) {
                    if (a = o[i], b.relative[s = a.type]) break;
                    if ((u = b.find[s]) && (r = u(a.matches[0].replace(te, ne), ee.test(o[0].type) && ye(t.parentNode) || t))) {
                        if (o.splice(i, 1), !(e = r.length && xe(o))) return H.apply(n, r), n;
                        break
                    }
                }
            }
            return (l || f(e, c))(r, t, !E, n, !t || ee.test(e) && ye(t.parentNode) || t), n
        }, d.sortStable = k.split("").sort(D).join("") === k, d.detectDuplicates = !!l, T(), d.sortDetached = ce(function(e) {
            return 1 & e.compareDocumentPosition(C.createElement("fieldset"))
        }), ce(function(e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || fe("type|href|height|width", function(e, t, n) {
            if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), d.attributes && ce(function(e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || fe("value", function(e, t, n) {
            if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
        }), ce(function(e) {
            return null == e.getAttribute("disabled")
        }) || fe(R, function(e, t, n) {
            var r;
            if (!n) return !0 === e[t] ? t.toLowerCase() : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }), se
    }(C);
    k.find = h, k.expr = h.selectors, k.expr[":"] = k.expr.pseudos, k.uniqueSort = k.unique = h.uniqueSort, k.text = h.getText, k.isXMLDoc = h.isXML, k.contains = h.contains, k.escapeSelector = h.escape;
    var T = function(e, t, n) {
            var r = [],
                i = void 0 !== n;
            while ((e = e[t]) && 9 !== e.nodeType)
                if (1 === e.nodeType) {
                    if (i && k(e).is(n)) break;
                    r.push(e)
                }
            return r
        },
        S = function(e, t) {
            for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
            return n
        },
        N = k.expr.match.needsContext;

    function A(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }
    var D = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function j(e, n, r) {
        return m(n) ? k.grep(e, function(e, t) {
            return !!n.call(e, t, e) !== r
        }) : n.nodeType ? k.grep(e, function(e) {
            return e === n !== r
        }) : "string" != typeof n ? k.grep(e, function(e) {
            return -1 < i.call(n, e) !== r
        }) : k.filter(n, e, r)
    }
    k.filter = function(e, t, n) {
        var r = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === r.nodeType ? k.find.matchesSelector(r, e) ? [r] : [] : k.find.matches(e, k.grep(t, function(e) {
            return 1 === e.nodeType
        }))
    }, k.fn.extend({
        find: function(e) {
            var t, n, r = this.length,
                i = this;
            if ("string" != typeof e) return this.pushStack(k(e).filter(function() {
                for (t = 0; t < r; t++)
                    if (k.contains(i[t], this)) return !0
            }));
            for (n = this.pushStack([]), t = 0; t < r; t++) k.find(e, i[t], n);
            return 1 < r ? k.uniqueSort(n) : n
        },
        filter: function(e) {
            return this.pushStack(j(this, e || [], !1))
        },
        not: function(e) {
            return this.pushStack(j(this, e || [], !0))
        },
        is: function(e) {
            return !!j(this, "string" == typeof e && N.test(e) ? k(e) : e || [], !1).length
        }
    });
    var q, L = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (k.fn.init = function(e, t, n) {
        var r, i;
        if (!e) return this;
        if (n = n || q, "string" == typeof e) {
            if (!(r = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : L.exec(e)) || !r[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
            if (r[1]) {
                if (t = t instanceof k ? t[0] : t, k.merge(this, k.parseHTML(r[1], t && t.nodeType ? t.ownerDocument || t : E, !0)), D.test(r[1]) && k.isPlainObject(t))
                    for (r in t) m(this[r]) ? this[r](t[r]) : this.attr(r, t[r]);
                return this
            }
            return (i = E.getElementById(r[2])) && (this[0] = i, this.length = 1), this
        }
        return e.nodeType ? (this[0] = e, this.length = 1, this) : m(e) ? void 0 !== n.ready ? n.ready(e) : e(k) : k.makeArray(e, this)
    }).prototype = k.fn, q = k(E);
    var H = /^(?:parents|prev(?:Until|All))/,
        O = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };

    function P(e, t) {
        while ((e = e[t]) && 1 !== e.nodeType);
        return e
    }
    k.fn.extend({
        has: function(e) {
            var t = k(e, this),
                n = t.length;
            return this.filter(function() {
                for (var e = 0; e < n; e++)
                    if (k.contains(this, t[e])) return !0
            })
        },
        closest: function(e, t) {
            var n, r = 0,
                i = this.length,
                o = [],
                a = "string" != typeof e && k(e);
            if (!N.test(e))
                for (; r < i; r++)
                    for (n = this[r]; n && n !== t; n = n.parentNode)
                        if (n.nodeType < 11 && (a ? -1 < a.index(n) : 1 === n.nodeType && k.find.matchesSelector(n, e))) {
                            o.push(n);
                            break
                        }
            return this.pushStack(1 < o.length ? k.uniqueSort(o) : o)
        },
        index: function(e) {
            return e ? "string" == typeof e ? i.call(k(e), this[0]) : i.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(e, t) {
            return this.pushStack(k.uniqueSort(k.merge(this.get(), k(e, t))))
        },
        addBack: function(e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), k.each({
        parent: function(e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        },
        parents: function(e) {
            return T(e, "parentNode")
        },
        parentsUntil: function(e, t, n) {
            return T(e, "parentNode", n)
        },
        next: function(e) {
            return P(e, "nextSibling")
        },
        prev: function(e) {
            return P(e, "previousSibling")
        },
        nextAll: function(e) {
            return T(e, "nextSibling")
        },
        prevAll: function(e) {
            return T(e, "previousSibling")
        },
        nextUntil: function(e, t, n) {
            return T(e, "nextSibling", n)
        },
        prevUntil: function(e, t, n) {
            return T(e, "previousSibling", n)
        },
        siblings: function(e) {
            return S((e.parentNode || {}).firstChild, e)
        },
        children: function(e) {
            return S(e.firstChild)
        },
        contents: function(e) {
            return "undefined" != typeof e.contentDocument ? e.contentDocument : (A(e, "template") && (e = e.content || e), k.merge([], e.childNodes))
        }
    }, function(r, i) {
        k.fn[r] = function(e, t) {
            var n = k.map(this, i, e);
            return "Until" !== r.slice(-5) && (t = e), t && "string" == typeof t && (n = k.filter(t, n)), 1 < this.length && (O[r] || k.uniqueSort(n), H.test(r) && n.reverse()), this.pushStack(n)
        }
    });
    var R = /[^\x20\t\r\n\f]+/g;

    function M(e) {
        return e
    }

    function I(e) {
        throw e
    }

    function W(e, t, n, r) {
        var i;
        try {
            e && m(i = e.promise) ? i.call(e).done(t).fail(n) : e && m(i = e.then) ? i.call(e, t, n) : t.apply(void 0, [e].slice(r))
        } catch (e) {
            n.apply(void 0, [e])
        }
    }
    k.Callbacks = function(r) {
        var e, n;
        r = "string" == typeof r ? (e = r, n = {}, k.each(e.match(R) || [], function(e, t) {
            n[t] = !0
        }), n) : k.extend({}, r);
        var i, t, o, a, s = [],
            u = [],
            l = -1,
            c = function() {
                for (a = a || r.once, o = i = !0; u.length; l = -1) {
                    t = u.shift();
                    while (++l < s.length) !1 === s[l].apply(t[0], t[1]) && r.stopOnFalse && (l = s.length, t = !1)
                }
                r.memory || (t = !1), i = !1, a && (s = t ? [] : "")
            },
            f = {
                add: function() {
                    return s && (t && !i && (l = s.length - 1, u.push(t)), function n(e) {
                        k.each(e, function(e, t) {
                            m(t) ? r.unique && f.has(t) || s.push(t) : t && t.length && "string" !== w(t) && n(t)
                        })
                    }(arguments), t && !i && c()), this
                },
                remove: function() {
                    return k.each(arguments, function(e, t) {
                        var n;
                        while (-1 < (n = k.inArray(t, s, n))) s.splice(n, 1), n <= l && l--
                    }), this
                },
                has: function(e) {
                    return e ? -1 < k.inArray(e, s) : 0 < s.length
                },
                empty: function() {
                    return s && (s = []), this
                },
                disable: function() {
                    return a = u = [], s = t = "", this
                },
                disabled: function() {
                    return !s
                },
                lock: function() {
                    return a = u = [], t || i || (s = t = ""), this
                },
                locked: function() {
                    return !!a
                },
                fireWith: function(e, t) {
                    return a || (t = [e, (t = t || []).slice ? t.slice() : t], u.push(t), i || c()), this
                },
                fire: function() {
                    return f.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!o
                }
            };
        return f
    }, k.extend({
        Deferred: function(e) {
            var o = [
                    ["notify", "progress", k.Callbacks("memory"), k.Callbacks("memory"), 2],
                    ["resolve", "done", k.Callbacks("once memory"), k.Callbacks("once memory"), 0, "resolved"],
                    ["reject", "fail", k.Callbacks("once memory"), k.Callbacks("once memory"), 1, "rejected"]
                ],
                i = "pending",
                a = {
                    state: function() {
                        return i
                    },
                    always: function() {
                        return s.done(arguments).fail(arguments), this
                    },
                    "catch": function(e) {
                        return a.then(null, e)
                    },
                    pipe: function() {
                        var i = arguments;
                        return k.Deferred(function(r) {
                            k.each(o, function(e, t) {
                                var n = m(i[t[4]]) && i[t[4]];
                                s[t[1]](function() {
                                    var e = n && n.apply(this, arguments);
                                    e && m(e.promise) ? e.promise().progress(r.notify).done(r.resolve).fail(r.reject) : r[t[0] + "With"](this, n ? [e] : arguments)
                                })
                            }), i = null
                        }).promise()
                    },
                    then: function(t, n, r) {
                        var u = 0;

                        function l(i, o, a, s) {
                            return function() {
                                var n = this,
                                    r = arguments,
                                    e = function() {
                                        var e, t;
                                        if (!(i < u)) {
                                            if ((e = a.apply(n, r)) === o.promise()) throw new TypeError("Thenable self-resolution");
                                            t = e && ("object" == typeof e || "function" == typeof e) && e.then, m(t) ? s ? t.call(e, l(u, o, M, s), l(u, o, I, s)) : (u++, t.call(e, l(u, o, M, s), l(u, o, I, s), l(u, o, M, o.notifyWith))) : (a !== M && (n = void 0, r = [e]), (s || o.resolveWith)(n, r))
                                        }
                                    },
                                    t = s ? e : function() {
                                        try {
                                            e()
                                        } catch (e) {
                                            k.Deferred.exceptionHook && k.Deferred.exceptionHook(e, t.stackTrace), u <= i + 1 && (a !== I && (n = void 0, r = [e]), o.rejectWith(n, r))
                                        }
                                    };
                                i ? t() : (k.Deferred.getStackHook && (t.stackTrace = k.Deferred.getStackHook()), C.setTimeout(t))
                            }
                        }
                        return k.Deferred(function(e) {
                            o[0][3].add(l(0, e, m(r) ? r : M, e.notifyWith)), o[1][3].add(l(0, e, m(t) ? t : M)), o[2][3].add(l(0, e, m(n) ? n : I))
                        }).promise()
                    },
                    promise: function(e) {
                        return null != e ? k.extend(e, a) : a
                    }
                },
                s = {};
            return k.each(o, function(e, t) {
                var n = t[2],
                    r = t[5];
                a[t[1]] = n.add, r && n.add(function() {
                    i = r
                }, o[3 - e][2].disable, o[3 - e][3].disable, o[0][2].lock, o[0][3].lock), n.add(t[3].fire), s[t[0]] = function() {
                    return s[t[0] + "With"](this === s ? void 0 : this, arguments), this
                }, s[t[0] + "With"] = n.fireWith
            }), a.promise(s), e && e.call(s, s), s
        },
        when: function(e) {
            var n = arguments.length,
                t = n,
                r = Array(t),
                i = s.call(arguments),
                o = k.Deferred(),
                a = function(t) {
                    return function(e) {
                        r[t] = this, i[t] = 1 < arguments.length ? s.call(arguments) : e, --n || o.resolveWith(r, i)
                    }
                };
            if (n <= 1 && (W(e, o.done(a(t)).resolve, o.reject, !n), "pending" === o.state() || m(i[t] && i[t].then))) return o.then();
            while (t--) W(i[t], a(t), o.reject);
            return o.promise()
        }
    });
    var $ = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    k.Deferred.exceptionHook = function(e, t) {
        C.console && C.console.warn && e && $.test(e.name) && C.console.warn("jQuery.Deferred exception: " + e.message, e.stack, t)
    }, k.readyException = function(e) {
        C.setTimeout(function() {
            throw e
        })
    };
    var F = k.Deferred();

    function B() {
        E.removeEventListener("DOMContentLoaded", B), C.removeEventListener("load", B), k.ready()
    }
    k.fn.ready = function(e) {
        return F.then(e)["catch"](function(e) {
            k.readyException(e)
        }), this
    }, k.extend({
        isReady: !1,
        readyWait: 1,
        ready: function(e) {
            (!0 === e ? --k.readyWait : k.isReady) || (k.isReady = !0) !== e && 0 < --k.readyWait || F.resolveWith(E, [k])
        }
    }), k.ready.then = F.then, "complete" === E.readyState || "loading" !== E.readyState && !E.documentElement.doScroll ? C.setTimeout(k.ready) : (E.addEventListener("DOMContentLoaded", B), C.addEventListener("load", B));
    var _ = function(e, t, n, r, i, o, a) {
            var s = 0,
                u = e.length,
                l = null == n;
            if ("object" === w(n))
                for (s in i = !0, n) _(e, t, s, n[s], !0, o, a);
            else if (void 0 !== r && (i = !0, m(r) || (a = !0), l && (a ? (t.call(e, r), t = null) : (l = t, t = function(e, t, n) {
                    return l.call(k(e), n)
                })), t))
                for (; s < u; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
            return i ? e : l ? t.call(e) : u ? t(e[0], n) : o
        },
        z = /^-ms-/,
        U = /-([a-z])/g;

    function X(e, t) {
        return t.toUpperCase()
    }

    function V(e) {
        return e.replace(z, "ms-").replace(U, X)
    }
    var G = function(e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function Y() {
        this.expando = k.expando + Y.uid++
    }
    Y.uid = 1, Y.prototype = {
        cache: function(e) {
            var t = e[this.expando];
            return t || (t = {}, G(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        },
        set: function(e, t, n) {
            var r, i = this.cache(e);
            if ("string" == typeof t) i[V(t)] = n;
            else
                for (r in t) i[V(r)] = t[r];
            return i
        },
        get: function(e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][V(t)]
        },
        access: function(e, t, n) {
            return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
        },
        remove: function(e, t) {
            var n, r = e[this.expando];
            if (void 0 !== r) {
                if (void 0 !== t) {
                    n = (t = Array.isArray(t) ? t.map(V) : (t = V(t)) in r ? [t] : t.match(R) || []).length;
                    while (n--) delete r[t[n]]
                }(void 0 === t || k.isEmptyObject(r)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        },
        hasData: function(e) {
            var t = e[this.expando];
            return void 0 !== t && !k.isEmptyObject(t)
        }
    };
    var Q = new Y,
        J = new Y,
        K = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        Z = /[A-Z]/g;

    function ee(e, t, n) {
        var r, i;
        if (void 0 === n && 1 === e.nodeType)
            if (r = "data-" + t.replace(Z, "-$&").toLowerCase(), "string" == typeof(n = e.getAttribute(r))) {
                try {
                    n = "true" === (i = n) || "false" !== i && ("null" === i ? null : i === +i + "" ? +i : K.test(i) ? JSON.parse(i) : i)
                } catch (e) {}
                J.set(e, t, n)
            } else n = void 0;
        return n
    }
    k.extend({
        hasData: function(e) {
            return J.hasData(e) || Q.hasData(e)
        },
        data: function(e, t, n) {
            return J.access(e, t, n)
        },
        removeData: function(e, t) {
            J.remove(e, t)
        },
        _data: function(e, t, n) {
            return Q.access(e, t, n)
        },
        _removeData: function(e, t) {
            Q.remove(e, t)
        }
    }), k.fn.extend({
        data: function(n, e) {
            var t, r, i, o = this[0],
                a = o && o.attributes;
            if (void 0 === n) {
                if (this.length && (i = J.get(o), 1 === o.nodeType && !Q.get(o, "hasDataAttrs"))) {
                    t = a.length;
                    while (t--) a[t] && 0 === (r = a[t].name).indexOf("data-") && (r = V(r.slice(5)), ee(o, r, i[r]));
                    Q.set(o, "hasDataAttrs", !0)
                }
                return i
            }
            return "object" == typeof n ? this.each(function() {
                J.set(this, n)
            }) : _(this, function(e) {
                var t;
                if (o && void 0 === e) return void 0 !== (t = J.get(o, n)) ? t : void 0 !== (t = ee(o, n)) ? t : void 0;
                this.each(function() {
                    J.set(this, n, e)
                })
            }, null, e, 1 < arguments.length, null, !0)
        },
        removeData: function(e) {
            return this.each(function() {
                J.remove(this, e)
            })
        }
    }), k.extend({
        queue: function(e, t, n) {
            var r;
            if (e) return t = (t || "fx") + "queue", r = Q.get(e, t), n && (!r || Array.isArray(n) ? r = Q.access(e, t, k.makeArray(n)) : r.push(n)), r || []
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = k.queue(e, t),
                r = n.length,
                i = n.shift(),
                o = k._queueHooks(e, t);
            "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, function() {
                k.dequeue(e, t)
            }, o)), !r && o && o.empty.fire()
        },
        _queueHooks: function(e, t) {
            var n = t + "queueHooks";
            return Q.get(e, n) || Q.access(e, n, {
                empty: k.Callbacks("once memory").add(function() {
                    Q.remove(e, [t + "queue", n])
                })
            })
        }
    }), k.fn.extend({
        queue: function(t, n) {
            var e = 2;
            return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? k.queue(this[0], t) : void 0 === n ? this : this.each(function() {
                var e = k.queue(this, t, n);
                k._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && k.dequeue(this, t)
            })
        },
        dequeue: function(e) {
            return this.each(function() {
                k.dequeue(this, e)
            })
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", [])
        },
        promise: function(e, t) {
            var n, r = 1,
                i = k.Deferred(),
                o = this,
                a = this.length,
                s = function() {
                    --r || i.resolveWith(o, [o])
                };
            "string" != typeof e && (t = e, e = void 0), e = e || "fx";
            while (a--)(n = Q.get(o[a], e + "queueHooks")) && n.empty && (r++, n.empty.add(s));
            return s(), i.promise(t)
        }
    });
    var te = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        ne = new RegExp("^(?:([+-])=|)(" + te + ")([a-z%]*)$", "i"),
        re = ["Top", "Right", "Bottom", "Left"],
        ie = E.documentElement,
        oe = function(e) {
            return k.contains(e.ownerDocument, e)
        },
        ae = {
            composed: !0
        };
    ie.getRootNode && (oe = function(e) {
        return k.contains(e.ownerDocument, e) || e.getRootNode(ae) === e.ownerDocument
    });
    var se = function(e, t) {
            return "none" === (e = t || e).style.display || "" === e.style.display && oe(e) && "none" === k.css(e, "display")
        },
        ue = function(e, t, n, r) {
            var i, o, a = {};
            for (o in t) a[o] = e.style[o], e.style[o] = t[o];
            for (o in i = n.apply(e, r || []), t) e.style[o] = a[o];
            return i
        };

    function le(e, t, n, r) {
        var i, o, a = 20,
            s = r ? function() {
                return r.cur()
            } : function() {
                return k.css(e, t, "")
            },
            u = s(),
            l = n && n[3] || (k.cssNumber[t] ? "" : "px"),
            c = e.nodeType && (k.cssNumber[t] || "px" !== l && +u) && ne.exec(k.css(e, t));
        if (c && c[3] !== l) {
            u /= 2, l = l || c[3], c = +u || 1;
            while (a--) k.style(e, t, c + l), (1 - o) * (1 - (o = s() / u || .5)) <= 0 && (a = 0), c /= o;
            c *= 2, k.style(e, t, c + l), n = n || []
        }
        return n && (c = +c || +u || 0, i = n[1] ? c + (n[1] + 1) * n[2] : +n[2], r && (r.unit = l, r.start = c, r.end = i)), i
    }
    var ce = {};

    function fe(e, t) {
        for (var n, r, i, o, a, s, u, l = [], c = 0, f = e.length; c < f; c++)(r = e[c]).style && (n = r.style.display, t ? ("none" === n && (l[c] = Q.get(r, "display") || null, l[c] || (r.style.display = "")), "" === r.style.display && se(r) && (l[c] = (u = a = o = void 0, a = (i = r).ownerDocument, s = i.nodeName, (u = ce[s]) || (o = a.body.appendChild(a.createElement(s)), u = k.css(o, "display"), o.parentNode.removeChild(o), "none" === u && (u = "block"), ce[s] = u)))) : "none" !== n && (l[c] = "none", Q.set(r, "display", n)));
        for (c = 0; c < f; c++) null != l[c] && (e[c].style.display = l[c]);
        return e
    }
    k.fn.extend({
        show: function() {
            return fe(this, !0)
        },
        hide: function() {
            return fe(this)
        },
        toggle: function(e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
                se(this) ? k(this).show() : k(this).hide()
            })
        }
    });
    var pe = /^(?:checkbox|radio)$/i,
        de = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        he = /^$|^module$|\/(?:java|ecma)script/i,
        ge = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            thead: [1, "<table>", "</table>"],
            col: [2, "<table><colgroup>", "</colgroup></table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: [0, "", ""]
        };

    function ve(e, t) {
        var n;
        return n = "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t || "*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && A(e, t) ? k.merge([e], n) : n
    }

    function ye(e, t) {
        for (var n = 0, r = e.length; n < r; n++) Q.set(e[n], "globalEval", !t || Q.get(t[n], "globalEval"))
    }
    ge.optgroup = ge.option, ge.tbody = ge.tfoot = ge.colgroup = ge.caption = ge.thead, ge.th = ge.td;
    var me, xe, be = /<|&#?\w+;/;

    function we(e, t, n, r, i) {
        for (var o, a, s, u, l, c, f = t.createDocumentFragment(), p = [], d = 0, h = e.length; d < h; d++)
            if ((o = e[d]) || 0 === o)
                if ("object" === w(o)) k.merge(p, o.nodeType ? [o] : o);
                else if (be.test(o)) {
            a = a || f.appendChild(t.createElement("div")), s = (de.exec(o) || ["", ""])[1].toLowerCase(), u = ge[s] || ge._default, a.innerHTML = u[1] + k.htmlPrefilter(o) + u[2], c = u[0];
            while (c--) a = a.lastChild;
            k.merge(p, a.childNodes), (a = f.firstChild).textContent = ""
        } else p.push(t.createTextNode(o));
        f.textContent = "", d = 0;
        while (o = p[d++])
            if (r && -1 < k.inArray(o, r)) i && i.push(o);
            else if (l = oe(o), a = ve(f.appendChild(o), "script"), l && ye(a), n) {
            c = 0;
            while (o = a[c++]) he.test(o.type || "") && n.push(o)
        }
        return f
    }
    me = E.createDocumentFragment().appendChild(E.createElement("div")), (xe = E.createElement("input")).setAttribute("type", "radio"), xe.setAttribute("checked", "checked"), xe.setAttribute("name", "t"), me.appendChild(xe), y.checkClone = me.cloneNode(!0).cloneNode(!0).lastChild.checked, me.innerHTML = "<textarea>x</textarea>", y.noCloneChecked = !!me.cloneNode(!0).lastChild.defaultValue;
    var Te = /^key/,
        Ce = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
        Ee = /^([^.]*)(?:\.(.+)|)/;

    function ke() {
        return !0
    }

    function Se() {
        return !1
    }

    function Ne(e, t) {
        return e === function() {
            try {
                return E.activeElement
            } catch (e) {}
        }() == ("focus" === t)
    }

    function Ae(e, t, n, r, i, o) {
        var a, s;
        if ("object" == typeof t) {
            for (s in "string" != typeof n && (r = r || n, n = void 0), t) Ae(e, s, n, r, t[s], o);
            return e
        }
        if (null == r && null == i ? (i = n, r = n = void 0) : null == i && ("string" == typeof n ? (i = r, r = void 0) : (i = r, r = n, n = void 0)), !1 === i) i = Se;
        else if (!i) return e;
        return 1 === o && (a = i, (i = function(e) {
            return k().off(e), a.apply(this, arguments)
        }).guid = a.guid || (a.guid = k.guid++)), e.each(function() {
            k.event.add(this, t, i, r, n)
        })
    }

    function De(e, i, o) {
        o ? (Q.set(e, i, !1), k.event.add(e, i, {
            namespace: !1,
            handler: function(e) {
                var t, n, r = Q.get(this, i);
                if (1 & e.isTrigger && this[i]) {
                    if (r.length)(k.event.special[i] || {}).delegateType && e.stopPropagation();
                    else if (r = s.call(arguments), Q.set(this, i, r), t = o(this, i), this[i](), r !== (n = Q.get(this, i)) || t ? Q.set(this, i, !1) : n = {}, r !== n) return e.stopImmediatePropagation(), e.preventDefault(), n.value
                } else r.length && (Q.set(this, i, {
                    value: k.event.trigger(k.extend(r[0], k.Event.prototype), r.slice(1), this)
                }), e.stopImmediatePropagation())
            }
        })) : void 0 === Q.get(e, i) && k.event.add(e, i, ke)
    }
    k.event = {
        global: {},
        add: function(t, e, n, r, i) {
            var o, a, s, u, l, c, f, p, d, h, g, v = Q.get(t);
            if (v) {
                n.handler && (n = (o = n).handler, i = o.selector), i && k.find.matchesSelector(ie, i), n.guid || (n.guid = k.guid++), (u = v.events) || (u = v.events = {}), (a = v.handle) || (a = v.handle = function(e) {
                    return "undefined" != typeof k && k.event.triggered !== e.type ? k.event.dispatch.apply(t, arguments) : void 0
                }), l = (e = (e || "").match(R) || [""]).length;
                while (l--) d = g = (s = Ee.exec(e[l]) || [])[1], h = (s[2] || "").split(".").sort(), d && (f = k.event.special[d] || {}, d = (i ? f.delegateType : f.bindType) || d, f = k.event.special[d] || {}, c = k.extend({
                    type: d,
                    origType: g,
                    data: r,
                    handler: n,
                    guid: n.guid,
                    selector: i,
                    needsContext: i && k.expr.match.needsContext.test(i),
                    namespace: h.join(".")
                }, o), (p = u[d]) || ((p = u[d] = []).delegateCount = 0, f.setup && !1 !== f.setup.call(t, r, h, a) || t.addEventListener && t.addEventListener(d, a)), f.add && (f.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, c) : p.push(c), k.event.global[d] = !0)
            }
        },
        remove: function(e, t, n, r, i) {
            var o, a, s, u, l, c, f, p, d, h, g, v = Q.hasData(e) && Q.get(e);
            if (v && (u = v.events)) {
                l = (t = (t || "").match(R) || [""]).length;
                while (l--)
                    if (d = g = (s = Ee.exec(t[l]) || [])[1], h = (s[2] || "").split(".").sort(), d) {
                        f = k.event.special[d] || {}, p = u[d = (r ? f.delegateType : f.bindType) || d] || [], s = s[2] && new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), a = o = p.length;
                        while (o--) c = p[o], !i && g !== c.origType || n && n.guid !== c.guid || s && !s.test(c.namespace) || r && r !== c.selector && ("**" !== r || !c.selector) || (p.splice(o, 1), c.selector && p.delegateCount--, f.remove && f.remove.call(e, c));
                        a && !p.length && (f.teardown && !1 !== f.teardown.call(e, h, v.handle) || k.removeEvent(e, d, v.handle), delete u[d])
                    } else
                        for (d in u) k.event.remove(e, d + t[l], n, r, !0);
                k.isEmptyObject(u) && Q.remove(e, "handle events")
            }
        },
        dispatch: function(e) {
            var t, n, r, i, o, a, s = k.event.fix(e),
                u = new Array(arguments.length),
                l = (Q.get(this, "events") || {})[s.type] || [],
                c = k.event.special[s.type] || {};
            for (u[0] = s, t = 1; t < arguments.length; t++) u[t] = arguments[t];
            if (s.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, s)) {
                a = k.event.handlers.call(this, s, l), t = 0;
                while ((i = a[t++]) && !s.isPropagationStopped()) {
                    s.currentTarget = i.elem, n = 0;
                    while ((o = i.handlers[n++]) && !s.isImmediatePropagationStopped()) s.rnamespace && !1 !== o.namespace && !s.rnamespace.test(o.namespace) || (s.handleObj = o, s.data = o.data, void 0 !== (r = ((k.event.special[o.origType] || {}).handle || o.handler).apply(i.elem, u)) && !1 === (s.result = r) && (s.preventDefault(), s.stopPropagation()))
                }
                return c.postDispatch && c.postDispatch.call(this, s), s.result
            }
        },
        handlers: function(e, t) {
            var n, r, i, o, a, s = [],
                u = t.delegateCount,
                l = e.target;
            if (u && l.nodeType && !("click" === e.type && 1 <= e.button))
                for (; l !== this; l = l.parentNode || this)
                    if (1 === l.nodeType && ("click" !== e.type || !0 !== l.disabled)) {
                        for (o = [], a = {}, n = 0; n < u; n++) void 0 === a[i = (r = t[n]).selector + " "] && (a[i] = r.needsContext ? -1 < k(i, this).index(l) : k.find(i, this, null, [l]).length), a[i] && o.push(r);
                        o.length && s.push({
                            elem: l,
                            handlers: o
                        })
                    }
            return l = this, u < t.length && s.push({
                elem: l,
                handlers: t.slice(u)
            }), s
        },
        addProp: function(t, e) {
            Object.defineProperty(k.Event.prototype, t, {
                enumerable: !0,
                configurable: !0,
                get: m(e) ? function() {
                    if (this.originalEvent) return e(this.originalEvent)
                } : function() {
                    if (this.originalEvent) return this.originalEvent[t]
                },
                set: function(e) {
                    Object.defineProperty(this, t, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: e
                    })
                }
            })
        },
        fix: function(e) {
            return e[k.expando] ? e : new k.Event(e)
        },
        special: {
            load: {
                noBubble: !0
            },
            click: {
                setup: function(e) {
                    var t = this || e;
                    return pe.test(t.type) && t.click && A(t, "input") && De(t, "click", ke), !1
                },
                trigger: function(e) {
                    var t = this || e;
                    return pe.test(t.type) && t.click && A(t, "input") && De(t, "click"), !0
                },
                _default: function(e) {
                    var t = e.target;
                    return pe.test(t.type) && t.click && A(t, "input") && Q.get(t, "click") || A(t, "a")
                }
            },
            beforeunload: {
                postDispatch: function(e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, k.removeEvent = function(e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, k.Event = function(e, t) {
        if (!(this instanceof k.Event)) return new k.Event(e, t);
        e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? ke : Se, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && k.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[k.expando] = !0
    }, k.Event.prototype = {
        constructor: k.Event,
        isDefaultPrevented: Se,
        isPropagationStopped: Se,
        isImmediatePropagationStopped: Se,
        isSimulated: !1,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = ke, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = ke, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function() {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = ke, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, k.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        "char": !0,
        code: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: function(e) {
            var t = e.button;
            return null == e.which && Te.test(e.type) ? null != e.charCode ? e.charCode : e.keyCode : !e.which && void 0 !== t && Ce.test(e.type) ? 1 & t ? 1 : 2 & t ? 3 : 4 & t ? 2 : 0 : e.which
        }
    }, k.event.addProp), k.each({
        focus: "focusin",
        blur: "focusout"
    }, function(e, t) {
        k.event.special[e] = {
            setup: function() {
                return De(this, e, Ne), !1
            },
            trigger: function() {
                return De(this, e), !0
            },
            delegateType: t
        }
    }), k.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(e, i) {
        k.event.special[e] = {
            delegateType: i,
            bindType: i,
            handle: function(e) {
                var t, n = e.relatedTarget,
                    r = e.handleObj;
                return n && (n === this || k.contains(this, n)) || (e.type = r.origType, t = r.handler.apply(this, arguments), e.type = i), t
            }
        }
    }), k.fn.extend({
        on: function(e, t, n, r) {
            return Ae(this, e, t, n, r)
        },
        one: function(e, t, n, r) {
            return Ae(this, e, t, n, r, 1)
        },
        off: function(e, t, n) {
            var r, i;
            if (e && e.preventDefault && e.handleObj) return r = e.handleObj, k(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
            if ("object" == typeof e) {
                for (i in e) this.off(i, t, e[i]);
                return this
            }
            return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = Se), this.each(function() {
                k.event.remove(this, e, n, t)
            })
        }
    });
    var je = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,
        qe = /<script|<style|<link/i,
        Le = /checked\s*(?:[^=]|=\s*.checked.)/i,
        He = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function Oe(e, t) {
        return A(e, "table") && A(11 !== t.nodeType ? t : t.firstChild, "tr") && k(e).children("tbody")[0] || e
    }

    function Pe(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function Re(e) {
        return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Me(e, t) {
        var n, r, i, o, a, s, u, l;
        if (1 === t.nodeType) {
            if (Q.hasData(e) && (o = Q.access(e), a = Q.set(t, o), l = o.events))
                for (i in delete a.handle, a.events = {}, l)
                    for (n = 0, r = l[i].length; n < r; n++) k.event.add(t, i, l[i][n]);
            J.hasData(e) && (s = J.access(e), u = k.extend({}, s), J.set(t, u))
        }
    }

    function Ie(n, r, i, o) {
        r = g.apply([], r);
        var e, t, a, s, u, l, c = 0,
            f = n.length,
            p = f - 1,
            d = r[0],
            h = m(d);
        if (h || 1 < f && "string" == typeof d && !y.checkClone && Le.test(d)) return n.each(function(e) {
            var t = n.eq(e);
            h && (r[0] = d.call(this, e, t.html())), Ie(t, r, i, o)
        });
        if (f && (t = (e = we(r, n[0].ownerDocument, !1, n, o)).firstChild, 1 === e.childNodes.length && (e = t), t || o)) {
            for (s = (a = k.map(ve(e, "script"), Pe)).length; c < f; c++) u = e, c !== p && (u = k.clone(u, !0, !0), s && k.merge(a, ve(u, "script"))), i.call(n[c], u, c);
            if (s)
                for (l = a[a.length - 1].ownerDocument, k.map(a, Re), c = 0; c < s; c++) u = a[c], he.test(u.type || "") && !Q.access(u, "globalEval") && k.contains(l, u) && (u.src && "module" !== (u.type || "").toLowerCase() ? k._evalUrl && !u.noModule && k._evalUrl(u.src, {
                    nonce: u.nonce || u.getAttribute("nonce")
                }) : b(u.textContent.replace(He, ""), u, l))
        }
        return n
    }

    function We(e, t, n) {
        for (var r, i = t ? k.filter(t, e) : e, o = 0; null != (r = i[o]); o++) n || 1 !== r.nodeType || k.cleanData(ve(r)), r.parentNode && (n && oe(r) && ye(ve(r, "script")), r.parentNode.removeChild(r));
        return e
    }
    k.extend({
        htmlPrefilter: function(e) {
            return e.replace(je, "<$1></$2>")
        },
        clone: function(e, t, n) {
            var r, i, o, a, s, u, l, c = e.cloneNode(!0),
                f = oe(e);
            if (!(y.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || k.isXMLDoc(e)))
                for (a = ve(c), r = 0, i = (o = ve(e)).length; r < i; r++) s = o[r], u = a[r], void 0, "input" === (l = u.nodeName.toLowerCase()) && pe.test(s.type) ? u.checked = s.checked : "input" !== l && "textarea" !== l || (u.defaultValue = s.defaultValue);
            if (t)
                if (n)
                    for (o = o || ve(e), a = a || ve(c), r = 0, i = o.length; r < i; r++) Me(o[r], a[r]);
                else Me(e, c);
            return 0 < (a = ve(c, "script")).length && ye(a, !f && ve(e, "script")), c
        },
        cleanData: function(e) {
            for (var t, n, r, i = k.event.special, o = 0; void 0 !== (n = e[o]); o++)
                if (G(n)) {
                    if (t = n[Q.expando]) {
                        if (t.events)
                            for (r in t.events) i[r] ? k.event.remove(n, r) : k.removeEvent(n, r, t.handle);
                        n[Q.expando] = void 0
                    }
                    n[J.expando] && (n[J.expando] = void 0)
                }
        }
    }), k.fn.extend({
        detach: function(e) {
            return We(this, e, !0)
        },
        remove: function(e) {
            return We(this, e)
        },
        text: function(e) {
            return _(this, function(e) {
                return void 0 === e ? k.text(this) : this.empty().each(function() {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                })
            }, null, e, arguments.length)
        },
        append: function() {
            return Ie(this, arguments, function(e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || Oe(this, e).appendChild(e)
            })
        },
        prepend: function() {
            return Ie(this, arguments, function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = Oe(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        },
        before: function() {
            return Ie(this, arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        },
        after: function() {
            return Ie(this, arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        },
        empty: function() {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (k.cleanData(ve(e, !1)), e.textContent = "");
            return this
        },
        clone: function(e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function() {
                return k.clone(this, e, t)
            })
        },
        html: function(e) {
            return _(this, function(e) {
                var t = this[0] || {},
                    n = 0,
                    r = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !qe.test(e) && !ge[(de.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = k.htmlPrefilter(e);
                    try {
                        for (; n < r; n++) 1 === (t = this[n] || {}).nodeType && (k.cleanData(ve(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {}
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        },
        replaceWith: function() {
            var n = [];
            return Ie(this, arguments, function(e) {
                var t = this.parentNode;
                k.inArray(this, n) < 0 && (k.cleanData(ve(this)), t && t.replaceChild(e, this))
            }, n)
        }
    }), k.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(e, a) {
        k.fn[e] = function(e) {
            for (var t, n = [], r = k(e), i = r.length - 1, o = 0; o <= i; o++) t = o === i ? this : this.clone(!0), k(r[o])[a](t), u.apply(n, t.get());
            return this.pushStack(n)
        }
    });
    var $e = new RegExp("^(" + te + ")(?!px)[a-z%]+$", "i"),
        Fe = function(e) {
            var t = e.ownerDocument.defaultView;
            return t && t.opener || (t = C), t.getComputedStyle(e)
        },
        Be = new RegExp(re.join("|"), "i");

    function _e(e, t, n) {
        var r, i, o, a, s = e.style;
        return (n = n || Fe(e)) && ("" !== (a = n.getPropertyValue(t) || n[t]) || oe(e) || (a = k.style(e, t)), !y.pixelBoxStyles() && $e.test(a) && Be.test(t) && (r = s.width, i = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = r, s.minWidth = i, s.maxWidth = o)), void 0 !== a ? a + "" : a
    }

    function ze(e, t) {
        return {
            get: function() {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }! function() {
        function e() {
            if (u) {
                s.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", u.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", ie.appendChild(s).appendChild(u);
                var e = C.getComputedStyle(u);
                n = "1%" !== e.top, a = 12 === t(e.marginLeft), u.style.right = "60%", o = 36 === t(e.right), r = 36 === t(e.width), u.style.position = "absolute", i = 12 === t(u.offsetWidth / 3), ie.removeChild(s), u = null
            }
        }

        function t(e) {
            return Math.round(parseFloat(e))
        }
        var n, r, i, o, a, s = E.createElement("div"),
            u = E.createElement("div");
        u.style && (u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", y.clearCloneStyle = "content-box" === u.style.backgroundClip, k.extend(y, {
            boxSizingReliable: function() {
                return e(), r
            },
            pixelBoxStyles: function() {
                return e(), o
            },
            pixelPosition: function() {
                return e(), n
            },
            reliableMarginLeft: function() {
                return e(), a
            },
            scrollboxSize: function() {
                return e(), i
            }
        }))
    }();
    var Ue = ["Webkit", "Moz", "ms"],
        Xe = E.createElement("div").style,
        Ve = {};

    function Ge(e) {
        var t = k.cssProps[e] || Ve[e];
        return t || (e in Xe ? e : Ve[e] = function(e) {
            var t = e[0].toUpperCase() + e.slice(1),
                n = Ue.length;
            while (n--)
                if ((e = Ue[n] + t) in Xe) return e
        }(e) || e)
    }
    var Ye = /^(none|table(?!-c[ea]).+)/,
        Qe = /^--/,
        Je = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        Ke = {
            letterSpacing: "0",
            fontWeight: "400"
        };

    function Ze(e, t, n) {
        var r = ne.exec(t);
        return r ? Math.max(0, r[2] - (n || 0)) + (r[3] || "px") : t
    }

    function et(e, t, n, r, i, o) {
        var a = "width" === t ? 1 : 0,
            s = 0,
            u = 0;
        if (n === (r ? "border" : "content")) return 0;
        for (; a < 4; a += 2) "margin" === n && (u += k.css(e, n + re[a], !0, i)), r ? ("content" === n && (u -= k.css(e, "padding" + re[a], !0, i)), "margin" !== n && (u -= k.css(e, "border" + re[a] + "Width", !0, i))) : (u += k.css(e, "padding" + re[a], !0, i), "padding" !== n ? u += k.css(e, "border" + re[a] + "Width", !0, i) : s += k.css(e, "border" + re[a] + "Width", !0, i));
        return !r && 0 <= o && (u += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - o - u - s - .5)) || 0), u
    }

    function tt(e, t, n) {
        var r = Fe(e),
            i = (!y.boxSizingReliable() || n) && "border-box" === k.css(e, "boxSizing", !1, r),
            o = i,
            a = _e(e, t, r),
            s = "offset" + t[0].toUpperCase() + t.slice(1);
        if ($e.test(a)) {
            if (!n) return a;
            a = "auto"
        }
        return (!y.boxSizingReliable() && i || "auto" === a || !parseFloat(a) && "inline" === k.css(e, "display", !1, r)) && e.getClientRects().length && (i = "border-box" === k.css(e, "boxSizing", !1, r), (o = s in e) && (a = e[s])), (a = parseFloat(a) || 0) + et(e, t, n || (i ? "border" : "content"), o, r, a) + "px"
    }

    function nt(e, t, n, r, i) {
        return new nt.prototype.init(e, t, n, r, i)
    }
    k.extend({
        cssHooks: {
            opacity: {
                get: function(e, t) {
                    if (t) {
                        var n = _e(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function(e, t, n, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i, o, a, s = V(t),
                    u = Qe.test(t),
                    l = e.style;
                if (u || (t = Ge(s)), a = k.cssHooks[t] || k.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
                "string" === (o = typeof n) && (i = ne.exec(n)) && i[1] && (n = le(e, t, i), o = "number"), null != n && n == n && ("number" !== o || u || (n += i && i[3] || (k.cssNumber[s] ? "" : "px")), y.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), a && "set" in a && void 0 === (n = a.set(e, n, r)) || (u ? l.setProperty(t, n) : l[t] = n))
            }
        },
        css: function(e, t, n, r) {
            var i, o, a, s = V(t);
            return Qe.test(t) || (t = Ge(s)), (a = k.cssHooks[t] || k.cssHooks[s]) && "get" in a && (i = a.get(e, !0, n)), void 0 === i && (i = _e(e, t, r)), "normal" === i && t in Ke && (i = Ke[t]), "" === n || n ? (o = parseFloat(i), !0 === n || isFinite(o) ? o || 0 : i) : i
        }
    }), k.each(["height", "width"], function(e, u) {
        k.cssHooks[u] = {
            get: function(e, t, n) {
                if (t) return !Ye.test(k.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? tt(e, u, n) : ue(e, Je, function() {
                    return tt(e, u, n)
                })
            },
            set: function(e, t, n) {
                var r, i = Fe(e),
                    o = !y.scrollboxSize() && "absolute" === i.position,
                    a = (o || n) && "border-box" === k.css(e, "boxSizing", !1, i),
                    s = n ? et(e, u, n, a, i) : 0;
                return a && o && (s -= Math.ceil(e["offset" + u[0].toUpperCase() + u.slice(1)] - parseFloat(i[u]) - et(e, u, "border", !1, i) - .5)), s && (r = ne.exec(t)) && "px" !== (r[3] || "px") && (e.style[u] = t, t = k.css(e, u)), Ze(0, t, s)
            }
        }
    }), k.cssHooks.marginLeft = ze(y.reliableMarginLeft, function(e, t) {
        if (t) return (parseFloat(_e(e, "marginLeft")) || e.getBoundingClientRect().left - ue(e, {
            marginLeft: 0
        }, function() {
            return e.getBoundingClientRect().left
        })) + "px"
    }), k.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(i, o) {
        k.cssHooks[i + o] = {
            expand: function(e) {
                for (var t = 0, n = {}, r = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) n[i + re[t] + o] = r[t] || r[t - 2] || r[0];
                return n
            }
        }, "margin" !== i && (k.cssHooks[i + o].set = Ze)
    }), k.fn.extend({
        css: function(e, t) {
            return _(this, function(e, t, n) {
                var r, i, o = {},
                    a = 0;
                if (Array.isArray(t)) {
                    for (r = Fe(e), i = t.length; a < i; a++) o[t[a]] = k.css(e, t[a], !1, r);
                    return o
                }
                return void 0 !== n ? k.style(e, t, n) : k.css(e, t)
            }, e, t, 1 < arguments.length)
        }
    }), ((k.Tween = nt).prototype = {
        constructor: nt,
        init: function(e, t, n, r, i, o) {
            this.elem = e, this.prop = n, this.easing = i || k.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (k.cssNumber[n] ? "" : "px")
        },
        cur: function() {
            var e = nt.propHooks[this.prop];
            return e && e.get ? e.get(this) : nt.propHooks._default.get(this)
        },
        run: function(e) {
            var t, n = nt.propHooks[this.prop];
            return this.options.duration ? this.pos = t = k.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : nt.propHooks._default.set(this), this
        }
    }).init.prototype = nt.prototype, (nt.propHooks = {
        _default: {
            get: function(e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = k.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
            },
            set: function(e) {
                k.fx.step[e.prop] ? k.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !k.cssHooks[e.prop] && null == e.elem.style[Ge(e.prop)] ? e.elem[e.prop] = e.now : k.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }).scrollTop = nt.propHooks.scrollLeft = {
        set: function(e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, k.easing = {
        linear: function(e) {
            return e
        },
        swing: function(e) {
            return .5 - Math.cos(e * Math.PI) / 2
        },
        _default: "swing"
    }, k.fx = nt.prototype.init, k.fx.step = {};
    var rt, it, ot, at, st = /^(?:toggle|show|hide)$/,
        ut = /queueHooks$/;

    function lt() {
        it && (!1 === E.hidden && C.requestAnimationFrame ? C.requestAnimationFrame(lt) : C.setTimeout(lt, k.fx.interval), k.fx.tick())
    }

    function ct() {
        return C.setTimeout(function() {
            rt = void 0
        }), rt = Date.now()
    }

    function ft(e, t) {
        var n, r = 0,
            i = {
                height: e
            };
        for (t = t ? 1 : 0; r < 4; r += 2 - t) i["margin" + (n = re[r])] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i
    }

    function pt(e, t, n) {
        for (var r, i = (dt.tweeners[t] || []).concat(dt.tweeners["*"]), o = 0, a = i.length; o < a; o++)
            if (r = i[o].call(n, t, e)) return r
    }

    function dt(o, e, t) {
        var n, a, r = 0,
            i = dt.prefilters.length,
            s = k.Deferred().always(function() {
                delete u.elem
            }),
            u = function() {
                if (a) return !1;
                for (var e = rt || ct(), t = Math.max(0, l.startTime + l.duration - e), n = 1 - (t / l.duration || 0), r = 0, i = l.tweens.length; r < i; r++) l.tweens[r].run(n);
                return s.notifyWith(o, [l, n, t]), n < 1 && i ? t : (i || s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l]), !1)
            },
            l = s.promise({
                elem: o,
                props: k.extend({}, e),
                opts: k.extend(!0, {
                    specialEasing: {},
                    easing: k.easing._default
                }, t),
                originalProperties: e,
                originalOptions: t,
                startTime: rt || ct(),
                duration: t.duration,
                tweens: [],
                createTween: function(e, t) {
                    var n = k.Tween(o, l.opts, e, t, l.opts.specialEasing[e] || l.opts.easing);
                    return l.tweens.push(n), n
                },
                stop: function(e) {
                    var t = 0,
                        n = e ? l.tweens.length : 0;
                    if (a) return this;
                    for (a = !0; t < n; t++) l.tweens[t].run(1);
                    return e ? (s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l, e])) : s.rejectWith(o, [l, e]), this
                }
            }),
            c = l.props;
        for (! function(e, t) {
                var n, r, i, o, a;
                for (n in e)
                    if (i = t[r = V(n)], o = e[n], Array.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), (a = k.cssHooks[r]) && "expand" in a)
                        for (n in o = a.expand(o), delete e[r], o) n in e || (e[n] = o[n], t[n] = i);
                    else t[r] = i
            }(c, l.opts.specialEasing); r < i; r++)
            if (n = dt.prefilters[r].call(l, o, c, l.opts)) return m(n.stop) && (k._queueHooks(l.elem, l.opts.queue).stop = n.stop.bind(n)), n;
        return k.map(c, pt, l), m(l.opts.start) && l.opts.start.call(o, l), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always), k.fx.timer(k.extend(u, {
            elem: o,
            anim: l,
            queue: l.opts.queue
        })), l
    }
    k.Animation = k.extend(dt, {
        tweeners: {
            "*": [function(e, t) {
                var n = this.createTween(e, t);
                return le(n.elem, e, ne.exec(t), n), n
            }]
        },
        tweener: function(e, t) {
            m(e) ? (t = e, e = ["*"]) : e = e.match(R);
            for (var n, r = 0, i = e.length; r < i; r++) n = e[r], dt.tweeners[n] = dt.tweeners[n] || [], dt.tweeners[n].unshift(t)
        },
        prefilters: [function(e, t, n) {
            var r, i, o, a, s, u, l, c, f = "width" in t || "height" in t,
                p = this,
                d = {},
                h = e.style,
                g = e.nodeType && se(e),
                v = Q.get(e, "fxshow");
            for (r in n.queue || (null == (a = k._queueHooks(e, "fx")).unqueued && (a.unqueued = 0, s = a.empty.fire, a.empty.fire = function() {
                    a.unqueued || s()
                }), a.unqueued++, p.always(function() {
                    p.always(function() {
                        a.unqueued--, k.queue(e, "fx").length || a.empty.fire()
                    })
                })), t)
                if (i = t[r], st.test(i)) {
                    if (delete t[r], o = o || "toggle" === i, i === (g ? "hide" : "show")) {
                        if ("show" !== i || !v || void 0 === v[r]) continue;
                        g = !0
                    }
                    d[r] = v && v[r] || k.style(e, r)
                }
            if ((u = !k.isEmptyObject(t)) || !k.isEmptyObject(d))
                for (r in f && 1 === e.nodeType && (n.overflow = [h.overflow, h.overflowX, h.overflowY], null == (l = v && v.display) && (l = Q.get(e, "display")), "none" === (c = k.css(e, "display")) && (l ? c = l : (fe([e], !0), l = e.style.display || l, c = k.css(e, "display"), fe([e]))), ("inline" === c || "inline-block" === c && null != l) && "none" === k.css(e, "float") && (u || (p.done(function() {
                        h.display = l
                    }), null == l && (c = h.display, l = "none" === c ? "" : c)), h.display = "inline-block")), n.overflow && (h.overflow = "hidden", p.always(function() {
                        h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
                    })), u = !1, d) u || (v ? "hidden" in v && (g = v.hidden) : v = Q.access(e, "fxshow", {
                    display: l
                }), o && (v.hidden = !g), g && fe([e], !0), p.done(function() {
                    for (r in g || fe([e]), Q.remove(e, "fxshow"), d) k.style(e, r, d[r])
                })), u = pt(g ? v[r] : 0, r, p), r in v || (v[r] = u.start, g && (u.end = u.start, u.start = 0))
        }],
        prefilter: function(e, t) {
            t ? dt.prefilters.unshift(e) : dt.prefilters.push(e)
        }
    }), k.speed = function(e, t, n) {
        var r = e && "object" == typeof e ? k.extend({}, e) : {
            complete: n || !n && t || m(e) && e,
            duration: e,
            easing: n && t || t && !m(t) && t
        };
        return k.fx.off ? r.duration = 0 : "number" != typeof r.duration && (r.duration in k.fx.speeds ? r.duration = k.fx.speeds[r.duration] : r.duration = k.fx.speeds._default), null != r.queue && !0 !== r.queue || (r.queue = "fx"), r.old = r.complete, r.complete = function() {
            m(r.old) && r.old.call(this), r.queue && k.dequeue(this, r.queue)
        }, r
    }, k.fn.extend({
        fadeTo: function(e, t, n, r) {
            return this.filter(se).css("opacity", 0).show().end().animate({
                opacity: t
            }, e, n, r)
        },
        animate: function(t, e, n, r) {
            var i = k.isEmptyObject(t),
                o = k.speed(e, n, r),
                a = function() {
                    var e = dt(this, k.extend({}, t), o);
                    (i || Q.get(this, "finish")) && e.stop(!0)
                };
            return a.finish = a, i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
        },
        stop: function(i, e, o) {
            var a = function(e) {
                var t = e.stop;
                delete e.stop, t(o)
            };
            return "string" != typeof i && (o = e, e = i, i = void 0), e && !1 !== i && this.queue(i || "fx", []), this.each(function() {
                var e = !0,
                    t = null != i && i + "queueHooks",
                    n = k.timers,
                    r = Q.get(this);
                if (t) r[t] && r[t].stop && a(r[t]);
                else
                    for (t in r) r[t] && r[t].stop && ut.test(t) && a(r[t]);
                for (t = n.length; t--;) n[t].elem !== this || null != i && n[t].queue !== i || (n[t].anim.stop(o), e = !1, n.splice(t, 1));
                !e && o || k.dequeue(this, i)
            })
        },
        finish: function(a) {
            return !1 !== a && (a = a || "fx"), this.each(function() {
                var e, t = Q.get(this),
                    n = t[a + "queue"],
                    r = t[a + "queueHooks"],
                    i = k.timers,
                    o = n ? n.length : 0;
                for (t.finish = !0, k.queue(this, a, []), r && r.stop && r.stop.call(this, !0), e = i.length; e--;) i[e].elem === this && i[e].queue === a && (i[e].anim.stop(!0), i.splice(e, 1));
                for (e = 0; e < o; e++) n[e] && n[e].finish && n[e].finish.call(this);
                delete t.finish
            })
        }
    }), k.each(["toggle", "show", "hide"], function(e, r) {
        var i = k.fn[r];
        k.fn[r] = function(e, t, n) {
            return null == e || "boolean" == typeof e ? i.apply(this, arguments) : this.animate(ft(r, !0), e, t, n)
        }
    }), k.each({
        slideDown: ft("show"),
        slideUp: ft("hide"),
        slideToggle: ft("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(e, r) {
        k.fn[e] = function(e, t, n) {
            return this.animate(r, e, t, n)
        }
    }), k.timers = [], k.fx.tick = function() {
        var e, t = 0,
            n = k.timers;
        for (rt = Date.now(); t < n.length; t++)(e = n[t])() || n[t] !== e || n.splice(t--, 1);
        n.length || k.fx.stop(), rt = void 0
    }, k.fx.timer = function(e) {
        k.timers.push(e), k.fx.start()
    }, k.fx.interval = 13, k.fx.start = function() {
        it || (it = !0, lt())
    }, k.fx.stop = function() {
        it = null
    }, k.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, k.fn.delay = function(r, e) {
        return r = k.fx && k.fx.speeds[r] || r, e = e || "fx", this.queue(e, function(e, t) {
            var n = C.setTimeout(e, r);
            t.stop = function() {
                C.clearTimeout(n)
            }
        })
    }, ot = E.createElement("input"), at = E.createElement("select").appendChild(E.createElement("option")), ot.type = "checkbox", y.checkOn = "" !== ot.value, y.optSelected = at.selected, (ot = E.createElement("input")).value = "t", ot.type = "radio", y.radioValue = "t" === ot.value;
    var ht, gt = k.expr.attrHandle;
    k.fn.extend({
        attr: function(e, t) {
            return _(this, k.attr, e, t, 1 < arguments.length)
        },
        removeAttr: function(e) {
            return this.each(function() {
                k.removeAttr(this, e)
            })
        }
    }), k.extend({
        attr: function(e, t, n) {
            var r, i, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return "undefined" == typeof e.getAttribute ? k.prop(e, t, n) : (1 === o && k.isXMLDoc(e) || (i = k.attrHooks[t.toLowerCase()] || (k.expr.match.bool.test(t) ? ht : void 0)), void 0 !== n ? null === n ? void k.removeAttr(e, t) : i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : (e.setAttribute(t, n + ""), n) : i && "get" in i && null !== (r = i.get(e, t)) ? r : null == (r = k.find.attr(e, t)) ? void 0 : r)
        },
        attrHooks: {
            type: {
                set: function(e, t) {
                    if (!y.radioValue && "radio" === t && A(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        removeAttr: function(e, t) {
            var n, r = 0,
                i = t && t.match(R);
            if (i && 1 === e.nodeType)
                while (n = i[r++]) e.removeAttribute(n)
        }
    }), ht = {
        set: function(e, t, n) {
            return !1 === t ? k.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, k.each(k.expr.match.bool.source.match(/\w+/g), function(e, t) {
        var a = gt[t] || k.find.attr;
        gt[t] = function(e, t, n) {
            var r, i, o = t.toLowerCase();
            return n || (i = gt[o], gt[o] = r, r = null != a(e, t, n) ? o : null, gt[o] = i), r
        }
    });
    var vt = /^(?:input|select|textarea|button)$/i,
        yt = /^(?:a|area)$/i;

    function mt(e) {
        return (e.match(R) || []).join(" ")
    }

    function xt(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    function bt(e) {
        return Array.isArray(e) ? e : "string" == typeof e && e.match(R) || []
    }
    k.fn.extend({
        prop: function(e, t) {
            return _(this, k.prop, e, t, 1 < arguments.length)
        },
        removeProp: function(e) {
            return this.each(function() {
                delete this[k.propFix[e] || e]
            })
        }
    }), k.extend({
        prop: function(e, t, n) {
            var r, i, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return 1 === o && k.isXMLDoc(e) || (t = k.propFix[t] || t, i = k.propHooks[t]), void 0 !== n ? i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get" in i && null !== (r = i.get(e, t)) ? r : e[t]
        },
        propHooks: {
            tabIndex: {
                get: function(e) {
                    var t = k.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : vt.test(e.nodeName) || yt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        },
        propFix: {
            "for": "htmlFor",
            "class": "className"
        }
    }), y.optSelected || (k.propHooks.selected = {
        get: function(e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        },
        set: function(e) {
            var t = e.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
        }
    }), k.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
        k.propFix[this.toLowerCase()] = this
    }), k.fn.extend({
        addClass: function(t) {
            var e, n, r, i, o, a, s, u = 0;
            if (m(t)) return this.each(function(e) {
                k(this).addClass(t.call(this, e, xt(this)))
            });
            if ((e = bt(t)).length)
                while (n = this[u++])
                    if (i = xt(n), r = 1 === n.nodeType && " " + mt(i) + " ") {
                        a = 0;
                        while (o = e[a++]) r.indexOf(" " + o + " ") < 0 && (r += o + " ");
                        i !== (s = mt(r)) && n.setAttribute("class", s)
                    }
            return this
        },
        removeClass: function(t) {
            var e, n, r, i, o, a, s, u = 0;
            if (m(t)) return this.each(function(e) {
                k(this).removeClass(t.call(this, e, xt(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ((e = bt(t)).length)
                while (n = this[u++])
                    if (i = xt(n), r = 1 === n.nodeType && " " + mt(i) + " ") {
                        a = 0;
                        while (o = e[a++])
                            while (-1 < r.indexOf(" " + o + " ")) r = r.replace(" " + o + " ", " ");
                        i !== (s = mt(r)) && n.setAttribute("class", s)
                    }
            return this
        },
        toggleClass: function(i, t) {
            var o = typeof i,
                a = "string" === o || Array.isArray(i);
            return "boolean" == typeof t && a ? t ? this.addClass(i) : this.removeClass(i) : m(i) ? this.each(function(e) {
                k(this).toggleClass(i.call(this, e, xt(this), t), t)
            }) : this.each(function() {
                var e, t, n, r;
                if (a) {
                    t = 0, n = k(this), r = bt(i);
                    while (e = r[t++]) n.hasClass(e) ? n.removeClass(e) : n.addClass(e)
                } else void 0 !== i && "boolean" !== o || ((e = xt(this)) && Q.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === i ? "" : Q.get(this, "__className__") || ""))
            })
        },
        hasClass: function(e) {
            var t, n, r = 0;
            t = " " + e + " ";
            while (n = this[r++])
                if (1 === n.nodeType && -1 < (" " + mt(xt(n)) + " ").indexOf(t)) return !0;
            return !1
        }
    });
    var wt = /\r/g;
    k.fn.extend({
        val: function(n) {
            var r, e, i, t = this[0];
            return arguments.length ? (i = m(n), this.each(function(e) {
                var t;
                1 === this.nodeType && (null == (t = i ? n.call(this, e, k(this).val()) : n) ? t = "" : "number" == typeof t ? t += "" : Array.isArray(t) && (t = k.map(t, function(e) {
                    return null == e ? "" : e + ""
                })), (r = k.valHooks[this.type] || k.valHooks[this.nodeName.toLowerCase()]) && "set" in r && void 0 !== r.set(this, t, "value") || (this.value = t))
            })) : t ? (r = k.valHooks[t.type] || k.valHooks[t.nodeName.toLowerCase()]) && "get" in r && void 0 !== (e = r.get(t, "value")) ? e : "string" == typeof(e = t.value) ? e.replace(wt, "") : null == e ? "" : e : void 0
        }
    }), k.extend({
        valHooks: {
            option: {
                get: function(e) {
                    var t = k.find.attr(e, "value");
                    return null != t ? t : mt(k.text(e))
                }
            },
            select: {
                get: function(e) {
                    var t, n, r, i = e.options,
                        o = e.selectedIndex,
                        a = "select-one" === e.type,
                        s = a ? null : [],
                        u = a ? o + 1 : i.length;
                    for (r = o < 0 ? u : a ? o : 0; r < u; r++)
                        if (((n = i[r]).selected || r === o) && !n.disabled && (!n.parentNode.disabled || !A(n.parentNode, "optgroup"))) {
                            if (t = k(n).val(), a) return t;
                            s.push(t)
                        }
                    return s
                },
                set: function(e, t) {
                    var n, r, i = e.options,
                        o = k.makeArray(t),
                        a = i.length;
                    while (a--)((r = i[a]).selected = -1 < k.inArray(k.valHooks.option.get(r), o)) && (n = !0);
                    return n || (e.selectedIndex = -1), o
                }
            }
        }
    }), k.each(["radio", "checkbox"], function() {
        k.valHooks[this] = {
            set: function(e, t) {
                if (Array.isArray(t)) return e.checked = -1 < k.inArray(k(e).val(), t)
            }
        }, y.checkOn || (k.valHooks[this].get = function(e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    }), y.focusin = "onfocusin" in C;
    var Tt = /^(?:focusinfocus|focusoutblur)$/,
        Ct = function(e) {
            e.stopPropagation()
        };
    k.extend(k.event, {
        trigger: function(e, t, n, r) {
            var i, o, a, s, u, l, c, f, p = [n || E],
                d = v.call(e, "type") ? e.type : e,
                h = v.call(e, "namespace") ? e.namespace.split(".") : [];
            if (o = f = a = n = n || E, 3 !== n.nodeType && 8 !== n.nodeType && !Tt.test(d + k.event.triggered) && (-1 < d.indexOf(".") && (d = (h = d.split(".")).shift(), h.sort()), u = d.indexOf(":") < 0 && "on" + d, (e = e[k.expando] ? e : new k.Event(d, "object" == typeof e && e)).isTrigger = r ? 2 : 3, e.namespace = h.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), t = null == t ? [e] : k.makeArray(t, [e]), c = k.event.special[d] || {}, r || !c.trigger || !1 !== c.trigger.apply(n, t))) {
                if (!r && !c.noBubble && !x(n)) {
                    for (s = c.delegateType || d, Tt.test(s + d) || (o = o.parentNode); o; o = o.parentNode) p.push(o), a = o;
                    a === (n.ownerDocument || E) && p.push(a.defaultView || a.parentWindow || C)
                }
                i = 0;
                while ((o = p[i++]) && !e.isPropagationStopped()) f = o, e.type = 1 < i ? s : c.bindType || d, (l = (Q.get(o, "events") || {})[e.type] && Q.get(o, "handle")) && l.apply(o, t), (l = u && o[u]) && l.apply && G(o) && (e.result = l.apply(o, t), !1 === e.result && e.preventDefault());
                return e.type = d, r || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(p.pop(), t) || !G(n) || u && m(n[d]) && !x(n) && ((a = n[u]) && (n[u] = null), k.event.triggered = d, e.isPropagationStopped() && f.addEventListener(d, Ct), n[d](), e.isPropagationStopped() && f.removeEventListener(d, Ct), k.event.triggered = void 0, a && (n[u] = a)), e.result
            }
        },
        simulate: function(e, t, n) {
            var r = k.extend(new k.Event, n, {
                type: e,
                isSimulated: !0
            });
            k.event.trigger(r, null, t)
        }
    }), k.fn.extend({
        trigger: function(e, t) {
            return this.each(function() {
                k.event.trigger(e, t, this)
            })
        },
        triggerHandler: function(e, t) {
            var n = this[0];
            if (n) return k.event.trigger(e, t, n, !0)
        }
    }), y.focusin || k.each({
        focus: "focusin",
        blur: "focusout"
    }, function(n, r) {
        var i = function(e) {
            k.event.simulate(r, e.target, k.event.fix(e))
        };
        k.event.special[r] = {
            setup: function() {
                var e = this.ownerDocument || this,
                    t = Q.access(e, r);
                t || e.addEventListener(n, i, !0), Q.access(e, r, (t || 0) + 1)
            },
            teardown: function() {
                var e = this.ownerDocument || this,
                    t = Q.access(e, r) - 1;
                t ? Q.access(e, r, t) : (e.removeEventListener(n, i, !0), Q.remove(e, r))
            }
        }
    });
    var Et = C.location,
        kt = Date.now(),
        St = /\?/;
    k.parseXML = function(e) {
        var t;
        if (!e || "string" != typeof e) return null;
        try {
            t = (new C.DOMParser).parseFromString(e, "text/xml")
        } catch (e) {
            t = void 0
        }
        return t && !t.getElementsByTagName("parsererror").length || k.error("Invalid XML: " + e), t
    };
    var Nt = /\[\]$/,
        At = /\r?\n/g,
        Dt = /^(?:submit|button|image|reset|file)$/i,
        jt = /^(?:input|select|textarea|keygen)/i;

    function qt(n, e, r, i) {
        var t;
        if (Array.isArray(e)) k.each(e, function(e, t) {
            r || Nt.test(n) ? i(n, t) : qt(n + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, r, i)
        });
        else if (r || "object" !== w(e)) i(n, e);
        else
            for (t in e) qt(n + "[" + t + "]", e[t], r, i)
    }
    k.param = function(e, t) {
        var n, r = [],
            i = function(e, t) {
                var n = m(t) ? t() : t;
                r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
            };
        if (null == e) return "";
        if (Array.isArray(e) || e.jquery && !k.isPlainObject(e)) k.each(e, function() {
            i(this.name, this.value)
        });
        else
            for (n in e) qt(n, e[n], t, i);
        return r.join("&")
    }, k.fn.extend({
        serialize: function() {
            return k.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map(function() {
                var e = k.prop(this, "elements");
                return e ? k.makeArray(e) : this
            }).filter(function() {
                var e = this.type;
                return this.name && !k(this).is(":disabled") && jt.test(this.nodeName) && !Dt.test(e) && (this.checked || !pe.test(e))
            }).map(function(e, t) {
                var n = k(this).val();
                return null == n ? null : Array.isArray(n) ? k.map(n, function(e) {
                    return {
                        name: t.name,
                        value: e.replace(At, "\r\n")
                    }
                }) : {
                    name: t.name,
                    value: n.replace(At, "\r\n")
                }
            }).get()
        }
    });
    var Lt = /%20/g,
        Ht = /#.*$/,
        Ot = /([?&])_=[^&]*/,
        Pt = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        Rt = /^(?:GET|HEAD)$/,
        Mt = /^\/\//,
        It = {},
        Wt = {},
        $t = "*/".concat("*"),
        Ft = E.createElement("a");

    function Bt(o) {
        return function(e, t) {
            "string" != typeof e && (t = e, e = "*");
            var n, r = 0,
                i = e.toLowerCase().match(R) || [];
            if (m(t))
                while (n = i[r++]) "+" === n[0] ? (n = n.slice(1) || "*", (o[n] = o[n] || []).unshift(t)) : (o[n] = o[n] || []).push(t)
        }
    }

    function _t(t, i, o, a) {
        var s = {},
            u = t === Wt;

        function l(e) {
            var r;
            return s[e] = !0, k.each(t[e] || [], function(e, t) {
                var n = t(i, o, a);
                return "string" != typeof n || u || s[n] ? u ? !(r = n) : void 0 : (i.dataTypes.unshift(n), l(n), !1)
            }), r
        }
        return l(i.dataTypes[0]) || !s["*"] && l("*")
    }

    function zt(e, t) {
        var n, r, i = k.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
        return r && k.extend(!0, e, r), e
    }
    Ft.href = Et.href, k.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: Et.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(Et.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": $t,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": JSON.parse,
                "text xml": k.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(e, t) {
            return t ? zt(zt(e, k.ajaxSettings), t) : zt(k.ajaxSettings, e)
        },
        ajaxPrefilter: Bt(It),
        ajaxTransport: Bt(Wt),
        ajax: function(e, t) {
            "object" == typeof e && (t = e, e = void 0), t = t || {};
            var c, f, p, n, d, r, h, g, i, o, v = k.ajaxSetup({}, t),
                y = v.context || v,
                m = v.context && (y.nodeType || y.jquery) ? k(y) : k.event,
                x = k.Deferred(),
                b = k.Callbacks("once memory"),
                w = v.statusCode || {},
                a = {},
                s = {},
                u = "canceled",
                T = {
                    readyState: 0,
                    getResponseHeader: function(e) {
                        var t;
                        if (h) {
                            if (!n) {
                                n = {};
                                while (t = Pt.exec(p)) n[t[1].toLowerCase() + " "] = (n[t[1].toLowerCase() + " "] || []).concat(t[2])
                            }
                            t = n[e.toLowerCase() + " "]
                        }
                        return null == t ? null : t.join(", ")
                    },
                    getAllResponseHeaders: function() {
                        return h ? p : null
                    },
                    setRequestHeader: function(e, t) {
                        return null == h && (e = s[e.toLowerCase()] = s[e.toLowerCase()] || e, a[e] = t), this
                    },
                    overrideMimeType: function(e) {
                        return null == h && (v.mimeType = e), this
                    },
                    statusCode: function(e) {
                        var t;
                        if (e)
                            if (h) T.always(e[T.status]);
                            else
                                for (t in e) w[t] = [w[t], e[t]];
                        return this
                    },
                    abort: function(e) {
                        var t = e || u;
                        return c && c.abort(t), l(0, t), this
                    }
                };
            if (x.promise(T), v.url = ((e || v.url || Et.href) + "").replace(Mt, Et.protocol + "//"), v.type = t.method || t.type || v.method || v.type, v.dataTypes = (v.dataType || "*").toLowerCase().match(R) || [""], null == v.crossDomain) {
                r = E.createElement("a");
                try {
                    r.href = v.url, r.href = r.href, v.crossDomain = Ft.protocol + "//" + Ft.host != r.protocol + "//" + r.host
                } catch (e) {
                    v.crossDomain = !0
                }
            }
            if (v.data && v.processData && "string" != typeof v.data && (v.data = k.param(v.data, v.traditional)), _t(It, v, t, T), h) return T;
            for (i in (g = k.event && v.global) && 0 == k.active++ && k.event.trigger("ajaxStart"), v.type = v.type.toUpperCase(), v.hasContent = !Rt.test(v.type), f = v.url.replace(Ht, ""), v.hasContent ? v.data && v.processData && 0 === (v.contentType || "").indexOf("application/x-www-form-urlencoded") && (v.data = v.data.replace(Lt, "+")) : (o = v.url.slice(f.length), v.data && (v.processData || "string" == typeof v.data) && (f += (St.test(f) ? "&" : "?") + v.data, delete v.data), !1 === v.cache && (f = f.replace(Ot, "$1"), o = (St.test(f) ? "&" : "?") + "_=" + kt++ + o), v.url = f + o), v.ifModified && (k.lastModified[f] && T.setRequestHeader("If-Modified-Since", k.lastModified[f]), k.etag[f] && T.setRequestHeader("If-None-Match", k.etag[f])), (v.data && v.hasContent && !1 !== v.contentType || t.contentType) && T.setRequestHeader("Content-Type", v.contentType), T.setRequestHeader("Accept", v.dataTypes[0] && v.accepts[v.dataTypes[0]] ? v.accepts[v.dataTypes[0]] + ("*" !== v.dataTypes[0] ? ", " + $t + "; q=0.01" : "") : v.accepts["*"]), v.headers) T.setRequestHeader(i, v.headers[i]);
            if (v.beforeSend && (!1 === v.beforeSend.call(y, T, v) || h)) return T.abort();
            if (u = "abort", b.add(v.complete), T.done(v.success), T.fail(v.error), c = _t(Wt, v, t, T)) {
                if (T.readyState = 1, g && m.trigger("ajaxSend", [T, v]), h) return T;
                v.async && 0 < v.timeout && (d = C.setTimeout(function() {
                    T.abort("timeout")
                }, v.timeout));
                try {
                    h = !1, c.send(a, l)
                } catch (e) {
                    if (h) throw e;
                    l(-1, e)
                }
            } else l(-1, "No Transport");

            function l(e, t, n, r) {
                var i, o, a, s, u, l = t;
                h || (h = !0, d && C.clearTimeout(d), c = void 0, p = r || "", T.readyState = 0 < e ? 4 : 0, i = 200 <= e && e < 300 || 304 === e, n && (s = function(e, t, n) {
                    var r, i, o, a, s = e.contents,
                        u = e.dataTypes;
                    while ("*" === u[0]) u.shift(), void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (r)
                        for (i in s)
                            if (s[i] && s[i].test(r)) {
                                u.unshift(i);
                                break
                            }
                    if (u[0] in n) o = u[0];
                    else {
                        for (i in n) {
                            if (!u[0] || e.converters[i + " " + u[0]]) {
                                o = i;
                                break
                            }
                            a || (a = i)
                        }
                        o = o || a
                    }
                    if (o) return o !== u[0] && u.unshift(o), n[o]
                }(v, T, n)), s = function(e, t, n, r) {
                    var i, o, a, s, u, l = {},
                        c = e.dataTypes.slice();
                    if (c[1])
                        for (a in e.converters) l[a.toLowerCase()] = e.converters[a];
                    o = c.shift();
                    while (o)
                        if (e.responseFields[o] && (n[e.responseFields[o]] = t), !u && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), u = o, o = c.shift())
                            if ("*" === o) o = u;
                            else if ("*" !== u && u !== o) {
                        if (!(a = l[u + " " + o] || l["* " + o]))
                            for (i in l)
                                if ((s = i.split(" "))[1] === o && (a = l[u + " " + s[0]] || l["* " + s[0]])) {
                                    !0 === a ? a = l[i] : !0 !== l[i] && (o = s[0], c.unshift(s[1]));
                                    break
                                }
                        if (!0 !== a)
                            if (a && e["throws"]) t = a(t);
                            else try {
                                t = a(t)
                            } catch (e) {
                                return {
                                    state: "parsererror",
                                    error: a ? e : "No conversion from " + u + " to " + o
                                }
                            }
                    }
                    return {
                        state: "success",
                        data: t
                    }
                }(v, s, T, i), i ? (v.ifModified && ((u = T.getResponseHeader("Last-Modified")) && (k.lastModified[f] = u), (u = T.getResponseHeader("etag")) && (k.etag[f] = u)), 204 === e || "HEAD" === v.type ? l = "nocontent" : 304 === e ? l = "notmodified" : (l = s.state, o = s.data, i = !(a = s.error))) : (a = l, !e && l || (l = "error", e < 0 && (e = 0))), T.status = e, T.statusText = (t || l) + "", i ? x.resolveWith(y, [o, l, T]) : x.rejectWith(y, [T, l, a]), T.statusCode(w), w = void 0, g && m.trigger(i ? "ajaxSuccess" : "ajaxError", [T, v, i ? o : a]), b.fireWith(y, [T, l]), g && (m.trigger("ajaxComplete", [T, v]), --k.active || k.event.trigger("ajaxStop")))
            }
            return T
        },
        getJSON: function(e, t, n) {
            return k.get(e, t, n, "json")
        },
        getScript: function(e, t) {
            return k.get(e, void 0, t, "script")
        }
    }), k.each(["get", "post"], function(e, i) {
        k[i] = function(e, t, n, r) {
            return m(t) && (r = r || n, n = t, t = void 0), k.ajax(k.extend({
                url: e,
                type: i,
                dataType: r,
                data: t,
                success: n
            }, k.isPlainObject(e) && e))
        }
    }), k._evalUrl = function(e, t) {
        return k.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            converters: {
                "text script": function() {}
            },
            dataFilter: function(e) {
                k.globalEval(e, t)
            }
        })
    }, k.fn.extend({
        wrapAll: function(e) {
            var t;
            return this[0] && (m(e) && (e = e.call(this[0])), t = k(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
                var e = this;
                while (e.firstElementChild) e = e.firstElementChild;
                return e
            }).append(this)), this
        },
        wrapInner: function(n) {
            return m(n) ? this.each(function(e) {
                k(this).wrapInner(n.call(this, e))
            }) : this.each(function() {
                var e = k(this),
                    t = e.contents();
                t.length ? t.wrapAll(n) : e.append(n)
            })
        },
        wrap: function(t) {
            var n = m(t);
            return this.each(function(e) {
                k(this).wrapAll(n ? t.call(this, e) : t)
            })
        },
        unwrap: function(e) {
            return this.parent(e).not("body").each(function() {
                k(this).replaceWith(this.childNodes)
            }), this
        }
    }), k.expr.pseudos.hidden = function(e) {
        return !k.expr.pseudos.visible(e)
    }, k.expr.pseudos.visible = function(e) {
        return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, k.ajaxSettings.xhr = function() {
        try {
            return new C.XMLHttpRequest
        } catch (e) {}
    };
    var Ut = {
            0: 200,
            1223: 204
        },
        Xt = k.ajaxSettings.xhr();
    y.cors = !!Xt && "withCredentials" in Xt, y.ajax = Xt = !!Xt, k.ajaxTransport(function(i) {
        var o, a;
        if (y.cors || Xt && !i.crossDomain) return {
            send: function(e, t) {
                var n, r = i.xhr();
                if (r.open(i.type, i.url, i.async, i.username, i.password), i.xhrFields)
                    for (n in i.xhrFields) r[n] = i.xhrFields[n];
                for (n in i.mimeType && r.overrideMimeType && r.overrideMimeType(i.mimeType), i.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) r.setRequestHeader(n, e[n]);
                o = function(e) {
                    return function() {
                        o && (o = a = r.onload = r.onerror = r.onabort = r.ontimeout = r.onreadystatechange = null, "abort" === e ? r.abort() : "error" === e ? "number" != typeof r.status ? t(0, "error") : t(r.status, r.statusText) : t(Ut[r.status] || r.status, r.statusText, "text" !== (r.responseType || "text") || "string" != typeof r.responseText ? {
                            binary: r.response
                        } : {
                            text: r.responseText
                        }, r.getAllResponseHeaders()))
                    }
                }, r.onload = o(), a = r.onerror = r.ontimeout = o("error"), void 0 !== r.onabort ? r.onabort = a : r.onreadystatechange = function() {
                    4 === r.readyState && C.setTimeout(function() {
                        o && a()
                    })
                }, o = o("abort");
                try {
                    r.send(i.hasContent && i.data || null)
                } catch (e) {
                    if (o) throw e
                }
            },
            abort: function() {
                o && o()
            }
        }
    }), k.ajaxPrefilter(function(e) {
        e.crossDomain && (e.contents.script = !1)
    }), k.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function(e) {
                return k.globalEval(e), e
            }
        }
    }), k.ajaxPrefilter("script", function(e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), k.ajaxTransport("script", function(n) {
        var r, i;
        if (n.crossDomain || n.scriptAttrs) return {
            send: function(e, t) {
                r = k("<script>").attr(n.scriptAttrs || {}).prop({
                    charset: n.scriptCharset,
                    src: n.url
                }).on("load error", i = function(e) {
                    r.remove(), i = null, e && t("error" === e.type ? 404 : 200, e.type)
                }), E.head.appendChild(r[0])
            },
            abort: function() {
                i && i()
            }
        }
    });
    var Vt, Gt = [],
        Yt = /(=)\?(?=&|$)|\?\?/;
    k.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var e = Gt.pop() || k.expando + "_" + kt++;
            return this[e] = !0, e
        }
    }), k.ajaxPrefilter("json jsonp", function(e, t, n) {
        var r, i, o, a = !1 !== e.jsonp && (Yt.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Yt.test(e.data) && "data");
        if (a || "jsonp" === e.dataTypes[0]) return r = e.jsonpCallback = m(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Yt, "$1" + r) : !1 !== e.jsonp && (e.url += (St.test(e.url) ? "&" : "?") + e.jsonp + "=" + r), e.converters["script json"] = function() {
            return o || k.error(r + " was not called"), o[0]
        }, e.dataTypes[0] = "json", i = C[r], C[r] = function() {
            o = arguments
        }, n.always(function() {
            void 0 === i ? k(C).removeProp(r) : C[r] = i, e[r] && (e.jsonpCallback = t.jsonpCallback, Gt.push(r)), o && m(i) && i(o[0]), o = i = void 0
        }), "script"
    }), y.createHTMLDocument = ((Vt = E.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === Vt.childNodes.length), k.parseHTML = function(e, t, n) {
        return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (y.createHTMLDocument ? ((r = (t = E.implementation.createHTMLDocument("")).createElement("base")).href = E.location.href, t.head.appendChild(r)) : t = E), o = !n && [], (i = D.exec(e)) ? [t.createElement(i[1])] : (i = we([e], t, o), o && o.length && k(o).remove(), k.merge([], i.childNodes)));
        var r, i, o
    }, k.fn.load = function(e, t, n) {
        var r, i, o, a = this,
            s = e.indexOf(" ");
        return -1 < s && (r = mt(e.slice(s)), e = e.slice(0, s)), m(t) ? (n = t, t = void 0) : t && "object" == typeof t && (i = "POST"), 0 < a.length && k.ajax({
            url: e,
            type: i || "GET",
            dataType: "html",
            data: t
        }).done(function(e) {
            o = arguments, a.html(r ? k("<div>").append(k.parseHTML(e)).find(r) : e)
        }).always(n && function(e, t) {
            a.each(function() {
                n.apply(this, o || [e.responseText, t, e])
            })
        }), this
    }, k.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
        k.fn[t] = function(e) {
            return this.on(t, e)
        }
    }), k.expr.pseudos.animated = function(t) {
        return k.grep(k.timers, function(e) {
            return t === e.elem
        }).length
    }, k.offset = {
        setOffset: function(e, t, n) {
            var r, i, o, a, s, u, l = k.css(e, "position"),
                c = k(e),
                f = {};
            "static" === l && (e.style.position = "relative"), s = c.offset(), o = k.css(e, "top"), u = k.css(e, "left"), ("absolute" === l || "fixed" === l) && -1 < (o + u).indexOf("auto") ? (a = (r = c.position()).top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(u) || 0), m(t) && (t = t.call(e, n, k.extend({}, s))), null != t.top && (f.top = t.top - s.top + a), null != t.left && (f.left = t.left - s.left + i), "using" in t ? t.using.call(e, f) : c.css(f)
        }
    }, k.fn.extend({
        offset: function(t) {
            if (arguments.length) return void 0 === t ? this : this.each(function(e) {
                k.offset.setOffset(this, t, e)
            });
            var e, n, r = this[0];
            return r ? r.getClientRects().length ? (e = r.getBoundingClientRect(), n = r.ownerDocument.defaultView, {
                top: e.top + n.pageYOffset,
                left: e.left + n.pageXOffset
            }) : {
                top: 0,
                left: 0
            } : void 0
        },
        position: function() {
            if (this[0]) {
                var e, t, n, r = this[0],
                    i = {
                        top: 0,
                        left: 0
                    };
                if ("fixed" === k.css(r, "position")) t = r.getBoundingClientRect();
                else {
                    t = this.offset(), n = r.ownerDocument, e = r.offsetParent || n.documentElement;
                    while (e && (e === n.body || e === n.documentElement) && "static" === k.css(e, "position")) e = e.parentNode;
                    e && e !== r && 1 === e.nodeType && ((i = k(e).offset()).top += k.css(e, "borderTopWidth", !0), i.left += k.css(e, "borderLeftWidth", !0))
                }
                return {
                    top: t.top - i.top - k.css(r, "marginTop", !0),
                    left: t.left - i.left - k.css(r, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map(function() {
                var e = this.offsetParent;
                while (e && "static" === k.css(e, "position")) e = e.offsetParent;
                return e || ie
            })
        }
    }), k.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(t, i) {
        var o = "pageYOffset" === i;
        k.fn[t] = function(e) {
            return _(this, function(e, t, n) {
                var r;
                if (x(e) ? r = e : 9 === e.nodeType && (r = e.defaultView), void 0 === n) return r ? r[i] : e[t];
                r ? r.scrollTo(o ? r.pageXOffset : n, o ? n : r.pageYOffset) : e[t] = n
            }, t, e, arguments.length)
        }
    }), k.each(["top", "left"], function(e, n) {
        k.cssHooks[n] = ze(y.pixelPosition, function(e, t) {
            if (t) return t = _e(e, n), $e.test(t) ? k(e).position()[n] + "px" : t
        })
    }), k.each({
        Height: "height",
        Width: "width"
    }, function(a, s) {
        k.each({
            padding: "inner" + a,
            content: s,
            "": "outer" + a
        }, function(r, o) {
            k.fn[o] = function(e, t) {
                var n = arguments.length && (r || "boolean" != typeof e),
                    i = r || (!0 === e || !0 === t ? "margin" : "border");
                return _(this, function(e, t, n) {
                    var r;
                    return x(e) ? 0 === o.indexOf("outer") ? e["inner" + a] : e.document.documentElement["client" + a] : 9 === e.nodeType ? (r = e.documentElement, Math.max(e.body["scroll" + a], r["scroll" + a], e.body["offset" + a], r["offset" + a], r["client" + a])) : void 0 === n ? k.css(e, t, i) : k.style(e, t, n, i)
                }, s, n ? e : void 0, n)
            }
        })
    }), k.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(e, n) {
        k.fn[n] = function(e, t) {
            return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n)
        }
    }), k.fn.extend({
        hover: function(e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), k.fn.extend({
        bind: function(e, t, n) {
            return this.on(e, null, t, n)
        },
        unbind: function(e, t) {
            return this.off(e, null, t)
        },
        delegate: function(e, t, n, r) {
            return this.on(t, e, n, r)
        },
        undelegate: function(e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }
    }), k.proxy = function(e, t) {
        var n, r, i;
        if ("string" == typeof t && (n = e[t], t = e, e = n), m(e)) return r = s.call(arguments, 2), (i = function() {
            return e.apply(t || this, r.concat(s.call(arguments)))
        }).guid = e.guid = e.guid || k.guid++, i
    }, k.holdReady = function(e) {
        e ? k.readyWait++ : k.ready(!0)
    }, k.isArray = Array.isArray, k.parseJSON = JSON.parse, k.nodeName = A, k.isFunction = m, k.isWindow = x, k.camelCase = V, k.type = w, k.now = Date.now, k.isNumeric = function(e) {
        var t = k.type(e);
        return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, "function" == typeof define && define.amd && define("jquery", [], function() {
        return k
    });
    var Qt = C.jQuery,
        Jt = C.$;
    return k.noConflict = function(e) {
        return C.$ === k && (C.$ = Jt), e && C.jQuery === k && (C.jQuery = Qt), k
    }, e || (C.jQuery = C.$ = k), k
});
/*!
 * Bootstrap v4.4.1 (https://getbootstrap.com/)
 * Copyright 2011-2019 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
! function(e, t) {
	"object" == typeof exports && "undefined" != typeof module ? t(exports, require("jquery")) : "function" ==
		typeof define && define.amd ? define(["exports", "jquery"], t) : t((e = e || self)
			.bootstrap = {}, e.jQuery)
}(this, function(e, p) {
	"use strict";

	function i(e, t) {
		for (var n = 0; n < t.length; n++) {
			var i = t[n];
			i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object
				.defineProperty(e, i.key, i)
		}
	}

	function s(e, t, n) {
		return t && i(e.prototype, t), n && i(e, n), e
	}

	function t(t, e) {
		var n = Object.keys(t);
		if (Object.getOwnPropertySymbols) {
			var i = Object.getOwnPropertySymbols(t);
			e && (i = i.filter(function(e) {
				return Object.getOwnPropertyDescriptor(t, e)
					.enumerable
			})), n.push.apply(n, i)
		}
		return n
	}

	function l(o) {
		for (var e = 1; e < arguments.length; e++) {
			var r = null != arguments[e] ? arguments[e] : {};
			e % 2 ? t(Object(r), !0)
				.forEach(function(e) {
					var t, n, i;
					t = o, i = r[n = e], n in t ? Object.defineProperty(t, n, {
						value: i,
						enumerable: !0,
						configurable: !0,
						writable: !0
					}) : t[n] = i
				}) : Object.getOwnPropertyDescriptors ? Object.defineProperties(o, Object.getOwnPropertyDescriptors(r)) : t(
					Object(r))
				.forEach(function(e) {
					Object.defineProperty(o, e, Object.getOwnPropertyDescriptor(r, e))
				})
		}
		return o
	}
	p = p && p.hasOwnProperty("default") ? p.default : p;
	var n = "transitionend";

	function o(e) {
		var t = this,
			n = !1;
		return p(this)
			.one(m.TRANSITION_END, function() {
				n = !0
			}), setTimeout(function() {
				n || m.triggerTransitionEnd(t)
			}, e), this
	}
	var m = {
		TRANSITION_END: "bsTransitionEnd",
		getUID: function(e) {
			for (; e += ~~(1e6 * Math.random()), document.getElementById(e););
			return e
		},
		getSelectorFromElement: function(e) {
			var t = e.getAttribute("data-target");
			if (!t || "#" === t) {
				var n = e.getAttribute("href");
				t = n && "#" !== n ? n.trim() : ""
			}
			try {
				return document.querySelector(t) ? t : null
			} catch (e) {
				return null
			}
		},
		getTransitionDurationFromElement: function(e) {
			if (!e) return 0;
			var t = p(e)
				.css("transition-duration"),
				n = p(e)
				.css("transition-delay"),
				i = parseFloat(t),
				o = parseFloat(n);
			return i || o ? (t = t.split(",")[0], n = n.split(",")[0], 1e3 * (parseFloat(t) + parseFloat(n))) : 0
		},
		reflow: function(e) {
			return e.offsetHeight
		},
		triggerTransitionEnd: function(e) {
			p(e)
				.trigger(n)
		},
		supportsTransitionEnd: function() {
			return Boolean(n)
		},
		isElement: function(e) {
			return (e[0] || e)
				.nodeType
		},
		typeCheckConfig: function(e, t, n) {
			for (var i in n)
				if (Object.prototype.hasOwnProperty.call(n, i)) {
					var o = n[i],
						r = t[i],
						s = r && m.isElement(r) ? "element" : (a = r, {}.toString.call(a)
							.match(/\s([a-z]+)/i)[1].toLowerCase());
					if (!new RegExp(o)
						.test(s)) throw new Error(e.toUpperCase() + ': Option "' + i + '" provided type "' + s +
						'" but expected type "' + o + '".')
				}
			var a
		},
		findShadowRoot: function(e) {
			if (!document.documentElement.attachShadow) return null;
			if ("function" != typeof e.getRootNode) return e instanceof ShadowRoot ? e : e.parentNode ? m
				.findShadowRoot(e.parentNode) : null;
			var t = e.getRootNode();
			return t instanceof ShadowRoot ? t : null
		},
		jQueryDetection: function() {
			if ("undefined" == typeof p) throw new TypeError(
				"Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");
			var e = p.fn.jquery.split(" ")[0].split(".");
			if (e[0] < 2 && e[1] < 9 || 1 === e[0] && 9 === e[1] && e[2] < 1 || 4 <= e[0]) throw new Error(
				"Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")
		}
	};
	m.jQueryDetection(), p.fn.emulateTransitionEnd = o, p.event.special[m.TRANSITION_END] = {
		bindType: n,
		delegateType: n,
		handle: function(e) {
			if (p(e.target)
				.is(this)) return e.handleObj.handler.apply(this, arguments)
		}
	};
	var r = "alert",
		a = "bs.alert",
		c = "." + a,
		h = p.fn[r],
		u = {
			CLOSE: "close" + c,
			CLOSED: "closed" + c,
			CLICK_DATA_API: "click" + c + ".data-api"
		},
		f = "alert",
		d = "fade",
		g = "show",
		_ = function() {
			function i(e) {
				this._element = e
			}
			var e = i.prototype;
			return e.close = function(e) {
				var t = this._element;
				e && (t = this._getRootElement(e)), this._triggerCloseEvent(t)
					.isDefaultPrevented() || this._removeElement(t)
			}, e.dispose = function() {
				p.removeData(this._element, a), this._element = null
			}, e._getRootElement = function(e) {
				var t = m.getSelectorFromElement(e),
					n = !1;
				return t && (n = document.querySelector(t)), n = n || p(e)
					.closest("." + f)[0]
			}, e._triggerCloseEvent = function(e) {
				var t = p.Event(u.CLOSE);
				return p(e)
					.trigger(t), t
			}, e._removeElement = function(t) {
				var n = this;
				if (p(t)
					.removeClass(g), p(t)
					.hasClass(d)) {
					var e = m.getTransitionDurationFromElement(t);
					p(t)
						.one(m.TRANSITION_END, function(e) {
							return n._destroyElement(t, e)
						})
						.emulateTransitionEnd(e)
				} else this._destroyElement(t)
			}, e._destroyElement = function(e) {
				p(e)
					.detach()
					.trigger(u.CLOSED)
					.remove()
			}, i._jQueryInterface = function(n) {
				return this.each(function() {
					var e = p(this),
						t = e.data(a);
					t || (t = new i(this), e.data(a, t)), "close" === n && t[n](this)
				})
			}, i._handleDismiss = function(t) {
				return function(e) {
					e && e.preventDefault(), t.close(this)
				}
			}, s(i, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }]), i
		}();
	p(document)
		.on(u.CLICK_DATA_API, '[data-dismiss="alert"]', _._handleDismiss(new _)), p.fn[r] = _._jQueryInterface, p.fn[r]
		.Constructor = _, p.fn[r].noConflict = function() {
			return p.fn[r] = h, _._jQueryInterface
		};
	var v = "button",
		y = "bs.button",
		E = "." + y,
		b = ".data-api",
		w = p.fn[v],
		T = "active",
		C = "btn",
		S = "focus",
		D = '[data-toggle^="button"]',
		I = '[data-toggle="buttons"]',
		A = '[data-toggle="button"]',
		O = '[data-toggle="buttons"] .btn',
		N = 'input:not([type="hidden"])',
		k = ".active",
		L = ".btn",
		P = {
			CLICK_DATA_API: "click" + E + b,
			FOCUS_BLUR_DATA_API: "focus" + E + b + " blur" + E + b,
			LOAD_DATA_API: "load" + E + b
		},
		x = function() {
			function n(e) {
				this._element = e
			}
			var e = n.prototype;
			return e.toggle = function() {
				var e = !0,
					t = !0,
					n = p(this._element)
					.closest(I)[0];
				if (n) {
					var i = this._element.querySelector(N);
					if (i) {
						if ("radio" === i.type)
							if (i.checked && this._element.classList.contains(T)) e = !1;
							else {
								var o = n.querySelector(k);
								o && p(o)
									.removeClass(T)
							}
						else "checkbox" === i.type ? "LABEL" === this._element.tagName && i.checked === this._element.classList
							.contains(T) && (e = !1) : e = !1;
						e && (i.checked = !this._element.classList.contains(T), p(i)
							.trigger("change")), i.focus(), t = !1
					}
				}
				this._element.hasAttribute("disabled") || this._element.classList.contains("disabled") || (t && this
					._element.setAttribute("aria-pressed", !this._element.classList.contains(T)), e && p(this._element)
					.toggleClass(T))
			}, e.dispose = function() {
				p.removeData(this._element, y), this._element = null
			}, n._jQueryInterface = function(t) {
				return this.each(function() {
					var e = p(this)
						.data(y);
					e || (e = new n(this), p(this)
						.data(y, e)), "toggle" === t && e[t]()
				})
			}, s(n, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }]), n
		}();
	p(document)
		.on(P.CLICK_DATA_API, D, function(e) {
			var t = e.target;
			if (p(t)
				.hasClass(C) || (t = p(t)
					.closest(L)[0]), !t || t.hasAttribute("disabled") || t.classList.contains("disabled")) e.preventDefault();
			else {
				var n = t.querySelector(N);
				if (n && (n.hasAttribute("disabled") || n.classList.contains("disabled"))) return void e.preventDefault();
				x._jQueryInterface.call(p(t), "toggle")
			}
		})
		.on(P.FOCUS_BLUR_DATA_API, D, function(e) {
			var t = p(e.target)
				.closest(L)[0];
			p(t)
				.toggleClass(S, /^focus(in)?$/.test(e.type))
		}), p(window)
		.on(P.LOAD_DATA_API, function() {
			for (var e = [].slice.call(document.querySelectorAll(O)), t = 0, n = e.length; t < n; t++) {
				var i = e[t],
					o = i.querySelector(N);
				o.checked || o.hasAttribute("checked") ? i.classList.add(T) : i.classList.remove(T)
			}
			for (var r = 0, s = (e = [].slice.call(document.querySelectorAll(A)))
					.length; r < s; r++) {
				var a = e[r];
				"true" === a.getAttribute("aria-pressed") ? a.classList.add(T) : a.classList.remove(T)
			}
		}), p.fn[v] = x._jQueryInterface, p.fn[v].Constructor = x, p.fn[v].noConflict = function() {
			return p.fn[v] = w, x._jQueryInterface
		};
	var j = "carousel",
		H = "bs.carousel",
		R = "." + H,
		F = ".data-api",
		M = p.fn[j],
		W = {
			interval: 5e3,
			keyboard: !0,
			slide: !1,
			pause: "hover",
			wrap: !0,
			touch: !0
		},
		U = {
			interval: "(number|boolean)",
			keyboard: "boolean",
			slide: "(boolean|string)",
			pause: "(string|boolean)",
			wrap: "boolean",
			touch: "boolean"
		},
		B = "next",
		q = "prev",
		K = "left",
		Q = "right",
		V = {
			SLIDE: "slide" + R,
			SLID: "slid" + R,
			KEYDOWN: "keydown" + R,
			MOUSEENTER: "mouseenter" + R,
			MOUSELEAVE: "mouseleave" + R,
			TOUCHSTART: "touchstart" + R,
			TOUCHMOVE: "touchmove" + R,
			TOUCHEND: "touchend" + R,
			POINTERDOWN: "pointerdown" + R,
			POINTERUP: "pointerup" + R,
			DRAG_START: "dragstart" + R,
			LOAD_DATA_API: "load" + R + F,
			CLICK_DATA_API: "click" + R + F
		},
		Y = "carousel",
		z = "active",
		X = "slide",
		G = "carousel-item-right",
		$ = "carousel-item-left",
		J = "carousel-item-next",
		Z = "carousel-item-prev",
		ee = "pointer-event",
		te = ".active",
		ne = ".active.carousel-item",
		ie = ".carousel-item",
		oe = ".carousel-item img",
		re = ".carousel-item-next, .carousel-item-prev",
		se = ".carousel-indicators",
		ae = "[data-slide], [data-slide-to]",
		le = '[data-ride="carousel"]',
		ce = {
			TOUCH: "touch",
			PEN: "pen"
		},
		he = function() {
			function r(e, t) {
				this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this
					._isSliding = !1, this.touchTimeout = null, this.touchStartX = 0, this.touchDeltaX = 0, this._config = this
					._getConfig(t), this._element = e, this._indicatorsElement = this._element.querySelector(se), this
					._touchSupported = "ontouchstart" in document.documentElement || 0 < navigator.maxTouchPoints, this
					._pointerEvent = Boolean(window.PointerEvent || window.MSPointerEvent), this._addEventListeners()
			}
			var e = r.prototype;
			return e.next = function() {
				this._isSliding || this._slide(B)
			}, e.nextWhenVisible = function() {
				!document.hidden && p(this._element)
					.is(":visible") && "hidden" !== p(this._element)
					.css("visibility") && this.next()
			}, e.prev = function() {
				this._isSliding || this._slide(q)
			}, e.pause = function(e) {
				e || (this._isPaused = !0), this._element.querySelector(re) && (m.triggerTransitionEnd(this._element), this
					.cycle(!0)), clearInterval(this._interval), this._interval = null
			}, e.cycle = function(e) {
				e || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this
					._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this
							.nextWhenVisible : this.next)
						.bind(this), this._config.interval))
			}, e.to = function(e) {
				var t = this;
				this._activeElement = this._element.querySelector(ne);
				var n = this._getItemIndex(this._activeElement);
				if (!(e > this._items.length - 1 || e < 0))
					if (this._isSliding) p(this._element)
						.one(V.SLID, function() {
							return t.to(e)
						});
					else {
						if (n === e) return this.pause(), void this.cycle();
						var i = n < e ? B : q;
						this._slide(i, this._items[e])
					}
			}, e.dispose = function() {
				p(this._element)
					.off(R), p.removeData(this._element, H), this._items = null, this._config = null, this._element = null,
					this._interval = null, this._isPaused = null, this._isSliding = null, this._activeElement = null, this
					._indicatorsElement = null
			}, e._getConfig = function(e) {
				return e = l({}, W, {}, e), m.typeCheckConfig(j, e, U), e
			}, e._handleSwipe = function() {
				var e = Math.abs(this.touchDeltaX);
				if (!(e <= 40)) {
					var t = e / this.touchDeltaX;
					(this.touchDeltaX = 0) < t && this.prev(), t < 0 && this.next()
				}
			}, e._addEventListeners = function() {
				var t = this;
				this._config.keyboard && p(this._element)
					.on(V.KEYDOWN, function(e) {
						return t._keydown(e)
					}), "hover" === this._config.pause && p(this._element)
					.on(V.MOUSEENTER, function(e) {
						return t.pause(e)
					})
					.on(V.MOUSELEAVE, function(e) {
						return t.cycle(e)
					}), this._config.touch && this._addTouchEventListeners()
			}, e._addTouchEventListeners = function() {
				var t = this;
				if (this._touchSupported) {
					var n = function(e) {
							t._pointerEvent && ce[e.originalEvent.pointerType.toUpperCase()] ? t.touchStartX = e.originalEvent
								.clientX : t._pointerEvent || (t.touchStartX = e.originalEvent.touches[0].clientX)
						},
						i = function(e) {
							t._pointerEvent && ce[e.originalEvent.pointerType.toUpperCase()] && (t.touchDeltaX = e.originalEvent
								.clientX - t.touchStartX), t._handleSwipe(), "hover" === t._config.pause && (t.pause(), t
								.touchTimeout && clearTimeout(t.touchTimeout), t.touchTimeout = setTimeout(function(e) {
									return t.cycle(e)
								}, 500 + t._config.interval))
						};
					p(this._element.querySelectorAll(oe))
						.on(V.DRAG_START, function(e) {
							return e.preventDefault()
						}), this._pointerEvent ? (p(this._element)
							.on(V.POINTERDOWN, function(e) {
								return n(e)
							}), p(this._element)
							.on(V.POINTERUP, function(e) {
								return i(e)
							}), this._element.classList.add(ee)) : (p(this._element)
							.on(V.TOUCHSTART, function(e) {
								return n(e)
							}), p(this._element)
							.on(V.TOUCHMOVE, function(e) {
								return function(e) {
									e.originalEvent.touches && 1 < e.originalEvent.touches.length ? t.touchDeltaX = 0 : t
										.touchDeltaX = e.originalEvent.touches[0].clientX - t.touchStartX
								}(e)
							}), p(this._element)
							.on(V.TOUCHEND, function(e) {
								return i(e)
							}))
				}
			}, e._keydown = function(e) {
				if (!/input|textarea/i.test(e.target.tagName)) switch (e.which) {
					case 37:
						e.preventDefault(), this.prev();
						break;
					case 39:
						e.preventDefault(), this.next()
				}
			}, e._getItemIndex = function(e) {
				return this._items = e && e.parentNode ? [].slice.call(e.parentNode.querySelectorAll(ie)) : [], this._items
					.indexOf(e)
			}, e._getItemByDirection = function(e, t) {
				var n = e === B,
					i = e === q,
					o = this._getItemIndex(t),
					r = this._items.length - 1;
				if ((i && 0 === o || n && o === r) && !this._config.wrap) return t;
				var s = (o + (e === q ? -1 : 1)) % this._items.length;
				return -1 == s ? this._items[this._items.length - 1] : this._items[s]
			}, e._triggerSlideEvent = function(e, t) {
				var n = this._getItemIndex(e),
					i = this._getItemIndex(this._element.querySelector(ne)),
					o = p.Event(V.SLIDE, {
						relatedTarget: e,
						direction: t,
						from: i,
						to: n
					});
				return p(this._element)
					.trigger(o), o
			}, e._setActiveIndicatorElement = function(e) {
				if (this._indicatorsElement) {
					var t = [].slice.call(this._indicatorsElement.querySelectorAll(te));
					p(t)
						.removeClass(z);
					var n = this._indicatorsElement.children[this._getItemIndex(e)];
					n && p(n)
						.addClass(z)
				}
			}, e._slide = function(e, t) {
				var n, i, o, r = this,
					s = this._element.querySelector(ne),
					a = this._getItemIndex(s),
					l = t || s && this._getItemByDirection(e, s),
					c = this._getItemIndex(l),
					h = Boolean(this._interval);
				if (o = e === B ? (n = $, i = J, K) : (n = G, i = Z, Q), l && p(l)
					.hasClass(z)) this._isSliding = !1;
				else if (!this._triggerSlideEvent(l, o)
					.isDefaultPrevented() && s && l) {
					this._isSliding = !0, h && this.pause(), this._setActiveIndicatorElement(l);
					var u = p.Event(V.SLID, {
						relatedTarget: l,
						direction: o,
						from: a,
						to: c
					});
					if (p(this._element)
						.hasClass(X)) {
						p(l)
							.addClass(i), m.reflow(l), p(s)
							.addClass(n), p(l)
							.addClass(n);
						var f = parseInt(l.getAttribute("data-interval"), 10);
						f ? (this._config.defaultInterval = this._config.defaultInterval || this._config.interval, this._config
							.interval = f) : this._config.interval = this._config.defaultInterval || this._config.interval;
						var d = m.getTransitionDurationFromElement(s);
						p(s)
							.one(m.TRANSITION_END, function() {
								p(l)
									.removeClass(n + " " + i)
									.addClass(z), p(s)
									.removeClass(z + " " + i + " " + n), r._isSliding = !1, setTimeout(function() {
										return p(r._element)
											.trigger(u)
									}, 0)
							})
							.emulateTransitionEnd(d)
					} else p(s)
						.removeClass(z), p(l)
						.addClass(z), this._isSliding = !1, p(this._element)
						.trigger(u);
					h && this.cycle()
				}
			}, r._jQueryInterface = function(i) {
				return this.each(function() {
					var e = p(this)
						.data(H),
						t = l({}, W, {}, p(this)
							.data());
					"object" == typeof i && (t = l({}, t, {}, i));
					var n = "string" == typeof i ? i : t.slide;
					if (e || (e = new r(this, t), p(this)
							.data(H, e)), "number" == typeof i) e.to(i);
					else if ("string" == typeof n) {
						if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');
						e[n]()
					} else t.interval && t.ride && (e.pause(), e.cycle())
				})
			}, r._dataApiClickHandler = function(e) {
				var t = m.getSelectorFromElement(this);
				if (t) {
					var n = p(t)[0];
					if (n && p(n)
						.hasClass(Y)) {
						var i = l({}, p(n)
								.data(), {}, p(this)
								.data()),
							o = this.getAttribute("data-slide-to");
						o && (i.interval = !1), r._jQueryInterface.call(p(n), i), o && p(n)
							.data(H)
							.to(o), e.preventDefault()
					}
				}
			}, s(r, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return W
				}
            }]), r
		}();
	p(document)
		.on(V.CLICK_DATA_API, ae, he._dataApiClickHandler), p(window)
		.on(V.LOAD_DATA_API, function() {
			for (var e = [].slice.call(document.querySelectorAll(le)), t = 0, n = e.length; t < n; t++) {
				var i = p(e[t]);
				he._jQueryInterface.call(i, i.data())
			}
		}), p.fn[j] = he._jQueryInterface, p.fn[j].Constructor = he, p.fn[j].noConflict = function() {
			return p.fn[j] = M, he._jQueryInterface
		};
	var ue = "collapse",
		fe = "bs.collapse",
		de = "." + fe,
		pe = p.fn[ue],
		me = {
			toggle: !0,
			parent: ""
		},
		ge = {
			toggle: "boolean",
			parent: "(string|element)"
		},
		_e = {
			SHOW: "show" + de,
			SHOWN: "shown" + de,
			HIDE: "hide" + de,
			HIDDEN: "hidden" + de,
			CLICK_DATA_API: "click" + de + ".data-api"
		},
		ve = "show",
		ye = "collapse",
		Ee = "collapsing",
		be = "collapsed",
		we = "width",
		Te = "height",
		Ce = ".show, .collapsing",
		Se = '[data-toggle="collapse"]',
		De = function() {
			function a(t, e) {
				this._isTransitioning = !1, this._element = t, this._config = this._getConfig(e), this._triggerArray = []
					.slice.call(document.querySelectorAll('[data-toggle="collapse"][href="#' + t.id +
						'"],[data-toggle="collapse"][data-target="#' + t.id + '"]'));
				for (var n = [].slice.call(document.querySelectorAll(Se)), i = 0, o = n.length; i < o; i++) {
					var r = n[i],
						s = m.getSelectorFromElement(r),
						a = [].slice.call(document.querySelectorAll(s))
						.filter(function(e) {
							return e === t
						});
					null !== s && 0 < a.length && (this._selector = s, this._triggerArray.push(r))
				}
				this._parent = this._config.parent ? this._getParent() : null, this._config.parent || this
					._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle()
			}
			var e = a.prototype;
			return e.toggle = function() {
				p(this._element)
					.hasClass(ve) ? this.hide() : this.show()
			}, e.show = function() {
				var e, t, n = this;
				if (!this._isTransitioning && !p(this._element)
					.hasClass(ve) && (this._parent && 0 === (e = [].slice.call(this._parent.querySelectorAll(Ce))
							.filter(function(e) {
								return "string" == typeof n._config.parent ? e.getAttribute("data-parent") === n._config.parent :
									e.classList.contains(ye)
							}))
						.length && (e = null), !(e && (t = p(e)
							.not(this._selector)
							.data(fe)) && t._isTransitioning))) {
					var i = p.Event(_e.SHOW);
					if (p(this._element)
						.trigger(i), !i.isDefaultPrevented()) {
						e && (a._jQueryInterface.call(p(e)
								.not(this._selector), "hide"), t || p(e)
							.data(fe, null));
						var o = this._getDimension();
						p(this._element)
							.removeClass(ye)
							.addClass(Ee), this._element.style[o] = 0, this._triggerArray.length && p(this._triggerArray)
							.removeClass(be)
							.attr("aria-expanded", !0), this.setTransitioning(!0);
						var r = "scroll" + (o[0].toUpperCase() + o.slice(1)),
							s = m.getTransitionDurationFromElement(this._element);
						p(this._element)
							.one(m.TRANSITION_END, function() {
								p(n._element)
									.removeClass(Ee)
									.addClass(ye)
									.addClass(ve), n._element.style[o] = "", n.setTransitioning(!1), p(n._element)
									.trigger(_e.SHOWN)
							})
							.emulateTransitionEnd(s), this._element.style[o] = this._element[r] + "px"
					}
				}
			}, e.hide = function() {
				var e = this;
				if (!this._isTransitioning && p(this._element)
					.hasClass(ve)) {
					var t = p.Event(_e.HIDE);
					if (p(this._element)
						.trigger(t), !t.isDefaultPrevented()) {
						var n = this._getDimension();
						this._element.style[n] = this._element.getBoundingClientRect()[n] + "px", m.reflow(this._element), p(
								this._element)
							.addClass(Ee)
							.removeClass(ye)
							.removeClass(ve);
						var i = this._triggerArray.length;
						if (0 < i)
							for (var o = 0; o < i; o++) {
								var r = this._triggerArray[o],
									s = m.getSelectorFromElement(r);
								if (null !== s) p([].slice.call(document.querySelectorAll(s)))
									.hasClass(ve) || p(r)
									.addClass(be)
									.attr("aria-expanded", !1)
							}
						this.setTransitioning(!0);
						this._element.style[n] = "";
						var a = m.getTransitionDurationFromElement(this._element);
						p(this._element)
							.one(m.TRANSITION_END, function() {
								e.setTransitioning(!1), p(e._element)
									.removeClass(Ee)
									.addClass(ye)
									.trigger(_e.HIDDEN)
							})
							.emulateTransitionEnd(a)
					}
				}
			}, e.setTransitioning = function(e) {
				this._isTransitioning = e
			}, e.dispose = function() {
				p.removeData(this._element, fe), this._config = null, this._parent = null, this._element = null, this
					._triggerArray = null, this._isTransitioning = null
			}, e._getConfig = function(e) {
				return (e = l({}, me, {}, e))
					.toggle = Boolean(e.toggle), m.typeCheckConfig(ue, e, ge), e
			}, e._getDimension = function() {
				return p(this._element)
					.hasClass(we) ? we : Te
			}, e._getParent = function() {
				var e, n = this;
				m.isElement(this._config.parent) ? (e = this._config.parent, "undefined" != typeof this._config.parent
					.jquery && (e = this._config.parent[0])) : e = document.querySelector(this._config.parent);
				var t = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]',
					i = [].slice.call(e.querySelectorAll(t));
				return p(i)
					.each(function(e, t) {
						n._addAriaAndCollapsedClass(a._getTargetFromElement(t), [t])
					}), e
			}, e._addAriaAndCollapsedClass = function(e, t) {
				var n = p(e)
					.hasClass(ve);
				t.length && p(t)
					.toggleClass(be, !n)
					.attr("aria-expanded", n)
			}, a._getTargetFromElement = function(e) {
				var t = m.getSelectorFromElement(e);
				return t ? document.querySelector(t) : null
			}, a._jQueryInterface = function(i) {
				return this.each(function() {
					var e = p(this),
						t = e.data(fe),
						n = l({}, me, {}, e.data(), {}, "object" == typeof i && i ? i : {});
					if (!t && n.toggle && /show|hide/.test(i) && (n.toggle = !1), t || (t = new a(this, n), e.data(fe,
						t)), "string" == typeof i) {
						if ("undefined" == typeof t[i]) throw new TypeError('No method named "' + i + '"');
						t[i]()
					}
				})
			}, s(a, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return me
				}
            }]), a
		}();
	p(document)
		.on(_e.CLICK_DATA_API, Se, function(e) {
			"A" === e.currentTarget.tagName && e.preventDefault();
			var n = p(this),
				t = m.getSelectorFromElement(this),
				i = [].slice.call(document.querySelectorAll(t));
			p(i)
				.each(function() {
					var e = p(this),
						t = e.data(fe) ? "toggle" : n.data();
					De._jQueryInterface.call(e, t)
				})
		}), p.fn[ue] = De._jQueryInterface, p.fn[ue].Constructor = De, p.fn[ue].noConflict = function() {
			return p.fn[ue] = pe, De._jQueryInterface
		};
	var Ie = "undefined" != typeof window && "undefined" != typeof document && "undefined" != typeof navigator,
		Ae = function() {
			for (var e = ["Edge", "Trident", "Firefox"], t = 0; t < e.length; t += 1)
				if (Ie && 0 <= navigator.userAgent.indexOf(e[t])) return 1;
			return 0
		}();
	var Oe = Ie && window.Promise ? function(e) {
		var t = !1;
		return function() {
			t || (t = !0, window.Promise.resolve()
				.then(function() {
					t = !1, e()
				}))
		}
	} : function(e) {
		var t = !1;
		return function() {
			t || (t = !0, setTimeout(function() {
				t = !1, e()
			}, Ae))
		}
	};

	function Ne(e) {
		return e && "[object Function]" === {}.toString.call(e)
	}

	function ke(e, t) {
		if (1 !== e.nodeType) return [];
		var n = e.ownerDocument.defaultView.getComputedStyle(e, null);
		return t ? n[t] : n
	}

	function Le(e) {
		return "HTML" === e.nodeName ? e : e.parentNode || e.host
	}

	function Pe(e) {
		if (!e) return document.body;
		switch (e.nodeName) {
			case "HTML":
			case "BODY":
				return e.ownerDocument.body;
			case "#document":
				return e.body
		}
		var t = ke(e),
			n = t.overflow,
			i = t.overflowX,
			o = t.overflowY;
		return /(auto|scroll|overlay)/.test(n + o + i) ? e : Pe(Le(e))
	}

	function xe(e) {
		return e && e.referenceNode ? e.referenceNode : e
	}
	var je = Ie && !(!window.MSInputMethodContext || !document.documentMode),
		He = Ie && /MSIE 10/.test(navigator.userAgent);

	function Re(e) {
		return 11 === e ? je : 10 === e ? He : je || He
	}

	function Fe(e) {
		if (!e) return document.documentElement;
		for (var t = Re(10) ? document.body : null, n = e.offsetParent || null; n === t && e.nextElementSibling;) n = (e =
				e.nextElementSibling)
			.offsetParent;
		var i = n && n.nodeName;
		return i && "BODY" !== i && "HTML" !== i ? -1 !== ["TH", "TD", "TABLE"].indexOf(n.nodeName) && "static" === ke(n,
			"position") ? Fe(n) : n : e ? e.ownerDocument.documentElement : document.documentElement
	}

	function Me(e) {
		return null !== e.parentNode ? Me(e.parentNode) : e
	}

	function We(e, t) {
		if (!(e && e.nodeType && t && t.nodeType)) return document.documentElement;
		var n = e.compareDocumentPosition(t) & Node.DOCUMENT_POSITION_FOLLOWING,
			i = n ? e : t,
			o = n ? t : e,
			r = document.createRange();
		r.setStart(i, 0), r.setEnd(o, 0);
		var s = r.commonAncestorContainer;
		if (e !== s && t !== s || i.contains(o)) return function(e) {
			var t = e.nodeName;
			return "BODY" !== t && ("HTML" === t || Fe(e.firstElementChild) === e)
		}(s) ? s : Fe(s);
		var a = Me(e);
		return a.host ? We(a.host, t) : We(e, Me(t)
			.host)
	}

	function Ue(e, t) {
		var n = "top" === (1 < arguments.length && void 0 !== t ? t : "top") ? "scrollTop" : "scrollLeft",
			i = e.nodeName;
		if ("BODY" !== i && "HTML" !== i) return e[n];
		var o = e.ownerDocument.documentElement;
		return (e.ownerDocument.scrollingElement || o)[n]
	}

	function Be(e, t) {
		var n = "x" === t ? "Left" : "Top",
			i = "Left" == n ? "Right" : "Bottom";
		return parseFloat(e["border" + n + "Width"], 10) + parseFloat(e["border" + i + "Width"], 10)
	}

	function qe(e, t, n, i) {
		return Math.max(t["offset" + e], t["scroll" + e], n["client" + e], n["offset" + e], n["scroll" + e], Re(10) ?
			parseInt(n["offset" + e]) + parseInt(i["margin" + ("Height" === e ? "Top" : "Left")]) + parseInt(i["margin" +
				("Height" === e ? "Bottom" : "Right")]) : 0)
	}

	function Ke(e) {
		var t = e.body,
			n = e.documentElement,
			i = Re(10) && getComputedStyle(n);
		return {
			height: qe("Height", t, n, i),
			width: qe("Width", t, n, i)
		}
	}
	var Qe = function(e, t, n) {
		return t && Ve(e.prototype, t), n && Ve(e, n), e
	};

	function Ve(e, t) {
		for (var n = 0; n < t.length; n++) {
			var i = t[n];
			i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object
				.defineProperty(e, i.key, i)
		}
	}

	function Ye(e, t, n) {
		return t in e ? Object.defineProperty(e, t, {
			value: n,
			enumerable: !0,
			configurable: !0,
			writable: !0
		}) : e[t] = n, e
	}
	var ze = Object.assign || function(e) {
		for (var t = 1; t < arguments.length; t++) {
			var n = arguments[t];
			for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (e[i] = n[i])
		}
		return e
	};

	function Xe(e) {
		return ze({}, e, {
			right: e.left + e.width,
			bottom: e.top + e.height
		})
	}

	function Ge(e) {
		var t = {};
		try {
			if (Re(10)) {
				t = e.getBoundingClientRect();
				var n = Ue(e, "top"),
					i = Ue(e, "left");
				t.top += n, t.left += i, t.bottom += n, t.right += i
			} else t = e.getBoundingClientRect()
		} catch (e) {}
		var o = {
				left: t.left,
				top: t.top,
				width: t.right - t.left,
				height: t.bottom - t.top
			},
			r = "HTML" === e.nodeName ? Ke(e.ownerDocument) : {},
			s = r.width || e.clientWidth || o.width,
			a = r.height || e.clientHeight || o.height,
			l = e.offsetWidth - s,
			c = e.offsetHeight - a;
		if (l || c) {
			var h = ke(e);
			l -= Be(h, "x"), c -= Be(h, "y"), o.width -= l, o.height -= c
		}
		return Xe(o)
	}

	function $e(e, t, n) {
		var i = 2 < arguments.length && void 0 !== n && n,
			o = Re(10),
			r = "HTML" === t.nodeName,
			s = Ge(e),
			a = Ge(t),
			l = Pe(e),
			c = ke(t),
			h = parseFloat(c.borderTopWidth, 10),
			u = parseFloat(c.borderLeftWidth, 10);
		i && r && (a.top = Math.max(a.top, 0), a.left = Math.max(a.left, 0));
		var f = Xe({
			top: s.top - a.top - h,
			left: s.left - a.left - u,
			width: s.width,
			height: s.height
		});
		if (f.marginTop = 0, f.marginLeft = 0, !o && r) {
			var d = parseFloat(c.marginTop, 10),
				p = parseFloat(c.marginLeft, 10);
			f.top -= h - d, f.bottom -= h - d, f.left -= u - p, f.right -= u - p, f.marginTop = d, f.marginLeft = p
		}
		return (o && !i ? t.contains(l) : t === l && "BODY" !== l.nodeName) && (f = function(e, t, n) {
			var i = 2 < arguments.length && void 0 !== n && n,
				o = Ue(t, "top"),
				r = Ue(t, "left"),
				s = i ? -1 : 1;
			return e.top += o * s, e.bottom += o * s, e.left += r * s, e.right += r * s, e
		}(f, t)), f
	}

	function Je(e) {
		if (!e || !e.parentElement || Re()) return document.documentElement;
		for (var t = e.parentElement; t && "none" === ke(t, "transform");) t = t.parentElement;
		return t || document.documentElement
	}

	function Ze(e, t, n, i, o) {
		var r = 4 < arguments.length && void 0 !== o && o,
			s = {
				top: 0,
				left: 0
			},
			a = r ? Je(e) : We(e, xe(t));
		if ("viewport" === i) s = function(e, t) {
			var n = 1 < arguments.length && void 0 !== t && t,
				i = e.ownerDocument.documentElement,
				o = $e(e, i),
				r = Math.max(i.clientWidth, window.innerWidth || 0),
				s = Math.max(i.clientHeight, window.innerHeight || 0),
				a = n ? 0 : Ue(i),
				l = n ? 0 : Ue(i, "left");
			return Xe({
				top: a - o.top + o.marginTop,
				left: l - o.left + o.marginLeft,
				width: r,
				height: s
			})
		}(a, r);
		else {
			var l = void 0;
			"scrollParent" === i ? "BODY" === (l = Pe(Le(t)))
				.nodeName && (l = e.ownerDocument.documentElement) : l = "window" === i ? e.ownerDocument.documentElement : i;
			var c = $e(l, a, r);
			if ("HTML" !== l.nodeName || function e(t) {
					var n = t.nodeName;
					if ("BODY" === n || "HTML" === n) return !1;
					if ("fixed" === ke(t, "position")) return !0;
					var i = Le(t);
					return !!i && e(i)
				}(a)) s = c;
			else {
				var h = Ke(e.ownerDocument),
					u = h.height,
					f = h.width;
				s.top += c.top - c.marginTop, s.bottom = u + c.top, s.left += c.left - c.marginLeft, s.right = f + c.left
			}
		}
		var d = "number" == typeof(n = n || 0);
		return s.left += d ? n : n.left || 0, s.top += d ? n : n.top || 0, s.right -= d ? n : n.right || 0, s.bottom -=
			d ? n : n.bottom || 0, s
	}

	function et(e, t, i, n, o, r) {
		var s = 5 < arguments.length && void 0 !== r ? r : 0;
		if (-1 === e.indexOf("auto")) return e;
		var a = Ze(i, n, s, o),
			l = {
				top: {
					width: a.width,
					height: t.top - a.top
				},
				right: {
					width: a.right - t.right,
					height: a.height
				},
				bottom: {
					width: a.width,
					height: a.bottom - t.bottom
				},
				left: {
					width: t.left - a.left,
					height: a.height
				}
			},
			c = Object.keys(l)
			.map(function(e) {
				return ze({
					key: e
				}, l[e], {
					area: function(e) {
						return e.width * e.height
					}(l[e])
				})
			})
			.sort(function(e, t) {
				return t.area - e.area
			}),
			h = c.filter(function(e) {
				var t = e.width,
					n = e.height;
				return t >= i.clientWidth && n >= i.clientHeight
			}),
			u = 0 < h.length ? h[0].key : c[0].key,
			f = e.split("-")[1];
		return u + (f ? "-" + f : "")
	}

	function tt(e, t, n, i) {
		var o = 3 < arguments.length && void 0 !== i ? i : null;
		return $e(n, o ? Je(t) : We(t, xe(n)), o)
	}

	function nt(e) {
		var t = e.ownerDocument.defaultView.getComputedStyle(e),
			n = parseFloat(t.marginTop || 0) + parseFloat(t.marginBottom || 0),
			i = parseFloat(t.marginLeft || 0) + parseFloat(t.marginRight || 0);
		return {
			width: e.offsetWidth + i,
			height: e.offsetHeight + n
		}
	}

	function it(e) {
		var t = {
			left: "right",
			right: "left",
			bottom: "top",
			top: "bottom"
		};
		return e.replace(/left|right|bottom|top/g, function(e) {
			return t[e]
		})
	}

	function ot(e, t, n) {
		n = n.split("-")[0];
		var i = nt(e),
			o = {
				width: i.width,
				height: i.height
			},
			r = -1 !== ["right", "left"].indexOf(n),
			s = r ? "top" : "left",
			a = r ? "left" : "top",
			l = r ? "height" : "width",
			c = r ? "width" : "height";
		return o[s] = t[s] + t[l] / 2 - i[l] / 2, o[a] = n === a ? t[a] - i[c] : t[it(a)], o
	}

	function rt(e, t) {
		return Array.prototype.find ? e.find(t) : e.filter(t)[0]
	}

	function st(e, n, t) {
		return (void 0 === t ? e : e.slice(0, function(e, t, n) {
				if (Array.prototype.findIndex) return e.findIndex(function(e) {
					return e[t] === n
				});
				var i = rt(e, function(e) {
					return e[t] === n
				});
				return e.indexOf(i)
			}(e, "name", t)))
			.forEach(function(e) {
				e.function && console.warn("`modifier.function` is deprecated, use `modifier.fn`!");
				var t = e.function || e.fn;
				e.enabled && Ne(t) && (n.offsets.popper = Xe(n.offsets.popper), n.offsets.reference = Xe(n.offsets
					.reference), n = t(n, e))
			}), n
	}

	function at(e, n) {
		return e.some(function(e) {
			var t = e.name;
			return e.enabled && t === n
		})
	}

	function lt(e) {
		for (var t = [!1, "ms", "Webkit", "Moz", "O"], n = e.charAt(0)
				.toUpperCase() + e.slice(1), i = 0; i < t.length; i++) {
			var o = t[i],
				r = o ? "" + o + n : e;
			if ("undefined" != typeof document.body.style[r]) return r
		}
		return null
	}

	function ct(e) {
		var t = e.ownerDocument;
		return t ? t.defaultView : window
	}

	function ht(e, t, n, i) {
		n.updateBound = i, ct(e)
			.addEventListener("resize", n.updateBound, {
				passive: !0
			});
		var o = Pe(e);
		return function e(t, n, i, o) {
			var r = "BODY" === t.nodeName,
				s = r ? t.ownerDocument.defaultView : t;
			s.addEventListener(n, i, {
				passive: !0
			}), r || e(Pe(s.parentNode), n, i, o), o.push(s)
		}(o, "scroll", n.updateBound, n.scrollParents), n.scrollElement = o, n.eventsEnabled = !0, n
	}

	function ut() {
		this.state.eventsEnabled && (cancelAnimationFrame(this.scheduleUpdate), this.state = function(e, t) {
			return ct(e)
				.removeEventListener("resize", t.updateBound), t.scrollParents.forEach(function(e) {
					e.removeEventListener("scroll", t.updateBound)
				}), t.updateBound = null, t.scrollParents = [], t.scrollElement = null, t.eventsEnabled = !1, t
		}(this.reference, this.state))
	}

	function ft(e) {
		return "" !== e && !isNaN(parseFloat(e)) && isFinite(e)
	}

	function dt(n, i) {
		Object.keys(i)
			.forEach(function(e) {
				var t = ""; - 1 !== ["width", "height", "top", "right", "bottom", "left"].indexOf(e) && ft(i[e]) && (t =
					"px"), n.style[e] = i[e] + t
			})
	}

	function pt(e, t) {
		function n(e) {
			return e
		}
		var i = e.offsets,
			o = i.popper,
			r = i.reference,
			s = Math.round,
			a = Math.floor,
			l = s(r.width),
			c = s(o.width),
			h = -1 !== ["left", "right"].indexOf(e.placement),
			u = -1 !== e.placement.indexOf("-"),
			f = t ? h || u || l % 2 == c % 2 ? s : a : n,
			d = t ? s : n;
		return {
			left: f(l % 2 == 1 && c % 2 == 1 && !u && t ? o.left - 1 : o.left),
			top: d(o.top),
			bottom: d(o.bottom),
			right: f(o.right)
		}
	}
	var mt = Ie && /Firefox/i.test(navigator.userAgent);

	function gt(e, t, n) {
		var i = rt(e, function(e) {
				return e.name === t
			}),
			o = !!i && e.some(function(e) {
				return e.name === n && e.enabled && e.order < i.order
			});
		if (!o) {
			var r = "`" + t + "`",
				s = "`" + n + "`";
			console.warn(s + " modifier is required by " + r + " modifier in order to work, be sure to include it before " +
				r + "!")
		}
		return o
	}
	var _t = ["auto-start", "auto", "auto-end", "top-start", "top", "top-end", "right-start", "right", "right-end",
			"bottom-end", "bottom", "bottom-start", "left-end", "left", "left-start"],
		vt = _t.slice(3);

	function yt(e, t) {
		var n = 1 < arguments.length && void 0 !== t && t,
			i = vt.indexOf(e),
			o = vt.slice(i + 1)
			.concat(vt.slice(0, i));
		return n ? o.reverse() : o
	}
	var Et = "flip",
		bt = "clockwise",
		wt = "counterclockwise";

	function Tt(e, o, r, t) {
		var s = [0, 0],
			a = -1 !== ["right", "left"].indexOf(t),
			n = e.split(/(\+|\-)/)
			.map(function(e) {
				return e.trim()
			}),
			i = n.indexOf(rt(n, function(e) {
				return -1 !== e.search(/,|\s/)
			}));
		n[i] && -1 === n[i].indexOf(",") && console.warn(
			"Offsets separated by white space(s) are deprecated, use a comma (,) instead.");
		var l = /\s*,\s*|\s+/,
			c = -1 !== i ? [n.slice(0, i)
				.concat([n[i].split(l)[0]]), [n[i].split(l)[1]].concat(n.slice(i + 1))] : [n];
		return (c = c.map(function(e, t) {
				var n = (1 === t ? !a : a) ? "height" : "width",
					i = !1;
				return e.reduce(function(e, t) {
						return "" === e[e.length - 1] && -1 !== ["+", "-"].indexOf(t) ? (e[e.length - 1] = t, i = !0, e) :
							i ? (e[e.length - 1] += t, i = !1, e) : e.concat(t)
					}, [])
					.map(function(e) {
						return function(e, t, n, i) {
							var o = e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),
								r = +o[1],
								s = o[2];
							if (!r) return e;
							if (0 !== s.indexOf("%")) return "vh" !== s && "vw" !== s ? r : ("vh" === s ? Math.max(document
								.documentElement.clientHeight, window.innerHeight || 0) : Math.max(document
								.documentElement.clientWidth, window.innerWidth || 0)) / 100 * r;
							var a = void 0;
							switch (s) {
								case "%p":
									a = n;
									break;
								case "%":
								case "%r":
								default:
									a = i
							}
							return Xe(a)[t] / 100 * r
						}(e, n, o, r)
					})
			}))
			.forEach(function(n, i) {
				n.forEach(function(e, t) {
					ft(e) && (s[i] += e * ("-" === n[t - 1] ? -1 : 1))
				})
			}), s
	}
	var Ct = {
			placement: "bottom",
			positionFixed: !1,
			eventsEnabled: !0,
			removeOnDestroy: !1,
			onCreate: function() {},
			onUpdate: function() {},
			modifiers: {
				shift: {
					order: 100,
					enabled: !0,
					fn: function(e) {
						var t = e.placement,
							n = t.split("-")[0],
							i = t.split("-")[1];
						if (i) {
							var o = e.offsets,
								r = o.reference,
								s = o.popper,
								a = -1 !== ["bottom", "top"].indexOf(n),
								l = a ? "left" : "top",
								c = a ? "width" : "height",
								h = {
									start: Ye({}, l, r[l]),
									end: Ye({}, l, r[l] + r[c] - s[c])
								};
							e.offsets.popper = ze({}, s, h[i])
						}
						return e
					}
				},
				offset: {
					order: 200,
					enabled: !0,
					fn: function(e, t) {
						var n = t.offset,
							i = e.placement,
							o = e.offsets,
							r = o.popper,
							s = o.reference,
							a = i.split("-")[0],
							l = void 0;
						return l = ft(+n) ? [+n, 0] : Tt(n, r, s, a), "left" === a ? (r.top += l[0], r.left -= l[1]) :
							"right" === a ? (r.top += l[0], r.left += l[1]) : "top" === a ? (r.left += l[0], r.top -= l[1]) :
							"bottom" === a && (r.left += l[0], r.top += l[1]), e.popper = r, e
					},
					offset: 0
				},
				preventOverflow: {
					order: 300,
					enabled: !0,
					fn: function(e, i) {
						var t = i.boundariesElement || Fe(e.instance.popper);
						e.instance.reference === t && (t = Fe(t));
						var n = lt("transform"),
							o = e.instance.popper.style,
							r = o.top,
							s = o.left,
							a = o[n];
						o.top = "", o.left = "", o[n] = "";
						var l = Ze(e.instance.popper, e.instance.reference, i.padding, t, e.positionFixed);
						o.top = r, o.left = s, o[n] = a, i.boundaries = l;
						var c = i.priority,
							h = e.offsets.popper,
							u = {
								primary: function(e) {
									var t = h[e];
									return h[e] < l[e] && !i.escapeWithReference && (t = Math.max(h[e], l[e])), Ye({}, e, t)
								},
								secondary: function(e) {
									var t = "right" === e ? "left" : "top",
										n = h[t];
									return h[e] > l[e] && !i.escapeWithReference && (n = Math.min(h[t], l[e] - ("right" === e ? h
										.width : h.height))), Ye({}, t, n)
								}
							};
						return c.forEach(function(e) {
							var t = -1 !== ["left", "top"].indexOf(e) ? "primary" : "secondary";
							h = ze({}, h, u[t](e))
						}), e.offsets.popper = h, e
					},
					priority: ["left", "right", "top", "bottom"],
					padding: 5,
					boundariesElement: "scrollParent"
				},
				keepTogether: {
					order: 400,
					enabled: !0,
					fn: function(e) {
						var t = e.offsets,
							n = t.popper,
							i = t.reference,
							o = e.placement.split("-")[0],
							r = Math.floor,
							s = -1 !== ["top", "bottom"].indexOf(o),
							a = s ? "right" : "bottom",
							l = s ? "left" : "top",
							c = s ? "width" : "height";
						return n[a] < r(i[l]) && (e.offsets.popper[l] = r(i[l]) - n[c]), n[l] > r(i[a]) && (e.offsets.popper[
							l] = r(i[a])), e
					}
				},
				arrow: {
					order: 500,
					enabled: !0,
					fn: function(e, t) {
						var n;
						if (!gt(e.instance.modifiers, "arrow", "keepTogether")) return e;
						var i = t.element;
						if ("string" == typeof i) {
							if (!(i = e.instance.popper.querySelector(i))) return e
						} else if (!e.instance.popper.contains(i)) return console.warn(
							"WARNING: `arrow.element` must be child of its popper element!"), e;
						var o = e.placement.split("-")[0],
							r = e.offsets,
							s = r.popper,
							a = r.reference,
							l = -1 !== ["left", "right"].indexOf(o),
							c = l ? "height" : "width",
							h = l ? "Top" : "Left",
							u = h.toLowerCase(),
							f = l ? "left" : "top",
							d = l ? "bottom" : "right",
							p = nt(i)[c];
						a[d] - p < s[u] && (e.offsets.popper[u] -= s[u] - (a[d] - p)), a[u] + p > s[d] && (e.offsets.popper[
							u] += a[u] + p - s[d]), e.offsets.popper = Xe(e.offsets.popper);
						var m = a[u] + a[c] / 2 - p / 2,
							g = ke(e.instance.popper),
							_ = parseFloat(g["margin" + h], 10),
							v = parseFloat(g["border" + h + "Width"], 10),
							y = m - e.offsets.popper[u] - _ - v;
						return y = Math.max(Math.min(s[c] - p, y), 0), e.arrowElement = i, e.offsets.arrow = (Ye(n = {}, u, Math
							.round(y)), Ye(n, f, ""), n), e
					},
					element: "[x-arrow]"
				},
				flip: {
					order: 600,
					enabled: !0,
					fn: function(m, g) {
						if (at(m.instance.modifiers, "inner")) return m;
						if (m.flipped && m.placement === m.originalPlacement) return m;
						var _ = Ze(m.instance.popper, m.instance.reference, g.padding, g.boundariesElement, m.positionFixed),
							v = m.placement.split("-")[0],
							y = it(v),
							E = m.placement.split("-")[1] || "",
							b = [];
						switch (g.behavior) {
							case Et:
								b = [v, y];
								break;
							case bt:
								b = yt(v);
								break;
							case wt:
								b = yt(v, !0);
								break;
							default:
								b = g.behavior
						}
						return b.forEach(function(e, t) {
							if (v !== e || b.length === t + 1) return m;
							v = m.placement.split("-")[0], y = it(v);
							var n = m.offsets.popper,
								i = m.offsets.reference,
								o = Math.floor,
								r = "left" === v && o(n.right) > o(i.left) || "right" === v && o(n.left) < o(i.right) ||
								"top" === v && o(n.bottom) > o(i.top) || "bottom" === v && o(n.top) < o(i.bottom),
								s = o(n.left) < o(_.left),
								a = o(n.right) > o(_.right),
								l = o(n.top) < o(_.top),
								c = o(n.bottom) > o(_.bottom),
								h = "left" === v && s || "right" === v && a || "top" === v && l || "bottom" === v && c,
								u = -1 !== ["top", "bottom"].indexOf(v),
								f = !!g.flipVariations && (u && "start" === E && s || u && "end" === E && a || !u && "start" ===
									E && l || !u && "end" === E && c),
								d = !!g.flipVariationsByContent && (u && "start" === E && a || u && "end" === E && s || !u &&
									"start" === E && c || !u && "end" === E && l),
								p = f || d;
							(r || h || p) && (m.flipped = !0, (r || h) && (v = b[t + 1]), p && (E = function(e) {
								return "end" === e ? "start" : "start" === e ? "end" : e
							}(E)), m.placement = v + (E ? "-" + E : ""), m.offsets.popper = ze({}, m.offsets.popper, ot(m
								.instance.popper, m.offsets.reference, m.placement)), m = st(m.instance.modifiers, m, "flip"))
						}), m
					},
					behavior: "flip",
					padding: 5,
					boundariesElement: "viewport",
					flipVariations: !1,
					flipVariationsByContent: !1
				},
				inner: {
					order: 700,
					enabled: !1,
					fn: function(e) {
						var t = e.placement,
							n = t.split("-")[0],
							i = e.offsets,
							o = i.popper,
							r = i.reference,
							s = -1 !== ["left", "right"].indexOf(n),
							a = -1 === ["top", "left"].indexOf(n);
						return o[s ? "left" : "top"] = r[n] - (a ? o[s ? "width" : "height"] : 0), e.placement = it(t), e
							.offsets.popper = Xe(o), e
					}
				},
				hide: {
					order: 800,
					enabled: !0,
					fn: function(e) {
						if (!gt(e.instance.modifiers, "hide", "preventOverflow")) return e;
						var t = e.offsets.reference,
							n = rt(e.instance.modifiers, function(e) {
								return "preventOverflow" === e.name
							})
							.boundaries;
						if (t.bottom < n.top || t.left > n.right || t.top > n.bottom || t.right < n.left) {
							if (!0 === e.hide) return e;
							e.hide = !0, e.attributes["x-out-of-boundaries"] = ""
						} else {
							if (!1 === e.hide) return e;
							e.hide = !1, e.attributes["x-out-of-boundaries"] = !1
						}
						return e
					}
				},
				computeStyle: {
					order: 850,
					enabled: !0,
					fn: function(e, t) {
						var n = t.x,
							i = t.y,
							o = e.offsets.popper,
							r = rt(e.instance.modifiers, function(e) {
								return "applyStyle" === e.name
							})
							.gpuAcceleration;
						void 0 !== r && console.warn(
							"WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!"
							);
						var s = void 0 !== r ? r : t.gpuAcceleration,
							a = Fe(e.instance.popper),
							l = Ge(a),
							c = {
								position: o.position
							},
							h = pt(e, window.devicePixelRatio < 2 || !mt),
							u = "bottom" === n ? "top" : "bottom",
							f = "right" === i ? "left" : "right",
							d = lt("transform"),
							p = void 0,
							m = void 0;
						if (m = "bottom" == u ? "HTML" === a.nodeName ? -a.clientHeight + h.bottom : -l.height + h.bottom : h
							.top, p = "right" == f ? "HTML" === a.nodeName ? -a.clientWidth + h.right : -l.width + h.right : h
							.left, s && d) c[d] = "translate3d(" + p + "px, " + m + "px, 0)", c[u] = 0, c[f] = 0, c.willChange =
							"transform";
						else {
							var g = "bottom" == u ? -1 : 1,
								_ = "right" == f ? -1 : 1;
							c[u] = m * g, c[f] = p * _, c.willChange = u + ", " + f
						}
						var v = {
							"x-placement": e.placement
						};
						return e.attributes = ze({}, v, e.attributes), e.styles = ze({}, c, e.styles), e.arrowStyles = ze({}, e
							.offsets.arrow, e.arrowStyles), e
					},
					gpuAcceleration: !0,
					x: "bottom",
					y: "right"
				},
				applyStyle: {
					order: 900,
					enabled: !0,
					fn: function(e) {
						return dt(e.instance.popper, e.styles),
							function(t, n) {
								Object.keys(n)
									.forEach(function(e) {
										!1 !== n[e] ? t.setAttribute(e, n[e]) : t.removeAttribute(e)
									})
							}(e.instance.popper, e.attributes), e.arrowElement && Object.keys(e.arrowStyles)
							.length && dt(e.arrowElement, e.arrowStyles), e
					},
					onLoad: function(e, t, n, i, o) {
						var r = tt(o, t, e, n.positionFixed),
							s = et(n.placement, r, t, e, n.modifiers.flip.boundariesElement, n.modifiers.flip.padding);
						return t.setAttribute("x-placement", s), dt(t, {
							position: n.positionFixed ? "fixed" : "absolute"
						}), n
					},
					gpuAcceleration: void 0
				}
			}
		},
		St = (Qe(Dt, [{
			key: "update",
			value: function() {
				return function() {
					if (!this.state.isDestroyed) {
						var e = {
							instance: this,
							styles: {},
							arrowStyles: {},
							attributes: {},
							flipped: !1,
							offsets: {}
						};
						e.offsets.reference = tt(this.state, this.popper, this.reference, this.options.positionFixed), e
							.placement = et(this.options.placement, e.offsets.reference, this.popper, this.reference, this
								.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding), e
							.originalPlacement = e.placement, e.positionFixed = this.options.positionFixed, e.offsets
							.popper = ot(this.popper, e.offsets.reference, e.placement), e.offsets.popper.position = this
							.options.positionFixed ? "fixed" : "absolute", e = st(this.modifiers, e), this.state
							.isCreated ? this.options.onUpdate(e) : (this.state.isCreated = !0, this.options.onCreate(e))
					}
				}.call(this)
			}
        }, {
			key: "destroy",
			value: function() {
				return function() {
					return this.state.isDestroyed = !0, at(this.modifiers, "applyStyle") && (this.popper
							.removeAttribute("x-placement"), this.popper.style.position = "", this.popper.style.top = "",
							this.popper.style.left = "", this.popper.style.right = "", this.popper.style.bottom = "", this
							.popper.style.willChange = "", this.popper.style[lt("transform")] = ""), this
						.disableEventListeners(), this.options.removeOnDestroy && this.popper.parentNode.removeChild(
							this.popper), this
				}.call(this)
			}
        }, {
			key: "enableEventListeners",
			value: function() {
				return function() {
					this.state.eventsEnabled || (this.state = ht(this.reference, this.options, this.state, this
						.scheduleUpdate))
				}.call(this)
			}
        }, {
			key: "disableEventListeners",
			value: function() {
				return ut.call(this)
			}
        }]), Dt);

	function Dt(e, t) {
		var n = this,
			i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : {};
		! function(e, t) {
			if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
		}(this, Dt), this.scheduleUpdate = function() {
				return requestAnimationFrame(n.update)
			}, this.update = Oe(this.update.bind(this)), this.options = ze({}, Dt.Defaults, i), this.state = {
				isDestroyed: !1,
				isCreated: !1,
				scrollParents: []
			}, this.reference = e && e.jquery ? e[0] : e, this.popper = t && t.jquery ? t[0] : t, this.options
			.modifiers = {}, Object.keys(ze({}, Dt.Defaults.modifiers, i.modifiers))
			.forEach(function(e) {
				n.options.modifiers[e] = ze({}, Dt.Defaults.modifiers[e] || {}, i.modifiers ? i.modifiers[e] : {})
			}), this.modifiers = Object.keys(this.options.modifiers)
			.map(function(e) {
				return ze({
					name: e
				}, n.options.modifiers[e])
			})
			.sort(function(e, t) {
				return e.order - t.order
			}), this.modifiers.forEach(function(e) {
				e.enabled && Ne(e.onLoad) && e.onLoad(n.reference, n.popper, n.options, e, n.state)
			}), this.update();
		var o = this.options.eventsEnabled;
		o && this.enableEventListeners(), this.state.eventsEnabled = o
	}
	St.Utils = ("undefined" != typeof window ? window : global)
		.PopperUtils, St.placements = _t, St.Defaults = Ct;
	var It = "dropdown",
		At = "bs.dropdown",
		Ot = "." + At,
		Nt = ".data-api",
		kt = p.fn[It],
		Lt = new RegExp("38|40|27"),
		Pt = {
			HIDE: "hide" + Ot,
			HIDDEN: "hidden" + Ot,
			SHOW: "show" + Ot,
			SHOWN: "shown" + Ot,
			CLICK: "click" + Ot,
			CLICK_DATA_API: "click" + Ot + Nt,
			KEYDOWN_DATA_API: "keydown" + Ot + Nt,
			KEYUP_DATA_API: "keyup" + Ot + Nt
		},
		xt = "disabled",
		jt = "show",
		Ht = "dropup",
		Rt = "dropright",
		Ft = "dropleft",
		Mt = "dropdown-menu-right",
		Wt = "position-static",
		Ut = '[data-toggle="dropdown"]',
		Bt = ".dropdown form",
		qt = ".dropdown-menu",
		Kt = ".navbar-nav",
		Qt = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",
		Vt = "top-start",
		Yt = "top-end",
		zt = "bottom-start",
		Xt = "bottom-end",
		Gt = "right-start",
		$t = "left-start",
		Jt = {
			offset: 0,
			flip: !0,
			boundary: "scrollParent",
			reference: "toggle",
			display: "dynamic",
			popperConfig: null
		},
		Zt = {
			offset: "(number|string|function)",
			flip: "boolean",
			boundary: "(string|element)",
			reference: "(string|element)",
			display: "string",
			popperConfig: "(null|object)"
		},
		en = function() {
			function c(e, t) {
				this._element = e, this._popper = null, this._config = this._getConfig(t), this._menu = this
				._getMenuElement(), this._inNavbar = this._detectNavbar(), this._addEventListeners()
			}
			var e = c.prototype;
			return e.toggle = function() {
				if (!this._element.disabled && !p(this._element)
					.hasClass(xt)) {
					var e = p(this._menu)
						.hasClass(jt);
					c._clearMenus(), e || this.show(!0)
				}
			}, e.show = function(e) {
				if (void 0 === e && (e = !1), !(this._element.disabled || p(this._element)
						.hasClass(xt) || p(this._menu)
						.hasClass(jt))) {
					var t = {
							relatedTarget: this._element
						},
						n = p.Event(Pt.SHOW, t),
						i = c._getParentFromElement(this._element);
					if (p(i)
						.trigger(n), !n.isDefaultPrevented()) {
						if (!this._inNavbar && e) {
							if ("undefined" == typeof St) throw new TypeError(
								"Bootstrap's dropdowns require Popper.js (https://popper.js.org/)");
							var o = this._element;
							"parent" === this._config.reference ? o = i : m.isElement(this._config.reference) && (o = this._config
									.reference, "undefined" != typeof this._config.reference.jquery && (o = this._config.reference[0])
									), "scrollParent" !== this._config.boundary && p(i)
								.addClass(Wt), this._popper = new St(o, this._menu, this._getPopperConfig())
						}
						"ontouchstart" in document.documentElement && 0 === p(i)
							.closest(Kt)
							.length && p(document.body)
							.children()
							.on("mouseover", null, p.noop), this._element.focus(), this._element.setAttribute("aria-expanded", !
							0), p(this._menu)
							.toggleClass(jt), p(i)
							.toggleClass(jt)
							.trigger(p.Event(Pt.SHOWN, t))
					}
				}
			}, e.hide = function() {
				if (!this._element.disabled && !p(this._element)
					.hasClass(xt) && p(this._menu)
					.hasClass(jt)) {
					var e = {
							relatedTarget: this._element
						},
						t = p.Event(Pt.HIDE, e),
						n = c._getParentFromElement(this._element);
					p(n)
						.trigger(t), t.isDefaultPrevented() || (this._popper && this._popper.destroy(), p(this._menu)
							.toggleClass(jt), p(n)
							.toggleClass(jt)
							.trigger(p.Event(Pt.HIDDEN, e)))
				}
			}, e.dispose = function() {
				p.removeData(this._element, At), p(this._element)
					.off(Ot), this._element = null, (this._menu = null) !== this._popper && (this._popper.destroy(), this
						._popper = null)
			}, e.update = function() {
				this._inNavbar = this._detectNavbar(), null !== this._popper && this._popper.scheduleUpdate()
			}, e._addEventListeners = function() {
				var t = this;
				p(this._element)
					.on(Pt.CLICK, function(e) {
						e.preventDefault(), e.stopPropagation(), t.toggle()
					})
			}, e._getConfig = function(e) {
				return e = l({}, this.constructor.Default, {}, p(this._element)
					.data(), {}, e), m.typeCheckConfig(It, e, this.constructor.DefaultType), e
			}, e._getMenuElement = function() {
				if (!this._menu) {
					var e = c._getParentFromElement(this._element);
					e && (this._menu = e.querySelector(qt))
				}
				return this._menu
			}, e._getPlacement = function() {
				var e = p(this._element.parentNode),
					t = zt;
				return e.hasClass(Ht) ? (t = Vt, p(this._menu)
						.hasClass(Mt) && (t = Yt)) : e.hasClass(Rt) ? t = Gt : e.hasClass(Ft) ? t = $t : p(this._menu)
					.hasClass(Mt) && (t = Xt), t
			}, e._detectNavbar = function() {
				return 0 < p(this._element)
					.closest(".navbar")
					.length
			}, e._getOffset = function() {
				var t = this,
					e = {};
				return "function" == typeof this._config.offset ? e.fn = function(e) {
					return e.offsets = l({}, e.offsets, {}, t._config.offset(e.offsets, t._element) || {}), e
				} : e.offset = this._config.offset, e
			}, e._getPopperConfig = function() {
				var e = {
					placement: this._getPlacement(),
					modifiers: {
						offset: this._getOffset(),
						flip: {
							enabled: this._config.flip
						},
						preventOverflow: {
							boundariesElement: this._config.boundary
						}
					}
				};
				return "static" === this._config.display && (e.modifiers.applyStyle = {
					enabled: !1
				}), l({}, e, {}, this._config.popperConfig)
			}, c._jQueryInterface = function(t) {
				return this.each(function() {
					var e = p(this)
						.data(At);
					if (e || (e = new c(this, "object" == typeof t ? t : null), p(this)
							.data(At, e)), "string" == typeof t) {
						if ("undefined" == typeof e[t]) throw new TypeError('No method named "' + t + '"');
						e[t]()
					}
				})
			}, c._clearMenus = function(e) {
				if (!e || 3 !== e.which && ("keyup" !== e.type || 9 === e.which))
					for (var t = [].slice.call(document.querySelectorAll(Ut)), n = 0, i = t.length; n < i; n++) {
						var o = c._getParentFromElement(t[n]),
							r = p(t[n])
							.data(At),
							s = {
								relatedTarget: t[n]
							};
						if (e && "click" === e.type && (s.clickEvent = e), r) {
							var a = r._menu;
							if (p(o)
								.hasClass(jt) && !(e && ("click" === e.type && /input|textarea/i.test(e.target.tagName) ||
									"keyup" === e.type && 9 === e.which) && p.contains(o, e.target))) {
								var l = p.Event(Pt.HIDE, s);
								p(o)
									.trigger(l), l.isDefaultPrevented() || ("ontouchstart" in document.documentElement && p(document
											.body)
										.children()
										.off("mouseover", null, p.noop), t[n].setAttribute("aria-expanded", "false"), r._popper && r
										._popper.destroy(), p(a)
										.removeClass(jt), p(o)
										.removeClass(jt)
										.trigger(p.Event(Pt.HIDDEN, s)))
							}
						}
					}
			}, c._getParentFromElement = function(e) {
				var t, n = m.getSelectorFromElement(e);
				return n && (t = document.querySelector(n)), t || e.parentNode
			}, c._dataApiKeydownHandler = function(e) {
				if ((/input|textarea/i.test(e.target.tagName) ? !(32 === e.which || 27 !== e.which && (40 !== e.which &&
						38 !== e.which || p(e.target)
						.closest(qt)
						.length)) : Lt.test(e.which)) && (e.preventDefault(), e.stopPropagation(), !this.disabled && !p(this)
						.hasClass(xt))) {
					var t = c._getParentFromElement(this),
						n = p(t)
						.hasClass(jt);
					if (n || 27 !== e.which)
						if (n && (!n || 27 !== e.which && 32 !== e.which)) {
							var i = [].slice.call(t.querySelectorAll(Qt))
								.filter(function(e) {
									return p(e)
										.is(":visible")
								});
							if (0 !== i.length) {
								var o = i.indexOf(e.target);
								38 === e.which && 0 < o && o--, 40 === e.which && o < i.length - 1 && o++, o < 0 && (o = 0), i[o]
									.focus()
							}
						} else {
							if (27 === e.which) {
								var r = t.querySelector(Ut);
								p(r)
									.trigger("focus")
							}
							p(this)
								.trigger("click")
						}
				}
			}, s(c, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return Jt
				}
            }, {
				key: "DefaultType",
				get: function() {
					return Zt
				}
            }]), c
		}();
	p(document)
		.on(Pt.KEYDOWN_DATA_API, Ut, en._dataApiKeydownHandler)
		.on(Pt.KEYDOWN_DATA_API, qt, en._dataApiKeydownHandler)
		.on(Pt.CLICK_DATA_API + " " + Pt.KEYUP_DATA_API, en._clearMenus)
		.on(Pt.CLICK_DATA_API, Ut, function(e) {
			e.preventDefault(), e.stopPropagation(), en._jQueryInterface.call(p(this), "toggle")
		})
		.on(Pt.CLICK_DATA_API, Bt, function(e) {
			e.stopPropagation()
		}), p.fn[It] = en._jQueryInterface, p.fn[It].Constructor = en, p.fn[It].noConflict = function() {
			return p.fn[It] = kt, en._jQueryInterface
		};
	var tn = "modal",
		nn = "bs.modal",
		on = "." + nn,
		rn = p.fn[tn],
		sn = {
			backdrop: !0,
			keyboard: !0,
			focus: !0,
			show: !0
		},
		an = {
			backdrop: "(boolean|string)",
			keyboard: "boolean",
			focus: "boolean",
			show: "boolean"
		},
		ln = {
			HIDE: "hide" + on,
			HIDE_PREVENTED: "hidePrevented" + on,
			HIDDEN: "hidden" + on,
			SHOW: "show" + on,
			SHOWN: "shown" + on,
			FOCUSIN: "focusin" + on,
			RESIZE: "resize" + on,
			CLICK_DISMISS: "click.dismiss" + on,
			KEYDOWN_DISMISS: "keydown.dismiss" + on,
			MOUSEUP_DISMISS: "mouseup.dismiss" + on,
			MOUSEDOWN_DISMISS: "mousedown.dismiss" + on,
			CLICK_DATA_API: "click" + on + ".data-api"
		},
		cn = "modal-dialog-scrollable",
		hn = "modal-scrollbar-measure",
		un = "modal-backdrop",
		fn = "modal-open",
		dn = "fade",
		pn = "show",
		mn = "modal-static",
		gn = ".modal-dialog",
		_n = ".modal-body",
		vn = '[data-toggle="modal"]',
		yn = '[data-dismiss="modal"]',
		En = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
		bn = ".sticky-top",
		wn = function() {
			function o(e, t) {
				this._config = this._getConfig(t), this._element = e, this._dialog = e.querySelector(gn), this._backdrop =
					null, this._isShown = !1, this._isBodyOverflowing = !1, this._ignoreBackdropClick = !1, this
					._isTransitioning = !1, this._scrollbarWidth = 0
			}
			var e = o.prototype;
			return e.toggle = function(e) {
				return this._isShown ? this.hide() : this.show(e)
			}, e.show = function(e) {
				var t = this;
				if (!this._isShown && !this._isTransitioning) {
					p(this._element)
						.hasClass(dn) && (this._isTransitioning = !0);
					var n = p.Event(ln.SHOW, {
						relatedTarget: e
					});
					p(this._element)
						.trigger(n), this._isShown || n.isDefaultPrevented() || (this._isShown = !0, this._checkScrollbar(),
							this._setScrollbar(), this._adjustDialog(), this._setEscapeEvent(), this._setResizeEvent(), p(this
								._element)
							.on(ln.CLICK_DISMISS, yn, function(e) {
								return t.hide(e)
							}), p(this._dialog)
							.on(ln.MOUSEDOWN_DISMISS, function() {
								p(t._element)
									.one(ln.MOUSEUP_DISMISS, function(e) {
										p(e.target)
											.is(t._element) && (t._ignoreBackdropClick = !0)
									})
							}), this._showBackdrop(function() {
								return t._showElement(e)
							}))
				}
			}, e.hide = function(e) {
				var t = this;
				if (e && e.preventDefault(), this._isShown && !this._isTransitioning) {
					var n = p.Event(ln.HIDE);
					if (p(this._element)
						.trigger(n), this._isShown && !n.isDefaultPrevented()) {
						this._isShown = !1;
						var i = p(this._element)
							.hasClass(dn);
						if (i && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), p(document)
							.off(ln.FOCUSIN), p(this._element)
							.removeClass(pn), p(this._element)
							.off(ln.CLICK_DISMISS), p(this._dialog)
							.off(ln.MOUSEDOWN_DISMISS), i) {
							var o = m.getTransitionDurationFromElement(this._element);
							p(this._element)
								.one(m.TRANSITION_END, function(e) {
									return t._hideModal(e)
								})
								.emulateTransitionEnd(o)
						} else this._hideModal()
					}
				}
			}, e.dispose = function() {
                [window, this._element, this._dialog].forEach(function(e) {
						return p(e)
							.off(on)
					}), p(document)
					.off(ln.FOCUSIN), p.removeData(this._element, nn), this._config = null, this._element = null, this
					._dialog = null, this._backdrop = null, this._isShown = null, this._isBodyOverflowing = null, this
					._ignoreBackdropClick = null, this._isTransitioning = null, this._scrollbarWidth = null
			}, e.handleUpdate = function() {
				this._adjustDialog()
			}, e._getConfig = function(e) {
				return e = l({}, sn, {}, e), m.typeCheckConfig(tn, e, an), e
			}, e._triggerBackdropTransition = function() {
				var e = this;
				if ("static" === this._config.backdrop) {
					var t = p.Event(ln.HIDE_PREVENTED);
					if (p(this._element)
						.trigger(t), t.defaultPrevented) return;
					this._element.classList.add(mn);
					var n = m.getTransitionDurationFromElement(this._element);
					p(this._element)
						.one(m.TRANSITION_END, function() {
							e._element.classList.remove(mn)
						})
						.emulateTransitionEnd(n), this._element.focus()
				} else this.hide()
			}, e._showElement = function(e) {
				var t = this,
					n = p(this._element)
					.hasClass(dn),
					i = this._dialog ? this._dialog.querySelector(_n) : null;
				this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body
					.appendChild(this._element), this._element.style.display = "block", this._element.removeAttribute(
						"aria-hidden"), this._element.setAttribute("aria-modal", !0), p(this._dialog)
					.hasClass(cn) && i ? i.scrollTop = 0 : this._element.scrollTop = 0, n && m.reflow(this._element), p(this
						._element)
					.addClass(pn), this._config.focus && this._enforceFocus();

				function o() {
					t._config.focus && t._element.focus(), t._isTransitioning = !1, p(t._element)
						.trigger(r)
				}
				var r = p.Event(ln.SHOWN, {
					relatedTarget: e
				});
				if (n) {
					var s = m.getTransitionDurationFromElement(this._dialog);
					p(this._dialog)
						.one(m.TRANSITION_END, o)
						.emulateTransitionEnd(s)
				} else o()
			}, e._enforceFocus = function() {
				var t = this;
				p(document)
					.off(ln.FOCUSIN)
					.on(ln.FOCUSIN, function(e) {
						document !== e.target && t._element !== e.target && 0 === p(t._element)
							.has(e.target)
							.length && t._element.focus()
					})
			}, e._setEscapeEvent = function() {
				var t = this;
				this._isShown && this._config.keyboard ? p(this._element)
					.on(ln.KEYDOWN_DISMISS, function(e) {
						27 === e.which && t._triggerBackdropTransition()
					}) : this._isShown || p(this._element)
					.off(ln.KEYDOWN_DISMISS)
			}, e._setResizeEvent = function() {
				var t = this;
				this._isShown ? p(window)
					.on(ln.RESIZE, function(e) {
						return t.handleUpdate(e)
					}) : p(window)
					.off(ln.RESIZE)
			}, e._hideModal = function() {
				var e = this;
				this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._element
					.removeAttribute("aria-modal"), this._isTransitioning = !1, this._showBackdrop(function() {
						p(document.body)
							.removeClass(fn), e._resetAdjustments(), e._resetScrollbar(), p(e._element)
							.trigger(ln.HIDDEN)
					})
			}, e._removeBackdrop = function() {
				this._backdrop && (p(this._backdrop)
					.remove(), this._backdrop = null)
			}, e._showBackdrop = function(e) {
				var t = this,
					n = p(this._element)
					.hasClass(dn) ? dn : "";
				if (this._isShown && this._config.backdrop) {
					if (this._backdrop = document.createElement("div"), this._backdrop.className = un, n && this._backdrop
						.classList.add(n), p(this._backdrop)
						.appendTo(document.body), p(this._element)
						.on(ln.CLICK_DISMISS, function(e) {
							t._ignoreBackdropClick ? t._ignoreBackdropClick = !1 : e.target === e.currentTarget && t
								._triggerBackdropTransition()
						}), n && m.reflow(this._backdrop), p(this._backdrop)
						.addClass(pn), !e) return;
					if (!n) return void e();
					var i = m.getTransitionDurationFromElement(this._backdrop);
					p(this._backdrop)
						.one(m.TRANSITION_END, e)
						.emulateTransitionEnd(i)
				} else if (!this._isShown && this._backdrop) {
					p(this._backdrop)
						.removeClass(pn);
					var o = function() {
						t._removeBackdrop(), e && e()
					};
					if (p(this._element)
						.hasClass(dn)) {
						var r = m.getTransitionDurationFromElement(this._backdrop);
						p(this._backdrop)
							.one(m.TRANSITION_END, o)
							.emulateTransitionEnd(r)
					} else o()
				} else e && e()
			}, e._adjustDialog = function() {
				var e = this._element.scrollHeight > document.documentElement.clientHeight;
				!this._isBodyOverflowing && e && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this
					._isBodyOverflowing && !e && (this._element.style.paddingRight = this._scrollbarWidth + "px")
			}, e._resetAdjustments = function() {
				this._element.style.paddingLeft = "", this._element.style.paddingRight = ""
			}, e._checkScrollbar = function() {
				var e = document.body.getBoundingClientRect();
				this._isBodyOverflowing = e.left + e.right < window.innerWidth, this._scrollbarWidth = this
					._getScrollbarWidth()
			}, e._setScrollbar = function() {
				var o = this;
				if (this._isBodyOverflowing) {
					var e = [].slice.call(document.querySelectorAll(En)),
						t = [].slice.call(document.querySelectorAll(bn));
					p(e)
						.each(function(e, t) {
							var n = t.style.paddingRight,
								i = p(t)
								.css("padding-right");
							p(t)
								.data("padding-right", n)
								.css("padding-right", parseFloat(i) + o._scrollbarWidth + "px")
						}), p(t)
						.each(function(e, t) {
							var n = t.style.marginRight,
								i = p(t)
								.css("margin-right");
							p(t)
								.data("margin-right", n)
								.css("margin-right", parseFloat(i) - o._scrollbarWidth + "px")
						});
					var n = document.body.style.paddingRight,
						i = p(document.body)
						.css("padding-right");
					p(document.body)
						.data("padding-right", n)
						.css("padding-right", parseFloat(i) + this._scrollbarWidth + "px")
				}
				p(document.body)
					.addClass(fn)
			}, e._resetScrollbar = function() {
				var e = [].slice.call(document.querySelectorAll(En));
				p(e)
					.each(function(e, t) {
						var n = p(t)
							.data("padding-right");
						p(t)
							.removeData("padding-right"), t.style.paddingRight = n || ""
					});
				var t = [].slice.call(document.querySelectorAll("" + bn));
				p(t)
					.each(function(e, t) {
						var n = p(t)
							.data("margin-right");
						"undefined" != typeof n && p(t)
							.css("margin-right", n)
							.removeData("margin-right")
					});
				var n = p(document.body)
					.data("padding-right");
				p(document.body)
					.removeData("padding-right"), document.body.style.paddingRight = n || ""
			}, e._getScrollbarWidth = function() {
				var e = document.createElement("div");
				e.className = hn, document.body.appendChild(e);
				var t = e.getBoundingClientRect()
					.width - e.clientWidth;
				return document.body.removeChild(e), t
			}, o._jQueryInterface = function(n, i) {
				return this.each(function() {
					var e = p(this)
						.data(nn),
						t = l({}, sn, {}, p(this)
							.data(), {}, "object" == typeof n && n ? n : {});
					if (e || (e = new o(this, t), p(this)
							.data(nn, e)), "string" == typeof n) {
						if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');
						e[n](i)
					} else t.show && e.show(i)
				})
			}, s(o, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return sn
				}
            }]), o
		}();
	p(document)
		.on(ln.CLICK_DATA_API, vn, function(e) {
			var t, n = this,
				i = m.getSelectorFromElement(this);
			i && (t = document.querySelector(i));
			var o = p(t)
				.data(nn) ? "toggle" : l({}, p(t)
					.data(), {}, p(this)
					.data());
			"A" !== this.tagName && "AREA" !== this.tagName || e.preventDefault();
			var r = p(t)
				.one(ln.SHOW, function(e) {
					e.isDefaultPrevented() || r.one(ln.HIDDEN, function() {
						p(n)
							.is(":visible") && n.focus()
					})
				});
			wn._jQueryInterface.call(p(t), o, this)
		}), p.fn[tn] = wn._jQueryInterface, p.fn[tn].Constructor = wn, p.fn[tn].noConflict = function() {
			return p.fn[tn] = rn, wn._jQueryInterface
		};
	var Tn = ["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"],
		Cn = {
			"*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
			a: ["target", "href", "title", "rel"],
			area: [],
			b: [],
			br: [],
			col: [],
			code: [],
			div: [],
			em: [],
			hr: [],
			h1: [],
			h2: [],
			h3: [],
			h4: [],
			h5: [],
			h6: [],
			i: [],
			img: ["src", "alt", "title", "width", "height"],
			li: [],
			ol: [],
			p: [],
			pre: [],
			s: [],
			small: [],
			span: [],
			sub: [],
			sup: [],
			strong: [],
			u: [],
			ul: []
		},
		Sn = /^(?:(?:https?|mailto|ftp|tel|file):|[^&:/?#]*(?:[/?#]|$))/gi,
		Dn =
		/^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[a-z0-9+/]+=*$/i;

	function In(e, r, t) {
		if (0 === e.length) return e;
		if (t && "function" == typeof t) return t(e);
		for (var n = (new window.DOMParser)
				.parseFromString(e, "text/html"), s = Object.keys(r), a = [].slice.call(n.body.querySelectorAll("*")), i =
				function(e) {
					var t = a[e],
						n = t.nodeName.toLowerCase();
					if (-1 === s.indexOf(t.nodeName.toLowerCase())) return t.parentNode.removeChild(t), "continue";
					var i = [].slice.call(t.attributes),
						o = [].concat(r["*"] || [], r[n] || []);
					i.forEach(function(e) {
						! function(e, t) {
							var n = e.nodeName.toLowerCase();
							if (-1 !== t.indexOf(n)) return -1 === Tn.indexOf(n) || Boolean(e.nodeValue.match(Sn) || e.nodeValue
								.match(Dn));
							for (var i = t.filter(function(e) {
									return e instanceof RegExp
								}), o = 0, r = i.length; o < r; o++)
								if (n.match(i[o])) return !0;
							return !1
						}(e, o) && t.removeAttribute(e.nodeName)
					})
				}, o = 0, l = a.length; o < l; o++) i(o);
		return n.body.innerHTML
	}
	var An = "tooltip",
		On = "bs.tooltip",
		Nn = "." + On,
		kn = p.fn[An],
		Ln = "bs-tooltip",
		Pn = new RegExp("(^|\\s)" + Ln + "\\S+", "g"),
		xn = ["sanitize", "whiteList", "sanitizeFn"],
		jn = {
			animation: "boolean",
			template: "string",
			title: "(string|element|function)",
			trigger: "string",
			delay: "(number|object)",
			html: "boolean",
			selector: "(string|boolean)",
			placement: "(string|function)",
			offset: "(number|string|function)",
			container: "(string|element|boolean)",
			fallbackPlacement: "(string|array)",
			boundary: "(string|element)",
			sanitize: "boolean",
			sanitizeFn: "(null|function)",
			whiteList: "object",
			popperConfig: "(null|object)"
		},
		Hn = {
			AUTO: "auto",
			TOP: "top",
			RIGHT: "right",
			BOTTOM: "bottom",
			LEFT: "left"
		},
		Rn = {
			animation: !0,
			template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
			trigger: "hover focus",
			title: "",
			delay: 0,
			html: !1,
			selector: !1,
			placement: "top",
			offset: 0,
			container: !1,
			fallbackPlacement: "flip",
			boundary: "scrollParent",
			sanitize: !0,
			sanitizeFn: null,
			whiteList: Cn,
			popperConfig: null
		},
		Fn = "show",
		Mn = "out",
		Wn = {
			HIDE: "hide" + Nn,
			HIDDEN: "hidden" + Nn,
			SHOW: "show" + Nn,
			SHOWN: "shown" + Nn,
			INSERTED: "inserted" + Nn,
			CLICK: "click" + Nn,
			FOCUSIN: "focusin" + Nn,
			FOCUSOUT: "focusout" + Nn,
			MOUSEENTER: "mouseenter" + Nn,
			MOUSELEAVE: "mouseleave" + Nn
		},
		Un = "fade",
		Bn = "show",
		qn = ".tooltip-inner",
		Kn = ".arrow",
		Qn = "hover",
		Vn = "focus",
		Yn = "click",
		zn = "manual",
		Xn = function() {
			function i(e, t) {
				if ("undefined" == typeof St) throw new TypeError(
					"Bootstrap's tooltips require Popper.js (https://popper.js.org/)");
				this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null,
					this.element = e, this.config = this._getConfig(t), this.tip = null, this._setListeners()
			}
			var e = i.prototype;
			return e.enable = function() {
				this._isEnabled = !0
			}, e.disable = function() {
				this._isEnabled = !1
			}, e.toggleEnabled = function() {
				this._isEnabled = !this._isEnabled
			}, e.toggle = function(e) {
				if (this._isEnabled)
					if (e) {
						var t = this.constructor.DATA_KEY,
							n = p(e.currentTarget)
							.data(t);
						n || (n = new this.constructor(e.currentTarget, this._getDelegateConfig()), p(e.currentTarget)
							.data(t, n)), n._activeTrigger.click = !n._activeTrigger.click, n._isWithActiveTrigger() ? n._enter(
							null, n) : n._leave(null, n)
					} else {
						if (p(this.getTipElement())
							.hasClass(Bn)) return void this._leave(null, this);
						this._enter(null, this)
					}
			}, e.dispose = function() {
				clearTimeout(this._timeout), p.removeData(this.element, this.constructor.DATA_KEY), p(this.element)
					.off(this.constructor.EVENT_KEY), p(this.element)
					.closest(".modal")
					.off("hide.bs.modal", this._hideModalHandler), this.tip && p(this.tip)
					.remove(), this._isEnabled = null, this._timeout = null, this._hoverState = null, this._activeTrigger =
					null, this._popper && this._popper.destroy(), this._popper = null, this.element = null, this.config =
					null, this.tip = null
			}, e.show = function() {
				var t = this;
				if ("none" === p(this.element)
					.css("display")) throw new Error("Please use show on visible elements");
				var e = p.Event(this.constructor.Event.SHOW);
				if (this.isWithContent() && this._isEnabled) {
					p(this.element)
						.trigger(e);
					var n = m.findShadowRoot(this.element),
						i = p.contains(null !== n ? n : this.element.ownerDocument.documentElement, this.element);
					if (e.isDefaultPrevented() || !i) return;
					var o = this.getTipElement(),
						r = m.getUID(this.constructor.NAME);
					o.setAttribute("id", r), this.element.setAttribute("aria-describedby", r), this.setContent(), this.config
						.animation && p(o)
						.addClass(Un);
					var s = "function" == typeof this.config.placement ? this.config.placement.call(this, o, this.element) :
						this.config.placement,
						a = this._getAttachment(s);
					this.addAttachmentClass(a);
					var l = this._getContainer();
					p(o)
						.data(this.constructor.DATA_KEY, this), p.contains(this.element.ownerDocument.documentElement, this
						.tip) || p(o)
						.appendTo(l), p(this.element)
						.trigger(this.constructor.Event.INSERTED), this._popper = new St(this.element, o, this._getPopperConfig(
							a)), p(o)
						.addClass(Bn), "ontouchstart" in document.documentElement && p(document.body)
						.children()
						.on("mouseover", null, p.noop);
					var c = function() {
						t.config.animation && t._fixTransition();
						var e = t._hoverState;
						t._hoverState = null, p(t.element)
							.trigger(t.constructor.Event.SHOWN), e === Mn && t._leave(null, t)
					};
					if (p(this.tip)
						.hasClass(Un)) {
						var h = m.getTransitionDurationFromElement(this.tip);
						p(this.tip)
							.one(m.TRANSITION_END, c)
							.emulateTransitionEnd(h)
					} else c()
				}
			}, e.hide = function(e) {
				function t() {
					n._hoverState !== Fn && i.parentNode && i.parentNode.removeChild(i), n._cleanTipClass(), n.element
						.removeAttribute("aria-describedby"), p(n.element)
						.trigger(n.constructor.Event.HIDDEN), null !== n._popper && n._popper.destroy(), e && e()
				}
				var n = this,
					i = this.getTipElement(),
					o = p.Event(this.constructor.Event.HIDE);
				if (p(this.element)
					.trigger(o), !o.isDefaultPrevented()) {
					if (p(i)
						.removeClass(Bn), "ontouchstart" in document.documentElement && p(document.body)
						.children()
						.off("mouseover", null, p.noop), this._activeTrigger[Yn] = !1, this._activeTrigger[Vn] = !1, this
						._activeTrigger[Qn] = !1, p(this.tip)
						.hasClass(Un)) {
						var r = m.getTransitionDurationFromElement(i);
						p(i)
							.one(m.TRANSITION_END, t)
							.emulateTransitionEnd(r)
					} else t();
					this._hoverState = ""
				}
			}, e.update = function() {
				null !== this._popper && this._popper.scheduleUpdate()
			}, e.isWithContent = function() {
				return Boolean(this.getTitle())
			}, e.addAttachmentClass = function(e) {
				p(this.getTipElement())
					.addClass(Ln + "-" + e)
			}, e.getTipElement = function() {
				return this.tip = this.tip || p(this.config.template)[0], this.tip
			}, e.setContent = function() {
				var e = this.getTipElement();
				this.setElementContent(p(e.querySelectorAll(qn)), this.getTitle()), p(e)
					.removeClass(Un + " " + Bn)
			}, e.setElementContent = function(e, t) {
				"object" != typeof t || !t.nodeType && !t.jquery ? this.config.html ? (this.config.sanitize && (t = In(t,
						this.config.whiteList, this.config.sanitizeFn)), e.html(t)) : e.text(t) : this.config.html ? p(t)
					.parent()
					.is(e) || e.empty()
					.append(t) : e.text(p(t)
						.text())
			}, e.getTitle = function() {
				var e = this.element.getAttribute("data-original-title");
				return e = e || ("function" == typeof this.config.title ? this.config.title.call(this.element) : this.config
					.title)
			}, e._getPopperConfig = function(e) {
				var t = this;
				return l({}, {
					placement: e,
					modifiers: {
						offset: this._getOffset(),
						flip: {
							behavior: this.config.fallbackPlacement
						},
						arrow: {
							element: Kn
						},
						preventOverflow: {
							boundariesElement: this.config.boundary
						}
					},
					onCreate: function(e) {
						e.originalPlacement !== e.placement && t._handlePopperPlacementChange(e)
					},
					onUpdate: function(e) {
						return t._handlePopperPlacementChange(e)
					}
				}, {}, this.config.popperConfig)
			}, e._getOffset = function() {
				var t = this,
					e = {};
				return "function" == typeof this.config.offset ? e.fn = function(e) {
					return e.offsets = l({}, e.offsets, {}, t.config.offset(e.offsets, t.element) || {}), e
				} : e.offset = this.config.offset, e
			}, e._getContainer = function() {
				return !1 === this.config.container ? document.body : m.isElement(this.config.container) ? p(this.config
						.container) : p(document)
					.find(this.config.container)
			}, e._getAttachment = function(e) {
				return Hn[e.toUpperCase()]
			}, e._setListeners = function() {
				var i = this;
				this.config.trigger.split(" ")
					.forEach(function(e) {
						if ("click" === e) p(i.element)
							.on(i.constructor.Event.CLICK, i.config.selector, function(e) {
								return i.toggle(e)
							});
						else if (e !== zn) {
							var t = e === Qn ? i.constructor.Event.MOUSEENTER : i.constructor.Event.FOCUSIN,
								n = e === Qn ? i.constructor.Event.MOUSELEAVE : i.constructor.Event.FOCUSOUT;
							p(i.element)
								.on(t, i.config.selector, function(e) {
									return i._enter(e)
								})
								.on(n, i.config.selector, function(e) {
									return i._leave(e)
								})
						}
					}), this._hideModalHandler = function() {
						i.element && i.hide()
					}, p(this.element)
					.closest(".modal")
					.on("hide.bs.modal", this._hideModalHandler), this.config.selector ? this.config = l({}, this.config, {
						trigger: "manual",
						selector: ""
					}) : this._fixTitle()
			}, e._fixTitle = function() {
				var e = typeof this.element.getAttribute("data-original-title");
				!this.element.getAttribute("title") && "string" == e || (this.element.setAttribute("data-original-title",
					this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""))
			}, e._enter = function(e, t) {
				var n = this.constructor.DATA_KEY;
				(t = t || p(e.currentTarget)
					.data(n)) || (t = new this.constructor(e.currentTarget, this._getDelegateConfig()), p(e.currentTarget)
					.data(n, t)), e && (t._activeTrigger["focusin" === e.type ? Vn : Qn] = !0), p(t.getTipElement())
					.hasClass(Bn) || t._hoverState === Fn ? t._hoverState = Fn : (clearTimeout(t._timeout), t._hoverState =
						Fn, t.config.delay && t.config.delay.show ? t._timeout = setTimeout(function() {
							t._hoverState === Fn && t.show()
						}, t.config.delay.show) : t.show())
			}, e._leave = function(e, t) {
				var n = this.constructor.DATA_KEY;
				(t = t || p(e.currentTarget)
					.data(n)) || (t = new this.constructor(e.currentTarget, this._getDelegateConfig()), p(e.currentTarget)
					.data(n, t)), e && (t._activeTrigger["focusout" === e.type ? Vn : Qn] = !1), t._isWithActiveTrigger() || (
					clearTimeout(t._timeout), t._hoverState = Mn, t.config.delay && t.config.delay.hide ? t._timeout =
					setTimeout(function() {
						t._hoverState === Mn && t.hide()
					}, t.config.delay.hide) : t.hide())
			}, e._isWithActiveTrigger = function() {
				for (var e in this._activeTrigger)
					if (this._activeTrigger[e]) return !0;
				return !1
			}, e._getConfig = function(e) {
				var t = p(this.element)
					.data();
				return Object.keys(t)
					.forEach(function(e) {
						-1 !== xn.indexOf(e) && delete t[e]
					}), "number" == typeof(e = l({}, this.constructor.Default, {}, t, {}, "object" == typeof e && e ? e : {}))
					.delay && (e.delay = {
						show: e.delay,
						hide: e.delay
					}), "number" == typeof e.title && (e.title = e.title.toString()), "number" == typeof e.content && (e
						.content = e.content.toString()), m.typeCheckConfig(An, e, this.constructor.DefaultType), e.sanitize &&
					(e.template = In(e.template, e.whiteList, e.sanitizeFn)), e
			}, e._getDelegateConfig = function() {
				var e = {};
				if (this.config)
					for (var t in this.config) this.constructor.Default[t] !== this.config[t] && (e[t] = this.config[t]);
				return e
			}, e._cleanTipClass = function() {
				var e = p(this.getTipElement()),
					t = e.attr("class")
					.match(Pn);
				null !== t && t.length && e.removeClass(t.join(""))
			}, e._handlePopperPlacementChange = function(e) {
				var t = e.instance;
				this.tip = t.popper, this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(e.placement))
			}, e._fixTransition = function() {
				var e = this.getTipElement(),
					t = this.config.animation;
				null === e.getAttribute("x-placement") && (p(e)
					.removeClass(Un), this.config.animation = !1, this.hide(), this.show(), this.config.animation = t)
			}, i._jQueryInterface = function(n) {
				return this.each(function() {
					var e = p(this)
						.data(On),
						t = "object" == typeof n && n;
					if ((e || !/dispose|hide/.test(n)) && (e || (e = new i(this, t), p(this)
							.data(On, e)), "string" == typeof n)) {
						if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');
						e[n]()
					}
				})
			}, s(i, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return Rn
				}
            }, {
				key: "NAME",
				get: function() {
					return An
				}
            }, {
				key: "DATA_KEY",
				get: function() {
					return On
				}
            }, {
				key: "Event",
				get: function() {
					return Wn
				}
            }, {
				key: "EVENT_KEY",
				get: function() {
					return Nn
				}
            }, {
				key: "DefaultType",
				get: function() {
					return jn
				}
            }]), i
		}();
	p.fn[An] = Xn._jQueryInterface, p.fn[An].Constructor = Xn, p.fn[An].noConflict = function() {
		return p.fn[An] = kn, Xn._jQueryInterface
	};
	var Gn = "popover",
		$n = "bs.popover",
		Jn = "." + $n,
		Zn = p.fn[Gn],
		ei = "bs-popover",
		ti = new RegExp("(^|\\s)" + ei + "\\S+", "g"),
		ni = l({}, Xn.Default, {
			placement: "right",
			trigger: "click",
			content: "",
			template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
		}),
		ii = l({}, Xn.DefaultType, {
			content: "(string|element|function)"
		}),
		oi = "fade",
		ri = "show",
		si = ".popover-header",
		ai = ".popover-body",
		li = {
			HIDE: "hide" + Jn,
			HIDDEN: "hidden" + Jn,
			SHOW: "show" + Jn,
			SHOWN: "shown" + Jn,
			INSERTED: "inserted" + Jn,
			CLICK: "click" + Jn,
			FOCUSIN: "focusin" + Jn,
			FOCUSOUT: "focusout" + Jn,
			MOUSEENTER: "mouseenter" + Jn,
			MOUSELEAVE: "mouseleave" + Jn
		},
		ci = function(e) {
			function i() {
				return e.apply(this, arguments) || this
			}! function(e, t) {
				e.prototype = Object.create(t.prototype), (e.prototype.constructor = e)
					.__proto__ = t
			}(i, e);
			var t = i.prototype;
			return t.isWithContent = function() {
				return this.getTitle() || this._getContent()
			}, t.addAttachmentClass = function(e) {
				p(this.getTipElement())
					.addClass(ei + "-" + e)
			}, t.getTipElement = function() {
				return this.tip = this.tip || p(this.config.template)[0], this.tip
			}, t.setContent = function() {
				var e = p(this.getTipElement());
				this.setElementContent(e.find(si), this.getTitle());
				var t = this._getContent();
				"function" == typeof t && (t = t.call(this.element)), this.setElementContent(e.find(ai), t), e.removeClass(
					oi + " " + ri)
			}, t._getContent = function() {
				return this.element.getAttribute("data-content") || this.config.content
			}, t._cleanTipClass = function() {
				var e = p(this.getTipElement()),
					t = e.attr("class")
					.match(ti);
				null !== t && 0 < t.length && e.removeClass(t.join(""))
			}, i._jQueryInterface = function(n) {
				return this.each(function() {
					var e = p(this)
						.data($n),
						t = "object" == typeof n ? n : null;
					if ((e || !/dispose|hide/.test(n)) && (e || (e = new i(this, t), p(this)
							.data($n, e)), "string" == typeof n)) {
						if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');
						e[n]()
					}
				})
			}, s(i, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return ni
				}
            }, {
				key: "NAME",
				get: function() {
					return Gn
				}
            }, {
				key: "DATA_KEY",
				get: function() {
					return $n
				}
            }, {
				key: "Event",
				get: function() {
					return li
				}
            }, {
				key: "EVENT_KEY",
				get: function() {
					return Jn
				}
            }, {
				key: "DefaultType",
				get: function() {
					return ii
				}
            }]), i
		}(Xn);
	p.fn[Gn] = ci._jQueryInterface, p.fn[Gn].Constructor = ci, p.fn[Gn].noConflict = function() {
		return p.fn[Gn] = Zn, ci._jQueryInterface
	};
	var hi = "scrollspy",
		ui = "bs.scrollspy",
		fi = "." + ui,
		di = p.fn[hi],
		pi = {
			offset: 10,
			method: "auto",
			target: ""
		},
		mi = {
			offset: "number",
			method: "string",
			target: "(string|element)"
		},
		gi = {
			ACTIVATE: "activate" + fi,
			SCROLL: "scroll" + fi,
			LOAD_DATA_API: "load" + fi + ".data-api"
		},
		_i = "dropdown-item",
		vi = "active",
		yi = '[data-spy="scroll"]',
		Ei = ".nav, .list-group",
		bi = ".nav-link",
		wi = ".nav-item",
		Ti = ".list-group-item",
		Ci = ".dropdown",
		Si = ".dropdown-item",
		Di = ".dropdown-toggle",
		Ii = "offset",
		Ai = "position",
		Oi = function() {
			function n(e, t) {
				var n = this;
				this._element = e, this._scrollElement = "BODY" === e.tagName ? window : e, this._config = this._getConfig(t),
					this._selector = this._config.target + " " + bi + "," + this._config.target + " " + Ti + "," + this._config
					.target + " " + Si, this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight =
					0, p(this._scrollElement)
					.on(gi.SCROLL, function(e) {
						return n._process(e)
					}), this.refresh(), this._process()
			}
			var e = n.prototype;
			return e.refresh = function() {
				var t = this,
					e = this._scrollElement === this._scrollElement.window ? Ii : Ai,
					o = "auto" === this._config.method ? e : this._config.method,
					r = o === Ai ? this._getScrollTop() : 0;
				this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight(), [].slice.call(document
						.querySelectorAll(this._selector))
					.map(function(e) {
						var t, n = m.getSelectorFromElement(e);
						if (n && (t = document.querySelector(n)), t) {
							var i = t.getBoundingClientRect();
							if (i.width || i.height) return [p(t)[o]()
								.top + r, n]
						}
						return null
					})
					.filter(function(e) {
						return e
					})
					.sort(function(e, t) {
						return e[0] - t[0]
					})
					.forEach(function(e) {
						t._offsets.push(e[0]), t._targets.push(e[1])
					})
			}, e.dispose = function() {
				p.removeData(this._element, ui), p(this._scrollElement)
					.off(fi), this._element = null, this._scrollElement = null, this._config = null, this._selector = null,
					this._offsets = null, this._targets = null, this._activeTarget = null, this._scrollHeight = null
			}, e._getConfig = function(e) {
				if ("string" != typeof(e = l({}, pi, {}, "object" == typeof e && e ? e : {}))
					.target) {
					var t = p(e.target)
						.attr("id");
					t || (t = m.getUID(hi), p(e.target)
						.attr("id", t)), e.target = "#" + t
				}
				return m.typeCheckConfig(hi, e, mi), e
			}, e._getScrollTop = function() {
				return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop
			}, e._getScrollHeight = function() {
				return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement
					.scrollHeight)
			}, e._getOffsetHeight = function() {
				return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect()
					.height
			}, e._process = function() {
				var e = this._getScrollTop() + this._config.offset,
					t = this._getScrollHeight(),
					n = this._config.offset + t - this._getOffsetHeight();
				if (this._scrollHeight !== t && this.refresh(), n <= e) {
					var i = this._targets[this._targets.length - 1];
					this._activeTarget !== i && this._activate(i)
				} else {
					if (this._activeTarget && e < this._offsets[0] && 0 < this._offsets[0]) return this._activeTarget = null,
						void this._clear();
					for (var o = this._offsets.length; o--;) {
						this._activeTarget !== this._targets[o] && e >= this._offsets[o] && ("undefined" == typeof this
							._offsets[o + 1] || e < this._offsets[o + 1]) && this._activate(this._targets[o])
					}
				}
			}, e._activate = function(t) {
				this._activeTarget = t, this._clear();
				var e = this._selector.split(",")
					.map(function(e) {
						return e + '[data-target="' + t + '"],' + e + '[href="' + t + '"]'
					}),
					n = p([].slice.call(document.querySelectorAll(e.join(","))));
				n.hasClass(_i) ? (n.closest(Ci)
						.find(Di)
						.addClass(vi), n.addClass(vi)) : (n.addClass(vi), n.parents(Ei)
						.prev(bi + ", " + Ti)
						.addClass(vi), n.parents(Ei)
						.prev(wi)
						.children(bi)
						.addClass(vi)), p(this._scrollElement)
					.trigger(gi.ACTIVATE, {
						relatedTarget: t
					})
			}, e._clear = function() {
                [].slice.call(document.querySelectorAll(this._selector))
					.filter(function(e) {
						return e.classList.contains(vi)
					})
					.forEach(function(e) {
						return e.classList.remove(vi)
					})
			}, n._jQueryInterface = function(t) {
				return this.each(function() {
					var e = p(this)
						.data(ui);
					if (e || (e = new n(this, "object" == typeof t && t), p(this)
							.data(ui, e)), "string" == typeof t) {
						if ("undefined" == typeof e[t]) throw new TypeError('No method named "' + t + '"');
						e[t]()
					}
				})
			}, s(n, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "Default",
				get: function() {
					return pi
				}
            }]), n
		}();
	p(window)
		.on(gi.LOAD_DATA_API, function() {
			for (var e = [].slice.call(document.querySelectorAll(yi)), t = e.length; t--;) {
				var n = p(e[t]);
				Oi._jQueryInterface.call(n, n.data())
			}
		}), p.fn[hi] = Oi._jQueryInterface, p.fn[hi].Constructor = Oi, p.fn[hi].noConflict = function() {
			return p.fn[hi] = di, Oi._jQueryInterface
		};
	var Ni = "bs.tab",
		ki = "." + Ni,
		Li = p.fn.tab,
		Pi = {
			HIDE: "hide" + ki,
			HIDDEN: "hidden" + ki,
			SHOW: "show" + ki,
			SHOWN: "shown" + ki,
			CLICK_DATA_API: "click" + ki + ".data-api"
		},
		xi = "dropdown-menu",
		ji = "active",
		Hi = "disabled",
		Ri = "fade",
		Fi = "show",
		Mi = ".dropdown",
		Wi = ".nav, .list-group",
		Ui = ".active",
		Bi = "> li > .active",
		qi = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',
		Ki = ".dropdown-toggle",
		Qi = "> .dropdown-menu .active",
		Vi = function() {
			function i(e) {
				this._element = e
			}
			var e = i.prototype;
			return e.show = function() {
				var n = this;
				if (!(this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && p(this
							._element)
						.hasClass(ji) || p(this._element)
						.hasClass(Hi))) {
					var e, i, t = p(this._element)
						.closest(Wi)[0],
						o = m.getSelectorFromElement(this._element);
					if (t) {
						var r = "UL" === t.nodeName || "OL" === t.nodeName ? Bi : Ui;
						i = (i = p.makeArray(p(t)
							.find(r)))[i.length - 1]
					}
					var s = p.Event(Pi.HIDE, {
							relatedTarget: this._element
						}),
						a = p.Event(Pi.SHOW, {
							relatedTarget: i
						});
					if (i && p(i)
						.trigger(s), p(this._element)
						.trigger(a), !a.isDefaultPrevented() && !s.isDefaultPrevented()) {
						o && (e = document.querySelector(o)), this._activate(this._element, t);
						var l = function() {
							var e = p.Event(Pi.HIDDEN, {
									relatedTarget: n._element
								}),
								t = p.Event(Pi.SHOWN, {
									relatedTarget: i
								});
							p(i)
								.trigger(e), p(n._element)
								.trigger(t)
						};
						e ? this._activate(e, e.parentNode, l) : l()
					}
				}
			}, e.dispose = function() {
				p.removeData(this._element, Ni), this._element = null
			}, e._activate = function(e, t, n) {
				function i() {
					return o._transitionComplete(e, r, n)
				}
				var o = this,
					r = (!t || "UL" !== t.nodeName && "OL" !== t.nodeName ? p(t)
						.children(Ui) : p(t)
						.find(Bi))[0],
					s = n && r && p(r)
					.hasClass(Ri);
				if (r && s) {
					var a = m.getTransitionDurationFromElement(r);
					p(r)
						.removeClass(Fi)
						.one(m.TRANSITION_END, i)
						.emulateTransitionEnd(a)
				} else i()
			}, e._transitionComplete = function(e, t, n) {
				if (t) {
					p(t)
						.removeClass(ji);
					var i = p(t.parentNode)
						.find(Qi)[0];
					i && p(i)
						.removeClass(ji), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !1)
				}
				if (p(e)
					.addClass(ji), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !0), m.reflow(e), e
					.classList.contains(Ri) && e.classList.add(Fi), e.parentNode && p(e.parentNode)
					.hasClass(xi)) {
					var o = p(e)
						.closest(Mi)[0];
					if (o) {
						var r = [].slice.call(o.querySelectorAll(Ki));
						p(r)
							.addClass(ji)
					}
					e.setAttribute("aria-expanded", !0)
				}
				n && n()
			}, i._jQueryInterface = function(n) {
				return this.each(function() {
					var e = p(this),
						t = e.data(Ni);
					if (t || (t = new i(this), e.data(Ni, t)), "string" == typeof n) {
						if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
						t[n]()
					}
				})
			}, s(i, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }]), i
		}();
	p(document)
		.on(Pi.CLICK_DATA_API, qi, function(e) {
			e.preventDefault(), Vi._jQueryInterface.call(p(this), "show")
		}), p.fn.tab = Vi._jQueryInterface, p.fn.tab.Constructor = Vi, p.fn.tab.noConflict = function() {
			return p.fn.tab = Li, Vi._jQueryInterface
		};
	var Yi = "toast",
		zi = "bs.toast",
		Xi = "." + zi,
		Gi = p.fn[Yi],
		$i = {
			CLICK_DISMISS: "click.dismiss" + Xi,
			HIDE: "hide" + Xi,
			HIDDEN: "hidden" + Xi,
			SHOW: "show" + Xi,
			SHOWN: "shown" + Xi
		},
		Ji = "fade",
		Zi = "hide",
		eo = "show",
		to = "showing",
		no = {
			animation: "boolean",
			autohide: "boolean",
			delay: "number"
		},
		io = {
			animation: !0,
			autohide: !0,
			delay: 500
		},
		oo = '[data-dismiss="toast"]',
		ro = function() {
			function i(e, t) {
				this._element = e, this._config = this._getConfig(t), this._timeout = null, this._setListeners()
			}
			var e = i.prototype;
			return e.show = function() {
				var e = this,
					t = p.Event($i.SHOW);
				if (p(this._element)
					.trigger(t), !t.isDefaultPrevented()) {
					this._config.animation && this._element.classList.add(Ji);
					var n = function() {
						e._element.classList.remove(to), e._element.classList.add(eo), p(e._element)
							.trigger($i.SHOWN), e._config.autohide && (e._timeout = setTimeout(function() {
								e.hide()
							}, e._config.delay))
					};
					if (this._element.classList.remove(Zi), m.reflow(this._element), this._element.classList.add(to), this
						._config.animation) {
						var i = m.getTransitionDurationFromElement(this._element);
						p(this._element)
							.one(m.TRANSITION_END, n)
							.emulateTransitionEnd(i)
					} else n()
				}
			}, e.hide = function() {
				if (this._element.classList.contains(eo)) {
					var e = p.Event($i.HIDE);
					p(this._element)
						.trigger(e), e.isDefaultPrevented() || this._close()
				}
			}, e.dispose = function() {
				clearTimeout(this._timeout), this._timeout = null, this._element.classList.contains(eo) && this._element
					.classList.remove(eo), p(this._element)
					.off($i.CLICK_DISMISS), p.removeData(this._element, zi), this._element = null, this._config = null
			}, e._getConfig = function(e) {
				return e = l({}, io, {}, p(this._element)
						.data(), {}, "object" == typeof e && e ? e : {}), m.typeCheckConfig(Yi, e, this.constructor
					.DefaultType), e
			}, e._setListeners = function() {
				var e = this;
				p(this._element)
					.on($i.CLICK_DISMISS, oo, function() {
						return e.hide()
					})
			}, e._close = function() {
				function e() {
					t._element.classList.add(Zi), p(t._element)
						.trigger($i.HIDDEN)
				}
				var t = this;
				if (this._element.classList.remove(eo), this._config.animation) {
					var n = m.getTransitionDurationFromElement(this._element);
					p(this._element)
						.one(m.TRANSITION_END, e)
						.emulateTransitionEnd(n)
				} else e()
			}, i._jQueryInterface = function(n) {
				return this.each(function() {
					var e = p(this),
						t = e.data(zi);
					if (t || (t = new i(this, "object" == typeof n && n), e.data(zi, t)), "string" == typeof n) {
						if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
						t[n](this)
					}
				})
			}, s(i, null, [{
				key: "VERSION",
				get: function() {
					return "4.4.1"
				}
            }, {
				key: "DefaultType",
				get: function() {
					return no
				}
            }, {
				key: "Default",
				get: function() {
					return io
				}
            }]), i
		}();
	p.fn[Yi] = ro._jQueryInterface, p.fn[Yi].Constructor = ro, p.fn[Yi].noConflict = function() {
			return p.fn[Yi] = Gi, ro._jQueryInterface
		}, e.Alert = _, e.Button = x, e.Carousel = he, e.Collapse = De, e.Dropdown = en, e.Modal = wn, e.Popover = ci, e
		.Scrollspy = Oi, e.Tab = Vi, e.Toast = ro, e.Tooltip = Xn, e.Util = m, Object.defineProperty(e, "__esModule", {
			value: !0
		})
});

/**
 * Owl Carousel v2.3.4
 * Copyright 2013-2018 David Deutsch
 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
 */
! function(a, b, c, d) {
    function e(b, c) {
        this.settings = null, this.options = a.extend({}, e.Defaults, c), this.$element = a(b), this._handlers = {}, this._plugins = {}, this._supress = {}, this._current = null, this._speed = null, this._coordinates = [], this._breakpoint = null, this._width = null, this._items = [], this._clones = [], this._mergers = [], this._widths = [], this._invalidated = {}, this._pipe = [], this._drag = {
            time: null,
            target: null,
            pointer: null,
            stage: {
                start: null,
                current: null
            },
            direction: null
        }, this._states = {
            current: {},
            tags: {
                initializing: ["busy"],
                animating: ["busy"],
                dragging: ["interacting"]
            }
        }, a.each(["onResize", "onThrottledResize"], a.proxy(function(b, c) {
            this._handlers[c] = a.proxy(this[c], this)
        }, this)), a.each(e.Plugins, a.proxy(function(a, b) {
            this._plugins[a.charAt(0).toLowerCase() + a.slice(1)] = new b(this)
        }, this)), a.each(e.Workers, a.proxy(function(b, c) {
            this._pipe.push({
                filter: c.filter,
                run: a.proxy(c.run, this)
            })
        }, this)), this.setup(), this.initialize()
    }
    e.Defaults = {
        items: 3,
        loop: !1,
        center: !1,
        rewind: !1,
        checkVisibility: !0,
        mouseDrag: !0,
        touchDrag: !0,
        pullDrag: !0,
        freeDrag: !1,
        margin: 0,
        stagePadding: 0,
        merge: !1,
        mergeFit: !0,
        autoWidth: !1,
        startPosition: 0,
        rtl: !1,
        smartSpeed: 250,
        fluidSpeed: !1,
        dragEndSpeed: !1,
        responsive: {},
        responsiveRefreshRate: 200,
        responsiveBaseElement: b,
        fallbackEasing: "swing",
        slideTransition: "",
        info: !1,
        nestedItemSelector: !1,
        itemElement: "div",
        stageElement: "div",
        refreshClass: "owl-refresh",
        loadedClass: "owl-loaded",
        loadingClass: "owl-loading",
        rtlClass: "owl-rtl",
        responsiveClass: "owl-responsive",
        dragClass: "owl-drag",
        itemClass: "owl-item",
        stageClass: "owl-stage",
        stageOuterClass: "owl-stage-outer",
        grabClass: "owl-grab"
    }, e.Width = {
        Default: "default",
        Inner: "inner",
        Outer: "outer"
    }, e.Type = {
        Event: "event",
        State: "state"
    }, e.Plugins = {}, e.Workers = [{
        filter: ["width", "settings"],
        run: function() {
            this._width = this.$element.width()
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(a) {
            a.current = this._items && this._items[this.relative(this._current)]
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            this.$stage.children(".cloned").remove()
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(a) {
            var b = this.settings.margin || "",
                c = !this.settings.autoWidth,
                d = this.settings.rtl,
                e = {
                    width: "auto",
                    "margin-left": d ? b : "",
                    "margin-right": d ? "" : b
                };
            !c && this.$stage.children().css(e), a.css = e
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(a) {
            var b = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                c = null,
                d = this._items.length,
                e = !this.settings.autoWidth,
                f = [];
            for (a.items = {
                    merge: !1,
                    width: b
                }; d--;) c = this._mergers[d], c = this.settings.mergeFit && Math.min(c, this.settings.items) || c, a.items.merge = c > 1 || a.items.merge, f[d] = e ? b * c : this._items[d].width();
            this._widths = f
        }
    }, {
        filter: ["items", "settings"],
        run: function() {
            var b = [],
                c = this._items,
                d = this.settings,
                e = Math.max(2 * d.items, 4),
                f = 2 * Math.ceil(c.length / 2),
                g = d.loop && c.length ? d.rewind ? e : Math.max(e, f) : 0,
                h = "",
                i = "";
            for (g /= 2; g > 0;) b.push(this.normalize(b.length / 2, !0)), h += c[b[b.length - 1]][0].outerHTML, b.push(this.normalize(c.length - 1 - (b.length - 1) / 2, !0)), i = c[b[b.length - 1]][0].outerHTML + i, g -= 1;
            this._clones = b, a(h).addClass("cloned").appendTo(this.$stage), a(i).addClass("cloned").prependTo(this.$stage)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            for (var a = this.settings.rtl ? 1 : -1, b = this._clones.length + this._items.length, c = -1, d = 0, e = 0, f = []; ++c < b;) d = f[c - 1] || 0, e = this._widths[this.relative(c)] + this.settings.margin, f.push(d + e * a);
            this._coordinates = f
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function() {
            var a = this.settings.stagePadding,
                b = this._coordinates,
                c = {
                    width: Math.ceil(Math.abs(b[b.length - 1])) + 2 * a,
                    "padding-left": a || "",
                    "padding-right": a || ""
                };
            this.$stage.css(c)
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(a) {
            var b = this._coordinates.length,
                c = !this.settings.autoWidth,
                d = this.$stage.children();
            if (c && a.items.merge)
                for (; b--;) a.css.width = this._widths[this.relative(b)], d.eq(b).css(a.css);
            else c && (a.css.width = a.items.width, d.css(a.css))
        }
    }, {
        filter: ["items"],
        run: function() {
            this._coordinates.length < 1 && this.$stage.removeAttr("style")
        }
    }, {
        filter: ["width", "items", "settings"],
        run: function(a) {
            a.current = a.current ? this.$stage.children().index(a.current) : 0, a.current = Math.max(this.minimum(), Math.min(this.maximum(), a.current)), this.reset(a.current)
        }
    }, {
        filter: ["position"],
        run: function() {
            this.animate(this.coordinates(this._current))
        }
    }, {
        filter: ["width", "position", "items", "settings"],
        run: function() {
            var a, b, c, d, e = this.settings.rtl ? 1 : -1,
                f = 2 * this.settings.stagePadding,
                g = this.coordinates(this.current()) + f,
                h = g + this.width() * e,
                i = [];
            for (c = 0, d = this._coordinates.length; c < d; c++) a = this._coordinates[c - 1] || 0, b = Math.abs(this._coordinates[c]) + f * e, (this.op(a, "<=", g) && this.op(a, ">", h) || this.op(b, "<", g) && this.op(b, ">", h)) && i.push(c);
            this.$stage.children(".active").removeClass("active"), this.$stage.children(":eq(" + i.join("), :eq(") + ")").addClass("active"), this.$stage.children(".center").removeClass("center"), this.settings.center && this.$stage.children().eq(this.current()).addClass("center")
        }
    }], e.prototype.initializeStage = function() {
        this.$stage = this.$element.find("." + this.settings.stageClass), this.$stage.length || (this.$element.addClass(this.options.loadingClass), this.$stage = a("<" + this.settings.stageElement + ">", {
            class: this.settings.stageClass
        }).wrap(a("<div/>", {
            class: this.settings.stageOuterClass
        })), this.$element.append(this.$stage.parent()))
    }, e.prototype.initializeItems = function() {
        var b = this.$element.find(".owl-item");
        if (b.length) return this._items = b.get().map(function(b) {
            return a(b)
        }), this._mergers = this._items.map(function() {
            return 1
        }), void this.refresh();
        this.replace(this.$element.children().not(this.$stage.parent())), this.isVisible() ? this.refresh() : this.invalidate("width"), this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass)
    }, e.prototype.initialize = function() {
        if (this.enter("initializing"), this.trigger("initialize"), this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl), this.settings.autoWidth && !this.is("pre-loading")) {
            var a, b, c;
            a = this.$element.find("img"), b = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : d, c = this.$element.children(b).width(), a.length && c <= 0 && this.preloadAutoWidthImages(a)
        }
        this.initializeStage(), this.initializeItems(), this.registerEventHandlers(), this.leave("initializing"), this.trigger("initialized")
    }, e.prototype.isVisible = function() {
        return !this.settings.checkVisibility || this.$element.is(":visible")
    }, e.prototype.setup = function() {
        var b = this.viewport(),
            c = this.options.responsive,
            d = -1,
            e = null;
        c ? (a.each(c, function(a) {
            a <= b && a > d && (d = Number(a))
        }), e = a.extend({}, this.options, c[d]), "function" == typeof e.stagePadding && (e.stagePadding = e.stagePadding()), delete e.responsive, e.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + d))) : e = a.extend({}, this.options), this.trigger("change", {
            property: {
                name: "settings",
                value: e
            }
        }), this._breakpoint = d, this.settings = e, this.invalidate("settings"), this.trigger("changed", {
            property: {
                name: "settings",
                value: this.settings
            }
        })
    }, e.prototype.optionsLogic = function() {
        this.settings.autoWidth && (this.settings.stagePadding = !1, this.settings.merge = !1)
    }, e.prototype.prepare = function(b) {
        var c = this.trigger("prepare", {
            content: b
        });
        return c.data || (c.data = a("<" + this.settings.itemElement + "/>").addClass(this.options.itemClass).append(b)), this.trigger("prepared", {
            content: c.data
        }), c.data
    }, e.prototype.update = function() {
        for (var b = 0, c = this._pipe.length, d = a.proxy(function(a) {
                return this[a]
            }, this._invalidated), e = {}; b < c;)(this._invalidated.all || a.grep(this._pipe[b].filter, d).length > 0) && this._pipe[b].run(e), b++;
        this._invalidated = {}, !this.is("valid") && this.enter("valid")
    }, e.prototype.width = function(a) {
        switch (a = a || e.Width.Default) {
            case e.Width.Inner:
            case e.Width.Outer:
                return this._width;
            default:
                return this._width - 2 * this.settings.stagePadding + this.settings.margin
        }
    }, e.prototype.refresh = function() {
        this.enter("refreshing"), this.trigger("refresh"), this.setup(), this.optionsLogic(), this.$element.addClass(this.options.refreshClass), this.update(), this.$element.removeClass(this.options.refreshClass), this.leave("refreshing"), this.trigger("refreshed")
    }, e.prototype.onThrottledResize = function() {
        b.clearTimeout(this.resizeTimer), this.resizeTimer = b.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate)
    }, e.prototype.onResize = function() {
        return !!this._items.length && (this._width !== this.$element.width() && (!!this.isVisible() && (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))))
    }, e.prototype.registerEventHandlers = function() {
        a.support.transition && this.$stage.on(a.support.transition.end + ".owl.core", a.proxy(this.onTransitionEnd, this)), !1 !== this.settings.responsive && this.on(b, "resize", this._handlers.onThrottledResize), this.settings.mouseDrag && (this.$element.addClass(this.options.dragClass), this.$stage.on("mousedown.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("dragstart.owl.core selectstart.owl.core", function() {
            return !1
        })), this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", a.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", a.proxy(this.onDragEnd, this)))
    }, e.prototype.onDragStart = function(b) {
        var d = null;
        3 !== b.which && (a.support.transform ? (d = this.$stage.css("transform").replace(/.*\(|\)| /g, "").split(","), d = {
            x: d[16 === d.length ? 12 : 4],
            y: d[16 === d.length ? 13 : 5]
        }) : (d = this.$stage.position(), d = {
            x: this.settings.rtl ? d.left + this.$stage.width() - this.width() + this.settings.margin : d.left,
            y: d.top
        }), this.is("animating") && (a.support.transform ? this.animate(d.x) : this.$stage.stop(), this.invalidate("position")), this.$element.toggleClass(this.options.grabClass, "mousedown" === b.type), this.speed(0), this._drag.time = (new Date).getTime(), this._drag.target = a(b.target), this._drag.stage.start = d, this._drag.stage.current = d, this._drag.pointer = this.pointer(b), a(c).on("mouseup.owl.core touchend.owl.core", a.proxy(this.onDragEnd, this)), a(c).one("mousemove.owl.core touchmove.owl.core", a.proxy(function(b) {
            var d = this.difference(this._drag.pointer, this.pointer(b));
            a(c).on("mousemove.owl.core touchmove.owl.core", a.proxy(this.onDragMove, this)), Math.abs(d.x) < Math.abs(d.y) && this.is("valid") || (b.preventDefault(), this.enter("dragging"), this.trigger("drag"))
        }, this)))
    }, e.prototype.onDragMove = function(a) {
        var b = null,
            c = null,
            d = null,
            e = this.difference(this._drag.pointer, this.pointer(a)),
            f = this.difference(this._drag.stage.start, e);
        this.is("dragging") && (a.preventDefault(), this.settings.loop ? (b = this.coordinates(this.minimum()), c = this.coordinates(this.maximum() + 1) - b, f.x = ((f.x - b) % c + c) % c + b) : (b = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum()), c = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum()), d = this.settings.pullDrag ? -1 * e.x / 5 : 0, f.x = Math.max(Math.min(f.x, b + d), c + d)), this._drag.stage.current = f, this.animate(f.x))
    }, e.prototype.onDragEnd = function(b) {
        var d = this.difference(this._drag.pointer, this.pointer(b)),
            e = this._drag.stage.current,
            f = d.x > 0 ^ this.settings.rtl ? "left" : "right";
        a(c).off(".owl.core"), this.$element.removeClass(this.options.grabClass), (0 !== d.x && this.is("dragging") || !this.is("valid")) && (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed), this.current(this.closest(e.x, 0 !== d.x ? f : this._drag.direction)), this.invalidate("position"), this.update(), this._drag.direction = f, (Math.abs(d.x) > 3 || (new Date).getTime() - this._drag.time > 300) && this._drag.target.one("click.owl.core", function() {
            return !1
        })), this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"))
    }, e.prototype.closest = function(b, c) {
        var e = -1,
            f = 30,
            g = this.width(),
            h = this.coordinates();
        return this.settings.freeDrag || a.each(h, a.proxy(function(a, i) {
            return "left" === c && b > i - f && b < i + f ? e = a : "right" === c && b > i - g - f && b < i - g + f ? e = a + 1 : this.op(b, "<", i) && this.op(b, ">", h[a + 1] !== d ? h[a + 1] : i - g) && (e = "left" === c ? a + 1 : a), -1 === e
        }, this)), this.settings.loop || (this.op(b, ">", h[this.minimum()]) ? e = b = this.minimum() : this.op(b, "<", h[this.maximum()]) && (e = b = this.maximum())), e
    }, e.prototype.animate = function(b) {
        var c = this.speed() > 0;
        this.is("animating") && this.onTransitionEnd(), c && (this.enter("animating"), this.trigger("translate")), a.support.transform3d && a.support.transition ? this.$stage.css({
            transform: "translate3d(" + b + "px,0px,0px)",
            transition: this.speed() / 1e3 + "s" + (this.settings.slideTransition ? " " + this.settings.slideTransition : "")
        }) : c ? this.$stage.animate({
            left: b + "px"
        }, this.speed(), this.settings.fallbackEasing, a.proxy(this.onTransitionEnd, this)) : this.$stage.css({
            left: b + "px"
        })
    }, e.prototype.is = function(a) {
        return this._states.current[a] && this._states.current[a] > 0
    }, e.prototype.current = function(a) {
        if (a === d) return this._current;
        if (0 === this._items.length) return d;
        if (a = this.normalize(a), this._current !== a) {
            var b = this.trigger("change", {
                property: {
                    name: "position",
                    value: a
                }
            });
            b.data !== d && (a = this.normalize(b.data)), this._current = a, this.invalidate("position"), this.trigger("changed", {
                property: {
                    name: "position",
                    value: this._current
                }
            })
        }
        return this._current
    }, e.prototype.invalidate = function(b) {
        return "string" === a.type(b) && (this._invalidated[b] = !0, this.is("valid") && this.leave("valid")), a.map(this._invalidated, function(a, b) {
            return b
        })
    }, e.prototype.reset = function(a) {
        (a = this.normalize(a)) !== d && (this._speed = 0, this._current = a, this.suppress(["translate", "translated"]), this.animate(this.coordinates(a)), this.release(["translate", "translated"]))
    }, e.prototype.normalize = function(a, b) {
        var c = this._items.length,
            e = b ? 0 : this._clones.length;
        return !this.isNumeric(a) || c < 1 ? a = d : (a < 0 || a >= c + e) && (a = ((a - e / 2) % c + c) % c + e / 2), a
    }, e.prototype.relative = function(a) {
        return a -= this._clones.length / 2, this.normalize(a, !0)
    }, e.prototype.maximum = function(a) {
        var b, c, d, e = this.settings,
            f = this._coordinates.length;
        if (e.loop) f = this._clones.length / 2 + this._items.length - 1;
        else if (e.autoWidth || e.merge) {
            if (b = this._items.length)
                for (c = this._items[--b].width(), d = this.$element.width(); b-- && !((c += this._items[b].width() + this.settings.margin) > d););
            f = b + 1
        } else f = e.center ? this._items.length - 1 : this._items.length - e.items;
        return a && (f -= this._clones.length / 2), Math.max(f, 0)
    }, e.prototype.minimum = function(a) {
        return a ? 0 : this._clones.length / 2
    }, e.prototype.items = function(a) {
        return a === d ? this._items.slice() : (a = this.normalize(a, !0), this._items[a])
    }, e.prototype.mergers = function(a) {
        return a === d ? this._mergers.slice() : (a = this.normalize(a, !0), this._mergers[a])
    }, e.prototype.clones = function(b) {
        var c = this._clones.length / 2,
            e = c + this._items.length,
            f = function(a) {
                return a % 2 == 0 ? e + a / 2 : c - (a + 1) / 2
            };
        return b === d ? a.map(this._clones, function(a, b) {
            return f(b)
        }) : a.map(this._clones, function(a, c) {
            return a === b ? f(c) : null
        })
    }, e.prototype.speed = function(a) {
        return a !== d && (this._speed = a), this._speed
    }, e.prototype.coordinates = function(b) {
        var c, e = 1,
            f = b - 1;
        return b === d ? a.map(this._coordinates, a.proxy(function(a, b) {
            return this.coordinates(b)
        }, this)) : (this.settings.center ? (this.settings.rtl && (e = -1, f = b + 1), c = this._coordinates[b], c += (this.width() - c + (this._coordinates[f] || 0)) / 2 * e) : c = this._coordinates[f] || 0, c = Math.ceil(c))
    }, e.prototype.duration = function(a, b, c) {
        return 0 === c ? 0 : Math.min(Math.max(Math.abs(b - a), 1), 6) * Math.abs(c || this.settings.smartSpeed)
    }, e.prototype.to = function(a, b) {
        var c = this.current(),
            d = null,
            e = a - this.relative(c),
            f = (e > 0) - (e < 0),
            g = this._items.length,
            h = this.minimum(),
            i = this.maximum();
        this.settings.loop ? (!this.settings.rewind && Math.abs(e) > g / 2 && (e += -1 * f * g), a = c + e, (d = ((a - h) % g + g) % g + h) !== a && d - e <= i && d - e > 0 && (c = d - e, a = d, this.reset(c))) : this.settings.rewind ? (i += 1, a = (a % i + i) % i) : a = Math.max(h, Math.min(i, a)), this.speed(this.duration(c, a, b)), this.current(a), this.isVisible() && this.update()
    }, e.prototype.next = function(a) {
        a = a || !1, this.to(this.relative(this.current()) + 1, a)
    }, e.prototype.prev = function(a) {
        a = a || !1, this.to(this.relative(this.current()) - 1, a)
    }, e.prototype.onTransitionEnd = function(a) {
        if (a !== d && (a.stopPropagation(), (a.target || a.srcElement || a.originalTarget) !== this.$stage.get(0))) return !1;
        this.leave("animating"), this.trigger("translated")
    }, e.prototype.viewport = function() {
        var d;
        return this.options.responsiveBaseElement !== b ? d = a(this.options.responsiveBaseElement).width() : b.innerWidth ? d = b.innerWidth : c.documentElement && c.documentElement.clientWidth ? d = c.documentElement.clientWidth : console.warn("Can not detect viewport width."), d
    }, e.prototype.replace = function(b) {
        this.$stage.empty(), this._items = [], b && (b = b instanceof jQuery ? b : a(b)), this.settings.nestedItemSelector && (b = b.find("." + this.settings.nestedItemSelector)), b.filter(function() {
            return 1 === this.nodeType
        }).each(a.proxy(function(a, b) {
            b = this.prepare(b), this.$stage.append(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)
        }, this)), this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0), this.invalidate("items")
    }, e.prototype.add = function(b, c) {
        var e = this.relative(this._current);
        c = c === d ? this._items.length : this.normalize(c, !0), b = b instanceof jQuery ? b : a(b), this.trigger("add", {
            content: b,
            position: c
        }), b = this.prepare(b), 0 === this._items.length || c === this._items.length ? (0 === this._items.length && this.$stage.append(b), 0 !== this._items.length && this._items[c - 1].after(b), this._items.push(b), this._mergers.push(1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)) : (this._items[c].before(b), this._items.splice(c, 0, b), this._mergers.splice(c, 0, 1 * b.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)), this._items[e] && this.reset(this._items[e].index()), this.invalidate("items"), this.trigger("added", {
            content: b,
            position: c
        })
    }, e.prototype.remove = function(a) {
        (a = this.normalize(a, !0)) !== d && (this.trigger("remove", {
            content: this._items[a],
            position: a
        }), this._items[a].remove(), this._items.splice(a, 1), this._mergers.splice(a, 1), this.invalidate("items"), this.trigger("removed", {
            content: null,
            position: a
        }))
    }, e.prototype.preloadAutoWidthImages = function(b) {
        b.each(a.proxy(function(b, c) {
            this.enter("pre-loading"), c = a(c), a(new Image).one("load", a.proxy(function(a) {
                c.attr("src", a.target.src), c.css("opacity", 1), this.leave("pre-loading"), !this.is("pre-loading") && !this.is("initializing") && this.refresh()
            }, this)).attr("src", c.attr("src") || c.attr("data-src") || c.attr("data-src-retina"))
        }, this))
    }, e.prototype.destroy = function() {
        this.$element.off(".owl.core"), this.$stage.off(".owl.core"), a(c).off(".owl.core"), !1 !== this.settings.responsive && (b.clearTimeout(this.resizeTimer), this.off(b, "resize", this._handlers.onThrottledResize));
        for (var d in this._plugins) this._plugins[d].destroy();
        this.$stage.children(".cloned").remove(), this.$stage.unwrap(), this.$stage.children().contents().unwrap(), this.$stage.children().unwrap(), this.$stage.remove(), this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), "")).removeData("owl.carousel")
    }, e.prototype.op = function(a, b, c) {
        var d = this.settings.rtl;
        switch (b) {
            case "<":
                return d ? a > c : a < c;
            case ">":
                return d ? a < c : a > c;
            case ">=":
                return d ? a <= c : a >= c;
            case "<=":
                return d ? a >= c : a <= c
        }
    }, e.prototype.on = function(a, b, c, d) {
        a.addEventListener ? a.addEventListener(b, c, d) : a.attachEvent && a.attachEvent("on" + b, c)
    }, e.prototype.off = function(a, b, c, d) {
        a.removeEventListener ? a.removeEventListener(b, c, d) : a.detachEvent && a.detachEvent("on" + b, c)
    }, e.prototype.trigger = function(b, c, d, f, g) {
        var h = {
                item: {
                    count: this._items.length,
                    index: this.current()
                }
            },
            i = a.camelCase(a.grep(["on", b, d], function(a) {
                return a
            }).join("-").toLowerCase()),
            j = a.Event([b, "owl", d || "carousel"].join(".").toLowerCase(), a.extend({
                relatedTarget: this
            }, h, c));
        return this._supress[b] || (a.each(this._plugins, function(a, b) {
            b.onTrigger && b.onTrigger(j)
        }), this.register({
            type: e.Type.Event,
            name: b
        }), this.$element.trigger(j), this.settings && "function" == typeof this.settings[i] && this.settings[i].call(this, j)), j
    }, e.prototype.enter = function(b) {
        a.each([b].concat(this._states.tags[b] || []), a.proxy(function(a, b) {
            this._states.current[b] === d && (this._states.current[b] = 0), this._states.current[b]++
        }, this))
    }, e.prototype.leave = function(b) {
        a.each([b].concat(this._states.tags[b] || []), a.proxy(function(a, b) {
            this._states.current[b]--
        }, this))
    }, e.prototype.register = function(b) {
        if (b.type === e.Type.Event) {
            if (a.event.special[b.name] || (a.event.special[b.name] = {}), !a.event.special[b.name].owl) {
                var c = a.event.special[b.name]._default;
                a.event.special[b.name]._default = function(a) {
                    return !c || !c.apply || a.namespace && -1 !== a.namespace.indexOf("owl") ? a.namespace && a.namespace.indexOf("owl") > -1 : c.apply(this, arguments)
                }, a.event.special[b.name].owl = !0
            }
        } else b.type === e.Type.State && (this._states.tags[b.name] ? this._states.tags[b.name] = this._states.tags[b.name].concat(b.tags) : this._states.tags[b.name] = b.tags, this._states.tags[b.name] = a.grep(this._states.tags[b.name], a.proxy(function(c, d) {
            return a.inArray(c, this._states.tags[b.name]) === d
        }, this)))
    }, e.prototype.suppress = function(b) {
        a.each(b, a.proxy(function(a, b) {
            this._supress[b] = !0
        }, this))
    }, e.prototype.release = function(b) {
        a.each(b, a.proxy(function(a, b) {
            delete this._supress[b]
        }, this))
    }, e.prototype.pointer = function(a) {
        var c = {
            x: null,
            y: null
        };
        return a = a.originalEvent || a || b.event, a = a.touches && a.touches.length ? a.touches[0] : a.changedTouches && a.changedTouches.length ? a.changedTouches[0] : a, a.pageX ? (c.x = a.pageX, c.y = a.pageY) : (c.x = a.clientX, c.y = a.clientY), c
    }, e.prototype.isNumeric = function(a) {
        return !isNaN(parseFloat(a))
    }, e.prototype.difference = function(a, b) {
        return {
            x: a.x - b.x,
            y: a.y - b.y
        }
    }, a.fn.owlCarousel = function(b) {
        var c = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
            var d = a(this),
                f = d.data("owl.carousel");
            f || (f = new e(this, "object" == typeof b && b), d.data("owl.carousel", f), a.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function(b, c) {
                f.register({
                    type: e.Type.Event,
                    name: c
                }), f.$element.on(c + ".owl.carousel.core", a.proxy(function(a) {
                    a.namespace && a.relatedTarget !== this && (this.suppress([c]), f[c].apply(this, [].slice.call(arguments, 1)), this.release([c]))
                }, f))
            })), "string" == typeof b && "_" !== b.charAt(0) && f[b].apply(f, c)
        })
    }, a.fn.owlCarousel.Constructor = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(b) {
        this._core = b, this._interval = null, this._visible = null, this._handlers = {
            "initialized.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.autoRefresh && this.watch()
            }, this)
        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    e.Defaults = {
        autoRefresh: !0,
        autoRefreshInterval: 500
    }, e.prototype.watch = function() {
        this._interval || (this._visible = this._core.isVisible(), this._interval = b.setInterval(a.proxy(this.refresh, this), this._core.settings.autoRefreshInterval))
    }, e.prototype.refresh = function() {
        this._core.isVisible() !== this._visible && (this._visible = !this._visible, this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh())
    }, e.prototype.destroy = function() {
        var a, c;
        b.clearInterval(this._interval);
        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
        for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.AutoRefresh = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(b) {
        this._core = b, this._loaded = [], this._handlers = {
            "initialized.owl.carousel change.owl.carousel resized.owl.carousel": a.proxy(function(b) {
                if (b.namespace && this._core.settings && this._core.settings.lazyLoad && (b.property && "position" == b.property.name || "initialized" == b.type)) {
                    var c = this._core.settings,
                        e = c.center && Math.ceil(c.items / 2) || c.items,
                        f = c.center && -1 * e || 0,
                        g = (b.property && b.property.value !== d ? b.property.value : this._core.current()) + f,
                        h = this._core.clones().length,
                        i = a.proxy(function(a, b) {
                            this.load(b)
                        }, this);
                    for (c.lazyLoadEager > 0 && (e += c.lazyLoadEager, c.loop && (g -= c.lazyLoadEager, e++)); f++ < e;) this.load(h / 2 + this._core.relative(g)), h && a.each(this._core.clones(this._core.relative(g)), i), g++
                }
            }, this)
        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers)
    };
    e.Defaults = {
        lazyLoad: !1,
        lazyLoadEager: 0
    }, e.prototype.load = function(c) {
        var d = this._core.$stage.children().eq(c),
            e = d && d.find(".owl-lazy");
        !e || a.inArray(d.get(0), this._loaded) > -1 || (e.each(a.proxy(function(c, d) {
            var e, f = a(d),
                g = b.devicePixelRatio > 1 && f.attr("data-src-retina") || f.attr("data-src") || f.attr("data-srcset");
            this._core.trigger("load", {
                element: f,
                url: g
            }, "lazy"), f.is("img") ? f.one("load.owl.lazy", a.proxy(function() {
                f.css("opacity", 1), this._core.trigger("loaded", {
                    element: f,
                    url: g
                }, "lazy")
            }, this)).attr("src", g) : f.is("source") ? f.one("load.owl.lazy", a.proxy(function() {
                this._core.trigger("loaded", {
                    element: f,
                    url: g
                }, "lazy")
            }, this)).attr("srcset", g) : (e = new Image, e.onload = a.proxy(function() {
                f.css({
                    "background-image": 'url("' + g + '")',
                    opacity: "1"
                }), this._core.trigger("loaded", {
                    element: f,
                    url: g
                }, "lazy")
            }, this), e.src = g)
        }, this)), this._loaded.push(d.get(0)))
    }, e.prototype.destroy = function() {
        var a, b;
        for (a in this.handlers) this._core.$element.off(a, this.handlers[a]);
        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.Lazy = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(c) {
        this._core = c, this._previousHeight = null, this._handlers = {
            "initialized.owl.carousel refreshed.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.autoHeight && this.update()
            }, this),
            "changed.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.autoHeight && "position" === a.property.name && this.update()
            }, this),
            "loaded.owl.lazy": a.proxy(function(a) {
                a.namespace && this._core.settings.autoHeight && a.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update()
            }, this)
        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers), this._intervalId = null;
        var d = this;
        a(b).on("load", function() {
            d._core.settings.autoHeight && d.update()
        }), a(b).resize(function() {
            d._core.settings.autoHeight && (null != d._intervalId && clearTimeout(d._intervalId), d._intervalId = setTimeout(function() {
                d.update()
            }, 250))
        })
    };
    e.Defaults = {
        autoHeight: !1,
        autoHeightClass: "owl-height"
    }, e.prototype.update = function() {
        var b = this._core._current,
            c = b + this._core.settings.items,
            d = this._core.settings.lazyLoad,
            e = this._core.$stage.children().toArray().slice(b, c),
            f = [],
            g = 0;
        a.each(e, function(b, c) {
            f.push(a(c).height())
        }), g = Math.max.apply(null, f), g <= 1 && d && this._previousHeight && (g = this._previousHeight), this._previousHeight = g, this._core.$stage.parent().height(g).addClass(this._core.settings.autoHeightClass)
    }, e.prototype.destroy = function() {
        var a, b;
        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.AutoHeight = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(b) {
        this._core = b, this._videos = {}, this._playing = null, this._handlers = {
            "initialized.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.register({
                    type: "state",
                    name: "playing",
                    tags: ["interacting"]
                })
            }, this),
            "resize.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.video && this.isInFullScreen() && a.preventDefault()
            }, this),
            "refreshed.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove()
            }, this),
            "changed.owl.carousel": a.proxy(function(a) {
                a.namespace && "position" === a.property.name && this._playing && this.stop()
            }, this),
            "prepared.owl.carousel": a.proxy(function(b) {
                if (b.namespace) {
                    var c = a(b.content).find(".owl-video");
                    c.length && (c.css("display", "none"), this.fetch(c, a(b.content)))
                }
            }, this)
        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this._core.$element.on(this._handlers), this._core.$element.on("click.owl.video", ".owl-video-play-icon", a.proxy(function(a) {
            this.play(a)
        }, this))
    };
    e.Defaults = {
        video: !1,
        videoHeight: !1,
        videoWidth: !1
    }, e.prototype.fetch = function(a, b) {
        var c = function() {
                return a.attr("data-vimeo-id") ? "vimeo" : a.attr("data-vzaar-id") ? "vzaar" : "youtube"
            }(),
            d = a.attr("data-vimeo-id") || a.attr("data-youtube-id") || a.attr("data-vzaar-id"),
            e = a.attr("data-width") || this._core.settings.videoWidth,
            f = a.attr("data-height") || this._core.settings.videoHeight,
            g = a.attr("href");
        if (!g) throw new Error("Missing video URL.");
        if (d = g.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/), d[3].indexOf("youtu") > -1) c = "youtube";
        else if (d[3].indexOf("vimeo") > -1) c = "vimeo";
        else {
            if (!(d[3].indexOf("vzaar") > -1)) throw new Error("Video URL not supported.");
            c = "vzaar"
        }
        d = d[6], this._videos[g] = {
            type: c,
            id: d,
            width: e,
            height: f
        }, b.attr("data-video", g), this.thumbnail(a, this._videos[g])
    }, e.prototype.thumbnail = function(b, c) {
        var d, e, f, g = c.width && c.height ? "width:" + c.width + "px;height:" + c.height + "px;" : "",
            h = b.find("img"),
            i = "src",
            j = "",
            k = this._core.settings,
            l = function(c) {
                e = '<div class="owl-video-play-icon"></div>', d = k.lazyLoad ? a("<div/>", {
                    class: "owl-video-tn " + j,
                    srcType: c
                }) : a("<div/>", {
                    class: "owl-video-tn",
                    style: "opacity:1;background-image:url(" + c + ")"
                }), b.after(d), b.after(e)
            };
        if (b.wrap(a("<div/>", {
                class: "owl-video-wrapper",
                style: g
            })), this._core.settings.lazyLoad && (i = "data-src", j = "owl-lazy"), h.length) return l(h.attr(i)), h.remove(), !1;
        "youtube" === c.type ? (f = "//img.youtube.com/vi/" + c.id + "/hqdefault.jpg", l(f)) : "vimeo" === c.type ? a.ajax({
            type: "GET",
            url: "//vimeo.com/api/v2/video/" + c.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(a) {
                f = a[0].thumbnail_large, l(f)
            }
        }) : "vzaar" === c.type && a.ajax({
            type: "GET",
            url: "//vzaar.com/api/videos/" + c.id + ".json",
            jsonp: "callback",
            dataType: "jsonp",
            success: function(a) {
                f = a.framegrab_url, l(f)
            }
        })
    }, e.prototype.stop = function() {
        this._core.trigger("stop", null, "video"), this._playing.find(".owl-video-frame").remove(), this._playing.removeClass("owl-video-playing"), this._playing = null, this._core.leave("playing"), this._core.trigger("stopped", null, "video")
    }, e.prototype.play = function(b) {
        var c, d = a(b.target),
            e = d.closest("." + this._core.settings.itemClass),
            f = this._videos[e.attr("data-video")],
            g = f.width || "100%",
            h = f.height || this._core.$stage.height();
        this._playing || (this._core.enter("playing"), this._core.trigger("play", null, "video"), e = this._core.items(this._core.relative(e.index())), this._core.reset(e.index()), c = a('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>'), c.attr("height", h), c.attr("width", g), "youtube" === f.type ? c.attr("src", "//www.youtube.com/embed/" + f.id + "?autoplay=1&rel=0&v=" + f.id) : "vimeo" === f.type ? c.attr("src", "//player.vimeo.com/video/" + f.id + "?autoplay=1") : "vzaar" === f.type && c.attr("src", "//view.vzaar.com/" + f.id + "/player?autoplay=true"), a(c).wrap('<div class="owl-video-frame" />').insertAfter(e.find(".owl-video")), this._playing = e.addClass("owl-video-playing"))
    }, e.prototype.isInFullScreen = function() {
        var b = c.fullscreenElement || c.mozFullScreenElement || c.webkitFullscreenElement;
        return b && a(b).parent().hasClass("owl-video-frame")
    }, e.prototype.destroy = function() {
        var a, b;
        this._core.$element.off("click.owl.video");
        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.Video = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(b) {
        this.core = b, this.core.options = a.extend({}, e.Defaults, this.core.options), this.swapping = !0, this.previous = d, this.next = d, this.handlers = {
            "change.owl.carousel": a.proxy(function(a) {
                a.namespace && "position" == a.property.name && (this.previous = this.core.current(), this.next = a.property.value)
            }, this),
            "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": a.proxy(function(a) {
                a.namespace && (this.swapping = "translated" == a.type)
            }, this),
            "translate.owl.carousel": a.proxy(function(a) {
                a.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap()
            }, this)
        }, this.core.$element.on(this.handlers)
    };
    e.Defaults = {
        animateOut: !1,
        animateIn: !1
    }, e.prototype.swap = function() {
        if (1 === this.core.settings.items && a.support.animation && a.support.transition) {
            this.core.speed(0);
            var b, c = a.proxy(this.clear, this),
                d = this.core.$stage.children().eq(this.previous),
                e = this.core.$stage.children().eq(this.next),
                f = this.core.settings.animateIn,
                g = this.core.settings.animateOut;
            this.core.current() !== this.previous && (g && (b = this.core.coordinates(this.previous) - this.core.coordinates(this.next), d.one(a.support.animation.end, c).css({
                left: b + "px"
            }).addClass("animated owl-animated-out").addClass(g)), f && e.one(a.support.animation.end, c).addClass("animated owl-animated-in").addClass(f))
        }
    }, e.prototype.clear = function(b) {
        a(b.target).css({
            left: ""
        }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd()
    }, e.prototype.destroy = function() {
        var a, b;
        for (a in this.handlers) this.core.$element.off(a, this.handlers[a]);
        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.Animate = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    var e = function(b) {
        this._core = b, this._call = null, this._time = 0, this._timeout = 0, this._paused = !0, this._handlers = {
            "changed.owl.carousel": a.proxy(function(a) {
                a.namespace && "settings" === a.property.name ? this._core.settings.autoplay ? this.play() : this.stop() : a.namespace && "position" === a.property.name && this._paused && (this._time = 0)
            }, this),
            "initialized.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.autoplay && this.play()
            }, this),
            "play.owl.autoplay": a.proxy(function(a, b, c) {
                a.namespace && this.play(b, c)
            }, this),
            "stop.owl.autoplay": a.proxy(function(a) {
                a.namespace && this.stop()
            }, this),
            "mouseover.owl.autoplay": a.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
            }, this),
            "mouseleave.owl.autoplay": a.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play()
            }, this),
            "touchstart.owl.core": a.proxy(function() {
                this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause()
            }, this),
            "touchend.owl.core": a.proxy(function() {
                this._core.settings.autoplayHoverPause && this.play()
            }, this)
        }, this._core.$element.on(this._handlers), this._core.options = a.extend({}, e.Defaults, this._core.options)
    };
    e.Defaults = {
        autoplay: !1,
        autoplayTimeout: 5e3,
        autoplayHoverPause: !1,
        autoplaySpeed: !1
    }, e.prototype._next = function(d) {
        this._call = b.setTimeout(a.proxy(this._next, this, d), this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()), this._core.is("interacting") || c.hidden || this._core.next(d || this._core.settings.autoplaySpeed)
    }, e.prototype.read = function() {
        return (new Date).getTime() - this._time
    }, e.prototype.play = function(c, d) {
        var e;
        this._core.is("rotating") || this._core.enter("rotating"), c = c || this._core.settings.autoplayTimeout, e = Math.min(this._time % (this._timeout || c), c), this._paused ? (this._time = this.read(), this._paused = !1) : b.clearTimeout(this._call), this._time += this.read() % c - e, this._timeout = c, this._call = b.setTimeout(a.proxy(this._next, this, d), c - e)
    }, e.prototype.stop = function() {
        this._core.is("rotating") && (this._time = 0, this._paused = !0, b.clearTimeout(this._call), this._core.leave("rotating"))
    }, e.prototype.pause = function() {
        this._core.is("rotating") && !this._paused && (this._time = this.read(), this._paused = !0, b.clearTimeout(this._call))
    }, e.prototype.destroy = function() {
        var a, b;
        this.stop();
        for (a in this._handlers) this._core.$element.off(a, this._handlers[a]);
        for (b in Object.getOwnPropertyNames(this)) "function" != typeof this[b] && (this[b] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.autoplay = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    "use strict";
    var e = function(b) {
        this._core = b, this._initialized = !1, this._pages = [], this._controls = {}, this._templates = [], this.$element = this._core.$element, this._overrides = {
            next: this._core.next,
            prev: this._core.prev,
            to: this._core.to
        }, this._handlers = {
            "prepared.owl.carousel": a.proxy(function(b) {
                b.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + a(b.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "</div>")
            }, this),
            "added.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 0, this._templates.pop())
            }, this),
            "remove.owl.carousel": a.proxy(function(a) {
                a.namespace && this._core.settings.dotsData && this._templates.splice(a.position, 1)
            }, this),
            "changed.owl.carousel": a.proxy(function(a) {
                a.namespace && "position" == a.property.name && this.draw()
            }, this),
            "initialized.owl.carousel": a.proxy(function(a) {
                a.namespace && !this._initialized && (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), this._initialized = !0, this._core.trigger("initialized", null, "navigation"))
            }, this),
            "refreshed.owl.carousel": a.proxy(function(a) {
                a.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation"))
            }, this)
        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this.$element.on(this._handlers)
    };
    e.Defaults = {
        nav: !1,
        navText: ['<span aria-label="Previous">&#x2039;</span>', '<span aria-label="Next">&#x203a;</span>'],
        navSpeed: !1,
        navElement: 'button type="button" role="presentation"',
        navContainer: !1,
        navContainerClass: "owl-nav",
        navClass: ["owl-prev", "owl-next"],
        slideBy: 1,
        dotClass: "owl-dot",
        dotsClass: "owl-dots",
        dots: !0,
        dotsEach: !1,
        dotsData: !1,
        dotsSpeed: !1,
        dotsContainer: !1
    }, e.prototype.initialize = function() {
        var b, c = this._core.settings;
        this._controls.$relative = (c.navContainer ? a(c.navContainer) : a("<div>").addClass(c.navContainerClass).appendTo(this.$element)).addClass("disabled"), this._controls.$previous = a("<" + c.navElement + ">").addClass(c.navClass[0]).html(c.navText[0]).prependTo(this._controls.$relative).on("click", a.proxy(function(a) {
            this.prev(c.navSpeed)
        }, this)), this._controls.$next = a("<" + c.navElement + ">").addClass(c.navClass[1]).html(c.navText[1]).appendTo(this._controls.$relative).on("click", a.proxy(function(a) {
            this.next(c.navSpeed)
        }, this)), c.dotsData || (this._templates = [a('<button role="button">').addClass(c.dotClass).append(a("<span>")).prop("outerHTML")]), this._controls.$absolute = (c.dotsContainer ? a(c.dotsContainer) : a("<div>").addClass(c.dotsClass).appendTo(this.$element)).addClass("disabled"), this._controls.$absolute.on("click", "button", a.proxy(function(b) {
            var d = a(b.target).parent().is(this._controls.$absolute) ? a(b.target).index() : a(b.target).parent().index();
            b.preventDefault(), this.to(d, c.dotsSpeed)
        }, this));
        for (b in this._overrides) this._core[b] = a.proxy(this[b], this)
    }, e.prototype.destroy = function() {
        var a, b, c, d, e;
        e = this._core.settings;
        for (a in this._handlers) this.$element.off(a, this._handlers[a]);
        for (b in this._controls) "$relative" === b && e.navContainer ? this._controls[b].html("") : this._controls[b].remove();
        for (d in this.overides) this._core[d] = this._overrides[d];
        for (c in Object.getOwnPropertyNames(this)) "function" != typeof this[c] && (this[c] = null)
    }, e.prototype.update = function() {
        var a, b, c, d = this._core.clones().length / 2,
            e = d + this._core.items().length,
            f = this._core.maximum(!0),
            g = this._core.settings,
            h = g.center || g.autoWidth || g.dotsData ? 1 : g.dotsEach || g.items;
        if ("page" !== g.slideBy && (g.slideBy = Math.min(g.slideBy, g.items)), g.dots || "page" == g.slideBy)
            for (this._pages = [], a = d, b = 0, c = 0; a < e; a++) {
                if (b >= h || 0 === b) {
                    if (this._pages.push({
                            start: Math.min(f, a - d),
                            end: a - d + h - 1
                        }), Math.min(f, a - d) === f) break;
                    b = 0, ++c
                }
                b += this._core.mergers(this._core.relative(a))
            }
    }, e.prototype.draw = function() {
        var b, c = this._core.settings,
            d = this._core.items().length <= c.items,
            e = this._core.relative(this._core.current()),
            f = c.loop || c.rewind;
        this._controls.$relative.toggleClass("disabled", !c.nav || d), c.nav && (this._controls.$previous.toggleClass("disabled", !f && e <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !f && e >= this._core.maximum(!0))), this._controls.$absolute.toggleClass("disabled", !c.dots || d), c.dots && (b = this._pages.length - this._controls.$absolute.children().length, c.dotsData && 0 !== b ? this._controls.$absolute.html(this._templates.join("")) : b > 0 ? this._controls.$absolute.append(new Array(b + 1).join(this._templates[0])) : b < 0 && this._controls.$absolute.children().slice(b).remove(), this._controls.$absolute.find(".active").removeClass("active"), this._controls.$absolute.children().eq(a.inArray(this.current(), this._pages)).addClass("active"))
    }, e.prototype.onTrigger = function(b) {
        var c = this._core.settings;
        b.page = {
            index: a.inArray(this.current(), this._pages),
            count: this._pages.length,
            size: c && (c.center || c.autoWidth || c.dotsData ? 1 : c.dotsEach || c.items)
        }
    }, e.prototype.current = function() {
        var b = this._core.relative(this._core.current());
        return a.grep(this._pages, a.proxy(function(a, c) {
            return a.start <= b && a.end >= b
        }, this)).pop()
    }, e.prototype.getPosition = function(b) {
        var c, d, e = this._core.settings;
        return "page" == e.slideBy ? (c = a.inArray(this.current(), this._pages), d = this._pages.length, b ? ++c : --c, c = this._pages[(c % d + d) % d].start) : (c = this._core.relative(this._core.current()), d = this._core.items().length, b ? c += e.slideBy : c -= e.slideBy), c
    }, e.prototype.next = function(b) {
        a.proxy(this._overrides.to, this._core)(this.getPosition(!0), b)
    }, e.prototype.prev = function(b) {
        a.proxy(this._overrides.to, this._core)(this.getPosition(!1), b)
    }, e.prototype.to = function(b, c, d) {
        var e;
        !d && this._pages.length ? (e = this._pages.length, a.proxy(this._overrides.to, this._core)(this._pages[(b % e + e) % e].start, c)) : a.proxy(this._overrides.to, this._core)(b, c)
    }, a.fn.owlCarousel.Constructor.Plugins.Navigation = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    "use strict";
    var e = function(c) {
        this._core = c, this._hashes = {}, this.$element = this._core.$element, this._handlers = {
            "initialized.owl.carousel": a.proxy(function(c) {
                c.namespace && "URLHash" === this._core.settings.startPosition && a(b).trigger("hashchange.owl.navigation")
            }, this),
            "prepared.owl.carousel": a.proxy(function(b) {
                if (b.namespace) {
                    var c = a(b.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                    if (!c) return;
                    this._hashes[c] = b.content
                }
            }, this),
            "changed.owl.carousel": a.proxy(function(c) {
                if (c.namespace && "position" === c.property.name) {
                    var d = this._core.items(this._core.relative(this._core.current())),
                        e = a.map(this._hashes, function(a, b) {
                            return a === d ? b : null
                        }).join();
                    if (!e || b.location.hash.slice(1) === e) return;
                    b.location.hash = e
                }
            }, this)
        }, this._core.options = a.extend({}, e.Defaults, this._core.options), this.$element.on(this._handlers), a(b).on("hashchange.owl.navigation", a.proxy(function(a) {
            var c = b.location.hash.substring(1),
                e = this._core.$stage.children(),
                f = this._hashes[c] && e.index(this._hashes[c]);
            f !== d && f !== this._core.current() && this._core.to(this._core.relative(f), !1, !0)
        }, this))
    };
    e.Defaults = {
        URLhashListener: !1
    }, e.prototype.destroy = function() {
        var c, d;
        a(b).off("hashchange.owl.navigation");
        for (c in this._handlers) this._core.$element.off(c, this._handlers[c]);
        for (d in Object.getOwnPropertyNames(this)) "function" != typeof this[d] && (this[d] = null)
    }, a.fn.owlCarousel.Constructor.Plugins.Hash = e
}(window.Zepto || window.jQuery, window, document),
function(a, b, c, d) {
    function e(b, c) {
        var e = !1,
            f = b.charAt(0).toUpperCase() + b.slice(1);
        return a.each((b + " " + h.join(f + " ") + f).split(" "), function(a, b) {
            if (g[b] !== d) return e = !c || b, !1
        }), e
    }

    function f(a) {
        return e(a, !0)
    }
    var g = a("<support>").get(0).style,
        h = "Webkit Moz O ms".split(" "),
        i = {
            transition: {
                end: {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "oTransitionEnd",
                    transition: "transitionend"
                }
            },
            animation: {
                end: {
                    WebkitAnimation: "webkitAnimationEnd",
                    MozAnimation: "animationend",
                    OAnimation: "oAnimationEnd",
                    animation: "animationend"
                }
            }
        },
        j = {
            csstransforms: function() {
                return !!e("transform")
            },
            csstransforms3d: function() {
                return !!e("perspective")
            },
            csstransitions: function() {
                return !!e("transition")
            },
            cssanimations: function() {
                return !!e("animation")
            }
        };
    j.csstransitions() && (a.support.transition = new String(f("transition")), a.support.transition.end = i.transition.end[a.support.transition]), j.cssanimations() && (a.support.animation = new String(f("animation")), a.support.animation.end = i.animation.end[a.support.animation]), j.csstransforms() && (a.support.transform = new String(f("transform")), a.support.transform3d = j.csstransforms3d())
}(window.Zepto || window.jQuery, window, document);
/*! nouislider - 14.1.0 - 12/4/2019 */ ! function(t) {
    "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? module.exports = t() : window.noUiSlider = t()
}(function() {
    "use strict";
    var lt = "14.1.0";

    function ut(t) {
        t.parentElement.removeChild(t)
    }

    function s(t) {
        return null != t
    }

    function ct(t) {
        t.preventDefault()
    }

    function i(t) {
        return "number" == typeof t && !isNaN(t) && isFinite(t)
    }

    function pt(t, e, r) {
        0 < r && (ht(t, e), setTimeout(function() {
            mt(t, e)
        }, r))
    }

    function ft(t) {
        return Math.max(Math.min(t, 100), 0)
    }

    function dt(t) {
        return Array.isArray(t) ? t : [t]
    }

    function e(t) {
        var e = (t = String(t)).split(".");
        return 1 < e.length ? e[1].length : 0
    }

    function ht(t, e) {
        t.classList ? t.classList.add(e) : t.className += " " + e
    }

    function mt(t, e) {
        t.classList ? t.classList.remove(e) : t.className = t.className.replace(new RegExp("(^|\\b)" + e.split(" ").join("|") + "(\\b|$)", "gi"), " ")
    }

    function gt(t) {
        var e = void 0 !== window.pageXOffset,
            r = "CSS1Compat" === (t.compatMode || "");
        return {
            x: e ? window.pageXOffset : r ? t.documentElement.scrollLeft : t.body.scrollLeft,
            y: e ? window.pageYOffset : r ? t.documentElement.scrollTop : t.body.scrollTop
        }
    }

    function c(t, e) {
        return 100 / (e - t)
    }

    function p(t, e) {
        return 100 * e / (t[1] - t[0])
    }

    function f(t, e) {
        for (var r = 1; t >= e[r];) r += 1;
        return r
    }

    function r(t, e, r) {
        if (r >= t.slice(-1)[0]) return 100;
        var n, i, o = f(r, t),
            a = t[o - 1],
            s = t[o],
            l = e[o - 1],
            u = e[o];
        return l + (i = r, p(n = [a, s], n[0] < 0 ? i + Math.abs(n[0]) : i - n[0]) / c(l, u))
    }

    function n(t, e, r, n) {
        if (100 === n) return n;
        var i, o, a = f(n, t),
            s = t[a - 1],
            l = t[a];
        return r ? (l - s) / 2 < n - s ? l : s : e[a - 1] ? t[a - 1] + (i = n - t[a - 1], o = e[a - 1], Math.round(i / o) * o) : n
    }

    function o(t, e, r) {
        var n;
        if ("number" == typeof e && (e = [e]), !Array.isArray(e)) throw new Error("noUiSlider (" + lt + "): 'range' contains invalid value.");
        if (!i(n = "min" === t ? 0 : "max" === t ? 100 : parseFloat(t)) || !i(e[0])) throw new Error("noUiSlider (" + lt + "): 'range' value isn't numeric.");
        r.xPct.push(n), r.xVal.push(e[0]), n ? r.xSteps.push(!isNaN(e[1]) && e[1]) : isNaN(e[1]) || (r.xSteps[0] = e[1]), r.xHighestCompleteStep.push(0)
    }

    function a(t, e, r) {
        if (e)
            if (r.xVal[t] !== r.xVal[t + 1]) {
                r.xSteps[t] = p([r.xVal[t], r.xVal[t + 1]], e) / c(r.xPct[t], r.xPct[t + 1]);
                var n = (r.xVal[t + 1] - r.xVal[t]) / r.xNumSteps[t],
                    i = Math.ceil(Number(n.toFixed(3)) - 1),
                    o = r.xVal[t] + r.xNumSteps[t] * i;
                r.xHighestCompleteStep[t] = o
            } else r.xSteps[t] = r.xHighestCompleteStep[t] = r.xVal[t]
    }

    function l(t, e, r) {
        var n;
        this.xPct = [], this.xVal = [], this.xSteps = [r || !1], this.xNumSteps = [!1], this.xHighestCompleteStep = [], this.snap = e;
        var i = [];
        for (n in t) t.hasOwnProperty(n) && i.push([t[n], n]);
        for (i.length && "object" == typeof i[0][0] ? i.sort(function(t, e) {
                return t[0][0] - e[0][0]
            }) : i.sort(function(t, e) {
                return t[0] - e[0]
            }), n = 0; n < i.length; n++) o(i[n][1], i[n][0], this);
        for (this.xNumSteps = this.xSteps.slice(0), n = 0; n < this.xNumSteps.length; n++) a(n, this.xNumSteps[n], this)
    }
    l.prototype.getMargin = function(t) {
        var e = this.xNumSteps[0];
        if (e && t / e % 1 != 0) throw new Error("noUiSlider (" + lt + "): 'limit', 'margin' and 'padding' must be divisible by step.");
        return 2 === this.xPct.length && p(this.xVal, t)
    }, l.prototype.toStepping = function(t) {
        return t = r(this.xVal, this.xPct, t)
    }, l.prototype.fromStepping = function(t) {
        return function(t, e, r) {
            if (100 <= r) return t.slice(-1)[0];
            var n, i = f(r, e),
                o = t[i - 1],
                a = t[i],
                s = e[i - 1],
                l = e[i];
            return n = [o, a], (r - s) * c(s, l) * (n[1] - n[0]) / 100 + n[0]
        }(this.xVal, this.xPct, t)
    }, l.prototype.getStep = function(t) {
        return t = n(this.xPct, this.xSteps, this.snap, t)
    }, l.prototype.getDefaultStep = function(t, e, r) {
        var n = f(t, this.xPct);
        return (100 === t || e && t === this.xPct[n - 1]) && (n = Math.max(n - 1, 1)), (this.xVal[n] - this.xVal[n - 1]) / r
    }, l.prototype.getNearbySteps = function(t) {
        var e = f(t, this.xPct);
        return {
            stepBefore: {
                startValue: this.xVal[e - 2],
                step: this.xNumSteps[e - 2],
                highestStep: this.xHighestCompleteStep[e - 2]
            },
            thisStep: {
                startValue: this.xVal[e - 1],
                step: this.xNumSteps[e - 1],
                highestStep: this.xHighestCompleteStep[e - 1]
            },
            stepAfter: {
                startValue: this.xVal[e],
                step: this.xNumSteps[e],
                highestStep: this.xHighestCompleteStep[e]
            }
        }
    }, l.prototype.countStepDecimals = function() {
        var t = this.xNumSteps.map(e);
        return Math.max.apply(null, t)
    }, l.prototype.convert = function(t) {
        return this.getStep(this.toStepping(t))
    };
    var u = {
        to: function(t) {
            return void 0 !== t && t.toFixed(2)
        },
        from: Number
    };

    function d(t) {
        if ("object" == typeof(e = t) && "function" == typeof e.to && "function" == typeof e.from) return !0;
        var e;
        throw new Error("noUiSlider (" + lt + "): 'format' requires 'to' and 'from' methods.")
    }

    function h(t, e) {
        if (!i(e)) throw new Error("noUiSlider (" + lt + "): 'step' is not numeric.");
        t.singleStep = e
    }

    function m(t, e) {
        if ("object" != typeof e || Array.isArray(e)) throw new Error("noUiSlider (" + lt + "): 'range' is not an object.");
        if (void 0 === e.min || void 0 === e.max) throw new Error("noUiSlider (" + lt + "): Missing 'min' or 'max' in 'range'.");
        if (e.min === e.max) throw new Error("noUiSlider (" + lt + "): 'range' 'min' and 'max' cannot be equal.");
        t.spectrum = new l(e, t.snap, t.singleStep)
    }

    function g(t, e) {
        if (e = dt(e), !Array.isArray(e) || !e.length) throw new Error("noUiSlider (" + lt + "): 'start' option is incorrect.");
        t.handles = e.length, t.start = e
    }

    function v(t, e) {
        if ("boolean" != typeof(t.snap = e)) throw new Error("noUiSlider (" + lt + "): 'snap' option must be a boolean.")
    }

    function b(t, e) {
        if ("boolean" != typeof(t.animate = e)) throw new Error("noUiSlider (" + lt + "): 'animate' option must be a boolean.")
    }

    function S(t, e) {
        if ("number" != typeof(t.animationDuration = e)) throw new Error("noUiSlider (" + lt + "): 'animationDuration' option must be a number.")
    }

    function x(t, e) {
        var r, n = [!1];
        if ("lower" === e ? e = [!0, !1] : "upper" === e && (e = [!1, !0]), !0 === e || !1 === e) {
            for (r = 1; r < t.handles; r++) n.push(e);
            n.push(!1)
        } else {
            if (!Array.isArray(e) || !e.length || e.length !== t.handles + 1) throw new Error("noUiSlider (" + lt + "): 'connect' option doesn't match handle count.");
            n = e
        }
        t.connect = n
    }

    function w(t, e) {
        switch (e) {
            case "horizontal":
                t.ort = 0;
                break;
            case "vertical":
                t.ort = 1;
                break;
            default:
                throw new Error("noUiSlider (" + lt + "): 'orientation' option is invalid.")
        }
    }

    function y(t, e) {
        if (!i(e)) throw new Error("noUiSlider (" + lt + "): 'margin' option must be numeric.");
        if (0 !== e && (t.margin = t.spectrum.getMargin(e), !t.margin)) throw new Error("noUiSlider (" + lt + "): 'margin' option is only supported on linear sliders.")
    }

    function E(t, e) {
        if (!i(e)) throw new Error("noUiSlider (" + lt + "): 'limit' option must be numeric.");
        if (t.limit = t.spectrum.getMargin(e), !t.limit || t.handles < 2) throw new Error("noUiSlider (" + lt + "): 'limit' option is only supported on linear sliders with 2 or more handles.")
    }

    function C(t, e) {
        if (!i(e) && !Array.isArray(e)) throw new Error("noUiSlider (" + lt + "): 'padding' option must be numeric or array of exactly 2 numbers.");
        if (Array.isArray(e) && 2 !== e.length && !i(e[0]) && !i(e[1])) throw new Error("noUiSlider (" + lt + "): 'padding' option must be numeric or array of exactly 2 numbers.");
        if (0 !== e) {
            if (Array.isArray(e) || (e = [e, e]), !(t.padding = [t.spectrum.getMargin(e[0]), t.spectrum.getMargin(e[1])]) === t.padding[0] || !1 === t.padding[1]) throw new Error("noUiSlider (" + lt + "): 'padding' option is only supported on linear sliders.");
            if (t.padding[0] < 0 || t.padding[1] < 0) throw new Error("noUiSlider (" + lt + "): 'padding' option must be a positive number(s).");
            if (100 < t.padding[0] + t.padding[1]) throw new Error("noUiSlider (" + lt + "): 'padding' option must not exceed 100% of the range.")
        }
    }

    function N(t, e) {
        switch (e) {
            case "ltr":
                t.dir = 0;
                break;
            case "rtl":
                t.dir = 1;
                break;
            default:
                throw new Error("noUiSlider (" + lt + "): 'direction' option was not recognized.")
        }
    }

    function U(t, e) {
        if ("string" != typeof e) throw new Error("noUiSlider (" + lt + "): 'behaviour' must be a string containing options.");
        var r = 0 <= e.indexOf("tap"),
            n = 0 <= e.indexOf("drag"),
            i = 0 <= e.indexOf("fixed"),
            o = 0 <= e.indexOf("snap"),
            a = 0 <= e.indexOf("hover"),
            s = 0 <= e.indexOf("unconstrained");
        if (i) {
            if (2 !== t.handles) throw new Error("noUiSlider (" + lt + "): 'fixed' behaviour must be used with 2 handles");
            y(t, t.start[1] - t.start[0])
        }
        if (s && (t.margin || t.limit)) throw new Error("noUiSlider (" + lt + "): 'unconstrained' behaviour cannot be used with margin or limit");
        t.events = {
            tap: r || o,
            drag: n,
            fixed: i,
            snap: o,
            hover: a,
            unconstrained: s
        }
    }

    function P(t, e) {
        if (!1 !== e)
            if (!0 === e) {
                t.tooltips = [];
                for (var r = 0; r < t.handles; r++) t.tooltips.push(!0)
            } else {
                if (t.tooltips = dt(e), t.tooltips.length !== t.handles) throw new Error("noUiSlider (" + lt + "): must pass a formatter for all handles.");
                t.tooltips.forEach(function(t) {
                    if ("boolean" != typeof t && ("object" != typeof t || "function" != typeof t.to)) throw new Error("noUiSlider (" + lt + "): 'tooltips' must be passed a formatter or 'false'.")
                })
            }
    }

    function V(t, e) {
        d(t.ariaFormat = e)
    }

    function k(t, e) {
        d(t.format = e)
    }

    function A(t, e) {
        if ("boolean" != typeof(t.keyboardSupport = e)) throw new Error("noUiSlider (" + lt + "): 'keyboardSupport' option must be a boolean.")
    }

    function M(t, e) {
        t.documentElement = e
    }

    function O(t, e) {
        if ("string" != typeof e && !1 !== e) throw new Error("noUiSlider (" + lt + "): 'cssPrefix' must be a string or `false`.");
        t.cssPrefix = e
    }

    function L(t, e) {
        if ("object" != typeof e) throw new Error("noUiSlider (" + lt + "): 'cssClasses' must be an object.");
        if ("string" == typeof t.cssPrefix)
            for (var r in t.cssClasses = {}, e) e.hasOwnProperty(r) && (t.cssClasses[r] = t.cssPrefix + e[r]);
        else t.cssClasses = e
    }

    function vt(e) {
        var r = {
                margin: 0,
                limit: 0,
                padding: 0,
                animate: !0,
                animationDuration: 300,
                ariaFormat: u,
                format: u
            },
            n = {
                step: {
                    r: !1,
                    t: h
                },
                start: {
                    r: !0,
                    t: g
                },
                connect: {
                    r: !0,
                    t: x
                },
                direction: {
                    r: !0,
                    t: N
                },
                snap: {
                    r: !1,
                    t: v
                },
                animate: {
                    r: !1,
                    t: b
                },
                animationDuration: {
                    r: !1,
                    t: S
                },
                range: {
                    r: !0,
                    t: m
                },
                orientation: {
                    r: !1,
                    t: w
                },
                margin: {
                    r: !1,
                    t: y
                },
                limit: {
                    r: !1,
                    t: E
                },
                padding: {
                    r: !1,
                    t: C
                },
                behaviour: {
                    r: !0,
                    t: U
                },
                ariaFormat: {
                    r: !1,
                    t: V
                },
                format: {
                    r: !1,
                    t: k
                },
                tooltips: {
                    r: !1,
                    t: P
                },
                keyboardSupport: {
                    r: !0,
                    t: A
                },
                documentElement: {
                    r: !1,
                    t: M
                },
                cssPrefix: {
                    r: !0,
                    t: O
                },
                cssClasses: {
                    r: !0,
                    t: L
                }
            },
            i = {
                connect: !1,
                direction: "ltr",
                behaviour: "tap",
                orientation: "horizontal",
                keyboardSupport: !0,
                cssPrefix: "noUi-",
                cssClasses: {
                    target: "target",
                    base: "base",
                    origin: "origin",
                    handle: "handle",
                    handleLower: "handle-lower",
                    handleUpper: "handle-upper",
                    touchArea: "touch-area",
                    horizontal: "horizontal",
                    vertical: "vertical",
                    background: "background",
                    connect: "connect",
                    connects: "connects",
                    ltr: "ltr",
                    rtl: "rtl",
                    textDirectionLtr: "txt-dir-ltr",
                    textDirectionRtl: "txt-dir-rtl",
                    draggable: "draggable",
                    drag: "state-drag",
                    tap: "state-tap",
                    active: "active",
                    tooltip: "tooltip",
                    pips: "pips",
                    pipsHorizontal: "pips-horizontal",
                    pipsVertical: "pips-vertical",
                    marker: "marker",
                    markerHorizontal: "marker-horizontal",
                    markerVertical: "marker-vertical",
                    markerNormal: "marker-normal",
                    markerLarge: "marker-large",
                    markerSub: "marker-sub",
                    value: "value",
                    valueHorizontal: "value-horizontal",
                    valueVertical: "value-vertical",
                    valueNormal: "value-normal",
                    valueLarge: "value-large",
                    valueSub: "value-sub"
                }
            };
        e.format && !e.ariaFormat && (e.ariaFormat = e.format), Object.keys(n).forEach(function(t) {
            if (!s(e[t]) && void 0 === i[t]) {
                if (n[t].r) throw new Error("noUiSlider (" + lt + "): '" + t + "' is required.");
                return !0
            }
            n[t].t(r, s(e[t]) ? e[t] : i[t])
        }), r.pips = e.pips;
        var t = document.createElement("div"),
            o = void 0 !== t.style.msTransform,
            a = void 0 !== t.style.transform;
        r.transformRule = a ? "transform" : o ? "msTransform" : "webkitTransform";
        return r.style = [
            ["left", "top"],
            ["right", "bottom"]
        ][r.dir][r.ort], r
    }

    function D(t, v, o) {
        var l, u, a, c, i, s, e, p, f = window.navigator.pointerEnabled ? {
                start: "pointerdown",
                move: "pointermove",
                end: "pointerup"
            } : window.navigator.msPointerEnabled ? {
                start: "MSPointerDown",
                move: "MSPointerMove",
                end: "MSPointerUp"
            } : {
                start: "mousedown touchstart",
                move: "mousemove touchmove",
                end: "mouseup touchend"
            },
            d = window.CSS && CSS.supports && CSS.supports("touch-action", "none") && function() {
                var t = !1;
                try {
                    var e = Object.defineProperty({}, "passive", {
                        get: function() {
                            t = !0
                        }
                    });
                    window.addEventListener("test", null, e)
                } catch (t) {}
                return t
            }(),
            h = t,
            y = v.spectrum,
            b = [],
            S = [],
            m = [],
            g = 0,
            x = {},
            w = t.ownerDocument,
            E = v.documentElement || w.documentElement,
            C = w.body,
            N = -1,
            U = 0,
            P = 1,
            V = 2,
            k = "rtl" === w.dir || 1 === v.ort ? 0 : 100;

        function A(t, e) {
            var r = w.createElement("div");
            return e && ht(r, e), t.appendChild(r), r
        }

        function M(t, e) {
            var r = A(t, v.cssClasses.origin),
                n = A(r, v.cssClasses.handle);
            return A(n, v.cssClasses.touchArea), n.setAttribute("data-handle", e), v.keyboardSupport && (n.setAttribute("tabindex", "0"), n.addEventListener("keydown", function(t) {
                return function(t, e) {
                    if (L() || D(e)) return !1;
                    var r = ["Left", "Right"],
                        n = ["Down", "Up"],
                        i = ["PageDown", "PageUp"],
                        o = ["Home", "End"];
                    v.dir && !v.ort ? r.reverse() : v.ort && !v.dir && (n.reverse(), i.reverse());
                    var a, s = t.key.replace("Arrow", ""),
                        l = s === i[0],
                        u = s === i[1],
                        c = s === n[0] || s === r[0] || l,
                        p = s === n[1] || s === r[1] || u,
                        f = s === o[0],
                        d = s === o[1];
                    if (!(c || p || f || d)) return !0;
                    if (t.preventDefault(), p || c) {
                        var h = c ? 0 : 1,
                            m = st(e),
                            g = m[h];
                        if (null === g) return !1;
                        !1 === g && (g = y.getDefaultStep(S[e], c, 10)), (u || l) && (g *= 5), g = Math.max(g, 1e-7), g *= c ? -1 : 1, a = b[e] + g
                    } else a = d ? v.spectrum.xVal[v.spectrum.xVal.length - 1] : v.spectrum.xVal[0];
                    return rt(e, y.toStepping(a), !0, !0), J("slide", e), J("update", e), J("change", e), J("set", e), !1
                }(t, e)
            })), n.setAttribute("role", "slider"), n.setAttribute("aria-orientation", v.ort ? "vertical" : "horizontal"), 0 === e ? ht(n, v.cssClasses.handleLower) : e === v.handles - 1 && ht(n, v.cssClasses.handleUpper), r
        }

        function O(t, e) {
            return !!e && A(t, v.cssClasses.connect)
        }

        function r(t, e) {
            return !!v.tooltips[e] && A(t.firstChild, v.cssClasses.tooltip)
        }

        function L() {
            return h.hasAttribute("disabled")
        }

        function D(t) {
            return u[t].hasAttribute("disabled")
        }

        function z() {
            i && (G("update.tooltips"), i.forEach(function(t) {
                t && ut(t)
            }), i = null)
        }

        function H() {
            z(), i = u.map(r), $("update.tooltips", function(t, e, r) {
                if (i[e]) {
                    var n = t[e];
                    !0 !== v.tooltips[e] && (n = v.tooltips[e].to(r[e])), i[e].innerHTML = n
                }
            })
        }

        function j(e, i, o) {
            var a = w.createElement("div"),
                s = [];
            s[U] = v.cssClasses.valueNormal, s[P] = v.cssClasses.valueLarge, s[V] = v.cssClasses.valueSub;
            var l = [];
            l[U] = v.cssClasses.markerNormal, l[P] = v.cssClasses.markerLarge, l[V] = v.cssClasses.markerSub;
            var u = [v.cssClasses.valueHorizontal, v.cssClasses.valueVertical],
                c = [v.cssClasses.markerHorizontal, v.cssClasses.markerVertical];

            function p(t, e) {
                var r = e === v.cssClasses.value,
                    n = r ? s : l;
                return e + " " + (r ? u : c)[v.ort] + " " + n[t]
            }
            return ht(a, v.cssClasses.pips), ht(a, 0 === v.ort ? v.cssClasses.pipsHorizontal : v.cssClasses.pipsVertical), Object.keys(e).forEach(function(t) {
                ! function(t, e, r) {
                    if ((r = i ? i(e, r) : r) !== N) {
                        var n = A(a, !1);
                        n.className = p(r, v.cssClasses.marker), n.style[v.style] = t + "%", U < r && ((n = A(a, !1)).className = p(r, v.cssClasses.value), n.setAttribute("data-value", e), n.style[v.style] = t + "%", n.innerHTML = o.to(e))
                    }
                }(t, e[t][0], e[t][1])
            }), a
        }

        function F() {
            c && (ut(c), c = null)
        }

        function R(t) {
            F();
            var m, g, v, b, e, r, S, x, w, n = t.mode,
                i = t.density || 1,
                o = t.filter || !1,
                a = function(t, e, r) {
                    if ("range" === t || "steps" === t) return y.xVal;
                    if ("count" === t) {
                        if (e < 2) throw new Error("noUiSlider (" + lt + "): 'values' (>= 2) required for mode 'count'.");
                        var n = e - 1,
                            i = 100 / n;
                        for (e = []; n--;) e[n] = n * i;
                        e.push(100), t = "positions"
                    }
                    return "positions" === t ? e.map(function(t) {
                        return y.fromStepping(r ? y.getStep(t) : t)
                    }) : "values" === t ? r ? e.map(function(t) {
                        return y.fromStepping(y.getStep(y.toStepping(t)))
                    }) : e : void 0
                }(n, t.values || !1, t.stepped || !1),
                s = (m = i, g = n, v = a, b = {}, e = y.xVal[0], r = y.xVal[y.xVal.length - 1], x = S = !1, w = 0, (v = v.slice().sort(function(t, e) {
                    return t - e
                }).filter(function(t) {
                    return !this[t] && (this[t] = !0)
                }, {}))[0] !== e && (v.unshift(e), S = !0), v[v.length - 1] !== r && (v.push(r), x = !0), v.forEach(function(t, e) {
                    var r, n, i, o, a, s, l, u, c, p, f = t,
                        d = v[e + 1],
                        h = "steps" === g;
                    if (h && (r = y.xNumSteps[e]), r || (r = d - f), !1 !== f && void 0 !== d)
                        for (r = Math.max(r, 1e-7), n = f; n <= d; n = (n + r).toFixed(7) / 1) {
                            for (u = (a = (o = y.toStepping(n)) - w) / m, p = a / (c = Math.round(u)), i = 1; i <= c; i += 1) b[(s = w + i * p).toFixed(5)] = [y.fromStepping(s), 0];
                            l = -1 < v.indexOf(n) ? P : h ? V : U, !e && S && (l = 0), n === d && x || (b[o.toFixed(5)] = [n, l]), w = o
                        }
                }), b),
                l = t.format || {
                    to: Math.round
                };
            return c = h.appendChild(j(s, o, l))
        }

        function T() {
            var t = l.getBoundingClientRect(),
                e = "offset" + ["Width", "Height"][v.ort];
            return 0 === v.ort ? t.width || l[e] : t.height || l[e]
        }

        function B(n, i, o, a) {
            var e = function(t) {
                    return !!(t = function(t, e, r) {
                        var n, i, o = 0 === t.type.indexOf("touch"),
                            a = 0 === t.type.indexOf("mouse"),
                            s = 0 === t.type.indexOf("pointer");
                        0 === t.type.indexOf("MSPointer") && (s = !0);
                        if (o) {
                            var l = function(t) {
                                return t.target === r || r.contains(t.target)
                            };
                            if ("touchstart" === t.type) {
                                var u = Array.prototype.filter.call(t.touches, l);
                                if (1 < u.length) return !1;
                                n = u[0].pageX, i = u[0].pageY
                            } else {
                                var c = Array.prototype.find.call(t.changedTouches, l);
                                if (!c) return !1;
                                n = c.pageX, i = c.pageY
                            }
                        }
                        e = e || gt(w), (a || s) && (n = t.clientX + e.x, i = t.clientY + e.y);
                        return t.pageOffset = e, t.points = [n, i], t.cursor = a || s, t
                    }(t, a.pageOffset, a.target || i)) && (!(L() && !a.doNotReject) && (e = h, r = v.cssClasses.tap, !((e.classList ? e.classList.contains(r) : new RegExp("\\b" + r + "\\b").test(e.className)) && !a.doNotReject) && (!(n === f.start && void 0 !== t.buttons && 1 < t.buttons) && ((!a.hover || !t.buttons) && (d || t.preventDefault(), t.calcPoint = t.points[v.ort], void o(t, a))))));
                    var e, r
                },
                r = [];
            return n.split(" ").forEach(function(t) {
                i.addEventListener(t, e, !!d && {
                    passive: !0
                }), r.push([t, e])
            }), r
        }

        function q(t) {
            var e, r, n, i, o, a, s = 100 * (t - (e = l, r = v.ort, n = e.getBoundingClientRect(), i = e.ownerDocument, o = i.documentElement, a = gt(i), /webkit.*Chrome.*Mobile/i.test(navigator.userAgent) && (a.x = 0), r ? n.top + a.y - o.clientTop : n.left + a.x - o.clientLeft)) / T();
            return s = ft(s), v.dir ? 100 - s : s
        }

        function X(t, e) {
            "mouseout" === t.type && "HTML" === t.target.nodeName && null === t.relatedTarget && _(t, e)
        }

        function Y(t, e) {
            if (-1 === navigator.appVersion.indexOf("MSIE 9") && 0 === t.buttons && 0 !== e.buttonsProperty) return _(t, e);
            var r = (v.dir ? -1 : 1) * (t.calcPoint - e.startCalcPoint);
            Z(0 < r, 100 * r / e.baseSize, e.locations, e.handleNumbers)
        }

        function _(t, e) {
            e.handle && (mt(e.handle, v.cssClasses.active), g -= 1), e.listeners.forEach(function(t) {
                E.removeEventListener(t[0], t[1])
            }), 0 === g && (mt(h, v.cssClasses.drag), et(), t.cursor && (C.style.cursor = "", C.removeEventListener("selectstart", ct))), e.handleNumbers.forEach(function(t) {
                J("change", t), J("set", t), J("end", t)
            })
        }

        function I(t, e) {
            if (e.handleNumbers.some(D)) return !1;
            var r;
            1 === e.handleNumbers.length && (r = u[e.handleNumbers[0]].children[0], g += 1, ht(r, v.cssClasses.active));
            t.stopPropagation();
            var n = [],
                i = B(f.move, E, Y, {
                    target: t.target,
                    handle: r,
                    listeners: n,
                    startCalcPoint: t.calcPoint,
                    baseSize: T(),
                    pageOffset: t.pageOffset,
                    handleNumbers: e.handleNumbers,
                    buttonsProperty: t.buttons,
                    locations: S.slice()
                }),
                o = B(f.end, E, _, {
                    target: t.target,
                    handle: r,
                    listeners: n,
                    doNotReject: !0,
                    handleNumbers: e.handleNumbers
                }),
                a = B("mouseout", E, X, {
                    target: t.target,
                    handle: r,
                    listeners: n,
                    doNotReject: !0,
                    handleNumbers: e.handleNumbers
                });
            n.push.apply(n, i.concat(o, a)), t.cursor && (C.style.cursor = getComputedStyle(t.target).cursor, 1 < u.length && ht(h, v.cssClasses.drag), C.addEventListener("selectstart", ct, !1)), e.handleNumbers.forEach(function(t) {
                J("start", t)
            })
        }

        function n(t) {
            t.stopPropagation();
            var i, o, a, e = q(t.calcPoint),
                r = (i = e, a = !(o = 100), u.forEach(function(t, e) {
                    if (!D(e)) {
                        var r = S[e],
                            n = Math.abs(r - i);
                        (n < o || n <= o && r < i || 100 === n && 100 === o) && (a = e, o = n)
                    }
                }), a);
            if (!1 === r) return !1;
            v.events.snap || pt(h, v.cssClasses.tap, v.animationDuration), rt(r, e, !0, !0), et(), J("slide", r, !0), J("update", r, !0), J("change", r, !0), J("set", r, !0), v.events.snap && I(t, {
                handleNumbers: [r]
            })
        }

        function W(t) {
            var e = q(t.calcPoint),
                r = y.getStep(e),
                n = y.fromStepping(r);
            Object.keys(x).forEach(function(t) {
                "hover" === t.split(".")[0] && x[t].forEach(function(t) {
                    t.call(s, n)
                })
            })
        }

        function $(t, e) {
            x[t] = x[t] || [], x[t].push(e), "update" === t.split(".")[0] && u.forEach(function(t, e) {
                J("update", e)
            })
        }

        function G(t) {
            var n = t && t.split(".")[0],
                i = n && t.substring(n.length);
            Object.keys(x).forEach(function(t) {
                var e = t.split(".")[0],
                    r = t.substring(e.length);
                n && n !== e || i && i !== r || delete x[t]
            })
        }

        function J(r, n, i) {
            Object.keys(x).forEach(function(t) {
                var e = t.split(".")[0];
                r === e && x[t].forEach(function(t) {
                    t.call(s, b.map(v.format.to), n, b.slice(), i || !1, S.slice())
                })
            })
        }

        function K(t, e, r, n, i, o) {
            return 1 < u.length && !v.events.unconstrained && (n && 0 < e && (r = Math.max(r, t[e - 1] + v.margin)), i && e < u.length - 1 && (r = Math.min(r, t[e + 1] - v.margin))), 1 < u.length && v.limit && (n && 0 < e && (r = Math.min(r, t[e - 1] + v.limit)), i && e < u.length - 1 && (r = Math.max(r, t[e + 1] - v.limit))), v.padding && (0 === e && (r = Math.max(r, v.padding[0])), e === u.length - 1 && (r = Math.min(r, 100 - v.padding[1]))), !((r = ft(r = y.getStep(r))) === t[e] && !o) && r
        }

        function Q(t, e) {
            var r = v.ort;
            return (r ? e : t) + ", " + (r ? t : e)
        }

        function Z(t, n, r, e) {
            var i = r.slice(),
                o = [!t, t],
                a = [t, !t];
            e = e.slice(), t && e.reverse(), 1 < e.length ? e.forEach(function(t, e) {
                var r = K(i, t, i[t] + n, o[e], a[e], !1);
                !1 === r ? n = 0 : (n = r - i[t], i[t] = r)
            }) : o = a = [!0];
            var s = !1;
            e.forEach(function(t, e) {
                s = rt(t, r[t] + n, o[e], a[e]) || s
            }), s && e.forEach(function(t) {
                J("update", t), J("slide", t)
            })
        }

        function tt(t, e) {
            return v.dir ? 100 - t - e : t
        }

        function et() {
            m.forEach(function(t) {
                var e = 50 < S[t] ? -1 : 1,
                    r = 3 + (u.length + e * t);
                u[t].style.zIndex = r
            })
        }

        function rt(t, e, r, n) {
            return !1 !== (e = K(S, t, e, r, n, !1)) && (function(t, e) {
                S[t] = e, b[t] = y.fromStepping(e);
                var r = "translate(" + Q(10 * (tt(e, 0) - k) + "%", "0") + ")";
                u[t].style[v.transformRule] = r, nt(t), nt(t + 1)
            }(t, e), !0)
        }

        function nt(t) {
            if (a[t]) {
                var e = 0,
                    r = 100;
                0 !== t && (e = S[t - 1]), t !== a.length - 1 && (r = S[t]);
                var n = r - e,
                    i = "translate(" + Q(tt(e, n) + "%", "0") + ")",
                    o = "scale(" + Q(n / 100, "1") + ")";
                a[t].style[v.transformRule] = i + " " + o
            }
        }

        function it(t, e) {
            return null === t || !1 === t || void 0 === t ? S[e] : ("number" == typeof t && (t = String(t)), t = v.format.from(t), !1 === (t = y.toStepping(t)) || isNaN(t) ? S[e] : t)
        }

        function ot(t, e) {
            var r = dt(t),
                n = void 0 === S[0];
            e = void 0 === e || !!e, v.animate && !n && pt(h, v.cssClasses.tap, v.animationDuration), m.forEach(function(t) {
                rt(t, it(r[t], t), !0, !1)
            });
            for (var i = 1 === m.length ? 0 : 1; i < m.length; ++i) m.forEach(function(t) {
                rt(t, S[t], !0, !0)
            });
            et(), m.forEach(function(t) {
                J("update", t), null !== r[t] && e && J("set", t)
            })
        }

        function at() {
            var t = b.map(v.format.to);
            return 1 === t.length ? t[0] : t
        }

        function st(t) {
            var e = S[t],
                r = y.getNearbySteps(e),
                n = b[t],
                i = r.thisStep.step,
                o = null;
            if (v.snap) return [n - r.stepBefore.startValue || null, r.stepAfter.startValue - n || null];
            !1 !== i && n + i > r.stepAfter.startValue && (i = r.stepAfter.startValue - n), o = n > r.thisStep.startValue ? r.thisStep.step : !1 !== r.stepBefore.step && n - r.stepBefore.highestStep, 100 === e ? i = null : 0 === e && (o = null);
            var a = y.countStepDecimals();
            return null !== i && !1 !== i && (i = Number(i.toFixed(a))), null !== o && !1 !== o && (o = Number(o.toFixed(a))), [o, i]
        }
        return ht(e = h, v.cssClasses.target), 0 === v.dir ? ht(e, v.cssClasses.ltr) : ht(e, v.cssClasses.rtl), 0 === v.ort ? ht(e, v.cssClasses.horizontal) : ht(e, v.cssClasses.vertical), ht(e, "ltr" === getComputedStyle(e).direction ? v.cssClasses.textDirectionLtr : v.cssClasses.textDirectionRtl), l = A(e, v.cssClasses.base),
            function(t, e) {
                var r = A(e, v.cssClasses.connects);
                u = [], (a = []).push(O(r, t[0]));
                for (var n = 0; n < v.handles; n++) u.push(M(e, n)), m[n] = n, a.push(O(r, t[n + 1]))
            }(v.connect, l), (p = v.events).fixed || u.forEach(function(t, e) {
                B(f.start, t.children[0], I, {
                    handleNumbers: [e]
                })
            }), p.tap && B(f.start, l, n, {}), p.hover && B(f.move, l, W, {
                hover: !0
            }), p.drag && a.forEach(function(t, e) {
                if (!1 !== t && 0 !== e && e !== a.length - 1) {
                    var r = u[e - 1],
                        n = u[e],
                        i = [t];
                    ht(t, v.cssClasses.draggable), p.fixed && (i.push(r.children[0]), i.push(n.children[0])), i.forEach(function(t) {
                        B(f.start, t, I, {
                            handles: [r, n],
                            handleNumbers: [e - 1, e]
                        })
                    })
                }
            }), ot(v.start), v.pips && R(v.pips), v.tooltips && H(), $("update", function(t, e, a, r, s) {
                m.forEach(function(t) {
                    var e = u[t],
                        r = K(S, t, 0, !0, !0, !0),
                        n = K(S, t, 100, !0, !0, !0),
                        i = s[t],
                        o = v.ariaFormat.to(a[t]);
                    r = y.fromStepping(r).toFixed(1), n = y.fromStepping(n).toFixed(1), i = y.fromStepping(i).toFixed(1), e.children[0].setAttribute("aria-valuemin", r), e.children[0].setAttribute("aria-valuemax", n), e.children[0].setAttribute("aria-valuenow", i), e.children[0].setAttribute("aria-valuetext", o)
                })
            }), s = {
                destroy: function() {
                    for (var t in v.cssClasses) v.cssClasses.hasOwnProperty(t) && mt(h, v.cssClasses[t]);
                    for (; h.firstChild;) h.removeChild(h.firstChild);
                    delete h.noUiSlider
                },
                steps: function() {
                    return m.map(st)
                },
                on: $,
                off: G,
                get: at,
                set: ot,
                setHandle: function(t, e, r) {
                    if (!(0 <= (t = Number(t)) && t < m.length)) throw new Error("noUiSlider (" + lt + "): invalid handle number, got: " + t);
                    rt(t, it(e, t), !0, !0), J("update", t), r && J("set", t)
                },
                reset: function(t) {
                    ot(v.start, t)
                },
                __moveHandles: function(t, e, r) {
                    Z(t, e, S, r)
                },
                options: o,
                updateOptions: function(e, t) {
                    var r = at(),
                        n = ["margin", "limit", "padding", "range", "animate", "snap", "step", "format", "pips", "tooltips"];
                    n.forEach(function(t) {
                        void 0 !== e[t] && (o[t] = e[t])
                    });
                    var i = vt(o);
                    n.forEach(function(t) {
                        void 0 !== e[t] && (v[t] = i[t])
                    }), y = i.spectrum, v.margin = i.margin, v.limit = i.limit, v.padding = i.padding, v.pips ? R(v.pips) : F(), v.tooltips ? H() : z(), S = [], ot(e.start || r, t)
                },
                target: h,
                removePips: F,
                removeTooltips: z,
                pips: R
            }
    }
    return {
        __spectrum: l,
        version: lt,
        create: function(t, e) {
            if (!t || !t.nodeName) throw new Error("noUiSlider (" + lt + "): create requires a single element, got: " + t);
            if (t.noUiSlider) throw new Error("noUiSlider (" + lt + "): Slider was already initialized.");
            var r = D(t, vt(e), e);
            return t.noUiSlider = r
        }
    }
});
/*! PhotoSwipe - v4.1.3 - 2019-01-08
 * http://photoswipe.com
 * Copyright (c) 2019 Dmitry Semenov; */
! function(a, b) {
    "function" == typeof define && define.amd ? define(b) : "object" == typeof exports ? module.exports = b() : a.PhotoSwipe = b()
}(this, function() {
    "use strict";
    var a = function(a, b, c, d) {
        var e = {
            features: null,
            bind: function(a, b, c, d) {
                var e = (d ? "remove" : "add") + "EventListener";
                b = b.split(" ");
                for (var f = 0; f < b.length; f++) b[f] && a[e](b[f], c, !1)
            },
            isArray: function(a) {
                return a instanceof Array
            },
            createEl: function(a, b) {
                var c = document.createElement(b || "div");
                return a && (c.className = a), c
            },
            getScrollY: function() {
                var a = window.pageYOffset;
                return void 0 !== a ? a : document.documentElement.scrollTop
            },
            unbind: function(a, b, c) {
                e.bind(a, b, c, !0)
            },
            removeClass: function(a, b) {
                var c = new RegExp("(\\s|^)" + b + "(\\s|$)");
                a.className = a.className.replace(c, " ").replace(/^\s\s*/, "").replace(/\s\s*$/, "")
            },
            addClass: function(a, b) {
                e.hasClass(a, b) || (a.className += (a.className ? " " : "") + b)
            },
            hasClass: function(a, b) {
                return a.className && new RegExp("(^|\\s)" + b + "(\\s|$)").test(a.className)
            },
            getChildByClass: function(a, b) {
                for (var c = a.firstChild; c;) {
                    if (e.hasClass(c, b)) return c;
                    c = c.nextSibling
                }
            },
            arraySearch: function(a, b, c) {
                for (var d = a.length; d--;)
                    if (a[d][c] === b) return d;
                return -1
            },
            extend: function(a, b, c) {
                for (var d in b)
                    if (b.hasOwnProperty(d)) {
                        if (c && a.hasOwnProperty(d)) continue;
                        a[d] = b[d]
                    }
            },
            easing: {
                sine: {
                    out: function(a) {
                        return Math.sin(a * (Math.PI / 2))
                    },
                    inOut: function(a) {
                        return -(Math.cos(Math.PI * a) - 1) / 2
                    }
                },
                cubic: {
                    out: function(a) {
                        return --a * a * a + 1
                    }
                }
            },
            detectFeatures: function() {
                if (e.features) return e.features;
                var a = e.createEl(),
                    b = a.style,
                    c = "",
                    d = {};
                if (d.oldIE = document.all && !document.addEventListener, d.touch = "ontouchstart" in window, window.requestAnimationFrame && (d.raf = window.requestAnimationFrame, d.caf = window.cancelAnimationFrame), d.pointerEvent = !!window.PointerEvent || navigator.msPointerEnabled, !d.pointerEvent) {
                    var f = navigator.userAgent;
                    if (/iP(hone|od)/.test(navigator.platform)) {
                        var g = navigator.appVersion.match(/OS (\d+)_(\d+)_?(\d+)?/);
                        g && g.length > 0 && (g = parseInt(g[1], 10), g >= 1 && g < 8 && (d.isOldIOSPhone = !0))
                    }
                    var h = f.match(/Android\s([0-9\.]*)/),
                        i = h ? h[1] : 0;
                    i = parseFloat(i), i >= 1 && (i < 4.4 && (d.isOldAndroid = !0), d.androidVersion = i), d.isMobileOpera = /opera mini|opera mobi/i.test(f)
                }
                for (var j, k, l = ["transform", "perspective", "animationName"], m = ["", "webkit", "Moz", "ms", "O"], n = 0; n < 4; n++) {
                    c = m[n];
                    for (var o = 0; o < 3; o++) j = l[o], k = c + (c ? j.charAt(0).toUpperCase() + j.slice(1) : j), !d[j] && k in b && (d[j] = k);
                    c && !d.raf && (c = c.toLowerCase(), d.raf = window[c + "RequestAnimationFrame"], d.raf && (d.caf = window[c + "CancelAnimationFrame"] || window[c + "CancelRequestAnimationFrame"]))
                }
                if (!d.raf) {
                    var p = 0;
                    d.raf = function(a) {
                        var b = (new Date).getTime(),
                            c = Math.max(0, 16 - (b - p)),
                            d = window.setTimeout(function() {
                                a(b + c)
                            }, c);
                        return p = b + c, d
                    }, d.caf = function(a) {
                        clearTimeout(a)
                    }
                }
                return d.svg = !!document.createElementNS && !!document.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect, e.features = d, d
            }
        };
        e.detectFeatures(), e.features.oldIE && (e.bind = function(a, b, c, d) {
            b = b.split(" ");
            for (var e, f = (d ? "detach" : "attach") + "Event", g = function() {
                    c.handleEvent.call(c)
                }, h = 0; h < b.length; h++)
                if (e = b[h])
                    if ("object" == typeof c && c.handleEvent) {
                        if (d) {
                            if (!c["oldIE" + e]) return !1
                        } else c["oldIE" + e] = g;
                        a[f]("on" + e, c["oldIE" + e])
                    } else a[f]("on" + e, c)
        });
        var f = this,
            g = 25,
            h = 3,
            i = {
                allowPanToNext: !0,
                spacing: .12,
                bgOpacity: 1,
                mouseUsed: !1,
                loop: !0,
                pinchToClose: !0,
                closeOnScroll: !0,
                closeOnVerticalDrag: !0,
                verticalDragRange: .75,
                hideAnimationDuration: 333,
                showAnimationDuration: 333,
                showHideOpacity: !1,
                focus: !0,
                escKey: !0,
                arrowKeys: !0,
                mainScrollEndFriction: .35,
                panEndFriction: .35,
                isClickableElement: function(a) {
                    return "A" === a.tagName
                },
                getDoubleTapZoom: function(a, b) {
                    return a ? 1 : b.initialZoomLevel < .7 ? 1 : 1.33
                },
                maxSpreadZoom: 1.33,
                modal: !0,
                scaleMode: "fit"
            };
        e.extend(i, d);
        var j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z, $, _, aa, ba, ca, da, ea, fa, ga, ha, ia, ja, ka, la, ma = function() {
                return {
                    x: 0,
                    y: 0
                }
            },
            na = ma(),
            oa = ma(),
            pa = ma(),
            qa = {},
            ra = 0,
            sa = {},
            ta = ma(),
            ua = 0,
            va = !0,
            wa = [],
            xa = {},
            ya = !1,
            za = function(a, b) {
                e.extend(f, b.publicMethods), wa.push(a)
            },
            Aa = function(a) {
                var b = ac();
                return a > b - 1 ? a - b : a < 0 ? b + a : a
            },
            Ba = {},
            Ca = function(a, b) {
                return Ba[a] || (Ba[a] = []), Ba[a].push(b)
            },
            Da = function(a) {
                var b = Ba[a];
                if (b) {
                    var c = Array.prototype.slice.call(arguments);
                    c.shift();
                    for (var d = 0; d < b.length; d++) b[d].apply(f, c)
                }
            },
            Ea = function() {
                return (new Date).getTime()
            },
            Fa = function(a) {
                ja = a, f.bg.style.opacity = a * i.bgOpacity
            },
            Ga = function(a, b, c, d, e) {
                (!ya || e && e !== f.currItem) && (d /= e ? e.fitRatio : f.currItem.fitRatio), a[E] = u + b + "px, " + c + "px" + v + " scale(" + d + ")"
            },
            Ha = function(a) {
                ea && (a && (s > f.currItem.fitRatio ? ya || (mc(f.currItem, !1, !0), ya = !0) : ya && (mc(f.currItem), ya = !1)), Ga(ea, pa.x, pa.y, s))
            },
            Ia = function(a) {
                a.container && Ga(a.container.style, a.initialPosition.x, a.initialPosition.y, a.initialZoomLevel, a)
            },
            Ja = function(a, b) {
                b[E] = u + a + "px, 0px" + v
            },
            Ka = function(a, b) {
                if (!i.loop && b) {
                    var c = m + (ta.x * ra - a) / ta.x,
                        d = Math.round(a - tb.x);
                    (c < 0 && d > 0 || c >= ac() - 1 && d < 0) && (a = tb.x + d * i.mainScrollEndFriction)
                }
                tb.x = a, Ja(a, n)
            },
            La = function(a, b) {
                var c = ub[a] - sa[a];
                return oa[a] + na[a] + c - c * (b / t)
            },
            Ma = function(a, b) {
                a.x = b.x, a.y = b.y, b.id && (a.id = b.id)
            },
            Na = function(a) {
                a.x = Math.round(a.x), a.y = Math.round(a.y)
            },
            Oa = null,
            Pa = function() {
                Oa && (e.unbind(document, "mousemove", Pa), e.addClass(a, "pswp--has_mouse"), i.mouseUsed = !0, Da("mouseUsed")), Oa = setTimeout(function() {
                    Oa = null
                }, 100)
            },
            Qa = function() {
                e.bind(document, "keydown", f), N.transform && e.bind(f.scrollWrap, "click", f), i.mouseUsed || e.bind(document, "mousemove", Pa), e.bind(window, "resize scroll orientationchange", f), Da("bindEvents")
            },
            Ra = function() {
                e.unbind(window, "resize scroll orientationchange", f), e.unbind(window, "scroll", r.scroll), e.unbind(document, "keydown", f), e.unbind(document, "mousemove", Pa), N.transform && e.unbind(f.scrollWrap, "click", f), V && e.unbind(window, p, f), clearTimeout(O), Da("unbindEvents")
            },
            Sa = function(a, b) {
                var c = ic(f.currItem, qa, a);
                return b && (da = c), c
            },
            Ta = function(a) {
                return a || (a = f.currItem), a.initialZoomLevel
            },
            Ua = function(a) {
                return a || (a = f.currItem), a.w > 0 ? i.maxSpreadZoom : 1
            },
            Va = function(a, b, c, d) {
                return d === f.currItem.initialZoomLevel ? (c[a] = f.currItem.initialPosition[a], !0) : (c[a] = La(a, d), c[a] > b.min[a] ? (c[a] = b.min[a], !0) : c[a] < b.max[a] && (c[a] = b.max[a], !0))
            },
            Wa = function() {
                if (E) {
                    var b = N.perspective && !G;
                    return u = "translate" + (b ? "3d(" : "("), void(v = N.perspective ? ", 0px)" : ")")
                }
                E = "left", e.addClass(a, "pswp--ie"), Ja = function(a, b) {
                    b.left = a + "px"
                }, Ia = function(a) {
                    var b = a.fitRatio > 1 ? 1 : a.fitRatio,
                        c = a.container.style,
                        d = b * a.w,
                        e = b * a.h;
                    c.width = d + "px", c.height = e + "px", c.left = a.initialPosition.x + "px", c.top = a.initialPosition.y + "px"
                }, Ha = function() {
                    if (ea) {
                        var a = ea,
                            b = f.currItem,
                            c = b.fitRatio > 1 ? 1 : b.fitRatio,
                            d = c * b.w,
                            e = c * b.h;
                        a.width = d + "px", a.height = e + "px", a.left = pa.x + "px", a.top = pa.y + "px"
                    }
                }
            },
            Xa = function(a) {
                var b = "";
                i.escKey && 27 === a.keyCode ? b = "close" : i.arrowKeys && (37 === a.keyCode ? b = "prev" : 39 === a.keyCode && (b = "next")), b && (a.ctrlKey || a.altKey || a.shiftKey || a.metaKey || (a.preventDefault ? a.preventDefault() : a.returnValue = !1, f[b]()))
            },
            Ya = function(a) {
                a && (Y || X || fa || T) && (a.preventDefault(), a.stopPropagation())
            },
            Za = function() {
                f.setScrollOffset(0, e.getScrollY())
            },
            $a = {},
            _a = 0,
            ab = function(a) {
                $a[a] && ($a[a].raf && I($a[a].raf), _a--, delete $a[a])
            },
            bb = function(a) {
                $a[a] && ab(a), $a[a] || (_a++, $a[a] = {})
            },
            cb = function() {
                for (var a in $a) $a.hasOwnProperty(a) && ab(a)
            },
            db = function(a, b, c, d, e, f, g) {
                var h, i = Ea();
                bb(a);
                var j = function() {
                    if ($a[a]) {
                        if (h = Ea() - i, h >= d) return ab(a), f(c), void(g && g());
                        f((c - b) * e(h / d) + b), $a[a].raf = H(j)
                    }
                };
                j()
            },
            eb = {
                shout: Da,
                listen: Ca,
                viewportSize: qa,
                options: i,
                isMainScrollAnimating: function() {
                    return fa
                },
                getZoomLevel: function() {
                    return s
                },
                getCurrentIndex: function() {
                    return m
                },
                isDragging: function() {
                    return V
                },
                isZooming: function() {
                    return aa
                },
                setScrollOffset: function(a, b) {
                    sa.x = a, M = sa.y = b, Da("updateScrollOffset", sa)
                },
                applyZoomPan: function(a, b, c, d) {
                    pa.x = b, pa.y = c, s = a, Ha(d)
                },
                init: function() {
                    if (!j && !k) {
                        var c;
                        f.framework = e, f.template = a, f.bg = e.getChildByClass(a, "pswp__bg"), J = a.className, j = !0, N = e.detectFeatures(), H = N.raf, I = N.caf, E = N.transform, L = N.oldIE, f.scrollWrap = e.getChildByClass(a, "pswp__scroll-wrap"), f.container = e.getChildByClass(f.scrollWrap, "pswp__container"), n = f.container.style, f.itemHolders = y = [{
                            el: f.container.children[0],
                            wrap: 0,
                            index: -1
                        }, {
                            el: f.container.children[1],
                            wrap: 0,
                            index: -1
                        }, {
                            el: f.container.children[2],
                            wrap: 0,
                            index: -1
                        }], y[0].el.style.display = y[2].el.style.display = "none", Wa(), r = {
                            resize: f.updateSize,
                            orientationchange: function() {
                                clearTimeout(O), O = setTimeout(function() {
                                    qa.x !== f.scrollWrap.clientWidth && f.updateSize()
                                }, 500)
                            },
                            scroll: Za,
                            keydown: Xa,
                            click: Ya
                        };
                        var d = N.isOldIOSPhone || N.isOldAndroid || N.isMobileOpera;
                        for (N.animationName && N.transform && !d || (i.showAnimationDuration = i.hideAnimationDuration = 0), c = 0; c < wa.length; c++) f["init" + wa[c]]();
                        if (b) {
                            var g = f.ui = new b(f, e);
                            g.init()
                        }
                        Da("firstUpdate"), m = m || i.index || 0, (isNaN(m) || m < 0 || m >= ac()) && (m = 0), f.currItem = _b(m), (N.isOldIOSPhone || N.isOldAndroid) && (va = !1), a.setAttribute("aria-hidden", "false"), i.modal && (va ? a.style.position = "fixed" : (a.style.position = "absolute", a.style.top = e.getScrollY() + "px")), void 0 === M && (Da("initialLayout"), M = K = e.getScrollY());
                        var l = "pswp--open ";
                        for (i.mainClass && (l += i.mainClass + " "), i.showHideOpacity && (l += "pswp--animate_opacity "), l += G ? "pswp--touch" : "pswp--notouch", l += N.animationName ? " pswp--css_animation" : "", l += N.svg ? " pswp--svg" : "", e.addClass(a, l), f.updateSize(), o = -1, ua = null, c = 0; c < h; c++) Ja((c + o) * ta.x, y[c].el.style);
                        L || e.bind(f.scrollWrap, q, f), Ca("initialZoomInEnd", function() {
                            f.setContent(y[0], m - 1), f.setContent(y[2], m + 1), y[0].el.style.display = y[2].el.style.display = "block", i.focus && a.focus(), Qa()
                        }), f.setContent(y[1], m), f.updateCurrItem(), Da("afterInit"), va || (w = setInterval(function() {
                            _a || V || aa || s !== f.currItem.initialZoomLevel || f.updateSize()
                        }, 1e3)), e.addClass(a, "pswp--visible")
                    }
                },
                close: function() {
                    j && (j = !1, k = !0, Da("close"), Ra(), cc(f.currItem, null, !0, f.destroy))
                },
                destroy: function() {
                    Da("destroy"), Xb && clearTimeout(Xb), a.setAttribute("aria-hidden", "true"), a.className = J, w && clearInterval(w), e.unbind(f.scrollWrap, q, f), e.unbind(window, "scroll", f), zb(), cb(), Ba = null
                },
                panTo: function(a, b, c) {
                    c || (a > da.min.x ? a = da.min.x : a < da.max.x && (a = da.max.x), b > da.min.y ? b = da.min.y : b < da.max.y && (b = da.max.y)), pa.x = a, pa.y = b, Ha()
                },
                handleEvent: function(a) {
                    a = a || window.event, r[a.type] && r[a.type](a)
                },
                goTo: function(a) {
                    a = Aa(a);
                    var b = a - m;
                    ua = b, m = a, f.currItem = _b(m), ra -= b, Ka(ta.x * ra), cb(), fa = !1, f.updateCurrItem()
                },
                next: function() {
                    f.goTo(m + 1)
                },
                prev: function() {
                    f.goTo(m - 1)
                },
                updateCurrZoomItem: function(a) {
                    if (a && Da("beforeChange", 0), y[1].el.children.length) {
                        var b = y[1].el.children[0];
                        ea = e.hasClass(b, "pswp__zoom-wrap") ? b.style : null
                    } else ea = null;
                    da = f.currItem.bounds, t = s = f.currItem.initialZoomLevel, pa.x = da.center.x, pa.y = da.center.y, a && Da("afterChange")
                },
                invalidateCurrItems: function() {
                    x = !0;
                    for (var a = 0; a < h; a++) y[a].item && (y[a].item.needsUpdate = !0)
                },
                updateCurrItem: function(a) {
                    if (0 !== ua) {
                        var b, c = Math.abs(ua);
                        if (!(a && c < 2)) {
                            f.currItem = _b(m), ya = !1, Da("beforeChange", ua), c >= h && (o += ua + (ua > 0 ? -h : h), c = h);
                            for (var d = 0; d < c; d++) ua > 0 ? (b = y.shift(), y[h - 1] = b, o++, Ja((o + 2) * ta.x, b.el.style), f.setContent(b, m - c + d + 1 + 1)) : (b = y.pop(), y.unshift(b), o--, Ja(o * ta.x, b.el.style), f.setContent(b, m + c - d - 1 - 1));
                            if (ea && 1 === Math.abs(ua)) {
                                var e = _b(z);
                                e.initialZoomLevel !== s && (ic(e, qa), mc(e), Ia(e))
                            }
                            ua = 0, f.updateCurrZoomItem(), z = m, Da("afterChange")
                        }
                    }
                },
                updateSize: function(b) {
                    if (!va && i.modal) {
                        var c = e.getScrollY();
                        if (M !== c && (a.style.top = c + "px", M = c), !b && xa.x === window.innerWidth && xa.y === window.innerHeight) return;
                        xa.x = window.innerWidth, xa.y = window.innerHeight, a.style.height = xa.y + "px"
                    }
                    if (qa.x = f.scrollWrap.clientWidth, qa.y = f.scrollWrap.clientHeight, Za(), ta.x = qa.x + Math.round(qa.x * i.spacing), ta.y = qa.y, Ka(ta.x * ra), Da("beforeResize"), void 0 !== o) {
                        for (var d, g, j, k = 0; k < h; k++) d = y[k], Ja((k + o) * ta.x, d.el.style), j = m + k - 1, i.loop && ac() > 2 && (j = Aa(j)), g = _b(j), g && (x || g.needsUpdate || !g.bounds) ? (f.cleanSlide(g), f.setContent(d, j), 1 === k && (f.currItem = g, f.updateCurrZoomItem(!0)), g.needsUpdate = !1) : d.index === -1 && j >= 0 && f.setContent(d, j), g && g.container && (ic(g, qa), mc(g), Ia(g));
                        x = !1
                    }
                    t = s = f.currItem.initialZoomLevel, da = f.currItem.bounds, da && (pa.x = da.center.x, pa.y = da.center.y, Ha(!0)), Da("resize")
                },
                zoomTo: function(a, b, c, d, f) {
                    b && (t = s, ub.x = Math.abs(b.x) - pa.x, ub.y = Math.abs(b.y) - pa.y, Ma(oa, pa));
                    var g = Sa(a, !1),
                        h = {};
                    Va("x", g, h, a), Va("y", g, h, a);
                    var i = s,
                        j = {
                            x: pa.x,
                            y: pa.y
                        };
                    Na(h);
                    var k = function(b) {
                        1 === b ? (s = a, pa.x = h.x, pa.y = h.y) : (s = (a - i) * b + i, pa.x = (h.x - j.x) * b + j.x, pa.y = (h.y - j.y) * b + j.y), f && f(b), Ha(1 === b)
                    };
                    c ? db("customZoomTo", 0, 1, c, d || e.easing.sine.inOut, k) : k(1)
                }
            },
            fb = 30,
            gb = 10,
            hb = {},
            ib = {},
            jb = {},
            kb = {},
            lb = {},
            mb = [],
            nb = {},
            ob = [],
            pb = {},
            qb = 0,
            rb = ma(),
            sb = 0,
            tb = ma(),
            ub = ma(),
            vb = ma(),
            wb = function(a, b) {
                return a.x === b.x && a.y === b.y
            },
            xb = function(a, b) {
                return Math.abs(a.x - b.x) < g && Math.abs(a.y - b.y) < g
            },
            yb = function(a, b) {
                return pb.x = Math.abs(a.x - b.x), pb.y = Math.abs(a.y - b.y), Math.sqrt(pb.x * pb.x + pb.y * pb.y)
            },
            zb = function() {
                Z && (I(Z), Z = null)
            },
            Ab = function() {
                V && (Z = H(Ab), Qb())
            },
            Bb = function() {
                return !("fit" === i.scaleMode && s === f.currItem.initialZoomLevel)
            },
            Cb = function(a, b) {
                return !(!a || a === document) && (!(a.getAttribute("class") && a.getAttribute("class").indexOf("pswp__scroll-wrap") > -1) && (b(a) ? a : Cb(a.parentNode, b)))
            },
            Db = {},
            Eb = function(a, b) {
                return Db.prevent = !Cb(a.target, i.isClickableElement), Da("preventDragEvent", a, b, Db), Db.prevent
            },
            Fb = function(a, b) {
                return b.x = a.pageX, b.y = a.pageY, b.id = a.identifier, b
            },
            Gb = function(a, b, c) {
                c.x = .5 * (a.x + b.x), c.y = .5 * (a.y + b.y)
            },
            Hb = function(a, b, c) {
                if (a - Q > 50) {
                    var d = ob.length > 2 ? ob.shift() : {};
                    d.x = b, d.y = c, ob.push(d), Q = a
                }
            },
            Ib = function() {
                var a = pa.y - f.currItem.initialPosition.y;
                return 1 - Math.abs(a / (qa.y / 2))
            },
            Jb = {},
            Kb = {},
            Lb = [],
            Mb = function(a) {
                for (; Lb.length > 0;) Lb.pop();
                return F ? (la = 0, mb.forEach(function(a) {
                    0 === la ? Lb[0] = a : 1 === la && (Lb[1] = a), la++
                })) : a.type.indexOf("touch") > -1 ? a.touches && a.touches.length > 0 && (Lb[0] = Fb(a.touches[0], Jb), a.touches.length > 1 && (Lb[1] = Fb(a.touches[1], Kb))) : (Jb.x = a.pageX, Jb.y = a.pageY, Jb.id = "", Lb[0] = Jb), Lb
            },
            Nb = function(a, b) {
                var c, d, e, g, h = 0,
                    j = pa[a] + b[a],
                    k = b[a] > 0,
                    l = tb.x + b.x,
                    m = tb.x - nb.x;
                return c = j > da.min[a] || j < da.max[a] ? i.panEndFriction : 1, j = pa[a] + b[a] * c, !i.allowPanToNext && s !== f.currItem.initialZoomLevel || (ea ? "h" !== ga || "x" !== a || X || (k ? (j > da.min[a] && (c = i.panEndFriction, h = da.min[a] - j, d = da.min[a] - oa[a]), (d <= 0 || m < 0) && ac() > 1 ? (g = l, m < 0 && l > nb.x && (g = nb.x)) : da.min.x !== da.max.x && (e = j)) : (j < da.max[a] && (c = i.panEndFriction, h = j - da.max[a], d = oa[a] - da.max[a]), (d <= 0 || m > 0) && ac() > 1 ? (g = l, m > 0 && l < nb.x && (g = nb.x)) : da.min.x !== da.max.x && (e = j))) : g = l, "x" !== a) ? void(fa || $ || s > f.currItem.fitRatio && (pa[a] += b[a] * c)) : (void 0 !== g && (Ka(g, !0), $ = g !== nb.x), da.min.x !== da.max.x && (void 0 !== e ? pa.x = e : $ || (pa.x += b.x * c)), void 0 !== g)
            },
            Ob = function(a) {
                if (!("mousedown" === a.type && a.button > 0)) {
                    if ($b) return void a.preventDefault();
                    if (!U || "mousedown" !== a.type) {
                        if (Eb(a, !0) && a.preventDefault(), Da("pointerDown"), F) {
                            var b = e.arraySearch(mb, a.pointerId, "id");
                            b < 0 && (b = mb.length), mb[b] = {
                                x: a.pageX,
                                y: a.pageY,
                                id: a.pointerId
                            }
                        }
                        var c = Mb(a),
                            d = c.length;
                        _ = null, cb(), V && 1 !== d || (V = ha = !0, e.bind(window, p, f), S = ka = ia = T = $ = Y = W = X = !1, ga = null, Da("firstTouchStart", c), Ma(oa, pa), na.x = na.y = 0, Ma(kb, c[0]), Ma(lb, kb), nb.x = ta.x * ra, ob = [{
                            x: kb.x,
                            y: kb.y
                        }], Q = P = Ea(), Sa(s, !0), zb(), Ab()), !aa && d > 1 && !fa && !$ && (t = s, X = !1, aa = W = !0, na.y = na.x = 0, Ma(oa, pa), Ma(hb, c[0]), Ma(ib, c[1]), Gb(hb, ib, vb), ub.x = Math.abs(vb.x) - pa.x, ub.y = Math.abs(vb.y) - pa.y, ba = ca = yb(hb, ib))
                    }
                }
            },
            Pb = function(a) {
                if (a.preventDefault(), F) {
                    var b = e.arraySearch(mb, a.pointerId, "id");
                    if (b > -1) {
                        var c = mb[b];
                        c.x = a.pageX, c.y = a.pageY
                    }
                }
                if (V) {
                    var d = Mb(a);
                    if (ga || Y || aa) _ = d;
                    else if (tb.x !== ta.x * ra) ga = "h";
                    else {
                        var f = Math.abs(d[0].x - kb.x) - Math.abs(d[0].y - kb.y);
                        Math.abs(f) >= gb && (ga = f > 0 ? "h" : "v", _ = d)
                    }
                }
            },
            Qb = function() {
                if (_) {
                    var a = _.length;
                    if (0 !== a)
                        if (Ma(hb, _[0]), jb.x = hb.x - kb.x, jb.y = hb.y - kb.y, aa && a > 1) {
                            if (kb.x = hb.x, kb.y = hb.y, !jb.x && !jb.y && wb(_[1], ib)) return;
                            Ma(ib, _[1]), X || (X = !0, Da("zoomGestureStarted"));
                            var b = yb(hb, ib),
                                c = Vb(b);
                            c > f.currItem.initialZoomLevel + f.currItem.initialZoomLevel / 15 && (ka = !0);
                            var d = 1,
                                e = Ta(),
                                g = Ua();
                            if (c < e)
                                if (i.pinchToClose && !ka && t <= f.currItem.initialZoomLevel) {
                                    var h = e - c,
                                        j = 1 - h / (e / 1.2);
                                    Fa(j), Da("onPinchClose", j), ia = !0
                                } else d = (e - c) / e, d > 1 && (d = 1), c = e - d * (e / 3);
                            else c > g && (d = (c - g) / (6 * e), d > 1 && (d = 1), c = g + d * e);
                            d < 0 && (d = 0), ba = b, Gb(hb, ib, rb), na.x += rb.x - vb.x, na.y += rb.y - vb.y, Ma(vb, rb), pa.x = La("x", c), pa.y = La("y", c), S = c > s, s = c, Ha()
                        } else {
                            if (!ga) return;
                            if (ha && (ha = !1, Math.abs(jb.x) >= gb && (jb.x -= _[0].x - lb.x), Math.abs(jb.y) >= gb && (jb.y -= _[0].y - lb.y)), kb.x = hb.x, kb.y = hb.y, 0 === jb.x && 0 === jb.y) return;
                            if ("v" === ga && i.closeOnVerticalDrag && !Bb()) {
                                na.y += jb.y, pa.y += jb.y;
                                var k = Ib();
                                return T = !0, Da("onVerticalDrag", k), Fa(k), void Ha()
                            }
                            Hb(Ea(), hb.x, hb.y), Y = !0, da = f.currItem.bounds;
                            var l = Nb("x", jb);
                            l || (Nb("y", jb), Na(pa), Ha())
                        }
                }
            },
            Rb = function(a) {
                if (N.isOldAndroid) {
                    if (U && "mouseup" === a.type) return;
                    a.type.indexOf("touch") > -1 && (clearTimeout(U), U = setTimeout(function() {
                        U = 0
                    }, 600))
                }
                Da("pointerUp"), Eb(a, !1) && a.preventDefault();
                var b;
                if (F) {
                    var c = e.arraySearch(mb, a.pointerId, "id");
                    if (c > -1)
                        if (b = mb.splice(c, 1)[0], navigator.msPointerEnabled) {
                            var d = {
                                4: "mouse",
                                2: "touch",
                                3: "pen"
                            };
                            b.type = d[a.pointerType], b.type || (b.type = a.pointerType || "mouse")
                        } else b.type = a.pointerType || "mouse"
                }
                var g, h = Mb(a),
                    j = h.length;
                if ("mouseup" === a.type && (j = 0), 2 === j) return _ = null, !0;
                1 === j && Ma(lb, h[0]), 0 !== j || ga || fa || (b || ("mouseup" === a.type ? b = {
                    x: a.pageX,
                    y: a.pageY,
                    type: "mouse"
                } : a.changedTouches && a.changedTouches[0] && (b = {
                    x: a.changedTouches[0].pageX,
                    y: a.changedTouches[0].pageY,
                    type: "touch"
                })), Da("touchRelease", a, b));
                var k = -1;
                if (0 === j && (V = !1, e.unbind(window, p, f), zb(), aa ? k = 0 : sb !== -1 && (k = Ea() - sb)), sb = 1 === j ? Ea() : -1, g = k !== -1 && k < 150 ? "zoom" : "swipe", aa && j < 2 && (aa = !1, 1 === j && (g = "zoomPointerUp"), Da("zoomGestureEnded")), _ = null, Y || X || fa || T)
                    if (cb(), R || (R = Sb()), R.calculateSwipeSpeed("x"), T) {
                        var l = Ib();
                        if (l < i.verticalDragRange) f.close();
                        else {
                            var m = pa.y,
                                n = ja;
                            db("verticalDrag", 0, 1, 300, e.easing.cubic.out, function(a) {
                                pa.y = (f.currItem.initialPosition.y - m) * a + m, Fa((1 - n) * a + n), Ha()
                            }), Da("onVerticalDrag", 1)
                        }
                    } else {
                        if (($ || fa) && 0 === j) {
                            var o = Ub(g, R);
                            if (o) return;
                            g = "zoomPointerUp"
                        }
                        if (!fa) return "swipe" !== g ? void Wb() : void(!$ && s > f.currItem.fitRatio && Tb(R))
                    }
            },
            Sb = function() {
                var a, b, c = {
                    lastFlickOffset: {},
                    lastFlickDist: {},
                    lastFlickSpeed: {},
                    slowDownRatio: {},
                    slowDownRatioReverse: {},
                    speedDecelerationRatio: {},
                    speedDecelerationRatioAbs: {},
                    distanceOffset: {},
                    backAnimDestination: {},
                    backAnimStarted: {},
                    calculateSwipeSpeed: function(d) {
                        ob.length > 1 ? (a = Ea() - Q + 50, b = ob[ob.length - 2][d]) : (a = Ea() - P, b = lb[d]), c.lastFlickOffset[d] = kb[d] - b, c.lastFlickDist[d] = Math.abs(c.lastFlickOffset[d]), c.lastFlickDist[d] > 20 ? c.lastFlickSpeed[d] = c.lastFlickOffset[d] / a : c.lastFlickSpeed[d] = 0, Math.abs(c.lastFlickSpeed[d]) < .1 && (c.lastFlickSpeed[d] = 0), c.slowDownRatio[d] = .95, c.slowDownRatioReverse[d] = 1 - c.slowDownRatio[d], c.speedDecelerationRatio[d] = 1
                    },
                    calculateOverBoundsAnimOffset: function(a, b) {
                        c.backAnimStarted[a] || (pa[a] > da.min[a] ? c.backAnimDestination[a] = da.min[a] : pa[a] < da.max[a] && (c.backAnimDestination[a] = da.max[a]), void 0 !== c.backAnimDestination[a] && (c.slowDownRatio[a] = .7, c.slowDownRatioReverse[a] = 1 - c.slowDownRatio[a], c.speedDecelerationRatioAbs[a] < .05 && (c.lastFlickSpeed[a] = 0, c.backAnimStarted[a] = !0, db("bounceZoomPan" + a, pa[a], c.backAnimDestination[a], b || 300, e.easing.sine.out, function(b) {
                            pa[a] = b, Ha()
                        }))))
                    },
                    calculateAnimOffset: function(a) {
                        c.backAnimStarted[a] || (c.speedDecelerationRatio[a] = c.speedDecelerationRatio[a] * (c.slowDownRatio[a] + c.slowDownRatioReverse[a] - c.slowDownRatioReverse[a] * c.timeDiff / 10), c.speedDecelerationRatioAbs[a] = Math.abs(c.lastFlickSpeed[a] * c.speedDecelerationRatio[a]), c.distanceOffset[a] = c.lastFlickSpeed[a] * c.speedDecelerationRatio[a] * c.timeDiff, pa[a] += c.distanceOffset[a])
                    },
                    panAnimLoop: function() {
                        if ($a.zoomPan && ($a.zoomPan.raf = H(c.panAnimLoop), c.now = Ea(), c.timeDiff = c.now - c.lastNow, c.lastNow = c.now, c.calculateAnimOffset("x"), c.calculateAnimOffset("y"), Ha(), c.calculateOverBoundsAnimOffset("x"), c.calculateOverBoundsAnimOffset("y"), c.speedDecelerationRatioAbs.x < .05 && c.speedDecelerationRatioAbs.y < .05)) return pa.x = Math.round(pa.x), pa.y = Math.round(pa.y), Ha(), void ab("zoomPan")
                    }
                };
                return c
            },
            Tb = function(a) {
                return a.calculateSwipeSpeed("y"), da = f.currItem.bounds, a.backAnimDestination = {}, a.backAnimStarted = {}, Math.abs(a.lastFlickSpeed.x) <= .05 && Math.abs(a.lastFlickSpeed.y) <= .05 ? (a.speedDecelerationRatioAbs.x = a.speedDecelerationRatioAbs.y = 0, a.calculateOverBoundsAnimOffset("x"), a.calculateOverBoundsAnimOffset("y"), !0) : (bb("zoomPan"), a.lastNow = Ea(), void a.panAnimLoop())
            },
            Ub = function(a, b) {
                var c;
                fa || (qb = m);
                var d;
                if ("swipe" === a) {
                    var g = kb.x - lb.x,
                        h = b.lastFlickDist.x < 10;
                    g > fb && (h || b.lastFlickOffset.x > 20) ? d = -1 : g < -fb && (h || b.lastFlickOffset.x < -20) && (d = 1)
                }
                var j;
                d && (m += d, m < 0 ? (m = i.loop ? ac() - 1 : 0, j = !0) : m >= ac() && (m = i.loop ? 0 : ac() - 1, j = !0), j && !i.loop || (ua += d, ra -= d, c = !0));
                var k, l = ta.x * ra,
                    n = Math.abs(l - tb.x);
                return c || l > tb.x == b.lastFlickSpeed.x > 0 ? (k = Math.abs(b.lastFlickSpeed.x) > 0 ? n / Math.abs(b.lastFlickSpeed.x) : 333, k = Math.min(k, 400), k = Math.max(k, 250)) : k = 333, qb === m && (c = !1), fa = !0, Da("mainScrollAnimStart"), db("mainScroll", tb.x, l, k, e.easing.cubic.out, Ka, function() {
                    cb(), fa = !1, qb = -1, (c || qb !== m) && f.updateCurrItem(), Da("mainScrollAnimComplete")
                }), c && f.updateCurrItem(!0), c
            },
            Vb = function(a) {
                return 1 / ca * a * t
            },
            Wb = function() {
                var a = s,
                    b = Ta(),
                    c = Ua();
                s < b ? a = b : s > c && (a = c);
                var d, g = 1,
                    h = ja;
                return ia && !S && !ka && s < b ? (f.close(), !0) : (ia && (d = function(a) {
                    Fa((g - h) * a + h)
                }), f.zoomTo(a, 0, 200, e.easing.cubic.out, d), !0)
            };
        za("Gestures", {
            publicMethods: {
                initGestures: function() {
                    var a = function(a, b, c, d, e) {
                        A = a + b, B = a + c, C = a + d, D = e ? a + e : ""
                    };
                    F = N.pointerEvent, F && N.touch && (N.touch = !1), F ? navigator.msPointerEnabled ? a("MSPointer", "Down", "Move", "Up", "Cancel") : a("pointer", "down", "move", "up", "cancel") : N.touch ? (a("touch", "start", "move", "end", "cancel"), G = !0) : a("mouse", "down", "move", "up"), p = B + " " + C + " " + D, q = A, F && !G && (G = navigator.maxTouchPoints > 1 || navigator.msMaxTouchPoints > 1), f.likelyTouchDevice = G, r[A] = Ob, r[B] = Pb, r[C] = Rb, D && (r[D] = r[C]), N.touch && (q += " mousedown", p += " mousemove mouseup", r.mousedown = r[A], r.mousemove = r[B], r.mouseup = r[C]), G || (i.allowPanToNext = !1)
                }
            }
        });
        var Xb, Yb, Zb, $b, _b, ac, bc, cc = function(b, c, d, g) {
                Xb && clearTimeout(Xb), $b = !0, Zb = !0;
                var h;
                b.initialLayout ? (h = b.initialLayout, b.initialLayout = null) : h = i.getThumbBoundsFn && i.getThumbBoundsFn(m);
                var j = d ? i.hideAnimationDuration : i.showAnimationDuration,
                    k = function() {
                        ab("initialZoom"), d ? (f.template.removeAttribute("style"), f.bg.removeAttribute("style")) : (Fa(1), c && (c.style.display = "block"), e.addClass(a, "pswp--animated-in"), Da("initialZoom" + (d ? "OutEnd" : "InEnd"))), g && g(), $b = !1
                    };
                if (!j || !h || void 0 === h.x) return Da("initialZoom" + (d ? "Out" : "In")), s = b.initialZoomLevel, Ma(pa, b.initialPosition), Ha(), a.style.opacity = d ? 0 : 1, Fa(1), void(j ? setTimeout(function() {
                    k()
                }, j) : k());
                var n = function() {
                    var c = l,
                        g = !f.currItem.src || f.currItem.loadError || i.showHideOpacity;
                    b.miniImg && (b.miniImg.style.webkitBackfaceVisibility = "hidden"), d || (s = h.w / b.w, pa.x = h.x, pa.y = h.y - K, f[g ? "template" : "bg"].style.opacity = .001, Ha()), bb("initialZoom"), d && !c && e.removeClass(a, "pswp--animated-in"), g && (d ? e[(c ? "remove" : "add") + "Class"](a, "pswp--animate_opacity") : setTimeout(function() {
                        e.addClass(a, "pswp--animate_opacity")
                    }, 30)), Xb = setTimeout(function() {
                        if (Da("initialZoom" + (d ? "Out" : "In")), d) {
                            var f = h.w / b.w,
                                i = {
                                    x: pa.x,
                                    y: pa.y
                                },
                                l = s,
                                m = ja,
                                n = function(b) {
                                    1 === b ? (s = f, pa.x = h.x, pa.y = h.y - M) : (s = (f - l) * b + l, pa.x = (h.x - i.x) * b + i.x, pa.y = (h.y - M - i.y) * b + i.y), Ha(), g ? a.style.opacity = 1 - b : Fa(m - b * m)
                                };
                            c ? db("initialZoom", 0, 1, j, e.easing.cubic.out, n, k) : (n(1), Xb = setTimeout(k, j + 20))
                        } else s = b.initialZoomLevel, Ma(pa, b.initialPosition), Ha(), Fa(1), g ? a.style.opacity = 1 : Fa(1), Xb = setTimeout(k, j + 20)
                    }, d ? 25 : 90)
                };
                n()
            },
            dc = {},
            ec = [],
            fc = {
                index: 0,
                errorMsg: '<div class="pswp__error-msg"><a href="%url%" target="_blank">The image</a> could not be loaded.</div>',
                forceProgressiveLoading: !1,
                preload: [1, 1],
                getNumItemsFn: function() {
                    return Yb.length
                }
            },
            gc = function() {
                return {
                    center: {
                        x: 0,
                        y: 0
                    },
                    max: {
                        x: 0,
                        y: 0
                    },
                    min: {
                        x: 0,
                        y: 0
                    }
                }
            },
            hc = function(a, b, c) {
                var d = a.bounds;
                d.center.x = Math.round((dc.x - b) / 2), d.center.y = Math.round((dc.y - c) / 2) + a.vGap.top, d.max.x = b > dc.x ? Math.round(dc.x - b) : d.center.x, d.max.y = c > dc.y ? Math.round(dc.y - c) + a.vGap.top : d.center.y, d.min.x = b > dc.x ? 0 : d.center.x, d.min.y = c > dc.y ? a.vGap.top : d.center.y
            },
            ic = function(a, b, c) {
                if (a.src && !a.loadError) {
                    var d = !c;
                    if (d && (a.vGap || (a.vGap = {
                            top: 0,
                            bottom: 0
                        }), Da("parseVerticalMargin", a)), dc.x = b.x, dc.y = b.y - a.vGap.top - a.vGap.bottom, d) {
                        var e = dc.x / a.w,
                            f = dc.y / a.h;
                        a.fitRatio = e < f ? e : f;
                        var g = i.scaleMode;
                        "orig" === g ? c = 1 : "fit" === g && (c = a.fitRatio), c > 1 && (c = 1), a.initialZoomLevel = c, a.bounds || (a.bounds = gc())
                    }
                    if (!c) return;
                    return hc(a, a.w * c, a.h * c), d && c === a.initialZoomLevel && (a.initialPosition = a.bounds.center), a.bounds
                }
                return a.w = a.h = 0, a.initialZoomLevel = a.fitRatio = 1, a.bounds = gc(), a.initialPosition = a.bounds.center, a.bounds
            },
            jc = function(a, b, c, d, e, g) {
                b.loadError || d && (b.imageAppended = !0, mc(b, d, b === f.currItem && ya), c.appendChild(d), g && setTimeout(function() {
                    b && b.loaded && b.placeholder && (b.placeholder.style.display = "none", b.placeholder = null)
                }, 500))
            },
            kc = function(a) {
                a.loading = !0, a.loaded = !1;
                var b = a.img = e.createEl("pswp__img", "img"),
                    c = function() {
                        a.loading = !1, a.loaded = !0, a.loadComplete ? a.loadComplete(a) : a.img = null, b.onload = b.onerror = null, b = null
                    };
                return b.onload = c, b.onerror = function() {
                    a.loadError = !0, c()
                }, b.src = a.src, b
            },
            lc = function(a, b) {
                if (a.src && a.loadError && a.container) return b && (a.container.innerHTML = ""), a.container.innerHTML = i.errorMsg.replace("%url%", a.src), !0
            },
            mc = function(a, b, c) {
                if (a.src) {
                    b || (b = a.container.lastChild);
                    var d = c ? a.w : Math.round(a.w * a.fitRatio),
                        e = c ? a.h : Math.round(a.h * a.fitRatio);
                    a.placeholder && !a.loaded && (a.placeholder.style.width = d + "px", a.placeholder.style.height = e + "px"), b.style.width = d + "px", b.style.height = e + "px"
                }
            },
            nc = function() {
                if (ec.length) {
                    for (var a, b = 0; b < ec.length; b++) a = ec[b], a.holder.index === a.index && jc(a.index, a.item, a.baseDiv, a.img, !1, a.clearPlaceholder);
                    ec = []
                }
            };
        za("Controller", {
            publicMethods: {
                lazyLoadItem: function(a) {
                    a = Aa(a);
                    var b = _b(a);
                    b && (!b.loaded && !b.loading || x) && (Da("gettingData", a, b), b.src && kc(b))
                },
                initController: function() {
                    e.extend(i, fc, !0), f.items = Yb = c, _b = f.getItemAt, ac = i.getNumItemsFn, bc = i.loop, ac() < 3 && (i.loop = !1), Ca("beforeChange", function(a) {
                        var b, c = i.preload,
                            d = null === a || a >= 0,
                            e = Math.min(c[0], ac()),
                            g = Math.min(c[1], ac());
                        for (b = 1; b <= (d ? g : e); b++) f.lazyLoadItem(m + b);
                        for (b = 1; b <= (d ? e : g); b++) f.lazyLoadItem(m - b)
                    }), Ca("initialLayout", function() {
                        f.currItem.initialLayout = i.getThumbBoundsFn && i.getThumbBoundsFn(m)
                    }), Ca("mainScrollAnimComplete", nc), Ca("initialZoomInEnd", nc), Ca("destroy", function() {
                        for (var a, b = 0; b < Yb.length; b++) a = Yb[b], a.container && (a.container = null), a.placeholder && (a.placeholder = null), a.img && (a.img = null), a.preloader && (a.preloader = null), a.loadError && (a.loaded = a.loadError = !1);
                        ec = null
                    })
                },
                getItemAt: function(a) {
                    return a >= 0 && (void 0 !== Yb[a] && Yb[a])
                },
                allowProgressiveImg: function() {
                    return i.forceProgressiveLoading || !G || i.mouseUsed || screen.width > 1200
                },
                setContent: function(a, b) {
                    i.loop && (b = Aa(b));
                    var c = f.getItemAt(a.index);
                    c && (c.container = null);
                    var d, g = f.getItemAt(b);
                    if (!g) return void(a.el.innerHTML = "");
                    Da("gettingData", b, g), a.index = b, a.item = g;
                    var h = g.container = e.createEl("pswp__zoom-wrap");
                    if (!g.src && g.html && (g.html.tagName ? h.appendChild(g.html) : h.innerHTML = g.html), lc(g), ic(g, qa), !g.src || g.loadError || g.loaded) g.src && !g.loadError && (d = e.createEl("pswp__img", "img"), d.style.opacity = 1, d.src = g.src, mc(g, d), jc(b, g, h, d, !0));
                    else {
                        if (g.loadComplete = function(c) {
                                if (j) {
                                    if (a && a.index === b) {
                                        if (lc(c, !0)) return c.loadComplete = c.img = null, ic(c, qa), Ia(c), void(a.index === m && f.updateCurrZoomItem());
                                        c.imageAppended ? !$b && c.placeholder && (c.placeholder.style.display = "none", c.placeholder = null) : N.transform && (fa || $b) ? ec.push({
                                            item: c,
                                            baseDiv: h,
                                            img: c.img,
                                            index: b,
                                            holder: a,
                                            clearPlaceholder: !0
                                        }) : jc(b, c, h, c.img, fa || $b, !0)
                                    }
                                    c.loadComplete = null, c.img = null, Da("imageLoadComplete", b, c)
                                }
                            }, e.features.transform) {
                            var k = "pswp__img pswp__img--placeholder";
                            k += g.msrc ? "" : " pswp__img--placeholder--blank";
                            var l = e.createEl(k, g.msrc ? "img" : "");
                            g.msrc && (l.src = g.msrc), mc(g, l), h.appendChild(l), g.placeholder = l
                        }
                        g.loading || kc(g), f.allowProgressiveImg() && (!Zb && N.transform ? ec.push({
                            item: g,
                            baseDiv: h,
                            img: g.img,
                            index: b,
                            holder: a
                        }) : jc(b, g, h, g.img, !0, !0))
                    }
                    Zb || b !== m ? Ia(g) : (ea = h.style, cc(g, d || g.img)), a.el.innerHTML = "", a.el.appendChild(h)
                },
                cleanSlide: function(a) {
                    a.img && (a.img.onload = a.img.onerror = null), a.loaded = a.loading = a.img = a.imageAppended = !1
                }
            }
        });
        var oc, pc = {},
            qc = function(a, b, c) {
                var d = document.createEvent("CustomEvent"),
                    e = {
                        origEvent: a,
                        target: a.target,
                        releasePoint: b,
                        pointerType: c || "touch"
                    };
                d.initCustomEvent("pswpTap", !0, !0, e), a.target.dispatchEvent(d)
            };
        za("Tap", {
            publicMethods: {
                initTap: function() {
                    Ca("firstTouchStart", f.onTapStart), Ca("touchRelease", f.onTapRelease), Ca("destroy", function() {
                        pc = {}, oc = null
                    })
                },
                onTapStart: function(a) {
                    a.length > 1 && (clearTimeout(oc), oc = null)
                },
                onTapRelease: function(a, b) {
                    if (b && !Y && !W && !_a) {
                        var c = b;
                        if (oc && (clearTimeout(oc), oc = null, xb(c, pc))) return void Da("doubleTap", c);
                        if ("mouse" === b.type) return void qc(a, b, "mouse");
                        var d = a.target.tagName.toUpperCase();
                        if ("BUTTON" === d || e.hasClass(a.target, "pswp__single-tap")) return void qc(a, b);
                        Ma(pc, c), oc = setTimeout(function() {
                            qc(a, b), oc = null
                        }, 300)
                    }
                }
            }
        });
        var rc;
        za("DesktopZoom", {
            publicMethods: {
                initDesktopZoom: function() {
                    L || (G ? Ca("mouseUsed", function() {
                        f.setupDesktopZoom()
                    }) : f.setupDesktopZoom(!0))
                },
                setupDesktopZoom: function(b) {
                    rc = {};
                    var c = "wheel mousewheel DOMMouseScroll";
                    Ca("bindEvents", function() {
                        e.bind(a, c, f.handleMouseWheel)
                    }), Ca("unbindEvents", function() {
                        rc && e.unbind(a, c, f.handleMouseWheel)
                    }), f.mouseZoomedIn = !1;
                    var d, g = function() {
                            f.mouseZoomedIn && (e.removeClass(a, "pswp--zoomed-in"), f.mouseZoomedIn = !1), s < 1 ? e.addClass(a, "pswp--zoom-allowed") : e.removeClass(a, "pswp--zoom-allowed"), h()
                        },
                        h = function() {
                            d && (e.removeClass(a, "pswp--dragging"), d = !1)
                        };
                    Ca("resize", g), Ca("afterChange", g), Ca("pointerDown", function() {
                        f.mouseZoomedIn && (d = !0, e.addClass(a, "pswp--dragging"))
                    }), Ca("pointerUp", h), b || g()
                },
                handleMouseWheel: function(a) {
                    if (s <= f.currItem.fitRatio) return i.modal && (!i.closeOnScroll || _a || V ? a.preventDefault() : E && Math.abs(a.deltaY) > 2 && (l = !0, f.close())), !0;
                    if (a.stopPropagation(), rc.x = 0, "deltaX" in a) 1 === a.deltaMode ? (rc.x = 18 * a.deltaX, rc.y = 18 * a.deltaY) : (rc.x = a.deltaX, rc.y = a.deltaY);
                    else if ("wheelDelta" in a) a.wheelDeltaX && (rc.x = -.16 * a.wheelDeltaX), a.wheelDeltaY ? rc.y = -.16 * a.wheelDeltaY : rc.y = -.16 * a.wheelDelta;
                    else {
                        if (!("detail" in a)) return;
                        rc.y = a.detail
                    }
                    Sa(s, !0);
                    var b = pa.x - rc.x,
                        c = pa.y - rc.y;
                    (i.modal || b <= da.min.x && b >= da.max.x && c <= da.min.y && c >= da.max.y) && a.preventDefault(), f.panTo(b, c)
                },
                toggleDesktopZoom: function(b) {
                    b = b || {
                        x: qa.x / 2 + sa.x,
                        y: qa.y / 2 + sa.y
                    };
                    var c = i.getDoubleTapZoom(!0, f.currItem),
                        d = s === c;
                    f.mouseZoomedIn = !d, f.zoomTo(d ? f.currItem.initialZoomLevel : c, b, 333), e[(d ? "remove" : "add") + "Class"](a, "pswp--zoomed-in")
                }
            }
        });
        var sc, tc, uc, vc, wc, xc, yc, zc, Ac, Bc, Cc, Dc, Ec = {
                history: !0,
                galleryUID: 1
            },
            Fc = function() {
                return Cc.hash.substring(1)
            },
            Gc = function() {
                sc && clearTimeout(sc), uc && clearTimeout(uc)
            },
            Hc = function() {
                var a = Fc(),
                    b = {};
                if (a.length < 5) return b;
                var c, d = a.split("&");
                for (c = 0; c < d.length; c++)
                    if (d[c]) {
                        var e = d[c].split("=");
                        e.length < 2 || (b[e[0]] = e[1])
                    }
                if (i.galleryPIDs) {
                    var f = b.pid;
                    for (b.pid = 0, c = 0; c < Yb.length; c++)
                        if (Yb[c].pid === f) {
                            b.pid = c;
                            break
                        }
                } else b.pid = parseInt(b.pid, 10) - 1;
                return b.pid < 0 && (b.pid = 0), b
            },
            Ic = function() {
                if (uc && clearTimeout(uc), _a || V) return void(uc = setTimeout(Ic, 500));
                vc ? clearTimeout(tc) : vc = !0;
                var a = m + 1,
                    b = _b(m);
                b.hasOwnProperty("pid") && (a = b.pid);
                var c = yc + "&gid=" + i.galleryUID + "&pid=" + a;
                zc || Cc.hash.indexOf(c) === -1 && (Bc = !0);
                var d = Cc.href.split("#")[0] + "#" + c;
                Dc ? "#" + c !== window.location.hash && history[zc ? "replaceState" : "pushState"]("", document.title, d) : zc ? Cc.replace(d) : Cc.hash = c, zc = !0, tc = setTimeout(function() {
                    vc = !1
                }, 60)
            };
        za("History", {
            publicMethods: {
                initHistory: function() {
                    if (e.extend(i, Ec, !0), i.history) {
                        Cc = window.location, Bc = !1, Ac = !1, zc = !1, yc = Fc(), Dc = "pushState" in history, yc.indexOf("gid=") > -1 && (yc = yc.split("&gid=")[0], yc = yc.split("?gid=")[0]), Ca("afterChange", f.updateURL), Ca("unbindEvents", function() {
                            e.unbind(window, "hashchange", f.onHashChange)
                        });
                        var a = function() {
                            xc = !0, Ac || (Bc ? history.back() : yc ? Cc.hash = yc : Dc ? history.pushState("", document.title, Cc.pathname + Cc.search) : Cc.hash = ""), Gc()
                        };
                        Ca("unbindEvents", function() {
                            l && a()
                        }), Ca("destroy", function() {
                            xc || a()
                        }), Ca("firstUpdate", function() {
                            m = Hc().pid
                        });
                        var b = yc.indexOf("pid=");
                        b > -1 && (yc = yc.substring(0, b), "&" === yc.slice(-1) && (yc = yc.slice(0, -1))), setTimeout(function() {
                            j && e.bind(window, "hashchange", f.onHashChange)
                        }, 40)
                    }
                },
                onHashChange: function() {
                    return Fc() === yc ? (Ac = !0, void f.close()) : void(vc || (wc = !0, f.goTo(Hc().pid), wc = !1))
                },
                updateURL: function() {
                    Gc(), wc || (zc ? sc = setTimeout(Ic, 800) : Ic())
                }
            }
        }), e.extend(f, eb)
    };
    return a
});
/*! PhotoSwipe Default UI - 4.1.3 - 2019-01-08
 * http://photoswipe.com
 * Copyright (c) 2019 Dmitry Semenov; */
! function(a, b) {
    "function" == typeof define && define.amd ? define(b) : "object" == typeof exports ? module.exports = b() : a.PhotoSwipeUI_Default = b()
}(this, function() {
    "use strict";
    var a = function(a, b) {
        var c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v = this,
            w = !1,
            x = !0,
            y = !0,
            z = {
                barsSize: {
                    top: 44,
                    bottom: "auto"
                },
                closeElClasses: ["item", "caption", "zoom-wrap", "ui", "top-bar"],
                timeToIdle: 4e3,
                timeToIdleOutside: 1e3,
                loadingIndicatorDelay: 1e3,
                addCaptionHTMLFn: function(a, b) {
                    return a.title ? (b.children[0].innerHTML = a.title, !0) : (b.children[0].innerHTML = "", !1)
                },
                closeEl: !0,
                captionEl: !0,
                fullscreenEl: !0,
                zoomEl: !0,
                shareEl: !0,
                counterEl: !0,
                arrowEl: !0,
                preloaderEl: !0,
                tapToClose: !1,
                tapToToggleControls: !0,
                clickToCloseNonZoomable: !0,
                shareButtons: [{
                    id: "facebook",
                    label: "Share on Facebook",
                    url: "https://www.facebook.com/sharer/sharer.php?u={{url}}"
                }, {
                    id: "twitter",
                    label: "Tweet",
                    url: "https://twitter.com/intent/tweet?text={{text}}&url={{url}}"
                }, {
                    id: "pinterest",
                    label: "Pin it",
                    url: "http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}"
                }, {
                    id: "download",
                    label: "Download image",
                    url: "{{raw_image_url}}",
                    download: !0
                }],
                getImageURLForShare: function() {
                    return a.currItem.src || ""
                },
                getPageURLForShare: function() {
                    return window.location.href
                },
                getTextForShare: function() {
                    return a.currItem.title || ""
                },
                indexIndicatorSep: " / ",
                fitControlsWidth: 1200
            },
            A = function(a) {
                if (r) return !0;
                a = a || window.event, q.timeToIdle && q.mouseUsed && !k && K();
                for (var c, d, e = a.target || a.srcElement, f = e.getAttribute("class") || "", g = 0; g < S.length; g++) c = S[g], c.onTap && f.indexOf("pswp__" + c.name) > -1 && (c.onTap(), d = !0);
                if (d) {
                    a.stopPropagation && a.stopPropagation(), r = !0;
                    var h = b.features.isOldAndroid ? 600 : 30;
                    s = setTimeout(function() {
                        r = !1
                    }, h)
                }
            },
            B = function() {
                return !a.likelyTouchDevice || q.mouseUsed || screen.width > q.fitControlsWidth
            },
            C = function(a, c, d) {
                b[(d ? "add" : "remove") + "Class"](a, "pswp__" + c)
            },
            D = function() {
                var a = 1 === q.getNumItemsFn();
                a !== p && (C(d, "ui--one-slide", a), p = a)
            },
            E = function() {
                C(i, "share-modal--hidden", y)
            },
            F = function() {
                return y = !y, y ? (b.removeClass(i, "pswp__share-modal--fade-in"), setTimeout(function() {
                    y && E()
                }, 300)) : (E(), setTimeout(function() {
                    y || b.addClass(i, "pswp__share-modal--fade-in")
                }, 30)), y || H(), !1
            },
            G = function(b) {
                b = b || window.event;
                var c = b.target || b.srcElement;
                return a.shout("shareLinkClick", b, c), !!c.href && (!!c.hasAttribute("download") || (window.open(c.href, "pswp_share", "scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left=" + (window.screen ? Math.round(screen.width / 2 - 275) : 100)), y || F(), !1))
            },
            H = function() {
                for (var a, b, c, d, e, f = "", g = 0; g < q.shareButtons.length; g++) a = q.shareButtons[g], c = q.getImageURLForShare(a), d = q.getPageURLForShare(a), e = q.getTextForShare(a), b = a.url.replace("{{url}}", encodeURIComponent(d)).replace("{{image_url}}", encodeURIComponent(c)).replace("{{raw_image_url}}", c).replace("{{text}}", encodeURIComponent(e)), f += '<a href="' + b + '" target="_blank" class="pswp__share--' + a.id + '"' + (a.download ? "download" : "") + ">" + a.label + "</a>", q.parseShareButtonOut && (f = q.parseShareButtonOut(a, f));
                i.children[0].innerHTML = f, i.children[0].onclick = G
            },
            I = function(a) {
                for (var c = 0; c < q.closeElClasses.length; c++)
                    if (b.hasClass(a, "pswp__" + q.closeElClasses[c])) return !0
            },
            J = 0,
            K = function() {
                clearTimeout(u), J = 0, k && v.setIdle(!1)
            },
            L = function(a) {
                a = a ? a : window.event;
                var b = a.relatedTarget || a.toElement;
                b && "HTML" !== b.nodeName || (clearTimeout(u), u = setTimeout(function() {
                    v.setIdle(!0)
                }, q.timeToIdleOutside))
            },
            M = function() {
                q.fullscreenEl && !b.features.isOldAndroid && (c || (c = v.getFullscreenAPI()), c ? (b.bind(document, c.eventK, v.updateFullscreen), v.updateFullscreen(), b.addClass(a.template, "pswp--supports-fs")) : b.removeClass(a.template, "pswp--supports-fs"))
            },
            N = function() {
                q.preloaderEl && (O(!0), l("beforeChange", function() {
                    clearTimeout(o), o = setTimeout(function() {
                        a.currItem && a.currItem.loading ? (!a.allowProgressiveImg() || a.currItem.img && !a.currItem.img.naturalWidth) && O(!1) : O(!0)
                    }, q.loadingIndicatorDelay)
                }), l("imageLoadComplete", function(b, c) {
                    a.currItem === c && O(!0)
                }))
            },
            O = function(a) {
                n !== a && (C(m, "preloader--active", !a), n = a)
            },
            P = function(a) {
                var c = a.vGap;
                if (B()) {
                    var g = q.barsSize;
                    if (q.captionEl && "auto" === g.bottom)
                        if (f || (f = b.createEl("pswp__caption pswp__caption--fake"), f.appendChild(b.createEl("pswp__caption__center")), d.insertBefore(f, e), b.addClass(d, "pswp__ui--fit")), q.addCaptionHTMLFn(a, f, !0)) {
                            var h = f.clientHeight;
                            c.bottom = parseInt(h, 10) || 44
                        } else c.bottom = g.top;
                    else c.bottom = "auto" === g.bottom ? 0 : g.bottom;
                    c.top = g.top
                } else c.top = c.bottom = 0
            },
            Q = function() {
                q.timeToIdle && l("mouseUsed", function() {
                    b.bind(document, "mousemove", K), b.bind(document, "mouseout", L), t = setInterval(function() {
                        J++, 2 === J && v.setIdle(!0)
                    }, q.timeToIdle / 2)
                })
            },
            R = function() {
                l("onVerticalDrag", function(a) {
                    x && a < .95 ? v.hideControls() : !x && a >= .95 && v.showControls()
                });
                var a;
                l("onPinchClose", function(b) {
                    x && b < .9 ? (v.hideControls(), a = !0) : a && !x && b > .9 && v.showControls()
                }), l("zoomGestureEnded", function() {
                    a = !1, a && !x && v.showControls()
                })
            },
            S = [{
                name: "caption",
                option: "captionEl",
                onInit: function(a) {
                    e = a
                }
            }, {
                name: "share-modal",
                option: "shareEl",
                onInit: function(a) {
                    i = a
                },
                onTap: function() {
                    F()
                }
            }, {
                name: "button--share",
                option: "shareEl",
                onInit: function(a) {
                    h = a
                },
                onTap: function() {
                    F()
                }
            }, {
                name: "button--zoom",
                option: "zoomEl",
                onTap: a.toggleDesktopZoom
            }, {
                name: "counter",
                option: "counterEl",
                onInit: function(a) {
                    g = a
                }
            }, {
                name: "button--close",
                option: "closeEl",
                onTap: a.close
            }, {
                name: "button--arrow--left",
                option: "arrowEl",
                onTap: a.prev
            }, {
                name: "button--arrow--right",
                option: "arrowEl",
                onTap: a.next
            }, {
                name: "button--fs",
                option: "fullscreenEl",
                onTap: function() {
                    c.isFullscreen() ? c.exit() : c.enter()
                }
            }, {
                name: "preloader",
                option: "preloaderEl",
                onInit: function(a) {
                    m = a
                }
            }],
            T = function() {
                var a, c, e, f = function(d) {
                    if (d)
                        for (var f = d.length, g = 0; g < f; g++) {
                            a = d[g], c = a.className;
                            for (var h = 0; h < S.length; h++) e = S[h], c.indexOf("pswp__" + e.name) > -1 && (q[e.option] ? (b.removeClass(a, "pswp__element--disabled"), e.onInit && e.onInit(a)) : b.addClass(a, "pswp__element--disabled"))
                        }
                };
                f(d.children);
                var g = b.getChildByClass(d, "pswp__top-bar");
                g && f(g.children)
            };
        v.init = function() {
            b.extend(a.options, z, !0), q = a.options, d = b.getChildByClass(a.scrollWrap, "pswp__ui"), l = a.listen, R(), l("beforeChange", v.update), l("doubleTap", function(b) {
                var c = a.currItem.initialZoomLevel;
                a.getZoomLevel() !== c ? a.zoomTo(c, b, 333) : a.zoomTo(q.getDoubleTapZoom(!1, a.currItem), b, 333)
            }), l("preventDragEvent", function(a, b, c) {
                var d = a.target || a.srcElement;
                d && d.getAttribute("class") && a.type.indexOf("mouse") > -1 && (d.getAttribute("class").indexOf("__caption") > 0 || /(SMALL|STRONG|EM)/i.test(d.tagName)) && (c.prevent = !1)
            }), l("bindEvents", function() {
                b.bind(d, "pswpTap click", A), b.bind(a.scrollWrap, "pswpTap", v.onGlobalTap), a.likelyTouchDevice || b.bind(a.scrollWrap, "mouseover", v.onMouseOver)
            }), l("unbindEvents", function() {
                y || F(), t && clearInterval(t), b.unbind(document, "mouseout", L), b.unbind(document, "mousemove", K), b.unbind(d, "pswpTap click", A), b.unbind(a.scrollWrap, "pswpTap", v.onGlobalTap), b.unbind(a.scrollWrap, "mouseover", v.onMouseOver), c && (b.unbind(document, c.eventK, v.updateFullscreen), c.isFullscreen() && (q.hideAnimationDuration = 0, c.exit()), c = null)
            }), l("destroy", function() {
                q.captionEl && (f && d.removeChild(f), b.removeClass(e, "pswp__caption--empty")), i && (i.children[0].onclick = null), b.removeClass(d, "pswp__ui--over-close"), b.addClass(d, "pswp__ui--hidden"), v.setIdle(!1)
            }), q.showAnimationDuration || b.removeClass(d, "pswp__ui--hidden"), l("initialZoomIn", function() {
                q.showAnimationDuration && b.removeClass(d, "pswp__ui--hidden")
            }), l("initialZoomOut", function() {
                b.addClass(d, "pswp__ui--hidden")
            }), l("parseVerticalMargin", P), T(), q.shareEl && h && i && (y = !0), D(), Q(), M(), N()
        }, v.setIdle = function(a) {
            k = a, C(d, "ui--idle", a)
        }, v.update = function() {
            x && a.currItem ? (v.updateIndexIndicator(), q.captionEl && (q.addCaptionHTMLFn(a.currItem, e), C(e, "caption--empty", !a.currItem.title)), w = !0) : w = !1, y || F(), D()
        }, v.updateFullscreen = function(d) {
            d && setTimeout(function() {
                a.setScrollOffset(0, b.getScrollY())
            }, 50), b[(c.isFullscreen() ? "add" : "remove") + "Class"](a.template, "pswp--fs")
        }, v.updateIndexIndicator = function() {
            q.counterEl && (g.innerHTML = a.getCurrentIndex() + 1 + q.indexIndicatorSep + q.getNumItemsFn())
        }, v.onGlobalTap = function(c) {
            c = c || window.event;
            var d = c.target || c.srcElement;
            if (!r)
                if (c.detail && "mouse" === c.detail.pointerType) {
                    if (I(d)) return void a.close();
                    b.hasClass(d, "pswp__img") && (1 === a.getZoomLevel() && a.getZoomLevel() <= a.currItem.fitRatio ? q.clickToCloseNonZoomable && a.close() : a.toggleDesktopZoom(c.detail.releasePoint))
                } else if (q.tapToToggleControls && (x ? v.hideControls() : v.showControls()), q.tapToClose && (b.hasClass(d, "pswp__img") || I(d))) return void a.close()
        }, v.onMouseOver = function(a) {
            a = a || window.event;
            var b = a.target || a.srcElement;
            C(d, "ui--over-close", I(b))
        }, v.hideControls = function() {
            b.addClass(d, "pswp__ui--hidden"), x = !1
        }, v.showControls = function() {
            x = !0, w || v.update(), b.removeClass(d, "pswp__ui--hidden")
        }, v.supportsFullscreen = function() {
            var a = document;
            return !!(a.exitFullscreen || a.mozCancelFullScreen || a.webkitExitFullscreen || a.msExitFullscreen)
        }, v.getFullscreenAPI = function() {
            var b, c = document.documentElement,
                d = "fullscreenchange";
            return c.requestFullscreen ? b = {
                enterK: "requestFullscreen",
                exitK: "exitFullscreen",
                elementK: "fullscreenElement",
                eventK: d
            } : c.mozRequestFullScreen ? b = {
                enterK: "mozRequestFullScreen",
                exitK: "mozCancelFullScreen",
                elementK: "mozFullScreenElement",
                eventK: "moz" + d
            } : c.webkitRequestFullscreen ? b = {
                enterK: "webkitRequestFullscreen",
                exitK: "webkitExitFullscreen",
                elementK: "webkitFullscreenElement",
                eventK: "webkit" + d
            } : c.msRequestFullscreen && (b = {
                enterK: "msRequestFullscreen",
                exitK: "msExitFullscreen",
                elementK: "msFullscreenElement",
                eventK: "MSFullscreenChange"
            }), b && (b.enter = function() {
                return j = q.closeOnScroll, q.closeOnScroll = !1, "webkitRequestFullscreen" !== this.enterK ? a.template[this.enterK]() : void a.template[this.enterK](Element.ALLOW_KEYBOARD_INPUT)
            }, b.exit = function() {
                return q.closeOnScroll = j, document[this.exitK]()
            }, b.isFullscreen = function() {
                return document[this.elementK]
            }), b
        }
    };
    return a
});
/*! Select2 4.0.12 | https://github.com/select2/select2/blob/master/LICENSE.md */ ! function(n) {
    "function" == typeof define && define.amd ? define(["jquery"], n) : "object" == typeof module && module.exports ? module.exports = function(e, t) {
        return void 0 === t && (t = "undefined" != typeof window ? require("jquery") : require("jquery")(e)), n(t), t
    } : n(jQuery)
}(function(u) {
    var e = function() {
            if (u && u.fn && u.fn.select2 && u.fn.select2.amd) var e = u.fn.select2.amd;
            var t, n, r, h, o, s, f, g, m, v, y, _, i, a, w;

            function b(e, t) {
                return i.call(e, t)
            }

            function l(e, t) {
                var n, r, i, o, s, a, l, c, u, d, p, h = t && t.split("/"),
                    f = y.map,
                    g = f && f["*"] || {};
                if (e) {
                    for (s = (e = e.split("/")).length - 1, y.nodeIdCompat && w.test(e[s]) && (e[s] = e[s].replace(w, "")), "." === e[0].charAt(0) && h && (e = h.slice(0, h.length - 1).concat(e)), u = 0; u < e.length; u++)
                        if ("." === (p = e[u])) e.splice(u, 1), u -= 1;
                        else if (".." === p) {
                        if (0 === u || 1 === u && ".." === e[2] || ".." === e[u - 1]) continue;
                        0 < u && (e.splice(u - 1, 2), u -= 2)
                    }
                    e = e.join("/")
                }
                if ((h || g) && f) {
                    for (u = (n = e.split("/")).length; 0 < u; u -= 1) {
                        if (r = n.slice(0, u).join("/"), h)
                            for (d = h.length; 0 < d; d -= 1)
                                if (i = (i = f[h.slice(0, d).join("/")]) && i[r]) {
                                    o = i, a = u;
                                    break
                                }
                        if (o) break;
                        !l && g && g[r] && (l = g[r], c = u)
                    }!o && l && (o = l, a = c), o && (n.splice(0, a, o), e = n.join("/"))
                }
                return e
            }

            function A(t, n) {
                return function() {
                    var e = a.call(arguments, 0);
                    return "string" != typeof e[0] && 1 === e.length && e.push(null), s.apply(h, e.concat([t, n]))
                }
            }

            function x(t) {
                return function(e) {
                    m[t] = e
                }
            }

            function D(e) {
                if (b(v, e)) {
                    var t = v[e];
                    delete v[e], _[e] = !0, o.apply(h, t)
                }
                if (!b(m, e) && !b(_, e)) throw new Error("No " + e);
                return m[e]
            }

            function c(e) {
                var t, n = e ? e.indexOf("!") : -1;
                return -1 < n && (t = e.substring(0, n), e = e.substring(n + 1, e.length)), [t, e]
            }

            function S(e) {
                return e ? c(e) : []
            }
            return e && e.requirejs || (e ? n = e : e = {}, m = {}, v = {}, y = {}, _ = {}, i = Object.prototype.hasOwnProperty, a = [].slice, w = /\.js$/, f = function(e, t) {
                var n, r = c(e),
                    i = r[0],
                    o = t[1];
                return e = r[1], i && (n = D(i = l(i, o))), i ? e = n && n.normalize ? n.normalize(e, function(t) {
                    return function(e) {
                        return l(e, t)
                    }
                }(o)) : l(e, o) : (i = (r = c(e = l(e, o)))[0], e = r[1], i && (n = D(i))), {
                    f: i ? i + "!" + e : e,
                    n: e,
                    pr: i,
                    p: n
                }
            }, g = {
                require: function(e) {
                    return A(e)
                },
                exports: function(e) {
                    var t = m[e];
                    return void 0 !== t ? t : m[e] = {}
                },
                module: function(e) {
                    return {
                        id: e,
                        uri: "",
                        exports: m[e],
                        config: function(e) {
                            return function() {
                                return y && y.config && y.config[e] || {}
                            }
                        }(e)
                    }
                }
            }, o = function(e, t, n, r) {
                var i, o, s, a, l, c, u, d = [],
                    p = typeof n;
                if (c = S(r = r || e), "undefined" == p || "function" == p) {
                    for (t = !t.length && n.length ? ["require", "exports", "module"] : t, l = 0; l < t.length; l += 1)
                        if ("require" === (o = (a = f(t[l], c)).f)) d[l] = g.require(e);
                        else if ("exports" === o) d[l] = g.exports(e), u = !0;
                    else if ("module" === o) i = d[l] = g.module(e);
                    else if (b(m, o) || b(v, o) || b(_, o)) d[l] = D(o);
                    else {
                        if (!a.p) throw new Error(e + " missing " + o);
                        a.p.load(a.n, A(r, !0), x(o), {}), d[l] = m[o]
                    }
                    s = n ? n.apply(m[e], d) : void 0, e && (i && i.exports !== h && i.exports !== m[e] ? m[e] = i.exports : s === h && u || (m[e] = s))
                } else e && (m[e] = n)
            }, t = n = s = function(e, t, n, r, i) {
                if ("string" == typeof e) return g[e] ? g[e](t) : D(f(e, S(t)).f);
                if (!e.splice) {
                    if ((y = e).deps && s(y.deps, y.callback), !t) return;
                    t.splice ? (e = t, t = n, n = null) : e = h
                }
                return t = t || function() {}, "function" == typeof n && (n = r, r = i), r ? o(h, e, t, n) : setTimeout(function() {
                    o(h, e, t, n)
                }, 4), s
            }, s.config = function(e) {
                return s(e)
            }, t._defined = m, (r = function(e, t, n) {
                if ("string" != typeof e) throw new Error("See almond README: incorrect module build, no module name");
                t.splice || (n = t, t = []), b(m, e) || b(v, e) || (v[e] = [e, t, n])
            }).amd = {
                jQuery: !0
            }, e.requirejs = t, e.require = n, e.define = r), e.define("almond", function() {}), e.define("jquery", [], function() {
                var e = u || $;
                return null == e && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), e
            }), e.define("select2/utils", ["jquery"], function(o) {
                var i = {};

                function u(e) {
                    var t = e.prototype,
                        n = [];
                    for (var r in t) {
                        "function" == typeof t[r] && "constructor" !== r && n.push(r)
                    }
                    return n
                }
                i.Extend = function(e, t) {
                    var n = {}.hasOwnProperty;

                    function r() {
                        this.constructor = e
                    }
                    for (var i in t) n.call(t, i) && (e[i] = t[i]);
                    return r.prototype = t.prototype, e.prototype = new r, e.__super__ = t.prototype, e
                }, i.Decorate = function(r, i) {
                    var e = u(i),
                        t = u(r);

                    function o() {
                        var e = Array.prototype.unshift,
                            t = i.prototype.constructor.length,
                            n = r.prototype.constructor;
                        0 < t && (e.call(arguments, r.prototype.constructor), n = i.prototype.constructor), n.apply(this, arguments)
                    }
                    i.displayName = r.displayName, o.prototype = new function() {
                        this.constructor = o
                    };
                    for (var n = 0; n < t.length; n++) {
                        var s = t[n];
                        o.prototype[s] = r.prototype[s]
                    }

                    function a(e) {
                        var t = function() {};
                        e in o.prototype && (t = o.prototype[e]);
                        var n = i.prototype[e];
                        return function() {
                            return Array.prototype.unshift.call(arguments, t), n.apply(this, arguments)
                        }
                    }
                    for (var l = 0; l < e.length; l++) {
                        var c = e[l];
                        o.prototype[c] = a(c)
                    }
                    return o
                };

                function e() {
                    this.listeners = {}
                }
                e.prototype.on = function(e, t) {
                    this.listeners = this.listeners || {}, e in this.listeners ? this.listeners[e].push(t) : this.listeners[e] = [t]
                }, e.prototype.trigger = function(e) {
                    var t = Array.prototype.slice,
                        n = t.call(arguments, 1);
                    this.listeners = this.listeners || {}, null == n && (n = []), 0 === n.length && n.push({}), (n[0]._type = e) in this.listeners && this.invoke(this.listeners[e], t.call(arguments, 1)), "*" in this.listeners && this.invoke(this.listeners["*"], arguments)
                }, e.prototype.invoke = function(e, t) {
                    for (var n = 0, r = e.length; n < r; n++) e[n].apply(this, t)
                }, i.Observable = e, i.generateChars = function(e) {
                    for (var t = "", n = 0; n < e; n++) {
                        t += Math.floor(36 * Math.random()).toString(36)
                    }
                    return t
                }, i.bind = function(e, t) {
                    return function() {
                        e.apply(t, arguments)
                    }
                }, i._convertData = function(e) {
                    for (var t in e) {
                        var n = t.split("-"),
                            r = e;
                        if (1 !== n.length) {
                            for (var i = 0; i < n.length; i++) {
                                var o = n[i];
                                (o = o.substring(0, 1).toLowerCase() + o.substring(1)) in r || (r[o] = {}), i == n.length - 1 && (r[o] = e[t]), r = r[o]
                            }
                            delete e[t]
                        }
                    }
                    return e
                }, i.hasScroll = function(e, t) {
                    var n = o(t),
                        r = t.style.overflowX,
                        i = t.style.overflowY;
                    return (r !== i || "hidden" !== i && "visible" !== i) && ("scroll" === r || "scroll" === i || (n.innerHeight() < t.scrollHeight || n.innerWidth() < t.scrollWidth))
                }, i.escapeMarkup = function(e) {
                    var t = {
                        "\\": "&#92;",
                        "&": "&amp;",
                        "<": "&lt;",
                        ">": "&gt;",
                        '"': "&quot;",
                        "'": "&#39;",
                        "/": "&#47;"
                    };
                    return "string" != typeof e ? e : String(e).replace(/[&<>"'\/\\]/g, function(e) {
                        return t[e]
                    })
                }, i.appendMany = function(e, t) {
                    if ("1.7" === o.fn.jquery.substr(0, 3)) {
                        var n = o();
                        o.map(t, function(e) {
                            n = n.add(e)
                        }), t = n
                    }
                    e.append(t)
                }, i.__cache = {};
                var n = 0;
                return i.GetUniqueElementId = function(e) {
                    var t = e.getAttribute("data-select2-id");
                    return null == t && (e.id ? (t = e.id, e.setAttribute("data-select2-id", t)) : (e.setAttribute("data-select2-id", ++n), t = n.toString())), t
                }, i.StoreData = function(e, t, n) {
                    var r = i.GetUniqueElementId(e);
                    i.__cache[r] || (i.__cache[r] = {}), i.__cache[r][t] = n
                }, i.GetData = function(e, t) {
                    var n = i.GetUniqueElementId(e);
                    return t ? i.__cache[n] && null != i.__cache[n][t] ? i.__cache[n][t] : o(e).data(t) : i.__cache[n]
                }, i.RemoveData = function(e) {
                    var t = i.GetUniqueElementId(e);
                    null != i.__cache[t] && delete i.__cache[t], e.removeAttribute("data-select2-id")
                }, i
            }), e.define("select2/results", ["jquery", "./utils"], function(h, f) {
                function r(e, t, n) {
                    this.$element = e, this.data = n, this.options = t, r.__super__.constructor.call(this)
                }
                return f.Extend(r, f.Observable), r.prototype.render = function() {
                    var e = h('<ul class="select2-results__options" role="listbox"></ul>');
                    return this.options.get("multiple") && e.attr("aria-multiselectable", "true"), this.$results = e
                }, r.prototype.clear = function() {
                    this.$results.empty()
                }, r.prototype.displayMessage = function(e) {
                    var t = this.options.get("escapeMarkup");
                    this.clear(), this.hideLoading();
                    var n = h('<li role="alert" aria-live="assertive" class="select2-results__option"></li>'),
                        r = this.options.get("translations").get(e.message);
                    n.append(t(r(e.args))), n[0].className += " select2-results__message", this.$results.append(n)
                }, r.prototype.hideMessages = function() {
                    this.$results.find(".select2-results__message").remove()
                }, r.prototype.append = function(e) {
                    this.hideLoading();
                    var t = [];
                    if (null != e.results && 0 !== e.results.length) {
                        e.results = this.sort(e.results);
                        for (var n = 0; n < e.results.length; n++) {
                            var r = e.results[n],
                                i = this.option(r);
                            t.push(i)
                        }
                        this.$results.append(t)
                    } else 0 === this.$results.children().length && this.trigger("results:message", {
                        message: "noResults"
                    })
                }, r.prototype.position = function(e, t) {
                    t.find(".select2-results").append(e)
                }, r.prototype.sort = function(e) {
                    return this.options.get("sorter")(e)
                }, r.prototype.highlightFirstItem = function() {
                    var e = this.$results.find(".select2-results__option[aria-selected]"),
                        t = e.filter("[aria-selected=true]");
                    0 < t.length ? t.first().trigger("mouseenter") : e.first().trigger("mouseenter"), this.ensureHighlightVisible()
                }, r.prototype.setClasses = function() {
                    var t = this;
                    this.data.current(function(e) {
                        var r = h.map(e, function(e) {
                            return e.id.toString()
                        });
                        t.$results.find(".select2-results__option[aria-selected]").each(function() {
                            var e = h(this),
                                t = f.GetData(this, "data"),
                                n = "" + t.id;
                            null != t.element && t.element.selected || null == t.element && -1 < h.inArray(n, r) ? e.attr("aria-selected", "true") : e.attr("aria-selected", "false")
                        })
                    })
                }, r.prototype.showLoading = function(e) {
                    this.hideLoading();
                    var t = {
                            disabled: !0,
                            loading: !0,
                            text: this.options.get("translations").get("searching")(e)
                        },
                        n = this.option(t);
                    n.className += " loading-results", this.$results.prepend(n)
                }, r.prototype.hideLoading = function() {
                    this.$results.find(".loading-results").remove()
                }, r.prototype.option = function(e) {
                    var t = document.createElement("li");
                    t.className = "select2-results__option";
                    var n = {
                            role: "option",
                            "aria-selected": "false"
                        },
                        r = window.Element.prototype.matches || window.Element.prototype.msMatchesSelector || window.Element.prototype.webkitMatchesSelector;
                    for (var i in (null != e.element && r.call(e.element, ":disabled") || null == e.element && e.disabled) && (delete n["aria-selected"], n["aria-disabled"] = "true"), null == e.id && delete n["aria-selected"], null != e._resultId && (t.id = e._resultId), e.title && (t.title = e.title), e.children && (n.role = "group", n["aria-label"] = e.text, delete n["aria-selected"]), n) {
                        var o = n[i];
                        t.setAttribute(i, o)
                    }
                    if (e.children) {
                        var s = h(t),
                            a = document.createElement("strong");
                        a.className = "select2-results__group";
                        h(a);
                        this.template(e, a);
                        for (var l = [], c = 0; c < e.children.length; c++) {
                            var u = e.children[c],
                                d = this.option(u);
                            l.push(d)
                        }
                        var p = h("<ul></ul>", {
                            class: "select2-results__options select2-results__options--nested"
                        });
                        p.append(l), s.append(a), s.append(p)
                    } else this.template(e, t);
                    return f.StoreData(t, "data", e), t
                }, r.prototype.bind = function(t, e) {
                    var l = this,
                        n = t.id + "-results";
                    this.$results.attr("id", n), t.on("results:all", function(e) {
                        l.clear(), l.append(e.data), t.isOpen() && (l.setClasses(), l.highlightFirstItem())
                    }), t.on("results:append", function(e) {
                        l.append(e.data), t.isOpen() && l.setClasses()
                    }), t.on("query", function(e) {
                        l.hideMessages(), l.showLoading(e)
                    }), t.on("select", function() {
                        t.isOpen() && (l.setClasses(), l.options.get("scrollAfterSelect") && l.highlightFirstItem())
                    }), t.on("unselect", function() {
                        t.isOpen() && (l.setClasses(), l.options.get("scrollAfterSelect") && l.highlightFirstItem())
                    }), t.on("open", function() {
                        l.$results.attr("aria-expanded", "true"), l.$results.attr("aria-hidden", "false"), l.setClasses(), l.ensureHighlightVisible()
                    }), t.on("close", function() {
                        l.$results.attr("aria-expanded", "false"), l.$results.attr("aria-hidden", "true"), l.$results.removeAttr("aria-activedescendant")
                    }), t.on("results:toggle", function() {
                        var e = l.getHighlightedResults();
                        0 !== e.length && e.trigger("mouseup")
                    }), t.on("results:select", function() {
                        var e = l.getHighlightedResults();
                        if (0 !== e.length) {
                            var t = f.GetData(e[0], "data");
                            "true" == e.attr("aria-selected") ? l.trigger("close", {}) : l.trigger("select", {
                                data: t
                            })
                        }
                    }), t.on("results:previous", function() {
                        var e = l.getHighlightedResults(),
                            t = l.$results.find("[aria-selected]"),
                            n = t.index(e);
                        if (!(n <= 0)) {
                            var r = n - 1;
                            0 === e.length && (r = 0);
                            var i = t.eq(r);
                            i.trigger("mouseenter");
                            var o = l.$results.offset().top,
                                s = i.offset().top,
                                a = l.$results.scrollTop() + (s - o);
                            0 === r ? l.$results.scrollTop(0) : s - o < 0 && l.$results.scrollTop(a)
                        }
                    }), t.on("results:next", function() {
                        var e = l.getHighlightedResults(),
                            t = l.$results.find("[aria-selected]"),
                            n = t.index(e) + 1;
                        if (!(n >= t.length)) {
                            var r = t.eq(n);
                            r.trigger("mouseenter");
                            var i = l.$results.offset().top + l.$results.outerHeight(!1),
                                o = r.offset().top + r.outerHeight(!1),
                                s = l.$results.scrollTop() + o - i;
                            0 === n ? l.$results.scrollTop(0) : i < o && l.$results.scrollTop(s)
                        }
                    }), t.on("results:focus", function(e) {
                        e.element.addClass("select2-results__option--highlighted")
                    }), t.on("results:message", function(e) {
                        l.displayMessage(e)
                    }), h.fn.mousewheel && this.$results.on("mousewheel", function(e) {
                        var t = l.$results.scrollTop(),
                            n = l.$results.get(0).scrollHeight - t + e.deltaY,
                            r = 0 < e.deltaY && t - e.deltaY <= 0,
                            i = e.deltaY < 0 && n <= l.$results.height();
                        r ? (l.$results.scrollTop(0), e.preventDefault(), e.stopPropagation()) : i && (l.$results.scrollTop(l.$results.get(0).scrollHeight - l.$results.height()), e.preventDefault(), e.stopPropagation())
                    }), this.$results.on("mouseup", ".select2-results__option[aria-selected]", function(e) {
                        var t = h(this),
                            n = f.GetData(this, "data");
                        "true" !== t.attr("aria-selected") ? l.trigger("select", {
                            originalEvent: e,
                            data: n
                        }) : l.options.get("multiple") ? l.trigger("unselect", {
                            originalEvent: e,
                            data: n
                        }) : l.trigger("close", {})
                    }), this.$results.on("mouseenter", ".select2-results__option[aria-selected]", function(e) {
                        var t = f.GetData(this, "data");
                        l.getHighlightedResults().removeClass("select2-results__option--highlighted"), l.trigger("results:focus", {
                            data: t,
                            element: h(this)
                        })
                    })
                }, r.prototype.getHighlightedResults = function() {
                    return this.$results.find(".select2-results__option--highlighted")
                }, r.prototype.destroy = function() {
                    this.$results.remove()
                }, r.prototype.ensureHighlightVisible = function() {
                    var e = this.getHighlightedResults();
                    if (0 !== e.length) {
                        var t = this.$results.find("[aria-selected]").index(e),
                            n = this.$results.offset().top,
                            r = e.offset().top,
                            i = this.$results.scrollTop() + (r - n),
                            o = r - n;
                        i -= 2 * e.outerHeight(!1), t <= 2 ? this.$results.scrollTop(0) : (o > this.$results.outerHeight() || o < 0) && this.$results.scrollTop(i)
                    }
                }, r.prototype.template = function(e, t) {
                    var n = this.options.get("templateResult"),
                        r = this.options.get("escapeMarkup"),
                        i = n(e, t);
                    null == i ? t.style.display = "none" : "string" == typeof i ? t.innerHTML = r(i) : h(t).append(i)
                }, r
            }), e.define("select2/keys", [], function() {
                return {
                    BACKSPACE: 8,
                    TAB: 9,
                    ENTER: 13,
                    SHIFT: 16,
                    CTRL: 17,
                    ALT: 18,
                    ESC: 27,
                    SPACE: 32,
                    PAGE_UP: 33,
                    PAGE_DOWN: 34,
                    END: 35,
                    HOME: 36,
                    LEFT: 37,
                    UP: 38,
                    RIGHT: 39,
                    DOWN: 40,
                    DELETE: 46
                }
            }), e.define("select2/selection/base", ["jquery", "../utils", "../keys"], function(n, r, i) {
                function o(e, t) {
                    this.$element = e, this.options = t, o.__super__.constructor.call(this)
                }
                return r.Extend(o, r.Observable), o.prototype.render = function() {
                    var e = n('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');
                    return this._tabindex = 0, null != r.GetData(this.$element[0], "old-tabindex") ? this._tabindex = r.GetData(this.$element[0], "old-tabindex") : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")), e.attr("title", this.$element.attr("title")), e.attr("tabindex", this._tabindex), e.attr("aria-disabled", "false"), this.$selection = e
                }, o.prototype.bind = function(e, t) {
                    var n = this,
                        r = e.id + "-results";
                    this.container = e, this.$selection.on("focus", function(e) {
                        n.trigger("focus", e)
                    }), this.$selection.on("blur", function(e) {
                        n._handleBlur(e)
                    }), this.$selection.on("keydown", function(e) {
                        n.trigger("keypress", e), e.which === i.SPACE && e.preventDefault()
                    }), e.on("results:focus", function(e) {
                        n.$selection.attr("aria-activedescendant", e.data._resultId)
                    }), e.on("selection:update", function(e) {
                        n.update(e.data)
                    }), e.on("open", function() {
                        n.$selection.attr("aria-expanded", "true"), n.$selection.attr("aria-owns", r), n._attachCloseHandler(e)
                    }), e.on("close", function() {
                        n.$selection.attr("aria-expanded", "false"), n.$selection.removeAttr("aria-activedescendant"), n.$selection.removeAttr("aria-owns"), n.$selection.trigger("focus"), n._detachCloseHandler(e)
                    }), e.on("enable", function() {
                        n.$selection.attr("tabindex", n._tabindex), n.$selection.attr("aria-disabled", "false")
                    }), e.on("disable", function() {
                        n.$selection.attr("tabindex", "-1"), n.$selection.attr("aria-disabled", "true")
                    })
                }, o.prototype._handleBlur = function(e) {
                    var t = this;
                    window.setTimeout(function() {
                        document.activeElement == t.$selection[0] || n.contains(t.$selection[0], document.activeElement) || t.trigger("blur", e)
                    }, 1)
                }, o.prototype._attachCloseHandler = function(e) {
                    n(document.body).on("mousedown.select2." + e.id, function(e) {
                        var t = n(e.target).closest(".select2");
                        n(".select2.select2-container--open").each(function() {
                            this != t[0] && r.GetData(this, "element").select2("close")
                        })
                    })
                }, o.prototype._detachCloseHandler = function(e) {
                    n(document.body).off("mousedown.select2." + e.id)
                }, o.prototype.position = function(e, t) {
                    t.find(".selection").append(e)
                }, o.prototype.destroy = function() {
                    this._detachCloseHandler(this.container)
                }, o.prototype.update = function(e) {
                    throw new Error("The `update` method must be defined in child classes.")
                }, o
            }), e.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], function(e, t, n, r) {
                function i() {
                    i.__super__.constructor.apply(this, arguments)
                }
                return n.Extend(i, t), i.prototype.render = function() {
                    var e = i.__super__.render.call(this);
                    return e.addClass("select2-selection--single"), e.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), e
                }, i.prototype.bind = function(t, e) {
                    var n = this;
                    i.__super__.bind.apply(this, arguments);
                    var r = t.id + "-container";
                    this.$selection.find(".select2-selection__rendered").attr("id", r).attr("role", "textbox").attr("aria-readonly", "true"), this.$selection.attr("aria-labelledby", r), this.$selection.on("mousedown", function(e) {
                        1 === e.which && n.trigger("toggle", {
                            originalEvent: e
                        })
                    }), this.$selection.on("focus", function(e) {}), this.$selection.on("blur", function(e) {}), t.on("focus", function(e) {
                        t.isOpen() || n.$selection.trigger("focus")
                    })
                }, i.prototype.clear = function() {
                    var e = this.$selection.find(".select2-selection__rendered");
                    e.empty(), e.removeAttr("title")
                }, i.prototype.display = function(e, t) {
                    var n = this.options.get("templateSelection");
                    return this.options.get("escapeMarkup")(n(e, t))
                }, i.prototype.selectionContainer = function() {
                    return e("<span></span>")
                }, i.prototype.update = function(e) {
                    if (0 !== e.length) {
                        var t = e[0],
                            n = this.$selection.find(".select2-selection__rendered"),
                            r = this.display(t, n);
                        n.empty().append(r);
                        var i = t.title || t.text;
                        i ? n.attr("title", i) : n.removeAttr("title")
                    } else this.clear()
                }, i
            }), e.define("select2/selection/multiple", ["jquery", "./base", "../utils"], function(i, e, l) {
                function n(e, t) {
                    n.__super__.constructor.apply(this, arguments)
                }
                return l.Extend(n, e), n.prototype.render = function() {
                    var e = n.__super__.render.call(this);
                    return e.addClass("select2-selection--multiple"), e.html('<ul class="select2-selection__rendered"></ul>'), e
                }, n.prototype.bind = function(e, t) {
                    var r = this;
                    n.__super__.bind.apply(this, arguments), this.$selection.on("click", function(e) {
                        r.trigger("toggle", {
                            originalEvent: e
                        })
                    }), this.$selection.on("click", ".select2-selection__choice__remove", function(e) {
                        if (!r.options.get("disabled")) {
                            var t = i(this).parent(),
                                n = l.GetData(t[0], "data");
                            r.trigger("unselect", {
                                originalEvent: e,
                                data: n
                            })
                        }
                    })
                }, n.prototype.clear = function() {
                    var e = this.$selection.find(".select2-selection__rendered");
                    e.empty(), e.removeAttr("title")
                }, n.prototype.display = function(e, t) {
                    var n = this.options.get("templateSelection");
                    return this.options.get("escapeMarkup")(n(e, t))
                }, n.prototype.selectionContainer = function() {
                    return i('<li class="select2-selection__choice"><span class="select2-selection__choice__remove" role="presentation">&times;</span></li>')
                }, n.prototype.update = function(e) {
                    if (this.clear(), 0 !== e.length) {
                        for (var t = [], n = 0; n < e.length; n++) {
                            var r = e[n],
                                i = this.selectionContainer(),
                                o = this.display(r, i);
                            i.append(o);
                            var s = r.title || r.text;
                            s && i.attr("title", s), l.StoreData(i[0], "data", r), t.push(i)
                        }
                        var a = this.$selection.find(".select2-selection__rendered");
                        l.appendMany(a, t)
                    }
                }, n
            }), e.define("select2/selection/placeholder", ["../utils"], function(e) {
                function t(e, t, n) {
                    this.placeholder = this.normalizePlaceholder(n.get("placeholder")), e.call(this, t, n)
                }
                return t.prototype.normalizePlaceholder = function(e, t) {
                    return "string" == typeof t && (t = {
                        id: "",
                        text: t
                    }), t
                }, t.prototype.createPlaceholder = function(e, t) {
                    var n = this.selectionContainer();
                    return n.html(this.display(t)), n.addClass("select2-selection__placeholder").removeClass("select2-selection__choice"), n
                }, t.prototype.update = function(e, t) {
                    var n = 1 == t.length && t[0].id != this.placeholder.id;
                    if (1 < t.length || n) return e.call(this, t);
                    this.clear();
                    var r = this.createPlaceholder(this.placeholder);
                    this.$selection.find(".select2-selection__rendered").append(r)
                }, t
            }), e.define("select2/selection/allowClear", ["jquery", "../keys", "../utils"], function(i, r, a) {
                function e() {}
                return e.prototype.bind = function(e, t, n) {
                    var r = this;
                    e.call(this, t, n), null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."), this.$selection.on("mousedown", ".select2-selection__clear", function(e) {
                        r._handleClear(e)
                    }), t.on("keypress", function(e) {
                        r._handleKeyboardClear(e, t)
                    })
                }, e.prototype._handleClear = function(e, t) {
                    if (!this.options.get("disabled")) {
                        var n = this.$selection.find(".select2-selection__clear");
                        if (0 !== n.length) {
                            t.stopPropagation();
                            var r = a.GetData(n[0], "data"),
                                i = this.$element.val();
                            this.$element.val(this.placeholder.id);
                            var o = {
                                data: r
                            };
                            if (this.trigger("clear", o), o.prevented) this.$element.val(i);
                            else {
                                for (var s = 0; s < r.length; s++)
                                    if (o = {
                                            data: r[s]
                                        }, this.trigger("unselect", o), o.prevented) return void this.$element.val(i);
                                this.$element.trigger("change"), this.trigger("toggle", {})
                            }
                        }
                    }
                }, e.prototype._handleKeyboardClear = function(e, t, n) {
                    n.isOpen() || t.which != r.DELETE && t.which != r.BACKSPACE || this._handleClear(t)
                }, e.prototype.update = function(e, t) {
                    if (e.call(this, t), !(0 < this.$selection.find(".select2-selection__placeholder").length || 0 === t.length)) {
                        var n = this.options.get("translations").get("removeAllItems"),
                            r = i('<span class="select2-selection__clear" title="' + n() + '">&times;</span>');
                        a.StoreData(r[0], "data", t), this.$selection.find(".select2-selection__rendered").prepend(r)
                    }
                }, e
            }), e.define("select2/selection/search", ["jquery", "../utils", "../keys"], function(r, a, l) {
                function e(e, t, n) {
                    e.call(this, t, n)
                }
                return e.prototype.render = function(e) {
                    var t = r('<li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></li>');
                    this.$searchContainer = t, this.$search = t.find("input");
                    var n = e.call(this);
                    return this._transferTabIndex(), n
                }, e.prototype.bind = function(e, t, n) {
                    var r = this,
                        i = t.id + "-results";
                    e.call(this, t, n), t.on("open", function() {
                        r.$search.attr("aria-controls", i), r.$search.trigger("focus")
                    }), t.on("close", function() {
                        r.$search.val(""), r.$search.removeAttr("aria-controls"), r.$search.removeAttr("aria-activedescendant"), r.$search.trigger("focus")
                    }), t.on("enable", function() {
                        r.$search.prop("disabled", !1), r._transferTabIndex()
                    }), t.on("disable", function() {
                        r.$search.prop("disabled", !0)
                    }), t.on("focus", function(e) {
                        r.$search.trigger("focus")
                    }), t.on("results:focus", function(e) {
                        e.data._resultId ? r.$search.attr("aria-activedescendant", e.data._resultId) : r.$search.removeAttr("aria-activedescendant")
                    }), this.$selection.on("focusin", ".select2-search--inline", function(e) {
                        r.trigger("focus", e)
                    }), this.$selection.on("focusout", ".select2-search--inline", function(e) {
                        r._handleBlur(e)
                    }), this.$selection.on("keydown", ".select2-search--inline", function(e) {
                        if (e.stopPropagation(), r.trigger("keypress", e), r._keyUpPrevented = e.isDefaultPrevented(), e.which === l.BACKSPACE && "" === r.$search.val()) {
                            var t = r.$searchContainer.prev(".select2-selection__choice");
                            if (0 < t.length) {
                                var n = a.GetData(t[0], "data");
                                r.searchRemoveChoice(n), e.preventDefault()
                            }
                        }
                    }), this.$selection.on("click", ".select2-search--inline", function(e) {
                        r.$search.val() && e.stopPropagation()
                    });
                    var o = document.documentMode,
                        s = o && o <= 11;
                    this.$selection.on("input.searchcheck", ".select2-search--inline", function(e) {
                        s ? r.$selection.off("input.search input.searchcheck") : r.$selection.off("keyup.search")
                    }), this.$selection.on("keyup.search input.search", ".select2-search--inline", function(e) {
                        if (s && "input" === e.type) r.$selection.off("input.search input.searchcheck");
                        else {
                            var t = e.which;
                            t != l.SHIFT && t != l.CTRL && t != l.ALT && t != l.TAB && r.handleSearch(e)
                        }
                    })
                }, e.prototype._transferTabIndex = function(e) {
                    this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1")
                }, e.prototype.createPlaceholder = function(e, t) {
                    this.$search.attr("placeholder", t.text)
                }, e.prototype.update = function(e, t) {
                    var n = this.$search[0] == document.activeElement;
                    this.$search.attr("placeholder", ""), e.call(this, t), this.$selection.find(".select2-selection__rendered").append(this.$searchContainer), this.resizeSearch(), n && this.$search.trigger("focus")
                }, e.prototype.handleSearch = function() {
                    if (this.resizeSearch(), !this._keyUpPrevented) {
                        var e = this.$search.val();
                        this.trigger("query", {
                            term: e
                        })
                    }
                    this._keyUpPrevented = !1
                }, e.prototype.searchRemoveChoice = function(e, t) {
                    this.trigger("unselect", {
                        data: t
                    }), this.$search.val(t.text), this.handleSearch()
                }, e.prototype.resizeSearch = function() {
                    this.$search.css("width", "25px");
                    var e = "";
                    "" !== this.$search.attr("placeholder") ? e = this.$selection.find(".select2-selection__rendered").width() : e = .75 * (this.$search.val().length + 1) + "em";
                    this.$search.css("width", e)
                }, e
            }), e.define("select2/selection/eventRelay", ["jquery"], function(s) {
                function e() {}
                return e.prototype.bind = function(e, t, n) {
                    var r = this,
                        i = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting", "clear", "clearing"],
                        o = ["opening", "closing", "selecting", "unselecting", "clearing"];
                    e.call(this, t, n), t.on("*", function(e, t) {
                        if (-1 !== s.inArray(e, i)) {
                            t = t || {};
                            var n = s.Event("select2:" + e, {
                                params: t
                            });
                            r.$element.trigger(n), -1 !== s.inArray(e, o) && (t.prevented = n.isDefaultPrevented())
                        }
                    })
                }, e
            }), e.define("select2/translation", ["jquery", "require"], function(t, n) {
                function r(e) {
                    this.dict = e || {}
                }
                return r.prototype.all = function() {
                    return this.dict
                }, r.prototype.get = function(e) {
                    return this.dict[e]
                }, r.prototype.extend = function(e) {
                    this.dict = t.extend({}, e.all(), this.dict)
                }, r._cache = {}, r.loadPath = function(e) {
                    if (!(e in r._cache)) {
                        var t = n(e);
                        r._cache[e] = t
                    }
                    return new r(r._cache[e])
                }, r
            }), e.define("select2/diacritics", [], function() {
                return {
                    "Ⓐ": "A",
                    "Ａ": "A",
                    "À": "A",
                    "Á": "A",
                    "Â": "A",
                    "Ầ": "A",
                    "Ấ": "A",
                    "Ẫ": "A",
                    "Ẩ": "A",
                    "Ã": "A",
                    "Ā": "A",
                    "Ă": "A",
                    "Ằ": "A",
                    "Ắ": "A",
                    "Ẵ": "A",
                    "Ẳ": "A",
                    "Ȧ": "A",
                    "Ǡ": "A",
                    "Ä": "A",
                    "Ǟ": "A",
                    "Ả": "A",
                    "Å": "A",
                    "Ǻ": "A",
                    "Ǎ": "A",
                    "Ȁ": "A",
                    "Ȃ": "A",
                    "Ạ": "A",
                    "Ậ": "A",
                    "Ặ": "A",
                    "Ḁ": "A",
                    "Ą": "A",
                    "Ⱥ": "A",
                    "Ɐ": "A",
                    "Ꜳ": "AA",
                    "Æ": "AE",
                    "Ǽ": "AE",
                    "Ǣ": "AE",
                    "Ꜵ": "AO",
                    "Ꜷ": "AU",
                    "Ꜹ": "AV",
                    "Ꜻ": "AV",
                    "Ꜽ": "AY",
                    "Ⓑ": "B",
                    "Ｂ": "B",
                    "Ḃ": "B",
                    "Ḅ": "B",
                    "Ḇ": "B",
                    "Ƀ": "B",
                    "Ƃ": "B",
                    "Ɓ": "B",
                    "Ⓒ": "C",
                    "Ｃ": "C",
                    "Ć": "C",
                    "Ĉ": "C",
                    "Ċ": "C",
                    "Č": "C",
                    "Ç": "C",
                    "Ḉ": "C",
                    "Ƈ": "C",
                    "Ȼ": "C",
                    "Ꜿ": "C",
                    "Ⓓ": "D",
                    "Ｄ": "D",
                    "Ḋ": "D",
                    "Ď": "D",
                    "Ḍ": "D",
                    "Ḑ": "D",
                    "Ḓ": "D",
                    "Ḏ": "D",
                    "Đ": "D",
                    "Ƌ": "D",
                    "Ɗ": "D",
                    "Ɖ": "D",
                    "Ꝺ": "D",
                    "Ǳ": "DZ",
                    "Ǆ": "DZ",
                    "ǲ": "Dz",
                    "ǅ": "Dz",
                    "Ⓔ": "E",
                    "Ｅ": "E",
                    "È": "E",
                    "É": "E",
                    "Ê": "E",
                    "Ề": "E",
                    "Ế": "E",
                    "Ễ": "E",
                    "Ể": "E",
                    "Ẽ": "E",
                    "Ē": "E",
                    "Ḕ": "E",
                    "Ḗ": "E",
                    "Ĕ": "E",
                    "Ė": "E",
                    "Ë": "E",
                    "Ẻ": "E",
                    "Ě": "E",
                    "Ȅ": "E",
                    "Ȇ": "E",
                    "Ẹ": "E",
                    "Ệ": "E",
                    "Ȩ": "E",
                    "Ḝ": "E",
                    "Ę": "E",
                    "Ḙ": "E",
                    "Ḛ": "E",
                    "Ɛ": "E",
                    "Ǝ": "E",
                    "Ⓕ": "F",
                    "Ｆ": "F",
                    "Ḟ": "F",
                    "Ƒ": "F",
                    "Ꝼ": "F",
                    "Ⓖ": "G",
                    "Ｇ": "G",
                    "Ǵ": "G",
                    "Ĝ": "G",
                    "Ḡ": "G",
                    "Ğ": "G",
                    "Ġ": "G",
                    "Ǧ": "G",
                    "Ģ": "G",
                    "Ǥ": "G",
                    "Ɠ": "G",
                    "Ꞡ": "G",
                    "Ᵹ": "G",
                    "Ꝿ": "G",
                    "Ⓗ": "H",
                    "Ｈ": "H",
                    "Ĥ": "H",
                    "Ḣ": "H",
                    "Ḧ": "H",
                    "Ȟ": "H",
                    "Ḥ": "H",
                    "Ḩ": "H",
                    "Ḫ": "H",
                    "Ħ": "H",
                    "Ⱨ": "H",
                    "Ⱶ": "H",
                    "Ɥ": "H",
                    "Ⓘ": "I",
                    "Ｉ": "I",
                    "Ì": "I",
                    "Í": "I",
                    "Î": "I",
                    "Ĩ": "I",
                    "Ī": "I",
                    "Ĭ": "I",
                    "İ": "I",
                    "Ï": "I",
                    "Ḯ": "I",
                    "Ỉ": "I",
                    "Ǐ": "I",
                    "Ȉ": "I",
                    "Ȋ": "I",
                    "Ị": "I",
                    "Į": "I",
                    "Ḭ": "I",
                    "Ɨ": "I",
                    "Ⓙ": "J",
                    "Ｊ": "J",
                    "Ĵ": "J",
                    "Ɉ": "J",
                    "Ⓚ": "K",
                    "Ｋ": "K",
                    "Ḱ": "K",
                    "Ǩ": "K",
                    "Ḳ": "K",
                    "Ķ": "K",
                    "Ḵ": "K",
                    "Ƙ": "K",
                    "Ⱪ": "K",
                    "Ꝁ": "K",
                    "Ꝃ": "K",
                    "Ꝅ": "K",
                    "Ꞣ": "K",
                    "Ⓛ": "L",
                    "Ｌ": "L",
                    "Ŀ": "L",
                    "Ĺ": "L",
                    "Ľ": "L",
                    "Ḷ": "L",
                    "Ḹ": "L",
                    "Ļ": "L",
                    "Ḽ": "L",
                    "Ḻ": "L",
                    "Ł": "L",
                    "Ƚ": "L",
                    "Ɫ": "L",
                    "Ⱡ": "L",
                    "Ꝉ": "L",
                    "Ꝇ": "L",
                    "Ꞁ": "L",
                    "Ǉ": "LJ",
                    "ǈ": "Lj",
                    "Ⓜ": "M",
                    "Ｍ": "M",
                    "Ḿ": "M",
                    "Ṁ": "M",
                    "Ṃ": "M",
                    "Ɱ": "M",
                    "Ɯ": "M",
                    "Ⓝ": "N",
                    "Ｎ": "N",
                    "Ǹ": "N",
                    "Ń": "N",
                    "Ñ": "N",
                    "Ṅ": "N",
                    "Ň": "N",
                    "Ṇ": "N",
                    "Ņ": "N",
                    "Ṋ": "N",
                    "Ṉ": "N",
                    "Ƞ": "N",
                    "Ɲ": "N",
                    "Ꞑ": "N",
                    "Ꞥ": "N",
                    "Ǌ": "NJ",
                    "ǋ": "Nj",
                    "Ⓞ": "O",
                    "Ｏ": "O",
                    "Ò": "O",
                    "Ó": "O",
                    "Ô": "O",
                    "Ồ": "O",
                    "Ố": "O",
                    "Ỗ": "O",
                    "Ổ": "O",
                    "Õ": "O",
                    "Ṍ": "O",
                    "Ȭ": "O",
                    "Ṏ": "O",
                    "Ō": "O",
                    "Ṑ": "O",
                    "Ṓ": "O",
                    "Ŏ": "O",
                    "Ȯ": "O",
                    "Ȱ": "O",
                    "Ö": "O",
                    "Ȫ": "O",
                    "Ỏ": "O",
                    "Ő": "O",
                    "Ǒ": "O",
                    "Ȍ": "O",
                    "Ȏ": "O",
                    "Ơ": "O",
                    "Ờ": "O",
                    "Ớ": "O",
                    "Ỡ": "O",
                    "Ở": "O",
                    "Ợ": "O",
                    "Ọ": "O",
                    "Ộ": "O",
                    "Ǫ": "O",
                    "Ǭ": "O",
                    "Ø": "O",
                    "Ǿ": "O",
                    "Ɔ": "O",
                    "Ɵ": "O",
                    "Ꝋ": "O",
                    "Ꝍ": "O",
                    "Œ": "OE",
                    "Ƣ": "OI",
                    "Ꝏ": "OO",
                    "Ȣ": "OU",
                    "Ⓟ": "P",
                    "Ｐ": "P",
                    "Ṕ": "P",
                    "Ṗ": "P",
                    "Ƥ": "P",
                    "Ᵽ": "P",
                    "Ꝑ": "P",
                    "Ꝓ": "P",
                    "Ꝕ": "P",
                    "Ⓠ": "Q",
                    "Ｑ": "Q",
                    "Ꝗ": "Q",
                    "Ꝙ": "Q",
                    "Ɋ": "Q",
                    "Ⓡ": "R",
                    "Ｒ": "R",
                    "Ŕ": "R",
                    "Ṙ": "R",
                    "Ř": "R",
                    "Ȑ": "R",
                    "Ȓ": "R",
                    "Ṛ": "R",
                    "Ṝ": "R",
                    "Ŗ": "R",
                    "Ṟ": "R",
                    "Ɍ": "R",
                    "Ɽ": "R",
                    "Ꝛ": "R",
                    "Ꞧ": "R",
                    "Ꞃ": "R",
                    "Ⓢ": "S",
                    "Ｓ": "S",
                    "ẞ": "S",
                    "Ś": "S",
                    "Ṥ": "S",
                    "Ŝ": "S",
                    "Ṡ": "S",
                    "Š": "S",
                    "Ṧ": "S",
                    "Ṣ": "S",
                    "Ṩ": "S",
                    "Ș": "S",
                    "Ş": "S",
                    "Ȿ": "S",
                    "Ꞩ": "S",
                    "Ꞅ": "S",
                    "Ⓣ": "T",
                    "Ｔ": "T",
                    "Ṫ": "T",
                    "Ť": "T",
                    "Ṭ": "T",
                    "Ț": "T",
                    "Ţ": "T",
                    "Ṱ": "T",
                    "Ṯ": "T",
                    "Ŧ": "T",
                    "Ƭ": "T",
                    "Ʈ": "T",
                    "Ⱦ": "T",
                    "Ꞇ": "T",
                    "Ꜩ": "TZ",
                    "Ⓤ": "U",
                    "Ｕ": "U",
                    "Ù": "U",
                    "Ú": "U",
                    "Û": "U",
                    "Ũ": "U",
                    "Ṹ": "U",
                    "Ū": "U",
                    "Ṻ": "U",
                    "Ŭ": "U",
                    "Ü": "U",
                    "Ǜ": "U",
                    "Ǘ": "U",
                    "Ǖ": "U",
                    "Ǚ": "U",
                    "Ủ": "U",
                    "Ů": "U",
                    "Ű": "U",
                    "Ǔ": "U",
                    "Ȕ": "U",
                    "Ȗ": "U",
                    "Ư": "U",
                    "Ừ": "U",
                    "Ứ": "U",
                    "Ữ": "U",
                    "Ử": "U",
                    "Ự": "U",
                    "Ụ": "U",
                    "Ṳ": "U",
                    "Ų": "U",
                    "Ṷ": "U",
                    "Ṵ": "U",
                    "Ʉ": "U",
                    "Ⓥ": "V",
                    "Ｖ": "V",
                    "Ṽ": "V",
                    "Ṿ": "V",
                    "Ʋ": "V",
                    "Ꝟ": "V",
                    "Ʌ": "V",
                    "Ꝡ": "VY",
                    "Ⓦ": "W",
                    "Ｗ": "W",
                    "Ẁ": "W",
                    "Ẃ": "W",
                    "Ŵ": "W",
                    "Ẇ": "W",
                    "Ẅ": "W",
                    "Ẉ": "W",
                    "Ⱳ": "W",
                    "Ⓧ": "X",
                    "Ｘ": "X",
                    "Ẋ": "X",
                    "Ẍ": "X",
                    "Ⓨ": "Y",
                    "Ｙ": "Y",
                    "Ỳ": "Y",
                    "Ý": "Y",
                    "Ŷ": "Y",
                    "Ỹ": "Y",
                    "Ȳ": "Y",
                    "Ẏ": "Y",
                    "Ÿ": "Y",
                    "Ỷ": "Y",
                    "Ỵ": "Y",
                    "Ƴ": "Y",
                    "Ɏ": "Y",
                    "Ỿ": "Y",
                    "Ⓩ": "Z",
                    "Ｚ": "Z",
                    "Ź": "Z",
                    "Ẑ": "Z",
                    "Ż": "Z",
                    "Ž": "Z",
                    "Ẓ": "Z",
                    "Ẕ": "Z",
                    "Ƶ": "Z",
                    "Ȥ": "Z",
                    "Ɀ": "Z",
                    "Ⱬ": "Z",
                    "Ꝣ": "Z",
                    "ⓐ": "a",
                    "ａ": "a",
                    "ẚ": "a",
                    "à": "a",
                    "á": "a",
                    "â": "a",
                    "ầ": "a",
                    "ấ": "a",
                    "ẫ": "a",
                    "ẩ": "a",
                    "ã": "a",
                    "ā": "a",
                    "ă": "a",
                    "ằ": "a",
                    "ắ": "a",
                    "ẵ": "a",
                    "ẳ": "a",
                    "ȧ": "a",
                    "ǡ": "a",
                    "ä": "a",
                    "ǟ": "a",
                    "ả": "a",
                    "å": "a",
                    "ǻ": "a",
                    "ǎ": "a",
                    "ȁ": "a",
                    "ȃ": "a",
                    "ạ": "a",
                    "ậ": "a",
                    "ặ": "a",
                    "ḁ": "a",
                    "ą": "a",
                    "ⱥ": "a",
                    "ɐ": "a",
                    "ꜳ": "aa",
                    "æ": "ae",
                    "ǽ": "ae",
                    "ǣ": "ae",
                    "ꜵ": "ao",
                    "ꜷ": "au",
                    "ꜹ": "av",
                    "ꜻ": "av",
                    "ꜽ": "ay",
                    "ⓑ": "b",
                    "ｂ": "b",
                    "ḃ": "b",
                    "ḅ": "b",
                    "ḇ": "b",
                    "ƀ": "b",
                    "ƃ": "b",
                    "ɓ": "b",
                    "ⓒ": "c",
                    "ｃ": "c",
                    "ć": "c",
                    "ĉ": "c",
                    "ċ": "c",
                    "č": "c",
                    "ç": "c",
                    "ḉ": "c",
                    "ƈ": "c",
                    "ȼ": "c",
                    "ꜿ": "c",
                    "ↄ": "c",
                    "ⓓ": "d",
                    "ｄ": "d",
                    "ḋ": "d",
                    "ď": "d",
                    "ḍ": "d",
                    "ḑ": "d",
                    "ḓ": "d",
                    "ḏ": "d",
                    "đ": "d",
                    "ƌ": "d",
                    "ɖ": "d",
                    "ɗ": "d",
                    "ꝺ": "d",
                    "ǳ": "dz",
                    "ǆ": "dz",
                    "ⓔ": "e",
                    "ｅ": "e",
                    "è": "e",
                    "é": "e",
                    "ê": "e",
                    "ề": "e",
                    "ế": "e",
                    "ễ": "e",
                    "ể": "e",
                    "ẽ": "e",
                    "ē": "e",
                    "ḕ": "e",
                    "ḗ": "e",
                    "ĕ": "e",
                    "ė": "e",
                    "ë": "e",
                    "ẻ": "e",
                    "ě": "e",
                    "ȅ": "e",
                    "ȇ": "e",
                    "ẹ": "e",
                    "ệ": "e",
                    "ȩ": "e",
                    "ḝ": "e",
                    "ę": "e",
                    "ḙ": "e",
                    "ḛ": "e",
                    "ɇ": "e",
                    "ɛ": "e",
                    "ǝ": "e",
                    "ⓕ": "f",
                    "ｆ": "f",
                    "ḟ": "f",
                    "ƒ": "f",
                    "ꝼ": "f",
                    "ⓖ": "g",
                    "ｇ": "g",
                    "ǵ": "g",
                    "ĝ": "g",
                    "ḡ": "g",
                    "ğ": "g",
                    "ġ": "g",
                    "ǧ": "g",
                    "ģ": "g",
                    "ǥ": "g",
                    "ɠ": "g",
                    "ꞡ": "g",
                    "ᵹ": "g",
                    "ꝿ": "g",
                    "ⓗ": "h",
                    "ｈ": "h",
                    "ĥ": "h",
                    "ḣ": "h",
                    "ḧ": "h",
                    "ȟ": "h",
                    "ḥ": "h",
                    "ḩ": "h",
                    "ḫ": "h",
                    "ẖ": "h",
                    "ħ": "h",
                    "ⱨ": "h",
                    "ⱶ": "h",
                    "ɥ": "h",
                    "ƕ": "hv",
                    "ⓘ": "i",
                    "ｉ": "i",
                    "ì": "i",
                    "í": "i",
                    "î": "i",
                    "ĩ": "i",
                    "ī": "i",
                    "ĭ": "i",
                    "ï": "i",
                    "ḯ": "i",
                    "ỉ": "i",
                    "ǐ": "i",
                    "ȉ": "i",
                    "ȋ": "i",
                    "ị": "i",
                    "į": "i",
                    "ḭ": "i",
                    "ɨ": "i",
                    "ı": "i",
                    "ⓙ": "j",
                    "ｊ": "j",
                    "ĵ": "j",
                    "ǰ": "j",
                    "ɉ": "j",
                    "ⓚ": "k",
                    "ｋ": "k",
                    "ḱ": "k",
                    "ǩ": "k",
                    "ḳ": "k",
                    "ķ": "k",
                    "ḵ": "k",
                    "ƙ": "k",
                    "ⱪ": "k",
                    "ꝁ": "k",
                    "ꝃ": "k",
                    "ꝅ": "k",
                    "ꞣ": "k",
                    "ⓛ": "l",
                    "ｌ": "l",
                    "ŀ": "l",
                    "ĺ": "l",
                    "ľ": "l",
                    "ḷ": "l",
                    "ḹ": "l",
                    "ļ": "l",
                    "ḽ": "l",
                    "ḻ": "l",
                    "ſ": "l",
                    "ł": "l",
                    "ƚ": "l",
                    "ɫ": "l",
                    "ⱡ": "l",
                    "ꝉ": "l",
                    "ꞁ": "l",
                    "ꝇ": "l",
                    "ǉ": "lj",
                    "ⓜ": "m",
                    "ｍ": "m",
                    "ḿ": "m",
                    "ṁ": "m",
                    "ṃ": "m",
                    "ɱ": "m",
                    "ɯ": "m",
                    "ⓝ": "n",
                    "ｎ": "n",
                    "ǹ": "n",
                    "ń": "n",
                    "ñ": "n",
                    "ṅ": "n",
                    "ň": "n",
                    "ṇ": "n",
                    "ņ": "n",
                    "ṋ": "n",
                    "ṉ": "n",
                    "ƞ": "n",
                    "ɲ": "n",
                    "ŉ": "n",
                    "ꞑ": "n",
                    "ꞥ": "n",
                    "ǌ": "nj",
                    "ⓞ": "o",
                    "ｏ": "o",
                    "ò": "o",
                    "ó": "o",
                    "ô": "o",
                    "ồ": "o",
                    "ố": "o",
                    "ỗ": "o",
                    "ổ": "o",
                    "õ": "o",
                    "ṍ": "o",
                    "ȭ": "o",
                    "ṏ": "o",
                    "ō": "o",
                    "ṑ": "o",
                    "ṓ": "o",
                    "ŏ": "o",
                    "ȯ": "o",
                    "ȱ": "o",
                    "ö": "o",
                    "ȫ": "o",
                    "ỏ": "o",
                    "ő": "o",
                    "ǒ": "o",
                    "ȍ": "o",
                    "ȏ": "o",
                    "ơ": "o",
                    "ờ": "o",
                    "ớ": "o",
                    "ỡ": "o",
                    "ở": "o",
                    "ợ": "o",
                    "ọ": "o",
                    "ộ": "o",
                    "ǫ": "o",
                    "ǭ": "o",
                    "ø": "o",
                    "ǿ": "o",
                    "ɔ": "o",
                    "ꝋ": "o",
                    "ꝍ": "o",
                    "ɵ": "o",
                    "œ": "oe",
                    "ƣ": "oi",
                    "ȣ": "ou",
                    "ꝏ": "oo",
                    "ⓟ": "p",
                    "ｐ": "p",
                    "ṕ": "p",
                    "ṗ": "p",
                    "ƥ": "p",
                    "ᵽ": "p",
                    "ꝑ": "p",
                    "ꝓ": "p",
                    "ꝕ": "p",
                    "ⓠ": "q",
                    "ｑ": "q",
                    "ɋ": "q",
                    "ꝗ": "q",
                    "ꝙ": "q",
                    "ⓡ": "r",
                    "ｒ": "r",
                    "ŕ": "r",
                    "ṙ": "r",
                    "ř": "r",
                    "ȑ": "r",
                    "ȓ": "r",
                    "ṛ": "r",
                    "ṝ": "r",
                    "ŗ": "r",
                    "ṟ": "r",
                    "ɍ": "r",
                    "ɽ": "r",
                    "ꝛ": "r",
                    "ꞧ": "r",
                    "ꞃ": "r",
                    "ⓢ": "s",
                    "ｓ": "s",
                    "ß": "s",
                    "ś": "s",
                    "ṥ": "s",
                    "ŝ": "s",
                    "ṡ": "s",
                    "š": "s",
                    "ṧ": "s",
                    "ṣ": "s",
                    "ṩ": "s",
                    "ș": "s",
                    "ş": "s",
                    "ȿ": "s",
                    "ꞩ": "s",
                    "ꞅ": "s",
                    "ẛ": "s",
                    "ⓣ": "t",
                    "ｔ": "t",
                    "ṫ": "t",
                    "ẗ": "t",
                    "ť": "t",
                    "ṭ": "t",
                    "ț": "t",
                    "ţ": "t",
                    "ṱ": "t",
                    "ṯ": "t",
                    "ŧ": "t",
                    "ƭ": "t",
                    "ʈ": "t",
                    "ⱦ": "t",
                    "ꞇ": "t",
                    "ꜩ": "tz",
                    "ⓤ": "u",
                    "ｕ": "u",
                    "ù": "u",
                    "ú": "u",
                    "û": "u",
                    "ũ": "u",
                    "ṹ": "u",
                    "ū": "u",
                    "ṻ": "u",
                    "ŭ": "u",
                    "ü": "u",
                    "ǜ": "u",
                    "ǘ": "u",
                    "ǖ": "u",
                    "ǚ": "u",
                    "ủ": "u",
                    "ů": "u",
                    "ű": "u",
                    "ǔ": "u",
                    "ȕ": "u",
                    "ȗ": "u",
                    "ư": "u",
                    "ừ": "u",
                    "ứ": "u",
                    "ữ": "u",
                    "ử": "u",
                    "ự": "u",
                    "ụ": "u",
                    "ṳ": "u",
                    "ų": "u",
                    "ṷ": "u",
                    "ṵ": "u",
                    "ʉ": "u",
                    "ⓥ": "v",
                    "ｖ": "v",
                    "ṽ": "v",
                    "ṿ": "v",
                    "ʋ": "v",
                    "ꝟ": "v",
                    "ʌ": "v",
                    "ꝡ": "vy",
                    "ⓦ": "w",
                    "ｗ": "w",
                    "ẁ": "w",
                    "ẃ": "w",
                    "ŵ": "w",
                    "ẇ": "w",
                    "ẅ": "w",
                    "ẘ": "w",
                    "ẉ": "w",
                    "ⱳ": "w",
                    "ⓧ": "x",
                    "ｘ": "x",
                    "ẋ": "x",
                    "ẍ": "x",
                    "ⓨ": "y",
                    "ｙ": "y",
                    "ỳ": "y",
                    "ý": "y",
                    "ŷ": "y",
                    "ỹ": "y",
                    "ȳ": "y",
                    "ẏ": "y",
                    "ÿ": "y",
                    "ỷ": "y",
                    "ẙ": "y",
                    "ỵ": "y",
                    "ƴ": "y",
                    "ɏ": "y",
                    "ỿ": "y",
                    "ⓩ": "z",
                    "ｚ": "z",
                    "ź": "z",
                    "ẑ": "z",
                    "ż": "z",
                    "ž": "z",
                    "ẓ": "z",
                    "ẕ": "z",
                    "ƶ": "z",
                    "ȥ": "z",
                    "ɀ": "z",
                    "ⱬ": "z",
                    "ꝣ": "z",
                    "Ά": "Α",
                    "Έ": "Ε",
                    "Ή": "Η",
                    "Ί": "Ι",
                    "Ϊ": "Ι",
                    "Ό": "Ο",
                    "Ύ": "Υ",
                    "Ϋ": "Υ",
                    "Ώ": "Ω",
                    "ά": "α",
                    "έ": "ε",
                    "ή": "η",
                    "ί": "ι",
                    "ϊ": "ι",
                    "ΐ": "ι",
                    "ό": "ο",
                    "ύ": "υ",
                    "ϋ": "υ",
                    "ΰ": "υ",
                    "ώ": "ω",
                    "ς": "σ",
                    "’": "'"
                }
            }), e.define("select2/data/base", ["../utils"], function(r) {
                function n(e, t) {
                    n.__super__.constructor.call(this)
                }
                return r.Extend(n, r.Observable), n.prototype.current = function(e) {
                    throw new Error("The `current` method must be defined in child classes.")
                }, n.prototype.query = function(e, t) {
                    throw new Error("The `query` method must be defined in child classes.")
                }, n.prototype.bind = function(e, t) {}, n.prototype.destroy = function() {}, n.prototype.generateResultId = function(e, t) {
                    var n = e.id + "-result-";
                    return n += r.generateChars(4), null != t.id ? n += "-" + t.id.toString() : n += "-" + r.generateChars(4), n
                }, n
            }), e.define("select2/data/select", ["./base", "../utils", "jquery"], function(e, a, l) {
                function n(e, t) {
                    this.$element = e, this.options = t, n.__super__.constructor.call(this)
                }
                return a.Extend(n, e), n.prototype.current = function(e) {
                    var n = [],
                        r = this;
                    this.$element.find(":selected").each(function() {
                        var e = l(this),
                            t = r.item(e);
                        n.push(t)
                    }), e(n)
                }, n.prototype.select = function(i) {
                    var o = this;
                    if (i.selected = !0, l(i.element).is("option")) return i.element.selected = !0, void this.$element.trigger("change");
                    if (this.$element.prop("multiple")) this.current(function(e) {
                        var t = [];
                        (i = [i]).push.apply(i, e);
                        for (var n = 0; n < i.length; n++) {
                            var r = i[n].id; - 1 === l.inArray(r, t) && t.push(r)
                        }
                        o.$element.val(t), o.$element.trigger("change")
                    });
                    else {
                        var e = i.id;
                        this.$element.val(e), this.$element.trigger("change")
                    }
                }, n.prototype.unselect = function(i) {
                    var o = this;
                    if (this.$element.prop("multiple")) {
                        if (i.selected = !1, l(i.element).is("option")) return i.element.selected = !1, void this.$element.trigger("change");
                        this.current(function(e) {
                            for (var t = [], n = 0; n < e.length; n++) {
                                var r = e[n].id;
                                r !== i.id && -1 === l.inArray(r, t) && t.push(r)
                            }
                            o.$element.val(t), o.$element.trigger("change")
                        })
                    }
                }, n.prototype.bind = function(e, t) {
                    var n = this;
                    (this.container = e).on("select", function(e) {
                        n.select(e.data)
                    }), e.on("unselect", function(e) {
                        n.unselect(e.data)
                    })
                }, n.prototype.destroy = function() {
                    this.$element.find("*").each(function() {
                        a.RemoveData(this)
                    })
                }, n.prototype.query = function(r, e) {
                    var i = [],
                        o = this;
                    this.$element.children().each(function() {
                        var e = l(this);
                        if (e.is("option") || e.is("optgroup")) {
                            var t = o.item(e),
                                n = o.matches(r, t);
                            null !== n && i.push(n)
                        }
                    }), e({
                        results: i
                    })
                }, n.prototype.addOptions = function(e) {
                    a.appendMany(this.$element, e)
                }, n.prototype.option = function(e) {
                    var t;
                    e.children ? (t = document.createElement("optgroup")).label = e.text : void 0 !== (t = document.createElement("option")).textContent ? t.textContent = e.text : t.innerText = e.text, void 0 !== e.id && (t.value = e.id), e.disabled && (t.disabled = !0), e.selected && (t.selected = !0), e.title && (t.title = e.title);
                    var n = l(t),
                        r = this._normalizeItem(e);
                    return r.element = t, a.StoreData(t, "data", r), n
                }, n.prototype.item = function(e) {
                    var t = {};
                    if (null != (t = a.GetData(e[0], "data"))) return t;
                    if (e.is("option")) t = {
                        id: e.val(),
                        text: e.text(),
                        disabled: e.prop("disabled"),
                        selected: e.prop("selected"),
                        title: e.prop("title")
                    };
                    else if (e.is("optgroup")) {
                        t = {
                            text: e.prop("label"),
                            children: [],
                            title: e.prop("title")
                        };
                        for (var n = e.children("option"), r = [], i = 0; i < n.length; i++) {
                            var o = l(n[i]),
                                s = this.item(o);
                            r.push(s)
                        }
                        t.children = r
                    }
                    return (t = this._normalizeItem(t)).element = e[0], a.StoreData(e[0], "data", t), t
                }, n.prototype._normalizeItem = function(e) {
                    e !== Object(e) && (e = {
                        id: e,
                        text: e
                    });
                    return null != (e = l.extend({}, {
                        text: ""
                    }, e)).id && (e.id = e.id.toString()), null != e.text && (e.text = e.text.toString()), null == e._resultId && e.id && null != this.container && (e._resultId = this.generateResultId(this.container, e)), l.extend({}, {
                        selected: !1,
                        disabled: !1
                    }, e)
                }, n.prototype.matches = function(e, t) {
                    return this.options.get("matcher")(e, t)
                }, n
            }), e.define("select2/data/array", ["./select", "../utils", "jquery"], function(e, f, g) {
                function r(e, t) {
                    this._dataToConvert = t.get("data") || [], r.__super__.constructor.call(this, e, t)
                }
                return f.Extend(r, e), r.prototype.bind = function(e, t) {
                    r.__super__.bind.call(this, e, t), this.addOptions(this.convertToOptions(this._dataToConvert))
                }, r.prototype.select = function(n) {
                    var e = this.$element.find("option").filter(function(e, t) {
                        return t.value == n.id.toString()
                    });
                    0 === e.length && (e = this.option(n), this.addOptions(e)), r.__super__.select.call(this, n)
                }, r.prototype.convertToOptions = function(e) {
                    var t = this,
                        n = this.$element.find("option"),
                        r = n.map(function() {
                            return t.item(g(this)).id
                        }).get(),
                        i = [];

                    function o(e) {
                        return function() {
                            return g(this).val() == e.id
                        }
                    }
                    for (var s = 0; s < e.length; s++) {
                        var a = this._normalizeItem(e[s]);
                        if (0 <= g.inArray(a.id, r)) {
                            var l = n.filter(o(a)),
                                c = this.item(l),
                                u = g.extend(!0, {}, a, c),
                                d = this.option(u);
                            l.replaceWith(d)
                        } else {
                            var p = this.option(a);
                            if (a.children) {
                                var h = this.convertToOptions(a.children);
                                f.appendMany(p, h)
                            }
                            i.push(p)
                        }
                    }
                    return i
                }, r
            }), e.define("select2/data/ajax", ["./array", "../utils", "jquery"], function(e, t, o) {
                function n(e, t) {
                    this.ajaxOptions = this._applyDefaults(t.get("ajax")), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), n.__super__.constructor.call(this, e, t)
                }
                return t.Extend(n, e), n.prototype._applyDefaults = function(e) {
                    var t = {
                        data: function(e) {
                            return o.extend({}, e, {
                                q: e.term
                            })
                        },
                        transport: function(e, t, n) {
                            var r = o.ajax(e);
                            return r.then(t), r.fail(n), r
                        }
                    };
                    return o.extend({}, t, e, !0)
                }, n.prototype.processResults = function(e) {
                    return e
                }, n.prototype.query = function(n, r) {
                    var i = this;
                    null != this._request && (o.isFunction(this._request.abort) && this._request.abort(), this._request = null);
                    var t = o.extend({
                        type: "GET"
                    }, this.ajaxOptions);

                    function e() {
                        var e = t.transport(t, function(e) {
                            var t = i.processResults(e, n);
                            i.options.get("debug") && window.console && console.error && (t && t.results && o.isArray(t.results) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")), r(t)
                        }, function() {
                            "status" in e && (0 === e.status || "0" === e.status) || i.trigger("results:message", {
                                message: "errorLoading"
                            })
                        });
                        i._request = e
                    }
                    "function" == typeof t.url && (t.url = t.url.call(this.$element, n)), "function" == typeof t.data && (t.data = t.data.call(this.$element, n)), this.ajaxOptions.delay && null != n.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), this._queryTimeout = window.setTimeout(e, this.ajaxOptions.delay)) : e()
                }, n
            }), e.define("select2/data/tags", ["jquery"], function(u) {
                function e(e, t, n) {
                    var r = n.get("tags"),
                        i = n.get("createTag");
                    void 0 !== i && (this.createTag = i);
                    var o = n.get("insertTag");
                    if (void 0 !== o && (this.insertTag = o), e.call(this, t, n), u.isArray(r))
                        for (var s = 0; s < r.length; s++) {
                            var a = r[s],
                                l = this._normalizeItem(a),
                                c = this.option(l);
                            this.$element.append(c)
                        }
                }
                return e.prototype.query = function(e, c, u) {
                    var d = this;
                    this._removeOldTags(), null != c.term && null == c.page ? e.call(this, c, function e(t, n) {
                        for (var r = t.results, i = 0; i < r.length; i++) {
                            var o = r[i],
                                s = null != o.children && !e({
                                    results: o.children
                                }, !0);
                            if ((o.text || "").toUpperCase() === (c.term || "").toUpperCase() || s) return !n && (t.data = r, void u(t))
                        }
                        if (n) return !0;
                        var a = d.createTag(c);
                        if (null != a) {
                            var l = d.option(a);
                            l.attr("data-select2-tag", !0), d.addOptions([l]), d.insertTag(r, a)
                        }
                        t.results = r, u(t)
                    }) : e.call(this, c, u)
                }, e.prototype.createTag = function(e, t) {
                    var n = u.trim(t.term);
                    return "" === n ? null : {
                        id: n,
                        text: n
                    }
                }, e.prototype.insertTag = function(e, t, n) {
                    t.unshift(n)
                }, e.prototype._removeOldTags = function(e) {
                    this.$element.find("option[data-select2-tag]").each(function() {
                        this.selected || u(this).remove()
                    })
                }, e
            }), e.define("select2/data/tokenizer", ["jquery"], function(d) {
                function e(e, t, n) {
                    var r = n.get("tokenizer");
                    void 0 !== r && (this.tokenizer = r), e.call(this, t, n)
                }
                return e.prototype.bind = function(e, t, n) {
                    e.call(this, t, n), this.$search = t.dropdown.$search || t.selection.$search || n.find(".select2-search__field")
                }, e.prototype.query = function(e, t, n) {
                    var r = this;
                    t.term = t.term || "";
                    var i = this.tokenizer(t, this.options, function(e) {
                        var t = r._normalizeItem(e);
                        if (!r.$element.find("option").filter(function() {
                                return d(this).val() === t.id
                            }).length) {
                            var n = r.option(t);
                            n.attr("data-select2-tag", !0), r._removeOldTags(), r.addOptions([n])
                        }! function(e) {
                            r.trigger("select", {
                                data: e
                            })
                        }(t)
                    });
                    i.term !== t.term && (this.$search.length && (this.$search.val(i.term), this.$search.trigger("focus")), t.term = i.term), e.call(this, t, n)
                }, e.prototype.tokenizer = function(e, t, n, r) {
                    for (var i = n.get("tokenSeparators") || [], o = t.term, s = 0, a = this.createTag || function(e) {
                            return {
                                id: e.term,
                                text: e.term
                            }
                        }; s < o.length;) {
                        var l = o[s];
                        if (-1 !== d.inArray(l, i)) {
                            var c = o.substr(0, s),
                                u = a(d.extend({}, t, {
                                    term: c
                                }));
                            null != u ? (r(u), o = o.substr(s + 1) || "", s = 0) : s++
                        } else s++
                    }
                    return {
                        term: o
                    }
                }, e
            }), e.define("select2/data/minimumInputLength", [], function() {
                function e(e, t, n) {
                    this.minimumInputLength = n.get("minimumInputLength"), e.call(this, t, n)
                }
                return e.prototype.query = function(e, t, n) {
                    t.term = t.term || "", t.term.length < this.minimumInputLength ? this.trigger("results:message", {
                        message: "inputTooShort",
                        args: {
                            minimum: this.minimumInputLength,
                            input: t.term,
                            params: t
                        }
                    }) : e.call(this, t, n)
                }, e
            }), e.define("select2/data/maximumInputLength", [], function() {
                function e(e, t, n) {
                    this.maximumInputLength = n.get("maximumInputLength"), e.call(this, t, n)
                }
                return e.prototype.query = function(e, t, n) {
                    t.term = t.term || "", 0 < this.maximumInputLength && t.term.length > this.maximumInputLength ? this.trigger("results:message", {
                        message: "inputTooLong",
                        args: {
                            maximum: this.maximumInputLength,
                            input: t.term,
                            params: t
                        }
                    }) : e.call(this, t, n)
                }, e
            }), e.define("select2/data/maximumSelectionLength", [], function() {
                function e(e, t, n) {
                    this.maximumSelectionLength = n.get("maximumSelectionLength"), e.call(this, t, n)
                }
                return e.prototype.bind = function(e, t, n) {
                    var r = this;
                    e.call(this, t, n), t.on("select", function() {
                        r._checkIfMaximumSelected()
                    })
                }, e.prototype.query = function(e, t, n) {
                    var r = this;
                    this._checkIfMaximumSelected(function() {
                        e.call(r, t, n)
                    })
                }, e.prototype._checkIfMaximumSelected = function(e, n) {
                    var r = this;
                    this.current(function(e) {
                        var t = null != e ? e.length : 0;
                        0 < r.maximumSelectionLength && t >= r.maximumSelectionLength ? r.trigger("results:message", {
                            message: "maximumSelected",
                            args: {
                                maximum: r.maximumSelectionLength
                            }
                        }) : n && n()
                    })
                }, e
            }), e.define("select2/dropdown", ["jquery", "./utils"], function(t, e) {
                function n(e, t) {
                    this.$element = e, this.options = t, n.__super__.constructor.call(this)
                }
                return e.Extend(n, e.Observable), n.prototype.render = function() {
                    var e = t('<span class="select2-dropdown"><span class="select2-results"></span></span>');
                    return e.attr("dir", this.options.get("dir")), this.$dropdown = e
                }, n.prototype.bind = function() {}, n.prototype.position = function(e, t) {}, n.prototype.destroy = function() {
                    this.$dropdown.remove()
                }, n
            }), e.define("select2/dropdown/search", ["jquery", "../utils"], function(o, e) {
                function t() {}
                return t.prototype.render = function(e) {
                    var t = e.call(this),
                        n = o('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></span>');
                    return this.$searchContainer = n, this.$search = n.find("input"), t.prepend(n), t
                }, t.prototype.bind = function(e, t, n) {
                    var r = this,
                        i = t.id + "-results";
                    e.call(this, t, n), this.$search.on("keydown", function(e) {
                        r.trigger("keypress", e), r._keyUpPrevented = e.isDefaultPrevented()
                    }), this.$search.on("input", function(e) {
                        o(this).off("keyup")
                    }), this.$search.on("keyup input", function(e) {
                        r.handleSearch(e)
                    }), t.on("open", function() {
                        r.$search.attr("tabindex", 0), r.$search.attr("aria-controls", i), r.$search.trigger("focus"), window.setTimeout(function() {
                            r.$search.trigger("focus")
                        }, 0)
                    }), t.on("close", function() {
                        r.$search.attr("tabindex", -1), r.$search.removeAttr("aria-controls"), r.$search.removeAttr("aria-activedescendant"), r.$search.val(""), r.$search.trigger("blur")
                    }), t.on("focus", function() {
                        t.isOpen() || r.$search.trigger("focus")
                    }), t.on("results:all", function(e) {
                        null != e.query.term && "" !== e.query.term || (r.showSearch(e) ? r.$searchContainer.removeClass("select2-search--hide") : r.$searchContainer.addClass("select2-search--hide"))
                    }), t.on("results:focus", function(e) {
                        e.data._resultId ? r.$search.attr("aria-activedescendant", e.data._resultId) : r.$search.removeAttr("aria-activedescendant")
                    })
                }, t.prototype.handleSearch = function(e) {
                    if (!this._keyUpPrevented) {
                        var t = this.$search.val();
                        this.trigger("query", {
                            term: t
                        })
                    }
                    this._keyUpPrevented = !1
                }, t.prototype.showSearch = function(e, t) {
                    return !0
                }, t
            }), e.define("select2/dropdown/hidePlaceholder", [], function() {
                function e(e, t, n, r) {
                    this.placeholder = this.normalizePlaceholder(n.get("placeholder")), e.call(this, t, n, r)
                }
                return e.prototype.append = function(e, t) {
                    t.results = this.removePlaceholder(t.results), e.call(this, t)
                }, e.prototype.normalizePlaceholder = function(e, t) {
                    return "string" == typeof t && (t = {
                        id: "",
                        text: t
                    }), t
                }, e.prototype.removePlaceholder = function(e, t) {
                    for (var n = t.slice(0), r = t.length - 1; 0 <= r; r--) {
                        var i = t[r];
                        this.placeholder.id === i.id && n.splice(r, 1)
                    }
                    return n
                }, e
            }), e.define("select2/dropdown/infiniteScroll", ["jquery"], function(n) {
                function e(e, t, n, r) {
                    this.lastParams = {}, e.call(this, t, n, r), this.$loadingMore = this.createLoadingMore(), this.loading = !1
                }
                return e.prototype.append = function(e, t) {
                    this.$loadingMore.remove(), this.loading = !1, e.call(this, t), this.showLoadingMore(t) && (this.$results.append(this.$loadingMore), this.loadMoreIfNeeded())
                }, e.prototype.bind = function(e, t, n) {
                    var r = this;
                    e.call(this, t, n), t.on("query", function(e) {
                        r.lastParams = e, r.loading = !0
                    }), t.on("query:append", function(e) {
                        r.lastParams = e, r.loading = !0
                    }), this.$results.on("scroll", this.loadMoreIfNeeded.bind(this))
                }, e.prototype.loadMoreIfNeeded = function() {
                    var e = n.contains(document.documentElement, this.$loadingMore[0]);
                    if (!this.loading && e) {
                        var t = this.$results.offset().top + this.$results.outerHeight(!1);
                        this.$loadingMore.offset().top + this.$loadingMore.outerHeight(!1) <= t + 50 && this.loadMore()
                    }
                }, e.prototype.loadMore = function() {
                    this.loading = !0;
                    var e = n.extend({}, {
                        page: 1
                    }, this.lastParams);
                    e.page++, this.trigger("query:append", e)
                }, e.prototype.showLoadingMore = function(e, t) {
                    return t.pagination && t.pagination.more
                }, e.prototype.createLoadingMore = function() {
                    var e = n('<li class="select2-results__option select2-results__option--load-more"role="option" aria-disabled="true"></li>'),
                        t = this.options.get("translations").get("loadingMore");
                    return e.html(t(this.lastParams)), e
                }, e
            }), e.define("select2/dropdown/attachBody", ["jquery", "../utils"], function(f, a) {
                function e(e, t, n) {
                    this.$dropdownParent = f(n.get("dropdownParent") || document.body), e.call(this, t, n)
                }
                return e.prototype.bind = function(e, t, n) {
                    var r = this;
                    e.call(this, t, n), t.on("open", function() {
                        r._showDropdown(), r._attachPositioningHandler(t), r._bindContainerResultHandlers(t)
                    }), t.on("close", function() {
                        r._hideDropdown(), r._detachPositioningHandler(t)
                    }), this.$dropdownContainer.on("mousedown", function(e) {
                        e.stopPropagation()
                    })
                }, e.prototype.destroy = function(e) {
                    e.call(this), this.$dropdownContainer.remove()
                }, e.prototype.position = function(e, t, n) {
                    t.attr("class", n.attr("class")), t.removeClass("select2"), t.addClass("select2-container--open"), t.css({
                        position: "absolute",
                        top: -999999
                    }), this.$container = n
                }, e.prototype.render = function(e) {
                    var t = f("<span></span>"),
                        n = e.call(this);
                    return t.append(n), this.$dropdownContainer = t
                }, e.prototype._hideDropdown = function(e) {
                    this.$dropdownContainer.detach()
                }, e.prototype._bindContainerResultHandlers = function(e, t) {
                    if (!this._containerResultsHandlersBound) {
                        var n = this;
                        t.on("results:all", function() {
                            n._positionDropdown(), n._resizeDropdown()
                        }), t.on("results:append", function() {
                            n._positionDropdown(), n._resizeDropdown()
                        }), t.on("results:message", function() {
                            n._positionDropdown(), n._resizeDropdown()
                        }), t.on("select", function() {
                            n._positionDropdown(), n._resizeDropdown()
                        }), t.on("unselect", function() {
                            n._positionDropdown(), n._resizeDropdown()
                        }), this._containerResultsHandlersBound = !0
                    }
                }, e.prototype._attachPositioningHandler = function(e, t) {
                    var n = this,
                        r = "scroll.select2." + t.id,
                        i = "resize.select2." + t.id,
                        o = "orientationchange.select2." + t.id,
                        s = this.$container.parents().filter(a.hasScroll);
                    s.each(function() {
                        a.StoreData(this, "select2-scroll-position", {
                            x: f(this).scrollLeft(),
                            y: f(this).scrollTop()
                        })
                    }), s.on(r, function(e) {
                        var t = a.GetData(this, "select2-scroll-position");
                        f(this).scrollTop(t.y)
                    }), f(window).on(r + " " + i + " " + o, function(e) {
                        n._positionDropdown(), n._resizeDropdown()
                    })
                }, e.prototype._detachPositioningHandler = function(e, t) {
                    var n = "scroll.select2." + t.id,
                        r = "resize.select2." + t.id,
                        i = "orientationchange.select2." + t.id;
                    this.$container.parents().filter(a.hasScroll).off(n), f(window).off(n + " " + r + " " + i)
                }, e.prototype._positionDropdown = function() {
                    var e = f(window),
                        t = this.$dropdown.hasClass("select2-dropdown--above"),
                        n = this.$dropdown.hasClass("select2-dropdown--below"),
                        r = null,
                        i = this.$container.offset();
                    i.bottom = i.top + this.$container.outerHeight(!1);
                    var o = {
                        height: this.$container.outerHeight(!1)
                    };
                    o.top = i.top, o.bottom = i.top + o.height;
                    var s = this.$dropdown.outerHeight(!1),
                        a = e.scrollTop(),
                        l = e.scrollTop() + e.height(),
                        c = a < i.top - s,
                        u = l > i.bottom + s,
                        d = {
                            left: i.left,
                            top: o.bottom
                        },
                        p = this.$dropdownParent;
                    "static" === p.css("position") && (p = p.offsetParent());
                    var h = {
                        top: 0,
                        left: 0
                    };
                    (f.contains(document.body, p[0]) || p[0].isConnected) && (h = p.offset()), d.top -= h.top, d.left -= h.left, t || n || (r = "below"), u || !c || t ? !c && u && t && (r = "below") : r = "above", ("above" == r || t && "below" !== r) && (d.top = o.top - h.top - s), null != r && (this.$dropdown.removeClass("select2-dropdown--below select2-dropdown--above").addClass("select2-dropdown--" + r), this.$container.removeClass("select2-container--below select2-container--above").addClass("select2-container--" + r)), this.$dropdownContainer.css(d)
                }, e.prototype._resizeDropdown = function() {
                    var e = {
                        width: this.$container.outerWidth(!1) + "px"
                    };
                    this.options.get("dropdownAutoWidth") && (e.minWidth = e.width, e.position = "relative", e.width = "auto"), this.$dropdown.css(e)
                }, e.prototype._showDropdown = function(e) {
                    this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown()
                }, e
            }), e.define("select2/dropdown/minimumResultsForSearch", [], function() {
                function e(e, t, n, r) {
                    this.minimumResultsForSearch = n.get("minimumResultsForSearch"), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), e.call(this, t, n, r)
                }
                return e.prototype.showSearch = function(e, t) {
                    return !(function e(t) {
                        for (var n = 0, r = 0; r < t.length; r++) {
                            var i = t[r];
                            i.children ? n += e(i.children) : n++
                        }
                        return n
                    }(t.data.results) < this.minimumResultsForSearch) && e.call(this, t)
                }, e
            }), e.define("select2/dropdown/selectOnClose", ["../utils"], function(o) {
                function e() {}
                return e.prototype.bind = function(e, t, n) {
                    var r = this;
                    e.call(this, t, n), t.on("close", function(e) {
                        r._handleSelectOnClose(e)
                    })
                }, e.prototype._handleSelectOnClose = function(e, t) {
                    if (t && null != t.originalSelect2Event) {
                        var n = t.originalSelect2Event;
                        if ("select" === n._type || "unselect" === n._type) return
                    }
                    var r = this.getHighlightedResults();
                    if (!(r.length < 1)) {
                        var i = o.GetData(r[0], "data");
                        null != i.element && i.element.selected || null == i.element && i.selected || this.trigger("select", {
                            data: i
                        })
                    }
                }, e
            }), e.define("select2/dropdown/closeOnSelect", [], function() {
                function e() {}
                return e.prototype.bind = function(e, t, n) {
                    var r = this;
                    e.call(this, t, n), t.on("select", function(e) {
                        r._selectTriggered(e)
                    }), t.on("unselect", function(e) {
                        r._selectTriggered(e)
                    })
                }, e.prototype._selectTriggered = function(e, t) {
                    var n = t.originalEvent;
                    n && (n.ctrlKey || n.metaKey) || this.trigger("close", {
                        originalEvent: n,
                        originalSelect2Event: t
                    })
                }, e
            }), e.define("select2/i18n/en", [], function() {
                return {
                    errorLoading: function() {
                        return "The results could not be loaded."
                    },
                    inputTooLong: function(e) {
                        var t = e.input.length - e.maximum,
                            n = "Please delete " + t + " character";
                        return 1 != t && (n += "s"), n
                    },
                    inputTooShort: function(e) {
                        return "Please enter " + (e.minimum - e.input.length) + " or more characters"
                    },
                    loadingMore: function() {
                        return "Loading more results…"
                    },
                    maximumSelected: function(e) {
                        var t = "You can only select " + e.maximum + " item";
                        return 1 != e.maximum && (t += "s"), t
                    },
                    noResults: function() {
                        return "No results found"
                    },
                    searching: function() {
                        return "Searching…"
                    },
                    removeAllItems: function() {
                        return "Remove all items"
                    }
                }
            }), e.define("select2/defaults", ["jquery", "require", "./results", "./selection/single", "./selection/multiple", "./selection/placeholder", "./selection/allowClear", "./selection/search", "./selection/eventRelay", "./utils", "./translation", "./diacritics", "./data/select", "./data/array", "./data/ajax", "./data/tags", "./data/tokenizer", "./data/minimumInputLength", "./data/maximumInputLength", "./data/maximumSelectionLength", "./dropdown", "./dropdown/search", "./dropdown/hidePlaceholder", "./dropdown/infiniteScroll", "./dropdown/attachBody", "./dropdown/minimumResultsForSearch", "./dropdown/selectOnClose", "./dropdown/closeOnSelect", "./i18n/en"], function(c, u, d, p, h, f, g, m, v, y, s, t, _, $, w, b, A, x, D, S, E, C, O, T, q, L, I, j, e) {
                function n() {
                    this.reset()
                }
                return n.prototype.apply = function(e) {
                    if (null == (e = c.extend(!0, {}, this.defaults, e)).dataAdapter) {
                        if (null != e.ajax ? e.dataAdapter = w : null != e.data ? e.dataAdapter = $ : e.dataAdapter = _, 0 < e.minimumInputLength && (e.dataAdapter = y.Decorate(e.dataAdapter, x)), 0 < e.maximumInputLength && (e.dataAdapter = y.Decorate(e.dataAdapter, D)), 0 < e.maximumSelectionLength && (e.dataAdapter = y.Decorate(e.dataAdapter, S)), e.tags && (e.dataAdapter = y.Decorate(e.dataAdapter, b)), null == e.tokenSeparators && null == e.tokenizer || (e.dataAdapter = y.Decorate(e.dataAdapter, A)), null != e.query) {
                            var t = u(e.amdBase + "compat/query");
                            e.dataAdapter = y.Decorate(e.dataAdapter, t)
                        }
                        if (null != e.initSelection) {
                            var n = u(e.amdBase + "compat/initSelection");
                            e.dataAdapter = y.Decorate(e.dataAdapter, n)
                        }
                    }
                    if (null == e.resultsAdapter && (e.resultsAdapter = d, null != e.ajax && (e.resultsAdapter = y.Decorate(e.resultsAdapter, T)), null != e.placeholder && (e.resultsAdapter = y.Decorate(e.resultsAdapter, O)), e.selectOnClose && (e.resultsAdapter = y.Decorate(e.resultsAdapter, I))), null == e.dropdownAdapter) {
                        if (e.multiple) e.dropdownAdapter = E;
                        else {
                            var r = y.Decorate(E, C);
                            e.dropdownAdapter = r
                        }
                        if (0 !== e.minimumResultsForSearch && (e.dropdownAdapter = y.Decorate(e.dropdownAdapter, L)), e.closeOnSelect && (e.dropdownAdapter = y.Decorate(e.dropdownAdapter, j)), null != e.dropdownCssClass || null != e.dropdownCss || null != e.adaptDropdownCssClass) {
                            var i = u(e.amdBase + "compat/dropdownCss");
                            e.dropdownAdapter = y.Decorate(e.dropdownAdapter, i)
                        }
                        e.dropdownAdapter = y.Decorate(e.dropdownAdapter, q)
                    }
                    if (null == e.selectionAdapter) {
                        if (e.multiple ? e.selectionAdapter = h : e.selectionAdapter = p, null != e.placeholder && (e.selectionAdapter = y.Decorate(e.selectionAdapter, f)), e.allowClear && (e.selectionAdapter = y.Decorate(e.selectionAdapter, g)), e.multiple && (e.selectionAdapter = y.Decorate(e.selectionAdapter, m)), null != e.containerCssClass || null != e.containerCss || null != e.adaptContainerCssClass) {
                            var o = u(e.amdBase + "compat/containerCss");
                            e.selectionAdapter = y.Decorate(e.selectionAdapter, o)
                        }
                        e.selectionAdapter = y.Decorate(e.selectionAdapter, v)
                    }
                    e.language = this._resolveLanguage(e.language), e.language.push("en");
                    for (var s = [], a = 0; a < e.language.length; a++) {
                        var l = e.language[a]; - 1 === s.indexOf(l) && s.push(l)
                    }
                    return e.language = s, e.translations = this._processTranslations(e.language, e.debug), e
                }, n.prototype.reset = function() {
                    function a(e) {
                        return e.replace(/[^\u0000-\u007E]/g, function(e) {
                            return t[e] || e
                        })
                    }
                    this.defaults = {
                        amdBase: "./",
                        amdLanguageBase: "./i18n/",
                        closeOnSelect: !0,
                        debug: !1,
                        dropdownAutoWidth: !1,
                        escapeMarkup: y.escapeMarkup,
                        language: {},
                        matcher: function e(t, n) {
                            if ("" === c.trim(t.term)) return n;
                            if (n.children && 0 < n.children.length) {
                                for (var r = c.extend(!0, {}, n), i = n.children.length - 1; 0 <= i; i--) null == e(t, n.children[i]) && r.children.splice(i, 1);
                                return 0 < r.children.length ? r : e(t, r)
                            }
                            var o = a(n.text).toUpperCase(),
                                s = a(t.term).toUpperCase();
                            return -1 < o.indexOf(s) ? n : null
                        },
                        minimumInputLength: 0,
                        maximumInputLength: 0,
                        maximumSelectionLength: 0,
                        minimumResultsForSearch: 0,
                        selectOnClose: !1,
                        scrollAfterSelect: !1,
                        sorter: function(e) {
                            return e
                        },
                        templateResult: function(e) {
                            return e.text
                        },
                        templateSelection: function(e) {
                            return e.text
                        },
                        theme: "default",
                        width: "resolve"
                    }
                }, n.prototype.applyFromElement = function(e, t) {
                    var n = e.language,
                        r = this.defaults.language,
                        i = t.prop("lang"),
                        o = t.closest("[lang]").prop("lang"),
                        s = Array.prototype.concat.call(this._resolveLanguage(i), this._resolveLanguage(n), this._resolveLanguage(r), this._resolveLanguage(o));
                    return e.language = s, e
                }, n.prototype._resolveLanguage = function(e) {
                    if (!e) return [];
                    if (c.isEmptyObject(e)) return [];
                    if (c.isPlainObject(e)) return [e];
                    var t;
                    t = c.isArray(e) ? e : [e];
                    for (var n = [], r = 0; r < t.length; r++)
                        if (n.push(t[r]), "string" == typeof t[r] && 0 < t[r].indexOf("-")) {
                            var i = t[r].split("-")[0];
                            n.push(i)
                        }
                    return n
                }, n.prototype._processTranslations = function(e, t) {
                    for (var n = new s, r = 0; r < e.length; r++) {
                        var i = new s,
                            o = e[r];
                        if ("string" == typeof o) try {
                            i = s.loadPath(o)
                        } catch (e) {
                            try {
                                o = this.defaults.amdLanguageBase + o, i = s.loadPath(o)
                            } catch (e) {
                                t && window.console && console.warn && console.warn('Select2: The language file for "' + o + '" could not be automatically loaded. A fallback will be used instead.')
                            }
                        } else i = c.isPlainObject(o) ? new s(o) : o;
                        n.extend(i)
                    }
                    return n
                }, n.prototype.set = function(e, t) {
                    var n = {};
                    n[c.camelCase(e)] = t;
                    var r = y._convertData(n);
                    c.extend(!0, this.defaults, r)
                }, new n
            }), e.define("select2/options", ["require", "jquery", "./defaults", "./utils"], function(r, d, i, p) {
                function e(e, t) {
                    if (this.options = e, null != t && this.fromElement(t), null != t && (this.options = i.applyFromElement(this.options, t)), this.options = i.apply(this.options), t && t.is("input")) {
                        var n = r(this.get("amdBase") + "compat/inputData");
                        this.options.dataAdapter = p.Decorate(this.options.dataAdapter, n)
                    }
                }
                return e.prototype.fromElement = function(e) {
                    var t = ["select2"];
                    null == this.options.multiple && (this.options.multiple = e.prop("multiple")), null == this.options.disabled && (this.options.disabled = e.prop("disabled")), null == this.options.dir && (e.prop("dir") ? this.options.dir = e.prop("dir") : e.closest("[dir]").prop("dir") ? this.options.dir = e.closest("[dir]").prop("dir") : this.options.dir = "ltr"), e.prop("disabled", this.options.disabled), e.prop("multiple", this.options.multiple), p.GetData(e[0], "select2Tags") && (this.options.debug && window.console && console.warn && console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'), p.StoreData(e[0], "data", p.GetData(e[0], "select2Tags")), p.StoreData(e[0], "tags", !0)), p.GetData(e[0], "ajaxUrl") && (this.options.debug && window.console && console.warn && console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."), e.attr("ajax--url", p.GetData(e[0], "ajaxUrl")), p.StoreData(e[0], "ajax-Url", p.GetData(e[0], "ajaxUrl")));
                    var n = {};

                    function r(e, t) {
                        return t.toUpperCase()
                    }
                    for (var i = 0; i < e[0].attributes.length; i++) {
                        var o = e[0].attributes[i].name,
                            s = "data-";
                        if (o.substr(0, s.length) == s) {
                            var a = o.substring(s.length),
                                l = p.GetData(e[0], a);
                            n[a.replace(/-([a-z])/g, r)] = l
                        }
                    }
                    d.fn.jquery && "1." == d.fn.jquery.substr(0, 2) && e[0].dataset && (n = d.extend(!0, {}, e[0].dataset, n));
                    var c = d.extend(!0, {}, p.GetData(e[0]), n);
                    for (var u in c = p._convertData(c)) - 1 < d.inArray(u, t) || (d.isPlainObject(this.options[u]) ? d.extend(this.options[u], c[u]) : this.options[u] = c[u]);
                    return this
                }, e.prototype.get = function(e) {
                    return this.options[e]
                }, e.prototype.set = function(e, t) {
                    this.options[e] = t
                }, e
            }), e.define("select2/core", ["jquery", "./options", "./utils", "./keys"], function(i, c, u, r) {
                var d = function(e, t) {
                    null != u.GetData(e[0], "select2") && u.GetData(e[0], "select2").destroy(), this.$element = e, this.id = this._generateId(e), t = t || {}, this.options = new c(t, e), d.__super__.constructor.call(this);
                    var n = e.attr("tabindex") || 0;
                    u.StoreData(e[0], "old-tabindex", n), e.attr("tabindex", "-1");
                    var r = this.options.get("dataAdapter");
                    this.dataAdapter = new r(e, this.options);
                    var i = this.render();
                    this._placeContainer(i);
                    var o = this.options.get("selectionAdapter");
                    this.selection = new o(e, this.options), this.$selection = this.selection.render(), this.selection.position(this.$selection, i);
                    var s = this.options.get("dropdownAdapter");
                    this.dropdown = new s(e, this.options), this.$dropdown = this.dropdown.render(), this.dropdown.position(this.$dropdown, i);
                    var a = this.options.get("resultsAdapter");
                    this.results = new a(e, this.options, this.dataAdapter), this.$results = this.results.render(), this.results.position(this.$results, this.$dropdown);
                    var l = this;
                    this._bindAdapters(), this._registerDomEvents(), this._registerDataEvents(), this._registerSelectionEvents(), this._registerDropdownEvents(), this._registerResultsEvents(), this._registerEvents(), this.dataAdapter.current(function(e) {
                        l.trigger("selection:update", {
                            data: e
                        })
                    }), e.addClass("select2-hidden-accessible"), e.attr("aria-hidden", "true"), this._syncAttributes(), u.StoreData(e[0], "select2", this), e.data("select2", this)
                };
                return u.Extend(d, u.Observable), d.prototype._generateId = function(e) {
                    return "select2-" + (null != e.attr("id") ? e.attr("id") : null != e.attr("name") ? e.attr("name") + "-" + u.generateChars(2) : u.generateChars(4)).replace(/(:|\.|\[|\]|,)/g, "")
                }, d.prototype._placeContainer = function(e) {
                    e.insertAfter(this.$element);
                    var t = this._resolveWidth(this.$element, this.options.get("width"));
                    null != t && e.css("width", t)
                }, d.prototype._resolveWidth = function(e, t) {
                    var n = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;
                    if ("resolve" == t) {
                        var r = this._resolveWidth(e, "style");
                        return null != r ? r : this._resolveWidth(e, "element")
                    }
                    if ("element" == t) {
                        var i = e.outerWidth(!1);
                        return i <= 0 ? "auto" : i + "px"
                    }
                    if ("style" != t) return "computedstyle" != t ? t : window.getComputedStyle(e[0]).width;
                    var o = e.attr("style");
                    if ("string" != typeof o) return null;
                    for (var s = o.split(";"), a = 0, l = s.length; a < l; a += 1) {
                        var c = s[a].replace(/\s/g, "").match(n);
                        if (null !== c && 1 <= c.length) return c[1]
                    }
                    return null
                }, d.prototype._bindAdapters = function() {
                    this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container)
                }, d.prototype._registerDomEvents = function() {
                    var t = this;
                    this.$element.on("change.select2", function() {
                        t.dataAdapter.current(function(e) {
                            t.trigger("selection:update", {
                                data: e
                            })
                        })
                    }), this.$element.on("focus.select2", function(e) {
                        t.trigger("focus", e)
                    }), this._syncA = u.bind(this._syncAttributes, this), this._syncS = u.bind(this._syncSubtree, this), this.$element[0].attachEvent && this.$element[0].attachEvent("onpropertychange", this._syncA);
                    var e = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
                    null != e ? (this._observer = new e(function(e) {
                        i.each(e, t._syncA), i.each(e, t._syncS)
                    }), this._observer.observe(this.$element[0], {
                        attributes: !0,
                        childList: !0,
                        subtree: !1
                    })) : this.$element[0].addEventListener && (this.$element[0].addEventListener("DOMAttrModified", t._syncA, !1), this.$element[0].addEventListener("DOMNodeInserted", t._syncS, !1), this.$element[0].addEventListener("DOMNodeRemoved", t._syncS, !1))
                }, d.prototype._registerDataEvents = function() {
                    var n = this;
                    this.dataAdapter.on("*", function(e, t) {
                        n.trigger(e, t)
                    })
                }, d.prototype._registerSelectionEvents = function() {
                    var n = this,
                        r = ["toggle", "focus"];
                    this.selection.on("toggle", function() {
                        n.toggleDropdown()
                    }), this.selection.on("focus", function(e) {
                        n.focus(e)
                    }), this.selection.on("*", function(e, t) {
                        -1 === i.inArray(e, r) && n.trigger(e, t)
                    })
                }, d.prototype._registerDropdownEvents = function() {
                    var n = this;
                    this.dropdown.on("*", function(e, t) {
                        n.trigger(e, t)
                    })
                }, d.prototype._registerResultsEvents = function() {
                    var n = this;
                    this.results.on("*", function(e, t) {
                        n.trigger(e, t)
                    })
                }, d.prototype._registerEvents = function() {
                    var n = this;
                    this.on("open", function() {
                        n.$container.addClass("select2-container--open")
                    }), this.on("close", function() {
                        n.$container.removeClass("select2-container--open")
                    }), this.on("enable", function() {
                        n.$container.removeClass("select2-container--disabled")
                    }), this.on("disable", function() {
                        n.$container.addClass("select2-container--disabled")
                    }), this.on("blur", function() {
                        n.$container.removeClass("select2-container--focus")
                    }), this.on("query", function(t) {
                        n.isOpen() || n.trigger("open", {}), this.dataAdapter.query(t, function(e) {
                            n.trigger("results:all", {
                                data: e,
                                query: t
                            })
                        })
                    }), this.on("query:append", function(t) {
                        this.dataAdapter.query(t, function(e) {
                            n.trigger("results:append", {
                                data: e,
                                query: t
                            })
                        })
                    }), this.on("keypress", function(e) {
                        var t = e.which;
                        n.isOpen() ? t === r.ESC || t === r.TAB || t === r.UP && e.altKey ? (n.close(), e.preventDefault()) : t === r.ENTER ? (n.trigger("results:select", {}), e.preventDefault()) : t === r.SPACE && e.ctrlKey ? (n.trigger("results:toggle", {}), e.preventDefault()) : t === r.UP ? (n.trigger("results:previous", {}), e.preventDefault()) : t === r.DOWN && (n.trigger("results:next", {}), e.preventDefault()) : (t === r.ENTER || t === r.SPACE || t === r.DOWN && e.altKey) && (n.open(), e.preventDefault())
                    })
                }, d.prototype._syncAttributes = function() {
                    this.options.set("disabled", this.$element.prop("disabled")), this.options.get("disabled") ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {})
                }, d.prototype._syncSubtree = function(e, t) {
                    var n = !1,
                        r = this;
                    if (!e || !e.target || "OPTION" === e.target.nodeName || "OPTGROUP" === e.target.nodeName) {
                        if (t)
                            if (t.addedNodes && 0 < t.addedNodes.length)
                                for (var i = 0; i < t.addedNodes.length; i++) {
                                    t.addedNodes[i].selected && (n = !0)
                                } else t.removedNodes && 0 < t.removedNodes.length && (n = !0);
                            else n = !0;
                        n && this.dataAdapter.current(function(e) {
                            r.trigger("selection:update", {
                                data: e
                            })
                        })
                    }
                }, d.prototype.trigger = function(e, t) {
                    var n = d.__super__.trigger,
                        r = {
                            open: "opening",
                            close: "closing",
                            select: "selecting",
                            unselect: "unselecting",
                            clear: "clearing"
                        };
                    if (void 0 === t && (t = {}), e in r) {
                        var i = r[e],
                            o = {
                                prevented: !1,
                                name: e,
                                args: t
                            };
                        if (n.call(this, i, o), o.prevented) return void(t.prevented = !0)
                    }
                    n.call(this, e, t)
                }, d.prototype.toggleDropdown = function() {
                    this.options.get("disabled") || (this.isOpen() ? this.close() : this.open())
                }, d.prototype.open = function() {
                    this.isOpen() || this.trigger("query", {})
                }, d.prototype.close = function() {
                    this.isOpen() && this.trigger("close", {})
                }, d.prototype.isOpen = function() {
                    return this.$container.hasClass("select2-container--open")
                }, d.prototype.hasFocus = function() {
                    return this.$container.hasClass("select2-container--focus")
                }, d.prototype.focus = function(e) {
                    this.hasFocus() || (this.$container.addClass("select2-container--focus"), this.trigger("focus", {}))
                }, d.prototype.enable = function(e) {
                    this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'), null != e && 0 !== e.length || (e = [!0]);
                    var t = !e[0];
                    this.$element.prop("disabled", t)
                }, d.prototype.data = function() {
                    this.options.get("debug") && 0 < arguments.length && window.console && console.warn && console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');
                    var t = [];
                    return this.dataAdapter.current(function(e) {
                        t = e
                    }), t
                }, d.prototype.val = function(e) {
                    if (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'), null == e || 0 === e.length) return this.$element.val();
                    var t = e[0];
                    i.isArray(t) && (t = i.map(t, function(e) {
                        return e.toString()
                    })), this.$element.val(t).trigger("change")
                }, d.prototype.destroy = function() {
                    this.$container.remove(), this.$element[0].detachEvent && this.$element[0].detachEvent("onpropertychange", this._syncA), null != this._observer ? (this._observer.disconnect(), this._observer = null) : this.$element[0].removeEventListener && (this.$element[0].removeEventListener("DOMAttrModified", this._syncA, !1), this.$element[0].removeEventListener("DOMNodeInserted", this._syncS, !1), this.$element[0].removeEventListener("DOMNodeRemoved", this._syncS, !1)), this._syncA = null, this._syncS = null, this.$element.off(".select2"), this.$element.attr("tabindex", u.GetData(this.$element[0], "old-tabindex")), this.$element.removeClass("select2-hidden-accessible"), this.$element.attr("aria-hidden", "false"), u.RemoveData(this.$element[0]), this.$element.removeData("select2"), this.dataAdapter.destroy(), this.selection.destroy(), this.dropdown.destroy(), this.results.destroy(), this.dataAdapter = null, this.selection = null, this.dropdown = null, this.results = null
                }, d.prototype.render = function() {
                    var e = i('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');
                    return e.attr("dir", this.options.get("dir")), this.$container = e, this.$container.addClass("select2-container--" + this.options.get("theme")), u.StoreData(e[0], "element", this.$element), e
                }, d
            }), e.define("jquery-mousewheel", ["jquery"], function(e) {
                return e
            }), e.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults", "./select2/utils"], function(i, e, o, t, s) {
                if (null == i.fn.select2) {
                    var a = ["open", "close", "destroy"];
                    i.fn.select2 = function(t) {
                        if ("object" == typeof(t = t || {})) return this.each(function() {
                            var e = i.extend(!0, {}, t);
                            new o(i(this), e)
                        }), this;
                        if ("string" != typeof t) throw new Error("Invalid arguments for Select2: " + t);
                        var n, r = Array.prototype.slice.call(arguments, 1);
                        return this.each(function() {
                            var e = s.GetData(this, "select2");
                            null == e && window.console && console.error && console.error("The select2('" + t + "') method was called on an element that is not using Select2."), n = e[t].apply(e, r)
                        }), -1 < i.inArray(t, a) ? this : n
                    }
                }
                return null == i.fn.select2.defaults && (i.fn.select2.defaults = t), o
            }), {
                define: e.define,
                require: e.require
            }
        }(),
        t = e.require("jquery.select2");
    return u.fn.select2.amd = e, t
});
(function($) {
    "use strict";

    // CustomEvent polyfill
    try {
        new CustomEvent('IE has CustomEvent, but doesn\'t support constructor');
    } catch (e) {
        window.CustomEvent = function(event, params) {
            let evt;
            params = params || {
                bubbles: false,
                cancelable: false,
                detail: undefined
            };
            evt = document.createEvent('CustomEvent');
            evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
            return evt;
        };

        CustomEvent.prototype = Object.create(window.Event.prototype);
    }

    /**
     * @param {HTMLInputElement} input
     * @param {HTMLElement} sub
     * @param {HTMLElement} add
     */
    function CustomNumber(input, sub, add) {
        const self = this;

        this.input = input;
        this.sub = sub;
        this.add = add;

        this._subHandler = function() {
            self._change(-1);
            self._changeByTimer(-1);
        };
        this._addHandler = function() {
            self._change(1);
            self._changeByTimer(1);
        };

        this.sub.addEventListener('mousedown', this._subHandler, false);
        this.add.addEventListener('mousedown', this._addHandler, false);
    }

    CustomNumber.prototype = {
        destroy: function() {
            this.sub.removeEventListener('mousedown', this._subHandler, false);
            this.add.removeEventListener('mousedown', this._addHandler, false);
        },

        /**
         * @param {number} direction - one of [-1, 1]
         * @private
         */
        _change: function(direction) {
            const step = this._step();
            const min = this._min();
            const max = this._max();

            let value = this._value() + step * direction;

            if (max != null) {
                value = Math.min(max, value);
            }
            if (min != null) {
                value = Math.max(min, value);
            }

            const triggerChange = this.input.value !== value.toString();

            this.input.value = value;

            if (triggerChange) {
                this.input.dispatchEvent(new CustomEvent('change', {
                    bubbles: true
                }));
            }
        },

        /**
         * @param {number} direction - one of [-1, 1]
         * @private
         */
        _changeByTimer: function(direction) {
            const self = this;

            let interval;
            const timer = setTimeout(function() {
                interval = setInterval(function() {
                    self._change(direction);
                }, 50);
            }, 300);

            const documentMouseUp = function() {
                clearTimeout(timer);
                clearInterval(interval);

                document.removeEventListener('mouseup', documentMouseUp, false);
            };

            document.addEventListener('mouseup', documentMouseUp, false);
        },

        /**
         * @return {number}
         * @private
         */
        _step: function() {
            let step = 1;

            if (this.input.hasAttribute('step')) {
                step = parseFloat(this.input.getAttribute('step'));
                step = isNaN(step) ? 1 : step;
            }

            return step;
        },

        /**
         * @return {?number}
         * @private
         */
        _min: function() {
            let min = null;
            if (this.input.hasAttribute('min')) {
                min = parseFloat(this.input.getAttribute('min'));
                min = isNaN(min) ? null : min;
            }

            return min;
        },

        /**
         * @return {?number}
         * @private
         */
        _max: function() {
            let max = null;
            if (this.input.hasAttribute('max')) {
                max = parseFloat(this.input.getAttribute('max'));
                max = isNaN(max) ? null : max;
            }

            return max;
        },

        /**
         * @return {number}
         * @private
         */
        _value: function() {
            let value = parseFloat(this.input.value);

            return isNaN(value) ? 0 : value;
        }
    };

    /** @this {HTMLElement} */
    $.fn.customNumber = function(options) {
        options = $.extend({
            destroy: false
        }, options);

        return this.each(function() {
            if (!$(this).is('.input-number')) {
                return;
            }

            /** @type {(undefined|CustomNumber)} */
            let instance = $(this).data('customNumber');

            if (instance && options.destroy) { // destroy
                instance.destroy();
                $(this).removeData('customNumber');

            } else if (!instance && !options.destroy) { // init
                instance = new CustomNumber(
                    this.querySelector('.input-number__input'),
                    this.querySelector('.input-number__sub'),
                    this.querySelector('.input-number__add')
                );
                $(this).data('customNumber', instance);
            }
        });
    };
})(jQuery);
! function(a, b) {
    "function" == typeof define && define.amd ? define([], function() {
        return a.svg4everybody = b()
    }) : "object" == typeof module && module.exports ? module.exports = b() : a.svg4everybody = b()
}(this, function() {
    function a(a, b, c) {
        if (c) {
            var d = document.createDocumentFragment(),
                e = !b.hasAttribute("viewBox") && c.getAttribute("viewBox");
            e && b.setAttribute("viewBox", e);
            for (var f = c.cloneNode(!0); f.childNodes.length;) d.appendChild(f.firstChild);
            a.appendChild(d)
        }
    }

    function b(b) {
        b.onreadystatechange = function() {
            if (4 === b.readyState) {
                var c = b._cachedDocument;
                c || (c = b._cachedDocument = document.implementation.createHTMLDocument(""), c.body.innerHTML = b.responseText, b._cachedTarget = {}), b._embeds.splice(0).map(function(d) {
                    var e = b._cachedTarget[d.id];
                    e || (e = b._cachedTarget[d.id] = c.getElementById(d.id)), a(d.parent, d.svg, e)
                })
            }
        }, b.onreadystatechange()
    }

    function c(c) {
        function e() {
            for (var c = 0; c < o.length;) {
                var h = o[c],
                    i = h.parentNode,
                    j = d(i),
                    k = h.getAttribute("xlink:href") || h.getAttribute("href");
                if (!k && g.attributeName && (k = h.getAttribute(g.attributeName)), j && k) {
                    if (f)
                        if (!g.validate || g.validate(k, j, h)) {
                            i.removeChild(h);
                            var l = k.split("#"),
                                q = l.shift(),
                                r = l.join("#");
                            if (q.length) {
                                var s = m[q];
                                s || (s = m[q] = new XMLHttpRequest, s.open("GET", q), s.send(), s._embeds = []), s._embeds.push({
                                    parent: i,
                                    svg: j,
                                    id: r
                                }), b(s)
                            } else a(i, j, document.getElementById(r))
                        } else ++c, ++p
                } else ++c
            }(!o.length || o.length - p > 0) && n(e, 67)
        }
        var f, g = Object(c),
            h = /\bTrident\/[567]\b|\bMSIE (?:9|10)\.0\b/,
            i = /\bAppleWebKit\/(\d+)\b/,
            j = /\bEdge\/12\.(\d+)\b/,
            k = /\bEdge\/.(\d+)\b/,
            l = window.top !== window.self;
        f = "polyfill" in g ? g.polyfill : h.test(navigator.userAgent) || (navigator.userAgent.match(j) || [])[1] < 10547 || (navigator.userAgent.match(i) || [])[1] < 537 || k.test(navigator.userAgent) && l;
        var m = {},
            n = window.requestAnimationFrame || setTimeout,
            o = document.getElementsByTagName("use"),
            p = 0;
        f && e()
    }

    function d(a) {
        for (var b = a;
            "svg" !== b.nodeName.toLowerCase() && (b = b.parentNode););
        return b
    }
    return c
});