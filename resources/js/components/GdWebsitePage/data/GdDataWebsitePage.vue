<template>
  <div>
    <slot :results="results" />
    <gd-component-dev-tool :results="results" />
  </div>
</template>
<style scoped lang="scss"></style>
<script>
import devtools from '@/mixins/devtools'

export default {
  name: 'GdDataWebsitePage',
  mixins: [devtools],
  props: {
    slug: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      results: []
    }
  },
  computed: {
    params() {
      return {
        slug: this.slug
      }
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    async fetch() {
      this.results = await this.$gorilladash.query(
        'websitePages',
        this.params
      )
    }
  }
}
</script>
