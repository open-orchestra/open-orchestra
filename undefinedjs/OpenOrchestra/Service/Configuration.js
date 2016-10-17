"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * @class Configuration
 */
var Configuration = function () {
  /**
   * Constructor
   * @param {object} parameters
   */
  function Configuration() {
    var parameters = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    _classCallCheck(this, Configuration);

    this._parameters = parameters;
  }

  /**
   * @param {String} name
   *
   * @return {mixed}
   */


  _createClass(Configuration, [{
    key: "getParameter",
    value: function getParameter(name) {
      return this._parameters[name];
    }

    /**
     * @return {object}
     */

  }, {
    key: "getParameters",
    value: function getParameters() {
      return this._parameters;
    }
  }]);

  return Configuration;
}();

exports.default = Configuration;
