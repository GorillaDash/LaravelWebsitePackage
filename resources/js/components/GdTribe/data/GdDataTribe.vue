<template>
  <div>{{ results }}</div>
</template>

<style scoped></style>
<script>
export default {
  props: {
    tribeSlug: {
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
        slug: this.tribeSlug
      }
    }
  },
  mounted() {
    this.fetch()
  },
  methods: {
    async fetch() {
      this.results = await this.$gorilladash.query('tribes', this.params)
    }
  }
}
</script>
