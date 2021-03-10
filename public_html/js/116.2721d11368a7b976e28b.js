/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(self["webpackChunk"] = self["webpackChunk"] || []).push([["js/116"],{

/***/ "./main/app/Modules/SuperAdmin/Resources/js/Shared/Partials/Footer.svelte":
/*!********************************************************************************!*\
  !*** ./main/app/Modules/SuperAdmin/Resources/js/Shared/Partials/Footer.svelte ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var svelte_internal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! svelte/internal */ "./node_modules/svelte/internal/index.mjs");
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

/* main/app/Modules/SuperAdmin/Resources/js/Shared/Partials/Footer.svelte generated by Svelte v3.35.0 */

var file = "main/app/Modules/SuperAdmin/Resources/js/Shared/Partials/Footer.svelte";

function create_fragment(ctx) {
  var footer;
  var div;
  var p;
  var block = {
    c: function create() {
      footer = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("footer");
      div = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("div");
      p = (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.element)("p");
      p.textContent = "2020 © The Bigtech Devices.";
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr_dev)(p, "class", "mb-0");
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.add_location)(p, file, 2, 4, 64);
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr_dev)(div, "class", "container-fluid");
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.add_location)(div, file, 1, 2, 30);
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.attr_dev)(footer, "class", "rui-footer");
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.add_location)(footer, file, 0, 0, 0);
    },
    l: function claim(nodes) {
      throw new Error("options.hydrate only works if the component was compiled with the `hydratable: true` option");
    },
    m: function mount(target, anchor) {
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.insert_dev)(target, footer, anchor);
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append_dev)(footer, div);
      (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.append_dev)(div, p);
    },
    p: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
    i: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
    o: svelte_internal__WEBPACK_IMPORTED_MODULE_0__.noop,
    d: function destroy(detaching) {
      if (detaching) (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.detach_dev)(footer);
    }
  };
  (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.dispatch_dev)("SvelteRegisterBlock", {
    block: block,
    id: create_fragment.name,
    type: "component",
    source: "",
    ctx: ctx
  });
  return block;
}

function instance($$self, $$props) {
  var _$$props$$$slots = $$props.$$slots,
      slots = _$$props$$$slots === void 0 ? {} : _$$props$$$slots,
      $$scope = $$props.$$scope;
  (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.validate_slots)("Footer", slots, []);
  var writable_props = [];
  Object.keys($$props).forEach(function (key) {
    if (!~writable_props.indexOf(key) && key.slice(0, 2) !== "$$") console.warn("<Footer> was created with unknown prop '".concat(key, "'"));
  });
  return [];
}

var Footer = /*#__PURE__*/function (_SvelteComponentDev) {
  _inherits(Footer, _SvelteComponentDev);

  var _super = _createSuper(Footer);

  function Footer(options) {
    var _this;

    _classCallCheck(this, Footer);

    _this = _super.call(this, options);
    (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.init)(_assertThisInitialized(_this), options, instance, create_fragment, svelte_internal__WEBPACK_IMPORTED_MODULE_0__.safe_not_equal, {});
    (0,svelte_internal__WEBPACK_IMPORTED_MODULE_0__.dispatch_dev)("SvelteRegisterComponent", {
      component: _assertThisInitialized(_this),
      tagName: "Footer",
      options: options,
      id: create_fragment.name
    });
    return _this;
  }

  return Footer;
}(svelte_internal__WEBPACK_IMPORTED_MODULE_0__.SvelteComponentDev);

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Footer);

/***/ })

}]);