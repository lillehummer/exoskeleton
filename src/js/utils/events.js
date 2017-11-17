
/**
 * App-wide event messages
 */

export default {
  page: {
    load: 'page.load'
  }
}

export class PubSub {
  static dispatch (...args) {
    let actionName = Array.prototype.slice.call(args).shift()
    this[`_${actionName}`].forEach(function (fnc) { fnc.call(...args) })
  }
  static receive (action, fnc) {
    let actionName = `_${action}`
    if (!this[actionName]) this[actionName] = []
    this[actionName].push(fnc)
  }
}
