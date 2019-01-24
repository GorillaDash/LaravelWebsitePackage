<template>
  <div>
    <slot :results="results" />
    <gd-component-dev-tool :results="results" />
  </div>
</template>

<style scoped>

</style>

<script>
  import devtools from '@/mixins/devtools'

  export default {
    name: 'GdDataWebsiteComponent',
    mixins: [devtools],
    props: {
      name: {
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
          name: this.name
        }
      }
    },
    created() {
      this.fetch()
    },
    methods: {
      async fetch() {
        this.results = await this.$gorilladash.query(
          'websiteComponents',
          this.params
        )
      }
    }
  };
</script>

