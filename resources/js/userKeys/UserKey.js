import fp from 'fingerprintjs2'

export default class UserKey {
  userKey = null
  callback = null

  constructor(callback) {
    this.callback = callback
    if (typeof window !== 'undefined') {
      if (window.requestIdleCallback) {
        requestIdleCallback(() => this.initial())
      } else {
        setTimeout(() => this.initial(), 350)
      }
    }
  }

  initial() {
    return new Promise((resolve) => {
      if (this.has()) {
        return resolve(this.userKey)
      }

      fp.get((components) => {
        this.userKey = fp.x64hash128(components.map(component => component.value).join(''), 31)
        resolve(this.userKey)
        if (this.callback) {
          this.callback()
        }
      })
    })
  }

  async get() {
    return this.initial()
  }

  has() {
    return !!this.userKey
  }
}
