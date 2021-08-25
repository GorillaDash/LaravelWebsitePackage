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
        default() {
          return null;
        },
      },
      includeInventory: {
        type: Object,
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
          componentTypes: this.componentTypes,
          includeMediaTribe: this.includeMediaTribe,
          includeComponents: this.includeComponents,
          includeRelatedProducts: this.includeRelatedProducts,
          includeInventory: this.includeInventory,
        }
      }
    },
    created() {
      this.fetch()
    },
    methods: {
      async fetch() {
        try {
          this.results = await this.$gorilladash.query('products', this.params)
        } catch (e) {
          this.results = [];
        } finally {
          this.$emit('fetched');
        }
      }
    }
  }
</script>
