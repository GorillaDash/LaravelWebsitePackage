import { library } from '@fortawesome/fontawesome-svg-core'
import { faSearch, faSyncAlt, faEye } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import * as components from './components'
import Gorilladash from './gorilladash'

export { Gorilladash }

// automatic install
if (typeof window !== 'undefined' && typeof window.Vue !== 'undefined') {
  Vue.use(VueGorillaDash)
}

export default function VueGorillaDash(Vue, options = {}) {
  library.add(faSearch, faSyncAlt, faEye)
  Vue.component('font-awesome-icon', FontAwesomeIcon)
  Vue.use(require('bootstrap-vue'))
  const GorillaDash = new Gorilladash({
    devtool: options.devtool || false,
    axios: options.axios
  })
  GorillaDash.setConfig(options)
  Vue.prototype.$gorilladash = GorillaDash
  for (const key in components) {
    const component = components[key]
    Vue.component(key, component)
  }
}
