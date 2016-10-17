'use strict';

var _Application = require('./OpenOrchestra/Application/Application');

var _Application2 = _interopRequireDefault(_Application);

var _Configuration = require('./OpenOrchestra/Service/Configuration');

var _Configuration2 = _interopRequireDefault(_Configuration);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

// variable config is define in layout.html.twig
var configuration = new _Configuration2.default(config);
_Application2.default.setConfiguration(configuration);

$(function () {
    _Application2.default.setRegions({
        'content': $('#content')
    });
    _Application2.default.run();
});
