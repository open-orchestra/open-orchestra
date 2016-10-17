'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _OrchestraView2 = require('../OrchestraView');

var _OrchestraView3 = _interopRequireDefault(_OrchestraView2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * @class NodeTreeView
 */
var NodeTreeView = function (_OrchestraView) {
    _inherits(NodeTreeView, _OrchestraView);

    function NodeTreeView() {
        _classCallCheck(this, NodeTreeView);

        return _possibleConstructorReturn(this, (NodeTreeView.__proto__ || Object.getPrototypeOf(NodeTreeView)).apply(this, arguments));
    }

    _createClass(NodeTreeView, [{
        key: 'preinitialize',

        /**
         * @inheritdoc
         */
        value: function preinitialize() {
            this.tagName = 'div';
        }

        /**
         * Initialize
         * @param {NodeTree} nodeTree
         */

    }, {
        key: 'initialize',
        value: function initialize(_ref) {
            var nodeTree = _ref.nodeTree;

            this._nodeTree = nodeTree;
        }

        /**
         * Render node tree
         */

    }, {
        key: 'render',
        value: function render() {
            var view = this;
            console.log(this._nodeTree);
            this._renderTemplate('openorchestrabackoffice/underscore/Node/nodeTreeView', { 'nodeTree': this._nodeTree }, function (template) {
                view.$el.append(template);
            });

            return this;
        }
    }]);

    return NodeTreeView;
}(_OrchestraView3.default);

exports.default = NodeTreeView;
