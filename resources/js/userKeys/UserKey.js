import fp from 'fingerprintjs2'

export default class UserKey {
  userKey = null

  constructor(emitter) {
    this.emitter = emitter
    if (typeof window !== 'undefined' && typeof window.Vue !== 'undefined') {
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
        return resolve()
      }
      fp.get((components) => {
        this.userKey = fp.x64hash128(components.map(component => component.value).join(''), 31)
        resolve(this.userKey)
        this.emitter.emit('generated')
      })
    })
  }

  async get() {
    if (!this.has()) {
      await this.initial()
    }
      return this.userKey
  }

  has() {
    return !!this.userKey
  }
}
