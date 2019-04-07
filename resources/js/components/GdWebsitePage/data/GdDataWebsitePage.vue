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
    },
    includeComponents: {
      type: Boolean,
      default() {
        return false
      },
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
        slug: this.slug,
        includeComponents: this.includeComponents
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
      this.$emit('fetched')
    }
  }
}
</script>
