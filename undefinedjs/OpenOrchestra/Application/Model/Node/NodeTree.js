'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _OrchestraModel2 = require('../OrchestraModel');

var _OrchestraModel3 = _interopRequireDefault(_OrchestraModel2);

var _Node = require('./Node');

var _Node2 = _interopRequireDefault(_Node);

var _Application = require('../../Application');

var _Application2 = _interopRequireDefault(_Application);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * @class NodeTree
 */
var NodeTree = function (_OrchestraModel) {
    _inherits(NodeTree, _OrchestraModel);

    function NodeTree() {
        _classCallCheck(this, NodeTree);

        return _possibleConstructorReturn(this, (NodeTree.__proto__ || Object.getPrototypeOf(NodeTree)).apply(this, arguments));
    }

    _createClass(NodeTree, [{
        key: 'parse',

        /**
         * Parse server response to create nested object
         * @param response
         *
         * @returns {Object}
         */
        value: function parse(response) {
            if (response.hasOwnProperty('node')) {
                response.node = new _Node2.default(response.node);
            }
            if (response.hasOwnProperty('children')) {
                var children = [];
                var _iteratorNormalCompletion = true;
                var _didIteratorError = false;
                var _iteratorError = undefined;

                try {
                    for (var _iterator = response.children[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
                        var nodeTree = _step.value;

                        children.push(new NodeTree(this.parse(nodeTree)));
                    }
                } catch (err) {
                    _didIteratorError = true;
                    _iteratorError = err;
                } finally {
                    try {
                        if (!_iteratorNormalCompletion && _iterator.return) {
                            _iterator.return();
                        }
                    } finally {
                        if (_didIteratorError) {
                            throw _iteratorError;
                        }
                    }
                }

                response.children = children;
            }

            return response;
        }

        /**
         * @returns {String}
         */

    }, {
        key: 'url',
        value: function url() {
            var siteId = _Application2.default.getConfiguration().getParameter('siteId');

            return Routing.generate('open_orchestra_api_node_list_tree', { siteId: siteId });
        }
    }]);

    return NodeTree;
}(_OrchestraModel3.default);

exports.default = NodeTree;
