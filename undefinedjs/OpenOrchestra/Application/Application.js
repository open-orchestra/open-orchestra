'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _NodeController = require('./Controller/Node/NodeController');

var _NodeController2 = _interopRequireDefault(_NodeController);

var _TemplateManager = require('../Service/TemplateManager');

var _TemplateManager2 = _interopRequireDefault(_TemplateManager);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * @class Application
 */
var Application = function () {
    /**
     * Constructor
     */
    function Application() {
        _classCallCheck(this, Application);

        this._regions = {};
    }

    /**
     * Run Application
     */


    _createClass(Application, [{
        key: 'run',
        value: function run() {
            this._initRouting();
            this._initTranslator();
            this._initTemplateManager();
            this._initController();
            Backbone.history.start();
        }

        /**
         * @param {string} name
         * @param {Object} $selector - Jquery selector
         */

    }, {
        key: 'addRegion',
        value: function addRegion(name, $selector) {
            this._regions[name] = $selector;
        }

        /**
         * @param {Object} regions
         */

    }, {
        key: 'setRegions',
        value: function setRegions(regions) {
            this._regions = regions;
        }

        /**
         * @param {string} name
         */

    }, {
        key: 'getRegion',
        value: function getRegion(name) {
            return this._regions[name];
        }

        /**
         * set Application configuration
         * @param {Configuration} configuration - Configuration object
         */

    }, {
        key: 'setConfiguration',
        value: function setConfiguration(configuration) {
            this._configuration = configuration;
        }

        /**
         * get Application configuration
         *
         * @returns {Configuration}
         */

    }, {
        key: 'getConfiguration',
        value: function getConfiguration() {
            return this._configuration;
        }

        /**
         * Initialize controller
         * @private
         */

    }, {
        key: '_initController',
        value: function _initController() {
            new _NodeController2.default();
        }

        /**
         * Initialize template manager
         * @private
         */

    }, {
        key: '_initTemplateManager',
        value: function _initTemplateManager() {
            _TemplateManager2.default.initialize(this._configuration.getParameter('template'), this._configuration.getParameter('environment'));
        }

        /**
         * Initialize routing
         * @private
         */

    }, {
        key: '_initRouting',
        value: function _initRouting() {
            var routingConfiguration = this._configuration.getParameter('routing');
            fos.Router.setData({
                'base_url': routingConfiguration.baseUrl,
                'scheme': routingConfiguration.scheme,
                'host': routingConfiguration.host,
                'routes': Routing.getRoutes()
            });
        }

        /**
         * Initialize translator
         * @private
         */

    }, {
        key: '_initTranslator',
        value: function _initTranslator() {
            Translator.locale = this._configuration.getParameter('language');
        }
    }]);

    return Application;
}();

// unique instance of Application


exports.default = new Application();
