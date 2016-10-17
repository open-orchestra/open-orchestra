'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _NodeTree = require('../../Model/Node/NodeTree');

var _NodeTree2 = _interopRequireDefault(_NodeTree);

var _NodeTreeView = require('../../View/Node/NodeTreeView');

var _NodeTreeView2 = _interopRequireDefault(_NodeTreeView);

var _Application = require('../../Application');

var _Application2 = _interopRequireDefault(_Application);

var _NodeRouter = require('../../Router/Node/NodeRouter');

var _NodeRouter2 = _interopRequireDefault(_NodeRouter);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * @class NodeController
 */
var NodeController = function () {
    /**
     * Constructor
     */
    function NodeController() {
        _classCallCheck(this, NodeController);

        new _NodeRouter2.default({
            'nodeController': this
        });
    }

    /**
     * Show node tree action
     */


    _createClass(NodeController, [{
        key: 'showNodeTreeAction',
        value: function showNodeTreeAction() {
            var nodeTree = new _NodeTree2.default();
            nodeTree.fetch({
                success: function success(nodeTree) {
                    var treeView = new _NodeTreeView2.default({ nodeTree: nodeTree });
                    _Application2.default.getRegion('content').html(treeView.render().$el);
                },
                error: function error(model, response, options) {
                    console.log('error');
                }
            });
        }
    }]);

    return NodeController;
}();

exports.default = NodeController;
