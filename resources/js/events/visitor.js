import axios from 'axios'
import collect from 'collect.js'

export default class Visitor {
  constructor(config, userKey) {
    this.config = config
    this.userKey = userKey
    this.$axios = axios.create({
      baseURL: 'https://events.gorilladash.com',
      headers: {
        Authorization: `Bearer ${this.config.token}`,
      },
      withCredentials: true,
    })
  }

  async collect(eventType, pageName = null, pageType = null, extraData = {}) {
    await this.$axios.post('/events/collect', {
      gorilla_user_key: await this.userKey.get(),
      event_type: eventType,
      page_name: pageName,
      page_type: pageType,
      extra_data: {
        ...extraData,
        ...this.getGDMeta(),
      },
    })
  }

  getGDMeta() {
    return collect([...document.querySelectorAll('meta')])
      .filter(meta => meta.name.indexOf('gd:') === 0)
      .mapWithKeys(meta => [meta.name, meta.content])
      .all();
  }
}
