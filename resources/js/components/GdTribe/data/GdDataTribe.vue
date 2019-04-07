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
      tribeSlug: {
        type: String,
        default() {
          return null;
        }
      },
      typeName: {
        type: String,
        default() {
          return null;
        }
      },
      orderBy: {
        type: String,
        default() {
          return null;
        },
      },
      includeContents: {
        type: Boolean,
        default() {
          return false;
        },
      },
      includeMedia: {
        type: Boolean,
        default() {
          return false;
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
          slug: this.tribeSlug,
          name: this.typeName,
          orderBy: this.orderBy,
          includeContents: this.includeContents,
          includeMedia: this.includeMedia,
        }
      }
    },
    created() {
      this.fetch()
    },
    methods: {
      async fetch() {
        this.results = await this.$gorilladash.query('tribes', this.params)
        this.$emit('fetched')
      }
    }
  }
</script>
