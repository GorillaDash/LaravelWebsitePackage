<template>
  <div>
    <slot :results="results" />
    <gd-component-dev-tool :results="results"></gd-component-dev-tool>
  </div>
</template>

<style scoped></style>

<script>
import devtools from '@/mixins/devtools'

export default {
  mixins: [devtools],
  props: {
    name: {
      type: String,
      required: true
    },
  },
  data() {
    return {
      results: []
    }
  },
  computed: {
    params() {
      return {
        name: this.name,
      }
    },
  },
  mounted() {
    this.fetch()
  },
  methods: {
    async fetch() {
      this.results = await this.$gorilladash.query('websiteMenus', this.params)
    }
  }
}
</script>
