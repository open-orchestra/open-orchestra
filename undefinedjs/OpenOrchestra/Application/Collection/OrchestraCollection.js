"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Override default constructor Backbone Collection to support ES6
 * Call preinitialize method before call basic constructor of Backbone Collection
 * Remove this when backbone 1.4 is out
 */
Backbone.Collection = function (Collection) {
    _.extend(Collection.prototype, {
        preinitialize: function preinitialize() {}
    });
    Backbone.Collection = function (models, options) {
        this.preinitialize.apply(this, arguments);
        Collection.apply(this, arguments);
    };

    _.extend(Backbone.Collection, Collection);

    Backbone.Collection.prototype = function (Prototype) {
        Prototype.prototype = Collection.prototype;
        return new Prototype();
    }(function () {});

    Backbone.Collection.prototype.constructor = Backbone.Collection;
    return Backbone.Collection;
}(Backbone.Collection);

/**
 * @class OrchestraCollection
 */

var OrchestraCollection = function (_Backbone$Collection) {
    _inherits(OrchestraCollection, _Backbone$Collection);

    function OrchestraCollection() {
        _classCallCheck(this, OrchestraCollection);

        return _possibleConstructorReturn(this, (OrchestraCollection.__proto__ || Object.getPrototypeOf(OrchestraCollection)).apply(this, arguments));
    }

    return OrchestraCollection;
}(Backbone.Collection);

exports.default = OrchestraCollection;
