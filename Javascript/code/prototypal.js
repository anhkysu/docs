// var myMammal = {
//   name: 'Herb the Mammal',
//   get_name: function () {
//     return this.name;
//   },
//   says: function () {
//     return this.saying || '';
//   },
// };
/// Here, we can recognize that we can create new object or instance
/// by using the new Operator with a constructor function or using
/// Object.create(predefinedObject)
// var myCat = Object.create(myMammal);
// myCat.name = 'Henrietta';
// myCat.saying = 'meow';
// myCat.get_name = function () {
//   return this.says() + ' OH YEAH';
// };

var block = function () {
  // Remember the current scope. Make a new scope that
  // includes everything from the current one.
  console.log(scope);
  var oldScope = scope;
  scope = Object.create(scope);
  // Advance past the left curly brace.
  advance('{');
  // Parse using the new scope.
  parse(scope);
  // Advance past the right curly brace and discard the
  // new scope, restoring the old one.
  advance('}');
  scope = oldScope;
};
