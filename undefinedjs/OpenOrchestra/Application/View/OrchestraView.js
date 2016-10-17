'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _TemplateManager = require('../../Service/TemplateManager');

var _TemplateManager2 = _interopRequireDefault(_TemplateManager);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * Override default constructor Backbone View to support ES6
 * Call preinitialize method before call basic constructor of backbone view
 * Remove this when backbone 1.4 is out
 */
Backbone.View = function (View) {
    _.extend(View.prototype, {
        preinitialize: function preinitialize() {}
    });
    Backbone.View = function (options) {
        this.preinitialize.apply(this, arguments);
        View.apply(this, arguments);
    };

    _.extend(Backbone.View, View);

    Backbone.View.prototype = function (Prototype) {
        Prototype.prototype = View.prototype;
        return new Prototype();
    }(function () {});

    Backbone.View.prototype.constructor = Backbone.View;
    return Backbone.View;
}(Backbone.View);

/**
 * @class OrchestraView
 */
var OrchestraView = function (_Backbone$View) {
    _inherits(OrchestraView, _Backbone$View);

    function OrchestraView() {
        _classCallCheck(this, OrchestraView);

        return _possibleConstructorReturn(this, (OrchestraView.__proto__ || Object.getPrototypeOf(OrchestraView)).apply(this, arguments));
    }

    _createClass(OrchestraView, [{
        key: '_renderTemplate',

        /**
         * Get underscore template and it with parameters
         *
         * @param {String}   templateName
         * @param {object}   parameters
         * @param {function} callback
         */
        value: function _renderTemplate(templateName, parameters, callback) {
            _TemplateManager2.default.get(templateName, function (template) {
                callback(template(parameters));
            });
        }
    }]);

    return OrchestraView;
}(Backbone.View);

exports.default = OrchestraView;
