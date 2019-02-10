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
        },
      },
      includeMediaTribe: {
        type: Boolean,
        default() {
          return false;
        },
      },
      includeComponents: {
        type: Boolean,
        default() {
          return false;
        },
      },
      includeRelatedProducts: {
        type: Boolean,
        default() {
          return false;
        },
      },
      componentTypes: {
        type: String,
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
          componentTypes: this.componentTypes,
          includeMediaTribe: this.includeMediaTribe,
          includeComponents: this.includeComponents,
          includeRelatedProducts: this.includeRelatedProducts,
        }
      }
    },
    created() {
      this.fetch()
    },
    methods: {
      async fetch() {
        this.results = await this.$gorilladash.query('products', this.params)
      }
    }
  }
</script>
