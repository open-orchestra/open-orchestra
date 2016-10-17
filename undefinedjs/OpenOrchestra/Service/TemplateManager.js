'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * @class TemplateManager
 */
var TemplateManager = function () {
    /**
     * constructor
     */
    function TemplateManager() {
        _classCallCheck(this, TemplateManager);

        this._templates = {};
        this._promises = {};
    }

    /**
     * @param {string} baseUrlTemplate
     * @param {string} templateVersion
     * @param {string} environment
     */


    _createClass(TemplateManager, [{
        key: 'initialize',
        value: function initialize(_ref, environment) {
            var baseUrlTemplate = _ref.baseUrlTemplate;
            var templateVersion = _ref.templateVersion;

            this._baseUrlTemplate = baseUrlTemplate;
            this._templateVersion = templateVersion;
            this._localStorageKey = 'template-underscore-' + environment;

            this._loadTemplatesLocalStorage();
        }

        /**
         * Clear template in cache
         */

    }, {
        key: 'clearCache',
        value: function clearCache() {
            this._templates = {};
            if (typeof localStorage != 'undefined') {
                localStorage.removeItem(this._localStorageKey);
            }
        }

        /**
         * get template
         *
         * @param {string} name
         * @param {function} callback
         */

    }, {
        key: 'get',
        value: function get(name, callback) {
            var templateManager = this;
            var key = this._getTemplateKeyStorage(name);

            if (this._templates.hasOwnProperty(key)) {
                var compiledTemplate = _.template(this._templates[key]);

                callback(compiledTemplate);
            } else {
                this._loadTemplate(name).then(function (template) {
                    var compiledTemplate = _.template(template);
                    templateManager.templates[key] = template;
                    templateManager._storeTemplateLocalStorage();

                    callback(compiledTemplate);
                }, function (reason) {
                    // implement error
                    console.log("ERROR");
                });
            }
        }

        /**
         * Load template on the server
         *
         * @param {string} name
         * @private
         */

    }, {
        key: '_loadTemplate',
        value: function _loadTemplate(name) {
            var url = this._baseUrlTemplate + name + '._tpl.html';
            var key = this._getTemplateKeyStorage(name);
            var promise = this._promises[key] || new Promise(function (resolve, reject) {
                Backbone.ajax({ method: 'GET', url: url }).done(resolve).fail(reject);
            });
            this._promises[key] = promise;

            return promise;
        }

        /**
         * Load template underscore in local storage
         * @private
         */

    }, {
        key: '_loadTemplatesLocalStorage',
        value: function _loadTemplatesLocalStorage() {
            if (typeof localStorage != 'undefined') {
                if (localStorage.hasOwnProperty(this._localStorageKey)) {
                    this._templates = JSON.parse(localStorage.getItem(this._localStorageKey));
                }
            }
        }

        /**
         * Store template underscore in local storage
         * @private
         */

    }, {
        key: '_storeTemplateLocalStorage',
        value: function _storeTemplateLocalStorage() {
            if (typeof localStorage != 'undefined') {
                localStorage.setItem(this.localStorageKey, JSON.stringify(this._templates));
            }
        }

        /**
         * @param name
         *
         * @returns {string}
         * @private
         */

    }, {
        key: '_getTemplateKeyStorage',
        value: function _getTemplateKeyStorage(name) {
            return name + '?' + this._templateVersion;
        }
    }]);

    return TemplateManager;
}();

exports.default = new TemplateManager();
