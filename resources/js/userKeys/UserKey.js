import fp from 'fingerprintjs2';

export default class UserKey {
  userKey = null

  constructor() {
    if (window.requestIdleCallback) {
      requestIdleCallback(() => this.initial())
    } else {
      setTimeout(() => this.initial(), 350)
    }
  }

  initial() {
    if (this.has()) {
      return;
    }
    fp.get((components) => {
      this.userKey = fp.x64hash128(components.map(component => component.value).join(''), 31);
    });
  }

  get() {
    return this.userKey
  }

  has() {
    return !!this.userKey
  }
}
