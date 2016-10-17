"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Override default constructor Backbone Model to support ES6
 * Call preinitialize method before call basic constructor of Backbone Model
 * Remove this when backbone 1.4 is out
 */
Backbone.Model = function (Model) {
    _.extend(Model.prototype, {
        preinitialize: function preinitialize() {}
    });
    Backbone.Model = function (attributes, options) {
        this.preinitialize.apply(this, arguments);
        Model.apply(this, arguments);
    };

    _.extend(Backbone.Model, Model);

    Backbone.Model.prototype = function (Prototype) {
        Prototype.prototype = Model.prototype;
        return new Prototype();
    }(function () {});

    Backbone.Model.prototype.constructor = Backbone.Model;
    return Backbone.Model;
}(Backbone.Model);

/**
 * @class OrchestraModel
 */

var OrchestraModel = function (_Backbone$Model) {
    _inherits(OrchestraModel, _Backbone$Model);

    function OrchestraModel() {
        _classCallCheck(this, OrchestraModel);

        return _possibleConstructorReturn(this, (OrchestraModel.__proto__ || Object.getPrototypeOf(OrchestraModel)).apply(this, arguments));
    }

    return OrchestraModel;
}(Backbone.Model);

exports.default = OrchestraModel;
