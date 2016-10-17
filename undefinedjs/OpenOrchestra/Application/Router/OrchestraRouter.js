"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Override default constructor Backbone Router to support ES6
 * Call preinitialize method before call basic constructor of Backbone Router
 * Remove this when backbone 1.4 is out
 */
Backbone.Router = function (Router) {
    _.extend(Router.prototype, {
        preinitialize: function preinitialize() {}
    });
    Backbone.Router = function (options) {
        this.preinitialize.apply(this, arguments);
        Router.apply(this, arguments);
    };

    _.extend(Backbone.Router, Router);

    Backbone.Router.prototype = function (Prototype) {
        Prototype.prototype = Router.prototype;
        return new Prototype();
    }(function () {});

    Backbone.Router.prototype.constructor = Backbone.Router;
    return Backbone.Router;
}(Backbone.Router);

/**
 * @class OrchestraRouter
 */

var OrchestraRouter = function (_Backbone$Router) {
    _inherits(OrchestraRouter, _Backbone$Router);

    function OrchestraRouter() {
        _classCallCheck(this, OrchestraRouter);

        return _possibleConstructorReturn(this, (OrchestraRouter.__proto__ || Object.getPrototypeOf(OrchestraRouter)).apply(this, arguments));
    }

    return OrchestraRouter;
}(Backbone.Router);

exports.default = OrchestraRouter;
