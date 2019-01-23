import collect from 'collect.js'
import get from 'lodash.get'

export default {
  methods: {
    gdValue(contents, name, value, defaults = null) {
      const content = collect(contents).where('name', name).first()
      if (content) {
        return get(content, value, defaults)
      }

      return defaults
    },
  },
}
