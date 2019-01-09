<template>
  <div class="position-relative">
    <div
      v-if="isDev"
      class="dev-panel"
    >
      <b-btn
        v-b-modal="uid"
        variant="primary"
      >
        <font-awesome-icon
          icon="eye"
          size="xs"
        />
      </b-btn>
      <b-modal
        :id="uid"
        size="lg"
        title="GorillaDash Dev Tool"
      >
        <pre>
            <code>
  {{ results }}
            </code>
        </pre>
      </b-modal>
    </div>
  </div>
</template>

<style scoped lang="scss">
  .dev-panel {
    position: absolute;
    top: 0;
    right: 0;
  }
</style>

<script>
  export default {
    name: 'GdComponentDevTool',
    props: {
      results: {
        type: [Object, Array],
        default() {
          return null
        }
      }
    },
    data() {
      return {
        uid: null
      }
    },
    computed: {
      isDev() {
        return this.$gorilladash.devtool
      }
    },
    created() {
      const uniqueId = Math.random()
        .toString(36)
        .substr(2, 9)
      this.uid = `GDComponent__${uniqueId}`
    }
  }
</script>
