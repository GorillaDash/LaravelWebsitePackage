import fp from 'fingerprintjs2';

export default class UserKey {
  GD_USER_KEY = 'gorilla_user_key';

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
      window.localStorage.setItem(this.GD_USER_KEY, fp.x64hash128(components.map(component => component.value).join(''), 31))
    });
  }

  get() {
    return window.localStorage.getItem(this.GD_USER_KEY)
  }

  has() {
    return !!window.localStorage.getItem(this.GD_USER_KEY)
  }
}
