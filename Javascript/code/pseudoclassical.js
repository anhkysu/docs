Function.method('inherits', function (Parent) {
  this.prototype = new Parent();
  return this;
});

//////////////////////////////////////////////////////////////

var Mammal = function (name) {
  this.name = name;
};
Mammal.prototype.get_name = function () {
  return this.name;
};
Mammal.prototype.says = function () {
  return this.saying || '';
};

var Cat = function (name) {
  this.name = name;
  this.saying = 'meow';
}
  .inherits(Mammal)
  .method('get_name', function () {
    return this.says() + ' OH YEAH';
  });

var myCat = new Cat('Henrietta');
var says = myCat.says();
var name = myCat.get_name();

// var Cat = function (name) {
//   this.name = name;
//   this.saying = 'meow';
// };

// Cat.prototype = new Mammal();
// Cat.prototype.get_name = function () {
//   return this.says();
// };

// var myMammal = new Mammal('Herb the Mammal');
// var name = myMammal.screamName;
document.getElementById('text').innerHTML = name;
