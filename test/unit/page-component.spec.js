var Vue = require('vue')
var Page = require('../../src/js/components/app.js');

describe('page.js', function () {
  it('should display correctly', function () {
    var vm = new Vue({
      template: '<div><test></test></div>',
      components: {
        'test': Page
      }
    }).$mount();
    expect(vm.$el.querySelector('h1').textContent).toBe('Test');
  })
})
