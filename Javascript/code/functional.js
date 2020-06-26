// var constructorFunc = function(spec, my){
//   var that, privateVar;
//   my = my || {};
//   /// Add shared varibles and functions to my
//   that = a new object;

//   // Add privileged methods to that
//   return that;
// }
var mammal = function (spec) {
  var that = {};

  that.get_name = function () {
    return spec.name;
  };

  that.says = function () {
    return spec.saying || '';
  };

  return that;
};

var myMammal = mammal({ name: 'Herb' });

var cat = function (spec) {
  spec.saying = spec.saying || 'meow';
  var that = mammal(spec);
  that.get_name = function () {
    return that.says() + 'OH YEAHHH';
  };
  return that;
};
var myMammal = mammal({ name: 'Herb' });

Object.method('superior', function (name) {
  var that = this,
    method = that[name];
  return function () {
    return method.apply(that, arguments);
  };
});

var coolcat = function (spec) {
  var that = cat(spec),
    super_get_name = that.superior('get_name');
  that.get_name = function (n) {
    return 'like ' + super_get_name() + ' baby';
  };
  return that;
};

var myCoolCat = coolcat({ name: 'Bix' });
var name = myCoolCat.get_name();
