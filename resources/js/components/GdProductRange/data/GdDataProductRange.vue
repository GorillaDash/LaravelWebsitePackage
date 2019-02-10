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
      slug: {
        type: String,
        default() {
          return null;
        }
      },
      resultCount: {
        type: Number,
        default() {
          return null;
        },
      },
      includeComponents: {
        type: Boolean,
        default() {
          return false;
        }
      },
      includeRanges: {
        type: Boolean,
        default() {
          return false;
        },
      },
      includeProducts: {
        type: Boolean,
        default() {
          return false;
        },
      },
      includeInventory: {
        type: String,
        default() {
          return null;
        },
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
          slug: this.slug,
          'result-count': this.resultCount,
          includeComponents: this.includeComponents,
          includeProducts: this.includeProducts,
          includeInventory: this.includeInventory,
        }
      }
    },
    created() {
      this.fetch()
    },
    methods: {
      async fetch() {
        this.results = await this.$gorilladash.query('productRanges', this.params)
      }
    }
  }
</script>
