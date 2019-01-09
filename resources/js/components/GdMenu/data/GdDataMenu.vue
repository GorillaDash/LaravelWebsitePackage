<template>
  <div>
    <slot :results="results" />
    <gd-component-dev-tool :results="results" />
  </div>
</template>

<style scoped></style>

<script>
import devtools from '@/mixins/devtools'

export default {
  name: 'GdDataMenu',
  mixins: [devtools],
  data() {
    return {
      results: []
    }
  },
  methods: {
    async fetch() {
      this.results = await this.$gorilladash.query('websiteMenus', this.params)
    }
  }
}
</script>
