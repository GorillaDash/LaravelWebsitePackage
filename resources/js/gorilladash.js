import apiTypes from '../js/types/api'

export default class Gorilladash {

  config = {}

  constructor({ config, axios, devtool = false}) {
    this.devtool = devtool
    this.$axios = axios
    this.setConfig(config)
  }

  async loadWebsiteConfig() {
    if (this.configData) {
      return this.configData
    }
    const response = await this.$axios.get('/gorilladash/website/config')
    return this.configData = response.data
  }

  async setConfig(config) {
    Object.assign(this.config, config, await this.loadWebsiteConfig())
  }

  /**
   * Validate the query
   * @param query
   */
  static validateQuery(query) {
    if (!apiTypes.includes(query)) {
      console.error(`The ${query} query is not in library`)
      return false
    }
    return true
  }

  /**
   * Query graphql and returns result
   * @param query
   * @param params
   */
  async query(query, params = {}) {
    if (Gorilladash.validateQuery(query)) {
      try {
        const { data } = await this.$axios.$get(`/gorilladash/query/${query}`, {
          params: params
        })
        return data
      } catch (e) {
        console.log(e)
        if (e && e.response && e.response.message) {
          console.log(e.response.message)
        }
      }
    }
  }
}
