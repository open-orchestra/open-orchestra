"use strict";

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var mix = function mix(superclass) {
    return new MixinBuilder(superclass);
};

var MixinBuilder = function () {
    function MixinBuilder(superclass) {
        _classCallCheck(this, MixinBuilder);

        this.superclass = superclass;
    }

    _createClass(MixinBuilder, [{
        key: "with",
        value: function _with() {
            for (var _len = arguments.length, mixins = Array(_len), _key = 0; _key < _len; _key++) {
                mixins[_key] = arguments[_key];
            }

            return mixins.reduce(function (c, mixin) {
                return mixin(c);
            }, this.superclass);
        }
    }]);

    return MixinBuilder;
}();
