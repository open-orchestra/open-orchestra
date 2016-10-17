'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _OrchestraRouter2 = require('../OrchestraRouter');

var _OrchestraRouter3 = _interopRequireDefault(_OrchestraRouter2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

/**
 * @class NodeRouter
 */
var NodeRouter = function (_OrchestraRouter) {
    _inherits(NodeRouter, _OrchestraRouter);

    function NodeRouter() {
        _classCallCheck(this, NodeRouter);

        return _possibleConstructorReturn(this, (NodeRouter.__proto__ || Object.getPrototypeOf(NodeRouter)).apply(this, arguments));
    }

    _createClass(NodeRouter, [{
        key: 'preinitialize',

        /**
         * @inheritdoc
         */
        value: function preinitialize() {
            this.routes = {
                'node/tree': 'nodeTree'
            };
        }

        /**
         * Initialize router
         * @param {NodeController} nodeController
         */

    }, {
        key: 'initialize',
        value: function initialize(_ref) {
            var nodeController = _ref.nodeController;

            this._nodeController = nodeController;
        }

        /**
         * Show node tree
         */

    }, {
        key: 'nodeTree',
        value: function nodeTree() {
            this._nodeController.showNodeTreeAction();
        }
    }]);

    return NodeRouter;
}(_OrchestraRouter3.default);

exports.default = NodeRouter;
